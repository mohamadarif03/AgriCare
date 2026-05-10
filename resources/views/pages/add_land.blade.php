@extends('layouts.app')

@section('content')
<main class="flex-grow w-full max-w-[1600px] mx-auto px-4 xl:px-6 py-6 md:py-8 flex flex-col gap-6">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('manage_lands') }}" class="p-2 -ml-2 text-on-surface-variant hover:text-primary hover:bg-surface-container rounded-full transition-colors flex items-center justify-center">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="font-h2 text-h2 text-on-surface leading-tight">Tambah Lahan Baru</h1>
            <p class="font-body text-sm text-on-surface-variant mt-1">Daftarkan area tanam Anda untuk mendapatkan analisis iklim, deteksi hama, dan rekomendasi AI.</p>
        </div>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
    <div class="flex flex-col gap-1 px-5 py-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
        <p class="font-semibold text-sm">Mohon perbaiki kesalahan berikut:</p>
        <ul class="list-disc list-inside text-sm space-y-0.5 mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- Form Section --}}
        <div class="lg:col-span-8">
            <form action="{{ route('lahan.store') }}" method="POST" enctype="multipart/form-data"
                  class="bg-surface-container-lowest rounded-2xl p-6 md:p-8 shadow-[0_4px_20px_rgba(27,94,32,0.03)] border border-outline-variant/30 space-y-6">
                @csrf

                {{-- Nama Lahan --}}
                <div>
                    <label for="nama" class="block text-sm font-semibold text-on-surface mb-2">Nama Lahan <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px]">landscape</span>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                               placeholder="Misal: Sawah Blok A, Kebun Cabai Ciawi"
                               class="w-full pl-11 pr-4 py-3 rounded-xl bg-surface-container-low border border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none transition-all placeholder:text-outline-variant @error('nama') border-red-400 bg-red-50 @enderror" required>
                    </div>
                    @error('nama')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Komoditas --}}
                    <div>
                        <label for="komoditas" class="block text-sm font-semibold text-on-surface mb-2">Komoditas Utama <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px]">grass</span>
                            <select id="komoditas" name="komoditas"
                                    class="w-full pl-11 pr-10 py-3 rounded-xl bg-surface-container-low border border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none appearance-none cursor-pointer transition-all @error('komoditas') border-red-400 bg-red-50 @enderror" required>
                                <option value="" disabled {{ old('komoditas') ? '' : 'selected' }}>Pilih tanaman...</option>
                                @foreach(['padi' => 'Padi', 'cabai' => 'Cabai', 'bawang_merah' => 'Bawang Merah'] as $val => $label)
                                <option value="{{ $val }}" {{ old('komoditas') === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px] pointer-events-none">expand_more</span>
                        </div>
                        @error('komoditas')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Luas Lahan --}}
                    <div>
                        <label for="luas" class="block text-sm font-semibold text-on-surface mb-2">Luas Lahan</label>
                        <div class="flex gap-2">
                            <input type="number" id="luas" name="luas" step="0.01" min="0"
                                   value="{{ old('luas') }}" placeholder="0.0"
                                   class="w-full px-4 py-3 rounded-xl bg-surface-container-low border border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none transition-all placeholder:text-outline-variant">
                            <select name="area_unit" class="w-32 px-3 py-3 rounded-xl bg-surface-container-low border border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none cursor-pointer transition-all">
                                <option value="ha">Hektar (Ha)</option>
                                <option value="m2">Meter Persegi (m²)</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Tanggal Tanam --}}
                <div>
                    <label for="tanggal_tanam" class="block text-sm font-semibold text-on-surface mb-2">Perkiraan Tanggal Tanam</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px]">calendar_month</span>
                        <input type="date" id="tanggal_tanam" name="tanggal_tanam"
                               value="{{ old('tanggal_tanam') }}"
                               class="w-full pl-11 pr-4 py-3 rounded-xl bg-surface-container-low border border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none transition-all cursor-text">
                    </div>
                    <p class="text-xs text-on-surface-variant mt-2 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">info</span>
                        Digunakan untuk memprediksi fase pertumbuhan dan estimasi panen.
                    </p>
                </div>

                {{-- Lokasi Lahan (Cascading Dropdowns) --}}
                <div class="space-y-4">
                    <h3 class="text-sm font-semibold text-on-surface">Lokasi Lahan <span class="text-red-500">*</span></h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Provinsi --}}
                        <div>
                            <label for="prov_id" class="block text-xs font-medium text-on-surface-variant mb-1">1. Provinsi</label>
                            <div class="relative">
                                <select id="prov_id" class="w-full pl-4 pr-10 py-3 rounded-xl bg-surface-container-low border border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none appearance-none cursor-pointer transition-all">
                                    <option value="" selected disabled>Pilih Provinsi...</option>
                                </select>
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px] pointer-events-none">expand_more</span>
                            </div>
                        </div>

                        {{-- Kota/Kabupaten --}}
                        <div>
                            <label for="kota_id" class="block text-xs font-medium text-on-surface-variant mb-1">2. Kota/Kabupaten</label>
                            <div class="relative">
                                <select id="kota_id" class="w-full pl-4 pr-10 py-3 rounded-xl bg-surface-container-low border border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none appearance-none cursor-pointer transition-all" disabled>
                                    <option value="" selected disabled>Pilih Kota/Kab...</option>
                                </select>
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px] pointer-events-none">expand_more</span>
                            </div>
                        </div>

                        {{-- Kecamatan --}}
                        <div>
                            <label for="kec_id" class="block text-xs font-medium text-on-surface-variant mb-1">3. Kecamatan</label>
                            <div class="relative">
                                <select id="kec_id" class="w-full pl-4 pr-10 py-3 rounded-xl bg-surface-container-low border border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none appearance-none cursor-pointer transition-all" disabled>
                                    <option value="" selected disabled>Pilih Kecamatan...</option>
                                </select>
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px] pointer-events-none">expand_more</span>
                            </div>
                        </div>

                        {{-- Kelurahan (emsifa, untuk referensi nama) --}}
                        <div>
                            <label for="kel_id" class="block text-xs font-medium text-on-surface-variant mb-1">4. Kelurahan/Desa <span class="text-outline">(referensi)</span></label>
                            <div class="relative">
                                <select id="kel_id" class="w-full pl-4 pr-10 py-3 rounded-xl bg-surface-container-low border border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none appearance-none cursor-pointer transition-all" disabled>
                                    <option value="" selected disabled>Pilih Kelurahan...</option>
                                </select>
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px] pointer-events-none">expand_more</span>
                            </div>
                        </div>
                    </div>

                    {{-- Desa BMKG (dropdown ke-5 — kode cuaca BMKG) --}}
                    <div id="bmkg-desa-wrap" class="hidden">
                        <label for="bmkg_desa_id" class="block text-xs font-medium text-on-surface-variant mb-1">
                            5. Desa/Kelurahan BMKG <span class="text-red-500">*</span>
                            <span class="text-outline font-normal">(untuk data cuaca akurat)</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-primary text-[20px]">cloud</span>
                            <select id="bmkg_desa_id" class="w-full pl-10 pr-10 py-3 rounded-xl bg-primary-container/10 border border-primary/20 focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none appearance-none cursor-pointer transition-all" disabled>
                                <option value="" selected disabled>Memuat daftar desa dari BMKG...</option>
                            </select>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px] pointer-events-none">expand_more</span>
                        </div>
                        <p id="bmkg-loading-msg" class="text-xs text-primary mt-1 flex items-center gap-1 hidden">
                            <span class="material-symbols-outlined text-[14px] animate-spin">refresh</span>
                            Mencari daftar desa BMKG untuk kecamatan ini...
                        </p>
                    </div>

                    {{-- Hidden fields --}}
                    <input type="hidden" name="kode_wilayah" id="kode_wilayah" value="{{ old('kode_wilayah') }}">
                    <input type="hidden" name="provinsi"    id="provinsi"    value="{{ old('provinsi') }}">
                    <input type="hidden" name="kota"        id="kota"        value="{{ old('kota') }}">
                    <input type="hidden" name="kecamatan"   id="kecamatan"   value="{{ old('kecamatan') }}">
                    <input type="hidden" name="kelurahan"   id="kelurahan"   value="{{ old('kelurahan') }}">
                    <input type="hidden" name="latitude"    id="latitude"    value="{{ old('latitude') }}">
                    <input type="hidden" name="longitude"   id="longitude"   value="{{ old('longitude') }}">

                    <div id="wilayah-result" class="hidden mt-2 px-4 py-3 rounded-xl text-sm"></div>
                    @error('kode_wilayah')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Alamat / Lokasi (opsional, readonly setelah validasi) --}}
                <div>
                    <label for="alamat" class="block text-sm font-semibold text-on-surface mb-2">Alamat Lengkap <span class="text-on-surface-variant font-normal">(terisi otomatis)</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-3.5 material-symbols-outlined text-outline text-[20px]">location_on</span>
                        <textarea id="alamat" name="alamat" rows="2" placeholder="Akan terisi setelah kode wilayah divalidasi..."
                                  class="w-full pl-11 pr-4 py-3 rounded-xl bg-surface-container-low border border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none transition-all placeholder:text-outline-variant resize-none" readonly>{{ old('alamat') }}</textarea>
                    </div>
                </div>

                {{-- Foto Lahan --}}
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-2">Foto Lahan <span class="text-on-surface-variant font-normal">(opsional)</span></label>
                    <div class="relative border-2 border-dashed border-outline-variant/50 rounded-xl p-6 flex flex-col items-center gap-3 hover:border-primary/50 transition-colors cursor-pointer bg-surface-container-low"
                         onclick="document.getElementById('foto').click()">
                        <span class="material-symbols-outlined text-4xl text-on-surface-variant">add_a_photo</span>
                        <div class="text-center">
                            <p class="text-sm font-semibold text-on-surface">Klik untuk upload foto</p>
                            <p class="text-xs text-on-surface-variant mt-0.5">JPG, PNG, WebP — Maks. 1MB</p>
                        </div>
                        <input type="file" id="foto" name="foto" accept="image/*" class="hidden" onchange="previewFoto(this)">
                        <img id="foto-preview" class="hidden w-full max-h-48 object-cover rounded-lg mt-2" alt="Preview">
                    </div>
                    @error('foto')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Submit Buttons --}}
                <div class="pt-4 flex flex-col sm:flex-row items-center gap-3 justify-end border-t border-outline-variant/30">
                    <a href="{{ route('manage_lands') }}" class="w-full sm:w-auto px-6 py-2.5 rounded-xl text-sm font-semibold text-on-surface-variant bg-surface hover:bg-surface-container transition-colors text-center">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl text-sm font-semibold text-on-primary bg-primary hover:bg-primary-container shadow-md hover:shadow-lg transition-all active:scale-95 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan Lahan
                    </button>
                </div>
            </form>
        </div>

        {{-- Sidebar Info --}}
        <div class="lg:col-span-4 space-y-6">
            {{-- TaniBot Tip --}}
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
                </div>
            </div>

            {{-- Manfaat Tracker --}}
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
                        <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 mt-0.5">
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

