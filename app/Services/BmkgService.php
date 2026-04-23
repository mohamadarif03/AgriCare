<?php
// app/Services/BmkgService.php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class BmkgService
{
    public function getPrakiraan(string $kodeWilayah): array
    {
        // Cache 3 jam supaya tidak spam API BMKG
        return Cache::remember("bmkg_{$kodeWilayah}", 180 * 60, function () use ($kodeWilayah) {
            $response = Http::timeout(10)
                ->get("https://api.bmkg.go.id/publik/prakiraan-cuaca", [
                    'adm4' => $kodeWilayah
                ]);

            if ($response->failed()) {
                return [];
            }

            return $response->json('data') ?? [];
        });
    }
}
