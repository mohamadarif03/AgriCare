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
        // ─── Harga Pasar ─────────────────────────────────────────────
        $defaultRegion = 'cilacap';
        if ($selectedLahan) {
            $availableRegions = array_keys(\App\Models\MarketPrice::availableRegions());
            $landCity = strtolower($selectedLahan->kota ?? '');
            foreach ($availableRegions as $regionKey) {
                if (str_contains($landCity, strtolower($regionKey))) {
                    $defaultRegion = $regionKey;
                    break;
                }
            }
        }

        $commoditiesToFetch = ['padi', 'jagung', 'cabai_merah'];
        if ($selectedLahan) {
            $landComm = strtolower($selectedLahan->komoditas);
            if (array_key_exists($landComm, \App\Models\MarketPrice::availableCommodities())) {
                $commoditiesToFetch = array_diff($commoditiesToFetch, [$landComm]);
                array_unshift($commoditiesToFetch, $landComm);
                $commoditiesToFetch = array_slice($commoditiesToFetch, 0, 3);
            }
        }

        // Pastikan ada data, jika kosong jalankan seed dummy data
        if (\App\Models\MarketPrice::count() === 0) {
            app(\App\Services\MarketPriceService::class)->seedDummyData();
        }

        $marketPrices = [];
        foreach ($commoditiesToFetch as $comm) {
            $latest = \App\Models\MarketPrice::forCommodity($comm)
                ->forRegion($defaultRegion)
                ->orderByDesc('tanggal')
                ->first();
                
            if ($latest) {
                $prev = \App\Models\MarketPrice::forCommodity($comm)
                    ->forRegion($defaultRegion)
                    ->where('tanggal', '<', $latest->tanggal)
                    ->orderByDesc('tanggal')
                    ->first();
                    
                $trend = $prev && $prev->harga > 0 ? round(($latest->harga - $prev->harga) / $prev->harga * 100, 1) : 0;
                
                $marketPrices[] = [
                    'komoditas' => $comm,
                    'label' => \App\Models\MarketPrice::availableCommodities()[$comm] ?? ucfirst($comm),
                    'harga' => $latest->harga,
                    'trend' => $trend
                ];
            }
        }
        // ─── Rekomendasi AI (Untuk Skor Ketahanan dan Aktivitas) ─────────────
        $recommendation = null;
        if ($selectedLahan) {
            $recommendation = \App\Models\Recommendation::where('lahan_id', $selectedLahan->id)
                ->where('user_id', $userId)
                ->where('is_archived', false)
                ->where('generated_at', '>=', now()->subHours(24))
                ->with('checklists')
                ->first();
                
            // Jika tidak ada di cache, kita panggil service (secara opsional bisa fallback atau regenerate)
            if (!$recommendation) {
                try {
                    $recommendation = app(\App\Services\RecommendationService::class)->getRecommendation($userId, $selectedLahan->id);
                } catch (\Exception $e) {
                    $recommendation = null;
                }
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
            'risikoLevel',
            'marketPrices',
            'defaultRegion',
            'recommendation'
        ));
    }
}
