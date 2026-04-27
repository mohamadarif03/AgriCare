<?php

namespace App\Services;

use App\Models\Lahan;
use App\Models\Recommendation;
use App\Models\RecommendationChecklist;
use Illuminate\Support\Facades\Log;

class RecommendationService
{
    protected BmkgService $bmkgService;
    protected MarketPriceService $marketPriceService;
    protected GeminiService $geminiService;

    public function __construct(
        BmkgService $bmkgService,
        MarketPriceService $marketPriceService,
        GeminiService $geminiService
    ) {
        $this->bmkgService = $bmkgService;
        $this->marketPriceService = $marketPriceService;
        $this->geminiService = $geminiService;
    }

    /**
     * Dapatkan rekomendasi untuk lahan.
     * Cek cache (DB) atau panggil ulang Gemini.
     */
    public function getRecommendation(int $userId, int $lahanId, bool $forceRefresh = false)
    {
        $lahan = Lahan::where('user_id', $userId)->where('id', $lahanId)->firstOrFail();

        // Cari rekomendasi yang masih valid (kurang dari 24 jam)
        if (!$forceRefresh) {
            $latest = Recommendation::where('lahan_id', $lahanId)
                ->where('user_id', $userId)
                ->where('is_archived', false)
                ->where('generated_at', '>=', now()->subHours(24))
                ->first();

            if ($latest) {
                return $latest->load('checklists');
            }
        }

        // Generate baru
        return $this->generateNewRecommendation($lahan);
    }

    /**
     * Generate rekomendasi baru, panggil Gemini, simpan ke DB.
     */
    protected function generateNewRecommendation(Lahan $lahan)
    {
        // 1. Kumpulkan Data
        $cuaca = $this->getCuaca($lahan);
        $harga = $this->getHargaPasar($lahan);
        $hama = $this->getPestPrediction($lahan);

        // 2. Susun prompt untuk Gemini
        $prompt = $this->buildPrompt($lahan, $cuaca, $harga, $hama);

        // 3. Panggil Gemini
        $result = $this->geminiService->generateJson($prompt);

        if (!$result || !isset($result['skor_ketahanan'])) {
            // Fallback
            $result = $this->getFallbackRecommendation();
        }

        // 4. Archive yang lama
        Recommendation::where('lahan_id', $lahan->id)
            ->where('is_archived', false)
            ->update(['is_archived' => true]);

        // 5. Simpan ke DB
        $recommendation = Recommendation::create([
            'user_id' => $lahan->user_id,
            'lahan_id' => $lahan->id,
            'data_json' => $result,
            'generated_at' => now(),
            'is_archived' => false,
        ]);

        // Simpan checklist
        $kategoriMap = [
            'rekomendasi_hari_ini' => 'hari_ini',
            'rekomendasi_minggu_ini' => 'minggu_ini',
            'rekomendasi_bulan_ini' => 'bulan_ini',
        ];

        foreach ($kategoriMap as $key => $kategori) {
            if (isset($result[$key]) && is_array($result[$key])) {
                foreach ($result[$key] as $item) {
                    RecommendationChecklist::create([
                        'recommendation_id' => $recommendation->id,
                        'title' => $item['judul'] ?? 'Tugas',
                        'detail' => $item['detail'] ?? '',
                        'estimasi_waktu' => $item['estimasi_waktu'] ?? '',
                        'dampak_jika_diabaikan' => $item['dampak_jika_diabaikan'] ?? '',
                        'kategori' => $kategori,
                    ]);
                }
            }
        }

        return $recommendation->load('checklists');
    }

    protected function getCuaca(Lahan $lahan)
    {
        if ($lahan->kode_wilayah && $lahan->kode_wilayah !== '00.00.00.0000') {
            $cuacaHariIni = $this->bmkgService->getCuacaHariIni($lahan->kode_wilayah);
            if ($cuacaHariIni) {
                return [
                    'temperature' => $cuacaHariIni['suhu'],
                    'humidity' => $cuacaHariIni['kelembapan'],
                    'rainfall' => $cuacaHariIni['curah_hujan'],
                    'condition' => $cuacaHariIni['cuaca'],
                ];
            }
        }
        return [
            'temperature' => 28,
            'humidity' => 75,
            'rainfall' => 10,
            'condition' => 'Cerah Berawan',
        ];
    }

    protected function getHargaPasar(Lahan $lahan)
    {
        try {
            $data = $this->marketPriceService->getMarketData(
                strtolower($lahan->komoditas), 
                strtolower($lahan->kota ?? 'cilacap')
            );
            return [
                'current_price' => $data['current_price'] ?? 0,
                'trend' => $data['trend_percentage'] ?? 0,
            ];
        } catch (\Exception $e) {
            return ['current_price' => 5000, 'trend' => 0];
        }
    }

    protected function getPestPrediction(Lahan $lahan)
    {
        // Rule-based sederhana
        $komoditas = strtolower($lahan->komoditas);
        if ($komoditas === 'padi') {
            return ['pest_name' => 'Wereng Coklat', 'risk_level' => 60];
        } elseif ($komoditas === 'jagung') {
            return ['pest_name' => 'Ulat Grayak', 'risk_level' => 45];
        }
        return ['pest_name' => 'Kutu Daun', 'risk_level' => 30];
    }

    protected function buildPrompt(Lahan $lahan, array $cuaca, array $harga, array $hama)
    {
        $cuacaStr = json_encode($cuaca);
        $hargaStr = json_encode($harga);
        $hamaStr = json_encode($hama);

        return <<<PROMPT
Kamu adalah asisten pertanian AI "TaniBot". Hasilkan rekomendasi tindakan konkret untuk petani berdasarkan data berikut:
- Komoditas: {$lahan->komoditas}
- Fase Tanam: {$lahan->fase_label}
- Luas Lahan: {$lahan->luas} Ha
- Cuaca Saat Ini: {$cuacaStr}
- Harga Pasar: {$hargaStr}
- Prediksi Hama: {$hamaStr}

Berikan output dalam JSON VALID dengan struktur HARUS PERSIS SEPERTI INI:
{
  "skor_ketahanan": number (0-100),
  "estimasi_kerugian_rp": number (estimasi kerugian dalam Rp jika dibiarkan),
  "estimasi_kerugian_persen": number (0-100),
  "rekomendasi_hari_ini": [
    {
      "judul": "string (singkat, misal: 'Semprot Fungisida')",
      "detail": "string",
      "estimasi_waktu": "string (misal: '30 menit')",
      "dampak_jika_diabaikan": "string"
    }
  ],
  "rekomendasi_minggu_ini": [ ... ],
  "rekomendasi_bulan_ini": [ ... ]
}

Pastikan output HANYA berisi JSON murni tanpa markdown, tanpa teks pengantar, agar bisa di-parse.
PROMPT;
    }

    protected function getFallbackRecommendation()
    {
        return [
            "skor_ketahanan" => 50,
            "estimasi_kerugian_rp" => 1500000,
            "estimasi_kerugian_persen" => 20,
            "rekomendasi_hari_ini" => [
                [
                    "judul" => "Cek Kondisi Lahan",
                    "detail" => "AI gagal memuat data spesifik. Segera cek kondisi lahan secara manual.",
                    "estimasi_waktu" => "1 jam",
                    "dampak_jika_diabaikan" => "Kehilangan informasi vital mengenai serangan hama atau masalah air."
                ]
            ],
            "rekomendasi_minggu_ini" => [],
            "rekomendasi_bulan_ini" => []
        ];
    }
}
