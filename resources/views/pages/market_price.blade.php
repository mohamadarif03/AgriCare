@extends('layouts.app')

@section('content')
<main class="flex-grow w-full max-w-[1600px] mx-auto px-4 xl:px-6 py-6 md:py-8 flex flex-col gap-6">

    {{-- ═══ Page Header + Selectors ═══ --}}
    <section class="flex flex-col gap-3">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h2 class="font-h2 text-h2 text-on-surface">Radar Harga Pasar</h2>
                <p class="font-body text-body text-on-surface-variant mt-1">Data harga komoditas realtime — Panel Harga Pangan Kementan</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                {{-- Commodity Selector --}}
                <div class="relative">
                    <select id="commodity-select" class="appearance-none bg-primary-container/10 text-primary font-small-label text-small-label px-4 py-2 pr-8 rounded-full border border-primary-container/20 cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary/30">
                        @foreach($commodities as $key => $label)
                        <option value="{{ $key }}" {{ $key === $defaultCommodity ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Region Selector --}}
                <div class="relative">
                    <select id="region-select" class="appearance-none bg-tertiary-container/10 text-tertiary font-small-label text-small-label px-4 py-2 pr-8 rounded-full border border-tertiary-container/20 cursor-pointer focus:outline-none focus:ring-2 focus:ring-tertiary/30">
                        @foreach($regions as $key => $label)
                        <option value="{{ $key }}" {{ $key === $defaultRegion ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ Loading Overlay ═══ --}}
    <div id="loading-overlay" class="hidden fixed inset-0 bg-black/20 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="bg-surface-container-lowest rounded-2xl p-8 shadow-xl flex flex-col items-center gap-4">
            <div class="w-10 h-10 border-4 border-primary/30 border-t-primary rounded-full animate-spin"></div>
            <p class="font-body text-on-surface">Memuat data harga...</p>
        </div>
    </div>

    {{-- ═══ Section 1: Price Cards ═══ --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
        <div class="col-span-1 md:col-span-2 bg-surface-container-lowest rounded-[12px] p-6 border border-surface-variant shadow-[0_4px_20px_rgba(27,94,32,0.04)] relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <span class="material-symbols-outlined text-8xl text-primary" style="font-variation-settings:'FILL' 1;">eco</span>
            </div>
            <div class="relative z-10 flex flex-col gap-4 h-full justify-between">
                <div>
                    <div class="flex items-center gap-2 text-on-surface-variant mb-2">
                        <span class="material-symbols-outlined text-sm">payments</span>
                        <span class="font-small-label text-small-label">Harga <span id="card-commodity-label">Padi</span> Hari Ini</span>
                    </div>
                    <h3 class="font-h1 text-h1 text-primary mb-1">
                        <span id="card-current-price">—</span>
                        <span class="text-h3 font-h3 text-outline">/ kg</span>
                    </h3>
                    <div class="flex items-center gap-1 text-on-surface-variant">
                        <span class="material-symbols-outlined text-sm">location_on</span>
                        <span id="card-region-label" class="font-small-label text-small-label">—</span>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <div id="card-trend-badge" class="inline-flex items-center gap-1 bg-primary/10 text-primary px-3 py-1 rounded-full">
                        <span class="material-symbols-outlined text-sm" id="card-trend-icon">trending_up</span>
                        <span class="font-small-label text-small-label font-bold" id="card-trend-text">—</span>
                    </div>
                    <div id="card-ai-badge" class="inline-flex items-center gap-1 bg-tertiary-container/10 text-tertiary px-3 py-1 rounded-full border border-tertiary-container/20">
                        <span class="material-symbols-outlined text-sm">smart_toy</span>
                        <span class="font-small-label text-small-label" id="card-ai-text">Memuat...</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-1 flex flex-col gap-gutter">
            <div class="bg-surface-container-lowest rounded-[12px] p-5 border border-surface-variant shadow-[0_4px_20px_rgba(27,94,32,0.04)] flex-1 flex flex-col justify-center">
                <span class="font-small-label text-small-label text-on-surface-variant mb-1">Harga Tertinggi Bulan Ini</span>
                <div class="flex items-baseline gap-2">
                    <span class="font-h3 text-h3 text-on-surface" id="card-monthly-high">—</span>
                    <span class="text-sm text-outline">/kg</span>
                </div>
                <span class="font-small-label text-small-label text-outline mt-1" id="card-monthly-high-date">—</span>
            </div>
            <div class="bg-surface-container-lowest rounded-[12px] p-5 border border-surface-variant shadow-[0_4px_20px_rgba(27,94,32,0.04)] flex-1 flex flex-col justify-center">
                <span class="font-small-label text-small-label text-on-surface-variant mb-1">Prediksi Minggu Depan</span>
                <div class="flex items-baseline gap-2 mb-2">
                    <span class="font-h3 text-h3 text-on-surface" id="card-prediction-range">—</span>
                </div>
                <div id="card-prediction-badge" class="inline-flex items-center gap-1 bg-secondary-container/20 text-secondary-fixed-dim px-3 py-1 rounded-full w-fit">
                    <span class="material-symbols-outlined text-sm" id="card-prediction-icon">moving</span>
                    <span class="font-small-label text-small-label font-bold" id="card-prediction-trend">—</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ Section 2: Chart ═══ --}}
    <section class="bg-surface-container-lowest rounded-[12px] p-6 border border-surface-variant shadow-[0_4px_20px_rgba(27,94,32,0.04)]">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-h3 text-h3 text-on-surface">Grafik Harga 3 Bulan</h3>
            <div class="flex items-center gap-4 text-sm text-on-surface-variant">
                <span class="flex items-center gap-1"><span class="w-4 h-0.5 bg-primary inline-block rounded"></span> Historis</span>
                <span class="flex items-center gap-1"><span class="w-4 h-0.5 bg-tertiary inline-block rounded border-dashed border-t-2 border-tertiary"></span> Prediksi</span>
                <span class="flex items-center gap-1"><span class="w-4 h-0.5 bg-outline/40 inline-block rounded"></span> Rata-rata</span>
            </div>
        </div>
        <div class="relative" style="height:320px;">
            <canvas id="price-chart"></canvas>
        </div>
    </section>

    {{-- ═══ Section 3: AI Narration ═══ --}}
    <section id="ai-narration-section" class="bg-primary/5 border border-primary/15 rounded-[12px] p-6 relative overflow-hidden">
        <div class="absolute top-3 right-3 opacity-20">
            <span class="material-symbols-outlined text-4xl text-primary">psychology</span>
        </div>
        <div class="flex items-center gap-2 mb-3">
            <span class="material-symbols-outlined text-primary">smart_toy</span>
            <h3 class="font-h3 text-h3 text-primary">Analisis AI</h3>
            <span class="bg-primary/10 text-primary text-xs px-2 py-0.5 rounded-full font-bold">Gemini</span>
        </div>
        <div id="ai-narration-content" class="font-body text-body text-on-surface leading-relaxed whitespace-pre-line">
            <div class="flex items-center gap-2 text-on-surface-variant"><div class="w-4 h-4 border-2 border-primary/40 border-t-primary rounded-full animate-spin"></div> Menganalisis data harga...</div>
        </div>
    </section>

    {{-- ═══ Section 4: Recommendation ═══ --}}
    <section id="recommendation-section" class="rounded-[12px] p-6 border shadow-[0_4px_20px_rgba(27,94,32,0.04)] bg-surface-container-lowest border-surface-variant">
        <div class="flex items-center gap-2 mb-4">
            <span class="material-symbols-outlined" id="rec-icon">recommend</span>
            <h3 class="font-h3 text-h3" id="rec-title">Rekomendasi</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex flex-col gap-1">
                <span class="font-small-label text-small-label text-on-surface-variant">Aksi</span>
                <span class="font-h3 text-h3" id="rec-action">—</span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="font-small-label text-small-label text-on-surface-variant">Alasan</span>
                <p class="font-body text-body text-on-surface" id="rec-reason">—</p>
            </div>
            <div class="flex flex-col gap-1">
                <span class="font-small-label text-small-label text-on-surface-variant">Potensi Profit</span>
                <span class="font-h3 text-h3 text-primary" id="rec-profit">—</span>
            </div>
        </div>
    </section>

    {{-- ═══ Section 5: Region Comparison ═══ --}}
    <section class="bg-surface-container-lowest rounded-[12px] p-6 border border-surface-variant shadow-[0_4px_20px_rgba(27,94,32,0.04)]">
        <h3 class="font-h3 text-h3 text-on-surface mb-4">Perbandingan Wilayah</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-surface-variant">
                        <th class="py-3 px-4 font-small-label text-small-label text-on-surface-variant">Wilayah</th>
                        <th class="py-3 px-4 font-small-label text-small-label text-on-surface-variant text-right">Harga/kg</th>
                        <th class="py-3 px-4 font-small-label text-small-label text-on-surface-variant text-right">Tren</th>
                    </tr>
                </thead>
                <tbody id="regions-table-body">
                    <tr><td colspan="3" class="py-6 text-center text-on-surface-variant">Memuat...</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    {{-- ═══ Section 6: Other Commodities ═══ --}}
    <section class="bg-surface-container-lowest rounded-[12px] p-6 border border-surface-variant shadow-[0_4px_20px_rgba(27,94,32,0.04)]">
        <h3 class="font-h3 text-h3 text-on-surface mb-4">Komoditas Lain</h3>
        <div id="other-commodities-grid" class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div class="col-span-full text-center text-on-surface-variant py-4">Memuat...</div>
        </div>
    </section>

