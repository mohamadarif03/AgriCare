@extends('layouts.app')

@section('content')
<!-- Main Content Area -->
    <main class="flex-grow w-full max-w-[1600px] mx-auto px-4 xl:px-6 py-6 md:py-8 flex flex-col gap-6">
        <!-- Page Header -->
        <section class="flex flex-col gap-3">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h2 class="font-h2 text-h2 text-on-surface">Radar Harga Pasar</h2>
                    <p class="font-body text-body text-on-surface-variant mt-1">Data harga komoditas realtime — Panel
                        Harga Pangan Kementan</p>
                </div>
                <div
                    class="inline-flex items-center gap-2 bg-primary-container/10 px-4 py-2 rounded-full self-start md:self-auto border border-primary-container/20">
                    <span class="material-symbols-outlined text-primary text-sm">grass</span>
                    <span class="font-small-label text-small-label text-primary">Komoditas aktif: Padi</span>
                    <button class="ml-2 text-on-surface-variant hover:text-primary"><span
                            class="material-symbols-outlined text-sm">expand_more</span></button>
                </div>
            </div>
        </section>
        <!-- Top Row: Price Cards (Bento Grid Style) -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
            <!-- Card 1: Primary -->
            <div
                class="col-span-1 md:col-span-2 bg-surface-container-lowest rounded-[12px] p-6 border border-surface-variant shadow-[0_4px_20px_rgba(27,94,32,0.04)] relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-8xl text-primary"
                        style="font-variation-settings: 'FILL' 1;">eco</span>
                </div>
                <div class="relative z-10 flex flex-col gap-4 h-full justify-between">
                    <div>
                        <div class="flex items-center gap-2 text-on-surface-variant mb-2">
                            <span class="material-symbols-outlined text-sm">payments</span>
                            <span class="font-small-label text-small-label">Harga Padi Hari Ini</span>
                        </div>
                        <h3 class="font-h1 text-h1 text-primary mb-1">Rp 5.200 <span
                                class="text-h3 font-h3 text-outline">/ kg</span></h3>
                        <div class="flex items-center gap-1 text-on-surface-variant">
                            <span class="material-symbols-outlined text-sm">location_on</span>
                            <span class="font-small-label text-small-label">Cilacap, Jawa Tengah</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="inline-flex items-center gap-1 bg-primary/10 text-primary px-3 py-1 rounded-full">
                            <span class="material-symbols-outlined text-sm">trending_up</span>
                            <span class="font-small-label text-small-label font-bold">+3.2% vs kemarin</span>
                        </div>
                        <div
                            class="inline-flex items-center gap-1 bg-tertiary-container/10 text-tertiary px-3 py-1 rounded-full border border-tertiary-container/20">
                            <span class="material-symbols-outlined text-sm">smart_toy</span>
                            <span class="font-small-label text-small-label">Tahan — Harga diprediksi naik</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-1 flex flex-col gap-gutter">
                <!-- Card 2 -->
                <div
                    class="bg-surface-container-lowest rounded-[12px] p-5 border border-surface-variant shadow-[0_4px_20px_rgba(27,94,32,0.04)] flex-1 flex flex-col justify-center">
                    <span class="font-small-label text-small-label text-on-surface-variant mb-1">Harga Tertinggi Bulan
                        Ini</span>
                    <div class="flex items-baseline gap-2">
                        <span class="font-h3 text-h3 text-on-surface">Rp 5.450<span
                                class="text-sm text-outline">/kg</span></span>
                    </div>
                    <span class="font-small-label text-small-label text-outline mt-1">12 Oktober 2023</span>
                </div>
                <!-- Card 3 -->
                <div
                    class="bg-surface-container-lowest rounded-[12px] p-5 border border-surface-variant shadow-[0_4px_20px_rgba(27,94,32,0.04)] flex-1 flex flex-col justify-center">
                    <span class="font-small-label text-small-label text-on-surface-variant mb-1">Prediksi Minggu
                        Depan</span>
                    <div class="flex items-baseline gap-2 mb-2">
                        <span class="font-h3 text-h3 text-on-surface">Rp 5.300-5.500</span>
                    </div>
                    <div
                        class="inline-flex items-center gap-1 bg-secondary-container/20 text-secondary-fixed-dim px-3 py-1 rounded-full w-fit">
                        <span class="material-symbols-outlined text-sm">moving</span>
                        <span class="font-small-label text-small-label font-bold">Naik</span>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
