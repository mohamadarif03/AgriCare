<nav class="sticky top-0 w-full z-50 bg-white/95 backdrop-blur-md dark:bg-slate-900/95 border-b border-green-100/50 dark:border-slate-800 shadow-sm shadow-green-900/5 font-['Plus_Jakarta_Sans']">
    <div class="px-4 xl:px-6 w-full max-w-[1600px] mx-auto">
        <div class="flex items-center justify-between h-16 gap-4">
            <!-- Kiri: Logo -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 shrink-0">
                <span class="material-symbols-outlined text-green-700 dark:text-green-500 text-[28px]" style="font-variation-settings: 'FILL' 1;">eco</span>
                <span class="text-xl font-extrabold text-green-700 dark:text-green-500 tracking-tighter hidden md:block">TaniSiaga</span>
            </a>

            <!-- Tengah: Menu Navigasi -->
            <div class="hidden xl:flex items-center gap-1 flex-1 justify-center">
                <a href="{{ route('dashboard') }}" class="px-3 py-2 text-sm font-semibold transition-colors whitespace-nowrap {{ request()->routeIs('dashboard') ? 'text-green-700 dark:text-green-400 border-b-2 border-green-700 dark:border-green-400' : 'text-slate-600 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300' }}">Dashboard</a>
                <a href="{{ route('calender_planning') }}" class="px-3 py-2 text-sm font-semibold transition-colors whitespace-nowrap {{ request()->routeIs('calender_planning') ? 'text-green-700 dark:text-green-400 border-b-2 border-green-700 dark:border-green-400' : 'text-slate-600 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300' }}">Kalender Tanam</a>
                <a href="{{ route('pest_detection_alert') }}" class="px-3 py-2 text-sm font-semibold transition-colors whitespace-nowrap {{ request()->routeIs('pest_detection_alert') ? 'text-green-700 dark:text-green-400 border-b-2 border-green-700 dark:border-green-400' : 'text-slate-600 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300' }}">Deteksi Hama</a>
                <a href="{{ route('market_price') }}" class="px-3 py-2 text-sm font-semibold transition-colors whitespace-nowrap {{ request()->routeIs('market_price') ? 'text-green-700 dark:text-green-400 border-b-2 border-green-700 dark:border-green-400' : 'text-slate-600 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300' }}">Radar Harga</a>
                <a href="{{ route('riskmap') }}" class="px-3 py-2 text-sm font-semibold transition-colors whitespace-nowrap {{ request()->routeIs('riskmap') ? 'text-green-700 dark:text-green-400 border-b-2 border-green-700 dark:border-green-400' : 'text-slate-600 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300' }}">Peta Risiko</a>
                <a href="{{ route('tanibot') }}" class="px-3 py-2 text-sm font-semibold transition-colors whitespace-nowrap {{ request()->routeIs('tanibot') ? 'text-green-700 dark:text-green-400 border-b-2 border-green-700 dark:border-green-400' : 'text-slate-600 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300' }}">Komunitas</a>
                <a href="{{ route('ai_reccomendation') }}" class="px-3 py-2 text-sm font-semibold transition-colors whitespace-nowrap {{ request()->routeIs('ai_reccomendation') ? 'text-green-700 dark:text-green-400 border-b-2 border-green-700 dark:border-green-400' : 'text-slate-600 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300' }}">Rekomendasi</a>
            </div>

            <!-- Kanan: User Area -->
            <div class="flex items-center gap-3 shrink-0">
                <button class="relative p-2 text-slate-500 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-400 transition-colors rounded-full hover:bg-slate-100 dark:hover:bg-slate-800">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white dark:border-slate-900"></span>
                </button>
                
                <!-- Avatar Dropdown -->
                <div class="relative group cursor-pointer">
                    <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-green-100 dark:border-green-900 hover:border-green-300 transition-colors">
                        <img alt="User profile" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAiaOkqtKvpONSNSfG7t2BTmSea82V4J5sOVkoufLpc1HBZcIjGYg3X8jlq9TXt2cUMtG8QbpNk4LNICnmhIckd-kSb70pI9HUEGpM3Ks5N1Jzv9zKqNPVIevc31fyaxVBlnakxlp96Qig5fRgFN4VWQpA8_yHZOAh2xorQbJD2mBxXrBX8I0yTEW82z4BKm6F0UKCwZtem4dTDvhHTzrMxE6nu4UY3f8NdJ20dmT3eYUE72FFS_Ri5UeaKP_KrgK9pyZWIMYbmyS4" />
                    </div>
                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-100 dark:border-slate-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right translate-y-2 group-hover:translate-y-0 z-50">
                        <div class="py-2 flex flex-col">
                            <a href="#" class="px-4 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-green-50 dark:hover:bg-slate-700 hover:text-green-700 dark:hover:text-green-400 flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">person</span> Profil Saya</a>
                            <a href="{{ route('manage_lands') }}" class="px-4 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-green-50 dark:hover:bg-slate-700 hover:text-green-700 dark:hover:text-green-400 flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">agriculture</span> Kelola Lahan</a>
                            <a href="{{ route('add_land') }}" class="px-4 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-green-50 dark:hover:bg-slate-700 hover:text-green-700 dark:hover:text-green-400 flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">add_location_alt</span> Tambah Lahan</a>
                            <a href="#" class="px-4 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-green-50 dark:hover:bg-slate-700 hover:text-green-700 dark:hover:text-green-400 flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">settings</span> Pengaturan</a>
                            <div class="h-px bg-slate-100 dark:bg-slate-700 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-3"><span class="material-symbols-outlined text-[20px]">logout</span> Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile/Tablet Menu (Scrollable horizontally) -->
        <div class="flex xl:hidden overflow-x-auto no-scrollbar py-2 border-t border-slate-100 dark:border-slate-800 gap-6 mt-1">
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold whitespace-nowrap {{ request()->routeIs('dashboard') ? 'text-green-700 dark:text-green-400 border-b-2 border-green-700 dark:border-green-400 pb-1' : 'text-slate-600 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300' }}">Dashboard</a>
            <a href="{{ route('calender_planning') }}" class="text-sm font-semibold whitespace-nowrap {{ request()->routeIs('calender_planning') ? 'text-green-700 dark:text-green-400 border-b-2 border-green-700 dark:border-green-400 pb-1' : 'text-slate-600 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300' }}">Kalender Tanam</a>
            <a href="{{ route('pest_detection_alert') }}" class="text-sm font-semibold whitespace-nowrap {{ request()->routeIs('pest_detection_alert') ? 'text-green-700 dark:text-green-400 border-b-2 border-green-700 dark:border-green-400 pb-1' : 'text-slate-600 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300' }}">Deteksi Hama</a>
            <a href="{{ route('market_price') }}" class="text-sm font-semibold whitespace-nowrap {{ request()->routeIs('market_price') ? 'text-green-700 dark:text-green-400 border-b-2 border-green-700 dark:border-green-400 pb-1' : 'text-slate-600 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300' }}">Radar Harga</a>
            <a href="{{ route('riskmap') }}" class="text-sm font-semibold whitespace-nowrap {{ request()->routeIs('riskmap') ? 'text-green-700 dark:text-green-400 border-b-2 border-green-700 dark:border-green-400 pb-1' : 'text-slate-600 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300' }}">Peta Risiko</a>
            <a href="{{ route('tanibot') }}" class="text-sm font-semibold whitespace-nowrap {{ request()->routeIs('tanibot') ? 'text-green-700 dark:text-green-400 border-b-2 border-green-700 dark:border-green-400 pb-1' : 'text-slate-600 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300' }}">Komunitas</a>
            <a href="{{ route('ai_reccomendation') }}" class="text-sm font-semibold whitespace-nowrap {{ request()->routeIs('ai_reccomendation') ? 'text-green-700 dark:text-green-400 border-b-2 border-green-700 dark:border-green-400 pb-1' : 'text-slate-600 dark:text-slate-400 hover:text-green-600 dark:hover:text-green-300' }}">Rekomendasi</a>
        </div>
    </div>
</nav>
