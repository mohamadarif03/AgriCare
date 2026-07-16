@extends('layouts.app')

@section('content')
<!-- Main Content Canvas -->
    <main class="flex-grow w-full max-w-[1600px] mx-auto px-4 xl:px-6 py-6 md:py-8 flex flex-col gap-6">
        <!-- Hero Upload Section -->
        <section class="flex flex-col gap-sm">
            <div class="text-center md:text-left mb-sm">
                <h1 class="font-h1 text-h1 text-primary">Deteksi Penyakit Tanaman Anda</h1>
                <p class="font-body text-body text-on-surface-variant max-w-2xl mt-xs">Unggah foto daun yang sakit atau
                    hama yang ditemukan. AI kami akan mengidentifikasi ancaman dan memberikan rekomendasi penanganan
                    secara instan.</p>
            </div>
            <div id="upload-box" class="bg-surface-container-lowest rounded-xl border-2 border-dashed border-primary p-lg flex flex-col items-center justify-center text-center gap-md hover:bg-surface-container-low transition-colors duration-300 cursor-pointer group shadow-[0_4px_16px_rgba(27,94,32,0.04)] relative">
                <input type="file" id="foto-input" accept="image/jpeg, image/png" class="hidden">
                
                <div class="mb-2 w-full max-w-sm" onclick="event.stopPropagation()">
                    <label class="block text-sm font-medium text-on-surface mb-1 text-left">Pilih Lahan yang Terdampak:</label>
                    <select id="lahan-select" class="w-full bg-surface-container pl-4 pr-10 py-3 rounded-xl border border-outline-variant focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest font-body text-body text-on-surface transition-all shadow-sm">
                        @if(count($lahans) > 0)
                            @foreach($lahans as $l)
                                <option value="{{ $l->id }}">{{ $l->nama }} - {{ ucfirst($l->komoditas) }}</option>
                            @endforeach
                        @else
                            <option value="">-- Belum ada lahan, tambahkan dulu --</option>
                        @endif
                    </select>
                </div>

                <div
                    class="w-20 h-20 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center group-hover:scale-105 transition-transform duration-300 shadow-[0_4px_12px_rgba(27,94,32,0.15)]">
                    <span class="material-symbols-outlined text-4xl" data-weight="fill"
                        style="font-variation-settings: 'FILL' 1;">add_a_photo</span>
                </div>
                <div>
                    <p class="font-h3 text-h3 text-primary mb-xs">Tarik &amp; Lepas Foto Di Sini</p>
                    <p class="font-body text-body text-on-surface-variant">atau</p>
                </div>
                <button id="btn-upload" class="bg-primary text-on-primary px-8 py-3 rounded-full font-small-label text-small-label hover:bg-surface-tint transition-colors duration-200 active:scale-95 shadow-[0_4px_12px_rgba(27,94,32,0.15)] flex items-center gap-2">
                    <span class="material-symbols-outlined">upload</span> Ambil Foto / Upload Gambar
                </button>
                <p class="font-small-label text-small-label text-outline mt-xs">Mendukung format JPG, PNG. Maksimal
                    10MB.</p>
            </div>
        </section>
        <!-- Demo Result Bento Card -->
        <section class="grid grid-cols-1 md:grid-cols-12 gap-gutter">
            <div class="col-span-1 md:col-span-12">
                <h2 class="font-h2 text-h2 text-on-surface mb-md">Hasil Analisis Terkini</h2>
            </div>
            <div
                class="col-span-1 md:col-span-4 bg-surface-container-lowest rounded-xl border border-surface-variant overflow-hidden shadow-[0_2px_8px_rgba(27,94,32,0.04)] flex flex-col">
                <div class="h-48 w-full bg-surface-container-high relative" id="result-image-container">
                    <img id="result-image" alt="Preview" class="w-full h-full object-cover"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBSrQl8JGr6azHtpphmgiN_H8r4LggQwEaqnBIlUM9otG0IHFw7yzUcfk4WG2wp5gv9NC52V_jUQJnOHlIC0x6FtrW8-y-z6OKLTua58N88zcdM5T0MoyEruwtGg025nQoUmxlm1H-Q87S0lEPOO29OuX_NR8vKuzsO2J_FlBTIGXuKpY6iN6Lf_ytSA1fgPPWBsQMFY17h0GVJoy-SFhK6CxgutYnu0LCnSwp2risaw--cyKmS6V5jNzye56GEXmgEWBf8Fwn77-o" />
                    <div id="result-badge" class="absolute top-4 right-4 bg-surface-container-lowest/90 backdrop-blur px-3 py-1 rounded-full flex items-center gap-2 shadow-sm">
                        <span class="material-symbols-outlined text-primary text-sm">verified</span>
                        <span class="font-small-label text-small-label text-primary">AI Terverifikasi</span>
                    </div>
                </div>
                <div class="p-md flex flex-col gap-sm flex-grow">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 id="result-title" class="font-h3 text-h3 text-on-surface">Menunggu Analisis...</h3>
                            <p id="result-subtitle" class="font-body text-body text-on-surface-variant italic">Belum ada data</p>
                        </div>
                        <div id="result-severity" class="bg-surface-variant text-on-surface-variant px-3 py-1 rounded-full flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">hourglass_empty</span>
                            <span class="font-small-label text-small-label">MENUNGGU</span>
                        </div>
                    </div>
                    <div class="w-full bg-surface-variant rounded-full h-2 mt-2">
                        <div class="bg-primary h-2 rounded-full" style="width: 94%"></div>
                    </div>
                    <p id="result-confidence" class="font-small-label text-small-label text-outline text-right">Tingkat Kepercayaan: 0%</p>
                </div>
            </div>
            <div
                class="col-span-1 md:col-span-8 bg-surface-container-lowest rounded-xl border border-surface-variant p-md shadow-[0_2px_8px_rgba(27,94,32,0.04)] flex flex-col justify-between">
                <div>
                    <h3 class="font-h3 text-h3 text-primary mb-sm flex items-center gap-2">
                        <span class="material-symbols-outlined">health_and_safety</span> Rekomendasi Penanganan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-md mt-md">
                        <div
                            class="bg-surface-bright rounded-lg p-sm border border-surface-variant relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-2 opacity-10">
                                <span class="material-symbols-outlined text-4xl text-primary">flash_on</span>
                            </div>
                            <h4 class="font-small-label text-small-label text-on-surface font-bold mb-xs">Tindakan
                                Segera (Immediate)</h4>
                            <ul id="result-actions" class="font-body text-body text-on-surface-variant list-disc pl-5 space-y-1">
                                <li>Pilih lahan dan unggah foto hama atau penyakit untuk mendapatkan rekomendasi penanganan.</li>
                            </ul>
                        </div>
                        <div
                            class="bg-surface-bright rounded-lg p-sm border border-surface-variant relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-2 opacity-10">
                                <span class="material-symbols-outlined text-4xl text-primary">shield</span>
                            </div>
                            <h4 class="font-small-label text-small-label text-on-surface font-bold mb-xs">Pencegahan
                                (Prevention)</h4>
                            <ul id="result-preventions" class="font-body text-body text-on-surface-variant list-disc pl-5 space-y-1">
                                <li>AI akan menganalisis foto dan memberikan rekomendasi pencegahan ke depan.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                {{-- <div class="mt-md pt-sm border-t border-surface-variant flex justify-end">
                    <button
                        class="bg-surface-container-low text-primary border border-primary px-6 py-2 rounded-full font-small-label text-small-label hover:bg-primary hover:text-on-primary transition-colors duration-200 flex items-center gap-2">
                        <span class="material-symbols-outlined">forum</span> Konsultasi dengan TaniBot
                    </button>
                </div> --}}
            </div>
        </section>

    </main>
