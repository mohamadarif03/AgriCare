<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Masuk - TaniSiaga</title>
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
<body class="bg-background text-on-background font-body min-h-screen flex items-center justify-center p-4 relative overflow-hidden py-10">
    <!-- Abstract Background Decoration -->
    <div class="absolute inset-0 z-0 opacity-10 pointer-events-none">
        <div class="absolute top-20 left-10 w-64 h-64 bg-primary rounded-full mix-blend-multiply filter blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-primary-container rounded-full mix-blend-multiply filter blur-3xl"></div>
    </div>
    <img alt="Lahan Pertanian TaniSiaga" class="absolute inset-0 w-full h-full object-cover opacity-20 z-0 pointer-events-none" src="{{ asset('assets/herosection.jpeg') }}" />
    
    <div class="w-full max-w-md bg-surface-container-lowest rounded-2xl shadow-ambient border border-outline-variant/30 p-8 relative z-10">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-primary-container text-on-primary-container mb-4">
                <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">eco</span>
            </div>
            <h1 class="text-2xl font-bold text-on-surface mb-2">Selamat Datang Kembali</h1>
            <p class="text-on-surface-variant text-sm">Masuk ke akun TaniSiaga Anda</p>
        </div>

        <form class="space-y-5" method="POST" action="{{ route('login.post') }}">
            @csrf
            <div>
                <label class="block text-sm font-medium text-on-surface mb-1.5" for="email">Email</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px]">mail</span>
                    <input class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-surface-container-low border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none transition-all @error('email') border-red-500 @enderror" id="email" name="email" placeholder="Masukkan email Anda" type="email" value="{{ old('email') }}" required autofocus />
                </div>
                @error('email')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-on-surface mb-1.5" for="password">Kata Sandi</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-[20px]">lock</span>
                    <input class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-surface-container-low border-transparent focus:border-primary focus:ring-1 focus:ring-primary text-on-surface font-body text-sm outline-none transition-all @error('password') border-red-500 @enderror" id="password" name="password" placeholder="Masukkan kata sandi" type="password" required />
                </div>
                @error('password')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input class="h-4 w-4 text-primary focus:ring-primary border-outline-variant rounded" id="remember-me" name="remember" type="checkbox" />
                    <label class="ml-2 block text-sm text-on-surface-variant" for="remember-me">Ingat saya</label>
                </div>
                <div class="text-sm">
                    <a class="font-medium text-primary hover:text-primary-container transition-colors" href="#">Lupa sandi?</a>
                </div>
            </div>

            <button class="w-full bg-primary text-on-primary py-2.5 px-4 rounded-xl font-medium hover:bg-primary-container hover:text-on-primary-container transition-all active:scale-[0.98] duration-200 shadow-sm" type="submit">
                Masuk
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-outline-variant/30 text-center">
            <p class="text-sm text-on-surface-variant">
                Belum punya akun? 
                <a class="font-semibold text-primary hover:text-primary-container transition-colors" href="{{ route('register') }}">Daftar sekarang</a>
            </p>
        </div>
        
        <div class="mt-6 text-center">
            <a href="{{ route('index') }}" class="inline-flex items-center text-sm text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-[18px] mr-1">arrow_back</span>
                Kembali ke Beranda
            </a>
        </div>
    </div>

    @include('components.ai_button')
</body>
</html>
