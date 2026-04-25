<?php

namespace App\Services;

use App\Models\Lahan;
use Carbon\Carbon;

class PlantingCalendarService
{
    public function __construct(
        protected GeminiService $gemini,
        protected HistoricalWeatherService $historical,
        protected BmkgService $bmkg
    ) {}

    /**
     * Kumpulkan semua data input, proses, kirim ke Gemini, dan kembalikan kalender.
     */
    public function generate(Lahan $lahan): array
    {
        // ─── TAHAP 1: Kumpulkan Data Input ─────────────────────────────────

        // Sumber A: Data Prakiraan Cuaca BMKG (3 hari ke depan)
        $cuacaData = [];
        $bmkgRaw = null;
        try {
            $bmkgRaw = $this->bmkg->getPrakiraan($lahan->kode_wilayah);
            if ($bmkgRaw) {
                $cuacaData = $this->bmkg->getPrakiraan3Hari($lahan->kode_wilayah);
            }
        } catch (\Exception $e) {
            \Log::warning('BMKG fetch failed for lahan ' . $lahan->id . ': ' . $e->getMessage());
        }

        // Sumber B: Data Historis Curah Hujan (5 tahun terakhir)
        // Resolusi koordinat: coba lahan → BMKG lokasi → fallback provinsi
        $lat = $lahan->latitude ? (float) $lahan->latitude : null;
        $lng = $lahan->longitude ? (float) $lahan->longitude : null;

        // Coba ambil lat/lng dari response BMKG jika lahan belum punya
        if ((!$lat || !$lng) && $bmkgRaw) {
            $lokasiBmkg = $bmkgRaw['lokasi'] ?? ($bmkgRaw['data'][0]['lokasi'] ?? null);
            if ($lokasiBmkg) {
                $lat = $lat ?: (float) ($lokasiBmkg['lat'] ?? 0);
                $lng = $lng ?: (float) ($lokasiBmkg['lon'] ?? 0);
                // Simpan ke lahan untuk future use
                if ($lat && $lng) {
                    $lahan->update(['latitude' => $lat, 'longitude' => $lng]);
                }
            }
        }

        // Fallback: estimasi koordinat dari provinsi
        if (!$lat || !$lng) {
            [$lat, $lng] = $this->estimateCoordinates($lahan);
        }

        $historisData = null;
        if ($lat && $lng) {
            try {
                $historisData = $this->historical->getHistoricalRainfall($lat, $lng, 5);
            } catch (\Exception $e) {
                \Log::warning('Historical data fetch failed: ' . $e->getMessage());
            }
        }

        // Sumber C: Profil Lahan User
        $profilLahan = $this->buildProfilLahan($lahan);

        // ─── TAHAP 2: Processing Data ──────────────────────────────────────
        $processedData = $this->processData($historisData, $cuacaData, $profilLahan);

        // ─── TAHAP 3: Kirim ke Gemini ──────────────────────────────────────
        $prompt = $this->buildPrompt($processedData);
        $result = $this->gemini->generateJson($prompt);

        // Validasi: pastikan Gemini response memiliki data penting
        if (!$this->isValidResult($result)) {
            \Log::warning('Gemini returned incomplete calendar, retrying...');
            // Retry sekali lagi
            $result = $this->gemini->generateJson($prompt);
            if (!$this->isValidResult($result)) {
                $rawResult = is_array($result) ? json_encode($result) : 'empty/invalid';
                throw new \Exception("Missing required keys in Gemini JSON response:\n" . $rawResult);
            }
        }

        // Tambahkan metadata
        $result['_meta'] = [
            'generated_at'    => now()->toDateTimeString(),
            'lokasi'          => $processedData['lokasi'],
            'komoditas'       => $processedData['komoditas'],
            'lahan_id'        => $lahan->id,
            'has_historical'  => $historisData !== null,
            'has_bmkg'        => !empty($cuacaData),
        ];

        return $result;
    }

