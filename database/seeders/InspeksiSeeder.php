<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InspeksiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('inspeksis')->insert([
            [
                'id' => 'IDI11387',
                'hari' => 'Rabu',
                'tanggal' => '2022-11-23',
                'cuaca' => 'Cerah',
                'w1' => 'Y',
                'w2' => 'N',
                'lokasi_id' => 'L001',
                'petugas1_id' => 'NIP1384',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'IDI12068',
                'hari' => 'Selasa',
                'tanggal' => '2022-11-22',
                'cuaca' => 'Cerah',
                'w1' => 'Y',
                'w2' => 'N',
                'lokasi_id' => 'L001',
                'petugas1_id' => 'NIP1573',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
