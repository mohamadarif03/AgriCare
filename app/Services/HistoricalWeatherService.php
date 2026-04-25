<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class HistoricalWeatherService
{
    private const BASE_URL = 'https://archive-api.open-meteo.com/v1/archive';

    /**
     * Ambil data curah hujan historis 5 tahun terakhir.
     * Data di-cache 24 jam karena data historis jarang berubah.
     */
    public function getHistoricalRainfall(float $latitude, float $longitude, int $years = 5): ?array
    {
        $cacheKey = "hist_rainfall_{$latitude}_{$longitude}_{$years}";

        return Cache::remember($cacheKey, now()->addHours(24), function () use ($latitude, $longitude, $years) {
            try {
                $endDate = Carbon::now()->subDays(5)->toDateString(); // API punya delay beberapa hari
                $startDate = Carbon::now()->subYears($years)->startOfYear()->toDateString();

                $response = Http::timeout(30)->get(self::BASE_URL, [
                    'latitude'  => $latitude,
                    'longitude' => $longitude,
                    'start_date' => $startDate,
                    'end_date'   => $endDate,
                    'daily'      => 'precipitation_sum,temperature_2m_max,temperature_2m_min,relative_humidity_2m_mean',
                    'timezone'   => 'Asia/Jakarta',
                ]);

                if ($response->failed()) {
                    \Log::warning('Open-Meteo API error: ' . $response->body());
                    return null;
                }

                $data = $response->json();

                if (!isset($data['daily']['time'])) {
                    return null;
                }

                return $this->processHistoricalData($data['daily'], $years);
            } catch (\Exception $e) {
                \Log::warning('Historical weather fetch failed: ' . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * Proses data mentah menjadi ringkasan per bulan.
     */
    private function processHistoricalData(array $daily, int $years): array
    {
        $dates = $daily['time'];
        $precip = $daily['precipitation_sum'];
        $tempMax = $daily['temperature_2m_max'] ?? [];
        $tempMin = $daily['temperature_2m_min'] ?? [];
        $humidity = $daily['relative_humidity_2m_mean'] ?? [];

        // Group by bulan
        $monthlyData = [];
        $currentYearMonthly = [];
        $currentYear = Carbon::now()->year;

        foreach ($dates as $i => $date) {
            $carbon = Carbon::parse($date);
            $month = $carbon->month;
            $year = $carbon->year;

            $rain = $precip[$i] ?? 0;

            // Data semua tahun (untuk rata-rata)
            if (!isset($monthlyData[$month])) {
                $monthlyData[$month] = [];
            }
            $monthlyData[$month][] = [
                'year'     => $year,
                'rain'     => $rain,
                'temp_max' => $tempMax[$i] ?? null,
                'temp_min' => $tempMin[$i] ?? null,
                'humidity' => $humidity[$i] ?? null,
            ];

            // Data tahun ini (untuk perbandingan)
            if ($year === $currentYear) {
                if (!isset($currentYearMonthly[$month])) {
                    $currentYearMonthly[$month] = [];
                }
                $currentYearMonthly[$month][] = $rain;
            }
        }

        // Hitung rata-rata per bulan dari semua tahun
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
        $summary = [];
        $totalAvg = 0;
        $totalCurrentYear = 0;
        $monthsWithCurrentData = 0;

        for ($m = 1; $m <= 12; $m++) {
            if (!isset($monthlyData[$m])) {
                $summary[] = [
                    'bulan'           => $monthNames[$m - 1],
                    'bulan_num'       => $m,
                    'rata_curah_hujan_mm' => 0,
                    'kategori'        => 'kering',
                    'suhu_rata_max'   => null,
                    'suhu_rata_min'   => null,
                    'kelembapan_rata' => null,
                ];
                continue;
            }

            $items = collect($monthlyData[$m]);

            // Curah hujan: sum per bulan per tahun, lalu rata-rata antar tahun
            $yearlyMonthTotals = $items->groupBy('year')->map(fn($group) => $group->sum('rain'));
            $avgRain = round($yearlyMonthTotals->avg(), 1);
            $totalAvg += $avgRain;

            // Suhu rata-rata
            $avgTempMax = round($items->avg('temp_max'), 1);
            $avgTempMin = round($items->avg('temp_min'), 1);
            $avgHumidity = round($items->avg('humidity'), 1);

            // Kategori bulan
            $kategori = 'normal';
            if ($avgRain < 100) {
                $kategori = 'kering';
            } elseif ($avgRain > 200) {
                $kategori = 'basah';
            }

            // Trend tahun ini vs rata-rata
            $currentYearRain = null;
            $trendPercent = null;
            if (isset($currentYearMonthly[$m]) && $m <= Carbon::now()->month) {
                $currentYearRain = round(array_sum($currentYearMonthly[$m]), 1);
                if ($avgRain > 0) {
                    $trendPercent = round((($currentYearRain - $avgRain) / $avgRain) * 100, 1);
                }
                $totalCurrentYear += $currentYearRain;
                $monthsWithCurrentData++;
            }

            $summary[] = [
                'bulan'               => $monthNames[$m - 1],
                'bulan_num'           => $m,
                'rata_curah_hujan_mm' => $avgRain,
                'kategori'            => $kategori,
                'suhu_rata_max'       => $avgTempMax,
                'suhu_rata_min'       => $avgTempMin,
                'kelembapan_rata'     => $avgHumidity,
                'curah_hujan_tahun_ini' => $currentYearRain,
                'trend_persen'        => $trendPercent,
            ];
        }

        // Hitung trend keseluruhan tahun ini
        $overallTrend = null;
        if ($monthsWithCurrentData > 0 && $totalAvg > 0) {
            // Bandingkan rata-rata per bulan yang sudah berjalan
            $avgCurrentPerMonth = $totalCurrentYear / $monthsWithCurrentData;
            $avgHistoricalPerMonth = $totalAvg / 12;
            $overallTrend = round((($avgCurrentPerMonth - $avgHistoricalPerMonth) / $avgHistoricalPerMonth) * 100, 1);
        }

        // Identifikasi awal musim hujan & kemarau
        $musimHujanMulai = null;
        $musimKemarauMulai = null;
        for ($m = 0; $m < 12; $m++) {
            $current = $summary[$m]['rata_curah_hujan_mm'];
            $prev = $summary[($m + 11) % 12]['rata_curah_hujan_mm'];
            if ($current >= 150 && $prev < 150 && !$musimHujanMulai) {
                $musimHujanMulai = $summary[$m]['bulan'];
            }
            if ($current < 100 && $prev >= 100 && !$musimKemarauMulai) {
                $musimKemarauMulai = $summary[$m]['bulan'];
            }
        }

        return [
            'data_per_bulan'     => $summary,
            'trend_tahun_ini'    => $overallTrend,
            'musim_hujan_mulai'  => $musimHujanMulai ?? 'Okt',
            'musim_kemarau_mulai' => $musimKemarauMulai ?? 'Mei',
            'tahun_data'         => $years,
        ];
    }
}
