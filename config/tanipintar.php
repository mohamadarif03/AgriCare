<?php

return [

    /*
    |--------------------------------------------------------------------------
    | TaniPintar Application Config
    |--------------------------------------------------------------------------
    |
    | Konfigurasi khusus untuk aplikasi TaniPintar.
    | Semua data dari .env dipanggil di sini, lalu diakses
    | via config('tanipintar.xxx') di seluruh aplikasi.
    |
    */

    'name' => env('APP_NAME', 'TaniPintar'),

    /*
    |--------------------------------------------------------------------------
    | Gemini AI Configuration
    |--------------------------------------------------------------------------
    */

    'gemini' => [
        'api_key' => env('GEMINI_API_KEY'),
        'model'   => env('GEMINI_MODEL', 'gemini-2.5-flash'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Configuration (read-only reference)
    |--------------------------------------------------------------------------
    */

    'database' => [
        'connection' => env('DB_CONNECTION', 'mysql'),
        'host'       => env('DB_HOST', '127.0.0.1'),
        'port'       => env('DB_PORT', '3306'),
        'name'       => env('DB_DATABASE', 'CobyTani'),
        'username'   => env('DB_USERNAME', 'root'),
    ],

];
