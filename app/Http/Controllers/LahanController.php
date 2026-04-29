<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LahanController extends Controller
{
    // ─── Hardcoded user_id sementara (sebelum auth aktif) ───────────────────
    private function currentUserId(): int
    {
        return Auth::id();
    }

    // ─── INDEX ───────────────────────────────────────────────────────────────
    public function index()
    {
        $userId = $this->currentUserId();

        $lahans = Lahan::where('user_id', $userId)
            ->where('is_aktif', true)
            ->orderByDesc('created_at')
            ->get();

        // Quick stats
        $totalLahan  = $lahans->count();
        $totalLuas   = $lahans->sum('luas');
        $perluPerhatian = $lahans->whereIn('status_risiko', ['waspada', 'kritis'])->count();
        $estimasiPanen  = null;
        if ($lahans->isNotEmpty()) {
            $next = $lahans->filter(fn($l) => $l->estimasi_panen && $l->estimasi_panen->isFuture())
                           ->sortBy('estimasi_panen')
                           ->first();
            $estimasiPanen = $next ? round(now()->diffInDays($next->estimasi_panen)) : null;
        }

        return view('pages.manage_lands', compact(
            'lahans', 'totalLahan', 'totalLuas', 'perluPerhatian', 'estimasiPanen'
        ));
    }

    // ─── SHOW ────────────────────────────────────────────────────────────────
    public function show(Lahan $lahan)
    {
        $this->authorizeOwner($lahan);
        $lahan->load('musimTanams');
        return view('pages.land_details', compact('lahan'));
    }

    // ─── CREATE (form) ───────────────────────────────────────────────────────
    public function create()
    {
        return view('pages.add_land');
    }

    // ─── STORE ───────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'komoditas'     => 'required|string|max:100',
            'luas'          => 'nullable|numeric|min:0',
            'area_unit'     => 'nullable|string',
            'tanggal_tanam' => 'nullable|date',
            'kode_wilayah'  => 'required|string',
            'alamat'        => 'nullable|string|max:500',
            'provinsi'      => 'nullable|string|max:255',
            'kota'          => 'nullable|string|max:255',
            'kecamatan'     => 'nullable|string|max:255',
            'kelurahan'     => 'nullable|string|max:255',
            'latitude'      => 'nullable|numeric',
            'longitude'     => 'nullable|numeric',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        ], [
            'nama.required'         => 'Nama lahan wajib diisi.',
            'komoditas.required'    => 'Komoditas wajib dipilih.',
            'kode_wilayah.required' => 'Kode wilayah wajib diisi.',
            'luas.numeric'          => 'Luas harus berupa angka.',
            'foto.image'            => 'File harus berupa gambar.',
            'foto.max'              => 'Ukuran foto maksimal 1MB.',
        ]);

        // Konversi luas ke hektar jika unit m²
        $luas = $validated['luas'] ?? null;
        if ($luas && ($request->area_unit === 'm2')) {
            $luas = $luas / 10000;
        }

        // Upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('lahans', 'public');
        }

        // Estimasi panen berdasarkan tanggal tanam & komoditas
        $estimasiPanen = null;
        $durasiHari    = null;
        if ($validated['tanggal_tanam'] ?? false) {
            $durasiMap = [
                'padi'         => 115,
                'jagung'       => 90,
                'cabai'        => 90,
                'bawang_merah' => 65,
                'kedelai'      => 85,
                'lainnya'      => 100,
            ];
            $durasiHari    = $durasiMap[$validated['komoditas']] ?? 100;
            $estimasiPanen = \Carbon\Carbon::parse($validated['tanggal_tanam'])->addDays($durasiHari);
        }

        Lahan::create([
            'user_id'           => $this->currentUserId(),
            'nama'              => $validated['nama'],
            'komoditas'         => $validated['komoditas'],
            'luas'              => $luas,
            'foto'              => $fotoPath,
            'alamat'            => $validated['alamat'] ?? null,
            'kode_wilayah'      => $validated['kode_wilayah'],
            'provinsi'          => $validated['provinsi'] ?? null,
            'kota'              => $validated['kota'] ?? null,
            'kecamatan'         => $validated['kecamatan'] ?? null,
            'kelurahan'         => $validated['kelurahan'] ?? null,
            'latitude'          => $validated['latitude'] ?? null,
            'longitude'         => $validated['longitude'] ?? null,
            'tanggal_tanam'     => $validated['tanggal_tanam'] ?? null,
            'estimasi_panen'    => $estimasiPanen,
            'durasi_tanam_hari' => $durasiHari,
            'fase_tanam'        => 'persiapan',
            'status_risiko'     => 'optimal',
            'is_aktif'          => true,
            'notifikasi_aktif'  => true,
        ]);

        return redirect()->route('manage_lands')
            ->with('success', "Lahan \"{$validated['nama']}\" berhasil ditambahkan!");
    }

    // ─── EDIT (form) ─────────────────────────────────────────────────────────
    public function edit(Lahan $lahan)
    {
        $this->authorizeOwner($lahan);
        return view('pages.edit_land', compact('lahan'));
    }

    // ─── UPDATE ──────────────────────────────────────────────────────────────
    public function update(Request $request, Lahan $lahan)
    {
        $this->authorizeOwner($lahan);

        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'komoditas'     => 'required|string|max:100',
            'luas'          => 'nullable|numeric|min:0',
            'area_unit'     => 'nullable|string',
            'tanggal_tanam' => 'nullable|date',
            'fase_tanam'    => 'nullable|in:persiapan,persemaian,tanam,vegetatif,generatif,panen,pasca_panen',
            'status_risiko' => 'nullable|in:optimal,waspada,kritis',
            'alamat'        => 'nullable|string|max:500',
            'latitude'      => 'nullable|numeric',
            'longitude'     => 'nullable|numeric',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        ]);

        // Konversi luas ke hektar
        $luas = $validated['luas'] ?? $lahan->luas;
        if (($request->area_unit === 'm2') && $validated['luas'] ?? false) {
            $luas = $validated['luas'] / 10000;
        }

        // Upload foto baru jika ada
        if ($request->hasFile('foto')) {
            if ($lahan->foto) {
                Storage::disk('public')->delete($lahan->foto);
            }
            $validated['foto'] = $request->file('foto')->store('lahans', 'public');
        }

        // Hitung ulang estimasi panen jika tanggal tanam berubah
        $estimasiPanen = $lahan->estimasi_panen;
        $durasiHari    = $lahan->durasi_tanam_hari;
        if (($validated['tanggal_tanam'] ?? null) && $validated['tanggal_tanam'] !== $lahan->tanggal_tanam?->toDateString()) {
            $durasiMap  = ['padi' => 115, 'jagung' => 90, 'cabai' => 90, 'bawang_merah' => 65, 'kedelai' => 85, 'lainnya' => 100];
            $durasiHari = $durasiMap[$validated['komoditas']] ?? 100;
            $estimasiPanen = \Carbon\Carbon::parse($validated['tanggal_tanam'])->addDays($durasiHari);
        }

        $lahan->update([
            'nama'              => $validated['nama'],
            'komoditas'         => $validated['komoditas'],
            'luas'              => $luas,
            'foto'              => $validated['foto'] ?? $lahan->foto,
            'alamat'            => $validated['alamat'] ?? $lahan->alamat,
            'latitude'          => $validated['latitude'] ?? $lahan->latitude,
            'longitude'         => $validated['longitude'] ?? $lahan->longitude,
            'tanggal_tanam'     => $validated['tanggal_tanam'] ?? $lahan->tanggal_tanam,
            'estimasi_panen'    => $estimasiPanen,
            'durasi_tanam_hari' => $durasiHari,
            'fase_tanam'        => $validated['fase_tanam'] ?? $lahan->fase_tanam,
            'status_risiko'     => $validated['status_risiko'] ?? $lahan->status_risiko,
        ]);

        return redirect()->route('lahan.show', $lahan)
            ->with('success', "Lahan \"{$lahan->nama}\" berhasil diperbarui!");
    }

    // ─── DESTROY ─────────────────────────────────────────────────────────────
    public function destroy(Lahan $lahan)
    {
        $this->authorizeOwner($lahan);
        $nama = $lahan->nama;

        if ($lahan->foto) {
            Storage::disk('public')->delete($lahan->foto);
        }

        $lahan->delete(); // soft delete

        return redirect()->route('manage_lands')
            ->with('success', "Lahan \"{$nama}\" berhasil dihapus.");
    }

    // ─── TOGGLE AKTIF ────────────────────────────────────────────────────────
    public function toggleAktif(Lahan $lahan)
    {
        $this->authorizeOwner($lahan);
        $lahan->update(['is_aktif' => !$lahan->is_aktif]);

        return back()->with('success', 'Status lahan berhasil diperbarui.');
    }

    // ─── HELPER: cek kepemilikan ─────────────────────────────────────────────
    private function authorizeOwner(Lahan $lahan): void
    {
        if ($lahan->user_id !== $this->currentUserId()) {
            abort(403, 'Anda tidak memiliki akses ke lahan ini.');
        }
    }
}
