@extends('layouts.app')

@section('content')
<main class="flex-grow w-full max-w-[1600px] mx-auto px-4 xl:px-6 py-6 md:py-8 flex flex-col gap-6" x-data="recommendationPage()">
    <!-- Header -->
    <header class="mb-md">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                @if($selectedLahan)
                <div class="inline-flex items-center gap-2 bg-surface-container-low px-3 py-1.5 rounded-full mb-3 border border-outline-variant/30">
                    <span class="material-symbols-outlined text-primary text-[18px]" style="font-variation-settings: 'FILL' 0;">eco</span>
                    <span class="font-small-label text-small-label text-on-surface-variant">{{ $selectedLahan->nama }} — {{ ucfirst($selectedLahan->komoditas) }} — {{ $selectedLahan->fase_label }}</span>
                </div>
                @endif
                <h2 class="font-h2 text-h2 text-on-background mb-1">Rekomendasi Aksi untuk Lahan Anda</h2>
                <p class="font-body text-body text-on-surface-variant">Diperbarui otomatis setiap hari berdasarkan kondisi terkini</p>
            </div>
            
            @if($lahans->isNotEmpty())
            <div class="flex items-center gap-3">
                <select id="lahan-selector" class="appearance-none bg-surface text-on-surface text-sm px-4 py-2 pr-8 rounded-lg border border-outline-variant cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary/30" onchange="window.location.href='?lahan='+this.value">
                    @foreach($lahans as $l)
                    <option value="{{ $l->id }}" {{ $selectedLahan && $selectedLahan->id === $l->id ? 'selected' : '' }}>{{ $l->nama }}</option>
                    @endforeach
                </select>
                <button @click="refreshData()" :disabled="isLoading" class="shrink-0 flex items-center gap-1 px-4 py-2 rounded-lg text-sm font-semibold bg-primary text-on-primary hover:opacity-90 transition-opacity disabled:opacity-50">
                    <span class="material-symbols-outlined text-[18px]" :class="{'animate-spin': isLoading}">refresh</span>
                    Refresh AI
                </button>
            </div>
            @endif
        </div>
    </header>

    @if(!$selectedLahan)
    <div class="bg-surface-container-low rounded-xl p-8 text-center border border-outline-variant">
        <span class="material-symbols-outlined text-4xl text-on-surface-variant mb-2">landscape</span>
        <h3 class="text-lg font-bold text-on-surface mb-2">Belum Ada Lahan</h3>
        <p class="text-on-surface-variant mb-4">Tambahkan lahan terlebih dahulu untuk mendapatkan rekomendasi dari AI TaniBot.</p>
        <a href="{{ route('add_land') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-on-primary rounded-lg text-sm font-semibold">
            Tambah Lahan
        </a>
    </div>
    @else

    <!-- Loading Overlay (Visible when generating via JS) -->
    <div x-show="isLoading" class="bg-primary/5 rounded-[12px] p-8 border border-primary/20 text-center flex flex-col items-center justify-center gap-3" style="display: none;">
        <div class="w-10 h-10 border-4 border-primary/30 border-t-primary rounded-full animate-spin"></div>
        <p class="font-medium text-primary">TaniBot sedang menganalisis lahan Anda...</p>
        <p class="text-sm text-on-surface-variant">Memproses data cuaca, fase tanam, harga, dan hama.</p>
    </div>

    <!-- Error State -->
    <div x-show="hasError" class="bg-error-container rounded-[12px] p-8 border border-error/20 text-center" style="display: none;">
        <span class="material-symbols-outlined text-4xl text-error mb-2">error</span>
        <h3 class="text-lg font-bold text-on-error-container mb-2">Gagal Memuat Rekomendasi</h3>
        <p class="text-error mb-4" x-text="errorMessage"></p>
        <button @click="fetchData()" class="px-4 py-2 bg-error text-on-error rounded-lg text-sm font-semibold">Coba Lagi</button>
    </div>

    <!-- Content (Visible when data loaded) -->
    <div x-show="!isLoading && !hasError && data" style="display: none;">
        <!-- Top Row Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter mb-lg">
            <!-- Left Card: Skor -->
            <div class="card-surface rounded-[12px] p-md border border-outline-variant/30 card-shadow flex flex-col relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <span class="material-symbols-outlined text-[64px]" :class="skorColorText" style="font-variation-settings: 'FILL' 1;">spa</span>
                </div>
                <h3 class="font-h3 text-h3 text-on-surface mb-sm flex items-center gap-2 relative z-10">
                    <span class="material-symbols-outlined" :class="skorColorText" style="font-variation-settings: 'FILL' 0;">analytics</span>
                    Skor Ketahanan Lahan
                </h3>
                <div class="flex items-center gap-lg mb-md flex-grow">
                    <!-- Ring -->
                    <div class="relative w-24 h-24 shrink-0 flex items-center justify-center">
                        <svg class="w-full h-full transform -rotate-90" viewbox="0 0 100 100">
                            <circle cx="50" cy="50" fill="none" r="45" stroke="#ebf0e5" stroke-width="10"></circle>
                            <circle cx="50" cy="50" fill="none" r="45" :stroke="skorHex" stroke-dasharray="282.7" :stroke-dashoffset="282.7 - (282.7 * data.skor_ketahanan / 100)" stroke-linecap="round" stroke-width="10" class="transition-all duration-1000"></circle>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-[28px] font-bold text-on-surface leading-none" x-text="data.skor_ketahanan"></span>
                            <span class="text-[12px] text-on-surface-variant">/100</span>
                        </div>
                    </div>
                    <!-- Info Text -->
                    <div class="flex-grow">
                        <p class="text-sm font-medium" :class="skorColorText" x-text="skorText"></p>
                        <p class="text-xs text-on-surface-variant mt-2">Dihitung otomatis berdasarkan kondisi iklim, potensi hama, kesiapan fase tanam, dan tren pasar.</p>
                    </div>
                </div>
                <div class="bg-surface-container-low p-3 rounded-lg flex gap-3 items-start border" :class="'border-'+skorColor+'/20'">
                    <span class="material-symbols-outlined mt-0.5" :class="skorColorText" style="font-variation-settings: 'FILL' 1;">lightbulb</span>
                    <p class="text-sm text-on-surface font-medium">Lengkapi checklist rekomendasi di bawah untuk meningkatkan skor ketahanan.</p>
                </div>
            </div>

            <!-- Right Card: Kerugian -->
            <div class="card-surface rounded-[12px] p-md border border-error/20 card-shadow flex flex-col bg-gradient-to-br from-[#F8FAF8] to-error-container/10">
                <h3 class="font-h3 text-h3 text-on-surface mb-2 flex items-center gap-2">
                    <span class="material-symbols-outlined text-error" style="font-variation-settings: 'FILL' 0;">warning</span>
                    Estimasi Kerugian Jika Diabaikan
                </h3>
                <div class="mb-4">
                    <div class="text-[40px] font-bold text-error leading-tight tracking-tight" x-text="formatRp(data.estimasi_kerugian_rp)"></div>
                    <p class="text-sm text-on-surface-variant flex items-center gap-1">
                        <span>Potensi kerugian panen</span>
                        <span class="w-1 h-1 rounded-full bg-outline mx-1"></span>
                        <span x-text="data.estimasi_kerugian_persen + '% dari total panen'"></span>
                    </p>
                </div>
                <div class="mt-auto space-y-4">
                    <div class="bg-primary-container/10 text-primary-fixed-variant p-3 rounded-lg flex items-center justify-between">
                        <span class="text-sm font-medium">Ikuti rekomendasi → risiko turun drastis</span>
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">trending_down</span>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-on-surface-variant font-medium">Progres Aksi Selesai</span>
                            <span class="text-primary font-bold" x-text="completedCount + ' dari ' + totalCount + ' aksi'"></span>
                        </div>
                        <div class="h-2 w-full bg-surface-variant rounded-full overflow-hidden">
                            <div class="h-full bg-primary rounded-full transition-all duration-500" :style="'width: ' + progressPercent + '%'"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Recommendations Section -->
        <div class="mb-lg">
            <!-- Tabs -->
            <div class="flex border-b border-surface-variant mb-md overflow-x-auto hide-scrollbar">
                <button @click="activeTab = 'hari_ini'" :class="activeTab === 'hari_ini' ? 'border-error text-error font-bold' : 'border-transparent text-on-surface-variant hover:text-on-surface'" class="px-4 py-3 border-b-2 font-medium flex items-center gap-2 whitespace-nowrap transition-colors">
                    <span class="w-2 h-2 rounded-full bg-error"></span>
                    Hari Ini (<span x-text="checklists.hari_ini.length"></span>)
                </button>
                <button @click="activeTab = 'minggu_ini'" :class="activeTab === 'minggu_ini' ? 'border-amber-500 text-amber-600 font-bold' : 'border-transparent text-on-surface-variant hover:text-on-surface'" class="px-4 py-3 border-b-2 font-medium flex items-center gap-2 whitespace-nowrap transition-colors">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    Minggu Ini (<span x-text="checklists.minggu_ini.length"></span>)
                </button>
                <button @click="activeTab = 'bulan_ini'" :class="activeTab === 'bulan_ini' ? 'border-primary text-primary font-bold' : 'border-transparent text-on-surface-variant hover:text-on-surface'" class="px-4 py-3 border-b-2 font-medium flex items-center gap-2 whitespace-nowrap transition-colors">
                    <span class="w-2 h-2 rounded-full bg-primary"></span>
                    Bulan Ini (<span x-text="checklists.bulan_ini.length"></span>)
                </button>
            </div>

            <!-- Tab Content -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                <template x-for="item in activeChecklists" :key="item.id">
                    <div class="card-surface rounded-[12px] p-sm border card-shadow flex flex-col relative overflow-hidden group transition-colors" :class="item.is_checked ? 'border-primary/50 bg-primary/5' : 'border-outline-variant/30 hover:border-primary/50'">
                        <div class="flex justify-between items-start mb-3">
                            <!-- Label -->
                            <span x-show="activeTab === 'hari_ini'" class="bg-error-container text-on-error-container text-[10px] font-bold px-2 py-0.5 rounded-full tracking-wider">SEGERA</span>
                            <span x-show="activeTab === 'minggu_ini'" class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2 py-0.5 rounded-full tracking-wider">PENTING</span>
                            <span x-show="activeTab === 'bulan_ini'" class="bg-primary-container text-on-primary-container text-[10px] font-bold px-2 py-0.5 rounded-full tracking-wider">PERSIAPAN</span>
                            
                            <label class="flex items-center cursor-pointer">
                                <input @change="toggleChecklist(item)" x-model="item.is_checked" class="w-5 h-5 rounded border-outline text-primary focus:ring-primary focus:ring-offset-surface cursor-pointer" type="checkbox" />
                            </label>
                        </div>
                        <h4 class="font-bold text-on-surface mb-2 leading-tight" :class="{'line-through text-on-surface-variant': item.is_checked}" x-text="item.title"></h4>
                        <p class="text-sm text-on-surface-variant mb-4 flex-grow" x-text="item.detail"></p>
                        
                        <div x-show="item.dampak_jika_diabaikan" class="mb-3 text-[11px] text-error bg-error/5 p-2 rounded border border-error/10">
                            <strong>Risiko:</strong> <span x-text="item.dampak_jika_diabaikan"></span>
                        </div>

                        <div class="flex items-center gap-1 text-xs text-on-surface-variant border-t border-surface-variant pt-3">
                            <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 0;">schedule</span>
                            <span x-text="item.estimasi_waktu || 'Tidak diketahui'"></span>
                        </div>
                    </div>
                </template>
                <div x-show="activeChecklists.length === 0" class="col-span-full py-8 text-center text-on-surface-variant bg-surface-container-lowest rounded-xl border border-dashed border-outline-variant">
                    <span class="material-symbols-outlined text-4xl mb-2">task_alt</span>
                    <p>Tidak ada rekomendasi di kategori ini.</p>
                </div>
            </div>
        </div>

        <!-- Bottom Related Sections -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter mb-lg">
            <a class="card-surface rounded-[12px] p-4 border border-outline-variant/30 card-shadow flex items-center justify-between group hover:ambient-shadow transition-all" href="{{ route('pest_detection_alert') }}">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-tertiary-fixed flex items-center justify-center text-tertiary">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">bug_report</span>
                    </div>
                    <span class="font-medium text-on-surface">Lihat Deteksi Hama</span>
                </div>
                <span class="material-symbols-outlined text-tertiary group-hover:translate-x-1 transition-transform" style="font-variation-settings: 'FILL' 0;">arrow_forward</span>
            </a>
            <a class="card-surface rounded-[12px] p-4 border border-outline-variant/30 card-shadow flex items-center justify-between group hover:ambient-shadow transition-all" href="{{ route('market_price') }}">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#ffefc2] flex items-center justify-center text-[#7a5a00]">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">monitoring</span>
                    </div>
                    <span class="font-medium text-on-surface">Cek Radar Harga</span>
                </div>
                <span class="material-symbols-outlined text-[#7a5a00] group-hover:translate-x-1 transition-transform" style="font-variation-settings: 'FILL' 0;">arrow_forward</span>
            </a>
        </div>
    </div>
    @endif