<script>
function previewFoto(input) {
    const preview = document.getElementById('foto-preview');
    if (input.files && input.files[0]) {
        if (input.files[0].size > 1 * 1024 * 1024) {
            alert('Ukuran foto maksimal 1 MB!');
            input.value = '';
            preview.classList.add('hidden');
            return;
        }
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.classList.remove('hidden'); };
        reader.readAsDataURL(input.files[0]);
    }
}

let wilayahValidated = false;

const provSelect    = document.getElementById('prov_id');
const kotaSelect    = document.getElementById('kota_id');
const kecSelect     = document.getElementById('kec_id');
const kelSelect     = document.getElementById('kel_id');
const bmkgDesaSelect = document.getElementById('bmkg_desa_id');
const bmkgDesaWrap  = document.getElementById('bmkg-desa-wrap');
const bmkgLoadingMsg = document.getElementById('bmkg-loading-msg');

const hiddenKode = document.getElementById('kode_wilayah');
const hiddenProv = document.getElementById('provinsi');
const hiddenKota = document.getElementById('kota');
const hiddenKec  = document.getElementById('kecamatan');
const hiddenKel  = document.getElementById('kelurahan');
const hiddenAlamat = document.getElementById('alamat');
const resultDiv  = document.getElementById('wilayah-result');

