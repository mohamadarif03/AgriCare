<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$svc = app(App\Services\PlantingCalendarService::class);
$lahan = App\Models\Lahan::first();
try {
    $res = $svc->generate($lahan);
    print_r($res);
} catch (\Exception $e) {
    echo $e->getMessage();
}
