<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class BmkgService
{
    private const BASE_URL = 'https://api.bmkg.go.id/publik/prakiraan-cuaca';

    /**
     * Ambil prakiraan cuaca dari BMKG berdasarkan kode wilayah adm4.
     * Data di-cache 30 menit (BMKG update 2x sehari).
     */
    public function getPrakiraan(string $kodeWilayah): ?array
    {
        $cacheKey = "bmkg_cuaca_{$kodeWilayah}";

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($kodeWilayah) {
            try {
                $dotCount = substr_count($kodeWilayah, '.');

                // adm4: normal path
                if ($dotCount >= 3) {
                    $response = Http::timeout(15)->get(self::BASE_URL, ['adm4' => $kodeWilayah]);
                    if ($response->successful() && isset($response->json()['lokasi'])) {
                        return $response->json();
                    }
                    return null;
                }

                // adm3: find first valid adm4 in parallel
                $adm3  = $kodeWilayah;
                $codes = [];
                foreach (['2', '1', '3'] as $prefix) {
                    for ($i = 1; $i <= 20; $i++) {
                        $codes[] = $adm3 . '.' . $prefix . str_pad($i, 3, '0', STR_PAD_LEFT);
                    }
                }

                $responses = Http::pool(function ($pool) use ($codes) {
                    return array_map(
                        fn($k) => $pool->timeout(10)->get(self::BASE_URL, ['adm4' => $k]),
                        $codes
                    );
                });

                foreach ($responses as $idx => $res) {
                    try {
                        if (!($res instanceof \Exception) && $res->successful()) {
                            $body = $res->json();
                            if (isset($body['lokasi'])) {
                                return $body;
                            }
                        }
                    } catch (\Exception $e) {}
                }

                return null;
            } catch (\Exception $e) {
                return null;
            }
        });
    }

    /**
     * Ambil data cuaca hari ini (waktu lokal paling dekat).
     */
    public function getCuacaHariIni(string $kodeWilayah): ?array
    {
        $data = $this->getPrakiraan($kodeWilayah);

        if (!$data || empty($data['data'][0]['cuaca'])) {
            return null;
        }

        $lokasi = $data['lokasi'] ?? $data['data'][0]['lokasi'] ?? [];
        $allCuaca = collect($data['data'][0]['cuaca'])->flatten(1);

        // Cari cuaca paling dekat dengan waktu sekarang (lokal)
        $now = Carbon::now('Asia/Jakarta');

        $closest = $allCuaca->sortBy(function ($c) use ($now) {
            return abs(Carbon::parse($c['local_datetime'])->diffInMinutes($now));
        })->first();

        if (!$closest) {
            return null;
        }

        return [
            'lokasi'          => $lokasi,
            'suhu'            => $closest['t'],
            'cuaca'           => $closest['weather_desc'],
            'cuaca_en'        => $closest['weather_desc_en'],
            'cuaca_code'      => $closest['weather'],
            'kelembapan'      => $closest['hu'],
            'kecepatan_angin' => round($closest['ws'] * 3.6), // m/s -> km/h
            'arah_angin'      => $closest['wd'],
            'curah_hujan'     => $closest['tp'],
            'icon'            => $closest['image'] ?? null,
            'waktu_lokal'     => $closest['local_datetime'],
        ];
    }

    /**
     * Ambil prakiraan 3 hari ke depan, dikelompokkan per hari.
     */
    public function getPrakiraan3Hari(string $kodeWilayah): array
    {
        $data = $this->getPrakiraan($kodeWilayah);

        if (!$data || empty($data['data'][0]['cuaca'])) {
            return [];
        }

        $allCuaca = collect($data['data'][0]['cuaca'])->flatten(1);

        // Group by tanggal lokal
        $grouped = $allCuaca->groupBy(function ($c) {
            return Carbon::parse($c['local_datetime'])->toDateString();
        });

        $result = [];
        $hariNama = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

        foreach ($grouped as $tanggal => $items) {
            $date = Carbon::parse($tanggal);
            $suhuMax = $items->max('t');
            $suhuMin = $items->min('t');
            $totalHujan = $items->sum('tp');
            $avgKelembapan = round($items->avg('hu'));
            $avgAngin = round($items->avg('ws') * 3.6);

            // Cuaca dominan
            $dominantWeather = $items->groupBy('weather_desc')
                ->sortByDesc(fn ($group) => $group->count())
                ->keys()
                ->first();

            $dominantCode = $items->firstWhere('weather_desc', $dominantWeather)['weather'] ?? 1;

            // Tentukan risiko
            $risiko = 'aman';
            if ($totalHujan > 20 || $dominantCode >= 95) {
                $risiko = 'bahaya';
            } elseif ($totalHujan > 5 || $dominantCode >= 60) {
                $risiko = 'waspada';
            }

            $result[] = [
                'tanggal'     => $tanggal,
                'hari'        => $hariNama[$date->dayOfWeek],
                'hari_full'   => $date->translatedFormat('l'),
                'tanggal_fmt' => $date->translatedFormat('d M'),
                'suhu_max'    => $suhuMax,
                'suhu_min'    => $suhuMin,
                'suhu_avg'    => round(($suhuMax + $suhuMin) / 2),
                'cuaca'       => $dominantWeather,
                'cuaca_code'  => $dominantCode,
                'curah_hujan' => round($totalHujan, 1),
                'kelembapan'  => $avgKelembapan,
                'angin'       => $avgAngin,
                'risiko'      => $risiko,
            ];
        }

        return $result;
    }

    /**
     * Map kode cuaca BMKG ke Material icon name.
     */
    public static function weatherIcon(int $code): string
    {
        return match (true) {
            $code <= 1  => 'sunny',
            $code == 2  => 'partly_cloudy_day',
            $code == 3  => 'cloudy',
            $code == 4  => 'cloud',
            $code <= 45 => 'foggy',
            $code <= 63 => 'rainy',
            $code == 80 => 'rainy',
            $code >= 95 => 'thunderstorm',
            default     => 'partly_cloudy_day',
        };
    }

    /**
     * Map kode cuaca ke warna icon.
     */
    public static function weatherIconColor(int $code): string
    {
        return match (true) {
            $code <= 1  => 'text-amber-500',
            $code == 2  => 'text-amber-400',
            $code <= 4  => 'text-slate-400',
            $code <= 45 => 'text-slate-300',
            $code <= 80 => 'text-blue-500',
            $code >= 95 => 'text-purple-500',
            default     => 'text-blue-400',
        };
    }

    /**
     * Map risiko ke warna dot indicator.
     */
    public static function riskDotColor(string $risiko): string
    {
        return match ($risiko) {
            'bahaya'  => 'bg-red-500',
            'waspada' => 'bg-amber-500',
            default   => 'bg-green-500',
        };
    }
}
