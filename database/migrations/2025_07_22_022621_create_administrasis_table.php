<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('administrasis', function (Blueprint $table) {
        $table->id();
        $table->string('nama_lembaga');
        $table->string('alamat');
        $table->string('kontak')->nullable();
        $table->string('email')->nullable();
        $table->string('narahubung');
        $table->string('jenis_kelamin');
        $table->string('jabatan');
        $table->string('no_hp');
        $table->string('status_pengajuan')->default('belum diproses');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrasis');
    }
};
