@extends('layouts.app')

@section('content')
<!-- Main Content Area (Below App Bar) -->
    <div class="flex flex-1 pt-0 md:pt-16 overflow-hidden relative">
        <!-- SideNavBar (Desktop) / Mobile Drawer (Simulated) -->
        <aside
            class="w-72 bg-surface-container-lowest border-r border-outline-variant/30 flex-shrink-0 flex flex-col h-full overflow-y-auto z-10 absolute md:relative transform -translate-x-full md:translate-x-0 transition-transform duration-300">
            <div class="p-container_margin flex flex-col gap-md">
                <!-- Filter Section -->
                <section>
                    <h3 class="font-h3 text-h3 text-on-surface mb-sm">Filter Tampilan</h3>
                    <div class="space-y-sm">
                        <!-- Toggle Chips -->
                        <div class="flex flex-wrap gap-xs">
                            <button
                                class="px-3 py-1.5 rounded-full bg-secondary-container text-on-secondary-container font-small-label text-small-label border border-transparent shadow-sm flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">water_drop</span>
                                Risiko Banjir
                            </button>
                            <button
                                class="px-3 py-1.5 rounded-full bg-surface-container text-on-surface-variant font-small-label text-small-label border border-outline-variant/50 hover:bg-surface-container-high flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">wb_sunny</span>
                                Kekeringan
                            </button>
                            <button
                                class="px-3 py-1.5 rounded-full bg-surface-container text-on-surface-variant font-small-label text-small-label border border-outline-variant/50 hover:bg-surface-container-high flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">bug_report</span>
                                Hama
                            </button>
                            <button
                                class="px-3 py-1.5 rounded-full bg-surface-container text-on-surface-variant font-small-label text-small-label border border-outline-variant/50 hover:bg-surface-container-high flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">air</span>
                                Angin Kencang
                            </button>
                        </div>
                        <!-- Time Selector -->
                        <div class="flex rounded-lg overflow-hidden border border-outline-variant/50">
                            <button
                                class="flex-1 py-1.5 bg-primary-container text-on-primary-container font-small-label text-small-label text-center">Hari
                                Ini</button>
                            <button
                                class="flex-1 py-1.5 bg-surface text-on-surface-variant font-small-label text-small-label text-center border-l border-outline-variant/50 hover:bg-surface-container">Minggu
                                Ini</button>
                            <button
                                class="flex-1 py-1.5 bg-surface text-on-surface-variant font-small-label text-small-label text-center border-l border-outline-variant/50 hover:bg-surface-container">Bulan
                                Depan</button>
                        </div>
                        <!-- Commodity Filter -->
                        <select
                            class="w-full rounded-lg border-outline-variant/50 bg-surface text-on-surface text-body font-body py-2 px-3 focus:ring-primary focus:border-primary">
                            <option>All Komoditas</option>
                            <option>Padi</option>
                            <option>Sayuran</option>
                            <option>Perkebunan</option>
                        </select>
                    </div>
                </section>
                <hr class="border-outline-variant/30" />
                <!-- Lahan Saya -->
                <section>
                    <div class="flex justify-between items-center mb-sm">
                        <h3 class="font-h3 text-h3 text-on-surface">Lahan Saya</h3>
                    </div>
                    <div class="space-y-sm">
                        <!-- Lahan Card 1 -->
                        <div
                            class="bg-surface-bright rounded-xl border border-outline-variant/30 p-sm flex items-center justify-between cursor-pointer hover:shadow-sm transition-shadow">
                            <div class="flex items-center gap-sm">
                                <div
                                    class="w-10 h-10 rounded-lg bg-primary-container/20 flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined">landscape</span>
                                </div>
                                <div>
                                    <p class="font-body text-body text-on-surface font-semibold leading-tight">Sawah
                                        Blok A</p>
                                    <p class="font-small-label text-small-label text-on-surface-variant">Karawang, Jawa
                                        Barat</p>
                                </div>
                            </div>
                            <div class="bg-primary/10 text-primary px-2 py-1 rounded-full flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                <span class="font-small-label text-[11px] font-bold">Optimal</span>
                            </div>
                        </div>
                        <!-- Lahan Card 2 -->
                        <div
                            class="bg-surface-bright rounded-xl border border-outline-variant/30 p-sm flex items-center justify-between cursor-pointer hover:shadow-sm transition-shadow">
                            <div class="flex items-center gap-sm">
                                <div
                                    class="w-10 h-10 rounded-lg bg-secondary-container/20 flex items-center justify-center text-secondary">
                                    <span class="material-symbols-outlined">grass</span>
                                </div>
                                <div>
                                    <p class="font-body text-body text-on-surface font-semibold leading-tight">Ladang
                                        Jagung</p>
                                    <p class="font-small-label text-small-label text-on-surface-variant">Subang, Jawa
                                        Barat</p>
                                </div>
                            </div>
                            <div
                                class="bg-secondary-container/30 text-on-secondary-container px-2 py-1 rounded-full flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">warning</span>
                                <span class="font-small-label text-[11px] font-bold">Waspada</span>
                            </div>
                        </div>
                    </div>
                </section>
                <hr class="border-outline-variant/30" />
                <!-- Laporan Komunitas -->
                <section>
                    <h3 class="font-h3 text-h3 text-on-surface mb-sm">Laporan Komunitas</h3>
                    <div class="space-y-sm mb-md">
                        <div class="flex gap-sm items-start">
                            <div class="w-8 h-8 rounded-full bg-surface-container-high overflow-hidden flex-shrink-0">
                                <img alt="User Avatar" class="w-full h-full object-cover"
                                    data-alt="Portrait of an Indonesian farmer smiling slightly outdoors in natural light"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuC9IembPtyW5UO8fQXSc_UbQgWKEwbexf3MUvhHDQ9F9i9AdVLFp9eX7OK4gq1U0qc9g2GuvqZPD7RSep5g5wqPbhee8oT39aFhwb8-E8l_lhkHNFnr_LIyEkvoX4LUjCwgKp2aUKhanku1sfgYTbc3-bxAEPu-wex3QmAeRsCUPrcAPjoxVuL-TG2XCzzNSF5ef-l-K4Xol-V_qTcOtDtYxZBKZnXo_oifpS2eVtcShVcp-0BI3EOxnMGbkSYbDrW5nzWc6MkCV7I" />
                            </div>
                            <div>
                                <p class="font-small-label text-small-label text-on-surface font-semibold">Budi S. <span
                                        class="text-on-surface-variant font-normal">• 2 jam lalu</span></p>
                                <p
                                    class="font-small-label text-small-label text-on-surface-variant flex items-center gap-1 mt-0.5">
                                    <span class="material-symbols-outlined text-[14px] text-error">water_drop</span>
                                    Banjir ringan di area selatan
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-sm items-start">
                            <div class="w-8 h-8 rounded-full bg-surface-container-high overflow-hidden flex-shrink-0">
                                <img alt="User Avatar" class="w-full h-full object-cover"
                                    data-alt="Portrait of a female Indonesian farmer wearing a sun hat"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuAm31Nmb9Pl9kNG1LLZONgtZg7_183l5wD4v23PWYeB1QL9aaC77q49zwjY6gOtcQIiwtJ0d4DKYg2czXBvV2ekdj_1E8MAAqgHj_Q9Mc6A40cj3I1nCgCTdNML-yx8yXh7Am_WKKOgfUm9ubqXDiaCW5SbzNSarFwoTVsfAVH8W7C6KaCiwV9N9t5yhrlGCEMbvOV0W7xjpo2cqusRtP-wRJc2ZQRq4PeuJx_EasmhMdcG56S7k2iN2O8FA7Y4a5gfT9wmzKOm-Io" />
                            </div>
                            <div>
                                <p class="font-small-label text-small-label text-on-surface font-semibold">Siti A. <span
                                        class="text-on-surface-variant font-normal">• 5 jam lalu</span></p>
                                <p
                                    class="font-small-label text-small-label text-on-surface-variant flex items-center gap-1 mt-0.5">
                                    <span class="material-symbols-outlined text-[14px] text-[#9c27b0]">bug_report</span>
                                    Gejala wereng terlihat
                                </p>
                            </div>
                        </div>
                    </div>
                    <button
                        class="w-full py-2.5 rounded-full bg-primary text-on-primary font-small-label text-small-label font-bold flex justify-center items-center gap-2 hover:bg-surface-tint transition-colors">
                        <span class="material-symbols-outlined">add_location_alt</span>
                        Laporkan Kondisi Saya
                    </button>
                </section>
            </div>
        </aside>
        <!-- Map Area -->
        <main class="flex-1 relative bg-surface-container-low h-full">
            <!-- Simulated Map Background -->
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&amp;fit=crop&amp;q=80')] bg-cover bg-center opacity-40 mix-blend-multiply"
                data-alt="Aerial view of lush green rice terraces in Indonesia, showing varied topography and agricultural plots">
            </div>
            <div
                class="absolute inset-0 bg-gradient-to-b from-surface-container-lowest/50 to-surface-container-lowest/10">
            </div>
            <!-- Map Overlay UI Elements (Simulating the map interactivity) -->
            <div class="absolute inset-0">
                <!-- User Pin (Pulsing) -->
                <div class="absolute top-1/2 left-1/3 transform -translate-x-1/2 -translate-y-1/2">
                    <div class="relative flex h-6 w-6">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                        <span
                            class="relative inline-flex rounded-full h-6 w-6 bg-primary border-2 border-white shadow-md flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-[14px]">home</span>
                        </span>
                    </div>
                </div>
                <!-- Community Pins -->
                <div class="absolute top-[40%] left-[45%] text-error drop-shadow-md">
                    <span class="material-symbols-outlined text-[28px]"
                        style="font-variation-settings: 'FILL' 1;">location_on</span>
                </div>
                <div class="absolute top-[60%] left-[25%] text-secondary-container drop-shadow-md">
                    <span class="material-symbols-outlined text-[28px]"
                        style="font-variation-settings: 'FILL' 1;">location_on</span>
                </div>
                <!-- Map Popup (Visible for demonstration) -->
                <div
                    class="absolute top-1/2 left-1/3 ml-4 mt-[-80px] bg-surface-container-lowest rounded-xl shadow-[0_8px_30px_rgba(27,94,32,0.12)] p-4 w-64 border border-outline-variant/20 z-20">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h4 class="font-body text-body font-bold text-on-surface leading-tight">Kec. Majalaya</h4>
                            <p class="font-small-label text-small-label text-on-surface-variant">Kab. Karawang</p>
                        </div>
                        <div
                            class="bg-primary/10 text-primary px-2 py-0.5 rounded text-[10px] font-bold border border-primary/20">
                            Optimal
                        </div>
                    </div>
                    <div class="space-y-2 mt-3">
                        <div class="flex items-center gap-2 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[16px] text-tertiary">rainy</span>
                            <span class="font-small-label text-[12px]">Hujan: 12mm (3 Hari: Ringan)</span>
                        </div>
                        <div class="flex items-center gap-2 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[16px] text-primary">groups</span>
                            <span class="font-small-label text-[12px]">142 Petani Aktif</span>
                        </div>
                        <div class="flex items-center gap-2 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[16px] text-secondary">campaign</span>
                            <span class="font-small-label text-[12px]">3 Laporan Terbaru</span>
                        </div>
                    </div>
                    <a class="mt-4 block text-center font-small-label text-small-label text-primary font-bold hover:underline"
                        href="#">Lihat Detail Area</a>
                </div>
            </div>
            <!-- Map Controls -->
            <div class="absolute right-4 top-4 flex flex-col gap-2">
                <button
                    class="w-10 h-10 bg-surface-container-lowest rounded-lg shadow-sm border border-outline-variant/20 flex items-center justify-center text-on-surface hover:bg-surface-container">
                    <span class="material-symbols-outlined">add</span>
                </button>
                <button
                    class="w-10 h-10 bg-surface-container-lowest rounded-lg shadow-sm border border-outline-variant/20 flex items-center justify-center text-on-surface hover:bg-surface-container">
                    <span class="material-symbols-outlined">remove</span>
                </button>
                <button
                    class="w-10 h-10 bg-surface-container-lowest rounded-lg shadow-sm border border-outline-variant/20 flex items-center justify-center text-primary mt-2 hover:bg-surface-container">
                    <span class="material-symbols-outlined">my_location</span>
                </button>
            </div>
            <!-- Bottom Data Attribution & Legend Overlay -->
            <div
                class="absolute bottom-4 left-4 right-4 md:right-auto bg-surface-container-lowest/90 backdrop-blur-sm rounded-xl border border-outline-variant/20 shadow-sm p-3 flex flex-col sm:flex-row items-center gap-4 text-xs font-small-label justify-between md:min-w-[400px]">
                <div class="text-on-surface-variant flex gap-3 flex-wrap justify-center">
                    <span>Sumber: BMKG</span>
                    <span class="text-outline-variant">|</span>
                    <span>Risiko: BNPB</span>
                    <span class="text-outline-variant">|</span>
                    <span>Komunitas: TaniSiaga</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-on-surface font-semibold mr-1">Risiko:</span>
                    <div class="flex items-center gap-1" title="Optimal">
                        <div class="w-3 h-3 rounded-full bg-primary"></div>
                    </div>
                    <div class="flex items-center gap-1" title="Baik">
                        <div class="w-3 h-3 rounded-full bg-[#8bc34a]"></div>
                    </div>
                    <div class="flex items-center gap-1" title="Waspada">
                        <div class="w-3 h-3 rounded-full bg-secondary-container"></div>
                    </div>
                    <div class="flex items-center gap-1" title="Kritis">
                        <div class="w-3 h-3 rounded-full bg-error"></div>
                    </div>
                    <div class="flex items-center gap-1" title="Alert Hama">
                        <div class="w-3 h-3 rounded-full bg-[#9c27b0]"></div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
