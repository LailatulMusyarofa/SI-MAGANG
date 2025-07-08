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
         Schema::create('nota_dinas', function (Blueprint $table) {
            $table->id();
            // Kolom master_mgng_id yang mengarah ke id tabel master_mgng
            $table->foreignId('master_mgng_id')->constrained('master_mgng')
                ->cascadeOnUpdate()->cascadeOnDelete();

            // Kolom master_bdng_id yang mengarah ke id tabel master_bdng
            $table->foreignId('master_bdng_id')->constrained('master_bdng')
                ->cascadeOnUpdate()->cascadeOnDelete();

            $table->string('nomor_nota_dinas')->nullable();
            $table->date('tanggal_nota_dinas')->nullable();
            $table->enum('sifat_nota_dinas', ['biasa', 'penting', 'segera'])->default('biasa');
            $table->enum('lampiran_nota_dinas', ['tidakada', 'selembar'])->default('tidakada');
            $table->string('scan_nota_dinas')->nullable();
            $table->enum('status_nota_dinas', ['belum', 'terkirim'])->default('belum');

            // Kolom untuk bdng_member_id yang mengarah ke master_bdng_member
            $table->foreignId('bdng_member_id')->nullable()->constrained('master_bdng_member')
                ->cascadeOnUpdate()->cascadeOnDelete();

            $table->string('scan_laporan_magang')->nullable();
            $table->enum('status_laporan', ['belum', 'terkirim'])->default('belum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_dinas');
    }
};
