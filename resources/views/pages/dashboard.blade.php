@extends('layouts.app')

@section('content')
<!-- Main Content Container -->
    <main class="flex-grow w-full max-w-[1600px] mx-auto px-4 xl:px-6 py-6 md:py-8 flex flex-col gap-6">
        <!-- Alert Banner -->
        <div
            class="bg-[#FFF8E1] border-l-4 border-amber-500 rounded-r-lg p-4 flex items-start gap-3 shadow-[0_4px_12px_rgba(27,94,32,0.02)]">
            <span class="material-symbols-outlined text-amber-600" data-icon="warning">warning</span>
            <div class="flex-1">
                <p class="font-body text-body text-amber-900">
                    <strong>Waspada:</strong> Curah hujan tinggi diprediksi 3 hari ke depan. Risiko blast pada fase
                    anakan padi Anda.
                </p>
                <a class="inline-flex items-center mt-2 text-sm font-semibold text-amber-700 hover:text-amber-800"
                    href="#">
                    Lihat Rekomendasi <span class="material-symbols-outlined ml-1 text-sm"
                        data-icon="arrow_forward">arrow_forward</span>
                </a>
            </div>
        </div>
        <!-- Top Metrics (Bento Grid) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Metric 1 -->
            <div class="bg-surface rounded-xl p-5 border border-surface-variant shadow-[0_2px_8px_rgba(27,94,32,0.04)]">
                <div class="flex justify-between items-start mb-2">
                    <span class="font-small-label text-small-label text-on-surface-variant">Indeks Risiko Lahan</span>
                    <span
                        class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wide">WASPADA</span>
                </div>
                <div class="flex items-end gap-2">
                    <span class="font-h2 text-h2 text-on-surface">58</span><span
                        class="text-sm text-on-surface-variant mb-1">/100</span>
                </div>
                <div class="mt-3 flex items-center justify-between text-xs text-on-surface-variant">
                    <span>Sawah Cilacap</span>
                    <span>5 menit lalu</span>
                </div>
            </div>
            <!-- Metric 2 -->
            <div class="bg-surface rounded-xl p-5 border border-surface-variant shadow-[0_2px_8px_rgba(27,94,32,0.04)]">
                <div class="flex justify-between items-start mb-2">
                    <span class="font-small-label text-small-label text-on-surface-variant">Cuaca Hari Ini</span>
                    <div class="flex items-center gap-1 bg-surface-container-low px-2 py-0.5 rounded text-[10px] font-medium text-on-surface-variant">
                        <span class="material-symbols-outlined text-[12px] text-primary" data-icon="location_on">location_on</span>
                        Cilacap
                    </div>
                </div>
                <div class="flex justify-between items-end mt-1">
                    <div>
                        <div class="font-h2 text-h2 text-on-surface leading-none">28°C</div>
                        <div class="text-sm font-medium text-on-surface mt-1">Berawan</div>
                    </div>
                    <span class="material-symbols-outlined text-primary text-4xl leading-none" data-icon="rainy">rainy</span>
                </div>
                <div class="mt-3 pt-3 border-t border-surface-variant flex justify-between items-center text-xs text-on-surface-variant">
                    <span>Hujan sore</span>
                    <div class="flex gap-2 font-medium">
                        <span>💧 82%</span>
                        <span>💨 12km/h</span>
                    </div>
                </div>
            </div>
            <!-- Metric 3 -->
            <div class="bg-surface rounded-xl p-5 border border-surface-variant shadow-[0_2px_8px_rgba(27,94,32,0.04)]">
                <div class="flex justify-between items-start mb-2">
                    <span class="font-small-label text-small-label text-on-surface-variant">Fase Tanam</span>
                    <span class="material-symbols-outlined text-primary" data-icon="eco">eco</span>
                </div>
                <div class="font-body text-body font-medium text-on-surface mt-1">Fase Vegetatif</div>
                <div class="text-sm text-on-surface-variant">Minggu ke-4</div>
                <div class="w-full bg-surface-container-highest rounded-full h-1.5 mt-3">
                    <div class="bg-primary h-1.5 rounded-full" style="width: 45%"></div>
                </div>
                <div class="mt-2 text-xs text-primary font-medium text-right">42 hari lagi panen</div>
            </div>
            <!-- Metric 4 -->
            <div class="bg-surface rounded-xl p-5 border border-surface-variant shadow-[0_2px_8px_rgba(27,94,32,0.04)]">
                <div class="flex justify-between items-start mb-2">
                    <span class="font-small-label text-small-label text-on-surface-variant">Harga Padi Hari Ini</span>
                    <span class="material-symbols-outlined text-green-600" data-icon="trending_up">trending_up</span>
                </div>
                <div class="font-h2 text-h2 text-on-surface">Rp 5.200<span
                        class="text-sm font-normal text-on-surface-variant">/kg</span></div>
                <div class="flex items-center gap-1 mt-1 text-sm font-medium text-green-600">
                    <span class="material-symbols-outlined text-sm" data-icon="arrow_upward">arrow_upward</span> +3.2%
                </div>
                <div
                    class="mt-3 text-xs text-on-surface-variant bg-surface-container-low px-2 py-1 rounded inline-block">
                    Waktu jual: <strong>Tahan dulu</strong>
                </div>
            </div>
        </div>
        <!-- Main Content 2 Columns -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- LEFT COLUMN (65%) -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Prakiraan 7 Hari -->
                <div
                    class="bg-surface rounded-xl border border-surface-variant p-5 shadow-[0_2px_12px_rgba(27,94,32,0.03)]">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-h3 text-h3 text-on-surface">Prakiraan 7 Hari</h3>
                        <div class="flex items-center gap-1.5 px-3 py-1 bg-surface-container-low rounded-full border border-outline-variant">
                            <span class="material-symbols-outlined text-primary text-[16px]" data-icon="location_on">location_on</span>
                            <span class="text-xs font-medium text-on-surface-variant">Cilacap, Jawa Tengah</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3">
                        <!-- Day Items -->
                        <div
                            class="flex flex-col items-center bg-surface-container-low rounded-xl p-3 border border-outline-variant hover:border-primary hover:bg-surface transition-all cursor-pointer">
                            <span class="text-xs font-semibold text-on-surface mb-1">Sen</span>
                            <span class="material-symbols-outlined text-amber-500 mb-1 text-2xl"
                                data-icon="partly_cloudy_day">partly_cloudy_day</span>
                            <span class="text-sm font-bold text-on-surface">29°</span>
                            <div class="w-1.5 h-1.5 rounded-full bg-green-500 mt-2"></div>
                        </div>
                        <div
                            class="flex flex-col items-center bg-surface-container-low rounded-xl p-3 border border-outline-variant hover:border-primary hover:bg-surface transition-all cursor-pointer">
                            <span class="text-xs font-semibold text-on-surface mb-1">Sel</span>
                            <span class="material-symbols-outlined text-primary mb-1 text-2xl" data-icon="rainy">rainy</span>
                            <span class="text-sm font-bold text-on-surface">27°</span>
                            <div class="w-1.5 h-1.5 rounded-full bg-amber-500 mt-2"></div>
                        </div>
                        <div
                            class="flex flex-col items-center bg-surface-container-low rounded-xl p-3 border border-outline-variant hover:border-primary hover:bg-surface transition-all cursor-pointer">
                            <span class="text-xs font-semibold text-on-surface mb-1">Rab</span>
                            <span class="material-symbols-outlined text-primary mb-1 text-2xl"
                                data-icon="thunderstorm">thunderstorm</span>
                            <span class="text-sm font-bold text-on-surface">26°</span>
                            <div class="w-1.5 h-1.5 rounded-full bg-red-500 mt-2"></div>
                        </div>
                        <div
                            class="flex flex-col items-center bg-surface-container-low rounded-xl p-3 border border-outline-variant hover:border-primary hover:bg-surface transition-all cursor-pointer">
                            <span class="text-xs font-semibold text-on-surface mb-1">Kam</span>
                            <span class="material-symbols-outlined text-amber-500 mb-1 text-2xl" data-icon="cloudy">cloudy</span>
                            <span class="text-sm font-bold text-on-surface">28°</span>
                            <div class="w-1.5 h-1.5 rounded-full bg-amber-500 mt-2"></div>
                        </div>
                        <div
                            class="flex flex-col items-center bg-surface-container-low rounded-xl p-3 border border-outline-variant hover:border-primary hover:bg-surface transition-all cursor-pointer">
                            <span class="text-xs font-semibold text-on-surface mb-1">Jum</span>
                            <span class="material-symbols-outlined text-amber-500 mb-1 text-2xl" data-icon="sunny">sunny</span>
                            <span class="text-sm font-bold text-on-surface">31°</span>
                            <div class="w-1.5 h-1.5 rounded-full bg-green-500 mt-2"></div>
                        </div>
                        <div
                            class="flex flex-col items-center bg-surface-container-low rounded-xl p-3 border border-outline-variant hover:border-primary hover:bg-surface transition-all cursor-pointer">
                            <span class="text-xs font-semibold text-on-surface mb-1">Sab</span>
                            <span class="material-symbols-outlined text-amber-500 mb-1 text-2xl" data-icon="sunny">sunny</span>
                            <span class="text-sm font-bold text-on-surface">32°</span>
                            <div class="w-1.5 h-1.5 rounded-full bg-green-500 mt-2"></div>
                        </div>
                        <div
                            class="flex flex-col items-center bg-surface-container-low rounded-xl p-3 border border-outline-variant hover:border-primary hover:bg-surface transition-all cursor-pointer">
                            <span class="text-xs font-semibold text-on-surface mb-1">Min</span>
                            <span class="material-symbols-outlined text-amber-500 mb-1 text-2xl"
                                data-icon="partly_cloudy_day">partly_cloudy_day</span>
                            <span class="text-sm font-bold text-on-surface">30°</span>
                            <div class="w-1.5 h-1.5 rounded-full bg-green-500 mt-2"></div>
                        </div>
                    </div>
                </div>
                <!-- Aktivitas Hari Ini -->
                <div
                    class="bg-surface rounded-xl border border-surface-variant p-5 shadow-[0_2px_12px_rgba(27,94,32,0.03)] relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <span class="material-symbols-outlined text-6xl text-primary"
                            data-icon="psychiatry">psychiatry</span>
                    </div>
                    <div class="flex justify-between items-center mb-4 relative z-10">
                        <h3 class="font-h3 text-h3 text-on-surface">Aktivitas Hari Ini</h3>
                        <span
                            class="text-[10px] font-bold bg-primary-container text-on-primary-container px-2 py-1 rounded-md">Powered
                            by TaniBot AI</span>
                    </div>
                    <div class="space-y-3 relative z-10">
                        <div class="flex items-start gap-3 p-3 bg-white rounded-lg border border-surface-variant">
                            <input class="mt-1 rounded text-primary focus:ring-primary border-outline-variant"
                                type="checkbox" />
                            <div class="flex-1">
                                <p class="font-body text-body text-on-surface font-medium">Cek saluran irigasi</p>
                                <p class="text-xs text-on-surface-variant">Antisipasi hujan deras sore nanti.</p>
                            </div>
                            <span
                                class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Tinggi</span>
                        </div>
                        <div class="flex items-start gap-3 p-3 bg-white rounded-lg border border-surface-variant">
                            <input class="mt-1 rounded text-primary focus:ring-primary border-outline-variant"
                                type="checkbox" />
                            <div class="flex-1">
                                <p class="font-body text-body text-on-surface font-medium">Siapkan pupuk urea</p>
                                <p class="text-xs text-on-surface-variant">Jadwal pemupukan tahap 2 dalam 3 hari.</p>
                            </div>
                            <span
                                class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Sedang</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- RIGHT COLUMN (35%) -->
            <div class="lg:col-span-4 space-y-6">

                <!-- Harga Komoditas -->
                <div
                    class="bg-surface rounded-xl border border-surface-variant p-5 shadow-[0_2px_12px_rgba(27,94,32,0.03)]">
                    <h3 class="font-h3 text-h3 text-on-surface mb-4">Harga Komoditas</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center pb-2 border-b border-surface-variant">
                            <span class="text-sm font-medium text-on-surface">Padi</span>
                            <div class="text-right">
                                <div class="text-sm font-bold text-on-surface">Rp 5.200</div>
                                <div class="text-[10px] text-green-600 flex items-center justify-end gap-0.5"><span
                                        class="material-symbols-outlined text-[10px]"
                                        data-icon="arrow_upward">arrow_upward</span> +3.2%</div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-surface-variant">
                            <span class="text-sm font-medium text-on-surface">Jagung</span>
                            <div class="text-right">
                                <div class="text-sm font-bold text-on-surface">Rp 4.800</div>
                                <div class="text-[10px] text-red-600 flex items-center justify-end gap-0.5"><span
                                        class="material-symbols-outlined text-[10px]"
                                        data-icon="arrow_downward">arrow_downward</span> -1.5%</div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-on-surface">Cabai</span>
                            <div class="text-right">
                                <div class="text-sm font-bold text-on-surface">Rp 45.000</div>
                                <div class="text-[10px] text-green-600 flex items-center justify-end gap-0.5"><span
                                        class="material-symbols-outlined text-[10px]"
                                        data-icon="arrow_upward">arrow_upward</span> +5.0%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
@endsection
