@extends('layouts.app')

@section('content')
<main class="flex-grow w-full max-w-[1600px] mx-auto px-4 xl:px-6 py-6 md:py-8 flex flex-col gap-6">
    
    <!-- Header -->
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('dashboard') }}" class="p-2 -ml-2 text-on-surface-variant hover:text-primary hover:bg-surface-container rounded-full transition-colors flex items-center justify-center">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="font-h2 text-h2 text-on-surface leading-tight">Tambah Lahan Baru</h1>
            <p class="font-body text-sm text-on-surface-variant mt-1">Daftarkan area tanam Anda untuk mendapatkan analisis iklim, deteksi hama, dan rekomendasi AI.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Form Section -->
        <div class="lg:col-span-8">
            <form action="#" method="POST" class="bg-surface-container-lowest rounded-2xl p-6 md:p-8 shadow-[0_4px_20px_rgba(27,94,32,0.03)] border border-outline-variant/30 space-y-6">
                
                <!-- Nama Lahan -->
                <div>
                    <label for="land_name" class="block text-sm font-semibold text-on-surface mb-2">Nama Lahan</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px]">landscape</span>
                        <input type="text" id="land_name" name="land_name" placeholder="Misal: Sawah Blok A, Kebun Cabai Ciawi" class="w-full pl-11 pr-4 py-3 rounded-xl bg-surface-container-low border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none transition-all placeholder:text-outline-variant" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Komoditas -->
                    <div>
                        <label for="commodity" class="block text-sm font-semibold text-on-surface mb-2">Komoditas Utama</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px]">grass</span>
                            <select id="commodity" name="commodity" class="w-full pl-11 pr-10 py-3 rounded-xl bg-surface-container-low border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none appearance-none cursor-pointer transition-all" required>
                                <option value="" disabled selected>Pilih tanaman...</option>
                                <option value="padi">Padi</option>
                                <option value="jagung">Jagung</option>
                                <option value="cabai">Cabai</option>
                                <option value="bawang_merah">Bawang Merah</option>
                                <option value="kedelai">Kedelai</option>
                                <option value="lainnya">Lainnya...</option>
                            </select>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px] pointer-events-none">expand_more</span>
                        </div>
                    </div>

                    <!-- Luas Lahan -->
                    <div>
                        <label for="area_size" class="block text-sm font-semibold text-on-surface mb-2">Luas Lahan</label>
                        <div class="flex gap-2">
                            <input type="number" id="area_size" name="area_size" step="0.01" placeholder="0.0" class="w-full px-4 py-3 rounded-xl bg-surface-container-low border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none transition-all placeholder:text-outline-variant" required>
                            <select name="area_unit" class="w-28 px-3 py-3 rounded-xl bg-surface-container-low border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none cursor-pointer transition-all">
                                <option value="ha">Hektar (Ha)</option>
                                <option value="m2">Meter Persegi (m²)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Tanggal Tanam -->
                <div>
                    <label for="planting_date" class="block text-sm font-semibold text-on-surface mb-2">Perkiraan Tanggal Tanam</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px]">calendar_month</span>
                        <input type="date" id="planting_date" name="planting_date" class="w-full pl-11 pr-4 py-3 rounded-xl bg-surface-container-low border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none transition-all cursor-text text-outline" required>
                    </div>
                    <p class="text-xs text-on-surface-variant mt-2 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">info</span> Digunakan untuk memprediksi fase pertumbuhan dan rekomendasi AI.</p>
                </div>

                <!-- Lokasi Peta (Visual) -->
                <div>
                    <div class="flex justify-between items-end mb-2">
                        <label class="block text-sm font-semibold text-on-surface">Lokasi Lahan</label>
                        <button type="button" class="text-xs font-semibold text-primary hover:text-primary-container flex items-center gap-1 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">my_location</span> Gunakan Lokasi Saat Ini
                        </button>
                    </div>
                    <!-- Map Placeholder -->
                    <div class="w-full h-48 bg-surface-container rounded-xl border border-outline-variant/50 relative overflow-hidden flex items-center justify-center group cursor-pointer">
                        <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Map placeholder" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                        <div class="relative z-10 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-lg shadow-sm flex items-center gap-2 group-hover:-translate-y-1 transition-transform">
                            <span class="material-symbols-outlined text-red-500">location_on</span>
                            <span class="text-sm font-semibold text-on-surface">Tandai Lokasi di Peta</span>
                        </div>
                    </div>
                    <input type="text" class="w-full mt-3 px-4 py-3 rounded-xl bg-surface-container-low border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none transition-all placeholder:text-outline-variant" placeholder="Atau ketik alamat / nama desa...">
                </div>

                <!-- Submit Buttons -->
                <div class="pt-4 flex flex-col sm:flex-row items-center gap-3 justify-end border-t border-outline-variant/30">
                    <button type="button" class="w-full sm:w-auto px-6 py-2.5 rounded-xl text-sm font-semibold text-on-surface-variant bg-surface hover:bg-surface-container transition-colors" onclick="window.location.href='{{ route('dashboard') }}'">Batal</button>
                    <button type="button" class="w-full sm:w-auto px-6 py-2.5 rounded-xl text-sm font-semibold text-on-primary bg-primary hover:bg-primary-container shadow-md hover:shadow-lg transition-all active:scale-95 flex items-center justify-center gap-2" onclick="window.location.href='{{ route('dashboard') }}'">
                        <span class="material-symbols-outlined text-[18px]">save</span> Simpan Lahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar Info -->
        <div class="lg:col-span-4 space-y-6">
            <!-- TaniBot Tip -->
            <div class="bg-primary-container/10 rounded-2xl p-6 border border-primary-container/20 relative overflow-hidden">
                <div class="absolute -right-6 -top-6 text-primary/10 rotate-12">
                    <span class="material-symbols-outlined" style="font-size: 120px;">psychiatry</span>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 text-primary font-bold mb-3">
                        <span class="material-symbols-outlined">lightbulb</span> Tips TaniBot
                    </div>
                    <p class="text-sm text-on-surface-variant font-body leading-relaxed mb-4">
                        Memasukkan <strong>tanggal tanam</strong> dan <strong>lokasi akurat</strong> sangat penting! TaniBot akan menyesuaikan prediksi cuaca mikro dan peringatan hama khusus untuk area lahan Anda.
                    </p>
                    <div class="text-xs text-primary font-semibold flex items-center gap-1 cursor-pointer hover:underline">
                        Pelajari lebih lanjut <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    </div>
                </div>
            </div>

            <!-- Manfaat Tracker -->
            <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-[0_2px_12px_rgba(27,94,32,0.02)] border border-outline-variant/30">
                <h3 class="font-h3 text-h3 text-on-surface mb-4">Keuntungan Mendaftarkan Lahan:</h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="material-symbols-outlined text-[18px]">partly_cloudy_day</span>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-on-surface">Radar Cuaca Spesifik</h4>
                            <p class="text-xs text-on-surface-variant mt-0.5">Prakiraan cuaca hingga tingkat desa Anda.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="material-symbols-outlined text-[18px]">pest_control</span>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-on-surface">Peringatan Hama Dini</h4>
                            <p class="text-xs text-on-surface-variant mt-0.5">Notifikasi langsung jika ada sebaran hama di area sekitar.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="material-symbols-outlined text-[18px]">trending_up</span>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-on-surface">Kalender Pintar</h4>
                            <p class="text-xs text-on-surface-variant mt-0.5">Pengingat jadwal pupuk & panen otomatis via AI.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</main>
@endsection
