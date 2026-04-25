@extends('layouts.app')

@section('content')
<main class="flex-grow w-full max-w-[1600px] mx-auto px-4 xl:px-6 py-6 md:py-8 flex flex-col gap-6">
    <!-- Header -->
    <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h2 class="font-h2 text-h2 text-on-surface mb-2">Kalender Tanam Cerdas</h2>
            <p class="font-body text-body text-on-surface-variant">Rekomendasi berdasarkan data BMKG + pola historis wilayah.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative">
                <select id="lahanSelect"
                    class="appearance-none bg-surface-container-lowest border border-outline-variant text-on-surface py-2 pl-4 pr-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary font-small-label text-small-label cursor-pointer shadow-[0_2px_8px_rgba(27,94,32,0.04)]">
                    @foreach($lahans as $l)
                        <option value="{{ $l->id }}" {{ $selectedLahan->id == $l->id ? 'selected' : '' }}>
                            {{ $l->nama }} — {{ ucfirst($l->komoditas) }}
                        </option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-primary">
                    <span class="material-symbols-outlined text-sm">expand_more</span>
                </div>
            </div>
            <button id="btnRefresh" title="Generate ulang"
                class="p-2 rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container-low transition-colors">
                <span class="material-symbols-outlined text-sm">refresh</span>
            </button>
        </div>
    </header>

    <!-- Loading State -->
    <div id="loadingState" class="hidden">
        <div class="bg-surface-container-low border border-outline-variant rounded-[12px] p-12 flex flex-col items-center justify-center gap-4">
            <div class="relative w-16 h-16">
                <div class="absolute inset-0 border-4 border-primary/20 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
                <span class="material-symbols-outlined text-primary absolute inset-0 flex items-center justify-center text-2xl">eco</span>
            </div>
            <h3 class="font-h3 text-h3 text-on-surface">Menganalisis Data...</h3>
            <p class="font-body text-body text-on-surface-variant text-center max-w-md">
                AI sedang menganalisis data cuaca historis, prakiraan BMKG, dan profil lahan Anda untuk menghasilkan kalender tanam optimal.
            </p>
            <div class="flex gap-2 mt-2">
                <span class="w-2 h-2 bg-primary rounded-full animate-bounce" style="animation-delay:0s"></span>
                <span class="w-2 h-2 bg-primary rounded-full animate-bounce" style="animation-delay:0.2s"></span>
                <span class="w-2 h-2 bg-primary rounded-full animate-bounce" style="animation-delay:0.4s"></span>
            </div>
        </div>
    </div>

    <!-- Error State -->
    <div id="errorState" class="hidden">
        <div class="bg-error-container/30 border border-error/20 rounded-[12px] p-8 flex flex-col items-center justify-center gap-4">
            <span class="material-symbols-outlined text-error text-4xl">error</span>
            <h3 class="font-h3 text-h3 text-on-surface">Gagal Menganalisis</h3>
            <p id="errorMessage" class="font-body text-body text-on-surface-variant text-center max-w-md"></p>
            <button onclick="generateCalendar(true)"
                class="bg-primary text-on-primary px-6 py-2 rounded-full font-small-label text-small-label hover:bg-surface-tint transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">refresh</span> Coba Lagi
            </button>
        </div>
    </div>

    <!-- Content (hidden until data loaded) -->
    <div id="calendarContent" class="flex flex-col gap-6 {{ $kalenderData ? '' : 'hidden' }}">

        <!-- AI Recommendation Card -->
        <section class="bg-surface-container-low border border-primary-fixed-dim rounded-[12px] p-6 shadow-[0_4px_12px_rgba(27,94,32,0.06)] relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 text-primary-fixed opacity-20 pointer-events-none">
                <span class="material-symbols-outlined icon-fill" style="font-size: 120px;">eco</span>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 relative z-10">
                <div class="flex-1">
                    <div class="inline-flex items-center gap-1.5 bg-primary-container text-on-primary-container px-3 py-1 rounded-full mb-4">
                        <span class="material-symbols-outlined text-sm">auto_awesome</span>
                        <span class="font-small-label text-small-label uppercase tracking-wider text-[11px]">Rekomendasi AI TaniSiaga</span>
                    </div>
                    <h3 id="rekomendasiTitle" class="font-h3 text-h3 text-on-surface mb-3">Waktu Tanam Optimal:<br class="hidden md:block" /> —</h3>
                    <p id="rekomendasiAlasan" class="font-body text-body text-on-surface-variant max-w-2xl"></p>
                    <div id="warningBox" class="hidden mt-4 bg-error-container/30 border border-error/20 rounded-lg p-3 flex items-start gap-2">
                        <span class="material-symbols-outlined text-error text-sm mt-0.5">warning</span>
                        <p id="warningText" class="text-[13px] text-on-surface-variant"></p>
                    </div>
                </div>
                <div class="flex-shrink-0 flex flex-col items-center justify-center bg-surface-container-lowest w-32 h-32 rounded-full border-4 border-primary-container shadow-[0_4px_12px_rgba(27,94,32,0.08)] relative">
                    <svg class="absolute inset-0 w-full h-full -rotate-90" viewBox="0 0 100 100">
                        <circle cx="50" cy="50" fill="none" r="46" stroke="#eef2e7" stroke-width="8"></circle>
                        <circle id="probCircle" cx="50" cy="50" fill="none" r="46" stroke="#0b6b1d"
                            stroke-dasharray="289" stroke-dashoffset="289" stroke-linecap="round" stroke-width="8"
                            style="transition: stroke-dashoffset 1.5s ease-out"></circle>
                    </svg>
                    <span id="probText" class="font-h2 text-h2 text-primary relative z-10">—</span>
                    <span class="font-small-label text-small-label text-on-surface-variant relative z-10 text-[10px] mt-1">Probabilitas</span>
                </div>
            </div>
        </section>

        <!-- Calendar Grid + Timeline -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Map Calendar (replaces probability chart) -->
            <section class="lg:col-span-2 bg-surface-container-lowest border border-outline-variant rounded-[12px] p-6 shadow-[0_2px_8px_rgba(27,94,32,0.04)]">
                <div class="flex justify-between items-center mb-6">
                    <button id="prevMonthBtn" class="p-2 rounded-full hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined">chevron_left</span></button>
                    <h3 id="calendarMonthTitle" class="font-body text-body font-semibold text-on-surface">Jadwal Tanam</h3>
                    <button id="nextMonthBtn" class="p-2 rounded-full hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined">chevron_right</span></button>
                </div>
                <div class="flex flex-wrap gap-4 mb-6 text-[11px] font-small-label text-on-surface-variant justify-center">
                    <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-full bg-primary-container"></div> Awal Fase</div>
                    <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-full bg-secondary-container"></div> Sedang Berjalan</div>
                    <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-full bg-error-container"></div> Ada Peringatan</div>
                    <div class="flex items-center gap-1.5"><div class="w-3 h-3 rounded-full bg-surface-container-lowest border border-primary"></div> Hari Ini</div>
                </div>
                
                <!-- Days of week -->
                <div class="grid grid-cols-7 gap-1 text-center mb-2">
                    <div class="text-[11px] font-bold text-error">Min</div>
                    <div class="text-[11px] font-bold text-on-surface-variant">Sen</div>
                    <div class="text-[11px] font-bold text-on-surface-variant">Sel</div>
                    <div class="text-[11px] font-bold text-on-surface-variant">Rab</div>
                    <div class="text-[11px] font-bold text-on-surface-variant">Kam</div>
                    <div class="text-[11px] font-bold text-on-surface-variant">Jum</div>
                    <div class="text-[11px] font-bold text-primary">Sab</div>
                </div>

                <!-- Calendar Grid Container -->
                <div id="calendarGrid" class="grid grid-cols-7 gap-1 sm:gap-2 text-center">
                    <!-- Calendar cells injected by JS -->
                </div>
            </section>

            <!-- Timeline/Phases (Detail on the right) -->
            <div class="flex flex-col gap-6">
                <section class="bg-surface-container-lowest border border-outline-variant rounded-[12px] p-6 shadow-[0_2px_8px_rgba(27,94,32,0.04)] flex-grow">
                    <h3 class="font-body text-body font-semibold text-on-surface mb-4">Keterangan Fase</h3>
                    <div id="timelineContainer" class="relative pl-6 border-l-2 border-surface-container-highest space-y-5">
                        <!-- Timeline items injected by JS -->
                    </div>
                </section>
            </div>
        </div>

        <!-- Tips & Narasi -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <section class="bg-surface-container-lowest border border-outline-variant rounded-[12px] p-6 shadow-[0_2px_8px_rgba(27,94,32,0.04)]">
                <h3 class="font-body text-body font-semibold text-on-surface mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-sm">lightbulb</span> Tips Tambahan
                </h3>
                <ul id="tipsList" class="space-y-3 text-[13px] text-on-surface-variant">
                    <!-- Tips injected by JS -->
                </ul>
            </section>
            <section class="bg-surface-container-lowest border border-outline-variant rounded-[12px] p-6 shadow-[0_2px_8px_rgba(27,94,32,0.04)]">
                <h3 class="font-body text-body font-semibold text-on-surface mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-sm">description</span> Analisis AI
                </h3>
                <p id="narasiText" class="text-[13px] text-on-surface-variant leading-relaxed"></p>
            </section>
        </div>

        <!-- Meta Info -->
        <div id="metaInfo" class="text-[11px] text-on-surface-variant/60 text-center">
            <!-- Generated info -->
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-slate-50 dark:bg-slate-950 border-t border-green-100 dark:border-slate-800 w-full mt-auto">
    <div class="flex flex-col md:flex-row justify-between items-center py-10 px-6 gap-6 max-w-7xl mx-auto">
        <div class="text-lg font-bold text-green-800 dark:text-green-400">TaniSiaga</div>
        <div class="font-plus-jakarta text-xs md:text-sm font-normal text-slate-500 dark:text-slate-500 opacity-90">© 2024 TaniSiaga. Guardian of the Harvest.</div>
        <div class="flex gap-4">
            <a class="font-plus-jakarta text-xs md:text-sm font-normal text-slate-500 hover:text-green-600 hover:underline" href="#">Privacy Policy</a>
            <a class="font-plus-jakarta text-xs md:text-sm font-normal text-slate-500 hover:text-green-600 hover:underline" href="#">Terms of Service</a>
        </div>
    </div>