    /**
     * Validasi bahwa hasil Gemini memiliki field penting.
     */
    private function isValidResult(array $result): bool
    {
        return !empty($result['waktu_tanam_terbaik'])
            && isset($result['probabilitas_berhasil'])
            && !empty($result['timeline'])
            && !empty($result['bulan_terbaik']);
    }

    /**
     * Estimasi koordinat berdasarkan provinsi/kota.
     */
    private function estimateCoordinates(Lahan $lahan): array
    {
        // Lookup tabel koordinat pusat provinsi di Indonesia
        $coords = [
            'jawa barat'         => [-6.9, 107.6],
            'jawa tengah'        => [-7.15, 110.4],
            'jawa timur'         => [-7.5, 112.75],
            'dki jakarta'        => [-6.2, 106.85],
            'banten'             => [-6.4, 106.1],
            'di yogyakarta'      => [-7.8, 110.36],
            'sumatera utara'     => [2.5, 98.7],
            'sumatera barat'     => [-0.95, 100.35],
            'sumatera selatan'   => [-3.3, 104.75],
            'riau'               => [1.5, 102.1],
            'lampung'            => [-4.6, 105.25],
            'bali'               => [-8.4, 115.2],
            'nusa tenggara barat' => [-8.65, 117.4],
            'nusa tenggara timur' => [-8.65, 121.0],
            'kalimantan barat'   => [-0.1, 109.3],
            'kalimantan tengah'  => [-1.7, 113.9],
            'kalimantan selatan' => [-3.3, 115.0],
            'kalimantan timur'   => [1.2, 116.85],
            'sulawesi selatan'   => [-3.65, 119.85],
            'sulawesi utara'     => [0.6, 124.85],
            'sulawesi tengah'    => [-1.4, 121.45],
            'sulawesi tenggara'  => [-4.0, 122.5],
            'papua'              => [-4.0, 138.5],
            'maluku'             => [-3.2, 130.15],
            'jambi'              => [-1.6, 103.6],
            'bengkulu'           => [-3.5, 102.25],
            'aceh'               => [4.7, 96.75],
            'kepulauan riau'     => [3.95, 108.15],
            'bangka belitung'    => [-2.75, 106.65],
            'gorontalo'          => [0.6, 122.7],
        ];

        $prov = strtolower($lahan->provinsi ?? '');
        foreach ($coords as $key => $val) {
            if (str_contains($prov, $key) || str_contains($key, $prov)) {
                return $val;
            }
        }

        // Default: Jawa Tengah (pusat Indonesia pertanian)
        return [-7.15, 110.4];
    }

    /**
     * Build profil lahan dari data user.
     */
    private function buildProfilLahan(Lahan $lahan): array
    {
        $musimTanams = $lahan->musimTanams()
            ->orderByDesc('tanggal_tanam')
            ->limit(5)
            ->get();

        $riwayatMusim = $musimTanams->map(function ($mt) {
            return [
                'komoditas'      => $mt->komoditas,
                'tanggal_tanam'  => $mt->tanggal_tanam?->format('Y-m-d'),
                'tanggal_panen'  => $mt->tanggal_panen?->format('Y-m-d'),
                'hasil_panen_kg' => $mt->hasil_panen_kg,
                'status'         => $mt->status,
            ];
        })->toArray();

        return [
            'nama'              => $lahan->nama,
            'komoditas'         => $lahan->komoditas,
            'luas_hektar'       => $lahan->luas,
            'lokasi'            => $lahan->kecamatan . ', ' . $lahan->kota . ', ' . $lahan->provinsi,
            'kelurahan'         => $lahan->kelurahan,
            'latitude'          => $lahan->latitude,
            'longitude'         => $lahan->longitude,
            'fase_tanam_saat_ini' => $lahan->fase_tanam,
            'tanggal_tanam'     => $lahan->tanggal_tanam?->format('Y-m-d'),
            'estimasi_panen'    => $lahan->estimasi_panen?->format('Y-m-d'),
            'durasi_tanam_hari' => $lahan->durasi_tanam_hari,
            'riwayat_musim'     => $riwayatMusim,
        ];
    }

