<?php

namespace App\Services;

use App\Models\MarketPrice;
use App\Models\MarketPriceInsight;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MarketPriceService
{
    /**
     * Fetch & simpan data harga dari sumber eksternal atau dummy.
     */
    public function fetchAndStore(): int
    {
        $count = 0;

        // Coba ambil dari API Panel Harga Kementan
        try {
            $count = $this->fetchFromPanelHarga();
            if ($count > 0) {
                Log::info("MarketPriceService: berhasil fetch {$count} record dari Panel Harga Kementan");
                return $count;
            }
        } catch (\Throwable $e) {
            Log::warning("MarketPriceService: Panel Harga gagal — {$e->getMessage()}");
        }

        // Coba dari PIHPS Bank Indonesia
        try {
            $count = $this->fetchFromPihps();
            if ($count > 0) {
                Log::info("MarketPriceService: berhasil fetch {$count} record dari PIHPS BI");
                return $count;
            }
        } catch (\Throwable $e) {
            Log::warning("MarketPriceService: PIHPS BI gagal — {$e->getMessage()}");
        }

        // Fallback: gunakan dummy dataset realistis
        $count = $this->seedDummyData();
        Log::info("MarketPriceService: menggunakan dummy data, {$count} record");
        return $count;
    }

    /**
     * Attempt fetch dari panelharga.pertanian.go.id
     */
    protected function fetchFromPanelHarga(): int
    {
        $response = Http::timeout(10)
            ->get('https://panelharga.pertanian.go.id/api/harga-produsen');

        if ($response->failed()) {
            throw new \Exception("HTTP {$response->status()}");
        }

        $data = $response->json('data', []);
        if (empty($data)) {
            throw new \Exception("Empty response");
        }

        $count = 0;
        foreach ($data as $item) {
            MarketPrice::updateOrCreate(
                [
                    'komoditas' => $this->normalizeKomoditas($item['komoditas'] ?? ''),
                    'tanggal'   => Carbon::parse($item['tanggal'] ?? now()),
                    'wilayah'   => $this->normalizeWilayah($item['wilayah'] ?? ''),
                ],
                [
                    'harga'  => intval($item['harga'] ?? 0),
                    'sumber' => 'panelharga',
                ]
            );
            $count++;
        }
        return $count;
    }

    /**
     * Attempt fetch dari hargapangan.id (PIHPS BI)
     */
    protected function fetchFromPihps(): int
    {
        $response = Http::timeout(10)
            ->get('https://hargapangan.id/api/harga/provinsi');

        if ($response->failed()) {
            throw new \Exception("HTTP {$response->status()}");
        }

        $data = $response->json('data', []);
        if (empty($data)) {
            throw new \Exception("Empty response");
        }

        $count = 0;
        foreach ($data as $item) {
            MarketPrice::updateOrCreate(
                [
                    'komoditas' => $this->normalizeKomoditas($item['commodity'] ?? ''),
                    'tanggal'   => Carbon::parse($item['date'] ?? now()),
                    'wilayah'   => $this->normalizeWilayah($item['province'] ?? ''),
                ],
                [
                    'harga'  => intval($item['price'] ?? 0),
                    'sumber' => 'hargapangan',
                ]
            );
            $count++;
        }
        return $count;
    }

    /**
     * Generate dummy data realistis 3 bulan terakhir untuk semua komoditas & wilayah.
     */
    public function seedDummyData(): int
    {
        $commodities = MarketPrice::availableCommodities();
        $regions     = MarketPrice::availableRegions();

        // Harga base per komoditas (Rp/kg)
        $basePrices = [
            'padi'         => 5200,
            'jagung'       => 4800,
            'cabai_merah'  => 45000,
            'cabai_rawit'  => 55000,
            'bawang_merah' => 35000,
            'bawang_putih' => 32000,
            'kedelai'      => 11000,
            'gula_pasir'   => 15500,
        ];

        // Volatilitas per komoditas (%)
        $volatility = [
            'padi'         => 0.03,
            'jagung'       => 0.04,
            'cabai_merah'  => 0.12,
            'cabai_rawit'  => 0.15,
            'bawang_merah' => 0.08,
            'bawang_putih' => 0.06,
            'kedelai'      => 0.04,
            'gula_pasir'   => 0.03,
        ];

        // Tren musiman (multiplier per bulan, index 0 = Jan)
        $seasonalTrend = [1.00, 1.02, 1.05, 1.03, 0.98, 0.95, 0.93, 0.96, 1.00, 1.04, 1.06, 1.03];

        $count     = 0;
        $startDate = now()->subMonths(3)->startOfDay();
        $endDate   = now()->startOfDay();
        $records   = [];

        foreach (array_keys($commodities) as $commodity) {
            $base = $basePrices[$commodity] ?? 5000;
            $vol  = $volatility[$commodity] ?? 0.05;

            foreach (array_keys($regions) as $region) {
                // Offset harga per wilayah (-5% sampai +5%)
                $regionOffset = (crc32($region) % 11 - 5) / 100;
                $regionBase   = $base * (1 + $regionOffset);

                $currentDate = $startDate->copy();
                $price       = $regionBase;

                while ($currentDate->lte($endDate)) {
                    $monthIndex = $currentDate->month - 1;
                    $seasonal   = $seasonalTrend[$monthIndex];

                    // Random walk dengan mean reversion
                    $change = ($regionBase * $seasonal - $price) * 0.05 // mean reversion
                            + $price * $vol * (mt_rand(-100, 100) / 1000); // random noise

                    $price = max($base * 0.7, $price + $change); // floor 70% dari base
                    $price = round($price);

                    $records[] = [
                        'komoditas'  => $commodity,
                        'tanggal'    => $currentDate->toDateString(),
                        'harga'      => (int) $price,
                        'wilayah'    => $region,
                        'sumber'     => 'dummy',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $count++;
                    $currentDate->addDay();
                }
            }
        }

        // Bulk insert dalam chunk (hindari memory issue)
        foreach (array_chunk($records, 500) as $chunk) {
            MarketPrice::upsert($chunk, ['komoditas', 'tanggal', 'wilayah'], ['harga', 'sumber', 'updated_at']);
        }

        return $count;
    }

    // ─── API Data Methods ────────────────────────────────────────────────────

    /**
     * Ambil data lengkap untuk API endpoint.
     */
    public function getMarketData(string $commodity, string $region): array
    {
        $prices = MarketPrice::forCommodity($commodity)
            ->forRegion($region)
            ->recent(3)
            ->orderBy('tanggal')
            ->get();

        if ($prices->isEmpty()) {
            // Coba seed dulu jika belum ada data
            $this->seedDummyData();
            $prices = MarketPrice::forCommodity($commodity)
                ->forRegion($region)
                ->recent(3)
                ->orderBy('tanggal')
                ->get();
        }

        $latest = $prices->last();
        $previousDay = $prices->where('tanggal', '<', $latest?->tanggal)->last();

        $currentPrice = $latest?->harga ?? 0;
        $previousPrice = $previousDay?->harga ?? $currentPrice;
        $trendPercentage = $previousPrice > 0
            ? round(($currentPrice - $previousPrice) / $previousPrice * 100, 1)
            : 0;

        $monthPrices = $prices->where('tanggal', '>=', now()->startOfMonth());
        $monthlyHigh = $monthPrices->max('harga') ?? $currentPrice;
        $monthlyHighDate = $monthPrices->where('harga', $monthlyHigh)->first()?->tanggal?->toDateString();

        // Chart data
        $chartData = $prices->map(fn($p) => [
            'date'  => $p->tanggal->toDateString(),
            'price' => $p->harga,
        ])->values()->toArray();

        // Rata-rata
        $average = $prices->count() > 0 ? round($prices->avg('harga')) : 0;

        // Perbandingan wilayah
        $regionsComparison = $this->getRegionsComparison($commodity);

        // Komoditas lain
        $otherCommodities = $this->getOtherCommodities($region, $commodity);

        // AI Insight (cached)
        $insight = $this->getInsight($commodity, $region, $prices->toArray());

        return [
            'current_price'      => $currentPrice,
            'trend_percentage'   => $trendPercentage,
            'monthly_high'       => $monthlyHigh,
            'monthly_high_date'  => $monthlyHighDate,
            'average_price'      => $average,
            'prediction'         => $insight['price_prediction'] ?? null,
            'recommendation'     => $insight['recommendation'] ?? null,
            'trend_analysis'     => $insight['trend_analysis'] ?? null,
            'chart_data'         => $chartData,
            'regions_comparison' => $regionsComparison,
            'other_commodities'  => $otherCommodities,
            'commodity'          => $commodity,
            'commodity_label'    => MarketPrice::availableCommodities()[$commodity] ?? $commodity,
            'region'             => $region,
            'region_label'       => MarketPrice::availableRegions()[$region] ?? $region,
            'ai_available'       => isset($insight['trend_analysis']),
        ];
    }

    /**
     * Ambil insight AI (cache 6 jam, fallback jika gagal).
     */
    protected function getInsight(string $commodity, string $region, array $priceData): array
    {
        // Cek cache dulu
        $cached = MarketPriceInsight::getCached($commodity, $region);
        if ($cached) {
            return $cached;
        }

        // Panggil Gemini
        try {
            $gemini = app(GeminiService::class);

            $commodityLabel = MarketPrice::availableCommodities()[$commodity] ?? $commodity;
            $regionLabel    = MarketPrice::availableRegions()[$region] ?? $region;

            // Siapkan ringkasan data untuk prompt
            $pricesSummary = collect($priceData)
                ->sortByDesc('tanggal')
                ->take(90)
                ->map(fn($p) => substr($p['tanggal'], 0, 10) . ": Rp " . number_format($p['harga']))
                ->implode("\n");

            $prices = collect($priceData)->pluck('harga');
            $avgPrice = round($prices->avg());
            $minPrice = $prices->min();
            $maxPrice = $prices->max();
            $latestPrice = $prices->last();

            $prompt = <<<PROMPT
Kamu adalah analis pasar komoditas pertanian Indonesia yang berpengalaman.

Analisis data harga komoditas berikut dan berikan output dalam format JSON VALID (tanpa markdown, tanpa backtick, murni JSON).

KOMODITAS: {$commodityLabel}
WILAYAH: {$regionLabel}
PERIODE: 3 bulan terakhir
HARGA TERKINI: Rp {$latestPrice}/kg
HARGA RATA-RATA: Rp {$avgPrice}/kg
HARGA TERENDAH: Rp {$minPrice}/kg
HARGA TERTINGGI: Rp {$maxPrice}/kg

DATA HARGA (tanggal: harga):
{$pricesSummary}

Berikan analisis dalam format JSON berikut (HANYA JSON, tanpa teks lain):
{
  "trend_analysis": "string - narasi analisis tren harga dalam 2-3 paragraf dalam Bahasa Indonesia. Jelaskan tren, penyebab, dan konteks musiman.",
  "price_prediction": {
    "min": number (prediksi harga minimum 2-4 minggu ke depan dalam Rupiah),
    "max": number (prediksi harga maksimum 2-4 minggu ke depan dalam Rupiah),
    "confidence": "tinggi" atau "sedang" atau "rendah",
    "trend_direction": "naik" atau "turun" atau "stabil"
  },
  "recommendation": {
    "action": "jual_sekarang" atau "tahan" atau "jual_sebagian",
    "reason": "string - alasan rekomendasi dalam Bahasa Indonesia, 1-2 kalimat",
    "potential_profit": number (estimasi potensi profit dalam Rp/kg jika mengikuti rekomendasi)
  }
}
PROMPT;

            $result = $gemini->generateJson($prompt);

            // Validasi struktur
            if (isset($result['trend_analysis'], $result['price_prediction'], $result['recommendation'])) {
                MarketPriceInsight::cacheInsight($commodity, $region, $result);
                return $result;
            }

            Log::warning("MarketPriceService: Gemini response structure invalid", $result);
        } catch (\Throwable $e) {
            Log::warning("MarketPriceService: Gemini gagal — {$e->getMessage()}");
        }

        // Fallback: analisis sederhana tanpa AI
        return $this->generateFallbackInsight($priceData, $commodity, $region);
    }

    /**
     * Fallback insight jika Gemini gagal.
     */
    protected function generateFallbackInsight(array $priceData, string $commodity, string $region): array
    {
        $prices = collect($priceData)->pluck('harga');
        $avg    = round($prices->avg());
        $latest = $prices->last() ?? $avg;

        // Hitung tren sederhana (regresi linear naif)
        $recentPrices = $prices->take(-14)->values();
        $olderPrices  = $prices->take(-28)->take(14)->values();

        $recentAvg = $recentPrices->avg() ?: $avg;
        $olderAvg  = $olderPrices->avg() ?: $avg;
        $trend     = $olderAvg > 0 ? ($recentAvg - $olderAvg) / $olderAvg : 0;

        $direction = $trend > 0.02 ? 'naik' : ($trend < -0.02 ? 'turun' : 'stabil');
        $action    = $trend > 0.05 ? 'tahan' : ($trend < -0.03 ? 'jual_sekarang' : 'jual_sebagian');

        return [
            'trend_analysis' => null, // null = tanda bahwa AI tidak tersedia
            'price_prediction' => [
                'min'             => round($latest * (1 + $trend * 0.5)),
                'max'             => round($latest * (1 + $trend * 1.5 + 0.03)),
                'confidence'      => 'rendah',
                'trend_direction' => $direction,
            ],
            'recommendation' => [
                'action'           => $action,
                'reason'           => 'Analisis berdasarkan kalkulasi statistik sederhana (AI tidak tersedia).',
                'potential_profit' => round(abs($trend) * $latest),
            ],
        ];
    }

    /**
     * Perbandingan harga antar wilayah untuk satu komoditas.
     */
    protected function getRegionsComparison(string $commodity): array
    {
        $regions = MarketPrice::availableRegions();
        $result  = [];

        foreach ($regions as $key => $label) {
            $latest = MarketPrice::forCommodity($commodity)
                ->forRegion($key)
                ->orderByDesc('tanggal')
                ->first();

            if ($latest) {
                // Harga sebelumnya
                $prev = MarketPrice::forCommodity($commodity)
                    ->forRegion($key)
                    ->where('tanggal', '<', $latest->tanggal)
                    ->orderByDesc('tanggal')
                    ->first();

                $trend = $prev ? round(($latest->harga - $prev->harga) / $prev->harga * 100, 1) : 0;

                $result[] = [
                    'region'       => $key,
                    'region_label' => $label,
                    'price'        => $latest->harga,
                    'date'         => $latest->tanggal->toDateString(),
                    'trend'        => $trend,
                ];
            }
        }

        // Sort by price descending
        usort($result, fn($a, $b) => $b['price'] <=> $a['price']);

        return $result;
    }

    /**
     * Harga komoditas lain di wilayah yang sama.
     */
    protected function getOtherCommodities(string $region, string $excludeCommodity): array
    {
        $commodities = MarketPrice::availableCommodities();
        $result      = [];

        foreach ($commodities as $key => $label) {
            if ($key === $excludeCommodity) continue;

            $latest = MarketPrice::forCommodity($key)
                ->forRegion($region)
                ->orderByDesc('tanggal')
                ->first();

            if ($latest) {
                $prev = MarketPrice::forCommodity($key)
                    ->forRegion($region)
                    ->where('tanggal', '<', $latest->tanggal)
                    ->orderByDesc('tanggal')
                    ->first();

                $trend = $prev ? round(($latest->harga - $prev->harga) / $prev->harga * 100, 1) : 0;

                $result[] = [
                    'commodity'       => $key,
                    'commodity_label' => $label,
                    'price'           => $latest->harga,
                    'trend'           => $trend,
                ];
            }
        }

        return $result;
    }

    // ─── Normalize Helpers ───────────────────────────────────────────────────

    protected function normalizeKomoditas(string $raw): string
    {
        $map = [
            'beras'        => 'padi',
            'padi'         => 'padi',
            'jagung'       => 'jagung',
            'cabai merah'  => 'cabai_merah',
            'cabai rawit'  => 'cabai_rawit',
            'bawang merah' => 'bawang_merah',
            'bawang putih' => 'bawang_putih',
            'kedelai'      => 'kedelai',
            'gula pasir'   => 'gula_pasir',
            'gula'         => 'gula_pasir',
        ];

        return $map[strtolower(trim($raw))] ?? strtolower(str_replace(' ', '_', trim($raw)));
    }

    protected function normalizeWilayah(string $raw): string
    {
        $map = [
            'kab. cilacap'       => 'cilacap',
            'cilacap'            => 'cilacap',
            'kota semarang'      => 'semarang',
            'semarang'           => 'semarang',
            'kota surabaya'      => 'surabaya',
            'surabaya'           => 'surabaya',
            'dki jakarta'        => 'jakarta',
            'jakarta'            => 'jakarta',
            'kota bandung'       => 'bandung',
            'bandung'            => 'bandung',
            'di yogyakarta'      => 'yogyakarta',
            'yogyakarta'         => 'yogyakarta',
            'kota surakarta'     => 'solo',
            'solo'               => 'solo',
            'kota malang'        => 'malang',
            'malang'             => 'malang',
        ];

        return $map[strtolower(trim($raw))] ?? strtolower(str_replace(' ', '_', trim($raw)));
    }
}
