<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Daftar - TaniSiaga</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#0b6b1d",
                        "primary-container": "#2e8534",
                        "on-primary": "#ffffff",
                        "on-primary-container": "#f7fff1",
                        "background": "#f6fbf0",
                        "on-background": "#181d17",
                        "surface": "#f6fbf0",
                        "on-surface": "#181d17",
                        "surface-variant": "#dfe4d9",
                        "on-surface-variant": "#40493d",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#f0f5ea",
                        "outline": "#707a6c",
                        "outline-variant": "#bfcab9",
                    },
                    "fontFamily": {
                        "body": ["Plus Jakarta Sans"],
                    }
                }
            }
        }
    </script>
    <style>
        .shadow-ambient {
            box-shadow: 0 4px 20px rgba(27, 94, 32, 0.08);
        }
    </style>
</head>
<body class="bg-background text-on-background font-body min-h-screen flex items-center justify-center p-4 relative overflow-y-auto overflow-x-hidden py-10">
    <!-- Abstract Background Decoration -->
    <div class="absolute inset-0 z-0 opacity-10 pointer-events-none">
        <div class="absolute top-20 left-10 w-64 h-64 bg-primary rounded-full mix-blend-multiply filter blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-primary-container rounded-full mix-blend-multiply filter blur-3xl"></div>
    </div>
    <img alt="Lahan Pertanian TaniSiaga" class="absolute inset-0 w-full h-full object-cover opacity-20 z-0 pointer-events-none" src="{{ asset('assets/herosection.jpeg') }}" />
    
    <div class="w-full max-w-[380px] md:max-w-sm bg-surface-container-lowest rounded-2xl shadow-ambient border border-outline-variant/30 p-6 relative z-10">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-primary-container text-on-primary-container mb-4">
                <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">eco</span>
            </div>
            <h1 class="text-2xl font-bold text-on-surface mb-2">Buat Akun Baru</h1>
            <p class="text-on-surface-variant text-sm">Bergabung dengan TaniSiaga sekarang</p>
        </div>

        <form class="space-y-4" method="POST" action="{{ route('register.post') }}">
            @csrf
            <div>
                <label class="block text-sm font-medium text-on-surface mb-1.5" for="fullname">Nama Lengkap</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px]">person</span>
                    <input class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-surface-container-low border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none transition-all @error('name') border-red-500 @enderror" id="fullname" name="name" placeholder="Masukkan nama lengkap Anda" type="text" value="{{ old('name') }}" required autofocus />
                </div>
                @error('name')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-on-surface mb-1.5" for="email">Email</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px]">mail</span>
                    <input class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-surface-container-low border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none transition-all @error('email') border-red-500 @enderror" id="email" name="email" placeholder="Masukkan email Anda" type="email" value="{{ old('email') }}" required />
                </div>
                @error('email')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-on-surface mb-1.5" for="password">Kata Sandi</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px]">lock</span>
                    <input class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-surface-container-low border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none transition-all @error('password') border-red-500 @enderror" id="password" name="password" placeholder="Buat kata sandi" type="password" required />
                </div>
                @error('password')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-on-surface mb-1.5" for="confirm-password">Konfirmasi Kata Sandi</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px]">lock_reset</span>
                    <input class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-surface-container-low border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none transition-all" id="confirm-password" name="password_confirmation" placeholder="Ulangi kata sandi" type="password" required />
                </div>
            </div>

            <div class="flex items-start mt-2">
                <input class="mt-1 h-4 w-4 text-primary focus:ring-primary border-outline-variant rounded" id="terms" type="checkbox" required />
                <label class="ml-2 block text-sm text-on-surface-variant leading-snug" for="terms">
                    Saya setuju dengan <a href="#" class="text-primary hover:text-primary-container font-medium">Syarat & Ketentuan</a> serta <a href="#" class="text-primary hover:text-primary-container font-medium">Kebijakan Privasi</a>
                </label>
            </div>

            <button class="w-full bg-primary text-on-primary py-2.5 px-4 rounded-xl font-medium hover:bg-primary-container hover:text-on-primary-container transition-all active:scale-[0.98] duration-200 shadow-sm mt-2" type="submit">
                Daftar Akun
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-outline-variant/30 text-center">
            <p class="text-sm text-on-surface-variant">
                Sudah punya akun? 
                <a class="font-semibold text-primary hover:text-primary-container transition-colors" href="{{ route('login') }}">Masuk di sini</a>
            </p>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('index') }}" class="inline-flex items-center text-sm text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-[18px] mr-1">arrow_back</span>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
