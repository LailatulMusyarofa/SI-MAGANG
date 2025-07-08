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
        Schema::create('balasan_mgng', function (Blueprint $table) {
            // Kolom ID sebagai primary key
            $table->id();  // BIGINT UNSIGNED dan AUTO_INCREMENT secara default

            // Kolom relasi ke tabel master_mgng
            $table->unsignedBigInteger('master_mgng_id');
            $table->foreign('master_mgng_id')->references('id')->on('master_mgng')->onUpdate('CASCADE')->onDelete('CASCADE');

            // Kolom data balasan
            $table->string('nomor_surat_balasan')->nullable();
            $table->date('tanggal_surat_balasan')->nullable();
            $table->enum('sifat_surat_balasan', ['biasa', 'penting', 'segera'])->default('biasa');
            $table->enum('metode_magang', ['offline', 'online'])->default('offline');
            $table->enum('lampiran_surat_balasan', ['tidakada', 'selembar'])->default('tidakada');
            $table->string('scan_surat_balasan')->nullable();
            $table->date('tanggal_awal_magang')->nullable();
            $table->date('tanggal_akhir_magang')->nullable();
            $table->enum('status_surat_balasan', ['belum', 'terkirim'])->default('belum');
            $table->enum('status_baca_surat_balasan', ['belum', 'dibaca', 'belumbacaupdate', 'dibacaupdate'])->default('belum');
            
            // Kolom relasi ke tabel master_bdng_member
            $table->unsignedBigInteger('id_bdng_member')->nullable();
            $table->foreign('id_bdng_member')->references('id')->on('master_bdng_member')->onUpdate('CASCADE')->onDelete('CASCADE');
            
            // Timestamps untuk created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balasan_mgng');
    }
};
