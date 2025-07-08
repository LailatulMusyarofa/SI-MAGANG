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
            $table->decimal('nilai_akhir', 5, 2)->default(0.00)->change();
            $table->decimal('nilai_teknis1', 5, 2)->default(0.00)->change();
            $table->decimal('nilai_teknis2', 5, 2)->default(0.00)->change();
            $table->decimal('nilai_teknis3', 5, 2)->default(0.00)->change();
            $table->decimal('nilai_teknis4', 5, 2)->default(0.00)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('master_psrt', function (Blueprint $table) {
            $table->double('nilai_akhir', 15, 8)->default(0.00000000)->change();
            $table->integer('nilai_teknis1')->default(0)->change();
            $table->integer('nilai_teknis2')->default(0)->change();
            $table->integer('nilai_teknis3')->default(0)->change();
            $table->integer('nilai_teknis4')->default(0)->change();
        });
    }
};
