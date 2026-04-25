<?php
// app/Http/Controllers/PestDetectionController.php

namespace App\Http\Controllers;

use App\Services\PestDetectionService;
use Illuminate\Http\Request;

class PestDetectionController extends Controller
{
    public function __construct(protected PestDetectionService $pestService) {}

    public function detect(Request $request)
    {
        $request->validate([
            'foto'      => 'required|image|max:5120',
            'lahan_id'  => 'required|exists:lahans,id',
        ]);

        $lahan    = auth()->user()->lahans()->findOrFail($request->lahan_id);
        $path     = $request->file('foto')->store('temp');
        $fullPath = \Illuminate\Support\Facades\Storage::path($path);

        try {
            $result = $this->pestService->detect($fullPath, $lahan->komoditas);
            // Hapus file temp setelah dipakai
            unlink($fullPath);

            return response()->json($result);
        } catch (\Exception $e) {
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
            \Log::error('Pest Detection Error: ' . $e->getMessage());
            return response()->json([
                'terdeteksi' => false,
                'message' => 'Saat ini server AI sedang sibuk atau mengalami gangguan. Silakan coba beberapa saat lagi.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 503);
        }
    }
}