    /**
     * TAHAP 2: Proses data mentah menjadi konteks terstruktur untuk Gemini.
     */
    private function processData(?array $historis, array $cuaca, array $profil): array
    {
        // Ringkasan historis
        $ringkasanHistoris = 'Data historis tidak tersedia.';
        $polaBulanan = [];
        $trendTahunIni = null;
        $musimInfo = null;

        if ($historis) {
            $lines = [];
            foreach ($historis['data_per_bulan'] as $bulan) {
                $kategoriEmoji = match ($bulan['kategori']) {
                    'basah'  => '🌧️ BASAH',
                    'kering' => '☀️ KERING',
                    default  => '⛅ NORMAL',
                };

                $trendStr = '';
                if ($bulan['trend_persen'] !== null) {
                    $direction = $bulan['trend_persen'] > 0 ? 'lebih basah' : 'lebih kering';
                    $trendStr = " | Tahun ini: " . abs($bulan['trend_persen']) . "% {$direction}";
                }

                $lines[] = "- {$bulan['bulan']}: {$bulan['rata_curah_hujan_mm']}mm ({$kategoriEmoji}){$trendStr}";

                $polaBulanan[] = [
                    'bulan' => $bulan['bulan'],
                    'curah_hujan' => $bulan['rata_curah_hujan_mm'],
                    'kategori' => $bulan['kategori'],
                    'suhu_max' => $bulan['suhu_rata_max'],
                    'suhu_min' => $bulan['suhu_rata_min'],
                ];
            }

            $ringkasanHistoris = "Rata-rata curah hujan bulanan ({$historis['tahun_data']} tahun terakhir):\n" . implode("\n", $lines);

            $trendTahunIni = $historis['trend_tahun_ini'];
            $musimInfo = [
                'hujan_mulai'   => $historis['musim_hujan_mulai'],
                'kemarau_mulai' => $historis['musim_kemarau_mulai'],
            ];
        }

        // Ringkasan prakiraan BMKG
        $ringkasanCuaca = 'Data prakiraan BMKG tidak tersedia.';
        if (!empty($cuaca)) {
            $lines = [];
            foreach ($cuaca as $hari) {
                $lines[] = "- {$hari['hari_full']} {$hari['tanggal_fmt']}: {$hari['cuaca']}, "
                    . "Suhu {$hari['suhu_min']}-{$hari['suhu_max']}°C, "
                    . "Hujan {$hari['curah_hujan']}mm, "
                    . "Kelembapan {$hari['kelembapan']}%, "
                    . "Risiko: {$hari['risiko']}";
            }
            $ringkasanCuaca = "Prakiraan cuaca 3 hari ke depan:\n" . implode("\n", $lines);
        }

        // Trend description
        $trendDesc = 'Tidak ada data perbandingan tahun ini.';
        if ($trendTahunIni !== null) {
            $direction = $trendTahunIni > 0 ? 'lebih basah' : 'lebih kering';
            $trendDesc = "Tahun ini secara keseluruhan " . abs($trendTahunIni) . "% {$direction} dari rata-rata.";
            if (abs($trendTahunIni) > 20) {
                $trendDesc .= ' Ini menunjukkan kemungkinan pengaruh El Niño/La Niña.';
            }
        }

        // Riwayat musim tanam user
        $riwayatStr = 'Belum ada riwayat musim tanam.';
        if (!empty($profil['riwayat_musim'])) {
            $lines = [];
            foreach ($profil['riwayat_musim'] as $r) {
                $lines[] = "- {$r['komoditas']} ({$r['tanggal_tanam']} s/d " . ($r['tanggal_panen'] ?? 'masih berlangsung') . ") - Status: {$r['status']}" .
                    ($r['hasil_panen_kg'] ? ", Hasil: {$r['hasil_panen_kg']} kg" : '');
            }
            $riwayatStr = "Riwayat musim tanam terakhir:\n" . implode("\n", $lines);
        }

        return [
            'komoditas'          => $profil['komoditas'],
            'lokasi'             => $profil['lokasi'],
            'luas'               => $profil['luas_hektar'],
            'fase_saat_ini'      => $profil['fase_tanam_saat_ini'],
            'tanggal_tanam'      => $profil['tanggal_tanam'],
            'ringkasan_historis' => $ringkasanHistoris,
            'ringkasan_cuaca'    => $ringkasanCuaca,
            'trend_desc'         => $trendDesc,
            'trend_persen'       => $trendTahunIni,
            'musim_info'         => $musimInfo,
            'riwayat_musim'      => $riwayatStr,
            'pola_bulanan'       => $polaBulanan,
            'tanggal_sekarang'   => Carbon::now()->translatedFormat('l, d F Y'),
        ];
    }

