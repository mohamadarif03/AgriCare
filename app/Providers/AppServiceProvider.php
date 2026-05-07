<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GeminiService;
use Illuminate\Support\Facades\URL; 

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(GeminiService::class, function () {
            return new GeminiService();
        });
    }

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}