</main>

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const commoditySelect = document.getElementById('commodity-select');
    const regionSelect = document.getElementById('region-select');
    const loadingOverlay = document.getElementById('loading-overlay');
    let priceChart = null;

    // ─── Format helpers ──────────────────────────────────────────
    const fmtRp = (n) => 'Rp ' + Number(n).toLocaleString('id-ID');
    const fmtTrend = (t) => (t >= 0 ? '+' : '') + t + '%';

    const actionLabels = {
        jual_sekarang: 'Jual Sekarang',
        tahan: 'Tahan',
        jual_sebagian: 'Jual Sebagian',
    };
    const actionColors = {
        jual_sekarang: { bg: 'rgba(186,26,26,0.08)', border: 'rgba(186,26,26,0.2)', text: '#ba1a1a' },
        tahan:         { bg: 'rgba(11,107,29,0.08)',  border: 'rgba(11,107,29,0.2)', text: '#402E24' },
        jual_sebagian: { bg: 'rgba(120,89,0,0.08)',   border: 'rgba(120,89,0,0.2)',  text: '#785900' },
    };

    // ─── Fetch data ──────────────────────────────────────────────
    async function fetchData() {
        const commodity = commoditySelect.value;
        const region = regionSelect.value;
        loadingOverlay.classList.remove('hidden');

        try {
            const res = await fetch(`/api/market-price?commodity=${commodity}&region=${region}`);
            const json = await res.json();
            if (json.success && json.data) {
                renderAll(json.data);
            } else {
                showError(json.message || 'Gagal memuat data');
            }
        } catch (e) {
            showError('Koneksi gagal: ' + e.message);
        } finally {
            loadingOverlay.classList.add('hidden');
        }
    }

    function showError(msg) {
        document.getElementById('ai-narration-content').innerHTML =
            `<p class="text-error">${msg}</p>`;
    }

    // ─── Render all sections ─────────────────────────────────────
    function renderAll(d) {
        renderCards(d);
        renderChart(d);
        renderNarration(d);
        renderRecommendation(d);
        renderRegions(d);
        renderOtherCommodities(d);
    }

    // ── Section 1: Cards ─────────────────────────────────────────
    function renderCards(d) {
        document.getElementById('card-commodity-label').textContent = d.commodity_label;
        document.getElementById('card-current-price').textContent = fmtRp(d.current_price);
        document.getElementById('card-region-label').textContent = d.region_label;

        const trendEl = document.getElementById('card-trend-text');
        const trendIcon = document.getElementById('card-trend-icon');
        const trendBadge = document.getElementById('card-trend-badge');
        trendEl.textContent = fmtTrend(d.trend_percentage) + ' vs kemarin';
        if (d.trend_percentage >= 0) {
            trendIcon.textContent = 'trending_up';
            trendBadge.className = 'inline-flex items-center gap-1 bg-primary/10 text-primary px-3 py-1 rounded-full';
        } else {
            trendIcon.textContent = 'trending_down';
            trendBadge.className = 'inline-flex items-center gap-1 bg-error/10 text-error px-3 py-1 rounded-full';
        }

        // AI badge
        const aiBadge = document.getElementById('card-ai-badge');
        const aiText = document.getElementById('card-ai-text');
        if (d.recommendation) {
            aiBadge.classList.remove('hidden');
            const action = d.recommendation.action;
            const colors = actionColors[action] || actionColors.tahan;
            aiBadge.style.background = colors.bg;
            aiBadge.style.borderColor = colors.border;
            aiBadge.style.color = colors.text;
            aiText.textContent = (actionLabels[action] || action) + ' — ' + (d.recommendation.reason || '').substring(0, 40);
        } else {
            aiBadge.classList.add('hidden');
        }

        // Monthly high
        document.getElementById('card-monthly-high').textContent = fmtRp(d.monthly_high);
        document.getElementById('card-monthly-high-date').textContent = d.monthly_high_date || '—';

        // Prediction
        if (d.prediction) {
            document.getElementById('card-prediction-range').textContent = fmtRp(d.prediction.min) + ' - ' + fmtRp(d.prediction.max);
            const dir = d.prediction.trend_direction || 'stabil';
            document.getElementById('card-prediction-trend').textContent = dir.charAt(0).toUpperCase() + dir.slice(1);
            const pIcon = document.getElementById('card-prediction-icon');
            pIcon.textContent = dir === 'naik' ? 'moving' : (dir === 'turun' ? 'trending_down' : 'trending_flat');
        }
    }

    // ── Section 2: Chart ─────────────────────────────────────────
    function renderChart(d) {
        const ctx = document.getElementById('price-chart').getContext('2d');
        if (priceChart) priceChart.destroy();

        const labels = d.chart_data.map(p => p.date);
        const prices = d.chart_data.map(p => p.price);
        const avg = d.average_price;

        // prediction extension
        let predLabels = [], predPrices = [];
        if (d.prediction) {
            const lastDate = labels.length ? new Date(labels[labels.length - 1]) : new Date();
            for (let i = 1; i <= 28; i++) {
                const dt = new Date(lastDate); dt.setDate(dt.getDate() + i);
                predLabels.push(dt.toISOString().slice(0, 10));
                const t = i / 28;
                predPrices.push(Math.round(d.prediction.min + (d.prediction.max - d.prediction.min) * t));
            }
        }

        const allLabels = [...labels, ...predLabels];
        const historicalData = [...prices, ...Array(predLabels.length).fill(null)];
        const predictionData = [...Array(labels.length - 1).fill(null), prices[prices.length - 1], ...predPrices];
        const avgData = allLabels.map(() => avg);

        priceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: allLabels,
                datasets: [
                    {
                        label: 'Harga Historis',
                        data: historicalData,
                        borderColor: '#402E24',
                        backgroundColor: 'rgba(11,107,29,0.08)',
                        fill: true, tension: 0.3, pointRadius: 0, borderWidth: 2,
                    },
                    {
                        label: 'Prediksi',
                        data: predictionData,
                        borderColor: '#005ea4',
                        backgroundColor: 'rgba(0,94,164,0.06)',
                        borderDash: [6, 4], fill: true, tension: 0.3, pointRadius: 0, borderWidth: 2,
                    },
                    {
                        label: 'Rata-rata',
                        data: avgData,
                        borderColor: 'rgba(112,122,108,0.4)',
                        borderDash: [3, 3], borderWidth: 1, pointRadius: 0, fill: false,
                    },
                ],
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => ctx.dataset.label + ': ' + fmtRp(ctx.parsed.y),
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { maxTicksLimit: 10, font: { size: 11 } },
                        grid: { display: false },
                    },
                    y: {
                        ticks: { callback: v => fmtRp(v), font: { size: 11 } },
                        grid: { color: 'rgba(0,0,0,0.05)' },
                    }
                }
            }
        });
    }

    // ── Section 3: AI Narration ──────────────────────────────────
    function renderNarration(d) {
        const el = document.getElementById('ai-narration-content');
        const section = document.getElementById('ai-narration-section');
        if (d.trend_analysis) {
            el.textContent = d.trend_analysis;
            section.className = 'bg-primary/5 border border-primary/15 rounded-[12px] p-6 relative overflow-hidden';
        } else {
            el.innerHTML = '<div class="flex items-center gap-2 text-on-surface-variant"><span class="material-symbols-outlined text-sm">info</span> Analisis AI belum tersedia, menampilkan data harga saja.</div>';
            section.className = 'bg-surface-container/50 border border-surface-variant rounded-[12px] p-6 relative overflow-hidden';
        }
    }

    // ── Section 4: Recommendation ────────────────────────────────
    function renderRecommendation(d) {
        const section = document.getElementById('recommendation-section');
        const rec = d.recommendation;
        if (!rec) {
            section.classList.add('hidden');
            return;
        } else {
            section.classList.remove('hidden');
        }

        const action = rec.action || 'tahan';
        const colors = actionColors[action] || actionColors.tahan;

        section.style.background = colors.bg;
        section.style.borderColor = colors.border;

        document.getElementById('rec-icon').style.color = colors.text;
        document.getElementById('rec-title').style.color = colors.text;

        document.getElementById('rec-action').textContent = actionLabels[action] || action;
        document.getElementById('rec-action').style.color = colors.text;
        document.getElementById('rec-reason').textContent = rec.reason || '—';
        document.getElementById('rec-profit').textContent = rec.potential_profit ? fmtRp(rec.potential_profit) + '/kg' : '—';
    }

    // ── Section 5: Region Comparison ─────────────────────────────
    function renderRegions(d) {
        const tbody = document.getElementById('regions-table-body');
        if (!d.regions_comparison || !d.regions_comparison.length) {
            tbody.innerHTML = '<tr><td colspan="3" class="py-4 text-center text-on-surface-variant">Tidak ada data</td></tr>';
            return;
        }
        tbody.innerHTML = d.regions_comparison.map(r => {
            const trendColor = r.trend >= 0 ? 'text-primary' : 'text-error';
            const trendIcon = r.trend >= 0 ? 'trending_up' : 'trending_down';
            const isActive = r.region === d.region;
            const rowClass = isActive ? 'bg-primary/5' : 'hover:bg-surface-container-low';
            return `<tr class="${rowClass} border-b border-surface-variant/50 transition-colors">
                <td class="py-3 px-4 font-body text-body text-on-surface">${r.region_label}${isActive ? ' <span class="text-xs bg-primary/10 text-primary px-2 py-0.5 rounded-full ml-1">aktif</span>' : ''}</td>
                <td class="py-3 px-4 font-body text-body text-on-surface text-right font-semibold">${fmtRp(r.price)}</td>
                <td class="py-3 px-4 text-right"><span class="inline-flex items-center gap-1 ${trendColor}"><span class="material-symbols-outlined text-sm">${trendIcon}</span>${fmtTrend(r.trend)}</span></td>
            </tr>`;
        }).join('');
    }

    // ── Section 6: Other Commodities ─────────────────────────────
    function renderOtherCommodities(d) {
        const grid = document.getElementById('other-commodities-grid');
        if (!d.other_commodities || !d.other_commodities.length) {
            grid.innerHTML = '<div class="col-span-full text-center text-on-surface-variant py-4">Tidak ada data</div>';
            return;
        }
        grid.innerHTML = d.other_commodities.map(c => {
            const trendColor = c.trend >= 0 ? 'text-primary' : 'text-error';
            const trendIcon = c.trend >= 0 ? 'trending_up' : 'trending_down';
            return `<button onclick="switchCommodity('${c.commodity}')"
                class="bg-surface-container-low hover:bg-surface-container border border-surface-variant rounded-xl p-4 text-left transition-all hover:shadow-md cursor-pointer group">
                <span class="font-small-label text-small-label text-on-surface-variant">${c.commodity_label}</span>
                <div class="font-h3 text-h3 text-on-surface mt-1">${fmtRp(c.price)}<span class="text-xs text-outline">/kg</span></div>
                <div class="flex items-center gap-1 mt-1 ${trendColor}">
                    <span class="material-symbols-outlined text-sm">${trendIcon}</span>
                    <span class="font-small-label text-small-label">${fmtTrend(c.trend)}</span>
                </div>
            </button>`;
        }).join('');
    }

    // ─── Switch commodity via click ──────────────────────────────
    window.switchCommodity = function(commodity) {
        commoditySelect.value = commodity;
        fetchData();
    };

    // ─── Event listeners ─────────────────────────────────────────
    commoditySelect.addEventListener('change', fetchData);
    regionSelect.addEventListener('change', fetchData);

    // ─── Initial load ────────────────────────────────────────────
    fetchData();
});
</script>
@endsection
