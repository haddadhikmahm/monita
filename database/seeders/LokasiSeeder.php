<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('lokasi_inspeksis')->insert([
            ['id' => 'L001', 'nama' => 'Gedung Terminal', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'L002', 'nama' => 'L3-APS', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'L003', 'nama' => 'Jardat-MT', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'L004', 'nama' => 'Gedung Admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'L005', 'nama' => 'Gedung Parkir', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'L006', 'nama' => 'Ground Communication-Jatimas', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
