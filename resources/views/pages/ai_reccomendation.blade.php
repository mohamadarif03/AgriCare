@extends('layouts.app')

@section('content')
<!-- Main Canvas -->
    <main class="flex-grow w-full max-w-[1600px] mx-auto px-4 xl:px-6 py-6 md:py-8 flex flex-col gap-6">
        <!-- Header -->
        <header class="mb-md">
            <div
                class="inline-flex items-center gap-2 bg-surface-container-low px-3 py-1.5 rounded-full mb-3 border border-outline-variant/30">
                <span class="material-symbols-outlined text-primary text-[18px]"
                    style="font-variation-settings: 'FILL' 0;">eco</span>
                <span class="font-small-label text-small-label text-on-surface-variant">Sawah Cilacap — Padi — Fase
                    Vegetatif</span>
            </div>
            <h2 class="font-h2 text-h2 text-on-background mb-1">Rekomendasi Aksi untuk Lahan Anda</h2>
            <p class="font-body text-body text-on-surface-variant">Diperbarui otomatis setiap hari berdasarkan kondisi
                terkini</p>
        </header>
        <!-- Top Row Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter mb-lg">
            <!-- Left Card: Skor -->
            <div
                class="card-surface rounded-[12px] p-md border border-outline-variant/30 card-shadow flex flex-col relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <span class="material-symbols-outlined text-[64px] text-primary"
                        style="font-variation-settings: 'FILL' 1;">spa</span>
                </div>
                <h3 class="font-h3 text-h3 text-on-surface mb-sm flex items-center gap-2 relative z-10">
                    <span class="material-symbols-outlined text-primary"
                        style="font-variation-settings: 'FILL' 0;">analytics</span>
                    Skor Ketahanan Lahan
                </h3>
                <div class="flex items-center gap-lg mb-md flex-grow">
                    <!-- Ring -->
                    <div class="relative w-24 h-24 shrink-0 flex items-center justify-center">
                        <svg class="w-full h-full transform -rotate-90" viewbox="0 0 100 100">
                            <circle cx="50" cy="50" fill="none" r="45" stroke="#ebf0e5" stroke-width="10"></circle>
                            <circle cx="50" cy="50" fill="none" r="45" stroke="#fdc003" stroke-dasharray="282.7"
                                stroke-dashoffset="107.4" stroke-linecap="round" stroke-width="10"></circle>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-[28px] font-bold text-on-surface leading-none">62</span>
                            <span class="text-[12px] text-on-surface-variant">/100</span>
                        </div>
                    </div>
                    <!-- Breakdown -->
                    <div class="flex-grow space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="text-xs w-20 text-on-surface-variant">Iklim</span>
                            <div class="flex-grow h-1.5 bg-surface-container rounded-full overflow-hidden">
                                <div class="h-full bg-primary" style="width: 70%"></div>
                            </div>
                            <span class="text-xs font-medium w-8 text-right">70%</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs w-20 text-on-surface-variant">Fase Tanam</span>
                            <div class="flex-grow h-1.5 bg-surface-container rounded-full overflow-hidden">
                                <div class="h-full bg-primary" style="width: 65%"></div>
                            </div>
                            <span class="text-xs font-medium w-8 text-right">65%</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs w-20 text-on-surface-variant text-error font-medium">Hama</span>
                            <div class="flex-grow h-1.5 bg-surface-container rounded-full overflow-hidden">
                                <div class="h-full bg-error" style="width: 45%"></div>
                            </div>
                            <span class="text-xs font-medium w-8 text-right text-error">45%</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs w-20 text-on-surface-variant">Pasar</span>
                            <div class="flex-grow h-1.5 bg-surface-container rounded-full overflow-hidden">
                                <div class="h-full bg-primary" style="width: 68%"></div>
                            </div>
                            <span class="text-xs font-medium w-8 text-right">68%</span>
                        </div>
                    </div>
                </div>
                <div class="bg-surface-container-low p-3 rounded-lg flex gap-3 items-start border border-primary/20">
                    <span class="material-symbols-outlined text-primary mt-0.5"
                        style="font-variation-settings: 'FILL' 1;">lightbulb</span>
                    <p class="text-sm text-on-surface font-medium">Fokus pada mitigasi risiko hama minggu ini</p>
                </div>
            </div>
            <!-- Right Card: Kerugian -->
            <div
                class="card-surface rounded-[12px] p-md border border-error/20 card-shadow flex flex-col bg-gradient-to-br from-[#F8FAF8] to-error-container/10">
                <h3 class="font-h3 text-h3 text-on-surface mb-2 flex items-center gap-2">
                    <span class="material-symbols-outlined text-error"
                        style="font-variation-settings: 'FILL' 0;">warning</span>
                    Estimasi Kerugian Jika Tidak Siap
                </h3>
                <div class="mb-4">
                    <div class="text-[40px] font-bold text-error leading-tight tracking-tight">Rp 3.800.000</div>
                    <p class="text-sm text-on-surface-variant flex items-center gap-1">
                        <span>Potensi kerugian panen gagal</span>
                        <span class="w-1 h-1 rounded-full bg-outline mx-1"></span>
                        <span>Total nilai: Rp 12.500.000</span>
                    </p>
                </div>
                <div class="mt-auto space-y-4">
                    <div
                        class="bg-primary-container/10 text-primary-fixed-variant p-3 rounded-lg flex items-center justify-between">
                        <span class="text-sm font-medium">Ikuti rekomendasi → kerugian berkurang 71%</span>
                        <span class="material-symbols-outlined"
                            style="font-variation-settings: 'FILL' 0;">trending_down</span>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-on-surface-variant font-medium">Progres Aksi</span>
                            <span class="text-primary font-bold">4 dari 11 aksi sudah selesai</span>
                        </div>
                        <div class="h-2 w-full bg-surface-variant rounded-full overflow-hidden">
                            <div class="h-full bg-primary rounded-full" style="width: 36%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Recommendations Section -->
        <div class="mb-lg">
            <!-- Tabs -->
            <div class="flex border-b border-surface-variant mb-md overflow-x-auto hide-scrollbar">
                <button
                    class="px-4 py-3 border-b-2 border-primary text-primary font-medium flex items-center gap-2 whitespace-nowrap">
                    <span class="w-2 h-2 rounded-full bg-error"></span>
                    Hari Ini
                </button>
                <button
                    class="px-4 py-3 border-b-2 border-transparent text-on-surface-variant hover:text-on-surface font-medium flex items-center gap-2 whitespace-nowrap transition-colors">
                    <span class="w-2 h-2 rounded-full bg-secondary-container"></span>
                    Minggu Ini
                </button>
                <button
                    class="px-4 py-3 border-b-2 border-transparent text-on-surface-variant hover:text-on-surface font-medium flex items-center gap-2 whitespace-nowrap transition-colors">
                    <span class="w-2 h-2 rounded-full bg-primary"></span>
                    Bulan Ini
                </button>
            </div>
            <!-- Active Tab Content (Hari Ini) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                <!-- Action Card 1 -->
                <div
                    class="card-surface rounded-[12px] p-sm border border-outline-variant/30 card-shadow flex flex-col relative overflow-hidden group hover:border-primary/50 transition-colors">
                    <div class="flex justify-between items-start mb-3">
                        <span
                            class="bg-error-container text-on-error-container text-[10px] font-bold px-2 py-0.5 rounded-full tracking-wider">SEGERA</span>
                        <label class="flex items-center cursor-pointer">
                            <input
                                class="w-5 h-5 rounded border-outline text-primary focus:ring-primary focus:ring-offset-surface"
                                type="checkbox" />
                        </label>
                    </div>
                    <h4 class="font-bold text-on-surface mb-2 leading-tight">Semprot Pestisida Nabati</h4>
                    <p class="text-sm text-on-surface-variant mb-4 flex-grow">Kelembaban tinggi memicu wereng. Semprot
                        campuran daun mimba sore ini sebelum hujan turun.</p>
                    <div
                        class="flex items-center gap-1 text-xs text-on-surface-variant border-t border-surface-variant pt-3">
                        <span class="material-symbols-outlined text-[16px]"
                            style="font-variation-settings: 'FILL' 0;">schedule</span>
                        ±30 menit
                    </div>
                </div>
                <!-- Action Card 2 -->
                <div
                    class="card-surface rounded-[12px] p-sm border border-outline-variant/30 card-shadow flex flex-col relative overflow-hidden group hover:border-primary/50 transition-colors">
                    <div class="flex justify-between items-start mb-3">
                        <span
                            class="bg-error-container text-on-error-container text-[10px] font-bold px-2 py-0.5 rounded-full tracking-wider">SEGERA</span>
                        <label class="flex items-center cursor-pointer">
                            <input
                                class="w-5 h-5 rounded border-outline text-primary focus:ring-primary focus:ring-offset-surface"
                                type="checkbox" />
                        </label>
                    </div>
                    <h4 class="font-bold text-on-surface mb-2 leading-tight">Cek Saluran Irigasi Barat</h4>
                    <p class="text-sm text-on-surface-variant mb-4 flex-grow">Sensor mendeteksi genangan berlebih di
                        sektor barat. Buka pintu air untuk menghindari pembusukan akar.</p>
                    <div
                        class="flex items-center gap-1 text-xs text-on-surface-variant border-t border-surface-variant pt-3">
                        <span class="material-symbols-outlined text-[16px]"
                            style="font-variation-settings: 'FILL' 0;">schedule</span>
                        ±45 menit
                    </div>
                </div>
                <!-- Action Card 3 -->
                <div
                    class="card-surface rounded-[12px] p-sm border border-outline-variant/30 card-shadow flex flex-col relative overflow-hidden group hover:border-primary/50 transition-colors">
                    <div class="flex justify-between items-start mb-3">
                        <span
                            class="bg-error-container text-on-error-container text-[10px] font-bold px-2 py-0.5 rounded-full tracking-wider">SEGERA</span>
                        <label class="flex items-center cursor-pointer">
                            <input
                                class="w-5 h-5 rounded border-outline text-primary focus:ring-primary focus:ring-offset-surface"
                                type="checkbox" />
                        </label>
                    </div>
                    <h4 class="font-bold text-on-surface mb-2 leading-tight">Pembersihan Gulma Tepi</h4>
                    <p class="text-sm text-on-surface-variant mb-4 flex-grow">Satelit melihat pertumbuhan gulma padat di
                        area utara yang bisa menjadi sarang hama tikus.</p>
                    <div
                        class="flex items-center gap-1 text-xs text-on-surface-variant border-t border-surface-variant pt-3">
                        <span class="material-symbols-outlined text-[16px]"
                            style="font-variation-settings: 'FILL' 0;">schedule</span>
                        ±60 menit
                    </div>
                </div>
            </div>
        </div>
        <!-- Bottom Related Sections -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter mb-lg">
            <a class="card-surface rounded-[12px] p-4 border border-outline-variant/30 card-shadow flex items-center justify-between group hover:ambient-shadow transition-all"
                href="#">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-full bg-tertiary-fixed flex items-center justify-center text-tertiary">
                        <span class="material-symbols-outlined"
                            style="font-variation-settings: 'FILL' 0;">bug_report</span>
                    </div>
                    <span class="font-medium text-on-surface">Lihat Prediksi Hama</span>
                </div>
                <span class="material-symbols-outlined text-tertiary group-hover:translate-x-1 transition-transform"
                    style="font-variation-settings: 'FILL' 0;">arrow_forward</span>
            </a>
            <a class="card-surface rounded-[12px] p-4 border border-outline-variant/30 card-shadow flex items-center justify-between group hover:ambient-shadow transition-all"
                href="#">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#ffefc2] flex items-center justify-center text-[#7a5a00]">
                        <span class="material-symbols-outlined"
                            style="font-variation-settings: 'FILL' 0;">monitoring</span>
                    </div>
                    <span class="font-medium text-on-surface">Cek Radar Harga</span>
                </div>
                <span class="material-symbols-outlined text-[#7a5a00] group-hover:translate-x-1 transition-transform"
                    style="font-variation-settings: 'FILL' 0;">arrow_forward</span>
            </a>
        </div>
    </main>
    <!-- Footer -->
    <footer
        class="bg-slate-50 dark:bg-slate-900 font-['Plus_Jakarta_Sans'] text-xs w-full py-12 mt-auto border-t border-slate-200 dark:border-slate-800">
        <div class="flex flex-col md:flex-row justify-between items-center px-8 gap-4 max-w-screen-2xl mx-auto">
            <div class="text-lg font-bold text-green-800 dark:text-green-400">
                TaniSiaga
            </div>
            <div class="text-green-800 dark:text-green-400">
                © 2024 TaniSiaga. Empowering Indonesian Farmers with AI.
            </div>
            <div class="flex flex-wrap gap-4 justify-center">
                <a class="text-slate-500 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300 transition-opacity duration-200"
                    href="#">Privacy Policy</a>
                <a class="text-slate-500 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300 transition-opacity duration-200"
                    href="#">Terms of Service</a>
                <a class="text-slate-500 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300 transition-opacity duration-200"
                    href="#">Help Center</a>
                <a class="text-slate-500 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300 transition-opacity duration-200"
                    href="#">Contact Us</a>
            </div>
        </div>
    </footer>
@endsection
