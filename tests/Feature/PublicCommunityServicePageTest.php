<?php

namespace Tests\Feature;

use App\Models\CommunityService;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicCommunityServicePageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_can_access_pkm_page(): void
    {
        $response = $this->get(route('pengabdian.pkm'));

        $response->assertStatus(200);
        $response->assertSee('Pengabdian Kepada Masyarakat', false);
        $response->assertSee('D4 RSTJ');
        $response->assertSee('D4 TRO');
        $response->assertSee('D3 TO');
        $response->assertSee('Semua Sumber Dana');
        $response->assertSee('DIPA PKTJ / Internal');
        $response->assertSee('Kemdiktisaintek / DRTPM');
        $response->assertSee('Mitra Industri / CSR');
        $response->assertSee('Mandiri / Swadana');
        $response->assertSee('Capaian 3 Program Studi');
    }

    public function test_redirect_from_pengabdian_root_to_pkm(): void
    {
        $response = $this->get('/pengabdian');

        $response->assertRedirect(route('pengabdian.pkm'));
    }

    public function test_real_2025_pkm_data_from_excel_is_seeded_without_duplicates(): void
    {
        $pkm2025 = CommunityService::where('tahun', 2025)->get();
        $this->assertCount(74, $pkm2025);

        $this->assertEquals(14, $pkm2025->where('jenis_diklat', 'Penyuluhan & Sosialisasi')->count());
        $this->assertEquals(60, $pkm2025->whereIn('jenis_diklat', ['DPM', 'Teknis'])->count());

        $uniqueTitles = $pkm2025->pluck('judul')->map(fn ($t) => strtolower(trim($t)))->unique();
        $this->assertCount(74, $uniqueTitles);

        $this->assertEquals(14, $pkm2025->whereNotNull('kode_pkm')->count());
        $samplePkm = $pkm2025->where('kode_pkm', '2025/PkM/01')->first();
        $this->assertNotNull($samplePkm);
        $this->assertEquals(0, (int) $pkm2025->sum('anggaran'));
    }

    public function test_filter_by_prodi(): void
    {
        $troProdi = Prodi::where('kode_prodi', 'TRO')->first();
        $this->assertNotNull($troProdi);

        $response = $this->get(route('pengabdian.pkm', ['prodi' => 'TRO']));

        $response->assertStatus(200);
        $response->assertSee('D4 TRO');
    }

    public function test_filter_by_sumber_dana_tab(): void
    {
        $response = $this->get(route('pengabdian.pkm', ['sumber_dana' => 'dipa']));

        $response->assertStatus(200);
        $response->assertSee('DIPA');
    }

    public function test_filter_by_year(): void
    {
        $response = $this->get(route('pengabdian.pkm', ['tahun' => 2026]));

        $response->assertStatus(200);
        $response->assertSee('Tahun Anggaran 2026');
    }

    public function test_keyword_search(): void
    {
        $service = CommunityService::first();
        $this->assertNotNull($service);

        $response = $this->get(route('pengabdian.pkm', ['q' => substr($service->judul, 0, 15)]));

        $response->assertStatus(200);
        $response->assertSee($service->judul);
    }

    public function test_download_community_service_report_pdf(): void
    {
        Storage::fake('public');

        $service = CommunityService::first();
        $filePath = 'community_services/reports/sample_report.pdf';
        Storage::disk('public')->put($filePath, '%PDF-1.4 sample content');

        $service->update(['berkas_laporan' => $filePath]);

        $response = $this->get(route('pengabdian.pkm.unduh', $service));
        $response->assertOk();

        // Uji kasus berkas tidak ada
        $serviceEmpty = CommunityService::create([
            'prodi_id' => $service->prodi_id,
            'ketua_pelaksana' => 'Dr. Ir. Contoh Pelaksana, M.T.',
            'judul' => 'Pengabdian Tanpa Berkas Laporan',
            'skema' => 'PkM Kemitraan',
            'sumber_dana' => 'DIPA PKTJ',
            'anggaran' => 15000000,
            'tahun' => 2026,
            'status' => 'Selesai',
        ]);

        $responseEmpty = $this->get(route('pengabdian.pkm.unduh', $serviceEmpty));
        $responseEmpty->assertRedirect();
        $responseEmpty->assertSessionHas('error');
    }

    public function test_admin_can_create_community_service_with_file_and_details(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $prodi = Prodi::first();

        $pdfFile = UploadedFile::fake()->create('laporan_pkm_test.pdf', 500, 'application/pdf');

        $response = $this->actingAs($admin)->post(route('admin.community-services.store'), [
            'judul' => 'Edukasi Budaya Keselamatan Lalu Lintas Pengemudi Truk Muatan Berat',
            'ringkasan' => 'Pelatihan pemahaman titik buta dan pengecekan rem angin sebelum melintasi jalur curam.',
            'prodi_id' => $prodi->id,
            'ketua_pelaksana' => 'Dr. Hendro Wibowo, M.T.',
            'anggota' => 'Agus Setiawan, M.T., Dimas (Taruna)',
            'tahun' => 2026,
            'skema' => 'PkM Kemitraan Industri',
            'mitra' => 'Asosiasi Pengusaha Truk Indonesia (APTRINDO)',
            'lokasi_kegiatan' => 'Kec. Larangan, Kab. Brebes',
            'sumber_dana' => 'Mitra Industri',
            'anggaran' => 35000000,
            'status' => 'Selesai',
            'berkas_laporan' => $pdfFile,
        ]);

        $response->assertRedirect(route('admin.community-services.index'));
        $response->assertSessionHas('success');

        $created = CommunityService::where('judul', 'Edukasi Budaya Keselamatan Lalu Lintas Pengemudi Truk Muatan Berat')->first();
        $this->assertNotNull($created);
        $this->assertEquals('Kec. Larangan, Kab. Brebes', $created->lokasi_kegiatan);
        $this->assertNotNull($created->berkas_laporan);
        Storage::disk('public')->assertExists($created->berkas_laporan);
    }

    public function test_admin_can_update_community_service(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $service = CommunityService::first();

        $pdfFile = UploadedFile::fake()->create('laporan_revisi_pkm.pdf', 600, 'application/pdf');

        $response = $this->actingAs($admin)->put(route('admin.community-services.update', $service), [
            'judul' => 'Judul Kegiatan PkM Diperbarui',
            'ringkasan' => 'Ringkasan kegiatan yang telah disempurnakan bersama mitra binaan.',
            'prodi_id' => $service->prodi_id,
            'ketua_pelaksana' => 'Nama Pelaksana Baru, M.T.',
            'anggota' => 'Anggota Tim Baru',
            'tahun' => $service->tahun,
            'skema' => 'PkM Vokasi Unggulan',
            'mitra' => 'Mitra Binaan Baru',
            'lokasi_kegiatan' => 'Kota Tegal Barat',
            'sumber_dana' => 'DIPA PKTJ',
            'anggaran' => 28000000,
            'status' => 'Selesai',
            'berkas_laporan' => $pdfFile,
        ]);

        $response->assertRedirect(route('admin.community-services.index'));
        $this->assertDatabaseHas('community_services', [
            'id' => $service->id,
            'judul' => 'Judul Kegiatan PkM Diperbarui',
            'lokasi_kegiatan' => 'Kota Tegal Barat',
            'anggaran' => 28000000,
        ]);
    }

    public function test_admin_can_delete_community_service(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $service = CommunityService::first();

        $filePath = 'community_services/reports/delete_me.pdf';
        Storage::disk('public')->put($filePath, '%PDF-1.4');
        $service->update(['berkas_laporan' => $filePath]);

        $response = $this->actingAs($admin)->delete(route('admin.community-services.destroy', $service));

        $response->assertRedirect(route('admin.community-services.index'));
        $this->assertDatabaseMissing('community_services', ['id' => $service->id]);
        Storage::disk('public')->assertMissing($filePath);
    }

    public function test_admin_can_import_csv(): void
    {
        $admin = User::where('role', 'admin')->first();
        $prodi = Prodi::where('kode_prodi', 'RSTJ')->first();

        $csvContent = "Judul,KodeProdi,Ketua,Anggota,Tahun,Skema,Mitra,Lokasi,SumberDana,Anggaran,Status,Ringkasan\n";
        $csvContent .= "Kegiatan Impor Baru,RSTJ,Prof. Bambang,Budi,2026,PkM Kemitraan,Dishub,Tegal Barat,DIPA PKTJ,15000000,Selesai,Ringkasan Manfaat Impor\n";

        $file = UploadedFile::fake()->createWithContent('data_pkm.csv', $csvContent);

        $response = $this->actingAs($admin)->post(route('admin.community-services.import'), [
            'file_csv' => $file,
        ]);

        $response->assertRedirect(route('admin.community-services.index'));
        $this->assertDatabaseHas('community_services', [
            'judul' => 'Kegiatan Impor Baru',
            'prodi_id' => $prodi->id,
            'lokasi_kegiatan' => 'Tegal Barat',
        ]);
    }
}
