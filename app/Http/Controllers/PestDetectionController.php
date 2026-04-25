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
        
        $path     = $request->file('foto')->store('pest_detections', 'public');
        $fullPath = \Illuminate\Support\Facades\Storage::disk('public')->path($path);
        $fotoUrl  = asset('storage/' . $path);

        try {
            $result = $this->pestService->detect($fullPath, $lahan->komoditas);
            
            $result['foto_url'] = $fotoUrl;
            $result['foto_path'] = $path;

            $oldData = is_string($lahan->pest_detection) ? json_decode($lahan->pest_detection, true) : $lahan->pest_detection;
            if ($oldData && !empty($oldData['foto_path'])) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldData['foto_path']);
            }

            // Simpan hasil deteksi ke lahan, menggantikan yang lama
            $lahan->update([
                'pest_detection' => $result,
                'pest_detection_updated_at' => now(),
            ]);

            return response()->json($result);
        } catch (\Exception $e) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
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
