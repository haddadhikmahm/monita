<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InspeksiDetailSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('inspeksi_datas')->insert([
            [
                'id' => 'DTI13150',
                'inspeksi_id' => 'IDI11387',
                'data_id' => 'KD99408637',
                'jumlah' => 1,
                'kondisi_struktur' => 'Baik',
                'foto' => 'IMG_20221123_060225_802.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'DTI17852',
                'inspeksi_id' => 'IDI11387',
                'data_id' => 'KD84303048',
                'jumlah' => 1,
                'kondisi_struktur' => 'Baik',
                'foto' => 'IMG_20221123_055401_688.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
