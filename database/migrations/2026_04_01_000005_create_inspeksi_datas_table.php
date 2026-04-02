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
        Schema::create('inspeksi_datas', function (Blueprint $table) {
            $table->string('id')->primary(); // Legacy ID (DTIxxx)
            $table->string('inspeksi_id');
            $table->string('data_id');
            $table->integer('jumlah')->default(0);
            $table->enum('kondisi_struktur', ['Baik', 'Sedang', 'Rusak'])->nullable();
            $table->enum('kondisi_permukaan', ['Bersih', 'Sedang', 'Kotor'])->nullable();
            $table->text('foto')->nullable();
            $table->string('upaya')->nullable();
            $table->string('tindak_lanjut')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('inspeksi_id')->references('id')->on('inspeksis')->onDelete('cascade');
            $table->foreign('data_id')->references('id')->on('datas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_datas');
    }
};
