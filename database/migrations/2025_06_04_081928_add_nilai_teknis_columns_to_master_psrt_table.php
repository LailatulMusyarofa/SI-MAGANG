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
        Schema::table('master_psrt', function (Blueprint $table) {
            $table->integer('nilai_teknis1')->default(0)->after('nilai_inisiatif');
            $table->integer('nilai_teknis2')->default(0)->after('nilai_teknis1');
            $table->integer('nilai_teknis3')->default(0)->after('nilai_teknis2');
            $table->integer('nilai_teknis4')->default(0)->after('nilai_teknis3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_psrt', function (Blueprint $table) {
            $table->dropColumn(['nilai_teknis1', 'nilai_teknis2', 'nilai_teknis3', 'nilai_teknis4']);
        });
    }
};
