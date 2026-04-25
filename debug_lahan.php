<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$lahans = App\Models\Lahan::all();
foreach ($lahans as $l) {
    echo "ID: {$l->id}\n";
    echo "Lat: " . ($l->latitude ?? 'NULL') . "\n";
    echo "Lng: " . ($l->longitude ?? 'NULL') . "\n";
    echo "Kode: {$l->kode_wilayah}\n";
    echo "Komoditas: {$l->komoditas}\n";
    $k = $l->kalender_tanam;
    if ($k) {
        echo "Kalender keys: " . implode(', ', array_keys($k)) . "\n";
        echo "Waktu tanam: " . ($k['waktu_tanam_terbaik'] ?? 'EMPTY') . "\n";
        echo "Prob: " . ($k['probabilitas_berhasil'] ?? 'EMPTY') . "\n";
        echo "Timeline count: " . count($k['timeline'] ?? []) . "\n";
        echo "Bulan count: " . count($k['bulan_terbaik'] ?? []) . "\n";
    } else {
        echo "Kalender: NULL\n";
    }
    echo "---\n";
}