function fillSelect(select, data, placeholder, valueKey = 'id', labelKey = 'name') {
    select.innerHTML = `<option value="" selected disabled>${placeholder}</option>`;
    data.forEach(item => {
        const opt = document.createElement('option');
        opt.value = item[valueKey];
        opt.textContent = item[labelKey];
        select.appendChild(opt);
    });
    select.disabled = false;
}

function resetBmkgDesa() {
    bmkgDesaSelect.innerHTML = '<option value="" selected disabled>Pilih kecamatan dulu...</option>';
    bmkgDesaSelect.disabled = true;
    bmkgDesaWrap.classList.add('hidden');
    hiddenKode.value = '';
    wilayahValidated = false;
    resultDiv.classList.add('hidden');
}

async function loadProvinces() {
    try {
        const res  = await fetch('/api/wilayah/provinces');
        const data = await res.json();
        fillSelect(provSelect, data, 'Pilih Provinsi...');
    } catch (e) { console.error('Gagal memuat provinsi', e); }
}

// ── Province changed ───────────────────────────────────────────────────────
provSelect.addEventListener('change', async () => {
    hiddenProv.value = provSelect.options[provSelect.selectedIndex].text;
    kotaSelect.innerHTML = '<option value="" selected disabled>Memuat...</option>';
    kecSelect.innerHTML  = '<option value="" selected disabled>Pilih Kecamatan...</option>';
    kelSelect.innerHTML  = '<option value="" selected disabled>Pilih Kelurahan...</option>';
    kotaSelect.disabled = kecSelect.disabled = kelSelect.disabled = true;
    resetBmkgDesa();
    try {
        const data = await (await fetch(`/api/wilayah/regencies/${provSelect.value}`)).json();
        fillSelect(kotaSelect, data, 'Pilih Kota/Kabupaten...');
    } catch (e) { console.error('Gagal memuat kota', e); }
});

