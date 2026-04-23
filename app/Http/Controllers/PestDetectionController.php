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
        $fullPath = storage_path('app/' . $path);

        $result = $this->pestService->detect($fullPath, $lahan->komoditas);

        // Hapus file temp setelah dipakai
        unlink($fullPath);

        return response()->json($result);
    }
}
