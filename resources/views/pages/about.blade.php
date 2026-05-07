@extends('layouts.app')

@section('content')
<div class="px-4 xl:px-6 w-full max-w-[1200px] mx-auto py-8 lg:py-12 flex-1">
    
    <!-- Hero Section -->
    <div class="mb-10 md:mb-16 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold text-green-800 dark:text-green-400 tracking-tight mb-4">Tentang PastiPanen</h1>
        <p class="text-lg md:text-xl text-slate-600 dark:text-slate-300 max-w-3xl mx-auto leading-relaxed">
            Mitra terbaik Anda dalam mencapai pertanian yang cerdas, efisien, dan berkelanjutan.
        </p>
    </div>

    <!-- Content Sections -->
    <div class="space-y-12">
        
        <!-- Visi & Misi -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 md:p-12 shadow-sm border border-green-100 dark:border-slate-700">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 rounded-2xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400">
                    <span class="material-symbols-outlined text-[28px]">visibility</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-800 dark:text-white">Visi & Misi Kami</h2>
            </div>
            <div class="prose prose-lg prose-green dark:prose-invert max-w-none text-slate-600 dark:text-slate-300">
                <p>
                    <strong>PastiPanen</strong> hadir dengan visi untuk memodernisasi sektor pertanian Indonesia melalui pemanfaatan teknologi kecerdasan buatan (AI) dan data real-time. Kami percaya bahwa setiap petani berhak mendapatkan akses informasi yang akurat dan tepat waktu untuk mengoptimalkan hasil panen mereka.
                </p>
                <p>
                    Misi kami adalah:
                </p>
                <ul class="space-y-2 mt-4 list-disc pl-6">
                    <li>Menyediakan prediksi cuaca terakurat untuk setiap jengkal lahan pertanian.</li>
                    <li>Memberikan rekomendasi jadwal tanam berbasis data iklim dan kondisi tanah.</li>
                    <li>Memfasilitasi deteksi dini terhadap serangan hama dan penyakit tanaman menggunakan AI.</li>
                    <li>Menyajikan informasi harga pasar terkini untuk membantu petani mendapatkan keuntungan maksimal.</li>
                </ul>
            </div>
        </div>

        <!-- Keunggulan -->
        <div class="grid md:grid-cols-2 gap-6 md:gap-8">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-sm border border-green-100 dark:border-slate-700">
                <div class="w-12 h-12 rounded-2xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 mb-6">
                    <span class="material-symbols-outlined text-[28px]">smart_toy</span>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3">Teknologi AI Terdepan</h3>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                    Didukung oleh algoritma cerdas yang mampu menganalisis ribuan data point untuk memberikan rekomendasi spesifik yang disesuaikan dengan lahan Anda.
                </p>
            </div>
            
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-sm border border-green-100 dark:border-slate-700">
                <div class="w-12 h-12 rounded-2xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-600 dark:text-orange-400 mb-6">
                    <span class="material-symbols-outlined text-[28px]">eco</span>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3">Berpusat pada Petani</h3>
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                    Setiap fitur yang kami bangun didesain dengan mempertimbangkan kemudahan penggunaan, bahkan untuk mereka yang baru mengenal teknologi digital.
                </p>
            </div>
        </div>

        <!-- Tim Kami -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-slate-800 dark:to-slate-800/80 rounded-3xl p-8 md:p-12 shadow-sm border border-green-100 dark:border-slate-700">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-3xl font-bold text-slate-800 dark:text-white mb-4">Membangun Ekosistem Pertanian Modern</h2>
                <p class="text-slate-600 dark:text-slate-300 max-w-2xl mx-auto">
                    Kami terus berinovasi dan berkolaborasi dengan berbagai pihak untuk memastikan PastiPanen selalu relevan dengan kebutuhan pertanian masa depan.
                </p>
            </div>
            
            <div class="flex justify-center mt-8">
                <a href="{{ route('dashboard') }}" class="px-8 py-4 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-2xl transition-all hover:scale-105 active:scale-95 shadow-lg shadow-green-600/20">
                    Mulai Gunakan PastiPanen
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
