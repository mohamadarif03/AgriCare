<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\KalkulatorPemupukanController;

use App\Http\Controllers\MarketPriceController;

// ─── Halaman Statis ─────────────────────────────────────────────────────────
// Halaman Informasi
Route::get('/about', function () {
    return view('pages.about');
})->name('about');
Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');
Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

Route::get('/', fn() => view('index'))->name('index');
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login.post')->middleware('guest');
Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register.post')->middleware('guest');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Fitur Utama & Lahan (Hanya untuk user yang login) ──────────────────────
Route::middleware('auth')->group(function () {
    // Dashboard & Fitur
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/kalkulator-pemupukan', [KalkulatorPemupukanController::class, 'index'])->name('kalkulator_pemupukan');
    Route::post('/api/kalkulator-pemupukan/generate', [KalkulatorPemupukanController::class, 'generate'])->name('kalkulator_pemupukan.generate');
    Route::get('/calender-planning', [App\Http\Controllers\PlantingCalendarController::class, 'index'])->name('calender_planning');
    Route::post('/api/calender-planning/generate', [App\Http\Controllers\PlantingCalendarController::class, 'generate'])->name('calender_planning.generate');
    Route::get('/pest-detection', function () {
        return view('pages.pest_detection_alert', [
            'lahans' => auth()->user()->lahans
        ]);
    })->name('pest_detection_alert');
    Route::get('/market-price', [MarketPriceController::class, 'index'])->name('market_price');
    Route::get('/api/market-price', [MarketPriceController::class, 'getData'])->name('market_price.data');


    Route::get('/tanibot', [App\Http\Controllers\TaniBotController::class, 'index'])->name('tanibot');
    Route::post('/api/tanibot/chat', [App\Http\Controllers\TaniBotController::class, 'chat'])->name('tanibot.chat');
    Route::post('/api/pest-detection/analyze', [App\Http\Controllers\PestDetectionController::class, 'detect'])->name('pest_detection.analyze');

    // AI Recommendations
    Route::get('/recommendations', [App\Http\Controllers\RecommendationController::class, 'index'])->name('ai_reccomendation');
    Route::get('/api/recommendations', [App\Http\Controllers\RecommendationController::class, 'getData'])->name('api.recommendations.data');
    Route::post('/api/recommendations/refresh', [App\Http\Controllers\RecommendationController::class, 'refreshRecommendation'])->name('api.recommendations.refresh');
    Route::post('/api/recommendations/checklist', [App\Http\Controllers\RecommendationController::class, 'toggleChecklist'])->name('api.recommendations.checklist');



    // CRUD Lahan
    Route::get('/manage-lands', [LahanController::class, 'index'])->name('manage_lands');
    Route::get('/add-land', [LahanController::class, 'create'])->name('add_land');
    Route::post('/lands', [LahanController::class, 'store'])->name('lahan.store');
    Route::get('/lands/{lahan}', [LahanController::class, 'show'])->name('lahan.show');
    Route::get('/lands/{lahan}/edit', [LahanController::class, 'edit'])->name('lahan.edit');
    Route::put('/lands/{lahan}', [LahanController::class, 'update'])->name('lahan.update');
    Route::delete('/lands/{lahan}', [LahanController::class, 'destroy'])->name('lahan.destroy');
    Route::patch('/lands/{lahan}/toggle-aktif', [LahanController::class, 'toggleAktif'])->name('lahan.toggle-aktif');
});

// ─── API Wilayah (untuk AJAX) ───────────────────────────────────────────────
Route::get('/api/wilayah/validate', [App\Http\Controllers\WilayahController::class, 'validateKode'])->name('wilayah.validate');
Route::get('/api/wilayah/provinces', [App\Http\Controllers\WilayahController::class, 'provinces']);
Route::get('/api/wilayah/regencies/{id}', [App\Http\Controllers\WilayahController::class, 'regencies']);
Route::get('/api/wilayah/districts/{id}', [App\Http\Controllers\WilayahController::class, 'districts']);
Route::get('/api/wilayah/villages/{id}', [App\Http\Controllers\WilayahController::class, 'villages']);
Route::get('/api/wilayah/bmkg-desa', [App\Http\Controllers\WilayahController::class, 'bmkgDesa']);
// ─── Route lama untuk backward compat (redirect) ────────────────────────────
Route::get('/land-details', fn() => redirect()->route('manage_lands'))->name('land_details');
