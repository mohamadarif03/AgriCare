<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('market_prices', function (Blueprint $table) {
            $table->id();
            $table->string('komoditas', 100)->index();       // padi, jagung, cabai, bawang_merah, kedelai
            $table->date('tanggal')->index();
            $table->unsignedInteger('harga');                 // harga dalam Rupiah per kg
            $table->string('wilayah', 150)->index();          // provinsi/kota
            $table->string('sumber', 50)->default('dummy');   // panelharga / hargapangan / dummy
            $table->timestamps();

            $table->unique(['komoditas', 'tanggal', 'wilayah'], 'market_prices_unique');
        });

        Schema::create('market_price_insights', function (Blueprint $table) {
            $table->id();
            $table->string('komoditas', 100)->index();
            $table->string('wilayah', 150)->index();
            $table->json('insight_data');                     // cached Gemini JSON response
            $table->timestamp('expires_at')->index();
            $table->timestamps();

            $table->unique(['komoditas', 'wilayah'], 'insights_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('market_price_insights');
        Schema::dropIfExists('market_prices');
    }
};
