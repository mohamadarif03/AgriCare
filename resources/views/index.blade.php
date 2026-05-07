<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>PastiPanen - Platform AI Pertanian Indonesia #1</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/favicon.png') }}">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "secondary-fixed-dim": "#fabd00",
                        "surface-variant": "#dfe4d9",
                        "on-secondary-fixed-variant": "#5b4300",
                        "on-primary": "#ffffff",
                        "surface-container-highest": "#dfe4d9",
                        "on-secondary-fixed": "#261a00",
                        "surface": "#f6fbf0",
                        "inverse-on-surface": "#eef2e7",
                        "surface-tint": "#106d20",
                        "primary-container": "#2e8534",
                        "secondary": "#785900",
                        "tertiary-container": "#0077ce",
                        "tertiary-fixed": "#d3e4ff",
                        "tertiary": "#005ea4",
                        "outline-variant": "#bfcab9",
                        "inverse-primary": "#82db7e",
                        "error-container": "#ffdad6",
                        "on-secondary-container": "#6c5000",
                        "on-tertiary-fixed": "#001c38",
                        "secondary-fixed": "#ffdf9e",
                        "on-tertiary-container": "#fdfcff",
                        "surface-dim": "#d7dcd1",
                        "on-error-container": "#93000a",
                        "surface-container": "#ebf0e5",
                        "tertiary-fixed-dim": "#a2c9ff",
                        "on-surface-variant": "#40493d",
                        "on-surface": "#181d17",
                        "on-tertiary": "#ffffff",
                        "secondary-container": "#fdc003",
                        "surface-bright": "#f6fbf0",
                        "primary": "#0b6b1d",
                        "on-primary-fixed": "#002204",
                        "on-background": "#181d17",
                        "surface-container-low": "#f0f5ea",
                        "inverse-surface": "#2d322b",
                        "on-tertiary-fixed-variant": "#004881",
                        "on-primary-container": "#f7fff1",
                        "surface-container-lowest": "#ffffff",
                        "background": "#f6fbf0",
                        "on-secondary": "#ffffff",
                        "surface-container-high": "#e5eadf",
                        "primary-fixed": "#9df898",
                        "on-primary-fixed-variant": "#005312",
                        "outline": "#707a6c",
                        "on-error": "#ffffff",
                        "error": "#ba1a1a",
                        "primary-fixed-dim": "#82db7e"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "lg": "48px",
                        "gutter": "16px",
                        "base": "8px",
                        "xs": "4px",
                        "container_margin": "20px",
                        "md": "24px",
                        "sm": "12px"
                    },
                    "fontFamily": {
                        "body": ["Plus Jakarta Sans"],
                        "h2": ["Plus Jakarta Sans"],
                        "h1": ["Plus Jakarta Sans"],
                        "h3": ["Plus Jakarta Sans"],
                        "small-label": ["Plus Jakarta Sans"]
                    },
                    "fontSize": {
                        "body": ["16px", { "lineHeight": "1.7", "fontWeight": "400" }],
                        "h2": ["32px", { "lineHeight": "1.3", "fontWeight": "500" }],
                        "h1": ["48px", { "lineHeight": "1.2", "letterSpacing": "-0.02em", "fontWeight": "500" }],
                        "h3": ["24px", { "lineHeight": "1.4", "fontWeight": "500" }],
                        "small-label": ["13px", { "lineHeight": "1.2", "letterSpacing": "0.01em", "fontWeight": "500" }]
                    }
                }
            }
        }
    </script>
    <style>
        .shadow-ambient {
            box-shadow: 0 4px 20px rgba(27, 94, 32, 0.08);
        }

        .bg-hero-pattern {
            background-color: #f0f9f0;
            background-image: radial-gradient(#388E3C 0.5px, transparent 0.5px), radial-gradient(#388E3C 0.5px, #f0f9f0 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            opacity: 0.8;
        }
    </style>
</head>

<body
    class="bg-background text-on-background font-body text-body selection:bg-primary-container selection:text-on-primary-container">
    <!-- TopNavBar -->
    <nav
        class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-md fixed top-0 w-full z-50 border-b border-green-100 dark:border-slate-800 shadow-sm dark:shadow-none">
        <div class="flex items-center justify-between px-6 py-4 max-w-7xl mx-auto">
            <div class="flex items-center gap-2 text-xl font-bold tracking-tight text-green-800 dark:text-green-400">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">eco</span>
                PastiPanen
            </div>
            <div class="hidden md:flex gap-6">
                <a class="font-['Plus_Jakarta_Sans'] font-semibold text-sm text-slate-600 dark:text-slate-400 hover:text-green-700 transition-colors"
                    href="{{ route('dashboard') }}">Lahan Saya</a>
                <a class="font-['Plus_Jakarta_Sans'] font-semibold text-sm text-slate-600 dark:text-slate-400 hover:text-green-700 transition-colors"
                    href="{{ route('ai_reccomendation') }}">Analisis AI</a>
                <a class="font-['Plus_Jakarta_Sans'] font-semibold text-sm text-slate-600 dark:text-slate-400 hover:text-green-700 transition-colors"
                    href="{{ route('market_price') }}">Harga Pasar</a>
                <a class="font-['Plus_Jakarta_Sans'] font-semibold text-sm text-slate-600 dark:text-slate-400 hover:text-green-700 transition-colors"
                    href="{{ route('tanibot') }}">Tanya AI</a>
            </div>
            <div class="flex items-center gap-4">
                <a class="font-['Plus_Jakarta_Sans'] font-semibold text-sm bg-primary text-on-primary px-6 py-2 rounded-full hover:bg-primary-container hover:text-on-primary-container transition-all active:scale-95 duration-200"
                    href="{{ route('login') }}">Masuk</a>
            </div>
        </div>
    </nav>
    <!-- Hero Section -->
    <section
        class="relative pt-[120px] pb-lg px-container_margin md:px-lg min-h-[921px] flex flex-col justify-center items-center text-center overflow-hidden bg-gradient-to-b from-surface-container-low to-background">
        <!-- Abstract Background Decoration -->
        <div class="absolute inset-0 z-0 opacity-10 pointer-events-none">
            <div class="absolute top-20 left-10 w-64 h-64 bg-primary rounded-full mix-blend-multiply filter blur-3xl">
            </div>
            <div
                class="absolute bottom-20 right-10 w-96 h-96 bg-tertiary rounded-full mix-blend-multiply filter blur-3xl">
            </div>
        </div>
        <img alt="Lahan Pertanian PastiPanen"
            class="absolute inset-0 w-full h-full object-cover opacity-20 z-0 pointer-events-none"
            src="{{ asset('assets/herosection.jpeg') }}" />
        <div class="relative z-10 max-w-4xl mx-auto flex flex-col items-center gap-md">
            <h1 class="font-h1 text-h1 text-primary-fixed-variant max-w-3xl">
                Tanam Lebih Cerdas, Panen Lebih Pasti
            </h1>
            <p class="font-body text-body text-on-surface-variant max-w-2xl">
                Pantau risiko iklim lahan Anda, dapatkan jadwal tanam optimal, deteksi hama lebih awal, dan prediksi
                harga panen — semua dalam satu platform berbasis AI.
            </p>
            <div
                class="mt-md w-full max-w-4xl bg-surface-container-lowest p-sm md:p-md rounded-[16px] shadow-ambient border border-outline-variant/30 flex flex-col md:flex-row gap-sm items-center">
                <div class="w-full md:flex-1">
                    <label class="sr-only">Komoditas</label>
                    <div class="relative">
                        <span
                            class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline">grass</span>
                        <select
                            class="w-full pl-10 pr-4 py-3 rounded-[12px] bg-surface-container-low border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-body outline-none appearance-none cursor-pointer">
                            <option>Padi</option>
                            <option>Jagung</option>
                            <option>Kedelai</option>
                            <option>Cabai</option>
                        </select>
                        <span
                            class="absolute right-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline pointer-events-none">expand_more</span>
                    </div>
                </div>
                <div class="w-full md:flex-1">
                    <label class="sr-only">Lokasi Lahan</label>
                    <div class="relative">
                        <span
                            class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline">location_on</span>
                        <input
                            class="w-full pl-10 pr-4 py-3 rounded-[12px] bg-surface-container-low border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-body outline-none"
                            placeholder="Lokasi Lahan..." type="text" />
                    </div>
                </div>
                <button
                    class="w-full md:w-auto flex-none whitespace-nowrap bg-primary text-on-primary py-3 px-8 rounded-full font-body text-body font-medium hover:bg-primary-container hover:text-on-primary-container transition-colors shadow-ambient">
                    Cek Sekarang — Gratis
                </button>
            </div>
        </div>
    </section>
    <!-- Stats Section -->
    <section class="py-lg bg-surface-container-lowest relative z-20">
        <div class="max-w-7xl mx-auto px-container_margin md:px-lg">
            <div
                class="grid grid-cols-1 md:grid-cols-3 gap-lg text-center divide-y md:divide-y-0 md:divide-x divide-outline-variant/30">
                <div class="py-sm md:py-0 flex flex-col items-center gap-xs">
                    <div class="font-h2 text-h2 text-primary font-bold">17 Juta+</div>
                    <div class="w-12 h-1 bg-secondary-fixed-dim rounded-full mb-2"></div>
                    <div class="font-body text-body text-on-surface-variant">Petani aktif terdaftar</div>
                </div>
                <div class="py-sm md:py-0 flex flex-col items-center gap-xs">
                    <div class="font-h2 text-h2 text-primary font-bold">Rp 12 Triliun</div>
                    <div class="w-12 h-1 bg-secondary-fixed-dim rounded-full mb-2"></div>
                    <div class="font-body text-body text-on-surface-variant">Kerugian gagal panen per tahun</div>
                </div>
                <div class="py-sm md:py-0 flex flex-col items-center gap-xs">
                    <div class="font-h2 text-h2 text-primary font-bold">68%</div>
                    <div class="w-12 h-1 bg-secondary-fixed-dim rounded-full mb-2"></div>
                    <div class="font-body text-body text-on-surface-variant">Kasus gagal dapat dicegah dengan AI</div>
                </div>
            </div>
        </div>
    </section>
    <!-- Features Section -->
    <section class="py-lg px-container_margin md:px-lg bg-background">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-lg">
                <h2 class="font-h2 text-h2 text-on-surface mb-sm">Semua yang dibutuhkan petani modern</h2>
                <p class="font-body text-body text-on-surface-variant max-w-2xl mx-auto">Teknologi mutakhir yang
                    dirancang khusus untuk kondisi pertanian Indonesia, mudah digunakan dan sangat akurat.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-md">
                <!-- Feature 1 -->
                <div
                    class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant/30 hover:shadow-ambient transition-all group">
                    <div
                        class="w-12 h-12 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center mb-sm group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">calendar_month</span>
                    </div>
                    <h3 class="font-h3 text-h3 text-on-surface mb-xs text-[20px]">Kalender Tanam AI</h3>
                    <p class="font-body text-body text-on-surface-variant text-[14px]">Rekomendasi waktu tanam paling
                        optimal berdasarkan prediksi cuaca lokal dan siklus hama historis.</p>
                </div>
                <!-- Feature 2 -->
                <div
                    class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant/30 hover:shadow-ambient transition-all group">
                    <div
                        class="w-12 h-12 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center mb-sm group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">thermostat</span>
                    </div>
                    <h3 class="font-h3 text-h3 text-on-surface mb-xs text-[20px]">Pemantauan Iklim</h3>
                    <p class="font-body text-body text-on-surface-variant text-[14px]">Data curah hujan, kelembapan, dan
                        suhu real-time untuk setiap petak lahan Anda secara presisi.</p>
                </div>
                <!-- Feature 3 -->
                <div
                    class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant/30 hover:shadow-ambient transition-all group">
                    <div
                        class="w-12 h-12 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center mb-sm group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">bug_report</span>
                    </div>
                    <h3 class="font-h3 text-h3 text-on-surface mb-xs text-[20px]">Deteksi Hama Dini</h3>
                    <p class="font-body text-body text-on-surface-variant text-[14px]">Upload foto daun sakit, AI kami
                        akan menganalisis jenis hama dan memberikan rekomendasi penanganan seketika.</p>
                </div>
                <!-- Feature 4 -->
                <div
                    class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant/30 hover:shadow-ambient transition-all group">
                    <div
                        class="w-12 h-12 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center mb-sm group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">trending_up</span>
                    </div>
                    <h3 class="font-h3 text-h3 text-on-surface mb-xs text-[20px]">Radar Harga Pasar</h3>
                    <p class="font-body text-body text-on-surface-variant text-[14px]">Pantau pergerakan harga komoditas
                        di pasar terdekat untuk menentukan waktu jual paling menguntungkan.</p>
                </div>
                <!-- Feature 5 -->
                <div
                    class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant/30 hover:shadow-ambient transition-all group">
                    <div
                        class="w-12 h-12 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center mb-sm group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">analytics</span>
                    </div>
                    <h3 class="font-h3 text-h3 text-on-surface mb-xs text-[20px]">Rekomendasi AI</h3>
                    <p class="font-body text-body text-on-surface-variant text-[14px]">Dapatkan skor ketahanan lahan dan rekomendasi aksi harian yang dipersonalisasi berdasarkan cuaca, hama, dan harga pasar.</p>
                </div>
                <!-- Feature 6 -->
                <div
                    class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant/30 hover:shadow-ambient transition-all group">
                    <div
                        class="w-12 h-12 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center mb-sm group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">smart_toy</span>
                    </div>
                    <h3 class="font-h3 text-h3 text-on-surface mb-xs text-[20px]">Asisten AI TaniBot</h3>
                    <p class="font-body text-body text-on-surface-variant text-[14px]">Konsultasikan masalah pertanian Anda dengan asisten AI cerdas yang siap memberikan solusi dan rekomendasi 24/7.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Multi-Lahan Highlight -->
    <section class="py-lg px-container_margin md:px-lg bg-surface-container-low overflow-hidden">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-lg items-center">
            <div class="relative order-2 md:order-1">
                <div
                    class="absolute inset-0 bg-primary/10 rounded-full blur-3xl transform -translate-x-10 translate-y-10">
                </div>
                <img alt="Indonesian farmer smiling while looking at a digital tablet standing in a bright green rice field during daytime"
                    class="relative z-10 rounded-xl shadow-ambient object-cover w-full h-[400px]"
                    data-alt="Indonesian farmer smiling while looking at a digital tablet standing in a bright green rice field during daytime"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDTOKnkCmlkGWMBqNDJ2fH49qywMO7D3E2F2kXt-w3cFpbd-jb-Gno5PlJq4m_nUHwUTYo-BU0HN__kY6fIYKJAch6F_MRihEWYnIVdaixVTbm-FTyxQCxO5sZ9_oW4OG_lBzSd79M-hNuID6_q5JzXDKTJwG1lr5K6TBK2q73pOM-WSgGDheQmeYUPkfy3OzvJaCDfhtermEfekSjbyTW9mmyLITP0OS1e3Vh9RCceIJj7sOHbHkotm37d-TU-ThxjfTKFm6ATEgw" />
                <!-- Floating Element -->
            </div>
            <div class="order-1 md:order-2 flex flex-col gap-md">
                <div>
                    <h3 class="font-h3 text-h3 text-on-surface mb-sm">Kelola Semua Lahan dalam Satu Akun</h3>
                    <p class="font-body text-body text-on-surface-variant">Punya lebih dari satu petak sawah atau kebun
                        dengan komoditas berbeda? Tidak masalah. Pantau semuanya dari satu dashboard yang terorganisir.
                    </p>
                </div>
                <ul class="flex flex-col gap-sm">
                    <li class="flex items-start gap-sm">
                        <span class="material-symbols-outlined text-primary mt-1">task_alt</span>
                        <span class="font-body text-body text-on-surface">Pisahkan catatan panen, pupuk, dan biaya per
                            lahan.</span>
                    </li>
                    <li class="flex items-start gap-sm">
                        <span class="material-symbols-outlined text-primary mt-1">task_alt</span>
                        <span class="font-body text-body text-on-surface">Dapatkan alert spesifik hanya untuk lahan yang
                            berisiko.</span>
                    </li>
                    <li class="flex items-start gap-sm">
                        <span class="material-symbols-outlined text-primary mt-1">task_alt</span>
                        <span class="font-body text-body text-on-surface">Bandingkan produktivitas antar lahan dengan
                            grafik sederhana.</span>
                    </li>
                </ul>
                <div>
                    <button
                        class="bg-primary-container text-on-primary-container py-3 px-6 rounded-full font-body text-body font-medium hover:bg-primary transition-colors inline-flex items-center gap-2">
                        Pelajari Manajemen Lahan
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="bg-slate-50 dark:bg-slate-950 w-full py-12 px-8 border-t border-green-100 dark:border-slate-800">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 max-w-7xl mx-auto">
            <div class="flex flex-col gap-4">
                <div class="text-2xl font-black text-green-700 dark:text-green-400 flex items-center gap-2">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">eco</span>
                    PastiPanen
                </div>
                <p class="font-['Plus_Jakarta_Sans'] text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                    Menjaga Panen Nusantara dengan Kecerdasan Buatan. Platform andalan petani modern Indonesia.
                </p>
            </div>
            <div class="flex flex-col gap-2">
                <h4
                    class="font-['Plus_Jakarta_Sans'] text-sm leading-relaxed text-green-800 dark:text-green-500 font-bold mb-2">
                    Fitur</h4>
                <a class="font-['Plus_Jakarta_Sans'] text-sm leading-relaxed text-slate-500 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300 transition-colors opacity-100 hover:opacity-80"
                    href="{{ route('calender_planning') }}">Kalender Tanam</a>
                <a class="font-['Plus_Jakarta_Sans'] text-sm leading-relaxed text-slate-500 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300 transition-colors opacity-100 hover:opacity-80"
                    href="{{ route('pest_detection_alert') }}">Deteksi Hama</a>
                <a class="font-['Plus_Jakarta_Sans'] text-sm leading-relaxed text-slate-500 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300 transition-colors opacity-100 hover:opacity-80"
                    href="{{ route('market_price') }}">Harga Pasar</a>
            </div>
            <div class="flex flex-col gap-2">
                <h4
                    class="font-['Plus_Jakarta_Sans'] text-sm leading-relaxed text-green-800 dark:text-green-500 font-bold mb-2">
                    Perusahaan</h4>
                <a class="font-['Plus_Jakarta_Sans'] text-sm leading-relaxed text-slate-500 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300 transition-colors opacity-100 hover:opacity-80"
                    href="{{ route('about') }}">Tentang Kami</a>
                <a class="font-['Plus_Jakarta_Sans'] text-sm leading-relaxed text-slate-500 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300 transition-colors opacity-100 hover:opacity-80"
                    href="{{ route('terms') }}">Syarat &amp; Ketentuan</a>
                <a class="font-['Plus_Jakarta_Sans'] text-sm leading-relaxed text-slate-500 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300 transition-colors opacity-100 hover:opacity-80"
                    href="{{ route('privacy') }}">Kebijakan Privasi</a>
            </div>
            <div class="flex flex-col gap-2">
                <h4
                    class="font-['Plus_Jakarta_Sans'] text-sm leading-relaxed text-green-800 dark:text-green-500 font-bold mb-2">
                    Bantuan</h4>
                <a class="font-['Plus_Jakarta_Sans'] text-sm leading-relaxed text-slate-500 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300 transition-colors opacity-100 hover:opacity-80"
                    href="{{ route('tanibot') }}">Tanya AI</a>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-12 pt-8 border-t border-green-100 dark:border-slate-800 text-center">
            <p class="font-['Plus_Jakarta_Sans'] text-sm leading-relaxed text-slate-500 dark:text-slate-400">© 2024
                PastiPanen. Menjaga Panen Nusantara dengan Kecerdasan Buatan.</p>
        </div>
    </footer>
</body>

</html>
