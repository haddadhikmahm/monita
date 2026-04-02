<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        DB::table('users')->insert([
            [
                'id' => 'AD89274124',
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('admin123'), // Default temporary password
                'role' => 'admin',
                'ft' => 'ATNEW.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Petugas (Sample from SQL)
        DB::table('users')->insert([
            [
                'id' => 'NIP1384',
                'name' => 'Agus Prastyawan',
                'username' => 'wawanarza',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas',
                'jekel' => 'Laki-laki',
                'alm' => 'Pelita',
                'telp' => '081254296088',
                'tgl_lahir' => '1985-08-16',
                'ft' => 'user.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'NIP1573',
                'name' => 'Wiyadi Iwo Turwibowo',
                'username' => 'iwo',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas',
                'jekel' => 'Laki-laki',
                'alm' => 'Perum BK',
                'telp' => '123456',
                'tgl_lahir' => '1973-05-12',
                'ft' => 'user.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Pimpinan
        DB::table('users')->insert([
            [
                'id' => 'NIP7745',
                'name' => 'Herman Prayitno',
                'username' => 'hermanpray',
                'password' => Hash::make('pimpinan123'),
                'role' => 'pimpinan',
                'jekel' => 'Laki-laki',
                'alm' => 'Rumdin',
                'telp' => '028124848615',
                'tgl_lahir' => '1976-09-02',
                'ft' => 'user.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
