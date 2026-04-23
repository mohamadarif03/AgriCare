<?php

namespace App\Http\Controllers;

use App\Services\PlantingCalendarService;
use App\Services\BmkgService;
use Illuminate\Http\Request;

class PlantingCalendarController extends Controller
{
    public function __construct(
        protected PlantingCalendarService $calendarService,
        protected BmkgService $bmkg
    ) {}

    public function generate(Request $request)
    {
        $request->validate([
            'komoditas' => 'required|string',
            'lahan_id'  => 'required|exists:lahans,id',
        ]);

        $lahan     = auth()->user()->lahans()->findOrFail($request->lahan_id);
        $cuacaData = $this->bmkg->getPrakiraan($lahan->kode_wilayah);

        $result = $this->calendarService->generate(
            $request->komoditas,
            $lahan->lokasi,
            $cuacaData
        );

        return response()->json($result);
    }
}
