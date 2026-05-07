@extends('layouts.app')

@section('content')
<div class="px-4 xl:px-6 w-full max-w-[1200px] mx-auto py-8 lg:py-12 flex-1">
    
    <!-- Hero Section -->
    <div class="mb-10 md:mb-12">
        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-800 dark:text-white tracking-tight mb-4">Kebijakan Privasi</h1>
        <p class="text-lg text-slate-500 dark:text-slate-400">
            Pembaruan Terakhir: {{ date('d F Y') }}
        </p>
    </div>

    <!-- Content Sections -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 md:p-12 shadow-sm border border-slate-200 dark:border-slate-700">
        <div class="prose prose-lg prose-slate dark:prose-invert max-w-none">
            
            <p class="lead text-xl text-slate-600 dark:text-slate-300 mb-8">
                Privasi Anda sangat penting bagi kami. Kebijakan Privasi ini menjelaskan bagaimana PastiPanen mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda saat menggunakan layanan kami.
            </p>

            <h2 class="text-2xl font-bold text-slate-800 dark:text-white mt-10 mb-4">1. Informasi yang Kami Kumpulkan</h2>
            <p class="text-slate-600 dark:text-slate-300 mb-6">
                Kami dapat mengumpulkan informasi berikut saat Anda menggunakan platform kami:
            </p>
            <ul class="list-disc pl-6 text-slate-600 dark:text-slate-300 space-y-2 mb-6">
                <li><strong>Informasi Pribadi:</strong> Nama, alamat email, dan kata sandi saat Anda mendaftar.</li>
                <li><strong>Data Lahan:</strong> Lokasi geografis (titik koordinat), luas lahan, dan jenis komoditas yang Anda tanam.</li>
                <li><strong>Data Penggunaan:</strong> Interaksi Anda dengan fitur-fitur seperti asisten AI (TaniBot), unggahan foto deteksi hama, dan riwayat konsultasi.</li>
            </ul>

            <h2 class="text-2xl font-bold text-slate-800 dark:text-white mt-10 mb-4">2. Bagaimana Kami Menggunakan Informasi Anda</h2>
            <p class="text-slate-600 dark:text-slate-300 mb-6">
                Informasi yang dikumpulkan digunakan untuk:
            </p>
            <ul class="list-disc pl-6 text-slate-600 dark:text-slate-300 space-y-2 mb-6">
                <li>Menyediakan, memelihara, dan meningkatkan kualitas layanan PastiPanen.</li>
                <li>Menghasilkan rekomendasi AI yang personal untuk jadwal tanam, cuaca, dan deteksi hama berdasarkan data lahan spesifik Anda.</li>
                <li>Menghubungi Anda terkait pembaruan layanan, peringatan keamanan, atau pemberitahuan penting lainnya.</li>
            </ul>

            <h2 class="text-2xl font-bold text-slate-800 dark:text-white mt-10 mb-4">3. Perlindungan dan Keamanan Data</h2>
            <p class="text-slate-600 dark:text-slate-300 mb-6">
                Kami menerapkan standar keamanan industri untuk melindungi data Anda dari akses, perubahan, atau pengungkapan yang tidak sah. Data kata sandi disimpan dengan metode enkripsi. Meskipun kami berupaya semaksimal mungkin, tidak ada metode transmisi data di internet yang 100% aman.
            </p>

            <h2 class="text-2xl font-bold text-slate-800 dark:text-white mt-10 mb-4">4. Pembagian Informasi dengan Pihak Ketiga</h2>
            <p class="text-slate-600 dark:text-slate-300 mb-6">
                Kami <strong>tidak menjual</strong> atau menyewakan informasi pribadi Anda kepada pihak ketiga. Kami hanya dapat membagikan informasi dalam kondisi berikut:
            </p>
            <ul class="list-disc pl-6 text-slate-600 dark:text-slate-300 space-y-2 mb-6">
                <li>Kepada penyedia layanan infrastruktur cloud (seperti server dan basis data) yang terikat oleh kewajiban kerahasiaan.</li>
                <li>Jika diwajibkan oleh hukum atau permintaan dari otoritas penegak hukum.</li>
            </ul>

            <h2 class="text-2xl font-bold text-slate-800 dark:text-white mt-10 mb-4">5. Penggunaan Cookie</h2>
            <p class="text-slate-600 dark:text-slate-300 mb-6">
                PastiPanen menggunakan <em>cookie</em> dan teknologi pelacakan serupa untuk menyimpan preferensi sesi Anda (seperti status login) dan menganalisis tren penggunaan demi pengalaman pengguna yang lebih baik. Anda dapat mengatur browser Anda untuk menolak cookie, namun hal tersebut mungkin memengaruhi beberapa fungsi dari platform kami.
            </p>

            <h2 class="text-2xl font-bold text-slate-800 dark:text-white mt-10 mb-4">6. Perubahan Kebijakan Privasi</h2>
            <p class="text-slate-600 dark:text-slate-300 mb-6">
                Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Setiap perubahan akan diterbitkan di halaman ini dengan memperbarui tanggal "Pembaruan Terakhir" di bagian atas.
            </p>

        </div>
    </div>
</div>
@endsection
