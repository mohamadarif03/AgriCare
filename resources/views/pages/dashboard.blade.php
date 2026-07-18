@extends('layouts.app')

@section('content')
<!-- Main Content Container -->
    <main class="flex-grow w-full max-w-[1600px] mx-auto px-4 xl:px-6 py-6 md:py-8 flex flex-col gap-6">

        {{-- Filter Lahan --}}
        @if($lahans->isNotEmpty())
        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
            <div class="flex items-center gap-2 shrink-0">
                <span class="material-symbols-outlined text-primary text-[20px]">filter_list</span>
                <span class="text-sm font-semibold text-on-surface-variant">Lahan Aktif:</span>
            </div>
            <div class="flex flex-wrap gap-2 flex-1">
                @foreach($lahans as $l)
                <a href="{{ route('dashboard', ['lahan' => $l->id]) }}"
                   class="px-4 py-1.5 rounded-full text-sm font-semibold transition-all {{ $selectedLahan && $selectedLahan->id === $l->id ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container text-on-surface-variant hover:bg-surface-container-high' }}">
                    {{ $l->nama }}
                </a>
                @endforeach
            </div>
            <a href="{{ route('add_land') }}" class="shrink-0 flex items-center gap-1 px-3 py-1.5 rounded-full text-sm font-semibold bg-primary-container text-on-primary-container hover:opacity-90 transition-opacity">
                <span class="material-symbols-outlined text-[16px]">add</span>
                Tambah Lahan
            </a>
        </div>
        @endif

        {{-- Alert Banner --}}
        @if($cuacaHariIni && $cuacaHariIni['curah_hujan'] > 5)
        <div class="bg-[#FFF8E1] border-l-4 border-amber-500 rounded-r-lg p-4 flex items-start gap-3 shadow-[0_4px_12px_rgba(27,94,32,0.02)]">
            <span class="material-symbols-outlined text-amber-600">warning</span>
            <div class="flex-1">
                <p class="font-body text-body text-amber-900">
                    <strong>Waspada:</strong> Curah hujan {{ $cuacaHariIni['curah_hujan'] }} mm diprediksi di wilayah {{ $selectedLahan->nama ?? 'lahan Anda' }}.
                    @if($selectedLahan && $selectedLahan->fase_tanam === 'vegetatif')
                    Risiko blast pada fase vegetatif.
                    @endif
                </p>
                <a class="inline-flex items-center mt-2 text-sm font-semibold text-amber-700 hover:text-amber-800" href="{{ route('ai_reccomendation') }}">
                    Lihat Rekomendasi <span class="material-symbols-outlined ml-1 text-sm">arrow_forward</span>
                </a>
            </div>
        </div>
        @elseif($lahans->isEmpty())
        <div class="bg-orange-50 border-l-4 border-orange-400 rounded-r-lg p-4 flex items-start gap-3">
            <span class="material-symbols-outlined text-orange-500">info</span>
            <div class="flex-1">
                <p class="font-body text-body text-orange-900">
                    <strong>Selamat datang!</strong> Tambahkan lahan pertama Anda untuk melihat data cuaca real-time dari BMKG.
                </p>
                <a class="inline-flex items-center mt-2 text-sm font-semibold text-orange-700 hover:text-orange-800" href="{{ route('add_land') }}">
                    Tambah Lahan Sekarang <span class="material-symbols-outlined ml-1 text-sm">arrow_forward</span>
                </a>
            </div>
        </div>
        @endif

        {{-- Top Metrics (Bento Grid) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Metric 1: Skor Ketahanan Lahan --}}
            <div class="bg-surface rounded-xl p-5 border border-surface-variant shadow-[0_2px_8px_rgba(27,94,32,0.04)]">
                <div class="flex justify-between items-start mb-2">
                    <span class="font-small-label text-small-label text-on-surface-variant">Skor Ketahanan Lahan</span>
                    @php
                        $skor = $recommendation ? ($recommendation->data_json['skor_ketahanan'] ?? null) : null;
                        $skorLevel = '—';
                        $badgeClass = 'bg-surface-container text-on-surface-variant';
                        if ($needsAiGeneration) {
                            $skorLevel = 'LOADING...';
                            $badgeClass = 'bg-surface-variant text-on-surface-variant animate-pulse';
                        } elseif ($skor !== null) {
                            if ($skor >= 75) {
                                $skorLevel = 'SANGAT BAIK';
                                $badgeClass = 'bg-orange-100 text-orange-800';
                            } elseif ($skor >= 50) {
                                $skorLevel = 'CUKUP BAIK';
                                $badgeClass = 'bg-amber-100 text-amber-800';
                            } else {
                                $skorLevel = 'KRITIS';
                                $badgeClass = 'bg-red-100 text-red-800';
                            }
                        }
                    @endphp
                    <span id="ai-skor-badge" class="{{ $badgeClass }} text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wide">{{ $skorLevel }}</span>
                </div>
                <div class="flex items-end gap-2">
                    <span id="ai-skor-value" class="font-h2 text-h2 text-on-surface {{ $needsAiGeneration ? 'animate-pulse text-transparent bg-surface-variant rounded' : '' }}">{{ $needsAiGeneration ? '00' : ($skor ?? '—') }}</span><span class="text-sm text-on-surface-variant mb-1">/100</span>
                </div>
                <div class="mt-3 flex items-center justify-between text-xs text-on-surface-variant">
                    <span>{{ $selectedLahan->nama ?? 'Belum ada lahan' }}</span>
                    <span>AI TaniBot</span>
                </div>
            </div>

            {{-- Metric 2: Cuaca Hari Ini --}}
            <div class="bg-surface rounded-xl p-5 border border-surface-variant shadow-[0_2px_8px_rgba(27,94,32,0.04)]">
                <div class="flex justify-between items-start mb-2">
                    <span class="font-small-label text-small-label text-on-surface-variant">Cuaca Hari Ini</span>
                    @if($lokasiCuaca)
                    <div class="flex items-center gap-1 bg-surface-container-low px-2 py-0.5 rounded text-[10px] font-medium text-on-surface-variant">
                        <span class="material-symbols-outlined text-[12px] text-primary">location_on</span>
                        {{ Str::limit($lokasiCuaca, 20) }}
                    </div>
                    @endif
                </div>
                @if($cuacaHariIni)
                <div class="flex justify-between items-end mt-1">
                    <div>
                        <div class="font-h2 text-h2 text-on-surface leading-none">{{ $cuacaHariIni['suhu'] }}°C</div>
                        <div class="text-sm font-medium text-on-surface mt-1">{{ $cuacaHariIni['cuaca'] }}</div>
                    </div>
                    <span class="material-symbols-outlined {{ \App\Services\BmkgService::weatherIconColor($cuacaHariIni['cuaca_code']) }} text-4xl leading-none">{{ \App\Services\BmkgService::weatherIcon($cuacaHariIni['cuaca_code']) }}</span>
                </div>
                <div class="mt-3 pt-3 border-t border-surface-variant flex justify-between items-center text-xs text-on-surface-variant">
                    <span>{{ $cuacaHariIni['cuaca'] }}</span>
                    <div class="flex gap-2 font-medium">
                        <span>💧 {{ $cuacaHariIni['kelembapan'] }}%</span>
                        <span>💨 {{ $cuacaHariIni['kecepatan_angin'] }}km/h</span>
                    </div>
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-4 text-on-surface-variant">
                    <span class="material-symbols-outlined text-3xl mb-1">cloud_off</span>
                    <span class="text-xs">Belum ada data cuaca</span>
                </div>
                @endif
            </div>

            {{-- Metric 3: Fase Tanam --}}
            <div class="bg-surface rounded-xl p-5 border border-surface-variant shadow-[0_2px_8px_rgba(27,94,32,0.04)]">
                <div class="flex justify-between items-start mb-2">
                    <span class="font-small-label text-small-label text-on-surface-variant">Fase Tanam</span>
                    <span class="material-symbols-outlined text-primary">eco</span>
                </div>
                @if($selectedLahan)
                <div class="font-body text-body font-medium text-on-surface mt-1">{{ $selectedLahan->fase_label }}</div>
                <div class="text-sm text-on-surface-variant">{{ $selectedLahan->nama }}</div>
                <div class="w-full bg-surface-container-highest rounded-full h-1.5 mt-3">
                    <div class="bg-primary h-1.5 rounded-full transition-all" style="width: {{ $selectedLahan->fase_progress }}%"></div>
                </div>
                <div class="mt-2 text-xs text-primary font-medium text-right">
                    @if($estimasiPanen && $lahanPanenTerdekat && $lahanPanenTerdekat->id === $selectedLahan->id)
                        {{ $estimasiPanen }} hari lagi panen
                    @elseif($selectedLahan->estimasi_panen && $selectedLahan->estimasi_panen->isFuture())
                        {{ round(now()->diffInDays($selectedLahan->estimasi_panen)) }} hari lagi panen
                    @else
                        {{ $selectedLahan->fase_progress }}% selesai
                    @endif
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-4 text-on-surface-variant">
                    <span class="material-symbols-outlined text-3xl mb-1">grass</span>
                    <span class="text-xs">Belum ada lahan</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Main Content 2 Columns --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- LEFT COLUMN (65%) --}}
            <div class="lg:col-span-8 space-y-6">
                {{-- Prakiraan 3 Hari --}}
                <div class="bg-surface rounded-xl border border-surface-variant p-5 shadow-[0_2px_12px_rgba(27,94,32,0.03)]">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-h3 text-h3 text-on-surface">Prakiraan Cuaca</h3>
                        @if($lokasiCuaca)
                        <div class="flex items-center gap-1.5 px-3 py-1 bg-surface-container-low rounded-full border border-outline-variant">
                            <span class="material-symbols-outlined text-primary text-[16px]">location_on</span>
                            <span class="text-xs font-medium text-on-surface-variant">{{ $lokasiCuaca }}</span>
                        </div>
                        @endif
                    </div>

                    @if(!empty($prakiraan3Hari))
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-{{ min(count($prakiraan3Hari), 4) }} gap-3">
                        @foreach($prakiraan3Hari as $i => $hari)
                        <div class="flex flex-col items-center bg-surface-container-low rounded-xl p-3 border border-outline-variant hover:border-primary hover:bg-surface transition-all cursor-pointer {{ $i === 0 ? 'ring-1 ring-primary/30' : '' }}">
                            <span class="text-xs font-semibold text-on-surface mb-1">
                                {{ $i === 0 ? 'Hari Ini' : $hari['hari'] }}
                            </span>
                            <span class="text-[10px] text-on-surface-variant mb-1">{{ $hari['tanggal_fmt'] }}</span>
                            <span class="material-symbols-outlined {{ \App\Services\BmkgService::weatherIconColor($hari['cuaca_code']) }} mb-1 text-2xl">{{ \App\Services\BmkgService::weatherIcon($hari['cuaca_code']) }}</span>
                            <span class="text-sm font-bold text-on-surface">{{ $hari['suhu_max'] }}°</span>
                            <span class="text-[10px] text-on-surface-variant">{{ $hari['suhu_min'] }}°</span>
                            <div class="flex items-center gap-1 mt-1">
                                <div class="w-1.5 h-1.5 rounded-full {{ \App\Services\BmkgService::riskDotColor($hari['risiko']) }}"></div>
                                <span class="text-[9px] text-on-surface-variant">{{ $hari['curah_hujan'] }}mm</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Detail cuaca hari ini --}}
                    @if($cuacaHariIni)
                    <div class="mt-4 pt-4 border-t border-surface-variant grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="text-center">
                            <p class="text-[10px] text-on-surface-variant uppercase font-bold tracking-wider">Suhu</p>
                            <p class="text-lg font-bold text-on-surface">{{ $cuacaHariIni['suhu'] }}°C</p>
                        </div>
                        <div class="text-center">
                            <p class="text-[10px] text-on-surface-variant uppercase font-bold tracking-wider">Kelembapan</p>
                            <p class="text-lg font-bold text-on-surface">{{ $cuacaHariIni['kelembapan'] }}%</p>
                        </div>
                        <div class="text-center">
                            <p class="text-[10px] text-on-surface-variant uppercase font-bold tracking-wider">Angin</p>
                            <p class="text-lg font-bold text-on-surface">{{ $cuacaHariIni['kecepatan_angin'] }} km/h</p>
                        </div>
                        <div class="text-center">
                            <p class="text-[10px] text-on-surface-variant uppercase font-bold tracking-wider">Curah Hujan</p>
                            <p class="text-lg font-bold text-on-surface">{{ $cuacaHariIni['curah_hujan'] }} mm</p>
                        </div>
                    </div>
                    @endif

                    <div class="mt-3 flex items-center gap-1 text-[10px] text-on-surface-variant">
                        <span class="material-symbols-outlined text-[12px]">info</span>
                        Sumber data: BMKG (Badan Meteorologi, Klimatologi, dan Geofisika) — Update 2x sehari
                    </div>
                    @else
                    <div class="flex flex-col items-center justify-center py-12 text-on-surface-variant">
                        <span class="material-symbols-outlined text-4xl mb-3">cloud_off</span>
                        <p class="text-sm font-medium mb-1">Tidak ada data cuaca</p>
                        <p class="text-xs max-w-sm text-center">
                            @if($lahans->isEmpty())
                                Tambahkan lahan dengan lokasi yang valid untuk melihat prakiraan cuaca dari BMKG.
                            @else
                                Pastikan kode wilayah BMKG pada lahan sudah diisi dengan benar.
                            @endif
                        </p>
                        <a href="{{ route('add_land') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-primary text-on-primary rounded-lg text-sm font-semibold">
                            <span class="material-symbols-outlined text-[18px]">add</span>
                            {{ $lahans->isEmpty() ? 'Tambah Lahan' : 'Perbaiki Data Lahan' }}
                        </a>
                    </div>
                    @endif
                </div>

                {{-- Aktivitas Hari Ini --}}
                <div class="bg-surface rounded-xl border border-surface-variant p-5 shadow-[0_2px_12px_rgba(27,94,32,0.03)] relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <span class="material-symbols-outlined text-6xl text-primary">psychiatry</span>
                    </div>
                    <div class="flex justify-between items-center mb-4 relative z-10">
                        <h3 class="font-h3 text-h3 text-on-surface">Aktivitas Hari Ini</h3>
                        <span class="text-[10px] font-bold bg-primary-container text-on-primary-container px-2 py-1 rounded-md">Powered by TaniBot AI</span>
                    </div>
                    <div class="space-y-3 relative z-10" id="ai-checklist-container">
                        @if($needsAiGeneration)
                            {{-- Skeleton Loading --}}
                            <div class="flex items-start gap-3 p-3 bg-white rounded-lg border border-surface-variant animate-pulse">
                                <div class="w-6 h-6 rounded bg-surface-variant"></div>
                                <div class="flex-1 space-y-2 py-1">
                                    <div class="h-4 bg-surface-variant rounded w-3/4"></div>
                                    <div class="h-3 bg-surface-variant rounded w-1/2"></div>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 p-3 bg-white rounded-lg border border-surface-variant animate-pulse">
                                <div class="w-6 h-6 rounded bg-surface-variant"></div>
                                <div class="flex-1 space-y-2 py-1">
                                    <div class="h-4 bg-surface-variant rounded w-5/6"></div>
                                    <div class="h-3 bg-surface-variant rounded w-2/3"></div>
                                </div>
                            </div>
                            <div class="text-center text-xs text-on-surface-variant mt-2 animate-pulse">AI sedang menganalisis kondisi lahan...</div>
                        @elseif($recommendation && collect($recommendation->checklists)->where('kategori', 'hari_ini')->isNotEmpty())
                            @foreach(collect($recommendation->checklists)->where('kategori', 'hari_ini') as $checklist)
                            <div class="flex items-start gap-3 p-3 bg-white rounded-lg border {{ $checklist->is_checked ? 'border-primary/50 bg-primary/5' : 'border-surface-variant' }}">
                                <span class="material-symbols-outlined mt-0.5 {{ $checklist->is_checked ? 'text-primary' : 'text-outline-variant' }}">
                                    {{ $checklist->is_checked ? 'check_box' : 'check_box_outline_blank' }}
                                </span>
                                <div class="flex-1">
                                    <p class="font-body text-body {{ $checklist->is_checked ? 'text-on-surface-variant line-through' : 'text-on-surface' }} font-medium">{{ $checklist->title ?? $checklist->task_title }}</p>
                                    <p class="text-xs text-on-surface-variant">{{ $checklist->detail ?? $checklist->description }}</p>
                                </div>
                                <span class="bg-error-container text-on-error-container text-[10px] font-bold px-2 py-0.5 rounded uppercase">{{ $checklist->priority ?? 'Segera' }}</span>
                            </div>
                            @endforeach
                            <a href="{{ route('ai_reccomendation') }}" class="block text-center text-sm font-semibold text-primary mt-2 hover:underline">
                                Lihat Semua Rekomendasi
                            </a>
                        @else
                            <div class="flex items-start gap-3 p-3 bg-white rounded-lg border border-surface-variant">
                                <span class="material-symbols-outlined mt-1 text-primary">check_circle</span>
                                <div class="flex-1">
                                    <p class="font-body text-body text-on-surface font-medium">Tidak ada aktivitas mendesak</p>
                                    <p class="text-xs text-on-surface-variant">Lahan Anda dalam kondisi aman saat ini.</p>
                                </div>
                            </div>
                            <a href="{{ route('ai_reccomendation') }}" class="block text-center text-sm font-semibold text-primary mt-2 hover:underline">
                                Buka Analisis AI
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN (35%) --}}
            <div class="lg:col-span-4 space-y-6">

                {{-- Ringkasan Lahan --}}
                @if($lahans->isNotEmpty())
                <div class="bg-surface rounded-xl border border-surface-variant p-5 shadow-[0_2px_12px_rgba(27,94,32,0.03)]">
                    <h3 class="font-h3 text-h3 text-on-surface mb-4">Ringkasan Lahan</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center pb-2 border-b border-surface-variant">
                            <span class="text-sm text-on-surface-variant">Total Lahan</span>
                            <span class="text-sm font-bold text-on-surface">{{ $totalLahan }} Area</span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-surface-variant">
                            <span class="text-sm text-on-surface-variant">Total Luas</span>
                            <span class="text-sm font-bold text-on-surface">{{ number_format($totalLuas, 1) }} Ha</span>
                        </div>
                        @if($perluPerhatian > 0)
                        <div class="flex justify-between items-center pb-2 border-b border-surface-variant">
                            <span class="text-sm text-on-surface-variant">Perlu Perhatian</span>
                            <span class="text-sm font-bold text-amber-600">{{ $perluPerhatian }} Lahan</span>
                        </div>
                        @endif
                        @if($estimasiPanen)
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-on-surface-variant">Panen Terdekat</span>
                            <span class="text-sm font-bold text-primary">{{ $estimasiPanen }} Hari</span>
                        </div>
                        @endif
                    </div>
                    <a href="{{ route('manage_lands') }}" class="w-full mt-4 flex items-center justify-center gap-2 py-2.5 bg-surface-container hover:bg-surface-container-high rounded-xl text-sm font-semibold text-on-surface transition-colors">
                        <span class="material-symbols-outlined text-[18px]">agriculture</span>
                        Kelola Lahan
                    </a>
                </div>
                @endif
            </div>
        </div>
    </main>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const needsAi = {{ isset($needsAiGeneration) && $needsAiGeneration ? 'true' : 'false' }};
    const lahanId = '{{ $selectedLahan->id ?? '' }}';
    
    if (needsAi && lahanId) {
        fetch('{{ route("dashboard.generate_ai") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ lahan_id: lahanId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                // Update Skor
                const skor = data.data.skor_kesehatan || null;
                const badgeEl = document.getElementById('ai-skor-badge');
                const valEl = document.getElementById('ai-skor-value');
                
                if (skor !== null) {
                    valEl.innerText = skor;
                    valEl.classList.remove('animate-pulse', 'text-transparent', 'bg-surface-variant', 'rounded');
                    
                    badgeEl.classList.remove('bg-surface-variant', 'text-on-surface-variant', 'animate-pulse');
                    if (skor >= 75) {
                        badgeEl.innerText = 'SANGAT BAIK';
                        badgeEl.classList.add('bg-orange-100', 'text-orange-800');
                    } else if (skor >= 50) {
                        badgeEl.innerText = 'CUKUP BAIK';
                        badgeEl.classList.add('bg-amber-100', 'text-amber-800');
                    } else {
                        badgeEl.innerText = 'KRITIS';
                        badgeEl.classList.add('bg-red-100', 'text-red-800');
                    }
                }
                
                // Update Checklist
                const checklistContainer = document.getElementById('ai-checklist-container');
                const checklists = data.data.checklists || [];
                
                let html = '';
                if (checklists.length > 0) {
                    checklists.forEach(item => {
                        html += `
                        <div class="flex items-start gap-3 p-3 bg-white rounded-lg border ${item.is_completed ? 'border-primary/50 bg-primary/5' : 'border-surface-variant'}">
                            <span class="material-symbols-outlined mt-0.5 ${item.is_completed ? 'text-primary' : 'text-outline-variant'}">
                                ${item.is_completed ? 'check_box' : 'check_box_outline_blank'}
                            </span>
                            <div class="flex-1">
                                <p class="font-body text-body ${item.is_completed ? 'text-on-surface-variant line-through' : 'text-on-surface'} font-medium">${item.task_title}</p>
                                <p class="text-xs text-on-surface-variant">${item.description}</p>
                            </div>
                            <span class="bg-error-container text-on-error-container text-[10px] font-bold px-2 py-0.5 rounded uppercase">${item.priority || 'Segera'}</span>
                        </div>
                        `;
                    });
                    html += `
                        <a href="{{ route('ai_reccomendation') }}" class="block text-center text-sm font-semibold text-primary mt-2 hover:underline">
                            Lihat Semua Rekomendasi
                        </a>
                    `;
                } else {
                    html = `
                    <div class="flex items-start gap-3 p-3 bg-white rounded-lg border border-surface-variant">
                        <span class="material-symbols-outlined mt-1 text-primary">check_circle</span>
                        <div class="flex-1">
                            <p class="font-body text-body text-on-surface font-medium">Tidak ada aktivitas mendesak</p>
                            <p class="text-xs text-on-surface-variant">Lahan Anda dalam kondisi aman saat ini.</p>
                        </div>
                    </div>
                    `;
                }
                checklistContainer.innerHTML = html;
            }
        })
        .catch(error => {
            console.error('Error generating AI:', error);
            // Fallback UI
            document.getElementById('ai-skor-badge').innerText = 'ERROR';
            document.getElementById('ai-skor-badge').classList.remove('animate-pulse');
            document.getElementById('ai-skor-value').innerText = '—';
            document.getElementById('ai-skor-value').classList.remove('animate-pulse', 'text-transparent', 'bg-surface-variant', 'rounded');
            document.getElementById('ai-checklist-container').innerHTML = '<div class="text-center text-sm text-red-500 py-4">Gagal memuat rekomendasi AI.</div>';
        });
    }
});
</script>
@endpush
