<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_psrt', function (Blueprint $table) {
            $table->decimal('nilai_kehadiran', 5, 2)->default(0)->change();
            $table->decimal('nilai_kerapian', 5, 2)->default(0)->change();
            $table->decimal('nilai_sikap', 5, 2)->default(0)->change();
            $table->decimal('nilai_tanggungjawab', 5, 2)->default(0)->change();
            $table->decimal('nilai_kepatuhan', 5, 2)->default(0)->change();
            $table->decimal('nilai_komunikasi', 5, 2)->default(0)->change();
            $table->decimal('nilai_kerjasama', 5, 2)->default(0)->change();
            $table->decimal('nilai_inisiatif', 5, 2)->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('master_psrt', function (Blueprint $table) {
            $table->double('nilai_kehadiran', 15, 8)->default(0)->change();
            $table->double('nilai_kerapian', 15, 8)->default(0)->change();
            $table->double('nilai_sikap', 15, 8)->default(0)->change();
            $table->double('nilai_tanggungjawab', 15, 8)->default(0)->change();
            $table->double('nilai_kepatuhan', 15, 8)->default(0)->change();
            $table->double('nilai_komunikasi', 15, 8)->default(0)->change();
            $table->double('nilai_kerjasama', 15, 8)->default(0)->change();
            $table->double('nilai_inisiatif', 15, 8)->default(0)->change();
        });
    }
};

