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
Kamu adalah TaniBot, asisten pertanian AI untuk platform TaniSiaga Indonesia.
Kamu sudah mengetahui profil lahan petani ini:
- Nama lahan: {$lahan->nama}
- Komoditas: {$lahan->komoditas}
- Lokasi: {$lahan->lokasi}
- Luas: {$lahan->luas} hektar
- Fase tanam saat ini: {$lahan->fase_tanam}
- Status risiko hari ini: {$lahan->status_risiko}

Jawab dalam bahasa Indonesia yang ramah dan mudah dipahami petani.
Jawaban maksimal 150 kata. Jangan pakai istilah teknis yang sulit.
Jika ada rekomendasi tindakan, buat dalam poin-poin singkat.
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