// ── Kota changed ────────────────────────────────────────────────────────────
kotaSelect.addEventListener('change', async () => {
    hiddenKota.value = kotaSelect.options[kotaSelect.selectedIndex].text;
    kecSelect.innerHTML = '<option value="" selected disabled>Memuat...</option>';
    kelSelect.innerHTML = '<option value="" selected disabled>Pilih Kelurahan...</option>';
    kecSelect.disabled = kelSelect.disabled = true;
    resetBmkgDesa();
    try {
        const data = await (await fetch(`/api/wilayah/districts/${kotaSelect.value}`)).json();
        fillSelect(kecSelect, data, 'Pilih Kecamatan...');
    } catch (e) { console.error('Gagal memuat kecamatan', e); }
});

// ── Kecamatan changed — fetch emsifa kelurahan + BMKG desa concurrently ────
kecSelect.addEventListener('change', async () => {
    const kecId = kecSelect.value;   // e.g. "3507030"
    hiddenKec.value = kecSelect.options[kecSelect.selectedIndex].text;

    // adm3 for BMKG: "3507030" → "35.07.03"
    const adm3 = `${kecId.substring(0,2)}.${kecId.substring(2,4)}.${kecId.substring(4,6)}`;

    kelSelect.innerHTML = '<option value="" selected disabled>Memuat...</option>';
    kelSelect.disabled  = true;
    resetBmkgDesa();

    // Show BMKG desa wrap with loading state
    bmkgDesaWrap.classList.remove('hidden');
    bmkgDesaSelect.innerHTML = '<option value="" selected disabled>Memuat dari BMKG...</option>';
    bmkgDesaSelect.disabled  = true;
    bmkgLoadingMsg.classList.remove('hidden');

    // Fire both fetches in parallel
    const [kelRes, bmkgRes] = await Promise.allSettled([
        fetch(`/api/wilayah/villages/${kecId}`).then(r => r.json()),
        fetch(`/api/wilayah/bmkg-desa?adm3=${adm3}`).then(r => r.json()),
    ]);

    // Fill emsifa kelurahan
    if (kelRes.status === 'fulfilled') {
        fillSelect(kelSelect, kelRes.value, 'Pilih Kelurahan (referensi)...');
    } else {
        kelSelect.innerHTML = '<option value="" selected disabled>Gagal memuat</option>';
    }

    // Fill BMKG desa
    bmkgLoadingMsg.classList.add('hidden');
    if (bmkgRes.status === 'fulfilled' && Array.isArray(bmkgRes.value) && bmkgRes.value.length > 0) {
        fillSelect(bmkgDesaSelect, bmkgRes.value, 'Pilih Desa BMKG...', 'kode', 'label');
    } else {
        bmkgDesaSelect.innerHTML = '<option value="" selected disabled>Tidak ada data BMKG untuk kecamatan ini</option>';
        showResult(resultDiv, false, 'Data cuaca BMKG tidak tersedia untuk kecamatan ini. Pilih kecamatan lain.');
    }
});

