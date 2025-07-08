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
        Schema::table('master_bdng', function (Blueprint $table) {
            // Mengubah kolom 'id' menjadi 'BIGINT UNSIGNED' agar sesuai dengan $table->id()
            $table->unsignedBigInteger('id', true)->change(); // Mengubah tipe menjadi BIGINT UNSIGNED
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Mengembalikan ke tipe sebelumnya (jika rollback)
        Schema::table('master_bdng', function (Blueprint $table) {
            $table->increments('id')->change();
        });
    }
};
