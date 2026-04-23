<?php
// app/Http/Controllers/TaniBotController.php

namespace App\Http\Controllers;

use App\Services\TaniBotService;
use App\Models\ChatHistory;
use Illuminate\Http\Request;

class TaniBotController extends Controller
{
    public function __construct(protected TaniBotService $taniBot) {}

    public function chat(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string|max:500',
            'lahan_id'   => 'required|exists:lahans,id',
        ]);

        $lahan   = auth()->user()->lahans()->findOrFail($request->lahan_id);
        $riwayat = ChatHistory::where('user_id', auth()->id())
            ->where('lahan_id', $lahan->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($c) => [
                'pertanyaan' => $c->pertanyaan,
                'jawaban'    => $c->jawaban,
            ])
            ->toArray();

        $jawaban = $this->taniBot->chat($request->pertanyaan, $lahan, $riwayat);

        // Simpan ke database
        ChatHistory::create([
            'user_id'    => auth()->id(),
            'lahan_id'   => $lahan->id,
            'pertanyaan' => $request->pertanyaan,
            'jawaban'    => $jawaban,
        ]);

        return response()->json(['jawaban' => $jawaban]);
    }
}
