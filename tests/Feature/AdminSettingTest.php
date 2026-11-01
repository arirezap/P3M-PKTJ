<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSettingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_admin_can_view_settings_page(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get(route('admin.settings.profile'));

        $response->assertStatus(200);
        $response->assertSee('Pengaturan Beranda & Video Profil');
        $response->assertSee('Tautan Video YouTube');
        $response->assertSee('Judul Video Profil');
    }

    public function test_admin_can_update_video_and_profile_settings(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->put(route('admin.settings.profile.update'), [
            'video_profile_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'video_profile_title' => 'Video Riset Inovasi PKTJ Terbaru 2026',
            'video_profile_desc' => 'Dokumentasi riset keselamatan terapan oleh civitas akademika PKTJ.',
            'video_profile_active' => '1',
            'about_lead' => 'Narasi baru pengantar unit P3M PKTJ.',
            'about_vision_mission' => 'Visi baru riset keselamatan jalan vokasi.',
            'facility_1_title' => 'Lab Riset Baru',
            'facility_1_desc' => 'Deskripsi fasilitas baru.',
        ]);

        $response->assertRedirect(route('admin.settings.profile'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('settings', [
            'key' => 'video_profile_title',
            'value' => 'Video Riset Inovasi PKTJ Terbaru 2026',
        ]);

        // Verifikasi homepage langsung menampilkan data baru
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('Video Riset Inovasi PKTJ Terbaru 2026');
        $homeResponse->assertSee('https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ', false);
        $homeResponse->assertSee('Narasi baru pengantar unit P3M PKTJ.');
    }

    public function test_dosen_cannot_access_settings_page(): void
    {
        $dosen = User::where('role', 'dosen')->first();

        $response = $this->actingAs($dosen)->get(route('admin.settings.profile'));

        $response->assertRedirect('/dosen/dashboard');
    }
}
