@extends('layouts.app')

@section('content')
<div class="px-4 xl:px-6 w-full max-w-[1200px] mx-auto py-8 lg:py-12 flex-1">
    
    <!-- Hero Section -->
    <div class="mb-10 md:mb-12">
        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-800 dark:text-white tracking-tight mb-4">Syarat & Ketentuan</h1>
        <p class="text-lg text-slate-500 dark:text-slate-400">
            Pembaruan Terakhir: {{ date('d F Y') }}
        </p>
    </div>

    <!-- Content Sections -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 md:p-12 shadow-sm border border-slate-200 dark:border-slate-700">
        <div class="prose prose-lg prose-slate dark:prose-invert max-w-none">
            
            <p class="lead text-xl text-slate-600 dark:text-slate-300 mb-8">
                Selamat datang di AgriCare. Dengan mengakses dan menggunakan layanan kami, Anda dianggap telah membaca, memahami, dan menyetujui seluruh syarat dan ketentuan yang berlaku di bawah ini.
            </p>

            <h2 class="text-2xl font-bold text-slate-800 dark:text-white mt-10 mb-4">1. Definisi dan Layanan</h2>
            <p class="text-slate-600 dark:text-slate-300 mb-6">
                AgriCare adalah platform berbasis web yang menyediakan informasi seputar pertanian, meliputi namun tidak terbatas pada, kalender tanam, prediksi cuaca, rekomendasi pemupukan berbasis AI, deteksi hama, dan informasi harga pasar. Layanan ini disediakan "sebagaimana adanya" untuk membantu pengambilan keputusan, bukan sebagai jaminan keberhasilan panen mutlak.
            </p>

            <h2 class="text-2xl font-bold text-slate-800 dark:text-white mt-10 mb-4">2. Akun Pengguna</h2>
            <ul class="list-disc pl-6 text-slate-600 dark:text-slate-300 space-y-2 mb-6">
                <li>Pengguna wajib memberikan informasi yang akurat dan terkini saat melakukan pendaftaran.</li>
                <li>Keamanan kata sandi dan akun adalah tanggung jawab penuh dari pengguna.</li>
                <li>AgriCare berhak untuk menangguhkan atau menghapus akun yang melanggar ketentuan atau terindikasi melakukan tindakan penyalahgunaan.</li>
            </ul>

            <h2 class="text-2xl font-bold text-slate-800 dark:text-white mt-10 mb-4">3. Penggunaan Data</h2>
            <p class="text-slate-600 dark:text-slate-300 mb-6">
                Kami berkomitmen untuk menjaga privasi dan keamanan data Anda. Data lahan dan aktivitas yang Anda masukkan akan digunakan semata-mata untuk meningkatkan akurasi rekomendasi AI yang kami berikan. Kami tidak akan menjual atau membagikan data identitas pribadi Anda kepada pihak ketiga tanpa persetujuan Anda, kecuali diwajibkan oleh hukum.
            </p>

            <h2 class="text-2xl font-bold text-slate-800 dark:text-white mt-10 mb-4">4. Batasan Tanggung Jawab</h2>
            <p class="text-slate-600 dark:text-slate-300 mb-6">
                Seluruh rekomendasi yang diberikan oleh AgriCare dihasilkan oleh algoritma Artificial Intelligence berdasarkan data cuaca, iklim, dan pasar yang tersedia secara publik (BMKG, Kementerian Pertanian, dll). Kami tidak menjamin keakuratan absolut dari prediksi tersebut. Kerugian materil maupun imateril yang timbul akibat keputusan bertani yang diambil sepenuhnya merupakan tanggung jawab pengguna.
            </p>

            <h2 class="text-2xl font-bold text-slate-800 dark:text-white mt-10 mb-4">5. Kekayaan Intelektual</h2>
            <p class="text-slate-600 dark:text-slate-300 mb-6">
                Seluruh desain, logo, algoritma, dan konten yang terdapat pada AgriCare dilindungi oleh hak cipta. Pengguna dilarang untuk menyalin, mereproduksi, atau mendistribusikan ulang elemen-elemen tersebut tanpa izin tertulis dari pihak AgriCare.
            </p>

            <h2 class="text-2xl font-bold text-slate-800 dark:text-white mt-10 mb-4">6. Perubahan Ketentuan</h2>
            <p class="text-slate-600 dark:text-slate-300 mb-6">
                AgriCare berhak mengubah syarat dan ketentuan ini kapan saja. Perubahan akan diinformasikan melalui halaman ini atau melalui notifikasi akun. Penggunaan layanan yang berkelanjutan setelah perubahan dianggap sebagai persetujuan terhadap syarat dan ketentuan yang baru.
            </p>

         

        </div>
    </div>
</div>
@endsection