</main>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('recommendationPage', () => ({
            lahanId: {{ $selectedLahan ? $selectedLahan->id : 'null' }},
            data: null,
            checklists: { hari_ini: [], minggu_ini: [], bulan_ini: [] },
            isLoading: false,
            hasError: false,
            errorMessage: '',
            activeTab: 'hari_ini',
            
            // Initial data from controller if available
            init() {
                @if($recommendation)
                    this.processRecommendation(@json($recommendation));
                @else
                    if (this.lahanId) {
                        this.fetchData();
                    }
                @endif
            },

            async fetchData() {
                this.isLoading = true;
                this.hasError = false;
                try {
                    const res = await fetch(`/api/recommendations?lahan_id=${this.lahanId}`);
                    const json = await res.json();
                    if (json.success) {
                        this.processRecommendation(json.data);
                    } else {
                        throw new Error(json.message);
                    }
                } catch (e) {
                    this.hasError = true;
                    this.errorMessage = e.message || 'Terjadi kesalahan saat memuat data.';
                } finally {
                    this.isLoading = false;
                }
            },

            async refreshData() {
                this.isLoading = true;
                this.hasError = false;
                this.data = null; // hide content
                try {
                    const res = await fetch(`/api/recommendations/refresh`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ lahan_id: this.lahanId })
                    });
                    const json = await res.json();
                    if (json.success) {
                        this.processRecommendation(json.data);
                    } else {
                        throw new Error(json.message);
                    }
                } catch (e) {
                    this.hasError = true;
                    this.errorMessage = e.message || 'Terjadi kesalahan saat memuat data.';
                } finally {
                    this.isLoading = false;
                }
            },

            processRecommendation(rec) {
                this.data = rec.data_json;
                
                // Group checklists
                this.checklists = { hari_ini: [], minggu_ini: [], bulan_ini: [] };
                if (rec.checklists) {
                    rec.checklists.forEach(item => {
                        if (this.checklists[item.kategori]) {
                            this.checklists[item.kategori].push(item);
                        }
                    });
                }
            },

            async toggleChecklist(item) {
                try {
                    await fetch('/api/recommendations/checklist', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            checklist_id: item.id,
                            is_checked: item.is_checked
                        })
                    });
                    // Optional: hitung ulang skor atau progress
                } catch (e) {
                    console.error('Failed to toggle checklist', e);
                }
            },

            get activeChecklists() {
                return this.checklists[this.activeTab] || [];
            },

            get skorColor() {
                if (!this.data) return 'primary';
                if (this.data.skor_ketahanan >= 75) return 'primary';
                if (this.data.skor_ketahanan >= 50) return 'amber-500';
                return 'error';
            },

            get skorColorText() {
                if (!this.data) return 'text-primary';
                if (this.data.skor_ketahanan >= 75) return 'text-primary';
                if (this.data.skor_ketahanan >= 50) return 'text-amber-500';
                return 'text-error';
            },

            get skorHex() {
                if (!this.data) return '#0b6b1d';
                if (this.data.skor_ketahanan >= 75) return '#0b6b1d';
                if (this.data.skor_ketahanan >= 50) return '#f59e0b';
                return '#ba1a1a';
            },

            get skorText() {
                if (!this.data) return '';
                if (this.data.skor_ketahanan >= 75) return 'Sangat Baik (Hijau)';
                if (this.data.skor_ketahanan >= 50) return 'Cukup Baik (Kuning)';
                return 'Kritis (Merah)';
            },

            formatRp(angka) {
                return 'Rp ' + Number(angka).toLocaleString('id-ID');
            },

            get completedCount() {
                let count = 0;
                Object.values(this.checklists).forEach(list => {
                    count += list.filter(item => item.is_checked).length;
                });
                return count;
            },

            get totalCount() {
                let count = 0;
                Object.values(this.checklists).forEach(list => {
                    count += list.length;
                });
                return count;
            },

            get progressPercent() {
                if (this.totalCount === 0) return 0;
                return Math.round((this.completedCount / this.totalCount) * 100);
            }
        }));
    });
</script>
@endsection
