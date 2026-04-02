<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kat_data_inspeksis')->insert([
            ['id' => 'KT001', 'nama' => 'IT SUPPORT', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KT002', 'nama' => 'AAS', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KT003', 'nama' => 'ACCESS DOOR', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KT004', 'nama' => 'BAS', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KT005', 'nama' => 'PAS', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KT006', 'nama' => 'SECURITY EQUIPMENT', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KT007', 'nama' => 'FIDS UFIS', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KT008', 'nama' => 'FIRE ALARM', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KT009', 'nama' => 'JARINGAN DATA', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KT010', 'nama' => 'BHS', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KT011', 'nama' => 'HBS', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KT013', 'nama' => 'MASTER CLOCK', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KT014', 'nama' => 'GROUND COMMUNICATION', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KT015', 'nama' => 'CCTV', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KT016', 'nama' => 'SERVER ADMIN', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KT017', 'nama' => 'WIFI ADMIN', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KT018', 'nama' => 'SECURITY EQUIPMENT L3', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
