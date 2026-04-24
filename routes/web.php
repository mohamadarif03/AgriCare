<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\TaniBotController;
use App\Http\Controllers\PestDetectionController;
use App\Http\Controllers\PlantingCalendarController;

// ─── Halaman Statis ─────────────────────────────────────────────────────────
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
    Route::get('/calender-planning', fn() => view('pages.calender_planning'))->name('calender_planning');
    Route::get('/pest-detection', fn() => view('pages.pest_detection_alert'))->name('pest_detection_alert');
    Route::get('/market-price', fn() => view('pages.market_price'))->name('market_price');
    Route::get('/riskmap', fn() => view('pages.riskmap'))->name('riskmap');
    Route::get('/tanibot', [App\Http\Controllers\TaniBotController::class, 'index'])->name('tanibot');
    Route::post('/api/tanibot/chat', [App\Http\Controllers\TaniBotController::class, 'chat'])->name('tanibot.chat');
    Route::get('/ai-reccomendation', fn() => view('pages.ai_reccomendation'))->name('ai_reccomendation');

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
