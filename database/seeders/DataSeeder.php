<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('datas')->insert([
            ['id' => 'KD11208767', 'nama' => 'CS Online Arrival', 'kategori_id' => 'KT001', 'lokasi_id' => 'L001', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KD11895073', 'nama' => 'X Ray SCP', 'kategori_id' => 'KT018', 'lokasi_id' => 'L002', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KD14865247', 'nama' => 'Indi Procurement', 'kategori_id' => 'KT017', 'lokasi_id' => 'L004', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KD18438042', 'nama' => 'Pintu Koridor Ground Non Avio Barat', 'kategori_id' => 'KT003', 'lokasi_id' => 'L001', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KD21975368', 'nama' => 'Router-BPN', 'kategori_id' => 'KT009', 'lokasi_id' => 'L003', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KD28526475', 'nama' => 'Gate 1-3', 'kategori_id' => 'KT003', 'lokasi_id' => 'L001', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KD48914930', 'nama' => 'Radio HT', 'kategori_id' => 'KT014', 'lokasi_id' => 'L006', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KD57755533', 'nama' => 'Distri-MZ_01 & 02', 'kategori_id' => 'KT009', 'lokasi_id' => 'L003', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KD64762369', 'nama' => 'WIFI Check In C', 'kategori_id' => 'KT001', 'lokasi_id' => 'L001', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KD99408637', 'nama' => 'Lift Check In Barat', 'kategori_id' => 'KT003', 'lokasi_id' => 'L001', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KD84303048', 'nama' => 'Peralatan Tambahan', 'kategori_id' => 'KT003', 'lokasi_id' => 'L001', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 'KD99775681', 'nama' => 'Server EPMS', 'kategori_id' => 'KT016', 'lokasi_id' => 'L004', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
