<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('index'); })->name('index');
Route::get('/login', function () { return view('login'); })->name('login');
Route::get('/register', function () { return view('register'); })->name('register');

Route::get('/dashboard', function () { return view('pages.dashboard'); })->name('dashboard');
Route::get('/calender-planning', function () { return view('pages.calender_planning'); })->name('calender_planning');
Route::get('/pest-detection', function () { return view('pages.pest_detection_alert'); })->name('pest_detection_alert');
Route::get('/market-price', function () { return view('pages.market_price'); })->name('market_price');
Route::get('/riskmap', function () { return view('pages.riskmap'); })->name('riskmap');
Route::get('/tanibot', function () { return view('pages.tanibot'); })->name('tanibot');
Route::get('/ai-reccomendation', function () { return view('pages.ai_reccomendation'); })->name('ai_reccomendation');
Route::get('/add-land', function () { return view('pages.add_land'); })->name('add_land');
Route::get('/manage-lands', function () { return view('pages.manage_lands'); })->name('manage_lands');
Route::get('/land-details', function () { return view('pages.land_details'); })->name('land_details');
