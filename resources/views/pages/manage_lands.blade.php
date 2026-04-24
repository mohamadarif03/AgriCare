@extends('layouts.app')

@section('content')
<main class="flex-grow w-full max-w-[1600px] mx-auto px-4 xl:px-6 py-6 md:py-8 flex flex-col gap-6">

    {{-- Flash Messages --}}
    @if(session('success'))
    <div id="flash-success" class="flex items-center gap-3 px-5 py-4 bg-green-50 border border-green-200 text-green-800 rounded-xl shadow-sm animate-fade-in">
        <span class="material-symbols-outlined text-green-600">check_circle</span>
        <span class="font-semibold text-sm">{{ session('success') }}</span>
        <button onclick="document.getElementById('flash-success').remove()" class="ml-auto text-green-500 hover:text-green-700">
            <span class="material-symbols-outlined text-[18px]">close</span>
        </button>
    </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-2">
        <div>
            <h1 class="font-h2 text-h2 text-on-surface leading-tight">Kelola Lahan Anda</h1>
            <p class="font-body text-sm text-on-surface-variant mt-1">Pantau status, fase tanam, dan risiko untuk semua lahan pertanian Anda dalam satu tempat.</p>
        </div>
        <a href="{{ route('add_land') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary text-on-primary rounded-xl font-semibold shadow-md hover:bg-primary-container hover:shadow-lg transition-all active:scale-95 w-fit">
            <span class="material-symbols-outlined">add</span>
            Tambah Lahan Baru
        </a>
    </div>

    {{-- Lands Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse($lahans as $lahan)
        {{-- Land Card --}}
        <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 overflow-hidden shadow-[0_4px_20px_rgba(27,94,32,0.03)] hover:shadow-md transition-shadow group">
            <div class="relative h-40 overflow-hidden">
                <img src="{{ $lahan->foto_url }}" alt="{{ $lahan->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-4 left-4 flex items-center gap-2">
                    <span class="bg-primary-container text-on-primary-container text-[10px] font-bold px-2 py-1 rounded-md uppercase tracking-wider">
                        {{ ucfirst($lahan->komoditas) }}
                    </span>
                    <span class="{{ $lahan->risiko_badge_class }} text-white text-[10px] font-bold px-2 py-1 rounded-md uppercase tracking-wider">
                        {{ $lahan->risiko_label }}
                    </span>
                </div>
                {{-- Delete Button (top-right) --}}
                <form action="{{ route('lahan.destroy', $lahan) }}" method="POST" class="absolute top-3 right-3"
                      onsubmit="return confirm('Hapus lahan \"{{ $lahan->nama }}\"? Data akan dihapus permanen.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-1.5 bg-white/80 backdrop-blur-sm rounded-lg text-red-500 hover:bg-red-50 transition-colors shadow-sm" title="Hapus Lahan">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                    </button>
                </form>
            </div>
            <div class="p-5">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="font-h3 text-xl text-on-surface">{{ $lahan->nama }}</h3>
                    <div class="flex items-center text-on-surface-variant text-sm font-medium">
                        <span class="material-symbols-outlined text-[18px] mr-1">straighten</span>
                        {{ $lahan->luas ? number_format($lahan->luas, 1) . ' Ha' : '— Ha' }}
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-on-surface-variant">Fase Tanam:</span>
                        <span class="font-semibold text-primary">{{ $lahan->fase_label }}</span>
                    </div>
                    <div class="w-full bg-surface-container rounded-full h-1.5">
                        <div class="bg-primary h-1.5 rounded-full transition-all" style="width: {{ $lahan->fase_progress }}%"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <a href="{{ route('lahan.show', $lahan) }}" class="flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface text-sm font-semibold transition-colors">
                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                            Detail
                        </a>
                        <a href="{{ route('lahan.edit', $lahan) }}" class="flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface text-sm font-semibold transition-colors">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                            Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        {{-- Empty State --}}
        <div class="lg:col-span-3 flex flex-col items-center justify-center py-20 text-center">
            <div class="w-24 h-24 rounded-full bg-surface-container flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-5xl text-on-surface-variant">agriculture</span>
            </div>
            <h3 class="font-h3 text-xl text-on-surface mb-2">Belum Ada Lahan</h3>
            <p class="text-sm text-on-surface-variant max-w-sm mb-6">Daftarkan lahan pertanian Anda dan dapatkan analisis AI, prediksi cuaca, serta peringatan hama secara real-time.</p>
            <a href="{{ route('add_land') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-on-primary rounded-xl font-semibold shadow-md hover:bg-primary-container transition-all">
                <span class="material-symbols-outlined">add</span>
                Tambah Lahan Pertama
            </a>
        </div>
        @endforelse

        {{-- Add Land Placeholder Card (only if there are lands) --}}
        @if($lahans->isNotEmpty())
        <a href="{{ route('add_land') }}" class="bg-surface-container-low rounded-2xl border-2 border-dashed border-outline-variant/50 flex flex-col items-center justify-center p-8 gap-4 hover:bg-surface-container hover:border-primary/50 transition-all group min-h-[220px]">
            <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center text-primary shadow-sm group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-4xl">add</span>
            </div>
            <div class="text-center">
                <h4 class="font-bold text-on-surface">Tambah Lahan Baru</h4>
                <p class="text-sm text-on-surface-variant mt-1">Daftarkan lahan baru Anda untuk analisis AI</p>
            </div>
        </a>
        @endif
    </div>

    {{-- Quick Stats --}}
    <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-xl border border-outline-variant/30 flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined">agriculture</span>
            </div>
            <div>
                <p class="text-xs text-on-surface-variant uppercase font-bold tracking-wider">Total Lahan</p>
                <p class="text-xl font-bold text-on-surface">{{ $totalLahan }} Area</p>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl border border-outline-variant/30 flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined">square_foot</span>
            </div>
            <div>
                <p class="text-xs text-on-surface-variant uppercase font-bold tracking-wider">Total Luas</p>
                <p class="text-xl font-bold text-on-surface">{{ number_format($totalLuas, 1) }} Ha</p>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl border border-outline-variant/30 flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined">warning</span>
            </div>
            <div>
                <p class="text-xs text-on-surface-variant uppercase font-bold tracking-wider">Perlu Perhatian</p>
                <p class="text-xl font-bold text-on-surface">{{ $perluPerhatian }} Lahan</p>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl border border-outline-variant/30 flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined">trending_up</span>
            </div>
            <div>
                <p class="text-xs text-on-surface-variant uppercase font-bold tracking-wider">Estimasi Panen</p>
                <p class="text-xl font-bold text-on-surface">
                    @if($estimasiPanen !== null)
                        {{ $estimasiPanen }} Hari
                    @else
                        —
                    @endif
                </p>
            </div>
        </div>
    </div>
</main>
@endsection
