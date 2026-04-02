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
        Schema::create('inspeksis', function (Blueprint $table) {
            $table->string('id')->primary(); // Legacy ID (IDIxxx)
            $table->string('hari');
            $table->date('tanggal');
            $table->enum('cuaca', ['Cerah', 'Mendung', 'Hujan'])->nullable();
            $table->enum('w1', ['Y', 'N'])->default('N');
            $table->enum('w2', ['Y', 'N'])->default('N');
            $table->string('lokasi_id');
            $table->string('petugas1_id');
            $table->string('petugas2_id')->nullable();
            $table->string('petugas3_id')->nullable();
            $table->string('petugas4_id')->nullable();
            $table->timestamps();

            $table->foreign('lokasi_id')->references('id')->on('lokasi_inspeksis')->onDelete('cascade');
            $table->foreign('petugas1_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('petugas2_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('petugas3_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('petugas4_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksis');
    }
};
