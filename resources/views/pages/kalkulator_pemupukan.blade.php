@extends('layouts.app')

@section('content')
<main class="flex-grow w-full max-w-[1200px] mx-auto px-4 xl:px-6 py-6 md:py-8 flex flex-col gap-8">

    <div class="flex items-center justify-between">
        <h1 class="text-2xl md:text-3xl font-bold text-on-surface">Kalkulator Pemupukan</h1>
        <button class="bg-primary text-on-primary px-4 py-2 rounded-xl text-sm font-medium hover:bg-opacity-90 shadow-sm transition">
            Pengaturan
        </button>
    </div>

    <!-- 1. Bagian Pilih Lahan -->
    <section>
        <h2 class="text-lg font-semibold text-on-surface mb-4">1. Pilih Lahan</h2>
        @if($lahans->isEmpty())
            <div class="bg-surface rounded-2xl p-6 text-center shadow-sm border border-outline-variant/30 text-on-surface-variant">
                Anda belum memiliki lahan aktif. Silakan tambahkan lahan terlebih dahulu.
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4" id="lahan-list">
                @foreach($lahans as $index => $lahan)
                <div class="lahan-card bg-surface border {{ $index === 0 ? 'border-primary border-2 active-lahan' : 'border-outline-variant/50' }} rounded-2xl p-4 shadow-sm cursor-pointer relative overflow-hidden transition-all" data-id="{{ $lahan->id }}">
                    <div class="active-badge absolute top-0 right-0 bg-primary text-on-primary text-[10px] font-bold px-3 py-1 rounded-bl-lg {{ $index === 0 ? '' : 'hidden' }}">DIPILIH</div>
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined {{ $index === 0 ? 'text-primary' : 'text-outline' }} mt-0.5 icon-location">location_on</span>
                        <div>
                            <h3 class="font-bold text-on-surface text-base">{{ $lahan->nama }}</h3>
                            <p class="text-sm text-on-surface-variant mt-1">{{ ucfirst($lahan->komoditas) }} &middot; {{ number_format($lahan->luas, 2, ',', '.') }} Ha</p>
                            <p class="text-xs font-semibold {{ $index === 0 ? 'text-primary bg-primary-container' : 'text-on-surface-variant bg-surface-container' }} mt-2 px-2 py-1 rounded-md inline-block badge-hari">Hari ke-{{ $lahan->durasi_tanam_hari }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6 flex justify-end">
                <button id="btn-generate" class="bg-primary text-on-primary px-6 py-3 rounded-xl font-bold shadow-md hover:bg-opacity-90 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined" id="generate-icon">psychiatry</span>
                    <span id="generate-text">Generate Kalkulator Pemupukan</span>
                </button>
            </div>
        @endif
    </section>

    <!-- Error Message -->
    <div id="error-message" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline" id="error-text"></span>
    </div>

    <!-- Output Container -->
    <div id="output-container" class="hidden flex-col gap-8">
        <!-- 2. Jadwal Pemupukan (Timeline) -->
        <section class="bg-surface rounded-2xl p-6 shadow-sm border border-outline-variant/30">
            <h2 class="text-lg font-semibold text-on-surface mb-6">2. Jadwal Pemupukan (Fase Tanaman)</h2>
            
            <div class="relative w-full max-w-3xl mx-auto py-4">
                <!-- Line Base -->
                <div class="absolute top-1/2 left-0 w-full h-1.5 bg-surface-variant -translate-y-1/2 rounded-full"></div>
                <!-- Active Line -->
                <div id="timeline-active-line" class="absolute top-1/2 left-0 w-0 h-1.5 bg-primary -translate-y-1/2 rounded-full transition-all duration-1000"></div>

                <div class="relative flex justify-between" id="timeline-points">
                    <!-- Points will be injected here via JS -->
                </div>
            </div>
        </section>

        <!-- 3. Yang Perlu Dilakukan Sekarang -->
        <section>
            <div class="bg-gradient-to-br from-primary to-[#7a5940] rounded-3xl p-6 md:p-8 shadow-lg text-on-primary relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-48 h-48 bg-white opacity-5 rounded-full pointer-events-none"></div>
                <div class="absolute right-20 -bottom-10 w-32 h-32 bg-white opacity-5 rounded-full pointer-events-none"></div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="text-sm md:text-base font-bold tracking-widest uppercase opacity-90">Sekarang Perlu Dilakukan</h2>
                        <span id="card-hari" class="bg-white/20 px-3 py-1 rounded-full text-xs font-bold backdrop-blur-sm"></span>
                    </div>
                    <h3 id="card-fase" class="text-3xl md:text-4xl font-extrabold mb-8"></h3>

                    <div id="card-pupuk-list" class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <!-- Boxes injected via JS -->
                    </div>

                    <div class="flex items-start gap-3 bg-black/10 p-4 rounded-xl backdrop-blur-sm border border-white/10">
                        <span class="material-symbols-outlined text-yellow-300">info</span>
                        <p id="card-info" class="text-sm md:text-base leading-relaxed opacity-95">
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. Rekap Satu Musim Tanam -->
        <section class="bg-surface rounded-2xl p-6 shadow-sm border border-outline-variant/30">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-2">
                <h2 class="text-lg font-semibold text-on-surface">4. Rekap Satu Musim Tanam</h2>
            </div>

            <div class="space-y-0" id="rekap-list">
                <!-- Rows injected via JS -->
            </div>
        </section>
    </div>

</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lahanCards = document.querySelectorAll('.lahan-card');
        const btnGenerate = document.getElementById('btn-generate');
        let selectedLahanId = null;

        // Inisialisasi pilihan lahan (yang pertama)
        if(lahanCards.length > 0) {
            selectedLahanId = lahanCards[0].getAttribute('data-id');
        }

        // Handle Card Click
        lahanCards.forEach(card => {
            card.addEventListener('click', function() {
                // Reset semua card
                lahanCards.forEach(c => {
                    c.classList.remove('border-primary', 'border-2', 'active-lahan');
                    c.classList.add('border-outline-variant/50');
                    c.querySelector('.active-badge').classList.add('hidden');
                    c.querySelector('.icon-location').classList.replace('text-primary', 'text-outline');
                    const badge = c.querySelector('.badge-hari');
                    badge.classList.remove('text-primary', 'bg-primary-container');
                    badge.classList.add('text-on-surface-variant', 'bg-surface-container');
                });

                // Set aktif
                this.classList.remove('border-outline-variant/50');
                this.classList.add('border-primary', 'border-2', 'active-lahan');
                this.querySelector('.active-badge').classList.remove('hidden');
                this.querySelector('.icon-location').classList.replace('text-outline', 'text-primary');
                const badge = this.querySelector('.badge-hari');
                badge.classList.remove('text-on-surface-variant', 'bg-surface-container');
                badge.classList.add('text-primary', 'bg-primary-container');

                selectedLahanId = this.getAttribute('data-id');
                checkExistingData();
            });
        });

        // Cek awal
        if(selectedLahanId) {
            checkExistingData();
        }

        function checkExistingData() {
            if(!selectedLahanId) return;

            document.getElementById('output-container').classList.add('hidden');
            document.getElementById('error-message').classList.add('hidden');
            document.getElementById('generate-text').innerText = 'Generate Kalkulator Pemupukan';

            fetch(`{{ url('/api/kalkulator-pemupukan/data') }}?lahan_id=${selectedLahanId}`)
            .then(res => res.json())
            .then(data => {
                if(data.success && data.data) {
                    renderOutput(data.data);
                    document.getElementById('output-container').classList.remove('hidden');
                    document.getElementById('output-container').classList.add('flex');
                    document.getElementById('generate-text').innerText = 'Perbarui Kalkulator (AI)';
                }
            })
            .catch(err => console.log('Belum ada data', err));
        }

        if(btnGenerate) {
            btnGenerate.addEventListener('click', function() {
                if(!selectedLahanId) return;

                // Loading State
                const originalText = document.getElementById('generate-text').innerText;
                document.getElementById('generate-text').innerText = 'Memproses dengan AI...';
                const icon = document.getElementById('generate-icon');
                icon.innerText = 'sync';
                icon.classList.add('animate-spin');
                btnGenerate.disabled = true;
                btnGenerate.classList.add('opacity-70', 'cursor-not-allowed');

                document.getElementById('output-container').classList.add('hidden');
                document.getElementById('error-message').classList.add('hidden');

                fetch('{{ route("kalkulator_pemupukan.generate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ lahan_id: selectedLahanId })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success && data.data) {
                        renderOutput(data.data);
                        document.getElementById('output-container').classList.remove('hidden');
                        document.getElementById('output-container').classList.add('flex');
                        document.getElementById('generate-text').innerText = 'Perbarui Kalkulator (AI)';
                    } else {
                        throw new Error(data.message || 'Gagal mengambil data');
                    }
                })
                .catch(error => {
                    document.getElementById('error-text').innerText = error.message;
                    document.getElementById('error-message').classList.remove('hidden');
                    document.getElementById('generate-text').innerText = 'Generate Kalkulator Pemupukan';
                })
                .finally(() => {
                    // Reset Button Icon and State
                    icon.innerText = 'psychiatry';
                    icon.classList.remove('animate-spin');
                    btnGenerate.disabled = false;
                    btnGenerate.classList.remove('opacity-70', 'cursor-not-allowed');
                });
            });
        }

        function renderOutput(data) {
            // Render Timeline (Section 2)
            const timelinePoints = document.getElementById('timeline-points');
            const activeLine = document.getElementById('timeline-active-line');
            timelinePoints.innerHTML = '';
            
            if(data.jadwal && data.jadwal.length > 0) {
                let activeIndex = 0;
                data.jadwal.forEach((item, index) => {
                    if (item.status === 'sekarang' || item.is_active) activeIndex = index;
                    
                    let pointHtml = '';
                    if (item.status === 'selesai') {
                        pointHtml = `
                            <div class="flex flex-col items-center relative -top-3">
                                <div class="w-6 h-6 rounded-full bg-primary flex items-center justify-center border-4 border-surface shadow-sm">
                                    <span class="material-symbols-outlined text-[12px] text-on-primary">check</span>
                                </div>
                                <span class="text-xs font-bold text-on-surface mt-2">${item.fase}</span>
                                <span class="text-[10px] text-on-surface-variant">${item.hari}</span>
                            </div>
                        `;
                    } else if (item.status === 'sekarang') {
                        pointHtml = `
                            <div class="flex flex-col items-center relative -top-3">
                                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center border-4 border-surface-container-low shadow-md ring-2 ring-primary">
                                    <div class="w-2.5 h-2.5 bg-on-primary rounded-full"></div>
                                </div>
                                <span class="text-sm font-bold text-primary mt-2">${item.fase}</span>
                                <span class="text-xs font-semibold text-primary bg-primary-container px-2 py-0.5 rounded-full mt-1">${item.hari}</span>
                            </div>
                        `;
                    } else { // akan datang
                        pointHtml = `
                            <div class="flex flex-col items-center relative -top-3">
                                <div class="w-6 h-6 rounded-full bg-surface-variant flex items-center justify-center border-4 border-surface">
                                </div>
                                <span class="text-xs font-medium text-on-surface-variant mt-2">${item.fase}</span>
                                <span class="text-[10px] text-on-surface-variant">${item.hari}</span>
                            </div>
                        `;
                    }
                    timelinePoints.innerHTML += pointHtml;
                });
                // set width of active line
                const percent = (activeIndex / (data.jadwal.length - 1)) * 100;
                activeLine.style.width = percent + '%';
            }

            // Render Sekarang Perlu Dilakukan (Section 3)
            if(data.sekarang_perlu_dilakukan) {
                const s = data.sekarang_perlu_dilakukan;
                document.getElementById('card-hari').innerText = s.hari_ke || '';
                document.getElementById('card-fase').innerText = s.fase || '';
                document.getElementById('card-info').innerText = s.info || '';
                
                const pupukListContainer = document.getElementById('card-pupuk-list');
                pupukListContainer.innerHTML = '';
                if(s.pupuk_list && Array.isArray(s.pupuk_list)) {
                    s.pupuk_list.forEach(p => {
                        pupukListContainer.innerHTML += `
                            <div class="bg-white/10 border border-white/20 rounded-2xl p-4 backdrop-blur-md">
                                <div class="text-sm font-medium opacity-80 mb-1">${p.nama}</div>
                                <div class="text-2xl font-bold mb-1">${p.jumlah_kg} <span class="text-sm font-normal">kg</span></div>
                                <div class="text-[10px] opacity-70">${p.setara || ''}</div>
                            </div>
                        `;
                    });
                }
            }

            // Render Rekap (Section 4)
            const rekapList = document.getElementById('rekap-list');
            rekapList.innerHTML = '';
            
            if(data.rekap && Array.isArray(data.rekap)) {
                data.rekap.forEach(r => {
                    let rowClass, icon, iconClass, labelClass, labelBg;
                    if(r.status.toUpperCase() === 'SELESAI') {
                        rowClass = "border-b border-outline-variant/20 opacity-60";
                        icon = "check_circle"; iconClass = "text-green-600";
                        labelClass = "text-green-600"; labelBg = "bg-green-50";
                        faseClass = "text-on-surface";
                    } else if (r.status.toUpperCase() === 'SEKARANG') {
                        rowClass = "border-b border-outline-variant/20 bg-primary-container/20 rounded-xl my-1 border border-primary/20";
                        icon = "radio_button_checked"; iconClass = "text-primary fill-current";
                        labelClass = "text-primary"; labelBg = "bg-primary-container";
                        faseClass = "text-primary";
                    } else { // AKAN DATANG
                        rowClass = "border-b border-outline-variant/20";
                        icon = "radio_button_unchecked"; iconClass = "text-outline";
                        labelClass = "text-outline"; labelBg = "bg-surface-variant";
                        faseClass = "text-on-surface";
                    }

                    rekapList.innerHTML += `
                        <div class="flex flex-col md:flex-row md:items-center gap-4 p-4 ${rowClass}">
                            <div class="flex items-center gap-3 w-full md:w-1/3">
                                <span class="material-symbols-outlined ${iconClass}">${icon}</span>
                                <div>
                                    <div class="font-bold ${faseClass}">${r.fase}</div>
                                    <div class="text-xs ${faseClass === 'text-primary' ? 'text-primary font-medium' : 'text-on-surface-variant'}">${r.hari}</div>
                                </div>
                            </div>
                            <div class="text-sm ${faseClass === 'text-primary' ? 'text-on-surface font-semibold' : 'text-on-surface flex-1'} flex-1">
                                ${r.pupuk_detail}
                            </div>
                            <div class="text-xs font-bold ${labelClass} ${labelBg} px-2 py-1 rounded w-fit">${r.status.toUpperCase()}</div>
                        </div>
                    `;
                });
            }
        }
    });
</script>
@endsection
