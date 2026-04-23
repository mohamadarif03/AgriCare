@extends('layouts.app')

@section('content')
<!-- Main Content Canvas -->
    <main class="flex-grow w-full max-w-[1600px] mx-auto px-4 xl:px-6 py-6 md:py-8 flex flex-col gap-6">
        <!-- Hero Upload Section -->
        <section class="flex flex-col gap-sm">
            <div class="text-center md:text-left mb-sm">
                <h1 class="font-h1 text-h1 text-primary">Deteksi Penyakit Tanaman Anda</h1>
                <p class="font-body text-body text-on-surface-variant max-w-2xl mt-xs">Unggah foto daun yang sakit atau
                    hama yang ditemukan. AI kami akan mengidentifikasi ancaman dan memberikan rekomendasi penanganan
                    secara instan.</p>
            </div>
            <div
                class="bg-surface-container-lowest rounded-xl border-2 border-dashed border-primary p-lg flex flex-col items-center justify-center text-center gap-md hover:bg-surface-container-low transition-colors duration-300 cursor-pointer group shadow-[0_4px_16px_rgba(27,94,32,0.04)]">
                <div
                    class="w-20 h-20 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center group-hover:scale-105 transition-transform duration-300 shadow-[0_4px_12px_rgba(27,94,32,0.15)]">
                    <span class="material-symbols-outlined text-4xl" data-weight="fill"
                        style="font-variation-settings: 'FILL' 1;">add_a_photo</span>
                </div>
                <div>
                    <p class="font-h3 text-h3 text-primary mb-xs">Tarik &amp; Lepas Foto Di Sini</p>
                    <p class="font-body text-body text-on-surface-variant">atau</p>
                </div>
                <button
                    class="bg-primary text-on-primary px-8 py-3 rounded-full font-small-label text-small-label hover:bg-surface-tint transition-colors duration-200 active:scale-95 shadow-[0_4px_12px_rgba(27,94,32,0.15)] flex items-center gap-2">
                    <span class="material-symbols-outlined">upload</span> Ambil Foto / Upload Gambar
                </button>
                <p class="font-small-label text-small-label text-outline mt-xs">Mendukung format JPG, PNG. Maksimal
                    10MB.</p>
            </div>
        </section>
        <!-- Demo Result Bento Card -->
        <section class="grid grid-cols-1 md:grid-cols-12 gap-gutter">
            <div class="col-span-1 md:col-span-12">
                <h2 class="font-h2 text-h2 text-on-surface mb-md">Hasil Analisis Terkini</h2>
            </div>
            <div
                class="col-span-1 md:col-span-4 bg-surface-container-lowest rounded-xl border border-surface-variant overflow-hidden shadow-[0_2px_8px_rgba(27,94,32,0.04)] flex flex-col">
                <div class="h-48 w-full bg-surface-container-high relative">
                    <img alt="Rice leaf blast" class="w-full h-full object-cover"
                        data-alt="Close up of a rice leaf showing distinct diamond-shaped brown lesions typical of rice blast disease against a blurred green background"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBSrQl8JGr6azHtpphmgiN_H8r4LggQwEaqnBIlUM9otG0IHFw7yzUcfk4WG2wp5gv9NC52V_jUQJnOHlIC0x6FtrW8-y-z6OKLTua58N88zcdM5T0MoyEruwtGg025nQoUmxlm1H-Q87S0lEPOO29OuX_NR8vKuzsO2J_FlBTIGXuKpY6iN6Lf_ytSA1fgPPWBsQMFY17h0GVJoy-SFhK6CxgutYnu0LCnSwp2risaw--cyKmS6V5jNzye56GEXmgEWBf8Fwn77-o" />
                    <div
                        class="absolute top-4 right-4 bg-surface-container-lowest/90 backdrop-blur px-3 py-1 rounded-full flex items-center gap-2 shadow-sm">
                        <span class="material-symbols-outlined text-primary text-sm">verified</span>
                        <span class="font-small-label text-small-label text-primary">AI Terverifikasi</span>
                    </div>
                </div>
                <div class="p-md flex flex-col gap-sm flex-grow">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-h3 text-h3 text-on-surface">Blast Padi</h3>
                            <p class="font-body text-body text-on-surface-variant italic">Pyricularia oryzae</p>
                        </div>
                        <div
                            class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">warning</span>
                            <span class="font-small-label text-small-label">SEDANG</span>
                        </div>
                    </div>
                    <div class="w-full bg-surface-variant rounded-full h-2 mt-2">
                        <div class="bg-primary h-2 rounded-full" style="width: 94%"></div>
                    </div>
                    <p class="font-small-label text-small-label text-outline text-right">Tingkat Kepercayaan: 94%</p>
                </div>
            </div>
            <div
                class="col-span-1 md:col-span-8 bg-surface-container-lowest rounded-xl border border-surface-variant p-md shadow-[0_2px_8px_rgba(27,94,32,0.04)] flex flex-col justify-between">
                <div>
                    <h3 class="font-h3 text-h3 text-primary mb-sm flex items-center gap-2">
                        <span class="material-symbols-outlined">health_and_safety</span> Rekomendasi Penanganan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-md mt-md">
                        <div
                            class="bg-surface-bright rounded-lg p-sm border border-surface-variant relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-2 opacity-10">
                                <span class="material-symbols-outlined text-4xl text-primary">flash_on</span>
                            </div>
                            <h4 class="font-small-label text-small-label text-on-surface font-bold mb-xs">Tindakan
                                Segera (Immediate)</h4>
                            <ul class="font-body text-body text-on-surface-variant list-disc pl-5 space-y-1">
                                <li>Aplikasikan fungisida berbahan aktif trisiklazol atau benomil.</li>
                                <li>Kurangi pemberian pupuk Nitrogen (Urea) sementara waktu.</li>
                                <li>Pastikan sirkulasi air mengalir dengan baik.</li>
                            </ul>
                        </div>
                        <div
                            class="bg-surface-bright rounded-lg p-sm border border-surface-variant relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-2 opacity-10">
                                <span class="material-symbols-outlined text-4xl text-primary">shield</span>
                            </div>
                            <h4 class="font-small-label text-small-label text-on-surface font-bold mb-xs">Pencegahan
                                (Prevention)</h4>
                            <ul class="font-body text-body text-on-surface-variant list-disc pl-5 space-y-1">
                                <li>Gunakan varietas padi yang lebih tahan (misal: Inpari).</li>
                                <li>Jaga jarak tanam agar sirkulasi udara lebih optimal.</li>
                                <li>Bersihkan gulma di sekitar pematang sawah.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mt-md pt-sm border-t border-surface-variant flex justify-end">
                    <button
                        class="bg-surface-container-low text-primary border border-primary px-6 py-2 rounded-full font-small-label text-small-label hover:bg-primary hover:text-on-primary transition-colors duration-200 flex items-center gap-2">
                        <span class="material-symbols-outlined">forum</span> Konsultasi dengan TaniBot
                    </button>
                </div>
            </div>
        </section>
        <!-- Threat Prediction Section -->
        <section class="flex flex-col gap-md">
            <div class="flex justify-between items-end">
                <h2 class="font-h2 text-h2 text-on-surface">Prediksi Hama Minggu Ini</h2>
                <a class="font-small-label text-small-label text-primary hover:underline flex items-center"
                    href="#">Lihat Semua <span class="material-symbols-outlined text-sm">chevron_right</span></a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                <!-- Card 1 -->
                <div
                    class="bg-surface-container-lowest rounded-xl border border-surface-variant p-md shadow-[0_2px_8px_rgba(27,94,32,0.04)] relative overflow-hidden group">
                    <div
                        class="absolute -top-6 -right-6 text-tertiary/5 group-hover:scale-110 transition-transform duration-500">
                        <span class="material-symbols-outlined text-9xl">bug_report</span>
                    </div>
                    <div class="flex justify-between items-start mb-sm relative z-10">
                        <div
                            class="bg-tertiary-container text-on-tertiary-container px-3 py-1 rounded-full flex items-center gap-1 w-max">
                            <span class="material-symbols-outlined text-sm">emergency</span>
                            <span class="font-small-label text-small-label">WASPADA</span>
                        </div>
                        <span class="material-symbols-outlined text-on-surface-variant">trending_up</span>
                    </div>
                    <h3 class="font-h3 text-h3 text-on-surface relative z-10">Wereng Cokelat</h3>
                    <p class="font-body text-body text-on-surface-variant mt-xs relative z-10">Lonjakan populasi
                        terdeteksi di area sekitar akibat kelembapan tinggi.</p>
                </div>
                <!-- Card 2 -->
                <div
                    class="bg-surface-container-lowest rounded-xl border border-surface-variant p-md shadow-[0_2px_8px_rgba(27,94,32,0.04)] relative overflow-hidden group">
                    <div
                        class="absolute -top-6 -right-6 text-secondary/5 group-hover:scale-110 transition-transform duration-500">
                        <span class="material-symbols-outlined text-9xl">pest_control</span>
                    </div>
                    <div class="flex justify-between items-start mb-sm relative z-10">
                        <div
                            class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full flex items-center gap-1 w-max">
                            <span class="material-symbols-outlined text-sm">visibility</span>
                            <span class="font-small-label text-small-label">PANTAU</span>
                        </div>
                        <span class="material-symbols-outlined text-on-surface-variant">trending_flat</span>
                    </div>
                    <h3 class="font-h3 text-h3 text-on-surface relative z-10">Penggerek Batang</h3>
                    <p class="font-body text-body text-on-surface-variant mt-xs relative z-10">Aktivitas sedang
                        terpantau pada fase vegetatif padi.</p>
                </div>
                <!-- Card 3 -->
                <div
                    class="bg-surface-container-lowest rounded-xl border border-surface-variant p-md shadow-[0_2px_8px_rgba(27,94,32,0.04)] relative overflow-hidden group">
                    <div
                        class="absolute -top-6 -right-6 text-primary/5 group-hover:scale-110 transition-transform duration-500">
                        <span class="material-symbols-outlined text-9xl">eco</span>
                    </div>
                    <div class="flex justify-between items-start mb-sm relative z-10">
                        <div
                            class="bg-primary-container text-on-primary-container px-3 py-1 rounded-full flex items-center gap-1 w-max">
                            <span class="material-symbols-outlined text-sm">check_circle</span>
                            <span class="font-small-label text-small-label">AMAN</span>
                        </div>
                        <span class="material-symbols-outlined text-on-surface-variant">trending_down</span>
                    </div>
                    <h3 class="font-h3 text-h3 text-on-surface relative z-10">Tikus Sawah</h3>
                    <p class="font-body text-body text-on-surface-variant mt-xs relative z-10">Risiko rendah di wilayah
                        Anda saat ini. Terus jaga kebersihan area.</p>
                </div>
            </div>
        </section>
        <!-- Community Map Section -->
        <section
            class="flex flex-col gap-md bg-surface-container-lowest rounded-xl border border-surface-variant p-md shadow-[0_2px_8px_rgba(27,94,32,0.04)]">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-sm">
                <div>
                    <h2 class="font-h2 text-h2 text-on-surface">Peta Laporan Komunitas</h2>
                    <p class="font-body text-body text-on-surface-variant">Pantau penyebaran hama berdasarkan laporan
                        petani di sekitar Anda.</p>
                </div>
                <button
                    class="bg-primary text-on-primary px-6 py-2 rounded-full font-small-label text-small-label hover:bg-surface-tint transition-colors duration-200 flex items-center gap-2 shadow-[0_4px_12px_rgba(27,94,32,0.15)] whitespace-nowrap">
                    <span class="material-symbols-outlined">location_on</span> Laporkan Kondisi Lahan Saya
                </button>
            </div>
            <div
                class="w-full h-80 bg-surface-container-high rounded-lg overflow-hidden relative border border-surface-variant">
                <!-- Mock Map Background -->
                <div class="absolute inset-0 bg-[#e5eadf] opacity-50"
                    style="background-image: radial-gradient(#bfcab9 1px, transparent 1px); background-size: 20px 20px;">
                </div>
                <!-- Mock Map Pins -->
                <div class="absolute top-[30%] left-[40%] flex flex-col items-center group cursor-pointer">
                    <div class="bg-error text-on-error p-1 rounded-full shadow-md z-10"><span
                            class="material-symbols-outlined text-sm" data-weight="fill"
                            style="font-variation-settings: 'FILL' 1;">location_on</span></div>
                    <div class="w-1 h-4 bg-error"></div>
                    <div
                        class="hidden group-hover:block absolute bottom-full mb-2 bg-surface-container-lowest p-2 rounded shadow-lg border border-surface-variant w-32 z-20">
                        <p class="font-small-label text-small-label text-on-surface font-bold">Wereng</p>
                        <p class="text-[10px] text-on-surface-variant">Hari ini</p>
                    </div>
                </div>
                <div class="absolute top-[60%] left-[25%] flex flex-col items-center group cursor-pointer">
                    <div class="bg-secondary-container text-on-secondary-container p-1 rounded-full shadow-md z-10">
                        <span class="material-symbols-outlined text-sm" data-weight="fill"
                            style="font-variation-settings: 'FILL' 1;">location_on</span></div>
                    <div class="w-1 h-4 bg-secondary-container"></div>
                </div>
                <div class="absolute top-[45%] left-[70%] flex flex-col items-center group cursor-pointer">
                    <div class="bg-primary text-on-primary p-1 rounded-full shadow-md z-10"><span
                            class="material-symbols-outlined text-sm" data-weight="fill"
                            style="font-variation-settings: 'FILL' 1;">location_on</span></div>
                    <div class="w-1 h-4 bg-primary"></div>
                </div>
                <div class="absolute top-[20%] left-[60%] flex flex-col items-center group cursor-pointer">
                    <div class="bg-error text-on-error p-1 rounded-full shadow-md z-10"><span
                            class="material-symbols-outlined text-sm" data-weight="fill"
                            style="font-variation-settings: 'FILL' 1;">location_on</span></div>
                    <div class="w-1 h-4 bg-error"></div>
                </div>
                <!-- Map Legend -->
                <div
                    class="absolute bottom-4 right-4 bg-surface-container-lowest/90 backdrop-blur p-3 rounded-lg border border-surface-variant shadow-sm flex flex-col gap-2">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-error"></div>
                        <span class="font-small-label text-small-label text-on-surface">Bahaya Tinggi</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-secondary-container"></div>
                        <span class="font-small-label text-small-label text-on-surface">Perhatian</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-primary"></div>
                        <span class="font-small-label text-small-label text-on-surface">Terkendali</span>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Footer -->
    <footer class="w-full mt-auto border-t border-green-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-950">
        <div class="flex flex-col md:flex-row justify-between items-center py-10 px-6 gap-6 max-w-7xl mx-auto">
            <div class="text-lg font-bold text-green-800 dark:text-green-400">
                TaniSiaga
            </div>
            <div class="font-plus-jakarta text-xs md:text-sm font-normal text-slate-500 dark:text-slate-500">
                © 2024 TaniSiaga. Guardian of the Harvest.
            </div>
            <div class="flex gap-4">
                <a class="font-plus-jakarta text-xs md:text-sm font-normal text-slate-500 dark:text-slate-500 hover:text-green-600 dark:hover:text-green-300 hover:underline opacity-90 hover:opacity-100 transition-opacity"
                    href="#">Privacy Policy</a>
                <a class="font-plus-jakarta text-xs md:text-sm font-normal text-slate-500 dark:text-slate-500 hover:text-green-600 dark:hover:text-green-300 hover:underline opacity-90 hover:opacity-100 transition-opacity"
                    href="#">Terms of Service</a>
                <a class="font-plus-jakarta text-xs md:text-sm font-normal text-slate-500 dark:text-slate-500 hover:text-green-600 dark:hover:text-green-300 hover:underline opacity-90 hover:opacity-100 transition-opacity"
                    href="#">Help Center</a>
                <a class="font-plus-jakarta text-xs md:text-sm font-normal text-slate-500 dark:text-slate-500 hover:text-green-600 dark:hover:text-green-300 hover:underline opacity-90 hover:opacity-100 transition-opacity"
                    href="#">Community Guidelines</a>
            </div>
        </div>
    </footer>
@endsection