</footer>

<script>
const CSRF_TOKEN = '{{ csrf_token() }}';
const GENERATE_URL = '{{ route("calender_planning.generate") }}';
let currentLahanId = {{ $selectedLahan->id }};
let cachedData = @json($kalenderData);

const faseIcons = {
    'persemaian': 'water_drop', 'tanam': 'potted_plant', 'vegetatif': 'grass',
    'generatif': 'spa', 'panen': 'agriculture', 'pemupukan': 'science',
    'pengolahan': 'construction', 'persiapan': 'handyman', 'penanaman': 'potted_plant',
    'pematangan': 'wb_sunny', 'pembungaan': 'local_florist',
};

function getFaseIcon(fase) {
    const lower = fase.toLowerCase();
    for (const [key, icon] of Object.entries(faseIcons)) {
        if (lower.includes(key)) return icon;
    }
    return 'eco';
}

function showState(state) {
    document.getElementById('loadingState').classList.toggle('hidden', state !== 'loading');
    document.getElementById('errorState').classList.toggle('hidden', state !== 'error');
    document.getElementById('calendarContent').classList.toggle('hidden', state !== 'content');
}

function renderCalendar(data) {
    // Recommendation header
    document.getElementById('rekomendasiTitle').innerHTML =
        `Waktu Tanam Optimal:<br class="hidden md:block"/> ${data.waktu_tanam_terbaik || '—'}`;
    document.getElementById('rekomendasiAlasan').textContent = data.alasan || '';

    // Probability circle
    const prob = data.probabilitas_berhasil || 0;
    document.getElementById('probText').textContent = prob + '%';
    const circumference = 289;
    const offset = circumference - (circumference * prob / 100);
    setTimeout(() => {
        document.getElementById('probCircle').setAttribute('stroke-dashoffset', offset);
    }, 100);

    // Warning
    if (data.warning_utama) {
        document.getElementById('warningBox').classList.remove('hidden');
        document.getElementById('warningText').textContent = data.warning_utama;
    } else {
        document.getElementById('warningBox').classList.add('hidden');
    }

    // Calendar Grid
    renderCalendarGrid(data);

    // Timeline
    renderTimeline(data.timeline || []);

    // Tips
    renderTips(data.tips_tambahan || []);

    // Narasi
    document.getElementById('narasiText').textContent = data.ringkasan_narasi || data.alasan || '';

    // Meta
    const meta = data._meta || {};
    document.getElementById('metaInfo').innerHTML =
        `Terakhir di-generate: ${meta.generated_at || 'baru saja'} · Sumber data: ${meta.has_historical ? '✅ Historis' : '⚠️ Tanpa historis'} · ${meta.has_bmkg ? '✅ BMKG' : '⚠️ Tanpa BMKG'}`;

    showState('content');
}

