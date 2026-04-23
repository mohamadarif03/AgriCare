<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lahans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Informasi dasar lahan
            $table->string('nama');
            $table->string('komoditas');
            $table->decimal('luas', 8, 2)->nullable()->comment('Dalam hektar');
            $table->string('foto')->nullable();

            // Lokasi
            $table->string('alamat')->nullable();
            $table->string('kode_wilayah', 20)->comment('Kode adm4 BMKG, contoh: 33.01.01.2001');
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Fase & siklus tanam
            $table->enum('fase_tanam', [
                'persiapan',
                'persemaian',
                'tanam',
                'vegetatif',
                'generatif',
                'panen',
                'pasca_panen'
            ])->default('persiapan');
            $table->date('tanggal_tanam')->nullable();
            $table->date('estimasi_panen')->nullable();
            $table->integer('durasi_tanam_hari')->nullable()->comment('Estimasi hari dari tanam ke panen');

            // Status risiko (di-update berkala dari BMKG + Gemini)
            $table->enum('status_risiko', ['optimal', 'waspada', 'kritis'])->default('optimal');
            $table->timestamp('status_risiko_updated_at')->nullable();

            // Hasil kalender tanam dari Gemini (di-cache di DB)
            $table->json('kalender_tanam')->nullable()->comment('Cache hasil generate Gemini');
            $table->timestamp('kalender_tanam_generated_at')->nullable();

            // Pengaturan
            $table->boolean('notifikasi_aktif')->default(true);
            $table->boolean('is_aktif')->default(true)->comment('Lahan aktif di dashboard');

            $table->timestamps();
            $table->softDeletes();

            // Index untuk query yang sering dipakai
            $table->index(['user_id', 'is_aktif']);
            $table->index('kode_wilayah');
            $table->index('komoditas');
        });

        // Tabel riwayat musim tanam per lahan
        Schema::create('musim_tanams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lahan_id')->constrained()->cascadeOnDelete();
            $table->string('komoditas');
            $table->date('tanggal_tanam');
            $table->date('tanggal_panen')->nullable();
            $table->decimal('hasil_panen_kg', 10, 2)->nullable();
            $table->enum('status', ['berlangsung', 'berhasil', 'gagal'])->default('berlangsung');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index(['lahan_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('musim_tanams');
        Schema::dropIfExists('lahans');
    }
};
