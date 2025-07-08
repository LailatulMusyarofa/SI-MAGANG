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
        // Menambahkan kembali foreign key constraint pada kolom id_bdng di master_bdng_member
        Schema::table('master_bdng_member', function (Blueprint $table) {
            // Menambahkan kembali foreign key pada kolom id_bdng yang mengarah ke id master_bdng
            $table->foreign('id_bdng')->references('id')->on('master_bdng')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus foreign key jika rollback
        Schema::table('master_bdng_member', function (Blueprint $table) {
            $table->dropForeign('master_bdng_member_id_bdng_foreign');
        });
    }
};
