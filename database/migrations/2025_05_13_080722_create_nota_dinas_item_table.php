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
        Schema::create('nota_dinas_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nota_dinas_id')->constrained('nota_dinas')->onDelete('cascade');
            $table->foreignId('master_psrt_id')->constrained('master_psrt')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_dinas_item');
    }
};
