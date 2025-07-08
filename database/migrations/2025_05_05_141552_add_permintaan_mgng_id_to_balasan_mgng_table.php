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
    Schema::table('balasan_mgng', function (Blueprint $table) {
        // Menambahkan kolom permintaan_mgng_id setelah master_mgng_id
        $table->unsignedBigInteger('permintaan_mgng_id')->nullable()->after('master_mgng_id');
        $table->foreign('permintaan_mgng_id')->references('id')->on('permintaan_mgng')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('balasan_mgng', function (Blueprint $table) {
        $table->dropForeign(['permintaan_mgng_id']);
        $table->dropColumn('permintaan_mgng_id');
    });
}

};