// ── Kelurahan changed (emsifa — reference only) ─────────────────────────────
kelSelect.addEventListener('change', () => {
    hiddenKel.value = kelSelect.options[kelSelect.selectedIndex].text;
    // Update alamat preview jika BMKG desa sudah dipilih
    if (hiddenKode.value) {
        hiddenAlamat.value = `${hiddenKel.value}, ${hiddenKec.value}, ${hiddenKota.value}, ${hiddenProv.value}`;
    }
});

// ── BMKG Desa changed — THIS sets the actual kode_wilayah ──────────────────
bmkgDesaSelect.addEventListener('change', () => {
    const kode  = bmkgDesaSelect.value;
    const label = bmkgDesaSelect.options[bmkgDesaSelect.selectedIndex].text;

    hiddenKode.value   = kode;
    // Use emsifa kelurahan name if selected, otherwise use BMKG label
    const kelName = hiddenKel.value || label;
    hiddenAlamat.value = `${kelName}, ${hiddenKec.value}, ${hiddenKota.value}, ${hiddenProv.value}`;

    wilayahValidated = true;
    showResult(resultDiv, true,
        `<strong>✓ Lokasi & Data Cuaca Siap!</strong><br>` +
        `<span class="text-on-surface">${hiddenAlamat.value}</span><br>` +
        `<span class="text-xs text-on-surface-variant">Kode BMKG: <strong>${kode}</strong> — cuaca akan diambil secara real-time dari BMKG.</span>`
    );
});

function showResult(el, success, msg) {
    el.classList.remove('hidden','bg-blue-50','border-blue-200','text-blue-800','bg-red-50','border-red-200','text-red-700');
    el.classList.add(success ? 'bg-blue-50' : 'bg-red-50', 'border',
        success ? 'border-blue-200' : 'border-red-200',
        success ? 'text-blue-800'   : 'text-red-700');
    el.innerHTML = msg;
}

window.addEventListener('DOMContentLoaded', loadProvinces);

document.querySelector('form').addEventListener('submit', function(e) {
    if (!wilayahValidated || !hiddenKode.value) {
        e.preventDefault();
        showResult(resultDiv, false, 'Silakan pilih lokasi lengkap sampai memilih Desa BMKG (langkah 5).');
        document.getElementById('prov_id').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});
</script>
@endsection
