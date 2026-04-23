<?php
// app/Services/PestDetectionService.php

namespace App\Services;

class PestDetectionService
{
    public function __construct(protected GeminiService $gemini) {}

    public function detect(string $imagePath, string $komoditas): array
    {
        $imageData = base64_encode(file_get_contents($imagePath));
        $mimeType  = mime_content_type($imagePath);

        $prompt = "
Kamu adalah ahli penyakit tanaman Indonesia.
Analisis foto tanaman {$komoditas} ini.

Identifikasi:
1. Nama penyakit atau hama yang terdeteksi
2. Tingkat keparahan (ringan/sedang/parah)
3. Penyebab utama
4. Langkah penanganan segera (maks 3 langkah)
5. Langkah pencegahan ke depan (maks 3 langkah)

Jawab HANYA dalam JSON tanpa teks lain:
{
  \"terdeteksi\": true,
  \"nama_penyakit\": \"...\",
  \"confidence\": 94,
  \"keparahan\": \"sedang\",
  \"penyebab\": \"...\",
  \"penanganan\": [\"langkah 1\", \"langkah 2\"],
  \"pencegahan\": [\"langkah 1\", \"langkah 2\"],
  \"perlu_konsultasi\": false
}";

        return $this->gemini->generateJson($prompt, $imageData, $mimeType);
    }
}