function formatDateStr(dateStr) {
    if (!dateStr) return '';
    try {
        const d = new Date(dateStr);
        return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
    } catch(e) {
        return dateStr;
    }
}

let currentViewMonth = new Date();
window.hasSetInitialMonth = false;

function renderCalendarGrid(data) {
    if (!data.timeline || !data.timeline.length) {
        document.getElementById('calendarGrid').innerHTML = '<div class="col-span-full text-on-surface-variant text-sm py-4">Data timeline tidak tersedia.</div>';
        return;
    }
    
    // Set view month to start date if not set, or leave as current
    if (!window.hasSetInitialMonth && data.tanggal_mulai_estimasi) {
        currentViewMonth = new Date(data.tanggal_mulai_estimasi);
        window.hasSetInitialMonth = true;
    }

    renderMonthGrid(currentViewMonth, data.timeline);
}

function renderMonthGrid(date, timeline) {
    const container = document.getElementById('calendarGrid');
    container.innerHTML = '';
    
    const year = date.getFullYear();
    const month = date.getMonth();
    
    document.getElementById('calendarMonthTitle').textContent = date.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
    
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    
    const today = new Date();
    today.setHours(0,0,0,0);
    
    // Empty cells
    for (let i = 0; i < firstDay; i++) {
        container.innerHTML += `<div class="aspect-square p-1"></div>`;
    }
    
    for (let day = 1; day <= daysInMonth; day++) {
        const currentDate = new Date(year, month, day);
        const dateString = `${year}-${String(month+1).padStart(2,'0')}-${String(day).padStart(2,'0')}`;
        
        let isToday = currentDate.getTime() === today.getTime();
        
        let dayEvents = [];
        let hasWarning = false;
        
        timeline.forEach(phase => {
            if (!phase.tanggal_mulai) return;
            const start = new Date(phase.tanggal_mulai);
            const end = phase.tanggal_selesai ? new Date(phase.tanggal_selesai) : start;
            start.setHours(0,0,0,0);
            end.setHours(0,0,0,0);
            
            if (currentDate >= start && currentDate <= end) {
                dayEvents.push(phase);
                if (phase.warning) hasWarning = true;
            }
        });
        
        let cellClasses = `relative aspect-square sm:aspect-auto sm:min-h-[80px] flex flex-col p-1 sm:p-2 border rounded-lg transition-all ${isToday ? 'border-primary ring-1 ring-primary/20 shadow-sm' : 'border-outline-variant'} bg-surface-container-lowest`;
        
        if (dayEvents.length > 0) {
            let isStart = false;
            let phaseName = '';
            let iconHtml = '';
            dayEvents.forEach(e => {
                if (e.tanggal_mulai === dateString) {
                    isStart = true;
                    phaseName = e.fase;
                    iconHtml = getFaseIcon(e.fase);
                } else if (!phaseName) {
                    phaseName = e.fase; // fallback for continuous days
                }
            });
            
            if (hasWarning) {
                cellClasses = cellClasses.replace('bg-surface-container-lowest', 'bg-error-container/20 border-error/30');
            } else if (isStart) {
                cellClasses = cellClasses.replace('bg-surface-container-lowest', 'bg-primary-container/40 border-primary/30');
            } else {
                cellClasses = cellClasses.replace('bg-surface-container-lowest', 'bg-secondary-container/20');
            }
            
            let tooltipContent = dayEvents.map(e => `<div class="mb-1"><b class="text-primary">${e.fase}</b><br/>${e.aktivitas || ''}</div>`).join('');
            
            container.innerHTML += `
                <div class="${cellClasses} cursor-help group hover:shadow-md hover:-translate-y-0.5 overflow-hidden">
                    <div class="flex justify-between items-start">
                        <span class="text-[10px] sm:text-xs font-semibold ${isToday ? 'text-primary' : 'text-on-surface'}">${day}</span>
                        ${hasWarning ? `<span class="material-symbols-outlined text-[14px] text-error animate-pulse" title="Ada peringatan">warning</span>` : ''}
                    </div>
                    
                    <div class="mt-auto flex flex-col items-center justify-center w-full pt-1">
                        ${iconHtml ? `<span class="material-symbols-outlined text-[16px] sm:text-[18px] text-primary opacity-90 mb-0.5">${iconHtml}</span>` : ''}
                        ${phaseName ? `<span class="text-[9px] sm:text-[10px] leading-tight font-medium text-primary text-center line-clamp-1 sm:line-clamp-2 w-full px-0.5 bg-primary/10 rounded">${phaseName}</span>` : `<div class="w-1.5 h-1.5 rounded-full bg-primary/30 mt-1"></div>`}
                    </div>
                    
                    <div class="absolute bottom-[105%] left-1/2 -translate-x-1/2 w-48 sm:w-64 bg-surface-container-highest border border-outline-variant text-on-surface text-[11px] p-2 sm:p-3 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity z-[60] pointer-events-none shadow-xl text-left">
                        <div class="font-bold border-b border-outline-variant pb-1 mb-1.5 text-xs">${currentDate.toLocaleDateString('id-ID', {day:'numeric', month:'long', year:'numeric'})}</div>
                        ${tooltipContent}
                        ${hasWarning ? `<div class="mt-1.5 pt-1.5 border-t border-error/20 text-error flex items-start gap-1"><span class="material-symbols-outlined text-[14px]">error</span><span class="leading-tight">${dayEvents.find(e => e.warning)?.warning}</span></div>` : ''}
                    </div>
                </div>
            `;
        } else {
            container.innerHTML += `
                <div class="${cellClasses} opacity-60 hover:opacity-100">
                    <span class="text-[10px] sm:text-xs ${isToday ? 'text-primary font-bold' : 'text-on-surface-variant'}">${day}</span>
                </div>
            `;
        }
    }
}

