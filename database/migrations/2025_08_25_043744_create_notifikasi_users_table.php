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
        Schema::create('notifikasi_users', function (Blueprint $table) {
            $table->id();
            $table->string('status_baca_surat_balasan')->default('belum'); // sudah / belum
            $table->string('status_surat_balasan')->nullable(); // diterima / ditolak / dll
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi_users');
    }
};
