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
        Schema::create('master_bdng_member', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_bdng');
            $table->foreign('id_bdng')->references('id')->on('master_bdng')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('nama_pejabat')->nullable();
            $table->string('nip_pejabat')->nullable();
            $table->string('pangkat_pejabat')->nullable();
            $table->string('golongan_pejabat')->nullable();
            $table->string('ruang_pejabat')->nullable();
            $table->string('jabatan_pejabat')->nullable();//untuk jabatan sekretaris dan ketua tidak bisa diedit
            $table->string('sub_bidang_pejabat')->nullable();
            $table->timestamps();
          });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_bdng_member');
    }
};