function renderTimeline(timeline) {
    const container = document.getElementById('timelineContainer');
    container.innerHTML = '';

    timeline.forEach((item, idx) => {
        const isActive = idx < 2;
        const isLegacy = !item.tanggal_mulai;
        const dateRange = isLegacy ? `(Minggu ${item.minggu})` : `(${formatDateStr(item.tanggal_mulai)} - ${formatDateStr(item.tanggal_selesai)})`;
        
        const div = document.createElement('div');
        div.className = `relative ${isActive ? '' : 'opacity-60'}`;
        div.innerHTML = `
            <div class="absolute -left-[31px] top-0 w-4 h-4 rounded-full ${isActive ? 'bg-primary' : 'bg-outline-variant'} border-4 border-surface-container-lowest"></div>
            <h4 class="font-small-label text-small-label text-on-surface font-semibold mb-1 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm ${isActive ? 'text-primary' : ''}">${getFaseIcon(item.fase)}</span>
                ${item.fase} <span class="text-[11px] font-normal text-on-surface-variant">${dateRange}</span>
            </h4>
            <p class="text-[12px] text-on-surface-variant mb-1">${item.aktivitas || ''}</p>
            ${item.kondisi_cuaca ? `<p class="text-[11px] text-on-surface-variant/70 flex items-center gap-1"><span class="material-symbols-outlined text-[12px]">cloud</span>${item.kondisi_cuaca}</p>` : ''}
            ${item.warning ? `<p class="text-[11px] text-error flex items-center gap-1 mt-1"><span class="material-symbols-outlined text-[12px]">warning</span>${item.warning}</p>` : ''}
        `;
        container.appendChild(div);
    });
}

