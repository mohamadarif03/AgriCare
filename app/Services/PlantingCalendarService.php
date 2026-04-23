<?php
// app/Services/PlantingCalendarService.php

namespace App\Services;

class PlantingCalendarService
{
    public function __construct(protected GeminiService $gemini) {}

    public function generate(string $komoditas, string $lokasi, array $cuacaData): array
    {
        $prompt = "
Kamu adalah ahli agronomi Indonesia.
Berikut data prakiraan cuaca dan historis curah hujan untuk wilayah {$lokasi}:
" . json_encode($cuacaData) . "

Komoditas: {$komoditas}
Lokasi: {$lokasi}

Analisis data ini dan berikan:
1. Bulan terbaik untuk mulai tanam tahun ini
2. Timeline fase tanam minggu per minggu dari tanam sampai panen
3. Warning cuaca di fase yang paling rentan
4. Probabilitas keberhasilan panen (0-100%)

Jawab HANYA dalam format JSON berikut tanpa teks lain:
{
  \"waktu_tanam_terbaik\": \"Oktober minggu ke-2\",
  \"probabilitas_berhasil\": 82,
  \"alasan\": \"...\",
  \"timeline\": [
    {
      \"minggu\": 1,
      \"fase\": \"Persemaian\",
      \"aktivitas\": \"...\",
      \"warning\": \"...atau null jika tidak ada\"
    }
  ],
  \"bulan_terbaik\": [
    {\"bulan\": \"Oktober\", \"skor\": 85},
    {\"bulan\": \"November\", \"skor\": 60}
  ]
}";

        return $this->gemini->generateJson($prompt);
    }
}
