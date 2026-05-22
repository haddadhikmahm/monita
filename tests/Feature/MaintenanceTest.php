<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\LokasiInspeksi;
use App\Models\KategoriInspeksi;
use App\Models\MasterData;
use App\Models\Inspeksi;
use App\Models\InspeksiDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaintenanceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'id' => 'USR001',
            'name' => 'Petugas Satu',
            'username' => 'petugas1',
            'password' => bcrypt('password'),
            'role' => 'petugas',
        ]);

        $this->lokasi = LokasiInspeksi::create([
            'id' => 'LK001',
            'nama' => 'Terminal 1',
        ]);

        $this->kategori = KategoriInspeksi::create([
            'id' => 'KT001',
            'nama' => 'Fasilitas Utama',
        ]);

        $this->master = MasterData::create([
            'id' => 'MD001',
            'nama' => 'Monitor LCD 19 inch',
            'kategori_id' => 'KT001',
            'lokasi_id' => 'LK001',
        ]);

        $this->inspeksi = Inspeksi::create([
            'id' => 'INSP001',
            'hari' => 'Senin',
            'tanggal' => now(),
            'cuaca' => 'Cerah',
            'lokasi_id' => 'LK001',
            'petugas1_id' => 'USR001',
        ]);

        $this->detail = InspeksiDetail::create([
            'id' => 'DTI001',
            'inspeksi_id' => 'INSP001',
            'data_id' => 'MD001',
            'jumlah' => 1,
            'kondisi_struktur' => 'Rusak',
            'kondisi_permukaan' => 'Kotor',
            'keterangan' => 'Monitor blank',
            'is_repaired' => false,
        ]);
    }

    /** @test */
    public function test_a_petugas_can_view_maintenance_items()
    {
        $response = $this->actingAs($this->user)->get('/maintenance');
        $response->assertStatus(200);
        $response->assertSee('Monitor LCD 19 inch');
    }

    /** @test */
    public function test_a_petugas_can_log_a_repair()
    {
        $response = $this->actingAs($this->user)->post("/maintenance/DTI001/repair", [
            'kondisi_perbaikan' => 'Baik',
            'keterangan_perbaikan' => 'Kabel diganti baru',
            'tgl_perbaikan' => '2026-05-22T12:00',
        ]);

        $response->assertRedirect('/maintenance');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('inspeksi_datas', [
            'id' => 'DTI001',
            'is_repaired' => true,
            'kondisi_perbaikan' => 'Baik',
            'keterangan_perbaikan' => 'Kabel diganti baru',
        ]);
    }
}
