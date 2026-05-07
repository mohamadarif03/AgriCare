<?php
// app/Services/TaniBotService.php

namespace App\Services;

use App\Models\Lahan;

class TaniBotService
{
    public function __construct(protected GeminiService $gemini) {}

    public function chat(string $pertanyaan, Lahan $lahan, array $riwayat = []): string
    {
        $konteks = "
Kamu adalah TaniBot, asisten pertanian AI untuk platform PastiPanen Indonesia.
Kamu sudah mengetahui profil lahan petani ini:
- Nama lahan: {$lahan->nama}
- Komoditas: {$lahan->komoditas}
- Lokasi: {$lahan->kota}, {$lahan->kecamatan}
- Luas: " . ($lahan->luas ?? '?') . " hektar
- Fase tanam saat ini: {$lahan->fase_tanam}
- Status risiko hari ini: {$lahan->status_risiko}

Jawab dalam bahasa Indonesia yang ramah dan mudah dipahami petani.
Jawaban maksimal 200 kata. Jangan pakai istilah teknis yang sulit.
Jika ada rekomendasi tindakan, gunakan poin-poin singkat.
Format jawaban boleh menggunakan markdown dasar (bold, list).
";

        // Bangun riwayat percakapan
        $riwayatTeks = '';
        foreach ($riwayat as $chat) {
            $riwayatTeks .= "Petani: {$chat['pertanyaan']}\n";
            $riwayatTeks .= "TaniBot: {$chat['jawaban']}\n\n";
        }

        $prompt = $konteks . "\n\nRiwayat percakapan:\n" . $riwayatTeks . "\nPetani: " . $pertanyaan . "\nTaniBot:";

        return $this->gemini->generate($prompt);
    }
}
