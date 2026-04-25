<?php

namespace App\Http\Controllers;

use App\Services\PlantingCalendarService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PlantingCalendarController extends Controller
{
    public function __construct(
        protected PlantingCalendarService $calendarService
    ) {}

    public function index(Request $request)
    {
        $user = auth()->user();
        $lahans = $user->lahans;
        $lahan_id = $request->query('lahan_id');

        if ($lahans->isEmpty()) {
            return redirect()->route('add_land')->with('error', 'Silakan tambahkan lahan terlebih dahulu.');
        }

        $selectedLahan = $lahan_id ? $lahans->firstWhere('id', $lahan_id) : $lahans->first();

        if (!$selectedLahan) {
            $selectedLahan = $lahans->first();
        }

        $kalenderData = null;
        if ($selectedLahan->kalender_tanam) {
            $cached = is_string($selectedLahan->kalender_tanam)
                ? json_decode($selectedLahan->kalender_tanam, true)
                : $selectedLahan->kalender_tanam;

            if ($cached && !empty($cached['waktu_tanam_terbaik']) && !empty($cached['timeline'])) {
                $kalenderData = $cached;
            }
        }

        $kalenderFresh = $kalenderData
            && $selectedLahan->kalender_tanam_generated_at
            && Carbon::parse($selectedLahan->kalender_tanam_generated_at)->addDays(7)->isFuture();

        return view('pages.calender_planning', compact('lahans', 'selectedLahan', 'kalenderData', 'kalenderFresh'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'lahan_id'  => 'required|exists:lahans,id',
            'force'     => 'boolean'
        ]);

        $lahan = auth()->user()->lahans()->findOrFail($request->lahan_id);
        $isForce = $request->input('force', false);

        if (!$isForce && $lahan->kalender_tanam && $lahan->kalender_tanam_generated_at) {
            if (Carbon::parse($lahan->kalender_tanam_generated_at)->addDays(7)->isFuture()) {
                $kalender = is_string($lahan->kalender_tanam) ? json_decode($lahan->kalender_tanam, true) : $lahan->kalender_tanam;
                if ($kalender && !empty($kalender['waktu_tanam_terbaik']) && !empty($kalender['timeline'])) {
                    return response()->json($kalender);
                }
            }
        }

        try {
            $result = $this->calendarService->generate($lahan);

            $lahan->update([
                'kalender_tanam' => is_array($result) ? $result : json_decode($result, true),
                'kalender_tanam_generated_at' => now()
            ]);

            return response()->json($result);
        } catch (\Exception $e) {
            \Log::error('Kalender Tanam Error: ' . $e->getMessage());

            return response()->json([
                'error' => $e->getMessage(),
                'actual_error' => $e->getMessage()
            ], 503);
        }
    }
}
