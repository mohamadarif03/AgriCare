@extends('layouts.app')

@section('content')
<!-- Main Content -->
    <main class="flex-grow w-full max-w-[1600px] mx-auto px-4 xl:px-6 py-6 md:py-8 flex flex-col gap-6">
        <!-- Header -->
        <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <div>
                <h2 class="font-h2 text-h2 text-on-surface mb-2">Kalender Tanam Cerdas</h2>
                <p class="font-body text-body text-on-surface-variant">Rekomendasi berdasarkan data BMKG + pola historis
                    wilayah.</p>
            </div>
            <div class="relative">
                <select
                    class="appearance-none bg-surface-container-lowest border border-outline-variant text-on-surface py-2 pl-4 pr-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary font-small-label text-small-label cursor-pointer shadow-[0_2px_8px_rgba(27,94,32,0.04)]">
                    <option>Sawah Cilacap — Padi</option>
                    <option>Ladang Bantul — Jagung</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-primary">
                    <span class="material-symbols-outlined text-sm">expand_more</span>
                </div>
            </div>
        </header>
        <!-- AI Recommendation Card -->
        <section
            class="bg-surface-container-low border border-primary-fixed-dim rounded-[12px] p-6 shadow-[0_4px_12px_rgba(27,94,32,0.06)] relative overflow-hidden">
            <!-- Decorative Leaf Pattern -->
            <div class="absolute top-0 right-0 -mt-4 -mr-4 text-primary-fixed opacity-20 pointer-events-none">
                <span class="material-symbols-outlined icon-fill" style="font-size: 120px;">eco</span>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 relative z-10">
                <div class="flex-1">
                    <div
                        class="inline-flex items-center gap-1.5 bg-primary-container text-on-primary-container px-3 py-1 rounded-full mb-4">
                        <span class="material-symbols-outlined text-sm">auto_awesome</span>
                        <span class="font-small-label text-small-label uppercase tracking-wider text-[11px]">Rekomendasi
                            AI TaniSiaga</span>
                    </div>
                    <h3 class="font-h3 text-h3 text-on-surface mb-3">Waktu Tanam Optimal:<br class="hidden md:block" />
                        Minggu ke-2 Oktober 2025</h3>
                    <p class="font-body text-body text-on-surface-variant max-w-2xl">
                        Kondisi curah hujan diprediksi ideal (150-200mm/bulan) dengan probabilitas keberhasilan panen
                        tinggi. Hindari penanaman di bulan Desember karena risiko banjir historis.
                    </p>
                    <div class="mt-6 flex gap-3">
                        <button
                            class="bg-primary text-on-primary px-6 py-2 rounded-full font-small-label text-small-label shadow-[0_4px_8px_rgba(27,94,32,0.15)] hover:bg-surface-tint transition-colors flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">event_available</span> Tetapkan Jadwal
                        </button>
                        <button
                            class="bg-surface-container-lowest text-primary border border-primary px-6 py-2 rounded-full font-small-label text-small-label hover:bg-surface-container-low transition-colors">
                            Lihat Detail
                        </button>
                    </div>
                </div>
                <div
                    class="flex-shrink-0 flex flex-col items-center justify-center bg-surface-container-lowest w-32 h-32 rounded-full border-4 border-primary-container shadow-[0_4px_12px_rgba(27,94,32,0.08)] relative">
                    <svg class="absolute inset-0 w-full h-full -rotate-90" viewbox="0 0 100 100">
                        <circle cx="50" cy="50" fill="none" r="46" stroke="#eef2e7" stroke-width="8"></circle>
                        <circle cx="50" cy="50" fill="none" r="46" stroke="#0b6b1d" stroke-dasharray="289"
                            stroke-dashoffset="52" stroke-linecap="round" stroke-width="8"></circle>
                    </svg>
                    <span class="font-h2 text-h2 text-primary relative z-10">82%</span>
                    <span
                        class="font-small-label text-small-label text-on-surface-variant relative z-10 text-[10px] mt-1">Probabilitas</span>
                </div>
            </div>
        </section>
        <!-- Calendar Grid Area (Bento Layout) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Calendar Grid -->
            <section
                class="lg:col-span-2 bg-surface-container-lowest border border-outline-variant rounded-[12px] p-6 shadow-[0_2px_8px_rgba(27,94,32,0.04)]">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-body text-body font-semibold text-on-surface">Oktober 2025</h3>
                    <div class="flex gap-2">
                        <button
                            class="p-1 rounded text-on-surface-variant hover:bg-surface-container-low transition-colors"><span
                                class="material-symbols-outlined">chevron_left</span></button>
                        <button
                            class="p-1 rounded text-on-surface-variant hover:bg-surface-container-low transition-colors"><span
                                class="material-symbols-outlined">chevron_right</span></button>
                    </div>
                </div>
                <!-- Legend -->
                <div class="flex flex-wrap gap-4 mb-6 text-[11px] font-small-label text-on-surface-variant">
                    <div class="flex items-center gap-1.5">
                        <div class="w-3 h-3 rounded-full bg-primary"></div> Optimal
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div class="w-3 h-3 rounded-full bg-primary-fixed"></div> Baik
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div class="w-3 h-3 rounded-full bg-secondary-container"></div> Hati-hati
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div class="w-3 h-3 rounded-full bg-error-container"></div> Hindari
                    </div>
                </div>
                <div class="grid grid-cols-7 gap-2 text-center">
                    <!-- Days -->
                    <div class="font-small-label text-small-label text-on-surface-variant py-2">Min</div>
                    <div class="font-small-label text-small-label text-on-surface-variant py-2">Sen</div>
                    <div class="font-small-label text-small-label text-on-surface-variant py-2">Sel</div>
                    <div class="font-small-label text-small-label text-on-surface-variant py-2">Rab</div>
                    <div class="font-small-label text-small-label text-on-surface-variant py-2">Kam</div>
                    <div class="font-small-label text-small-label text-on-surface-variant py-2">Jum</div>
                    <div class="font-small-label text-small-label text-on-surface-variant py-2">Sab</div>
                    <!-- Week 1 -->
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-surface-container-high text-on-surface-variant/50 relative">
                        28</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-surface-container-high text-on-surface-variant/50 relative">
                        29</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-surface-container-high text-on-surface-variant/50 relative">
                        30</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-surface-container text-on-surface relative">
                        1</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-surface-container text-on-surface relative">
                        2</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-surface-container text-on-surface relative">
                        3</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-primary-fixed/30 text-on-surface relative border border-primary-fixed/50">
                        4</div>
                    <!-- Week 2 (Optimal) -->
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-primary-fixed/30 text-on-surface relative border border-primary-fixed/50">
                        5</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-primary text-on-primary relative shadow-md">
                        <span class="font-semibold">6</span>
                        <span class="material-symbols-outlined text-[10px] absolute bottom-1">water_drop</span>
                    </div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-primary text-on-primary relative shadow-md">
                        7</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-primary text-on-primary relative shadow-md">
                        <span class="font-semibold">8</span>
                        <span class="material-symbols-outlined text-[10px] absolute bottom-1">potted_plant</span>
                    </div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-primary text-on-primary relative shadow-md">
                        9</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-primary text-on-primary relative shadow-md">
                        10</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-primary text-on-primary relative shadow-md">
                        11</div>
                    <!-- Week 3 -->
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-primary-fixed/30 text-on-surface relative border border-primary-fixed/50">
                        12</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-primary-fixed/30 text-on-surface relative border border-primary-fixed/50">
                        13</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-primary-fixed/30 text-on-surface relative border border-primary-fixed/50">
                        14</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-primary-fixed/30 text-on-surface relative border border-primary-fixed/50">
                        15</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-secondary-container/20 text-on-surface relative border border-secondary-container/30">
                        16</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-secondary-container/20 text-on-surface relative border border-secondary-container/30">
                        17</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-secondary-container/20 text-on-surface relative border border-secondary-container/30">
                        18</div>
                    <!-- Week 4 -->
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-secondary-container/20 text-on-surface relative border border-secondary-container/30">
                        19</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-error-container/40 text-on-surface relative border border-error-container/50">
                        20</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-error-container/40 text-on-surface relative border border-error-container/50">
                        21</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-error-container/40 text-on-surface relative border border-error-container/50">
                        22</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-error-container/40 text-on-surface relative border border-error-container/50">
                        23</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-error-container/40 text-on-surface relative border border-error-container/50">
                        24</div>
                    <div
                        class="aspect-square flex flex-col justify-center items-center rounded-lg bg-error-container/40 text-on-surface relative border border-error-container/50">
                        25</div>
                </div>
            </section>
            <!-- Sidebar Info -->
            <div class="flex flex-col gap-6">
                <!-- Timeline/Phases -->
                <section
                    class="bg-surface-container-lowest border border-outline-variant rounded-[12px] p-6 shadow-[0_2px_8px_rgba(27,94,32,0.04)] flex-grow">
                    <h3 class="font-body text-body font-semibold text-on-surface mb-4">Fase Pertumbuhan</h3>
                    <div class="relative pl-6 border-l-2 border-surface-container-highest space-y-6">
                        <div class="relative">
                            <div
                                class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-primary border-4 border-surface-container-lowest">
                            </div>
                            <h4
                                class="font-small-label text-small-label text-on-surface font-semibold mb-1 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm text-primary">water_drop</span>
                                Persemaian
                            </h4>
                            <p class="text-[12px] text-on-surface-variant">1 - 20 Okt (20 Hari)</p>
                        </div>
                        <div class="relative">
                            <div
                                class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-primary border-4 border-surface-container-lowest">
                            </div>
                            <h4
                                class="font-small-label text-small-label text-on-surface font-semibold mb-1 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm text-primary">potted_plant</span> Tanam
                            </h4>
                            <p class="text-[12px] text-on-surface-variant">21 - 25 Okt (5 Hari)</p>
                        </div>
                        <div class="relative opacity-60">
                            <div
                                class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-outline-variant border-4 border-surface-container-lowest">
                            </div>
                            <h4
                                class="font-small-label text-small-label text-on-surface font-semibold mb-1 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">grass</span> Vegetatif
                            </h4>
                            <p class="text-[12px] text-on-surface-variant">Nov - Des</p>
                        </div>
                        <div class="relative opacity-60">
                            <div
                                class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-outline-variant border-4 border-surface-container-lowest">
                            </div>
                            <h4
                                class="font-small-label text-small-label text-on-surface font-semibold mb-1 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">spa</span> Generatif
                            </h4>
                            <p class="text-[12px] text-on-surface-variant">Jan 2026</p>
                        </div>
                        <div class="relative opacity-60">
                            <div
                                class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-outline-variant border-4 border-surface-container-lowest">
                            </div>
                            <h4
                                class="font-small-label text-small-label text-on-surface font-semibold mb-1 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">agriculture</span> Panen
                            </h4>
                            <p class="text-[12px] text-on-surface-variant">Feb 2026</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- Annual Probability Chart -->
        <section
            class="bg-surface-container-lowest border border-outline-variant rounded-[12px] p-6 shadow-[0_2px_8px_rgba(27,94,32,0.04)]">
            <h3 class="font-body text-body font-semibold text-on-surface mb-6">Tren Probabilitas Sukses 12 Bulan</h3>
            <div class="flex items-end gap-2 h-40 mt-4 relative">
                <!-- Y-axis labels -->
                <div
                    class="absolute left-0 top-0 bottom-0 flex flex-col justify-between text-[10px] text-on-surface-variant w-8 -ml-8">
                    <span>100%</span>
                    <span>50%</span>
                    <span>0%</span>
                </div>
                <!-- Grid lines -->
                <div class="absolute left-0 right-0 top-0 border-t border-dashed border-outline-variant/30"></div>
                <div class="absolute left-0 right-0 top-1/2 border-t border-dashed border-outline-variant/30"></div>
                <div class="absolute left-0 right-0 bottom-0 border-t border-solid border-outline-variant"></div>
                <!-- Bars -->
                <div class="flex-1 flex flex-col justify-end group">
                    <div
                        class="w-full bg-surface-container-highest rounded-t-sm h-[40%] group-hover:bg-primary-fixed/50 transition-colors">
                    </div>
                </div>
                <div class="flex-1 flex flex-col justify-end group">
                    <div
                        class="w-full bg-surface-container-highest rounded-t-sm h-[45%] group-hover:bg-primary-fixed/50 transition-colors">
                    </div>
                </div>
                <div class="flex-1 flex flex-col justify-end group">
                    <div
                        class="w-full bg-surface-container-highest rounded-t-sm h-[60%] group-hover:bg-primary-fixed/50 transition-colors">
                    </div>
                </div>
                <div class="flex-1 flex flex-col justify-end group">
                    <div
                        class="w-full bg-surface-container-highest rounded-t-sm h-[55%] group-hover:bg-primary-fixed/50 transition-colors">
                    </div>
                </div>
                <div class="flex-1 flex flex-col justify-end group">
                    <div
                        class="w-full bg-surface-container-highest rounded-t-sm h-[65%] group-hover:bg-primary-fixed/50 transition-colors">
                    </div>
                </div>
                <div class="flex-1 flex flex-col justify-end group">
                    <div
                        class="w-full bg-surface-container-highest rounded-t-sm h-[75%] group-hover:bg-primary-fixed/50 transition-colors">
                    </div>
                </div>
                <div class="flex-1 flex flex-col justify-end group">
                    <div
                        class="w-full bg-primary-fixed rounded-t-sm h-[85%] group-hover:bg-primary-fixed-dim transition-colors">
                    </div>
                </div>
                <div class="flex-1 flex flex-col justify-end group">
                    <div
                        class="w-full bg-primary-fixed rounded-t-sm h-[80%] group-hover:bg-primary-fixed-dim transition-colors">
                    </div>
                </div>
                <div class="flex-1 flex flex-col justify-end group relative">
                    <span
                        class="material-symbols-outlined text-secondary-container icon-fill absolute -top-6 left-1/2 -translate-x-1/2 text-sm drop-shadow-sm">star</span>
                    <div class="w-full bg-primary rounded-t-sm h-[92%]"></div>
                </div>
                <div class="flex-1 flex flex-col justify-end group">
                    <div
                        class="w-full bg-primary-fixed rounded-t-sm h-[70%] group-hover:bg-primary-fixed-dim transition-colors">
                    </div>
                </div>
                <div class="flex-1 flex flex-col justify-end group">
                    <div
                        class="w-full bg-surface-container-highest rounded-t-sm h-[40%] group-hover:bg-primary-fixed/50 transition-colors">
                    </div>
                </div>
                <div class="flex-1 flex flex-col justify-end group">
                    <div
                        class="w-full bg-error-container/50 rounded-t-sm h-[20%] group-hover:bg-error-container transition-colors">
                    </div>
                </div>
            </div>
            <div class="flex justify-between mt-3 text-[10px] font-small-label text-on-surface-variant font-medium">
                <div class="flex-1 text-center">Feb</div>
                <div class="flex-1 text-center">Mar</div>
                <div class="flex-1 text-center">Apr</div>
                <div class="flex-1 text-center">Mei</div>
                <div class="flex-1 text-center">Jun</div>
                <div class="flex-1 text-center">Jul</div>
                <div class="flex-1 text-center">Ags</div>
                <div class="flex-1 text-center">Sep</div>
                <div class="flex-1 text-center font-bold text-primary">Okt</div>
                <div class="flex-1 text-center">Nov</div>
                <div class="flex-1 text-center">Des</div>
                <div class="flex-1 text-center">Jan</div>
            </div>
        </section>
    </main>
    <!-- Footer -->
    <footer class="bg-slate-50 dark:bg-slate-950 border-t border-green-100 dark:border-slate-800 w-full mt-auto">
        <div class="flex flex-col md:flex-row justify-between items-center py-10 px-6 gap-6 max-w-7xl mx-auto">
            <div class="text-lg font-bold text-green-800 dark:text-green-400">TaniSiaga</div>
            <div
                class="font-plus-jakarta text-xs md:text-sm font-normal text-slate-500 dark:text-slate-500 opacity-90 hover:opacity-100 transition-opacity">
                © 2024 TaniSiaga. Guardian of the Harvest.</div>
            <div class="flex gap-4">
                <a class="font-plus-jakarta text-xs md:text-sm font-normal text-slate-500 dark:text-slate-500 hover:text-green-600 dark:hover:text-green-300 hover:underline"
                    href="#">Privacy Policy</a>
                <a class="font-plus-jakarta text-xs md:text-sm font-normal text-slate-500 dark:text-slate-500 hover:text-green-600 dark:hover:text-green-300 hover:underline"
                    href="#">Terms of Service</a>
                <a class="font-plus-jakarta text-xs md:text-sm font-normal text-slate-500 dark:text-slate-500 hover:text-green-600 dark:hover:text-green-300 hover:underline"
                    href="#">Help Center</a>
                <a class="font-plus-jakarta text-xs md:text-sm font-normal text-slate-500 dark:text-slate-500 hover:text-green-600 dark:hover:text-green-300 hover:underline"
                    href="#">Community Guidelines</a>
            </div>
        </div>
    </footer>
@endsection
