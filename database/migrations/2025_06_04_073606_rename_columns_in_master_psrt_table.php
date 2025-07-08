<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_psrt', function (Blueprint $table) {
            $table->renameColumn('nilai_kedisiplinan', 'nilai_kehadiran');
            $table->renameColumn('nilai_tanggungjawab', 'nilai_kerapian');
            $table->renameColumn('nilai_kerjasama', 'nilai_sikap');
        });

        Schema::table('master_psrt', function (Blueprint $table) {
            $table->renameColumn('nilai_motivasi', 'nilai_tanggungjawab');
            $table->renameColumn('nilai_kepribadian', 'nilai_kepatuhan');
        });

        Schema::table('master_psrt', function (Blueprint $table) {
            $table->renameColumn('nilai_pengetahuan', 'nilai_komunikasi');
            $table->renameColumn('nilai_pelaksanaankerja', 'nilai_kerjasama');
            $table->renameColumn('nilai_hasilkerja', 'nilai_inisiatif');
        });
    }

    public function down(): void
    {
        Schema::table('master_psrt', function (Blueprint $table) {
            $table->renameColumn('nilai_kehadiran', 'nilai_kedisiplinan');
            $table->renameColumn('nilai_kerapian', 'nilai_tanggungjawab');
            $table->renameColumn('nilai_sikap', 'nilai_kerjasama');
        });

        Schema::table('master_psrt', function (Blueprint $table) {
            $table->renameColumn('nilai_tanggungjawab', 'nilai_motivasi');
            $table->renameColumn('nilai_kepatuhan', 'nilai_kepribadian');
        });

        Schema::table('master_psrt', function (Blueprint $table) {
            $table->renameColumn('nilai_komunikasi', 'nilai_pengetahuan');
            $table->renameColumn('nilai_kerjasama', 'nilai_pelaksanaankerja');
            $table->renameColumn('nilai_inisiatif', 'nilai_hasilkerja');
        });
    }
};
