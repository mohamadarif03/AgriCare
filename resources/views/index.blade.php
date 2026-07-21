<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgriCare - Dashboard Cerdas untuk Petani Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'anton': ['Anton', 'sans-serif'],
                        'inter': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'brand-yellow': '#FFD147',
                        'brand-brown': '#402E24',
                        'brand-orange': '#FF7A59',
                    }
                }
            }
        }
    </script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }
        .hero-section {
            background-color: #FFFFFF;
            background-image: 
                linear-gradient(to right, #e8e8e8 1px, transparent 1px),
                linear-gradient(to bottom, #e8e8e8 1px, transparent 1px);
            background-size: 80px 80px;
        }
        .hero-title {
            font-family: 'Anton', sans-serif;
            color: #402E24;
            font-size: 9vw;
            line-height: 0.88;
            letter-spacing: -1px;
            white-space: nowrap;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="flex items-center justify-between px-6 sm:px-10 lg:px-16 py-5 bg-white relative z-50">
        <a href="/" class="flex items-center">
            <img src="{{ asset('assets/logo panjang.png') }}" alt="AgriCare Logo" class="h-12 w-auto">
        </a>
        <div class="hidden lg:flex space-x-10 text-[12px] font-bold text-brand-brown tracking-wider">
            <a href="#fitur" class="hover:text-brand-orange transition-colors">FITUR</a>
            <a href="#testimoni" class="hover:text-brand-orange transition-colors">TESTIMONI</a>
            <a href="#berita" class="hover:text-brand-orange transition-colors">BERITA</a>
            <a href="#faq" class="hover:text-brand-orange transition-colors">FAQ</a>
        </div>
        <div class="flex items-center gap-6 text-[12px] font-bold text-brand-brown tracking-wider">
            <a href="/login" class="bg-brand-yellow text-brand-brown px-6 py-2.5 rounded-full hover:scale-105 transition-transform shadow-sm">MASUK</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section relative w-full overflow-hidden" style="height: calc(100vh - 64px);">

        <!-- Teks besar di background: sebaris -->
        <div class="absolute inset-x-0 top-[20%] flex justify-center pointer-events-none select-none z-0">
            <span class="hero-title">SMART FARMING.</span>
        </div>

        <!-- Foto di tengah (di DEPAN teks, di BELAKANG konten) -->
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 z-10 flex items-end justify-center" style="height: 78%;">
            <img src="foto.png" alt="Hero Image" class="h-full object-contain object-bottom drop-shadow-2xl">
        </div>

        <!-- Konten kiri (di DEPAN semua) -->
        <div class="absolute left-6 sm:left-10 lg:left-16 top-[35%] z-30 max-w-[200px] lg:max-w-[240px]">
            <p class="text-brand-brown text-[11px] sm:text-[12px] lg:text-[13px] font-semibold leading-relaxed mb-5 lg:mb-6">
                Satu dashboard untuk semua kebutuhan pertanian Anda. Dari deteksi penyakit hingga prediksi panen.
            </p>
            <button class="bg-[#5C4033] text-white px-5 py-3 lg:px-6 lg:py-4 w-40 lg:w-48 flex items-center justify-between hover:bg-[#4a3429] transition font-bold text-[11px] lg:text-[12px] tracking-wider group">
                MULAI GRATIS 
                <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>

        <!-- Konten kanan (di DEPAN semua) -->
        <div class="absolute right-6 sm:right-10 lg:right-16 top-[35%] z-30 flex flex-col items-end space-y-3">
            <div class="flex items-center">
                <div class="w-9 h-9 lg:w-11 lg:h-11 bg-[#FFE800] rounded-full flex items-center justify-center -mr-2 z-10 shadow-md hover:scale-110 transition-transform cursor-pointer">
                    <svg class="w-3 h-3 text-brand-brown ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </div>
                <div class="w-9 h-9 lg:w-11 lg:h-11 bg-brand-orange rounded-full flex items-center justify-center shadow-md hover:scale-110 transition-transform cursor-pointer">
                    <svg class="w-4 h-4 lg:w-5 lg:h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.62 1.63-1.57 3.12-2.53 4.08zM12.03 7.25C11.85 4 14.43 1.34 17.65 1c.28 3.48-2.67 6.13-5.62 6.25z"/>
                    </svg>
                </div>
            </div>
            <p class="text-brand-brown text-[9px] lg:text-[11px] font-extrabold tracking-widest max-w-[140px] lg:max-w-[170px] text-right leading-relaxed">
                PERTANIAN CERDAS DENGAN KEKUATAN AI.
            </p>
        </div>

        <!-- Bottom Left -->
        <div class="absolute bottom-5 sm:bottom-8 left-6 sm:left-10 lg:left-16 z-30">
            <div class="w-2 h-2 bg-brand-orange mb-2"></div>
            <h3 class="text-brand-brown font-anton text-sm lg:text-lg tracking-wide leading-none">TERSEDIA-</h3>
            <p class="text-brand-brown text-[8px] lg:text-[10px] font-extrabold tracking-widest mt-1">SELURUH INDONESIA</p>
        </div>

    </section>

    <!-- Scale Feature Section -->
    <section id="fitur" class="bg-[#FDFBF7] py-20 px-6 sm:px-10 lg:px-16 relative z-30">
        <div class="max-w-[1200px] mx-auto bg-white rounded-[2rem] p-8 sm:p-12 md:p-16 shadow-lg border border-gray-100">
            <!-- Header Area (Two Columns) -->
            <div class="flex flex-col md:flex-row justify-between items-start gap-6 md:gap-12 mb-16">
                <div class="md:w-3/5">
                    <span class="text-brand-orange font-bold text-xs sm:text-sm tracking-widest uppercase">
                        FITUR UNGGULAN
                    </span>
                    <h2 class="text-brand-brown text-3xl sm:text-4xl md:text-5xl font-bold mt-3 leading-tight tracking-tight">
                        Semua yang petani butuhkan dalam satu dashboard.
                    </h2>
                </div>
                <div class="md:w-2/5 md:pt-8">
                    <p class="text-[#64748B] text-sm sm:text-base leading-relaxed">
                        Dari deteksi penyakit tanaman hingga prediksi hasil panen, AgriCare membantu setiap langkah budidaya Anda.
                    </p>
                </div>
            </div>

            <!-- Features Columns Area (Three Columns) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 border-t border-gray-100 pt-12">
                <!-- Column 1 -->
                <div class="space-y-4">
                    <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-[#FFF0EB]">
                        <svg class="w-7 h-7 text-brand-orange" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                            <circle cx="12" cy="13" r="4" />
                        </svg>
                    </div>
                    <h3 class="text-brand-brown text-lg sm:text-xl font-bold">
                        Deteksi Penyakit Tanaman
                    </h3>
                    <p class="text-[#64748B] text-sm leading-relaxed">
                        Foto tanaman Anda dan AI akan mengidentifikasi penyakit beserta rekomendasi penanganannya secara instan.
                    </p>
                </div>

                <!-- Column 2 -->
                <div class="space-y-4">
                    <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-[#FFF9E6]">
                        <svg class="w-7 h-7 text-brand-yellow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2v10l4.5 4.5" />
                            <circle cx="12" cy="12" r="10" />
                            <path d="M2 12h2M20 12h2M12 2v2M12 20v2" />
                        </svg>
                    </div>
                    <h3 class="text-brand-brown text-lg sm:text-xl font-bold">
                        Jadwal Budidaya Otomatis
                    </h3>
                    <p class="text-[#64748B] text-sm leading-relaxed">
                        Dapatkan jadwal menyiram, memupuk, dan menyemprot otomatis berdasarkan fase pertumbuhan dan data cuaca.
                    </p>
                </div>

                <!-- Column 3 -->
                <div class="space-y-4">
                    <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-[#F5F2F0]">
                        <svg class="w-7 h-7 text-brand-brown" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                        </svg>
                    </div>
                    <h3 class="text-brand-brown text-lg sm:text-xl font-bold">
                        Prediksi Hasil Panen
                    </h3>
                    <p class="text-[#64748B] text-sm leading-relaxed">
                        Analisis kondisi lahan dan riwayat budidaya untuk memprediksi hasil panen secara akurat dan terencana.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Quote Section -->
    <section id="testimoni" class="relative bg-gradient-to-br from-[#FCF9F5] via-[#F7EFE9] to-[#EFE2D5] pt-20 pb-32 px-6 sm:px-10 lg:px-16 overflow-hidden">
        
        <!-- Scalloped Top Edge Decoration using SVG -->
        <div class="absolute top-0 left-0 w-full overflow-hidden leading-none pointer-events-none">
            <svg viewBox="0 0 1440 24" fill="none" class="w-full h-6 text-[#F9F7F2]">
                <path d="M0,0 Q15,12 30,0 Q45,12 60,0 Q75,12 90,0 Q105,12 120,0 Q135,12 150,0 Q165,12 180,0 Q195,12 210,0 Q225,12 240,0 Q255,12 270,0 Q285,12 300,0 Q315,12 330,0 Q345,12 360,0 Q375,12 390,0 Q405,12 420,0 Q435,12 450,0 Q465,12 480,0 Q495,12 510,0 Q525,12 540,0 Q555,12 570,0 Q585,12 600,0 Q615,12 630,0 Q645,12 660,0 Q675,12 690,0 Q705,12 720,0 Q735,12 750,0 Q765,12 780,0 Q795,12 810,0 Q825,12 840,0 Q855,12 870,0 Q885,12 900,0 Q915,12 930,0 Q945,12 960,0 Q975,12 990,0 Q1005,12 1020,0 Q1035,12 1050,0 Q1065,12 1080,0 Q1095,12 1110,0 Q1125,12 1140,0 Q1155,12 1170,0 Q1185,12 1200,0 Q1215,12 1230,0 Q1245,12 1260,0 Q1275,12 1290,0 Q1305,12 1320,0 Q1335,12 1350,0 Q1365,12 1380,0 Q1395,12 1410,0 Q1425,12 1440,0 L1440,24 L0,24 Z" fill="currentColor"/>
            </svg>
        </div>

        <div class="max-w-[1200px] mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center relative z-10">
            <!-- Left Content -->
            <div class="space-y-6">
                <!-- Large brand-orange quote mark -->
                <span class="font-serif text-brand-orange text-8xl leading-none select-none block -mb-6">“</span>
                <h2 class="text-brand-brown text-3xl sm:text-4xl lg:text-[2.75rem] font-bold leading-[1.2] tracking-tight max-w-[500px]">
                    AgriCare mengubah cara saya bertani - hasilnya <span class="italic font-medium text-brand-orange">meningkat drastis</span> setiap musim
                </h2>
                <div class="pt-4">
                    <button class="bg-[#5C4033] hover:bg-[#4a3429] text-white px-8 py-3.5 rounded-full flex items-center gap-2 font-bold text-sm transition duration-200 shadow-md">
                        Mulai Sekarang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Right Content (Circular Photo & Floaters) -->
            <div class="flex justify-center relative">
                <!-- Outer Border / Glow -->
                <div class="w-[320px] h-[320px] sm:w-[380px] sm:h-[380px] rounded-full border border-white/40 p-2 shadow-inner relative flex items-center justify-center">
                    <!-- Circular Image -->
                    <div class="w-full h-full rounded-full overflow-hidden border-4 border-white shadow-lg">
                        <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=600" alt="Petani di sawah" class="w-full h-full object-cover object-center" />
                    </div>
                </div>

                <!-- Floating Mascot (Top Left) -->
                <div class="absolute -left-2 top-8 w-20 h-20 pointer-events-none drop-shadow-md">
                    <svg viewBox="0 0 100 100" class="w-full h-full">
                        <path d="M 50 15 
                                 C 55 10, 63 10, 67 15 
                                 C 71 20, 79 20, 81 25 
                                 C 83 30, 88 38, 84 44 
                                 C 80 50, 82 58, 78 63 
                                 C 74 68, 66 70, 62 74 
                                 C 58 78, 50 78, 46 74 
                                 C 42 70, 34 68, 30 63 
                                 C 26 58, 28 50, 24 44 
                                 C 20 38, 25 30, 27 25 
                                 C 29 20, 37 20, 41 15 
                                 C 45 10, 47 10, 50 15 Z" 
                              fill="url(#greenGrad)" stroke="#222" stroke-width="3.5" stroke-linejoin="round" />
                        <path d="M 36 42 Q 41 38 46 42" fill="none" stroke="#222" stroke-width="3.5" stroke-linecap="round"/>
                        <path d="M 54 42 Q 59 38 64 42" fill="none" stroke="#222" stroke-width="3.5" stroke-linecap="round"/>
                        <path d="M 40 50 Q 50 64 60 50 Z" fill="#222"/>
                    </svg>
                </div>

                <!-- Floating Moon & Stars (Bottom Left) -->
                <div class="absolute -left-4 bottom-12 w-16 h-16 pointer-events-none drop-shadow-md">
                    <svg viewBox="0 0 64 64" class="w-full h-full">
                        <!-- Moon -->
                        <path d="M 42 12 A 20 20 0 1 0 52 44 A 24 24 0 1 1 42 12 Z" fill="#FFE082" stroke="#222" stroke-width="3" stroke-linejoin="round" />
                        <!-- Moon Face -->
                        <path d="M 22 36 Q 24 33 26 36" fill="none" stroke="#222" stroke-width="2.5" stroke-linecap="round"/>
                        <path d="M 32 36 Q 34 33 36 36" fill="none" stroke="#222" stroke-width="2.5" stroke-linecap="round"/>
                        <path d="M 26 44 Q 29 48 32 44" fill="none" stroke="#222" stroke-width="2" stroke-linecap="round"/>
                        <!-- Pink sparkle star -->
                        <path d="M 50 20 Q 50 25 55 25 Q 50 25 50 30 Q 50 25 45 25 Q 50 25 50 20 Z" fill="#FFB7B2" />
                    </svg>
                </div>

                <!-- Floating Rocket (Top Right) -->
                <div class="absolute -right-2 top-12 w-16 h-16 pointer-events-none drop-shadow-md">
                    <svg viewBox="0 0 64 64" class="w-full h-full">
                        <!-- Rocket Body -->
                        <rect x="24" y="10" width="16" height="32" rx="8" fill="#B39DFF" stroke="#222" stroke-width="3" />
                        <!-- Rocket Nose -->
                        <path d="M 24 18 C 24 8, 40 8, 40 18 Z" fill="#FF8A80" stroke="#222" stroke-width="3" />
                        <!-- Rocket Wings -->
                        <path d="M 24 34 L 16 42 L 24 42 Z M 40 34 L 48 42 L 40 42 Z" fill="#FFD54F" stroke="#222" stroke-width="3" />
                        <!-- Fire -->
                        <path d="M 32 42 Q 32 54 28 48 Q 32 54 36 48 Q 32 54 32 42 Z" fill="#FF8A65" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Wave divider at bottom -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none pointer-events-none transform translate-y-1">
            <svg viewBox="0 0 1440 80" fill="none" preserveAspectRatio="none" class="w-full h-20 text-[#402E24]">
                <path d="M0,80 C240,0 480,80 720,80 C960,80 1200,0 1440,80 L1440,80 L0,80 Z" fill="currentColor"/>
            </svg>
        </div>
    </section>

    <!-- What's New Section -->
    <section id="berita" class="bg-gradient-to-b from-[#402E24] via-[#63483A] to-[#F9F7F2] pt-10 pb-28 px-6 sm:px-10 lg:px-16 relative z-20">
        <div class="max-w-[1200px] mx-auto">
            <!-- Header Text -->
            <div class="text-center mb-16 space-y-4">
                <h2 class="font-serif text-white text-4xl sm:text-5xl font-normal tracking-tight">Kabar Terbaru AgriCare</h2>
                <p class="text-white/80 text-sm sm:text-base max-w-[600px] mx-auto font-medium">
                    Tips, panduan, dan informasi terbaru seputar pertanian cerdas dari tim kami.
                </p>
            </div>

            <!-- Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                <!-- Left Card (Tall - 5 columns) -->
                <div class="lg:col-span-6 bg-white rounded-[2rem] overflow-hidden flex flex-col justify-between shadow-xl hover:translate-y-[-4px] transition-transform duration-300">
                    <div>
                        <!-- Image -->
                        <div class="h-64 sm:h-80 w-full overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=700" alt="Petani memeriksa tanaman" class="w-full h-full object-cover" />
                        </div>
                        <!-- Content -->
                        <div class="p-8 space-y-4">
                            <!-- Badge tag -->
                            <span class="inline-flex items-center gap-1 bg-[#FFF0EB] text-brand-orange px-4 py-1.5 rounded-full text-xs font-bold">
                                Berita
                            </span>
                            <h3 class="text-[#322A4E] text-2xl font-bold leading-tight hover:text-brand-orange transition-colors cursor-pointer">
                                Revolusi Pertanian Digital: Bagaimana AI Membantu Petani Meningkatkan Panen
                            </h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                Temukan bagaimana teknologi AI di AgriCare membantu petani mendeteksi penyakit tanaman lebih awal dan meningkatkan produktivitas lahan.
                            </p>
                        </div>
                    </div>
                    <!-- Read Now -->
                    <div class="px-8 pb-8 pt-2">
                        <a href="#" class="inline-flex items-center gap-1.5 text-sm font-bold text-brand-orange hover:gap-2.5 transition-all">
                            Baca Selengkapnya <span>&gt;</span>
                        </a>
                    </div>
                </div>

                <!-- Right Cards Column (6 columns) -->
                <div class="lg:col-span-6 flex flex-col justify-between gap-8">
                    <!-- Card 1 (Sleep Guide) -->
                    <div class="bg-white rounded-[2rem] overflow-hidden grid grid-cols-1 sm:grid-cols-12 shadow-xl hover:translate-y-[-4px] transition-transform duration-300 flex-grow">
                        <div class="sm:col-span-5 h-48 sm:h-full overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1523348837708-15d4a09cfac2?w=500" alt="Cuaca dan pertanian" class="w-full h-full object-cover" />
                        </div>
                        <div class="sm:col-span-7 p-6 sm:p-8 flex flex-col justify-between">
                            <div class="space-y-3">
                                <span class="inline-flex items-center gap-1 bg-[#FFF9E6] text-brand-yellow px-4 py-1.5 rounded-full text-xs font-bold">
                                    Cuaca
                                </span>
                                <h3 class="text-[#322A4E] text-lg font-bold leading-snug hover:text-brand-orange transition-colors cursor-pointer">
                                    Panduan Menyiram Berdasarkan Prakiraan Cuaca Mingguan
                                </h3>
                                <p class="text-gray-500 text-xs sm:text-sm leading-relaxed line-clamp-2">
                                    Pelajari cara mengoptimalkan jadwal penyiraman dengan memanfaatkan data cuaca real-time.
                                </p>
                            </div>
                            <div class="pt-4">
                                <a href="#" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-brand-orange hover:gap-2.5 transition-all">
                                    Baca Selengkapnya <span>&gt;</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 (Play Guide) -->
                    <div class="bg-white rounded-[2rem] overflow-hidden grid grid-cols-1 sm:grid-cols-12 shadow-xl hover:translate-y-[-4px] transition-transform duration-300 flex-grow">
                        <div class="sm:col-span-5 h-48 sm:h-full overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=500" alt="Kalkulator pupuk" class="w-full h-full object-cover" />
                        </div>
                        <div class="sm:col-span-7 p-6 sm:p-8 flex flex-col justify-between">
                            <div class="space-y-3">
                                <span class="inline-flex items-center gap-1 bg-[#F5F2F0] text-brand-brown px-4 py-1.5 rounded-full text-xs font-bold">
                                    Pupuk
                                </span>
                                <h3 class="text-[#322A4E] text-lg font-bold leading-snug hover:text-brand-orange transition-colors cursor-pointer">
                                    Kalkulator Pupuk Cerdas: Hitung Kebutuhan Sesuai Luas Lahan
                                </h3>
                                <p class="text-gray-500 text-xs sm:text-sm leading-relaxed line-clamp-2">
                                    Cara menghitung kebutuhan pupuk yang tepat berdasarkan jenis tanaman, luas lahan, dan fase pertumbuhan.
                                </p>
                            </div>
                            <div class="pt-4">
                                <a href="#" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-brand-orange hover:gap-2.5 transition-all">
                                    Baca Selengkapnya <span>&gt;</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="bg-[#F9F7F2] py-20 px-6 sm:px-10 lg:px-16 flex flex-col items-center relative z-30">
        <!-- FAQ Title -->
        <h2 class="font-serif text-[#322A4E] text-5xl md:text-6xl font-normal mb-4 tracking-tight">FAQ</h2>
        <p class="text-[#322A4E] text-sm sm:text-base text-center max-w-[600px] mb-16 leading-relaxed font-semibold">
            Pertanyaan yang sering diajukan tentang AgriCare. Temukan jawabannya di sini untuk memulai perjalanan pertanian cerdas Anda.
        </p>

        <!-- FAQ Container with Mascot -->
        <div class="w-full max-w-[800px] relative">
            
            <!-- Thoughtful Mascot on top left of first accordion -->
            <div class="absolute -top-16 left-6 w-20 h-20 pointer-events-none hidden sm:block z-10">
                <svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-sm">
                    <!-- Legs -->
                    <path d="M 45 75 L 42 92 M 55 75 L 58 92" stroke="#222" stroke-width="4" stroke-linecap="round"/>
                    <!-- Arms -->
                    <path d="M 32 55 Q 20 48 18 35 Q 25 25 35 25" fill="none" stroke="#222" stroke-width="4" stroke-linecap="round"/>
                    <path d="M 68 55 Q 78 55 75 65" fill="none" stroke="#222" stroke-width="4" stroke-linecap="round"/>
                    <!-- Scalloped Body -->
                    <path d="M 50 15 
                             C 55 10, 63 10, 67 15 
                             C 71 20, 79 20, 81 25 
                             C 83 30, 88 38, 84 44 
                             C 80 50, 82 58, 78 63 
                             C 74 68, 66 70, 62 74 
                             C 58 78, 50 78, 46 74 
                             C 42 70, 34 68, 30 63 
                             C 26 58, 28 50, 24 44 
                             C 20 38, 25 30, 27 25 
                             C 29 20, 37 20, 41 15 
                             C 45 10, 47 10, 50 15 Z" 
                          fill="url(#purpleGrad)" stroke="#222" stroke-width="3.5" stroke-linejoin="round" />
                    <!-- Eyes / Eyebrows -->
                    <path d="M 36 38 Q 40 35 44 38" fill="none" stroke="#222" stroke-width="2.5" stroke-linecap="round"/>
                    <circle cx="43" cy="46" r="2.5" fill="#222"/>
                    <circle cx="57" cy="46" r="2.5" fill="#222"/>
                    <!-- Confused straight mouth -->
                    <path d="M 45 56 L 55 54" stroke="#222" stroke-width="3" stroke-linecap="round"/>
                </svg>
            </div>

            <!-- Accordion List -->
            <div class="space-y-4">
                <!-- Item 1 (Open by default) -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300">
                    <button class="w-full text-left px-8 py-6 flex items-center justify-between font-bold text-base md:text-lg text-[#322A4E] focus:outline-none" onclick="toggleFAQ(this)">
                        <span>Seberapa akurat deteksi penyakit tanaman dari AgriCare?</span>
                        <span class="text-xl font-bold text-gray-400 select-none transition-transform duration-200">–</span>
                    </button>
                    <div class="px-8 pb-6 text-sm md:text-base text-gray-500 leading-relaxed max-w-[700px] transition-all duration-300">
                        Model AI kami dilatih dengan jutaan data gambar penyakit tanaman dari berbagai varietas dan memiliki tingkat akurasi di atas 95%. Sistem terus belajar dan diperbarui oleh tim ahli agronomi untuk memastikan rekomendasi penanganan yang tepat dan terkini.
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300">
                    <button class="w-full text-left px-8 py-6 flex items-center justify-between font-bold text-base md:text-lg text-[#322A4E] focus:outline-none" onclick="toggleFAQ(this)">
                        <span>Apakah data lahan dan hasil panen saya aman?</span>
                        <span class="text-xl font-bold text-gray-400 select-none transition-transform duration-200">+</span>
                    </button>
                    <div class="px-8 pb-0 text-sm md:text-base text-gray-500 leading-relaxed max-w-[700px] h-0 transition-all duration-300 hidden">
                        Keamanan data adalah prioritas utama kami. Seluruh data lahan, riwayat budidaya, dan hasil panen Anda dienkripsi dan tidak pernah dibagikan ke pihak ketiga tanpa persetujuan Anda.
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300">
                    <button class="w-full text-left px-8 py-6 flex items-center justify-between font-bold text-base md:text-lg text-[#322A4E] focus:outline-none" onclick="toggleFAQ(this)">
                        <span>Apakah AgriCare bisa digunakan secara gratis?</span>
                        <span class="text-xl font-bold text-gray-400 select-none transition-transform duration-200">+</span>
                    </button>
                    <div class="px-8 pb-0 text-sm md:text-base text-gray-500 leading-relaxed max-w-[700px] h-0 transition-all duration-300 hidden">
                        Ya, AgriCare menyediakan paket gratis dengan fitur dasar seperti deteksi penyakit dan info cuaca. Untuk fitur lengkap seperti prediksi panen dan kalkulator pupuk, tersedia paket premium dengan uji coba 14 hari gratis.
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300">
                    <button class="w-full text-left px-8 py-6 flex items-center justify-between font-bold text-base md:text-lg text-[#322A4E] focus:outline-none" onclick="toggleFAQ(this)">
                        <span>Jenis tanaman apa saja yang didukung oleh AgriCare?</span>
                        <span class="text-xl font-bold text-gray-400 select-none transition-transform duration-200">+</span>
                    </button>
                    <div class="px-8 pb-0 text-sm md:text-base text-gray-500 leading-relaxed max-w-[700px] h-0 transition-all duration-300 hidden">
                        AgriCare mendukung berbagai jenis tanaman seperti padi, jagung, cabai, tomat, kentang, kopi, kakao, dan masih banyak lagi. Database kami terus bertambah setiap bulan dengan varietas baru.
                    </div>
                </div>

                <!-- Item 5 -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300">
                    <button class="w-full text-left px-8 py-6 flex items-center justify-between font-bold text-base md:text-lg text-[#322A4E] focus:outline-none" onclick="toggleFAQ(this)">
                        <span>Apakah AgriCare bisa digunakan tanpa koneksi internet?</span>
                        <span class="text-xl font-bold text-gray-400 select-none transition-transform duration-200">+</span>
                    </button>
                    <div class="px-8 pb-0 text-sm md:text-base text-gray-500 leading-relaxed max-w-[700px] h-0 transition-all duration-300 hidden">
                        Beberapa fitur dasar seperti jadwal budidaya dan pengingat tersedia secara offline. Namun untuk deteksi penyakit AI, data cuaca real-time, dan chat AI memerlukan koneksi internet aktif.
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Accordion toggle script -->
    <script>
        function toggleFAQ(button) {
            const container = button.parentElement;
            const content = button.nextElementSibling;
            const icon = button.querySelector('span:last-child');
            
            // Close other items
            const allItems = container.parentElement.children;
            for (let item of allItems) {
                if (item !== container) {
                    const otherContent = item.querySelector('div');
                    const otherIcon = item.querySelector('button span:last-child');
                    otherContent.classList.add('hidden');
                    otherContent.style.paddingBottom = '0px';
                    otherContent.style.height = '0px';
                    otherIcon.textContent = '+';
                }
            }

            // Toggle current item
            const isHidden = content.classList.contains('hidden');
            if (isHidden) {
                content.classList.remove('hidden');
                content.style.paddingBottom = '24px';
                content.style.height = 'auto';
                icon.textContent = '–';
            } else {
                content.classList.add('hidden');
                content.style.paddingBottom = '0px';
                content.style.height = '0px';
                icon.textContent = '+';
            }
        }
    </script>

    <!-- Pre-Footer Section with Curved Ribbon & Main Card -->
    <section class="relative bg-[#FAFAFA] pt-10 pb-24 px-6 sm:px-10 lg:px-16 overflow-hidden">
        
        <!-- Curved Text Ribbon (Wavy / Loop-de-loop) -->
        <div class="w-full h-44 relative z-10 -mb-6 md:-mb-12 pointer-events-none">
            <svg class="w-full h-full" viewBox="0 0 1440 220" fill="none" preserveAspectRatio="none">
                <path id="ribbonPath" d="M-100,80 C 150,-10 300,120 500,80 C 700,40 850,20 900,60 C 950,100 970,160 930,185 C 880,215 820,180 840,110 C 860,30 1100,-20 1600,80" fill="none" stroke="transparent" />
                <text class="fill-brand-orange/30 font-bold text-xs sm:text-sm tracking-widest uppercase">
                    <textPath href="#ribbonPath" startOffset="0%">
                        Smart Farming untuk Semua • Smart Farming untuk Semua • Smart Farming untuk Semua • Smart Farming untuk Semua • Smart Farming untuk Semua • Smart Farming untuk Semua • Smart Farming untuk Semua • Smart Farming untuk Semua • Smart Farming untuk Semua • Smart Farming untuk Semua • Smart Farming untuk Semua • Smart Farming untuk Semua
                    </textPath>
                </text>
            </svg>
        </div>

        <div class="max-w-[1200px] mx-auto bg-gradient-to-r from-[#402E24] via-[#8C624E] to-[#D4A373] rounded-[2.5rem] relative z-20 px-8 sm:px-12 md:px-16 pt-6 pb-0 flex flex-col md:flex-row items-stretch justify-between shadow-xl">
            
            <!-- Left Side: Text and Button -->
            <div class="flex flex-col justify-center items-start md:w-[50%] relative z-10 py-6">
                <div class="space-y-4 mb-8">
                    <h2 class="text-[#FFF8F4] text-2xl sm:text-3xl lg:text-[2.5rem] font-bold leading-[1.25] tracking-tight max-w-[480px]">
                        Karena setiap keputusan di ladang seharusnya didukung oleh <span class="italic text-brand-orange font-semibold">data</span>, bukan tebakan.
                    </h2>
                </div>
                
                <div class="relative w-full flex items-center">
                    <button class="bg-brand-orange hover:bg-[#ff6842] text-white px-8 py-3.5 rounded-full flex items-center gap-2 font-bold text-sm transition duration-200 shadow-md">
                        Mulai Sekarang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    
                    <!-- Purple Mascot overlaying the phone & card -->
                    <div class="absolute left-40 -bottom-8 w-24 h-24 pointer-events-none hidden lg:block z-30">
                        <svg viewBox="0 0 120 120" class="w-full h-full drop-shadow-md">
                            <defs>
                                <linearGradient id="purpleGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#9FA8FF" />
                                    <stop offset="100%" stop-color="#C2E9FB" />
                                </linearGradient>
                            </defs>
                            <!-- Legs -->
                            <path d="M 45 90 L 35 110 A 4 4 0 0 1 30 108" fill="none" stroke="#222" stroke-width="4.5" stroke-linecap="round"/>
                            <path d="M 70 90 L 68 102 L 80 108" fill="none" stroke="#222" stroke-width="4.5" stroke-linecap="round"/>
                            <!-- Arms -->
                            <path d="M 20 65 Q 5 60 15 45" fill="none" stroke="#222" stroke-width="4.5" stroke-linecap="round"/>
                            <path d="M 95 65 Q 115 50 108 35" fill="none" stroke="#222" stroke-width="4.5" stroke-linecap="round"/>
                            <!-- Scalloped Body -->
                            <path d="M 60 20 
                                     C 65 15, 75 15, 80 20 
                                     C 85 25, 95 25, 98 30 
                                     C 101 35, 106 45, 101 52 
                                     C 96 59, 98 69, 93 75 
                                     C 88 81, 78 83, 73 87 
                                     C 68 91, 58 91, 53 87 
                                     C 48 83, 38 81, 33 75 
                                     C 28 69, 30 59, 25 52 
                                     C 20 45, 25 35, 28 30 
                                     C 31 25, 41 25, 46 20 
                                     C 51 15, 55 15, 60 20 Z" 
                                  fill="url(#purpleGrad)" stroke="#222" stroke-width="4" stroke-linejoin="round" />
                            <!-- Eyes -->
                            <ellipse cx="48" cy="48" rx="3.5" ry="5" fill="#222"/>
                            <ellipse cx="68" cy="48" rx="3.5" ry="5" fill="#222"/>
                            <!-- Smile -->
                            <path d="M 52 58 Q 58 64 64 58" fill="none" stroke="#222" stroke-width="4.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="md:w-[45%] flex items-end justify-center relative mt-6 md:mt-0">
                <div class="w-[300px] bg-[#1E1E1E] rounded-[3.2rem] p-3.5 shadow-2xl relative z-10 border-4 border-[#2E2E2E] transform translate-y-2 md:-translate-y-16">
                    <!-- Dynamic Island -->
                    <div class="absolute top-4 left-1/2 -translate-x-1/2 w-28 h-6 bg-black rounded-full z-20 flex items-center justify-between px-4">
                        <div class="w-2.5 h-2.5 bg-[#1F1F1F] rounded-full"></div>
                        <div class="w-12 h-1 bg-[#1F1F1F] rounded-full"></div>
                    </div>
                    
                    <!-- Screen Container -->
                    <div class="bg-gradient-to-b from-[#FFF2EA] to-[#FFFFFF] rounded-[2.6rem] overflow-hidden pt-8 pb-3 px-3 flex flex-col h-[500px]">
                        <!-- Chat Header -->
                        <div class="flex items-center justify-between border-b border-orange-100 pb-3 mb-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-[#FFF2EA] border border-orange-200 rounded-full flex items-center justify-center font-bold text-xs text-brand-brown">
                                    A
                                </div>
                                <span class="font-bold text-sm text-[#322A4E]">Chat AgriCare AI</span>
                            </div>
                            <button class="text-gray-400 hover:text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        
                        <!-- Chat Body -->
                        <div class="flex-grow space-y-4 overflow-y-auto pr-1">
                            <!-- Avatar / Welcome message -->
                            <div class="text-center my-3">
                                <div class="w-10 h-10 bg-[#FF9D74] border border-[#222] rounded-full flex items-center justify-center mx-auto mb-2 shadow-sm">
                                    <svg viewBox="0 0 40 40" class="w-6 h-6">
                                        <circle cx="20" cy="20" r="16" fill="#FF9D74" />
                                        <circle cx="15" cy="18" r="1.5" fill="#222" />
                                        <circle cx="25" cy="18" r="1.5" fill="#222" />
                                        <path d="M 17 24 Q 20 28 23 24" fill="none" stroke="#222" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </div>
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Halo Pak Budi!</p>
                                <p class="text-[12px] font-bold text-[#322A4E] max-w-[200px] mx-auto leading-tight mt-1">
                                    Ada yang bisa saya bantu untuk lahan Anda hari ini?
                                </p>
                                <p class="text-[10px] text-gray-400 mt-1">Berikut beberapa ide:</p>
                            </div>
                            
                            <!-- Prompt suggestions -->
                            <div class="grid grid-cols-2 gap-2 text-[9px] font-bold text-[#322A4E]">
                                <div class="p-2 bg-white rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition flex flex-col justify-between h-16 shadow-sm">
                                    <span class="text-xs">~</span>
                                    <span class="leading-tight">Analisis foto daun padi saya yang menguning.</span>
                                </div>
                                <div class="p-2 bg-white rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition flex flex-col justify-between h-16 shadow-sm">
                                    <span class="text-xs">~</span>
                                    <span class="leading-tight">Hitung kebutuhan pupuk untuk 2 hektar cabai.</span>
                                </div>
                                <div class="p-2 bg-white rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition flex flex-col justify-between h-16 shadow-sm">
                                    <span class="text-xs">~</span>
                                    <span class="leading-tight">Prediksi cuaca minggu depan untuk jadwal semprot.</span>
                                </div>
                                <div class="p-2 bg-white rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition flex flex-col justify-between h-16 shadow-sm">
                                    <span class="text-xs">~</span>
                                    <span class="leading-tight">Buatkan jadwal budidaya jagung dari awal tanam.</span>
                                </div>
                            </div>
                        </div>

                        <!-- Chat input mock -->
                        <div class="mt-2 bg-white rounded-full border border-gray-200 px-4 py-2.5 flex items-center justify-between shadow-inner">
                            <span class="text-[9px] text-gray-400 font-medium">Tanya seputar pertanian Anda...</span>
                            <svg class="w-3.5 h-3.5 text-brand-orange" fill="currentColor" viewBox="0 0 24 24"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3zm5.3-3c0 3-2.54 5.1-5.3 5.1S6.7 14 6.7 11H5c0 3.41 2.72 6.23 6 6.72V21h2v-3.28c3.28-.48 6-3.3 6-6.72h-1.7z"/></svg>
                        </div>

                        <!-- Mock Keyboard -->
                        <div class="mt-2 border-t pt-2 space-y-1.5 bg-gray-50 rounded-b-[2rem] -mx-3 -mb-3 px-3 pb-3">
                            <div class="flex justify-center gap-1.5">
                                <span class="bg-white border border-gray-200 text-[8px] px-2.5 py-0.5 rounded-md text-gray-700 font-medium">"The"</span>
                                <span class="bg-white border border-gray-200 text-[8px] px-2.5 py-0.5 rounded-md text-gray-700 font-medium">the</span>
                                <span class="bg-white border border-gray-200 text-[8px] px-2.5 py-0.5 rounded-md text-gray-700 font-medium">to</span>
                            </div>
                            <div class="grid grid-cols-10 gap-0.5 text-center text-[8px] font-bold text-gray-700 p-0.5">
                                <span>q</span><span>w</span><span>e</span><span>r</span><span>t</span><span>y</span><span>u</span><span>i</span><span>o</span><span>p</span>
                                <span>a</span><span>s</span><span>d</span><span>f</span><span>g</span><span>h</span><span>j</span><span>k</span><span>l</span><span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Green/Yellow Scalloped Mascot -->
                <div class="absolute -right-4 top-16 w-20 h-20 pointer-events-none z-20">
                    <svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-md">
                        <defs>
                            <linearGradient id="greenGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#E2F0D9" />
                                <stop offset="100%" stop-color="#C5E0B4" />
                            </linearGradient>
                        </defs>
                        <!-- Scalloped Body -->
                        <path d="M 50 15 
                                 C 55 10, 63 10, 67 15 
                                 C 71 20, 79 20, 81 25 
                                 C 83 30, 88 38, 84 44 
                                 C 80 50, 82 58, 78 63 
                                 C 74 68, 66 70, 62 74 
                                 C 58 78, 50 78, 46 74 
                                 C 42 70, 34 68, 30 63 
                                 C 26 58, 28 50, 24 44 
                                 C 20 38, 25 30, 27 25 
                                 C 29 20, 37 20, 41 15 
                                 C 45 10, 47 10, 50 15 Z" 
                              fill="url(#greenGrad)" stroke="#222" stroke-width="3.5" stroke-linejoin="round" />
                        <!-- Happy Closed Eyes -->
                        <path d="M 36 42 Q 41 38 46 42" fill="none" stroke="#222" stroke-width="3.5" stroke-linecap="round"/>
                        <path d="M 54 42 Q 59 38 64 42" fill="none" stroke="#222" stroke-width="3.5" stroke-linecap="round"/>
                        <!-- Big open smile -->
                        <path d="M 40 50 Q 50 64 60 50 Z" fill="#222"/>
                    </svg>
                </div>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-brand-brown text-[#FAFAFA] py-16 px-8 md:px-16 lg:px-24 border-t border-[#5C4033] relative z-40">
        <div class="max-w-[1400px] mx-auto grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-6 items-stretch">
            
            <!-- Left Side -->
            <div class="md:col-span-4 flex flex-col items-start justify-between space-y-6">
                <div class="space-y-4">
                    <!-- Logo -->
                    <div class="text-3xl font-anton tracking-wide text-white flex items-baseline">
                        AGRICARE<span class="text-brand-orange text-xl ml-0.5">.</span>
                    </div>
                    <!-- Subtext -->
                    <p class="text-gray-300 text-sm font-medium leading-relaxed max-w-[280px]">
                        Pertanian cerdas dimulai dari sini bersama AgriCare.
                    </p>
                </div>
                <!-- Button -->
                <button class="bg-brand-orange hover:bg-[#ff6842] text-white px-8 py-3.5 rounded-full flex items-center gap-2 font-bold text-[13px] transition duration-200 shadow-lg">
                    Mulai Sekarang
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            <!-- Middle Columns (Divider & Links) -->
            <div class="md:col-span-4 flex justify-between items-stretch">
                <!-- Divider Line -->
                <div class="w-[1px] bg-[#5C4033] hidden md:block self-stretch mr-10"></div>
                
                <!-- Links Grid -->
                <div class="grid grid-cols-2 gap-x-12 gap-y-4 w-full text-sm font-medium text-gray-300 self-center">
                    <!-- Column 1 -->
                    <div class="flex flex-col space-y-4">
                        <a href="#" class="hover:text-brand-orange transition-colors">Kenapa AgriCare</a>
                        <a href="#" class="hover:text-brand-orange transition-colors">Blog</a>
                        <a href="#" class="hover:text-brand-orange transition-colors">Harga</a>
                    </div>
                    
                    <!-- Column 2 -->
                    <div class="flex flex-col space-y-4">
                        <a href="#" class="hover:text-brand-orange transition-colors">Kebijakan Privasi</a>
                        <a href="#" class="hover:text-brand-orange transition-colors">Syarat Layanan</a>
                        <a href="#" class="hover:text-brand-orange transition-colors">Panduan Pengguna</a>
                        <a href="#" class="hover:text-brand-orange transition-colors">Bantuan</a>
                    </div>
                </div>

                <!-- Divider Line -->
                <div class="w-[1px] bg-[#5C4033] hidden md:block self-stretch ml-10"></div>
            </div>

            <!-- Right Side -->
            <div class="md:col-span-4 flex flex-col justify-center space-y-4">
                <p class="text-sm font-medium text-gray-300">
                    Dapatkan tips dan panduan pertanian gratis lewat newsletter kami.
                </p>
                <!-- Subscription Box -->
                <div class="flex items-center bg-white rounded-full p-1.5 w-full shadow-md max-w-md">
                    <input type="email" placeholder="Masukkan email Anda" class="w-full pl-4 pr-2 py-2 text-brand-brown text-sm font-medium focus:outline-none placeholder-gray-400 rounded-full" />
                    <button class="bg-[#5C4033] hover:bg-[#4a3429] text-white px-5 py-2.5 rounded-full text-xs font-bold tracking-wider transition shrink-0 flex items-center gap-1">
                        Subscribe
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </footer>

</body>
</html>
