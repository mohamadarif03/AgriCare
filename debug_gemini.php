<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$gemini = app(App\Services\GeminiService::class);
$lahan = App\Models\Lahan::first();

echo "Lahan: {$lahan->nama} ({$lahan->komoditas})\n";
echo "Kode wilayah: {$lahan->kode_wilayah}\n";
echo "Provinsi: {$lahan->provinsi}\n\n";

// Build the service and call it step by step
$service = app(App\Services\PlantingCalendarService::class);

// Just test the Gemini part with a simpler prompt
$lokasi = ($lahan->kecamatan ?? '') . ', ' . ($lahan->kota ?? '') . ', ' . ($lahan->provinsi ?? '');

$prompt = <<<PROMPT
Kamu adalah ahli agronomi Indonesia. Analisis dan berikan rekomendasi kalender tanam.

Komoditas: {$lahan->komoditas}
Lokasi: {$lokasi}

Jawab HANYA dalam format JSON (tanpa markdown fence, tanpa teks lain):
{
  "waktu_tanam_terbaik": "Oktober minggu ke-2",
  "tanggal_mulai_estimasi": "2026-10-08",
  "tanggal_panen_estimasi": "2027-02-05",
  "probabilitas_berhasil": 82,
  "alasan": "Penjelasan singkat",
  "warning_utama": "Peringatan utama",
  "timeline": [
    {"minggu": 1, "fase": "Persemaian", "aktivitas": "Siapkan benih", "kondisi_cuaca": "Cerah", "warning": null},
    {"minggu": 3, "fase": "Tanam", "aktivitas": "Tanam bibit", "kondisi_cuaca": "Hujan ringan", "warning": null},
    {"minggu": 8, "fase": "Vegetatif", "aktivitas": "Pemupukan", "kondisi_cuaca": "Hujan sedang", "warning": "Waspadai hama"},
    {"minggu": 14, "fase": "Panen", "aktivitas": "Panen", "kondisi_cuaca": "Cerah", "warning": null}
  ],
  "bulan_terbaik": [
    {"bulan": "Jan", "skor": 40},{"bulan": "Feb", "skor": 45},{"bulan": "Mar", "skor": 55},
    {"bulan": "Apr", "skor": 60},{"bulan": "Mei", "skor": 50},{"bulan": "Jun", "skor": 30},
    {"bulan": "Jul", "skor": 25},{"bulan": "Agt", "skor": 35},{"bulan": "Sep", "skor": 55},
    {"bulan": "Okt", "skor": 85},{"bulan": "Nov", "skor": 70},{"bulan": "Des", "skor": 50}
  ],
  "tips_tambahan": ["Tip 1", "Tip 2"],
  "ringkasan_narasi": "Narasi singkat."
}
PROMPT;

echo "Sending to Gemini...\n";
$start = microtime(true);

try {
    $raw = $gemini->generate($prompt);
    $elapsed = round(microtime(true) - $start, 1);
    echo "Response in {$elapsed}s, length: " . strlen($raw) . "\n\n";
    
    // Parse
    $clean = preg_replace('/```json|```/m', '', $raw);
    $clean = trim($clean);
    
    // Try to extract JSON object
    if (preg_match('/\{[\s\S]*\}/s', $clean, $matches)) {
        $jsonStr = $matches[0];
        $parsed = json_decode($jsonStr, true);
        if ($parsed) {
            echo "SUCCESS! Keys: " . implode(', ', array_keys($parsed)) . "\n";
            echo "Waktu tanam: " . ($parsed['waktu_tanam_terbaik'] ?? 'MISSING') . "\n";
            echo "Prob: " . ($parsed['probabilitas_berhasil'] ?? 'MISSING') . "\n";
            echo "Timeline: " . count($parsed['timeline'] ?? []) . " items\n";
            echo "Bulan: " . count($parsed['bulan_terbaik'] ?? []) . " items\n";
        } else {
            echo "JSON PARSE FAILED: " . json_last_error_msg() . "\n";
            echo "First 500 chars of extracted: " . substr($jsonStr, 0, 500) . "\n";
        }
    } else {
        echo "NO JSON OBJECT FOUND in response\n";
        echo "Full response:\n" . $raw . "\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
