@extends('layouts.app')

@section('content')
<main class="flex-grow w-full max-w-[1600px] mx-auto px-4 xl:px-6 py-6 md:py-8 flex flex-col gap-6">
    
    <!-- Breadcrumbs & Actions -->
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
                <h1 class="font-h2 text-h2 text-on-surface leading-tight">Sawah Cilacap</h1>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button class="px-4 py-2 bg-primary text-on-primary rounded-xl text-sm font-semibold shadow-sm hover:bg-primary-container transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                Set Aktif
            </button>
            <button class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-container rounded-xl transition-colors border border-outline-variant/30">
                <span class="material-symbols-outlined">edit</span>
            </button>
            <button class="p-2 text-red-500 hover:bg-red-50 rounded-xl transition-colors border border-red-100">
                <span class="material-symbols-outlined">delete</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- LEFT COLUMN: Main Info & Status -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Status & Condition Card -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Risk Level -->
                <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant/30 shadow-sm flex flex-col gap-3">
                    <div class="flex items-center gap-2 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">security</span>
                        <span class="text-xs font-bold uppercase tracking-wider">Risiko Iklim</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-3xl">warning</span>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-amber-600">Waspada</p>
                            <p class="text-[10px] text-on-surface-variant mt-0.5">Potensi Hujan Ekstrim</p>
                        </div>
                    </div>
                </div>
                
                <!-- Weather -->
                <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant/30 shadow-sm flex flex-col gap-3">
                    <div class="flex items-center gap-2 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">partly_cloudy_day</span>
                        <span class="text-xs font-bold uppercase tracking-wider">Cuaca Hari Ini</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-3xl">rainy</span>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-on-surface">28°C</p>
                            <p class="text-[10px] text-on-surface-variant mt-0.5">Hujan Ringan (Sore)</p>
                        </div>
                    </div>
                </div>

                <!-- Growth Phase -->
                <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant/30 shadow-sm flex flex-col gap-3">
                    <div class="flex items-center gap-2 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">eco</span>
                        <span class="text-xs font-bold uppercase tracking-wider">Fase Tanam</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-primary mb-2">Vegetatif — Minggu 4/8</p>
                        <div class="w-full bg-surface-container rounded-full h-2">
                            <div class="bg-primary h-2 rounded-full" style="width: 50%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Land Details & Photo -->
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-sm overflow-hidden flex flex-col md:flex-row">
                <div class="md:w-1/3 relative h-64 md:h-auto">
                    <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Foto Lahan" class="w-full h-full object-cover">
                    <button class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm p-2 rounded-lg shadow-md hover:bg-white transition-colors">
                        <span class="material-symbols-outlined text-primary">add_a_photo</span>
                    </button>
                </div>
                <div class="md:w-2/3 p-6 md:p-8 space-y-6">
                    <h3 class="font-h3 text-xl text-on-surface">Informasi Dasar</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                        <div>
                            <p class="text-xs text-on-surface-variant font-bold uppercase mb-1">Komoditas</p>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">eco</span>
                                <span class="font-semibold text-on-surface">Padi Inpari 32</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-on-surface-variant font-bold uppercase mb-1">Luas Lahan</p>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-blue-600">square_foot</span>
                                <span class="font-semibold text-on-surface">1.2 Hektar (Ha)</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-on-surface-variant font-bold uppercase mb-1">Tanggal Tanam</p>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-purple-600">calendar_today</span>
                                <span class="font-semibold text-on-surface">12 Maret 2024</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-on-surface-variant font-bold uppercase mb-1">Estimasi Panen</p>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-green-600">event_available</span>
                                <span class="font-semibold text-on-surface">15 Juni 2024</span>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-xs text-on-surface-variant font-bold uppercase mb-1">Lokasi Lengkap</p>
                            <div class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-red-500 mt-0.5">location_on</span>
                                <span class="font-semibold text-on-surface">Blok A-12, Desa Karangjati, Kec. Sampang, Cilacap, Jawa Tengah</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seasonal History -->
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-sm p-6 md:p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-h3 text-xl text-on-surface">Riwayat Musim Tanam</h3>
                    <span class="text-xs font-semibold text-primary px-3 py-1 bg-primary/5 rounded-full">Gemini AI Enhanced</span>
                </div>
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
                            <tr>
                                <td class="py-4">
                                    <p class="text-sm font-semibold text-on-surface">Des 2023 - Feb 2024</p>
                                    <p class="text-[10px] text-on-surface-variant">92 Hari Masa Tanam</p>
                                </td>
                                <td class="py-4 text-sm text-on-surface">Jagung Manis</td>
                                <td class="py-4 text-sm font-bold text-on-surface text-right">6.4 Ton</td>
                                <td class="py-4 text-right">
                                    <span class="text-[10px] font-bold text-green-700 bg-green-100 px-2 py-1 rounded">SUKSES</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4">
                                    <p class="text-sm font-semibold text-on-surface">Agu 2023 - Okt 2023</p>
                                    <p class="text-[10px] text-on-surface-variant">88 Hari Masa Tanam</p>
                                </td>
                                <td class="py-4 text-sm text-on-surface">Padi Gogo</td>
                                <td class="py-4 text-sm font-bold text-on-surface text-right">4.8 Ton</td>
                                <td class="py-4 text-right">
                                    <span class="text-[10px] font-bold text-amber-700 bg-amber-100 px-2 py-1 rounded">NORMAL</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button class="w-full mt-6 py-3 border border-dashed border-outline-variant rounded-xl text-sm font-semibold text-on-surface-variant hover:bg-surface-container transition-colors">
                    + Tambah Riwayat Manual
                </button>
            </div>
        </div>

        <!-- RIGHT COLUMN: Calendar Preview -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Calendar Preview Card -->
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-sm p-6 flex flex-col gap-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-h3 text-lg text-on-surface">Kalender Tanam</h3>
                    <span class="material-symbols-outlined text-primary">calendar_month</span>
                </div>
                
                <!-- Mini Timeline -->
                <div class="relative pl-6 border-l-2 border-primary/20 space-y-8">
                    <div class="relative">
                        <div class="absolute -left-[29px] top-0 w-3.5 h-3.5 rounded-full bg-primary border-4 border-white"></div>
                        <p class="text-[10px] font-bold text-primary uppercase">Hari Ini</p>
                        <h4 class="text-sm font-bold text-on-surface mt-1">Cek Saluran Irigasi</h4>
                        <p class="text-xs text-on-surface-variant mt-1">Antisipasi kenaikan curah hujan sesuai peringatan.</p>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-[29px] top-0 w-3.5 h-3.5 rounded-full bg-surface-container border-4 border-white"></div>
                        <p class="text-[10px] font-bold text-on-surface-variant uppercase">28 Mar</p>
                        <h4 class="text-sm font-semibold text-on-surface mt-1">Pemupukan Urea (Fase 2)</h4>
                        <p class="text-xs text-on-surface-variant mt-1">Dosis: 100kg/Ha. Pastikan tanah cukup lembap.</p>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-[29px] top-0 w-3.5 h-3.5 rounded-full bg-surface-container border-4 border-white"></div>
                        <p class="text-[10px] font-bold text-on-surface-variant uppercase">05 Apr</p>
                        <h4 class="text-sm font-semibold text-on-surface mt-1">Monitoring Penyakit Blas</h4>
                        <p class="text-xs text-on-surface-variant mt-1">Waspada jika kelembapan malam > 90%.</p>
                    </div>
                </div>

                <a href="{{ route('calender_planning') }}" class="w-full bg-surface-container hover:bg-surface-container-high text-on-surface py-3 rounded-xl text-sm font-bold transition-all flex items-center justify-center gap-2">
                    Lihat Kalender Lengkap
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>

            <!-- AI Insight Box -->
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
                        Berdasarkan riwayat 2 musim terakhir, lahan ini cenderung memiliki kelembapan tanah yang lebih tinggi. Gemini merekomendasikan pengurangan dosis Nitrogen sebesar 5% untuk mencegah robohnya tanaman saat angin kencang di bulan April nanti.
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