function renderTips(tips) {
    const container = document.getElementById('tipsList');
    container.innerHTML = '';
    if (!tips.length) {
        container.innerHTML = '<li class="text-on-surface-variant/60">Tidak ada tips tambahan.</li>';
        return;
    }
    tips.forEach(tip => {
        const li = document.createElement('li');
        li.className = 'flex items-start gap-2';
        li.innerHTML = `<span class="material-symbols-outlined text-primary text-sm mt-0.5">check_circle</span><span>${tip}</span>`;
        container.appendChild(li);
    });
}

async function generateCalendar(force = false) {
    showState('loading');
    try {
        const res = await fetch(GENERATE_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
            body: JSON.stringify({ lahan_id: currentLahanId, force: force })
        });
        const data = await res.json();
        if (!res.ok || data.error) {
            const actualErrorMsg = data.actual_error || data.error || 'Gagal menghasilkan kalender.';
            console.error("Gagal melakukan generate kalender tanam. Detail Error Backend:\n", actualErrorMsg);
            throw new Error(data.error || 'Gagal menghasilkan kalender.');
        }
        cachedData = data;
        renderCalendar(data);
    } catch (err) {
        document.getElementById('errorMessage').textContent = err.message;
        showState('error');
    }
}

// Init
document.getElementById('lahanSelect').addEventListener('change', function() {
    currentLahanId = this.value;
    window.location.href = `{{ route('calender_planning') }}?lahan_id=${this.value}`;
});

document.getElementById('btnRefresh').addEventListener('click', () => generateCalendar(true));

// On page load
if (cachedData && Object.keys(cachedData).length > 0) {
    renderCalendar(cachedData);
} else {
    generateCalendar(false);
}

document.getElementById('prevMonthBtn').addEventListener('click', () => {
    currentViewMonth.setMonth(currentViewMonth.getMonth() - 1);
    if (cachedData) renderMonthGrid(currentViewMonth, cachedData.timeline || []);
});

document.getElementById('nextMonthBtn').addEventListener('click', () => {
    currentViewMonth.setMonth(currentViewMonth.getMonth() + 1);
    if (cachedData) renderMonthGrid(currentViewMonth, cachedData.timeline || []);
});
</script>
@endsection
