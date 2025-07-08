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
        Schema::create('master_sklh', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('jenis_sklh', ['sma', 'pgt', 'lpd', 'upt'])->default('sma');
            $table->string('alamat_sklh');
            $table->string('kabko_sklh');
            $table->string('telp_sklh');
            $table->enum('akreditasi_sklh', ['c','b','a'])->default('c');
            $table->string('no_akreditasi_sklh');
            $table->string('scan_surat_akreditasi_sklh');
            $table->string('nama_narahubung');
            $table->enum('jenis_kelamin_narahubung',['pria','wanita'])->default('pria');
            $table->string('jabatan_narahubung');
            $table->string('handphone_narahubung');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_sklh');
    }
};
