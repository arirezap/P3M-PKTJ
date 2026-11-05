<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
            'hero_badge' => 'Pusat Riset Unggulan Keselamatan Jalan',
            'hero_title' => 'Inovasi Riset Berkelanjutan Transportasi Vokasi',
            'about_title' => 'Profil Lengkap Lembaga P3M PKTJ',
            'about_lead' => 'Narasi baru pengantar unit P3M PKTJ.',
            'about_vision_mission' => 'Visi baru riset keselamatan jalan vokasi.',
            'video_profile_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'video_profile_title' => 'Video Riset Inovasi PKTJ Terbaru 2026',
            'video_profile_desc' => 'Dokumentasi riset keselamatan terapan oleh civitas akademika PKTJ.',
            'video_profile_active' => '1',
            'news_badge' => 'Kabar & Diseminasi Terbaru',
            'news_title' => 'Warta Terkini Civitas Akademika PKTJ',
            'news_desc' => 'Informasi terhangat seputar hibah dan publikasi ilmiah.',
        ]);

        $response->assertRedirect(route('admin.settings.profile'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('settings', [
            'key' => 'hero_title',
            'value' => 'Inovasi Riset Berkelanjutan Transportasi Vokasi',
        ]);

        $this->assertDatabaseHas('settings', [
            'key' => 'about_title',
            'value' => 'Profil Lengkap Lembaga P3M PKTJ',
        ]);

        $this->assertDatabaseHas('settings', [
            'key' => 'video_profile_title',
            'value' => 'Video Riset Inovasi PKTJ Terbaru 2026',
        ]);

        // Verifikasi homepage langsung menampilkan seluruh data baru dari CMS
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('Pusat Riset Unggulan Keselamatan Jalan');
        $homeResponse->assertSee('Inovasi Riset Berkelanjutan Transportasi Vokasi');
        $homeResponse->assertSee('Profil Lengkap Lembaga P3M PKTJ');
        $homeResponse->assertSee('Narasi baru pengantar unit P3M PKTJ.');
        $homeResponse->assertSee('Video Riset Inovasi PKTJ Terbaru 2026');
        $homeResponse->assertSee('https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ', false);
        $homeResponse->assertSee('Kabar & Diseminasi Terbaru');
        $homeResponse->assertSee('Warta Terkini Civitas Akademika PKTJ');
    }

    public function test_dosen_cannot_access_settings_page(): void
    {
        $dosen = User::where('role', 'dosen')->first();

        $response = $this->actingAs($dosen)->get(route('admin.settings.profile'));

        $response->assertRedirect('/dosen/dashboard');
    }

    public function test_admin_can_view_header_footer_settings_page(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get(route('admin.settings.header-footer'));

        $response->assertStatus(200);
        $response->assertSee('Pengaturan Header Menu & Footer', false);
        $response->assertSee('Bilah Atas & Identitas Lembaga', false);
        $response->assertSee('Label Menu Navigasi & Tombol Masuk', false);
        $response->assertSee('Profil Lembaga & Kontak Pelayanan Dinas', false);
        $response->assertSee('Tautan Terkait Eksternal & Hak Cipta', false);
    }

    public function test_admin_can_update_header_footer_settings_and_reflect_on_public_portal(): void
    {
        $admin = User::where('role', 'admin')->first();

        $payload = [
            'top_bar_kemenhub' => 'Kementerian Perhubungan RI Kustom',
            'top_bar_bpsdm' => 'BPSDM Perhubungan Kustom',
            'top_bar_campus_info' => 'Kampus PKTJ Tegal: Kampus I & Kampus II',
            'top_bar_tagline' => 'Pusat Keunggulan Transportasi Vokasi',
            'brand_title' => 'P3M PKTJ Unggul',
            'brand_subtitle_1' => 'Pusat Riset Terapan Transportasi',
            'brand_subtitle_2' => 'Politeknik Keselamatan Transportasi Jalan Tegal',
            'menu_beranda_label' => 'Home Utama',
            'menu_profil_label' => 'Profil Unit',
            'menu_riset_label' => 'Riset Vokasi',
            'menu_pengabdian_label' => 'PkM Vokasi',
            'menu_layanan_label' => 'Layanan Publik',
            'navbar_jurnal_label' => 'Portal Jurnal KTJ',
            'navbar_jurnal_url' => 'https://ktj.pktj.ac.id/index.php/ktj',
            'navbar_custom_link_label' => 'Portal BPSDMP',
            'navbar_custom_link_url' => 'https://bpsdm.dephub.go.id',
            'navbar_login_button' => 'Masuk Portal SIM',
            'footer_brand_title' => 'P3M PKTJ Tegal',
            'footer_brand_subtitle' => 'Politeknik Keselamatan Transportasi Jalan',
            'footer_about_text' => 'Unit pengelola riset keselamatan transportasi darat dan inovasi vokasi terdepan di Indonesia.',
            'footer_address' => 'Jl. Semeru No. 3 Tegal Jawa Tengah 52125 Gedung A Lt. 2',
            'footer_email' => 'layanan.p3m@pktj.ac.id',
            'footer_phone' => '(0283) 351508 / 0811-2233-4455',
            'footer_nav_title' => 'Menu Utama Portal',
            'footer_links_title' => 'Pranala Luar Lembaga',
            'footer_link_1_label' => 'Web Utama PKTJ',
            'footer_link_1_url' => 'https://pktj.ac.id',
            'footer_link_2_label' => 'Kementerian Perhubungan RI',
            'footer_link_2_url' => 'https://dephub.go.id',
            'footer_link_3_label' => 'Jurnal Ilmiah Terindeks',
            'footer_link_3_url' => 'https://ktj.pktj.ac.id/',
            'footer_link_4_label' => 'SINTA Kemdiktisaintek',
            'footer_link_4_url' => 'https://sinta.kemdikbud.go.id',
            'footer_link_5_label' => 'Mitra Industri Transportasi',
            'footer_link_5_url' => 'https://mitra.pktj.ac.id',
            'footer_copyright_text' => '© {Y} P3M PKTJ Tegal. Hak Cipta Dilindungi Undang-Undang.',
            'footer_copyright_sub' => 'Badan Pengembangan SDM Perhubungan',
        ];

        $response = $this->actingAs($admin)->put(route('admin.settings.header-footer.update'), $payload);

        $response->assertRedirect(route('admin.settings.header-footer'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('settings', [
            'key' => 'top_bar_kemenhub',
            'value' => 'Kementerian Perhubungan RI Kustom',
        ]);
        $this->assertDatabaseHas('settings', [
            'key' => 'brand_title',
            'value' => 'P3M PKTJ Unggul',
        ]);
        $this->assertDatabaseHas('settings', [
            'key' => 'footer_email',
            'value' => 'layanan.p3m@pktj.ac.id',
        ]);

        // Verifikasi halaman publik tamu langsung memuat data kustom navbar & footer
        $this->post(route('logout'));

        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('Kementerian Perhubungan RI Kustom');
        $homeResponse->assertSee('Pusat Keunggulan Transportasi Vokasi');
        $homeResponse->assertSee('P3M PKTJ Unggul');
        $homeResponse->assertSee('Home Utama');
        $homeResponse->assertSee('Profil Unit');
        $homeResponse->assertSee('Riset Vokasi');
        $homeResponse->assertSee('PkM Vokasi');
        $homeResponse->assertSee('Layanan Publik');
        $homeResponse->assertSee('Portal Jurnal KTJ');
        $homeResponse->assertSee('Portal BPSDMP');
        $homeResponse->assertSee('Masuk Portal SIM');
        $homeResponse->assertSee('layanan.p3m@pktj.ac.id');
        $homeResponse->assertSee('Pranala Luar Lembaga');
        $homeResponse->assertSee('Mitra Industri Transportasi');
        $homeResponse->assertSee('Badan Pengembangan SDM Perhubungan');
    }

    public function test_non_admin_cannot_access_header_footer_settings(): void
    {
        $dosen = User::where('role', 'dosen')->first();

        $response = $this->actingAs($dosen)->get(route('admin.settings.header-footer'));

        $response->assertRedirect('/dosen/dashboard');
    }

    public function test_admin_can_view_renstra_settings_page(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get(route('admin.settings.renstra'));

        $response->assertStatus(200);
        $response->assertSee('Pengaturan Rencana Strategis');
        $response->assertSee('Berkas Dokumen Renstra Penelitian 2026-2031');
        $response->assertSee('Berkas Dokumen Renstra Pengabdian kepada Masyarakat');
    }

    public function test_admin_can_update_renstra_settings_and_upload_pdf(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $pdfPenelitian = UploadedFile::fake()->create('renstra_penelitian_baru.pdf', 1024, 'application/pdf');
        $pdfPengabdian = UploadedFile::fake()->create('renstra_pengabdian_baru.pdf', 1024, 'application/pdf');

        $response = $this->actingAs($admin)->put(route('admin.settings.renstra.update'), [
            'renstra_badge' => 'Kebijakan Riset & PKM PKTJ 2026-2031',
            'renstra_title' => 'Rencana Strategis Mandiri Berkelanjutan',
            'renstra_lead' => 'Dokumen panduan arah kebijakan riset dan pengabdian terpadu.',
            'renstra_custom_html' => '<div class="alert-info">Maklumat Rencana Strategis PKTJ Terpadu</div>',
            'file_renstra_penelitian' => $pdfPenelitian,
            'file_renstra_pengabdian' => $pdfPengabdian,
        ]);

        $response->assertRedirect(route('admin.settings.renstra'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('settings', [
            'key' => 'renstra_title',
            'value' => 'Rencana Strategis Mandiri Berkelanjutan',
        ]);

        // Verifikasi halaman publik langsung memuat judul dan HTML kustom dari CMS
        $publicResponse = $this->get(route('profil.rencana-strategis'));
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('Kebijakan Riset & PKM PKTJ 2026-2031');
        $publicResponse->assertSee('Rencana Strategis Mandiri Berkelanjutan');
        $publicResponse->assertSee('Dokumen panduan arah kebijakan riset dan pengabdian terpadu.');
        $publicResponse->assertSee('Maklumat Rencana Strategis PKTJ Terpadu', false);
    }

    public function test_non_admin_cannot_access_renstra_settings(): void
    {
        $dosen = User::where('role', 'dosen')->first();

        $response = $this->actingAs($dosen)->get(route('admin.settings.renstra'));

        $response->assertRedirect('/dosen/dashboard');
    }

    public function test_admin_can_view_roadmap_settings_page(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get(route('admin.settings.roadmap'));

        $response->assertStatus(200);
        $response->assertSee('Pengaturan Roadmap Penelitian');
        $response->assertSee('Berkas Dokumen Roadmap Penelitian');
    }

    public function test_admin_can_update_roadmap_settings_and_upload_pdf(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $pdfRoadmap = UploadedFile::fake()->create('roadmap_baru.pdf', 1024, 'application/pdf');

        $response = $this->actingAs($admin)->put(route('admin.settings.roadmap.update'), [
            'roadmap_badge' => 'Peta Jalan Riset Unggulan PKTJ',
            'roadmap_title' => 'Roadmap Riset Keselamatan Jalan 2026-2031',
            'roadmap_lead' => 'Haluan riset terpadu sivitas akademika PKTJ.',
            'roadmap_custom_html' => '<div class="alert-info">Maklumat Roadmap Riset PKTJ</div>',
            'file_roadmap' => $pdfRoadmap,
        ]);

        $response->assertRedirect(route('admin.settings.roadmap'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('settings', [
            'key' => 'roadmap_title',
            'value' => 'Roadmap Riset Keselamatan Jalan 2026-2031',
        ]);

        // Verifikasi halaman publik langsung memuat judul dan HTML kustom dari CMS
        $publicResponse = $this->get(route('profil.roadmap-penelitian'));
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('Peta Jalan Riset Unggulan PKTJ');
        $publicResponse->assertSee('Roadmap Riset Keselamatan Jalan 2026-2031');
        $publicResponse->assertSee('Haluan riset terpadu sivitas akademika PKTJ.');
        $publicResponse->assertSee('Maklumat Roadmap Riset PKTJ', false);
    }

    public function test_non_admin_cannot_access_roadmap_settings(): void
    {
        $dosen = User::where('role', 'dosen')->first();

        $response = $this->actingAs($dosen)->get(route('admin.settings.roadmap'));

        $response->assertRedirect('/dosen/dashboard');
    }
}
