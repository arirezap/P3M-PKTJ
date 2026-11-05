<?php

namespace Tests\Feature;

use App\Models\CommunityServiceOutput;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicCommunityServiceOutputPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_can_access_luaran_pkm_page(): void
    {
        $response = $this->get(route('pengabdian.luaran'));

        $response->assertStatus(200);
        $response->assertSee('Hasil Analisis Luaran Pengabdian', false);
        $response->assertSee('D4 RSTJ');
        $response->assertSee('D4 TRO');
        $response->assertSee('D3 TO');
        $response->assertSee('Total Luaran PkM');
        $response->assertSee('Kepuasan Mitra');
        $response->assertSee('Mitra & Desa Sasaran', false);
        $response->assertSee('TTG & Modul Terapan', false);
        $response->assertSee('Semua Luaran');
        $response->assertSee('Teknologi TTG');
        $response->assertSee('Dampak Desa Binaan');
    }

    public function test_filter_by_kategori_tab(): void
    {
        $response = $this->get(route('pengabdian.luaran', ['kategori' => 'ttg']));

        $response->assertStatus(200);
        $response->assertSee('Teknologi Tepat Guna');
    }

    public function test_real_2025_pkm_outputs_data_from_excel_is_seeded_without_duplicates(): void
    {
        $outputs2025 = CommunityServiceOutput::where('tahun', 2025)->get();
        $this->assertCount(33, $outputs2025);

        $uniqueTitles = $outputs2025->pluck('judul')->map(fn ($t) => strtolower(trim($t)))->unique();
        $this->assertCount(33, $uniqueTitles);
    }

    public function test_filter_by_prodi(): void
    {
        $troProdi = Prodi::where('kode_prodi', 'TRO')->first();
        $this->assertNotNull($troProdi);

        $response = $this->get(route('pengabdian.luaran', ['prodi' => 'TRO']));

        $response->assertStatus(200);
        $response->assertSee('D4 TRO');
    }

    public function test_filter_by_year(): void
    {
        $response = $this->get(route('pengabdian.luaran', ['tahun' => 2026]));

        $response->assertStatus(200);
        $response->assertSee('Tahun 2026');
    }

    public function test_keyword_search(): void
    {
        $output = CommunityServiceOutput::first();
        $this->assertNotNull($output);

        $firstWord = explode(' ', $output->judul)[0];

        $response = $this->get(route('pengabdian.luaran', ['search' => $firstWord]));

        $response->assertStatus(200);
        $response->assertSee($firstWord);
    }

    public function test_public_can_download_output_pdf(): void
    {
        Storage::fake('public');

        $prodi = Prodi::first();
        $filePath = 'community_services/outputs/test_dokumen_pkm.pdf';
        Storage::disk('public')->put($filePath, '%PDF-1.4 Fake Content');

        $output = CommunityServiceOutput::create([
            'judul' => 'Uji Coba Berkas Luaran PkM',
            'kategori' => 'ttg',
            'prodi_id' => $prodi->id,
            'pelaksana' => 'Penguji Coba, M.T.',
            'tahun' => 2026,
            'mitra_sasaran' => 'Mitra Bengkel Binaan',
            'lokasi' => 'Kota Tegal',
            'deskripsi_manfaat' => 'Pengujian unduhan berkas luaran pengabdian.',
            'indikator_keberhasilan' => 'Tingkat kepatuhan 90%',
            'tingkat_kepuasan_mitra' => '95% (Sangat Baik)',
            'berkas_luaran' => $filePath,
        ]);

        $response = $this->get(route('pengabdian.luaran.unduh', $output));

        $response->assertStatus(200);
        $this->assertStringContainsString('attachment', (string) $response->headers->get('content-disposition'));
    }

    public function test_admin_can_access_cms_outputs_index(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->assertNotNull($admin);

        $response = $this->actingAs($admin)->get(route('admin.community-service-outputs.index'));

        $response->assertStatus(200);
        $response->assertSee('Data Hasil Analisis Luaran Pengabdian (PkM)');
        $response->assertSee('+ Tambah Data Luaran');
        $response->assertSee('Impor Data CSV');
    }

    public function test_admin_can_create_community_service_output(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $prodi = Prodi::where('kode_prodi', 'RSTJ')->first();

        $pdfFile = UploadedFile::fake()->create('berkas_luaran_baru.pdf', 500, 'application/pdf');

        $response = $this->actingAs($admin)->post(route('admin.community-service-outputs.store'), [
            'judul' => 'Alat Deteksi Kecepatan Berbasis Sensor Arduino di Zona Selamat Sekolah',
            'kategori' => 'ttg',
            'prodi_id' => $prodi->id,
            'pelaksana' => 'Ir. Hartono, M.T.',
            'tahun' => 2026,
            'mitra_sasaran' => 'SD Negeri Kalinyamat Wetan Tegal',
            'lokasi' => 'Kota Tegal',
            'deskripsi_manfaat' => 'Sistem pemantau kecepatan pengendara di area penyeberangan anak sekolah.',
            'indikator_keberhasilan' => 'Penurunan kecepatan 35%',
            'tingkat_kepuasan_mitra' => '94% (Sangat Puas)',
            'berkas_luaran' => $pdfFile,
        ]);

        $response->assertRedirect(route('admin.community-service-outputs.index'));
        $this->assertDatabaseHas('community_service_outputs', [
            'judul' => 'Alat Deteksi Kecepatan Berbasis Sensor Arduino di Zona Selamat Sekolah',
            'kategori' => 'ttg',
            'mitra_sasaran' => 'SD Negeri Kalinyamat Wetan Tegal',
        ]);
    }

    public function test_admin_can_update_community_service_output(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $output = CommunityServiceOutput::first();

        $pdfFile = UploadedFile::fake()->create('revisi_luaran_pkm.pdf', 600, 'application/pdf');

        $response = $this->actingAs($admin)->put(route('admin.community-service-outputs.update', $output), [
            'judul' => 'Judul Luaran PkM Diperbarui',
            'kategori' => 'modul',
            'prodi_id' => $output->prodi_id,
            'pelaksana' => 'Pelaksana Update, M.Kom.',
            'tahun' => $output->tahun,
            'mitra_sasaran' => 'Dishub Kabupaten Brebes',
            'lokasi' => 'Brebes',
            'deskripsi_manfaat' => 'Deskripsi luaran yang telah disempurnakan bersama dinas perhubungan.',
            'indikator_keberhasilan' => 'Penerapan SOP baku di 5 terminal',
            'tingkat_kepuasan_mitra' => '92% (Sangat Puas)',
            'berkas_luaran' => $pdfFile,
        ]);

        $response->assertRedirect(route('admin.community-service-outputs.index'));
        $this->assertDatabaseHas('community_service_outputs', [
            'id' => $output->id,
            'judul' => 'Judul Luaran PkM Diperbarui',
            'kategori' => 'modul',
            'mitra_sasaran' => 'Dishub Kabupaten Brebes',
        ]);
    }

    public function test_admin_can_delete_community_service_output(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $output = CommunityServiceOutput::first();

        $filePath = 'community_services/outputs/delete_test.pdf';
        Storage::disk('public')->put($filePath, '%PDF-1.4');
        $output->update(['berkas_luaran' => $filePath]);

        $response = $this->actingAs($admin)->delete(route('admin.community-service-outputs.destroy', $output));

        $response->assertRedirect(route('admin.community-service-outputs.index'));
        $this->assertDatabaseMissing('community_service_outputs', ['id' => $output->id]);
        Storage::disk('public')->assertMissing($filePath);
    }

    public function test_admin_can_import_csv(): void
    {
        $admin = User::where('role', 'admin')->first();
        $prodi = Prodi::where('kode_prodi', 'RSTJ')->first();

        $csvContent = "Kategori,Judul,KodeProdi,Pelaksana,Tahun,Mitra,Lokasi,Manfaat,Indikator,Kepuasan,LinkDokumen\n";
        $csvContent .= "ttg,Prototipe Lampu Solar Cell Perlintasan Kereta,RSTJ,Prof. Suryo,2026,Masyarakat Tegal Barat,Tegal Barat,Lampu penerangan mandiri tenaga surya,Reduksi risiko kecelakaan 50%,95%,https://example.com\n";

        $file = UploadedFile::fake()->createWithContent('data_luaran_pkm.csv', $csvContent);

        $response = $this->actingAs($admin)->post(route('admin.community-service-outputs.import'), [
            'file_csv' => $file,
        ]);

        $response->assertRedirect(route('admin.community-service-outputs.index'));
        $this->assertDatabaseHas('community_service_outputs', [
            'judul' => 'Prototipe Lampu Solar Cell Perlintasan Kereta',
            'kategori' => 'ttg',
            'prodi_id' => $prodi->id,
            'pelaksana' => 'Prof. Suryo',
        ]);
    }
}
