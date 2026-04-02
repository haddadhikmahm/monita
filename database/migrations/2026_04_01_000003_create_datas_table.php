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
        Schema::create('datas', function (Blueprint $table) {
            $table->string('id')->primary(); // Legacy ID (KDxxx)
            $table->string('nama');
            $table->string('kategori_id');
            $table->string('lokasi_id');
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('kat_data_inspeksis')->onDelete('cascade');
            $table->foreign('lokasi_id')->references('id')->on('lokasi_inspeksis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datas');
    }
};
