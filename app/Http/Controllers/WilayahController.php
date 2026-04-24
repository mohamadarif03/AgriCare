<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WilayahController extends Controller
{
    /**
     * Search wilayah (desa/kelurahan) dari BMKG API.
     * Endpoint: GET /api/wilayah/search?q=tambakreja
     */
    public function search(Request $request)
    {
        $query = $request->query('q', '');

        if (strlen($query) < 3) {
            return response()->json([]);
        }

        // Cache daftar wilayah dari BMKG (data statis, cache 24 jam)
        $wilayahList = Cache::remember('bmkg_wilayah_list', now()->addHours(24), function () {
            try {
                // BMKG tidak punya endpoint search langsung, jadi kita gunakan
                // pendekatan: fetch beberapa provinsi populer untuk autocomplete.
                // Untuk MVP, kita return empty dan user bisa input manual kode wilayah.
                return [];
            } catch (\Exception $e) {
                return [];
            }
        });

        return response()->json($wilayahList);
    }

    /**
     * Validasi kode wilayah apakah valid di BMKG.
     * Endpoint: GET /api/wilayah/validate?kode=33.01.01.2001
     */
    public function validateKode(Request $request)
    {
        $kode = $request->query('kode', '');

        if (!preg_match('/^\d{2}\.\d{2}\.\d{2}\.\d{4}$/', $kode)) {
            return response()->json([
                'valid' => false,
                'message' => 'Format kode wilayah tidak valid. Gunakan format: XX.XX.XX.XXXX'
            ]);
        }

        $cacheKey = "bmkg_validate_{$kode}";

        $result = Cache::remember($cacheKey, now()->addHours(24), function () use ($kode) {
            try {
                $response = Http::timeout(10)
                    ->get('https://api.bmkg.go.id/publik/prakiraan-cuaca', ['adm4' => $kode]);

                if ($response->successful()) {
                    $data = $response->json();
                    $lokasi = $data['lokasi'] ?? null;

                    if ($lokasi) {
                        return [
                            'valid'     => true,
                            'provinsi'  => $lokasi['provinsi'] ?? '',
                            'kotkab'    => $lokasi['kotkab'] ?? '',
                            'kecamatan' => $lokasi['kecamatan'] ?? '',
                            'desa'      => $lokasi['desa'] ?? '',
                            'lat'       => $lokasi['lat'] ?? null,
                            'lon'       => $lokasi['lon'] ?? null,
                        ];
                    }
                }

                return ['valid' => false, 'message' => 'Kode wilayah tidak ditemukan di BMKG.'];
            } catch (\Exception $e) {
                return ['valid' => false, 'message' => 'Gagal menghubungi server BMKG.'];
            }
        });

        return response()->json($result);
    }

    /**
     * Get Provinces
     */
    public function provinces()
    {
        $data = Cache::remember('wilayah_provinces', now()->addHours(24), function () {
            $res = Http::timeout(15)->get('https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json');
            return $res->successful() ? $res->json() : [];
        });
        return response()->json($data);
    }

    /**
     * Get Regencies by Province
     */
    public function regencies($provinceId)
    {
        $data = Cache::remember("wilayah_regencies_{$provinceId}", now()->addHours(24), function () use ($provinceId) {
            $res = Http::timeout(15)->get("https://emsifa.github.io/api-wilayah-indonesia/api/regencies/{$provinceId}.json");
            return $res->successful() ? $res->json() : [];
        });
        return response()->json($data);
    }

    /**
     * Get Districts by Regency
     */
    public function districts($regencyId)
    {
        $data = Cache::remember("wilayah_districts_{$regencyId}", now()->addHours(24), function () use ($regencyId) {
            $res = Http::timeout(15)->get("https://emsifa.github.io/api-wilayah-indonesia/api/districts/{$regencyId}.json");
            return $res->successful() ? $res->json() : [];
        });
        return response()->json($data);
    }

    /**
     * Get Villages by District (emsifa)
     */
    public function villages($districtId)
    {
        $data = Cache::remember("wilayah_villages_{$districtId}", now()->addHours(24), function () use ($districtId) {
            $res = Http::timeout(15)->get("https://emsifa.github.io/api-wilayah-indonesia/api/villages/{$districtId}.json");
            return $res->successful() ? $res->json() : [];
        });
        return response()->json($data);
    }

    /**
     * Get valid BMKG adm4 codes for a given adm3 (kecamatan).
     * BMKG uses different village codes (not emsifa). We probe common patterns.
     * Endpoint: GET /api/wilayah/bmkg-desa?adm3=35.07.03
     */
    public function bmkgDesa(Request $request)
    {
        $adm3 = trim($request->query('adm3', ''));

        if (!preg_match('/^\d{2}\.\d{2}\.\d{2}$/', $adm3)) {
            return response()->json(['error' => 'Format adm3 tidak valid'], 422);
        }

        $cacheKey = "bmkg_desa_{$adm3}";

        $results = Cache::remember($cacheKey, now()->addHours(24), function () use ($adm3) {
            // Build candidate codes: prefix 2 (desa/rural) and 1 (kelurahan/urban)
            $codes = [];
            foreach (['2', '1', '3'] as $prefix) {
                for ($i = 1; $i <= 20; $i++) {
                    $codes[] = $adm3 . '.' . $prefix . str_pad($i, 3, '0', STR_PAD_LEFT);
                }
            }

            // Fire all requests in parallel
            $responses = Http::pool(function ($pool) use ($codes) {
                return array_map(
                    fn($kode) => $pool->timeout(10)->get(
                        'https://api.bmkg.go.id/publik/prakiraan-cuaca',
                        ['adm4' => $kode]
                    ),
                    $codes
                );
            });

            $found = [];
            foreach ($responses as $idx => $response) {
                try {
                    if ($response->successful()) {
                        $body = $response->json();
                        $lok  = $body['lokasi'] ?? null;
                        if ($lok && isset($lok['desa'])) {
                            $found[] = [
                                'kode'  => $codes[$idx],
                                'label' => $lok['desa'],
                            ];
                        }
                    }
                } catch (\Exception $e) {
                    // skip
                }
            }

            // Sort by kode for consistent ordering
            usort($found, fn($a, $b) => strcmp($a['kode'], $b['kode']));

            return $found;
        });

        return response()->json($results);
    }
}
