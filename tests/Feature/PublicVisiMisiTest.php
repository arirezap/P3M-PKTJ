<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicVisiMisiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_can_access_visi_misi_tujuan_page(): void
    {
        $response = $this->get(route('profil.visi-misi'));

        $response->assertStatus(200);
        $response->assertSeeText('Visi, Misi & Tujuan', false);
        $response->assertSee('Visi P3M Politeknik Keselamatan Transportasi Jalan');
        $response->assertSeeText('5 Butir Misi Utama P3M PKTJ', false);
        $response->assertSeeText('Tujuan Strategis & Sasaran Mutu', false);
        $response->assertSee('Reduksi Fatalitas Kecelakaan');
        $response->assertSee('Kemandirian Riset Vokasi');
        $response->assertSee('Menyelenggarakan penelitian terapan yang inovatif');
    }

    public function test_admin_can_access_visi_misi_settings_page(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get(route('admin.settings.visi-misi'));

        $response->assertStatus(200);
        $response->assertSeeText('Pengaturan Visi, Misi & Tujuan', false);
        $response->assertSee('Pernyataan Visi P3M');
        $response->assertSee('Butir Misi Kelembagaan');
        $response->assertSeeText('Tujuan Strategis & Sasaran Mutu', false);
    }

    public function test_dosen_cannot_access_visi_misi_settings_page(): void
    {
        $dosen = User::where('role', 'dosen')->first();

        $response = $this->actingAs($dosen)->get(route('admin.settings.visi-misi'));
        $response->assertRedirect('/dosen/dashboard');
    }

    public function test_guest_cannot_access_visi_misi_settings_page(): void
    {
        $response = $this->get(route('admin.settings.visi-misi'));
        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_update_visi_misi_settings_via_cms(): void
    {
        $admin = User::where('role', 'admin')->first();

        $updateResponse = $this->actingAs($admin)->put(route('admin.settings.visi-misi.update'), [
            'visi_badge' => 'Arah Haluan Riset & Pengabdian PKTJ 2026 - 2031',
            'page_title' => 'Visi, Misi & Tujuan P3M Kustom',
            'page_lead' => 'Landasan strategis pelaksanaan riset terapan dan pengabdian vokasi kustom.',
            'visi_title' => 'Visi Unggulan Riset Vokasi Keselamatan Transportasi 2031',
            'visi_statement' => 'Menjadi pusat rujukan keselamatan transportasi jalan berstandar internasional dan berintegritas tinggi.',
            'visi_subtext' => 'Komitmen institusional riset terapan berkelanjutan.',
            'misi_1' => 'Menyelenggarakan penelitian terapan berstandar global pada moda transportasi darat.',
            'misi_2' => 'Melaksanakan pengabdian kepada masyarakat berbasis pemberdayaan warga.',
            'misi_3' => 'Memperluas jejaring kemitraan dengan industri otomotif dan regulator.',
            'misi_4' => 'Mendorong percepatan perolehan paten dan publikasi jurnal terakreditasi.',
            'misi_5' => 'Mengembangkan tata kelola riset terintegrasi digital.',
            'tujuan_lead' => 'Sasaran mutu terukur pencapaian visi institusi.',
            'tujuan_1_title' => 'Publikasi Internasional Bereputasi',
            'tujuan_1_desc' => 'Peningkatan publikasi terindeks Scopus dan SINTA 2.',
            'tujuan_2_title' => 'Paten & Desain Industri Vokasi',
            'tujuan_2_desc' => 'Peningkatan perolehan paten aplikatif bidang keselamatan transportasi.',
            'tujuan_3_title' => 'Implementasi Mitra Strategis',
            'tujuan_3_desc' => 'Penerapan hasil kajian pada dinas perhubungan dan BUMN transportasi.',
            'tujuan_4_title' => 'Kemandirian Tata Kelola Riset',
            'tujuan_4_desc' => 'Sistem informasi terintegrasi dan akuntabilitas anggaran riset.',
        ]);

        $updateResponse->assertRedirect(route('admin.settings.visi-misi'));
        $updateResponse->assertSessionHas('success');

        $this->assertDatabaseHas('settings', [
            'key' => 'visi_title',
            'value' => 'Visi Unggulan Riset Vokasi Keselamatan Transportasi 2031',
        ]);

        $this->assertDatabaseHas('settings', [
            'key' => 'page_title',
            'value' => 'Visi, Misi & Tujuan P3M Kustom',
        ]);

        $this->assertDatabaseHas('settings', [
            'key' => 'visi_statement',
            'value' => 'Menjadi pusat rujukan keselamatan transportasi jalan berstandar internasional dan berintegritas tinggi.',
        ]);

        // Verifikasi halaman publik langsung memuat data yang diperbarui via CMS
        $publicResponse = $this->get(route('profil.visi-misi'));
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('Visi, Misi & Tujuan P3M Kustom');
        $publicResponse->assertSee('Visi Unggulan Riset Vokasi Keselamatan Transportasi 2031');
        $publicResponse->assertSee('Menjadi pusat rujukan keselamatan transportasi jalan berstandar internasional dan berintegritas tinggi.');
        $publicResponse->assertSee('Publikasi Internasional Bereputasi');
    }

    public function test_admin_can_dynamically_add_and_remove_misi_and_tujuan_items(): void
    {
        $admin = User::where('role', 'admin')->first();

        // Admin menyimpan 6 butir misi (bertambah) dan 2 butir tujuan (berkurang)
        $updateResponse = $this->actingAs($admin)->put(route('admin.settings.visi-misi.update'), [
            'page_title' => 'Visi, Misi & Tujuan Fleksibel',
            'page_lead' => 'Deskripsi dinamis',
            'visi_title' => 'Visi Baru',
            'visi_statement' => 'Pernyataan visi baru',
            'misi_items' => [
                'Misi Satu: Keselamatan Transportasi',
                'Misi Dua: Pengabdian Komunitas',
                'Misi Tiga: Jejaring Industri',
                'Misi Empat: Paten dan Jurnal',
                'Misi Lima: Sistem Informasi',
                'Misi Enam Baru: Internasionalisasi Riset Terapan',
            ],
            'tujuan_items' => [
                [
                    'title' => 'Sasaran Mutu Pertama',
                    'desc' => 'Uraian target sasaran mutu pertama',
                ],
                [
                    'title' => 'Sasaran Mutu Kedua',
                    'desc' => 'Uraian target sasaran mutu kedua',
                ],
            ],
        ]);

        $updateResponse->assertRedirect(route('admin.settings.visi-misi'));
        $updateResponse->assertSessionHas('success');

        // Verifikasi pada halaman publik
        $publicResponse = $this->get(route('profil.visi-misi'));
        $publicResponse->assertStatus(200);
        $publicResponse->assertSeeText('6 Butir Misi Utama P3M PKTJ', false);
        $publicResponse->assertSee('Misi Enam Baru: Internasionalisasi Riset Terapan');
        $publicResponse->assertSee('Sasaran Mutu Pertama');
        $publicResponse->assertSee('Sasaran Mutu Kedua');
        $publicResponse->assertSee('Sasaran 2');
        $publicResponse->assertDontSee('Sasaran 3');
    }

    public function test_admin_cannot_save_empty_misi_or_tujuan_items(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->put(route('admin.settings.visi-misi.update'), [
            'page_title' => 'Visi Misi Uji',
            'page_lead' => 'Deskripsi Uji',
            'visi_title' => 'Visi Uji',
            'visi_statement' => 'Pernyataan Visi Uji',
            'misi_items' => [],
            'tujuan_items' => [],
        ]);

        $response->assertSessionHasErrors(['misi_items', 'tujuan_items']);
    }
}
