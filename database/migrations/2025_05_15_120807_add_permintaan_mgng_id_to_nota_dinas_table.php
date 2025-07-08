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
        Schema::table('nota_dinas', function (Blueprint $table) {
            // Tambah kolom permintaan_mgng_id setelah master_mgng_id
            $table->foreignId('permintaan_mgng_id')->nullable()
                  ->after('master_mgng_id')
                  ->constrained('permintaan_mgng')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nota_dinas', function (Blueprint $table) {
            $table->dropForeign(['permintaan_mgng_id']);
            $table->dropColumn('permintaan_mgng_id');
        });
    }
};
