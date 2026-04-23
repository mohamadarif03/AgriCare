@extends('layouts.app')

@section('content')
<div class="flex flex-1 overflow-hidden">
        <!-- Main Content Area (3 Panels) -->
        <main class="flex-1 flex overflow-hidden bg-surface">
            <!-- Panel 1: Chat History -->
            <aside class="w-72 border-r border-outline-variant bg-surface-container-lowest hidden lg:flex flex-col">
                <div class="p-4">
                    <button
                        class="w-full bg-surface-container hover:bg-surface-container-high text-primary rounded-xl py-3 px-4 font-body font-medium flex justify-start items-center gap-3 border border-outline-variant transition-colors">
                        <span class="material-symbols-outlined" data-icon="add">add</span>
                        + Chat Baru
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto px-2 pb-4">
                    <div class="px-3 py-2 text-small-label text-on-surface-variant font-h3 mb-1">Hari Ini</div>
                    <a class="block bg-surface-container-low rounded-lg p-3 mx-2 mb-1 border-l-4 border-primary"
                        href="#">
                        <p class="font-body text-sm font-medium text-on-surface truncate">Analisis Cuaca Panen</p>
                        <p class="text-xs text-on-surface-variant mt-1">10:42 AM</p>
                    </a>
                    <a class="block hover:bg-surface-container rounded-lg p-3 mx-2 mb-1 transition-colors" href="#">
                        <p class="font-body text-sm text-on-surface truncate">Penyakit Daun Kuning</p>
                        <p class="text-xs text-on-surface-variant mt-1">08:15 AM</p>
                    </a>
                    <div class="px-3 py-2 text-small-label text-on-surface-variant font-h3 mt-4 mb-1">Kemarin</div>
                    <a class="block hover:bg-surface-container rounded-lg p-3 mx-2 mb-1 transition-colors" href="#">
                        <p class="font-body text-sm text-on-surface truncate">Jadwal Pemupukan Padi</p>
                        <p class="text-xs text-on-surface-variant mt-1">14:30 PM</p>
                    </a>
                    <a class="block hover:bg-surface-container rounded-lg p-3 mx-2 mb-1 transition-colors" href="#">
                        <p class="font-body text-sm text-on-surface truncate">Harga Gabah Terkini</p>
                        <p class="text-xs text-on-surface-variant mt-1">09:00 AM</p>
                    </a>
                </div>
            </aside>
            <!-- Panel 2: Center Chat Area -->
            <section class="flex-1 flex flex-col min-w-0 bg-surface-bright relative">
                <!-- Chat Messages Header (Mobile/Tablet) -->
                <div
                    class="lg:hidden p-4 border-b border-outline-variant flex justify-between items-center bg-surface-container-lowest">
                    <h2 class="font-h3 text-h3 text-on-surface">TaniBot</h2>
                    <button class="p-2 text-primary rounded-full hover:bg-surface-container">
                        <span class="material-symbols-outlined" data-icon="menu">menu</span>
                    </button>
                </div>
                <!-- Messages -->
                <div class="flex-1 overflow-y-auto p-4 md:p-gutter flex flex-col gap-6">
                    <!-- Farmer Message -->
                    <div class="flex flex-col items-end gap-1">
                        <div
                            class="bg-primary text-on-primary rounded-2xl rounded-tr-none px-5 py-3 max-w-[85%] md:max-w-[75%] shadow-[0_2px_8px_rgba(27,94,32,0.08)]">
                            <p class="font-body text-body">TaniBot, besok diperkirakan akan hujan deras. Padi saya baru
                                berumur 45 hari. Apakah aman?</p>
                        </div>
                        <span class="text-xs text-on-surface-variant px-2">10:42 AM</span>
                    </div>
                    <!-- Bot Message -->
                    <div class="flex items-start gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center flex-shrink-0 mt-1">
                            <span class="material-symbols-outlined text-on-primary-container text-sm"
                                data-icon="psychology" style="font-variation-settings: 'FILL' 1;">psychology</span>
                        </div>
                        <div class="flex flex-col items-start gap-1 max-w-[85%] md:max-w-[75%]">
                            <div
                                class="bg-surface-container-lowest border border-outline-variant rounded-2xl rounded-tl-none px-5 py-4 shadow-sm">
                                <p class="font-body text-body text-on-surface mb-3">
                                    Halo Pak. Pada umur 45 hari, padi Anda sedang memasuki fase <strong
                                        class="text-primary">Primordia (pembentukan malai)</strong>. Ini fase kritis.
                                </p>
                                <p class="font-body text-body text-on-surface mb-3">
                                    Hujan deras tidak masalah, <strong>tetapi perhatikan hal berikut:</strong>
                                </p>
                                <ul class="list-disc pl-5 font-body text-body text-on-surface space-y-2">
                                    <li>Pastikan saluran pembuangan air (drainase) lancar agar tanaman tidak terendam
                                        terlalu lama.</li>
                                    <li>Hindari pemupukan Nitrogen (Urea) tepat sebelum hujan agar pupuk tidak tercuci.
                                    </li>
                                    <li>Waspada serangan jamur (seperti Blas) karena kelembapan tinggi setelah hujan.
                                    </li>
                                </ul>
                            </div>
                            <span class="text-xs text-on-surface-variant px-2">10:43 AM</span>
                        </div>
                    </div>
                    <!-- Farmer Message -->
                    <div class="flex flex-col items-end gap-1">
                        <div
                            class="bg-primary text-on-primary rounded-2xl rounded-tr-none px-5 py-3 max-w-[85%] md:max-w-[75%] shadow-[0_2px_8px_rgba(27,94,32,0.08)]">
                            <p class="font-body text-body">Bagaimana cara mencegah jamur Blas itu?</p>
                        </div>
                        <span class="text-xs text-on-surface-variant px-2">10:45 AM</span>
                    </div>
                    <!-- Bot Message (Typing indicator placeholder) -->
                    <div class="flex items-start gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-on-primary-container text-sm"
                                data-icon="psychology" style="font-variation-settings: 'FILL' 1;">psychology</span>
                        </div>
                        <div
                            class="bg-surface-container-lowest border border-outline-variant rounded-2xl rounded-tl-none px-4 py-3 shadow-sm flex gap-1 items-center h-10">
                            <div class="w-2 h-2 rounded-full bg-outline-variant animate-pulse"></div>
                            <div class="w-2 h-2 rounded-full bg-outline-variant animate-pulse"
                                style="animation-delay: 0.2s"></div>
                            <div class="w-2 h-2 rounded-full bg-outline-variant animate-pulse"
                                style="animation-delay: 0.4s"></div>
                        </div>
                    </div>
                </div>
                <!-- Input Area -->
                <div class="p-4 bg-surface-container-lowest border-t border-outline-variant">
                    <!-- Suggested Chips -->
                    <div class="flex gap-2 overflow-x-auto pb-3 no-scrollbar">
                        <button
                            class="whitespace-nowrap px-4 py-1.5 rounded-full border border-outline-variant text-small-label font-small-label text-on-surface hover:bg-surface-container transition-colors flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]" data-icon="water_drop">water_drop</span>
                            Cek Jadwal Irigasi
                        </button>
                        <button
                            class="whitespace-nowrap px-4 py-1.5 rounded-full border border-outline-variant text-small-label font-small-label text-on-surface hover:bg-surface-container transition-colors flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]"
                                data-icon="pest_control">pest_control</span> Info Obat Jamur
                        </button>
                        <button
                            class="whitespace-nowrap px-4 py-1.5 rounded-full border border-outline-variant text-small-label font-small-label text-on-surface hover:bg-surface-container transition-colors flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]" data-icon="thermostat">thermostat</span>
                            Prediksi Cuaca Besok
                        </button>
                    </div>
                    <!-- Input Bar -->
                    <div class="relative flex items-center">
                        <button class="absolute left-3 p-2 text-outline hover:text-primary transition-colors">
                            <span class="material-symbols-outlined" data-icon="attach_file">attach_file</span>
                        </button>
                        <input
                            class="w-full bg-surface-container pl-12 pr-14 py-4 rounded-full border-none focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest font-body text-body text-on-surface placeholder-on-surface-variant transition-all shadow-sm"
                            placeholder="Ketik pertanyaan tentang lahan Anda..." type="text" />
                        <button
                            class="absolute right-3 p-2 bg-primary text-on-primary rounded-full hover:bg-primary-container transition-colors shadow-sm">
                            <span class="material-symbols-outlined" data-icon="send">send</span>
                        </button>
                    </div>
                    <div class="text-center mt-2">
                        <span class="text-[11px] text-on-surface-variant font-body">TaniBot AI dapat membuat kesalahan.
                            Harap verifikasi info penting.</span>
                    </div>
                </div>
            </section>
            <!-- Panel 3: Context Panel -->
            <aside
                class="w-80 border-l border-outline-variant bg-surface-container-lowest hidden xl:flex flex-col overflow-y-auto p-4 gap-4">
                <h3 class="font-h3 text-h3 text-on-surface mb-2">Konteks Lahan</h3>
                <!-- Weather Mini Card -->
                <div class="bg-surface-container-high rounded-xl p-4 border border-outline-variant">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary"
                                data-icon="partly_cloudy_day">partly_cloudy_day</span>
                            <span
                                class="font-small-label text-small-label text-on-surface-variant uppercase tracking-wider">Cuaca
                                Saat Ini</span>
                        </div>
                        <span class="text-xs font-medium text-on-surface-variant">Sukabumi</span>
                    </div>
                    <div class="flex items-end gap-3 mb-2">
                        <span class="font-h1 text-h1 text-on-surface leading-none">28°</span>
                        <span class="font-body text-body text-on-surface-variant pb-1">Berawan</span>
                    </div>
                    <div class="flex gap-4 mt-3 pt-3 border-t border-outline-variant/50">
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px] text-tertiary"
                                data-icon="humidity_percentage">humidity_percentage</span>
                            <span class="text-xs text-on-surface">75%</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px] text-tertiary"
                                data-icon="rainy">rainy</span>
                            <span class="text-xs text-on-surface">60% (Besok)</span>
                        </div>
                    </div>
                </div>
                <!-- Risk Badge -->
                <div
                    class="bg-surface-container-highest rounded-xl p-4 border border-outline-variant flex items-start gap-3">
                    <div
                        class="w-10 h-10 rounded-full bg-secondary-fixed flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-on-secondary-fixed"
                            data-icon="warning">warning</span>
                    </div>
                    <div>
                        <h4 class="font-body font-semibold text-on-surface text-sm">Risiko Menengah</h4>
                        <p class="text-xs text-on-surface-variant mt-1 leading-relaxed">Fase Primordia rentan terhadap
                            genangan air berlebih. Pantau drainase.</p>
                    </div>
                </div>
                <!-- Pest Alert -->
                <div class="bg-error-container/30 rounded-xl p-4 border border-error-container flex flex-col gap-2">
                    <div class="flex items-center gap-2 text-error">
                        <span class="material-symbols-outlined text-[20px]" data-icon="pest_control">pest_control</span>
                        <span class="font-small-label text-small-label font-bold">Waspada Hama</span>
                    </div>
                    <p class="text-sm font-body text-on-surface">Potensi serangan <strong>Wereng Coklat</strong>
                        meningkat karena kelembapan tinggi di area Anda.</p>
                    <button
                        class="mt-2 text-xs font-semibold text-primary flex items-center gap-1 hover:underline w-fit">
                        Lihat Panduan Mitigasi <span class="material-symbols-outlined text-[14px]"
                            data-icon="arrow_forward">arrow_forward</span>
                    </button>
                </div>
                <!-- Field Image Context -->
                <div class="mt-auto pt-4">
                    <div class="relative h-32 rounded-lg overflow-hidden border border-outline-variant shadow-sm">
                        <img alt="Lahan Padi" class="w-full h-full object-cover"
                            data-alt="aerial view of lush green rice paddy fields in Indonesia under bright sunlight"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuC2kTekf-18EHGXGct4xTbPZEd7xD5v6KoIXoEZTA1HxQeDu_HRw8ike_Jxr1Rs90e8Y7KythvnywdTtI_NhgT7g8bLdkc7rC10p-88MEFQLBTtRgOL3r8rO0BdwlQOME4Ssp2hQYe9-OTI78-zlUe92j7dVCZg6LmY3ldEyqelQ6JoqZzObjwOf9lTI-a4p_U7gEddMhgYGoIPHJcLq3vfBnsUqrIxZ_z853JRM2Z99NXyYvdBpq1cc3QCez_PNc67uPWWIL3oTnk" />
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-2">
                            <span class="text-white text-xs font-medium">Lahan Blok A - 45 HST</span>
                        </div>
                    </div>
                </div>
            </aside>
        </main>
    </div>
@endsection
