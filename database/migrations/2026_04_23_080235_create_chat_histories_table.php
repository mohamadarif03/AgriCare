<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Sesi chat (satu percakapan bisa berisi banyak pesan)
        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lahan_id')->nullable()->constrained()->nullOnDelete();
            $table->string('judul')->nullable()->comment('Auto-generate dari pertanyaan pertama');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'lahan_id']);
        });

        // Isi pesan per sesi
        Schema::create('chat_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lahan_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('chat_session_id')->constrained()->cascadeOnDelete();

            // Isi percakapan
            $table->text('pertanyaan');
            $table->text('jawaban');

            // Konteks saat pertanyaan diajukan (snapshot)
            $table->string('komoditas_saat_itu')->nullable();
            $table->string('fase_tanam_saat_itu')->nullable();
            $table->string('status_risiko_saat_itu')->nullable();

            // Metadata
            $table->integer('token_dipakai')->nullable()->comment('Untuk monitoring pemakaian API');
            $table->integer('durasi_ms')->nullable()->comment('Waktu response Gemini dalam milidetik');
            $table->boolean('is_helpful')->nullable()->comment('Feedback dari user: helpful atau tidak');

            $table->timestamps();

            $table->index(['user_id', 'lahan_id']);
            $table->index('chat_session_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_histories');
        Schema::dropIfExists('chat_sessions');
    }
};