<script>
    const uploadBox = document.getElementById('upload-box');
    const fileInput = document.getElementById('foto-input');
    const btnUpload = document.getElementById('btn-upload');
    const lahanSelect = document.getElementById('lahan-select');
    
    const lahansData = @json($lahans->map(function($l) {
        return [
            'id' => $l->id,
            'pest_detection' => $l->pest_detection
        ];
    })->keyBy('id'));

    uploadBox.addEventListener('click', (e) => {
        if(e.target !== lahanSelect && e.target.tagName !== 'OPTION') {
            fileInput.click();
        }
    });
    btnUpload.addEventListener('click', (e) => {
        e.stopPropagation();
        fileInput.click();
    });

    uploadBox.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadBox.classList.add('border-primary', 'bg-surface-container-low');
    });

    uploadBox.addEventListener('dragleave', () => {
        uploadBox.classList.remove('border-primary', 'bg-surface-container-low');
    });

    uploadBox.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadBox.classList.remove('border-primary', 'bg-surface-container-low');
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            handleUpload();
        }
    });

    fileInput.addEventListener('change', handleUpload);

    lahanSelect.addEventListener('change', () => {
        const lahanId = lahanSelect.value;
        if (lahanId && lahansData[lahanId] && lahansData[lahanId].pest_detection) {
            const data = lahansData[lahanId].pest_detection;
            updateResultUI(data);
            document.getElementById('result-image').src = data.foto_url ? data.foto_url : 'https://images.unsplash.com/photo-1592982537447-7440770cbfc9?auto=format&fit=crop&w=800&q=80';
        } else {
            resetResultUI();
        }
    });

    function resetResultUI() {
        document.getElementById('result-image').src = 'https://lh3.googleusercontent.com/aida-public/AB6AXuBSrQl8JGr6azHtpphmgiN_H8r4LggQwEaqnBIlUM9otG0IHFw7yzUcfk4WG2wp5gv9NC52V_jUQJnOHlIC0x6FtrW8-y-z6OKLTua58N88zcdM5T0MoyEruwtGg025nQoUmxlm1H-Q87S0lEPOO29OuX_NR8vKuzsO2J_FlBTIGXuKpY6iN6Lf_ytSA1fgPPWBsQMFY17h0GVJoy-SFhK6CxgutYnu0LCnSwp2risaw--cyKmS6V5jNzye56GEXmgEWBf8Fwn77-o';
        document.getElementById('result-title').innerText = 'Menunggu Analisis...';
        document.getElementById('result-subtitle').innerText = 'Belum ada data';
        document.getElementById('result-severity').className = 'bg-surface-variant text-on-surface-variant px-3 py-1 rounded-full flex items-center gap-1';
        document.getElementById('result-severity').innerHTML = '<span class="material-symbols-outlined text-sm">hourglass_empty</span><span class="font-small-label text-small-label">MENUNGGU</span>';
        document.getElementById('result-actions').innerHTML = '<li>Pilih lahan dan unggah foto hama atau penyakit untuk mendapatkan rekomendasi penanganan.</li>';
        document.getElementById('result-preventions').innerHTML = '<li>AI akan menganalisis foto dan memberikan rekomendasi pencegahan ke depan.</li>';
        document.getElementById('result-confidence').innerText = 'Tingkat Kepercayaan: 0%';
    }

    async function handleUpload() {
        if (!fileInput.files.length) return;
        const file = fileInput.files[0];
        const lahanId = lahanSelect.value;

        if (!lahanId) {
            alert('Pilih lahan terlebih dahulu sebelum mengunggah foto!');
            fileInput.value = '';
            return;
        }

        // Preview Image
        const reader = new FileReader();
        reader.onload = (e) => {
            document.getElementById('result-image').src = e.target.result;
        };
        reader.readAsDataURL(file);

        // Show loading state
        const originalBtnHtml = btnUpload.innerHTML;
        btnUpload.innerHTML = '<span class="material-symbols-outlined animate-spin" style="animation: spin 1s linear infinite;">sync</span> Menganalisis AI...';
        btnUpload.disabled = true;

        const formData = new FormData();
        formData.append('foto', file);
        formData.append('lahan_id', lahanId);

        try {
            const res = await fetch('{{ route('pest_detection.analyze') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            const data = await res.json();
            if(res.ok) {
                // Update cached data so it persists when switching tabs
                if(lahansData[lahanId]) {
                    lahansData[lahanId].pest_detection = data;
                }
                updateResultUI(data);
            } else {
                alert(data.message || data.error || 'Terjadi kesalahan saat memproses gambar.');
            }
        } catch (error) {
            alert('Gagal terhubung ke server.');
            console.error(error);
        } finally {
            btnUpload.innerHTML = originalBtnHtml;
            btnUpload.disabled = false;
        }
    }

    function updateResultUI(data) {
        if(!data.terdeteksi) {
            document.getElementById('result-title').innerText = 'Tidak Ditemukan Penyakit/Hama';
            document.getElementById('result-subtitle').innerText = data.penyebab || 'Tanaman tampak sehat';
            document.getElementById('result-severity').className = 'bg-primary-container text-on-primary-container px-3 py-1 rounded-full flex items-center gap-1 w-max';
            document.getElementById('result-severity').innerHTML = '<span class="material-symbols-outlined text-sm">check_circle</span><span class="font-small-label text-small-label uppercase">AMAN</span>';
            document.getElementById('result-actions').innerHTML = '<li>Lanjutkan perawatan rutin.</li>';
            document.getElementById('result-preventions').innerHTML = '<li>Jaga kondisi optimal pada lahan.</li>';
            document.getElementById('result-confidence').innerText = 'Tingkat Kepercayaan: ' + (data.confidence || 0) + '%';
            return;
        }

        document.getElementById('result-title').innerText = data.nama_penyakit;
        document.getElementById('result-subtitle').innerText = data.penyebab;
        document.getElementById('result-confidence').innerText = 'Tingkat Kepercayaan: ' + (data.confidence || 0) + '%';
        
        const severityObj = document.getElementById('result-severity');
        if (data.keparahan && data.keparahan.toLowerCase() === 'parah') {
            severityObj.className = 'bg-error-container text-on-error-container px-3 py-1 rounded-full flex items-center gap-1 w-max';
            severityObj.innerHTML = '<span class="material-symbols-outlined text-sm">error</span><span class="font-small-label text-small-label uppercase">PARAH</span>';
        } else if (data.keparahan && data.keparahan.toLowerCase() === 'sedang') {
            severityObj.className = 'bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full flex items-center gap-1 w-max';
            severityObj.innerHTML = '<span class="material-symbols-outlined text-sm">warning</span><span class="font-small-label text-small-label uppercase">SEDANG</span>';
        } else {
            severityObj.className = 'bg-tertiary-container text-on-tertiary-container px-3 py-1 rounded-full flex items-center gap-1 w-max';
            severityObj.innerHTML = '<span class="material-symbols-outlined text-sm">info</span><span class="font-small-label text-small-label uppercase">RINGAN</span>';
        }

        const actionsHtml = (data.penanganan || []).map(p => '<li>' + p + '</li>').join('');
        document.getElementById('result-actions').innerHTML = actionsHtml || '<li>Tidak ada tindakan khusus.</li>';

        const preventionsHtml = (data.pencegahan || []).map(p => '<li>' + p + '</li>').join('');
        document.getElementById('result-preventions').innerHTML = preventionsHtml || '<li>Lakukan pencegahan standar.</li>';
    }

    // Trigger initial load if lahan is selected
    if (lahanSelect.value) {
        lahanSelect.dispatchEvent(new Event('change'));
    }
</script>
<style>
@keyframes spin { 100% { transform: rotate(360deg); } }
.animate-spin { animation: spin 1s linear infinite; }
</style>

    <!-- Footer -->
    {{-- <footer class="w-full mt-auto border-t border-orange-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-950">
        <div class="flex flex-col md:flex-row justify-between items-center py-10 px-6 gap-6 max-w-7xl mx-auto">
            <div class="text-lg font-bold text-orange-800 dark:text-orange-400">
                AgriCare
            </div>
            <div class="font-plus-jakarta text-xs md:text-sm font-normal text-slate-500 dark:text-slate-500">
                © 2024 AgriCare. Guardian of the Harvest.
            </div>
            <div class="flex gap-4">
                <a class="font-plus-jakarta text-xs md:text-sm font-normal text-slate-500 dark:text-slate-500 hover:text-orange-600 dark:hover:text-orange-300 hover:underline opacity-90 hover:opacity-100 transition-opacity"
                    href="#">Privacy Policy</a>
                <a class="font-plus-jakarta text-xs md:text-sm font-normal text-slate-500 dark:text-slate-500 hover:text-orange-600 dark:hover:text-orange-300 hover:underline opacity-90 hover:opacity-100 transition-opacity"
                    href="#">Terms of Service</a>
                <a class="font-plus-jakarta text-xs md:text-sm font-normal text-slate-500 dark:text-slate-500 hover:text-orange-600 dark:hover:text-orange-300 hover:underline opacity-90 hover:opacity-100 transition-opacity"
                    href="#">Help Center</a>
                <a class="font-plus-jakarta text-xs md:text-sm font-normal text-slate-500 dark:text-slate-500 hover:text-orange-600 dark:hover:text-orange-300 hover:underline opacity-90 hover:opacity-100 transition-opacity"
                    href="#">Community Guidelines</a>
            </div>
        </div>
    </footer> --}}
@endsection