    /**
     * TAHAP 3: Bangun prompt yang detail dan terstruktur untuk Gemini.
     */
    private function buildPrompt(array $data): string
    {
        $bulanSekarang = Carbon::now()->translatedFormat('F Y');

        // Info kebutuhan air per komoditas
        $kebutuhanAir = $this->getKebutuhanAirKomoditas($data['komoditas']);

        return <<<PROMPT
Kamu adalah ahli agronomi Indonesia senior dengan 20 tahun pengalaman. Analisis data berikut dan berikan rekomendasi kalender tanam yang presisi.

═══ TANGGAL SEKARANG ═══
{$data['tanggal_sekarang']}

═══ PROFIL LAHAN ═══
Komoditas: {$data['komoditas']}
Lokasi: {$data['lokasi']}
Luas: {$data['luas']} hektar
Fase tanam saat ini: {$data['fase_saat_ini']}
Tanggal tanam terakhir: {$data['tanggal_tanam']}

═══ KEBUTUHAN AIR KOMODITAS ═══
{$kebutuhanAir}

═══ DATA HISTORIS CURAH HUJAN ═══
{$data['ringkasan_historis']}

═══ KONDISI TAHUN INI ═══
{$data['trend_desc']}

═══ PRAKIRAAN CUACA TERKINI ═══
{$data['ringkasan_cuaca']}

═══ RIWAYAT MUSIM TANAM USER ═══
{$data['riwayat_musim']}

═══ TUGAS ═══
Analisis semua data di atas dan berikan rekomendasi kalender tanam untuk musim tanam BERIKUTNYA.

Jawab HANYA dalam format JSON berikut (tanpa markdown fence, tanpa teks lain, HANYA JSON murni):
{
  "waktu_tanam_terbaik": "Bulan minggu ke-X",
  "tanggal_mulai_estimasi": "YYYY-MM-DD",
  "tanggal_panen_estimasi": "YYYY-MM-DD",
  "probabilitas_berhasil": 82,
  "alasan": "Alasan SINGKAT (maksimal 2 kalimat) mengapa waktu ini optimal terkait cuaca.",
  "warning_utama": "Satu peringatan paling kritis.",
  "timeline": [
    {
      "tanggal_mulai": "YYYY-MM-DD",
      "tanggal_selesai": "YYYY-MM-DD",
      "fase": "Persemaian",
      "aktivitas": "Instruksi singkat (maksimal 1 kalimat panjang). TIDAK PERLU mengulang tanggal di sini.",
      "kondisi_cuaca": "Singkat (misal: Hujan tinggi, lembap)",
      "warning": "Peringatan singkat atau null"
    },
    {
      "tanggal_mulai": "YYYY-MM-DD",
      "tanggal_selesai": "YYYY-MM-DD",
      "fase": "Tanam",
      "aktivitas": "Pindah tanam bibit ke lahan...",
      "kondisi_cuaca": "Cerah berawan",
      "warning": null
    }
  ],
  "bulan_terbaik": [
    {"bulan": "Jan", "skor": 40},
    {"bulan": "Feb", "skor": 45},
    {"bulan": "Mar", "skor": 55},
    {"bulan": "Apr", "skor": 60},
    {"bulan": "Mei", "skor": 50},
    {"bulan": "Jun", "skor": 30},
    {"bulan": "Jul", "skor": 25},
    {"bulan": "Agt", "skor": 35},
    {"bulan": "Sep", "skor": 55},
    {"bulan": "Okt", "skor": 85},
    {"bulan": "Nov", "skor": 70},
    {"bulan": "Des", "skor": 50}
  ],
  "tips_tambahan": [
    "Tip singkat 1",
    "Tip singkat 2"
  ],
  "ringkasan_narasi": "Maksimal 2 kalimat kesimpulan singkat yang mudah dipahami."
}

PENTING:
- SANGAT KRITIS: Tulis respons se-SINGKAT dan se-PADAT mungkin agar tidak terpotong (max tokens).
- timeline HARUS menggunakan tanggal spesifik (tanggal_mulai dan tanggal_selesai). TIDAK PERLU menulis ulang tanggal di dalam teks "aktivitas".
- bulan_terbaik HARUS berisi tepat 12 item untuk Jan-Des, skor 0-100.
- timeline minimal 4 entri dan maksimal 6 entri (jangan terlalu banyak).
- tanggal_mulai_estimasi dan tanggal_panen_estimasi harus dalam format YYYY-MM-DD.
PROMPT;
    }

