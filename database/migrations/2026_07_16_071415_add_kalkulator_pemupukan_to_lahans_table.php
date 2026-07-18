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
        Schema::table('lahans', function (Blueprint $table) {
            $table->json('kalkulator_pemupukan')->nullable()->after('pest_detection_updated_at');
            $table->timestamp('kalkulator_pemupukan_generated_at')->nullable()->after('kalkulator_pemupukan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lahans', function (Blueprint $table) {
            $table->dropColumn(['kalkulator_pemupukan', 'kalkulator_pemupukan_generated_at']);
        });
    }
};
