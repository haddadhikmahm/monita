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
        Schema::table('inspeksi_datas', function (Blueprint $table) {
            $table->boolean('is_repaired')->default(false);
            $table->dateTime('tgl_perbaikan')->nullable();
            $table->enum('kondisi_perbaikan', ['Baik', 'Tidak Baik'])->nullable();
            $table->string('foto_perbaikan')->nullable();
            $table->text('keterangan_perbaikan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inspeksi_datas', function (Blueprint $table) {
            $table->dropColumn([
                'is_repaired',
                'tgl_perbaikan',
                'kondisi_perbaikan',
                'foto_perbaikan',
                'keterangan_perbaikan'
            ]);
        });
    }
};
