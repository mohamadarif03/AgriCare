<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lahan;
use App\Services\GeminiService;

class KalkulatorPemupukanController extends Controller
{
    public function index()
    {
        $lahans = Lahan::where('user_id', auth()->id())->where('is_aktif', true)->get();
        return view('pages.kalkulator_pemupukan', compact('lahans'));
    }

    public function getData(Request $request)
    {
        $request->validate([
            'lahan_id' => 'required|exists:lahans,id'
        ]);

        $lahan = Lahan::where('user_id', auth()->id())->where('id', $request->lahan_id)->firstOrFail();

        if ($lahan->kalkulator_pemupukan) {
            return response()->json([
                'success' => true,
                'data' => $lahan->kalkulator_pemupukan
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan'
        ]);
    }

    public function generate(Request $request, GeminiService $gemini)
    {
        $request->validate([
            'lahan_id' => 'required|exists:lahans,id'
        ]);

        $lahan = Lahan::where('user_id', auth()->id())->where('id', $request->lahan_id)->firstOrFail();

        $prompt = "Buatkan jadwal dan kalkulator pemupukan untuk lahan berikut:\n"
                . "Komoditas: " . $lahan->komoditas . "\n"
                . "Luas Lahan: " . $lahan->luas . " Hektar\n"
                . "Fase saat ini: " . $lahan->fase_label . "\n"
                . "Usia Tanaman: " . $lahan->durasi_tanam_hari . " hari\n\n"
                . "Kembalikan respon DALAM FORMAT JSON murni (tanpa markdown block ```json) dengan struktur yang sama persis seperti ini:\n"
                . '{"jadwal":[{"fase":"Dasar","hari":"H+0","status":"selesai","is_active":false,"pupuk":"37,5 kg Urea, 50 kg SP-36, 25 kg KCl"},{"fase":"Susulan 1","hari":"H+20","status":"sekarang","is_active":true,"pupuk":"50 kg Urea, 25 kg KCl"},{"fase":"Susulan 2","hari":"H+35","status":"akan datang","is_active":false,"pupuk":"37,5 kg Urea, 25 kg KCl"}],"sekarang_perlu_dilakukan":{"hari_ke":"Hari ke-'.$lahan->durasi_tanam_hari.'","fase":"Susulan 1","pupuk_list":[{"nama":"Urea","jumlah_kg":50,"setara":"(setara 100kg/ha)"}],"info":"Penjelasan singkat fase ini dan cara pemupukan."},"rekap":[{"fase":"1. Pemupukan Dasar","hari":"H+0 - H+7","status":"SELESAI","pupuk_detail":"37,5 kg Urea..."}]}'
                . "\n\nPastikan status pada jadwal diisi dengan salah satu dari: 'selesai', 'sekarang', 'akan datang'. Hitung dosis pupuk berdasarkan luas " . $lahan->luas . " Hektar dan komoditas " . $lahan->komoditas . ". Buat realistis.";

        try {
            $result = $gemini->generateJson($prompt);
            
            // Simpan ke database
            $lahan->kalkulator_pemupukan = $result;
            $lahan->kalkulator_pemupukan_generated_at = now();
            $lahan->save();

            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghasilkan kalkulator pemupukan: ' . $e->getMessage()
            ], 500);
        }
    }
}
