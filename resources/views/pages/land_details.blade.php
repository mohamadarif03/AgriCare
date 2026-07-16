@extends('layouts.app')

@section('content')
<main class="flex-grow w-full max-w-[1600px] mx-auto px-4 xl:px-6 py-6 md:py-8 flex flex-col gap-6">

    {{-- Flash Messages --}}
    @if(session('success'))
    <div id="flash-success" class="flex items-center gap-3 px-5 py-4 bg-orange-50 border border-orange-200 text-orange-800 rounded-xl shadow-sm">
        <span class="material-symbols-outlined text-orange-600">check_circle</span>
        <span class="font-semibold text-sm">{{ session('success') }}</span>
        <button onclick="document.getElementById('flash-success').remove()" class="ml-auto text-orange-500 hover:text-orange-700">
            <span class="material-symbols-outlined text-[18px]">close</span>
        </button>
    </div>
    @endif

    {{-- Breadcrumbs & Actions --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-2">
        <div class="flex items-center gap-3">
            <a href="{{ route('manage_lands') }}" class="p-2 -ml-2 text-on-surface-variant hover:text-primary hover:bg-surface-container rounded-full transition-colors flex items-center justify-center">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <nav class="flex text-xs text-on-surface-variant mb-1" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        <li><a href="{{ route('manage_lands') }}" class="hover:text-primary">Kelola Lahan</a></li>
                        <li><span class="material-symbols-outlined text-[14px]">chevron_right</span></li>
                        <li class="text-on-surface font-semibold">Detail Lahan</li>
                    </ol>
                </nav>
                <h1 class="font-h2 text-h2 text-on-surface leading-tight">{{ $lahan->nama }}</h1>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <form action="{{ route('lahan.toggle-aktif', $lahan) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="px-4 py-2 {{ $lahan->is_aktif ? 'bg-surface-container text-on-surface' : 'bg-primary text-on-primary' }} rounded-xl text-sm font-semibold shadow-sm hover:opacity-80 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">{{ $lahan->is_aktif ? 'pause_circle' : 'check_circle' }}</span>
                    {{ $lahan->is_aktif ? 'Set Nonaktif' : 'Set Aktif' }}
                </button>
            </form>
            <a href="{{ route('lahan.edit', $lahan) }}" class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container rounded-xl transition-colors border border-outline-variant/30">
                <span class="material-symbols-outlined">edit</span>
            </a>
            <form action="{{ route('lahan.destroy', $lahan) }}" method="POST"
                  onsubmit="return confirm('Hapus lahan \"{{ $lahan->nama }}\"? Aksi ini tidak dapat dibatalkan.')">
                @csrf @method('DELETE')
                <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-xl transition-colors border border-red-100">
                    <span class="material-symbols-outlined">delete</span>
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- LEFT COLUMN: Main Info & Status --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- Status Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Risk Level --}}
                <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant/30 shadow-sm flex flex-col gap-3">
                    <div class="flex items-center gap-2 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">security</span>
                        <span class="text-xs font-bold uppercase tracking-wider">Risiko Iklim</span>
                    </div>
                    <div class="flex items-center gap-3">
                        @php
                            $risikoConfig = [
                                'optimal' => ['color' => 'bg-orange-100 text-orange-600', 'icon' => 'check_circle', 'label' => 'Optimal', 'sub' => 'Kondisi Baik'],
                                'waspada' => ['color' => 'bg-amber-100 text-amber-600', 'icon' => 'warning', 'label' => 'Waspada', 'sub' => 'Perlu Perhatian'],
                                'kritis'  => ['color' => 'bg-red-100 text-red-600', 'icon' => 'emergency', 'label' => 'Kritis', 'sub' => 'Segera Tindak'],
                            ];
                            $rc = $risikoConfig[$lahan->status_risiko] ?? $risikoConfig['optimal'];
                        @endphp
                        <div class="w-12 h-12 rounded-full {{ $rc['color'] }} flex items-center justify-center">
                            <span class="material-symbols-outlined text-3xl">{{ $rc['icon'] }}</span>
                        </div>
                        <div>
                            <p class="text-xl font-bold {{ explode(' ', $rc['color'])[1] }}">{{ $rc['label'] }}</p>
                            <p class="text-[10px] text-on-surface-variant mt-0.5">{{ $rc['sub'] }}</p>
                        </div>
                    </div>
                </div>

                {{-- Luas --}}
                <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant/30 shadow-sm flex flex-col gap-3">
                    <div class="flex items-center gap-2 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">square_foot</span>
                        <span class="text-xs font-bold uppercase tracking-wider">Luas Lahan</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-3xl">straighten</span>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-on-surface">{{ $lahan->luas ? number_format($lahan->luas, 2) : '—' }} Ha</p>
                            <p class="text-[10px] text-on-surface-variant mt-0.5">{{ $lahan->luas ? number_format($lahan->luas * 10000, 0, ',', '.') . ' m²' : '' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Growth Phase --}}
                <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant/30 shadow-sm flex flex-col gap-3">
                    <div class="flex items-center gap-2 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">eco</span>
                        <span class="text-xs font-bold uppercase tracking-wider">Fase Tanam</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-primary mb-2">{{ $lahan->fase_label }}</p>
                        <div class="w-full bg-surface-container rounded-full h-2">
                            <div class="bg-primary h-2 rounded-full transition-all" style="width: {{ $lahan->fase_progress }}%"></div>
                        </div>
                        <p class="text-[10px] text-on-surface-variant mt-1">{{ $lahan->fase_progress }}% Selesai</p>
                    </div>
                </div>
            </div>

            {{-- Land Details & Photo --}}
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-sm overflow-hidden flex flex-col md:flex-row">
                <div class="md:w-1/3 relative h-64 md:h-auto">
                    <img src="{{ $lahan->foto_url }}" alt="Foto Lahan" class="w-full h-full object-cover">
                    <a href="{{ route('lahan.edit', $lahan) }}" class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm p-2 rounded-lg shadow-md hover:bg-white transition-colors">
                        <span class="material-symbols-outlined text-primary">add_a_photo</span>
                    </a>
                </div>
                <div class="md:w-2/3 p-6 md:p-8 space-y-6">
                    <h3 class="font-h3 text-xl text-on-surface">Informasi Dasar</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                        <div>
                            <p class="text-xs text-on-surface-variant font-bold uppercase mb-1">Komoditas</p>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">eco</span>
                                <span class="font-semibold text-on-surface">{{ ucfirst($lahan->komoditas) }}</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-on-surface-variant font-bold uppercase mb-1">Luas Lahan</p>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-orange-600">square_foot</span>
                                <span class="font-semibold text-on-surface">{{ $lahan->luas ? number_format($lahan->luas, 2) . ' Hektar (Ha)' : 'Belum diisi' }}</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-on-surface-variant font-bold uppercase mb-1">Tanggal Tanam</p>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-purple-600">calendar_today</span>
                                <span class="font-semibold text-on-surface">{{ $lahan->tanggal_tanam ? $lahan->tanggal_tanam->translatedFormat('d F Y') : 'Belum diisi' }}</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-on-surface-variant font-bold uppercase mb-1">Estimasi Panen</p>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-orange-600">event_available</span>
                                <span class="font-semibold text-on-surface">{{ $lahan->estimasi_panen ? $lahan->estimasi_panen->translatedFormat('d F Y') : '—' }}</span>
                            </div>
                        </div>
                        @if($lahan->alamat)
                        <div class="md:col-span-2">
                            <p class="text-xs text-on-surface-variant font-bold uppercase mb-1">Lokasi Lengkap</p>
                            <div class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-red-500 mt-0.5">location_on</span>
                                <span class="font-semibold text-on-surface">{{ $lahan->alamat }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Seasonal History --}}
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-sm p-6 md:p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-h3 text-xl text-on-surface">Riwayat Musim Tanam</h3>
                </div>
                @if($lahan->musimTanams->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-outline-variant/30">
                                <th class="pb-4 font-bold text-xs text-on-surface-variant uppercase">Periode</th>
                                <th class="pb-4 font-bold text-xs text-on-surface-variant uppercase">Komoditas</th>
                                <th class="pb-4 font-bold text-xs text-on-surface-variant uppercase text-right">Hasil Panen</th>
                                <th class="pb-4 font-bold text-xs text-on-surface-variant uppercase text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/20">
                            @foreach($lahan->musimTanams as $musim)
                            <tr>
                                <td class="py-4">
                                    <p class="text-sm font-semibold text-on-surface">
                                        {{ $musim->tanggal_tanam->translatedFormat('M Y') }}
                                        @if($musim->tanggal_panen)– {{ $musim->tanggal_panen->translatedFormat('M Y') }}@endif
                                    </p>
                                    @if($musim->tanggal_panen)
                                    <p class="text-[10px] text-on-surface-variant">{{ $musim->tanggal_tanam->diffInDays($musim->tanggal_panen) }} Hari Masa Tanam</p>
                                    @endif
                                </td>
                                <td class="py-4 text-sm text-on-surface">{{ ucfirst($musim->komoditas) }}</td>
                                <td class="py-4 text-sm font-bold text-on-surface text-right">
                                    {{ $musim->hasil_panen_kg ? number_format($musim->hasil_panen_kg / 1000, 1) . ' Ton' : '—' }}
                                </td>
                                <td class="py-4 text-right">
                                    <span class="text-[10px] font-bold {{ $musim->status_badge_class }} px-2 py-1 rounded">{{ $musim->status_label }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-8 text-on-surface-variant">
                    <span class="material-symbols-outlined text-3xl mb-2 block">history</span>
                    <p class="text-sm">Belum ada riwayat musim tanam.</p>
                </div>
                @endif
            </div>
        </div>

        {{-- RIGHT COLUMN --}}
        <div class="lg:col-span-4 space-y-6">
            {{-- Quick Actions --}}
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-sm p-6">
                <h3 class="font-h3 text-lg text-on-surface mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('lahan.edit', $lahan) }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-surface-container hover:bg-surface-container-high text-on-surface text-sm font-semibold transition-colors">
                        <span class="material-symbols-outlined text-primary">edit</span>
                        Edit Informasi Lahan
                    </a>
                    <a href="{{ route('calender_planning') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-surface-container hover:bg-surface-container-high text-on-surface text-sm font-semibold transition-colors">
                        <span class="material-symbols-outlined text-orange-600">calendar_month</span>
                        Lihat Kalender Tanam
                    </a>
                    <a href="{{ route('ai_reccomendation') }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-surface-container hover:bg-surface-container-high text-on-surface text-sm font-semibold transition-colors">
                        <span class="material-symbols-outlined text-purple-600">auto_awesome</span>
                        Rekomendasi AI
                    </a>
                </div>
            </div>

            {{-- Land Info Summary --}}
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-sm p-6">
                <h3 class="font-h3 text-lg text-on-surface mb-4">Ringkasan</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-on-surface-variant">Status</span>
                        <span class="px-2 py-0.5 rounded text-[11px] font-bold {{ $lahan->is_aktif ? 'bg-orange-100 text-orange-700' : 'bg-surface-container text-on-surface-variant' }}">
                            {{ $lahan->is_aktif ? 'AKTIF' : 'NONAKTIF' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Terdaftar</span>
                        <span class="font-semibold text-on-surface">{{ $lahan->created_at->translatedFormat('d M Y') }}</span>
                    </div>
                    @if($lahan->estimasi_panen && $lahan->estimasi_panen->isFuture())
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Sisa Hari Panen</span>
                        <span class="font-bold text-primary">{{ round(now()->diffInDays($lahan->estimasi_panen)) }} hari</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Musim Tanam</span>
                        <span class="font-semibold text-on-surface">{{ $lahan->musimTanams->count() }} Riwayat</span>
                    </div>
                </div>
            </div>

            {{-- AI Insight Box --}}
            <div class="bg-primary-container text-on-primary-container rounded-2xl p-6 shadow-md relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 opacity-10">
                    <span class="material-symbols-outlined" style="font-size: 100px;">psychiatry</span>
                </div>
                <div class="relative z-10">
                    <h4 class="font-bold mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined">auto_awesome</span>
                        AI Insight
                    </h4>
                    <p class="text-sm leading-relaxed font-body">
                        Lahan <strong>{{ $lahan->nama }}</strong> dengan komoditas <strong>{{ ucfirst($lahan->komoditas) }}</strong>
                        @if($lahan->tanggal_tanam)
                            sudah {{ round($lahan->tanggal_tanam->diffInDays(now())) }} hari sejak tanam.
                        @else
                            belum memiliki data tanggal tanam. Tambahkan untuk mendapatkan prediksi AI yang akurat.
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
