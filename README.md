# AgriCare (sebelumnya TaniPintar)

AgriCare adalah platform manajemen pertanian cerdas berbasis web yang mengintegrasikan kecerdasan buatan (AI) untuk membantu petani dalam merencanakan, memantau, dan mengoptimalkan hasil panen mereka. Sistem ini memberikan rekomendasi personal untuk setiap lahan berdasarkan komoditas, fase penanaman, luas area, dan data cuaca secara *real-time*.

## ✨ Fitur Utama

- **Dashboard AI Pintar:** Tampilan ringkasan lahan dengan *lazy loading* AI, menampilkan skor ketahanan lahan dan aktivitas mandatori harian secara instan.
- **Kalkulator Pemupukan AI:** Secara otomatis menghitung dosis dan jadwal pemupukan yang paling optimal, disesuaikan persis dengan luas lahan (Hektar) dan usia tanaman. Data tersimpan secara permanen di database.
- **Kalender Tanam:** Membantu petani menentukan jadwal ideal mulai dari persiapan lahan, penanaman, pemeliharaan, hingga estimasi panen.
- **TaniBot (Tanya AI):** Asisten virtual pintar (*chatbot*) yang siap menjawab semua permasalahan seputar pertanian dan agrikultur.
- **Deteksi Hama & Penyakit:** (Dalam Pengembangan) Membantu mendeteksi hama dan merekomendasikan solusi penanganannya.
- **Integrasi Cuaca:** Mengambil data prakiraan cuaca lokal secara langsung (via API BMKG) untuk menentukan peringatan risiko iklim terhadap lahan.
- **Kelola Banyak Lahan:** Pengguna dapat mendaftarkan dan memantau beberapa lahan berbeda dengan komoditas yang berbeda-beda sekaligus.

## 💻 Teknologi yang Digunakan

Proyek ini dibangun dengan *stack* modern dan kokoh:

- **Backend:** [Laravel 13](https://laravel.com/) (PHP 8.3)
- **Frontend:** Blade Templating Engine + [Tailwind CSS](https://tailwindcss.com/)
- **Database:** MySQL
- **Kecerdasan Buatan (AI):** Google Gemini AI API
- **API Eksternal:** API BMKG (untuk prakiraan cuaca)

## 🚀 Panduan Instalasi & Menjalankan Proyek

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek AgriCare secara lokal di komputer Anda:

### 1. Persyaratan Sistem
Pastikan komputer Anda sudah terinstal:
- PHP >= 8.3
- Composer
- Node.js & npm
- MySQL / MariaDB

### 2. Kloning Repositori
```bash
git clone https://github.com/mohamadarif03/AgriCare.git
cd AgriCare
```

### 3. Instalasi Dependensi (Backend & Frontend)
Instal *package* PHP melalui Composer dan *library* JavaScript/CSS melalui npm:
```bash
composer install
npm install
npm run build
```

### 4. Pengaturan Lingkungan (Environment)
Salin file konfigurasi bawaan dan sesuaikan dengan *environment* Anda:
```bash
cp .env.example .env
```
Buka file `.env` di teks editor, lalu sesuaikan konfigurasi database dan API key Anda. Pastikan untuk mengisi kredensial AI:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=

GEMINI_API_KEY=masukkan_api_key_gemini_anda_di_sini
```

### 5. *Generate Key* dan Migrasi Database
Buat Application Key untuk Laravel dan jalankan migrasi beserta *seeder* awal (untuk data dummy market dll):
```bash
php artisan key:generate
php artisan migrate --seed
```

### 6. Jalankan Aplikasi
Jalankan *development server* bawaan Laravel:
```bash
php artisan serve
```
Aplikasi kini dapat diakses melalui browser di: `http://localhost:8000`

## 🤝 Kontribusi
Jika Anda ingin berkontribusi pada proyek ini, silakan buat *Pull Request* atau laporkan masalah melalui tab *Issues* di GitHub.

---
Dibuat dengan ❤️ untuk kemajuan Petani.
