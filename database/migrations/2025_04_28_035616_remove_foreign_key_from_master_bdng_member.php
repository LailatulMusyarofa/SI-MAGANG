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
        // Menghapus foreign key constraint pada kolom id_bdng
        Schema::table('master_bdng_member', function (Blueprint $table) {
            // Ganti 'master_bdng_member_id_bdng_foreign' dengan nama constraint yang benar jika berbeda
            $table->dropForeign('master_bdng_member_id_bdng_foreign');
        });
    }


    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menambahkan kembali foreign key jika rollback
        Schema::table('master_bdng_member', function (Blueprint $table) {
            $table->foreign('id_bdng')->references('id')->on('master_bdng')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }
};
