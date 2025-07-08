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
        Schema::create('permintaan_mgng', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_mgng_id')
                  ->constrained('master_mgng')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
            $table->string('nomor_surat_permintaan')->unique();
            $table->date('tanggal_surat_permintaan')->nullable();
            $table->string('perihal_surat_permintaan')->nullable();
            $table->string('ditandatangani_oleh')->nullable();
            $table->string('scan_surat_permintaan')->nullable();
            $table->string('scan_proposal_magang')->nullable();
            $table->enum('status_surat_permintaan', ['belum','terkirim'])->default('belum');
            $table->enum('status_baca_surat_permintaan', ['belum','dibaca'])->default('belum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_mgng');
    }
};
