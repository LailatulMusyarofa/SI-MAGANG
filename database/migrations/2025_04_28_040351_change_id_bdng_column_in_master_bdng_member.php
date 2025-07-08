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
        // Mengubah kolom id_bdng di master_bdng_member menjadi BIGINT UNSIGNED
        Schema::table('master_bdng_member', function (Blueprint $table) {
            $table->unsignedBigInteger('id_bdng')->change(); // Mengubah tipe menjadi BIGINT UNSIGNED
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Mengembalikan ke tipe sebelumnya jika rollback
        Schema::table('master_bdng_member', function (Blueprint $table) {
            $table->unsignedInteger('id_bdng')->change();
        });
    }
};
