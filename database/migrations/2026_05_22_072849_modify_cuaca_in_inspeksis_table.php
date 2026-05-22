<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inspeksis', function (Blueprint $table) {
            $table->enum('cuaca', ['Cerah', 'Berawan', 'Mendung', 'Hujan'])->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('inspeksis', function (Blueprint $table) {
            $table->enum('cuaca', ['Cerah', 'Mendung', 'Hujan'])->nullable()->change();
        });
    }
};
