<!DOCTYPE html>

<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>AgriCare Dashboard</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/favicon.png') }}">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container-highest": "#EFE2D5",
                        "on-secondary": "#ffffff",
                        "primary-fixed": "#EFE2D5",
                        "tertiary-fixed": "#d3e4ff",
                        "primary-container": "#F5F2F0",
                        "on-primary": "#ffffff",
                        "on-secondary-fixed": "#261a00",
                        "surface-container": "#F9F7F2",
                        "surface": "#ffffff",
                        "background": "#FDFBF7",
                        "inverse-surface": "#402E24",
                        "surface-variant": "#EFE2D5",
                        "tertiary-container": "#0077ce",
                        "tertiary": "#005ea4",
                        "primary": "#402E24",
                        "inverse-on-surface": "#FDFBF7",
                        "on-surface": "#402E24",
                        "on-surface-variant": "#63483A",
                        "secondary-fixed-dim": "#fabd00",
                        "surface-container-lowest": "#ffffff",
                        "outline-variant": "#D4A373",
                        "on-primary-fixed": "#402E24",
                        "error-container": "#ffdad6",
                        "surface-container-low": "#FCF9F5",
                        "outline": "#8C624E",
                        "tertiary-fixed-dim": "#a2c9ff",
                        "on-primary-container": "#402E24",
                        "secondary-fixed": "#ffdf9e",
                        "secondary": "#785900",
                        "secondary-container": "#fdc003",
                        "inverse-primary": "#D4A373",
                        "on-tertiary-fixed-variant": "#004881",
                        "on-error-container": "#93000a",
                        "on-background": "#402E24",
                        "surface-bright": "#fdfbff",
                        "surface-container-high": "#F7EFE9",
                        "primary-fixed-dim": "#D4A373",
                        "on-tertiary-container": "#fdfcff",
                        "surface-tint": "#402E24",
                        "on-primary-fixed-variant": "#63483A",
                        "on-secondary-container": "#6c5000",
                        "on-tertiary": "#ffffff",
                        "surface-dim": "#d8dae0",
                        "on-secondary-fixed-variant": "#5b4300",
                        "on-error": "#ffffff",
                        "error": "#ba1a1a",
                        "on-tertiary-fixed": "#001c38"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "lg": "48px",
                        "container_margin": "20px",
                        "xs": "4px",
                        "md": "24px",
                        "base": "8px",
                        "gutter": "16px",
                        "sm": "12px"
                    },
                    "fontFamily": {
                        "small-label": ["Plus Jakarta Sans"],
                        "h3": ["Plus Jakarta Sans"],
                        "h1": ["Plus Jakarta Sans"],
                        "h2": ["Plus Jakarta Sans"],
                        "body": ["Plus Jakarta Sans"]
                    },
                    "fontSize": {
                        "small-label": ["13px", { "lineHeight": "1.2", "letterSpacing": "0.01em", "fontWeight": "500" }],
                        "h3": ["24px", { "lineHeight": "1.4", "fontWeight": "500" }],
                        "h1": ["48px", { "lineHeight": "1.2", "letterSpacing": "-0.02em", "fontWeight": "500" }],
                        "h2": ["32px", { "lineHeight": "1.3", "fontWeight": "500" }],
                        "body": ["16px", { "lineHeight": "1.7", "fontWeight": "400" }]
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background text-on-background min-h-screen pb-24 md:pb-0 flex flex-col">
    @include('layouts.navigation')

    <!-- Page Content -->
    <main class="flex-1 flex flex-col">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-slate-900 border-t border-orange-100/50 dark:border-slate-800 mt-auto">
        <div class="max-w-[1600px] mx-auto px-4 xl:px-6 py-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-orange-700 dark:text-orange-500 text-[24px]" style="font-variation-settings: 'FILL' 1;">eco</span>
                <span class="text-sm font-bold text-slate-700 dark:text-slate-300">AgriCare</span>
                <span class="text-sm text-slate-500 dark:text-slate-400 ml-2">&copy; {{ date('Y') }} Hak Cipta Dilindungi.</span>
            </div>
            <div class="flex items-center gap-6">
                <a href="{{ route('about') }}" class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-orange-600 dark:hover:text-orange-400 transition-colors">Tentang Kami</a>
                <a href="{{ route('terms') }}" class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-orange-600 dark:hover:text-orange-400 transition-colors">Syarat & Ketentuan</a>
                <a href="{{ route('privacy') }}" class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-orange-600 dark:hover:text-orange-400 transition-colors">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>

    @if(!request()->routeIs('tanibot'))
        @include('components.ai_button')
    @endif
</body>
</html>
