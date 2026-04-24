<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
use App\Services\BmkgService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private BmkgService $bmkg;

    public function __construct(BmkgService $bmkg)
    {
        $this->bmkg = $bmkg;
    }

    private function currentUserId(): int
    {
        return Auth::id();
    }

    public function index(Request $request)
    {
        $userId = $this->currentUserId();

        // Ambil semua lahan aktif user
        $lahans = Lahan::where('user_id', $userId)
            ->where('is_aktif', true)
            ->orderByDesc('created_at')
            ->get();

        // Tentukan lahan yang dipilih (filter)
        $selectedLahanId = $request->query('lahan');
        $selectedLahan = null;

        if ($selectedLahanId) {
            $selectedLahan = $lahans->firstWhere('id', $selectedLahanId);
        }

        // Fallback ke lahan pertama jika tidak ada yang dipilih
        if (!$selectedLahan && $lahans->isNotEmpty()) {
            $selectedLahan = $lahans->first();
        }

        // ─── Data Cuaca dari BMKG ────────────────────────────────────────
        $cuacaHariIni = null;
        $prakiraan3Hari = [];
        $lokasiCuaca = null;

        if ($selectedLahan && $selectedLahan->kode_wilayah && $selectedLahan->kode_wilayah !== '00.00.00.0000') {
            $cuacaHariIni = $this->bmkg->getCuacaHariIni($selectedLahan->kode_wilayah);
            $prakiraan3Hari = $this->bmkg->getPrakiraan3Hari($selectedLahan->kode_wilayah);

            if ($cuacaHariIni) {
                $lok = $cuacaHariIni['lokasi'];
                $lokasiCuaca = ($lok['desa'] ?? '') . ', ' . ($lok['kecamatan'] ?? '') . ', ' . ($lok['kotkab'] ?? '');
            }
        }

        // ─── Statistik Lahan ─────────────────────────────────────────────
        $totalLahan = $lahans->count();
        $totalLuas = $lahans->sum('luas');
        $perluPerhatian = $lahans->whereIn('status_risiko', ['waspada', 'kritis'])->count();

        // Estimasi panen terdekat
        $estimasiPanen = null;
        $lahanPanenTerdekat = null;
        if ($lahans->isNotEmpty()) {
            $next = $lahans->filter(fn($l) => $l->estimasi_panen && $l->estimasi_panen->isFuture())
                           ->sortBy('estimasi_panen')
                           ->first();
            if ($next) {
                $estimasiPanen = round(now()->diffInDays($next->estimasi_panen));
                $lahanPanenTerdekat = $next;
            }
        }

        // ─── Risiko Iklim berdasarkan cuaca ──────────────────────────────
        $risikoIndex = null;
        $risikoLevel = null;
        if ($cuacaHariIni) {
            // Hitung index sederhana berdasarkan parameter cuaca
            $hujanScore = min($cuacaHariIni['curah_hujan'] * 5, 40);
            $kelembabanScore = max(0, ($cuacaHariIni['kelembapan'] - 70) * 1);
            $anginScore = max(0, ($cuacaHariIni['kecepatan_angin'] - 20));
            $risikoIndex = min(100, round($hujanScore + $kelembabanScore + $anginScore));

            if ($risikoIndex >= 70) {
                $risikoLevel = 'KRITIS';
            } elseif ($risikoIndex >= 40) {
                $risikoLevel = 'WASPADA';
            } else {
                $risikoLevel = 'AMAN';
            }
        }

        return view('pages.dashboard', compact(
            'lahans',
            'selectedLahan',
            'cuacaHariIni',
            'prakiraan3Hari',
            'lokasiCuaca',
            'totalLahan',
            'totalLuas',
            'perluPerhatian',
            'estimasiPanen',
            'lahanPanenTerdekat',
            'risikoIndex',
            'risikoLevel'
        ));
    }
}
