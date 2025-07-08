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
        Schema::table('master_psrt', function (Blueprint $table) {
            $table->unsignedBigInteger('permintaan_mgng_id')->after('id');
            $table->foreign('permintaan_mgng_id')->references('id')->on('permintaan_mgng')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('master_psrt', function (Blueprint $table) {
            $table->dropForeign(['permintaan_mgng_id']);
            $table->dropColumn('permintaan_mgng_id');
        });
    }
};
