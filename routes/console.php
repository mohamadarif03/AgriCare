<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Services\MarketPriceService;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ─── Market Price Scheduler: update setiap 6 jam ─────────────────────────────
Artisan::command('market:fetch-prices', function () {
    $service = app(MarketPriceService::class);
    $count   = $service->fetchAndStore();
    $this->info("Berhasil fetch/update {$count} record harga pasar.");
})->purpose('Fetch & update data harga pasar dari sumber eksternal atau dummy');

Schedule::command('market:fetch-prices')->everySixHours();
