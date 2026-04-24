@extends('layouts.app')

@section('content')
<main class="flex-grow w-full max-w-[1600px] mx-auto px-4 xl:px-6 py-6 md:py-8 flex flex-col gap-6">

    {{-- Flash Messages --}}
    @if(session('success'))
    <div id="flash-success" class="flex items-center gap-3 px-5 py-4 bg-green-50 border border-green-200 text-green-800 rounded-xl shadow-sm">
        <span class="material-symbols-outlined text-green-600">check_circle</span>
        <span class="font-semibold text-sm">{{ session('success') }}</span>
        <button onclick="document.getElementById('flash-success').remove()" class="ml-auto text-green-500 hover:text-green-700">
            <span class="material-symbols-outlined text-[18px]">close</span>
        </button>
    </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('manage_lands') }}" class="p-2 -ml-2 text-on-surface-variant hover:text-primary hover:bg-surface-container rounded-full transition-colors flex items-center justify-center">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="font-h2 text-h2 text-on-surface leading-tight">Edit Lahan</h1>
            <p class="font-body text-sm text-on-surface-variant mt-1">Perbarui informasi lahan <strong>{{ $lahan->nama }}</strong>.</p>
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
            <form action="{{ route('lahan.update', $lahan) }}" method="POST" enctype="multipart/form-data"
                  class="bg-surface-container-lowest rounded-2xl p-6 md:p-8 shadow-[0_4px_20px_rgba(27,94,32,0.03)] border border-outline-variant/30 space-y-6">
                @csrf
                @method('PUT')

                {{-- Nama Lahan --}}
                <div>
                    <label for="nama" class="block text-sm font-semibold text-on-surface mb-2">Nama Lahan <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px]">landscape</span>
                        <input type="text" id="nama" name="nama"
                               value="{{ old('nama', $lahan->nama) }}"
                               placeholder="Misal: Sawah Blok A"
                               class="w-full pl-11 pr-4 py-3 rounded-xl bg-surface-container-low border border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none transition-all @error('nama') border-red-400 bg-red-50 @enderror" required>
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
                                    class="w-full pl-11 pr-10 py-3 rounded-xl bg-surface-container-low border border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none appearance-none cursor-pointer transition-all" required>
                                @foreach(['padi' => 'Padi', 'jagung' => 'Jagung', 'cabai' => 'Cabai', 'bawang_merah' => 'Bawang Merah', 'kedelai' => 'Kedelai', 'lainnya' => 'Lainnya...'] as $val => $label)
                                <option value="{{ $val }}" {{ old('komoditas', $lahan->komoditas) === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px] pointer-events-none">expand_more</span>
                        </div>
                    </div>

                    {{-- Luas Lahan --}}
                    <div>
                        <label for="luas" class="block text-sm font-semibold text-on-surface mb-2">Luas Lahan</label>
                        <div class="flex gap-2">
                            <input type="number" id="luas" name="luas" step="0.01" min="0"
                                   value="{{ old('luas', $lahan->luas) }}"
                                   class="w-full px-4 py-3 rounded-xl bg-surface-container-low border border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none transition-all">
                            <select name="area_unit" class="w-32 px-3 py-3 rounded-xl bg-surface-container-low border border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none cursor-pointer transition-all">
                                <option value="ha" selected>Hektar (Ha)</option>
                                <option value="m2">Meter Persegi (m²)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Fase Tanam --}}
                    <div>
                        <label for="fase_tanam" class="block text-sm font-semibold text-on-surface mb-2">Fase Tanam Saat Ini</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px]">eco</span>
                            <select id="fase_tanam" name="fase_tanam"
                                    class="w-full pl-11 pr-10 py-3 rounded-xl bg-surface-container-low border border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none appearance-none cursor-pointer transition-all">
                                @foreach(['persiapan' => 'Persiapan Lahan', 'persemaian' => 'Persemaian', 'tanam' => 'Penanaman', 'vegetatif' => 'Vegetatif', 'generatif' => 'Generatif', 'panen' => 'Panen', 'pasca_panen' => 'Pasca Panen'] as $val => $label)
                                <option value="{{ $val }}" {{ old('fase_tanam', $lahan->fase_tanam) === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px] pointer-events-none">expand_more</span>
                        </div>
                    </div>

                    {{-- Status Risiko --}}
                    <div>
                        <label for="status_risiko" class="block text-sm font-semibold text-on-surface mb-2">Status Risiko</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px]">security</span>
                            <select id="status_risiko" name="status_risiko"
                                    class="w-full pl-11 pr-10 py-3 rounded-xl bg-surface-container-low border border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none appearance-none cursor-pointer transition-all">
                                <option value="optimal" {{ old('status_risiko', $lahan->status_risiko) === 'optimal' ? 'selected' : '' }}>Optimal (Aman)</option>
                                <option value="waspada" {{ old('status_risiko', $lahan->status_risiko) === 'waspada' ? 'selected' : '' }}>Waspada</option>
                                <option value="kritis" {{ old('status_risiko', $lahan->status_risiko) === 'kritis' ? 'selected' : '' }}>Kritis</option>
                            </select>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px] pointer-events-none">expand_more</span>
                        </div>
                    </div>
                </div>

                {{-- Tanggal Tanam --}}
                <div>
                    <label for="tanggal_tanam" class="block text-sm font-semibold text-on-surface mb-2">Tanggal Tanam</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px]">calendar_month</span>
                        <input type="date" id="tanggal_tanam" name="tanggal_tanam"
                               value="{{ old('tanggal_tanam', $lahan->tanggal_tanam?->toDateString()) }}"
                               class="w-full pl-11 pr-4 py-3 rounded-xl bg-surface-container-low border border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none transition-all">
                    </div>
                </div>

                {{-- Alamat --}}
                <div>
                    <label for="alamat" class="block text-sm font-semibold text-on-surface mb-2">Alamat / Lokasi Lahan</label>
                    <div class="relative">
                        <span class="absolute left-4 top-3.5 material-symbols-outlined text-outline text-[20px]">location_on</span>
                        <textarea id="alamat" name="alamat" rows="2"
                                  placeholder="Misal: Desa Karangjati, Kec. Sampang, Cilacap"
                                  class="w-full pl-11 pr-4 py-3 rounded-xl bg-surface-container-low border border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none transition-all placeholder:text-outline-variant resize-none">{{ old('alamat', $lahan->alamat) }}</textarea>
                    </div>
                </div>

                {{-- Foto Lahan --}}
                <div>
                    <label class="block text-sm font-semibold text-on-surface mb-2">Foto Lahan</label>
                    @if($lahan->foto)
                    <div class="mb-3 relative">
                        <img src="{{ asset('storage/' . $lahan->foto) }}" alt="Foto saat ini" class="w-full max-h-48 object-cover rounded-xl">
                        <span class="absolute bottom-2 left-2 text-xs bg-black/60 text-white px-2 py-1 rounded">Foto saat ini</span>
                    </div>
                    @endif
                    <div class="relative border-2 border-dashed border-outline-variant/50 rounded-xl p-6 flex flex-col items-center gap-3 hover:border-primary/50 transition-colors cursor-pointer bg-surface-container-low"
                         onclick="document.getElementById('foto').click()">
                        <span class="material-symbols-outlined text-3xl text-on-surface-variant">add_a_photo</span>
                        <p class="text-sm text-on-surface-variant">{{ $lahan->foto ? 'Klik untuk ganti foto' : 'Klik untuk upload foto' }}</p>
                        <input type="file" id="foto" name="foto" accept="image/*" class="hidden" onchange="previewFoto(this)">
                        <img id="foto-preview" class="hidden w-full max-h-48 object-cover rounded-lg" alt="Preview">
                    </div>
                </div>

                {{-- Submit Buttons --}}
                <div class="pt-4 flex flex-col sm:flex-row items-center gap-3 justify-between border-t border-outline-variant/30">
                    {{-- Hapus Lahan --}}
                    <form action="{{ route('lahan.destroy', $lahan) }}" method="POST"
                          onsubmit="return confirm('Hapus lahan ini? Aksi ini tidak dapat dibatalkan.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="flex items-center gap-2 text-sm font-semibold text-red-500 hover:text-red-700 hover:bg-red-50 px-4 py-2.5 rounded-xl transition-colors">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                            Hapus Lahan
                        </button>
                    </form>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('lahan.show', $lahan) }}" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-on-surface-variant bg-surface hover:bg-surface-container transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-on-primary bg-primary hover:bg-primary-container shadow-md hover:shadow-lg transition-all active:scale-95 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">save</span>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-4 space-y-6">
            {{-- Info Box --}}
            <div class="bg-primary-container/10 rounded-2xl p-6 border border-primary-container/20">
                <div class="flex items-center gap-2 text-primary font-bold mb-3">
                    <span class="material-symbols-outlined">info</span> Informasi
                </div>
                <p class="text-sm text-on-surface-variant leading-relaxed">
                    Perubahan <strong>tanggal tanam</strong> akan otomatis menghitung ulang estimasi panen berdasarkan komoditas yang dipilih.
                </p>
            </div>

            {{-- Current Info Card --}}
            <div class="bg-surface-container-lowest rounded-2xl p-6 border border-outline-variant/30">
                <h3 class="font-semibold text-on-surface mb-4">Info Lahan Saat Ini</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Dibuat</span>
                        <span class="font-semibold text-on-surface">{{ $lahan->created_at->translatedFormat('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Estimasi Panen</span>
                        <span class="font-semibold text-on-surface">
                            {{ $lahan->estimasi_panen ? $lahan->estimasi_panen->translatedFormat('d M Y') : '—' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Status</span>
                        <span class="font-semibold {{ $lahan->is_aktif ? 'text-green-600' : 'text-on-surface-variant' }}">
                            {{ $lahan->is_aktif ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>

                {{-- Toggle Aktif --}}
                <form action="{{ route('lahan.toggle-aktif', $lahan) }}" method="POST" class="mt-4">
                    @csrf @method('PATCH')
                    <button type="submit" class="w-full py-2 rounded-xl text-sm font-semibold transition-colors {{ $lahan->is_aktif ? 'bg-red-50 text-red-600 hover:bg-red-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }}">
                        {{ $lahan->is_aktif ? 'Nonaktifkan Lahan' : 'Aktifkan Lahan' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
function previewFoto(input) {
    const preview = document.getElementById('foto-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
