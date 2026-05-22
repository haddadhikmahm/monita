<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create standard test users
        $this->admin = User::create([
            'id' => 'AD_TEST',
            'name' => 'Test Admin',
            'username' => 'admin_test',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->petugas = User::create([
            'id' => 'PT_TEST',
            'name' => 'Test Petugas',
            'username' => 'petugas_test',
            'password' => bcrypt('password'),
            'role' => 'petugas',
        ]);

        $this->pimpinan = User::create([
            'id' => 'PM_TEST',
            'name' => 'Test Pimpinan',
            'username' => 'pimpinan_test',
            'password' => bcrypt('password'),
            'role' => 'pimpinan',
        ]);
    }

    /** @test */
    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/dashboard')->assertRedirect(route('login'));
        $this->get('/master-data')->assertRedirect(route('login'));
    }

    /** @test */
    public function test_pimpinan_can_view_dashboard_but_cannot_perform_write_actions(): void
    {
        $this->actingAs($this->pimpinan);

        // Can view read-only pages
        $this->get('/dashboard')->assertStatus(200);
        $this->get('/master-data')->assertStatus(200);
        $this->get('/maintenance')->assertStatus(200);
        $this->get('/inspeksi')->assertStatus(200);

        // Cannot view admin resources
        $this->get('/user')->assertStatus(403);
        $this->get('/lokasi')->assertStatus(403);
        $this->get('/kategori')->assertStatus(403);

        // Cannot perform master data write actions
        $this->get('/master-data/create')->assertStatus(403);
        $this->post('/master-data', [])->assertStatus(403);
        $this->get('/master-data/KD123/edit')->assertStatus(403);
        $this->put('/master-data/KD123', [])->assertStatus(403);
        $this->delete('/master-data/KD123')->assertStatus(403);

        // Cannot perform inspection write actions
        $this->post(route('inspeksi.start'), [])->assertStatus(403);
        $this->get(route('inspeksi.category', ['kategori_id' => 'KT001']))->assertStatus(403);
        $this->post(route('inspeksi.save_category', ['kategori_id' => 'KT001']), [])->assertStatus(403);
        $this->post(route('inspeksi.finish'), [])->assertStatus(403);

        // Cannot perform maintenance repair actions
        $this->post('/maintenance/1/repair', [])->assertStatus(403);
    }

    /** @test */
    public function test_petugas_can_perform_operational_actions_but_cannot_access_admin_resources(): void
    {
        $this->actingAs($this->petugas);

        // Can view read-only pages
        $this->get('/dashboard')->assertStatus(200);
        $this->get('/master-data')->assertStatus(200);
        $this->get('/maintenance')->assertStatus(200);
        $this->get('/inspeksi')->assertStatus(200);

        // Cannot view admin resources
        $this->get('/user')->assertStatus(403);
        $this->get('/lokasi')->assertStatus(403);
        $this->get('/kategori')->assertStatus(403);

        // Cannot perform master data write actions
        $this->get('/master-data/create')->assertStatus(403);
        $this->post('/master-data', [])->assertStatus(403);
        $this->get('/master-data/KD123/edit')->assertStatus(403);
        $this->put('/master-data/KD123', [])->assertStatus(403);
        $this->delete('/master-data/KD123')->assertStatus(403);
    }

    /** @test */
    public function test_admin_can_access_all_resources_and_actions(): void
    {
        $this->actingAs($this->admin);

        $this->get('/dashboard')->assertStatus(200);
        $this->get('/user')->assertStatus(200);
        $this->get('/lokasi')->assertStatus(200);
        $this->get('/kategori')->assertStatus(200);
        $this->get('/master-data/create')->assertStatus(200);
    }
}
