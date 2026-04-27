<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recommendation_checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recommendation_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('detail')->nullable();
            $table->string('estimasi_waktu')->nullable();
            $table->string('dampak_jika_diabaikan')->nullable();
            $table->string('kategori'); // hari_ini, minggu_ini, bulan_ini
            $table->boolean('is_checked')->default(false);
            $table->timestamp('checked_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommendation_checklists');
    }
};