    /**
     * Informasi kebutuhan air berdasarkan komoditas.
     */
    private function getKebutuhanAirKomoditas(string $komoditas): string
    {
        $info = match (strtolower($komoditas)) {
            'padi' => <<<INFO
Padi (Oryza sativa):
- Durasi tanam: 100-120 hari (varietas unggul), 120-150 hari (varietas lokal)
- Kebutuhan air fase persemaian: 100-150mm/bulan
- Kebutuhan air fase vegetatif: 150-200mm/bulan (optimal)
- Kebutuhan air fase generatif: 100-150mm/bulan (harus berkurang)
- Kebutuhan air fase pematangan: <100mm/bulan (harus kering)
- Suhu optimal: 22-30°C
- Risiko utama: banjir di fase generatif, kekeringan di fase vegetatif, wereng saat kelembapan >85%
INFO,
            'jagung' => <<<INFO
Jagung (Zea mays):
- Durasi tanam: 80-110 hari
- Kebutuhan air fase vegetatif: 100-150mm/bulan
- Kebutuhan air fase pembungaan: 150-200mm/bulan (paling kritis)
- Kebutuhan air fase pengisian biji: 100-150mm/bulan
- Tidak tahan genangan air
- Suhu optimal: 23-30°C
- Risiko utama: kekeringan di fase pembungaan, ulat grayak saat musim kemarau
INFO,
            'cabai' => <<<INFO
Cabai (Capsicum annuum):
- Durasi tanam: 90-150 hari
- Kebutuhan air sedang: 100-150mm/bulan sepanjang siklus
- Sangat sensitif terhadap genangan air
- Suhu optimal: 21-28°C
- Risiko utama: busuk buah di musim hujan lebat, layu bakteri jika terlalu basah, kutu kebul di musim kering
INFO,
            'bawang_merah' => <<<INFO
Bawang Merah (Allium cepa):
- Durasi tanam: 60-80 hari
- Kebutuhan air rendah-sedang: 80-120mm/bulan
- Tidak tahan hujan lebat dan genangan
- Suhu optimal: 25-32°C
- Risiko utama: busuk umbi di musim hujan, penyakit embun tepung saat kelembapan tinggi
- Lebih cocok ditanam di musim kemarau dengan irigasi terkontrol
INFO,
            'kedelai' => <<<INFO
Kedelai (Glycine max):
- Durasi tanam: 80-100 hari
- Kebutuhan air fase vegetatif: 100-150mm/bulan
- Kebutuhan air fase pembungaan: 150-180mm/bulan
- Toleran kekeringan ringan
- Suhu optimal: 23-30°C
- Risiko utama: kekeringan di fase pengisian polong, serangan ulat penggerek polong
INFO,
            default => <<<INFO
Komoditas: {$komoditas}
- Kebutuhan air umum: 100-200mm/bulan tergantung fase
- Suhu optimal: 22-30°C
- Perhatikan pola curah hujan lokal untuk menentukan waktu tanam terbaik
INFO,
        };

        return $info;
    }
}
