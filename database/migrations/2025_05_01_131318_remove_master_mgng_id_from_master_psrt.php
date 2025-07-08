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
    // Menghapus foreign key constraint yang mengarah ke master_mgng_id
    Schema::table('master_psrt', function (Blueprint $table) {
        // Pastikan untuk mengganti 'master_psrt_master_mgng_id_foreign' dengan nama foreign key yang sesuai
        $table->dropForeign(['master_mgng_id']);
        $table->dropColumn('master_mgng_id'); // Hapus kolom master_mgng_id
    });
}

public function down()
{
    // Menambahkan kembali kolom master_mgng_id jika rollback
    Schema::table('master_psrt', function (Blueprint $table) {
        $table->unsignedBigInteger('master_mgng_id')->nullable();  // Menambahkan kolom kembali jika rollback
    });
}
};
