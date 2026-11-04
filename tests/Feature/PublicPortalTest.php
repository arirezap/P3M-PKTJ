<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\Post;
use App\Models\Prodi;
use App\Models\Research;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPortalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_landing_page_renders_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('P3M PKTJ');
        $response->assertSee('Riset Unggulan & Pengabdian Berbasis', false);
    }

    public function test_landing_page_displays_official_three_prodis(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('D4 RSTJ');
        $response->assertSee('D4 TRO');
        $response->assertSee('D3 TO');
    }

    public function test_landing_page_displays_dynamic_posts_and_announcements(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        // Cek pengumuman dari seeder
        $response->assertSee('Sosialisasi Panduan Call for Proposals');
        // Cek berita dari seeder
        $response->assertSee('Diseminasi Hasil Riset Prototipe Sensor Blind Spot');
    }

    public function test_homepage_fulfills_stakeholder_requirements_tentang_p3m_video_profil_berita_terkini(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        // 1. Tampilan Tentang P3M PKTJ
        $response->assertSee('Tentang Pusat Penelitian dan Pengabdian kepada Masyarakat');
        $response->assertSee('D4 RSTJ');
        $response->assertSee('D4 TRO');
        $response->assertSee('D3 TO');

        // 2. Tampilan Video Profil P3M PKTJ
        $response->assertSee('Video Profil P3M PKTJ Tegal');
        $response->assertSee('https://www.youtube-nocookie.com/embed/5F_fNlPGBdQ', false);

        // 3. Tampilan Berita Terkini & Agenda
        $response->assertSee('Berita Terkini dan Agenda P3M PKTJ');
        $response->assertSee('Publikasi Berita Terkini');

        // 4. Tautan Jurnal Terhubung ke https://ktj.pktj.ac.id/
        $response->assertSee('https://ktj.pktj.ac.id/', false);
    }

    public function test_navbar_and_footer_display_login_for_guests(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee(route('login'));
        $response->assertDontSee('Masuk ke SIM P3M PKTJ');
        $response->assertDontSee('Masuk SIM P3M');
    }

    public function test_navbar_and_footer_display_dashboard_and_logout_for_authenticated_admin(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/');

        $response->assertStatus(200);
        $response->assertSee('Panel Admin');
        $response->assertSee(route('admin.dashboard'));
        $response->assertSee('Keluar');
        $response->assertSee('Buka Panel Admin SIM P3M');
    }

    public function test_navbar_and_footer_display_dashboard_and_logout_for_authenticated_dosen(): void
    {
        $dosen = User::where('role', 'dosen')->first();

        $response = $this->actingAs($dosen)->get('/');

        $response->assertStatus(200);
        $response->assertSee('Portal Dosen');
        $response->assertSee(route('dosen.dashboard'));
        $response->assertSee('Keluar');
        $response->assertSee('Buka Portal Dosen SIM');
    }

    public function test_navbar_and_footer_display_dashboard_and_logout_for_authenticated_reviewer(): void
    {
        $reviewer = User::where('role', 'reviewer')->first();

        $response = $this->actingAs($reviewer)->get('/');

        $response->assertStatus(200);
        $response->assertSee('Portal Reviewer');
        $response->assertSee(route('reviewer.dashboard'));
        $response->assertSee('Keluar');
        $response->assertSee('Buka Portal Reviewer SIM');
    }
}
