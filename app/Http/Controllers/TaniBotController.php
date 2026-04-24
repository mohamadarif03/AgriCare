<?php
// app/Http/Controllers/TaniBotController.php

namespace App\Http\Controllers;

use App\Services\TaniBotService;
use App\Models\ChatHistory;
use Illuminate\Http\Request;

class TaniBotController extends Controller
{
    public function __construct(protected TaniBotService $taniBot) {}

    public function index(Request $request)
    {
        $user = auth()->user();
        $lahans = $user->lahans;
        
        // Ambil semua sesi chat yang diurutkan berdasarkan waktu terakhir diupdate
        $sessions = $user->chatSessions()->with('lahan')->latest('updated_at')->get();

        $session_id = $request->query('session_id');
        $selectedSession = $session_id ? $sessions->firstWhere('id', $session_id) : null;
        
        // Lahan terpilih. Jika ada sesi, ambil lahan dari sesi. Jika tidak, tetap null (user harus pilih lahan baru).
        $selectedLahan = $selectedSession ? $selectedSession->lahan : null;
        
        $riwayat = collect();
        if ($selectedSession) {
            $riwayat = ChatHistory::where('chat_session_id', $selectedSession->id)
                ->oldest() // chronological
                ->get();
        }

        return view('pages.tanibot', compact('lahans', 'sessions', 'selectedSession', 'selectedLahan', 'riwayat'));
    }

    public function chat(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string|max:500',
            'lahan_id'   => 'required_without:session_id|exists:lahans,id',
            'session_id' => 'nullable|exists:chat_sessions,id'
        ]);

        $user = auth()->user();

        // Tentukan sesi dan lahan
        if ($request->session_id) {
            $session = $user->chatSessions()->findOrFail($request->session_id);
            $lahan = $session->lahan;
        } else {
            $lahan = $user->lahans()->findOrFail($request->lahan_id);
            // Buat sesi baru
            $session = \App\Models\ChatSession::create([
                'user_id' => $user->id,
                'lahan_id' => $lahan->id,
                'judul' => \Illuminate\Support\Str::limit($request->pertanyaan, 40)
            ]);
        }

        $riwayat = ChatHistory::where('chat_session_id', $session->id)
            ->latest()
            ->take(5)
            ->get()
            ->reverse() // chronological order for prompt
            ->values()
            ->map(fn($c) => [
                'pertanyaan' => $c->pertanyaan,
                'jawaban'    => $c->jawaban,
            ])
            ->toArray();

        try {
            $jawaban = $this->taniBot->chat($request->pertanyaan, $lahan, $riwayat);

            // Simpan ke database
            ChatHistory::create([
                'user_id'         => $user->id,
                'lahan_id'        => $lahan->id,
                'chat_session_id' => $session->id,
                'pertanyaan'      => $request->pertanyaan,
                'jawaban'         => $jawaban,
            ]);

            // Update timestamp sesi agar naik ke atas di daftar sidebar
            $session->touch();

            return response()->json([
                'jawaban' => $jawaban,
                'session_id' => $session->id,
                'is_new_session' => !$request->session_id
            ]);
        } catch (\Exception $e) {
            \Log::error('TaniBot Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Saat ini server AI sedang sibuk atau mengalami gangguan. Silakan coba beberapa saat lagi.',
                'actual_error' => config('app.debug') ? $e->getMessage() : null
            ], 503);
        }
    }
}
