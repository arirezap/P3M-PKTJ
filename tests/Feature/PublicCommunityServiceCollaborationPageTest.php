<?php

namespace Tests\Feature;

use App\Models\Collaboration;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicCommunityServiceCollaborationPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_can_access_kerjasama_pkm_page(): void
    {
        $response = $this->get(route('pengabdian.kerjasama'));

        $response->assertStatus(200);
        $response->assertSee('Kerjasama Pengabdian kepada Masyarakat');
        $response->assertSee('Total Kemitraan PkM');
        $response->assertSee('Kerjasama Aktif');
        $response->assertSee('Pemerintah & BUMN', false);
        $response->assertSee('Dokumen Legalitas');
        $response->assertSee('Semua Kategori');
        $response->assertSee('BUMN / BUMD', false);
        $response->assertSee('Industri & Bengkel', false);
        $response->assertSee('Komunitas & Desa Binaan', false);
        $response->assertSee('D4 RSTJ');
        $response->assertSee('D4 TRO');
        $response->assertSee('D3 TO');
    }

    public function test_filter_by_kategori_tab(): void
    {
        $response = $this->get(route('pengabdian.kerjasama', ['kategori' => 'pemerintah']));

        $response->assertStatus(200);
        $response->assertSee('Dinas Perhubungan Kota Tegal');
    }

    public function test_filter_by_prodi(): void
    {
        $rstjProdi = Prodi::where('kode_prodi', 'RSTJ')->first();
        $this->assertNotNull($rstjProdi);

        $response = $this->get(route('pengabdian.kerjasama', ['prodi' => $rstjProdi->id]));

        $response->assertStatus(200);
        $response->assertSee('D4 RSTJ');
    }

    public function test_filter_by_year(): void
    {
        $response = $this->get(route('pengabdian.kerjasama', ['tahun' => 2026]));

        $response->assertStatus(200);
        $response->assertSee('Tahun 2026');
    }

    public function test_filter_by_status(): void
    {
        $response = $this->get(route('pengabdian.kerjasama', ['status' => 'aktif']));

        $response->assertStatus(200);
        $response->assertSee('Kerjasama Aktif');
    }

    public function test_keyword_search(): void
    {
        $response = $this->get(route('pengabdian.kerjasama', ['q' => 'Kereta Api']));

        $response->assertStatus(200);
        $response->assertSee('PT Kereta Api Indonesia (Persero) Daop 4 Semarang');
    }

    public function test_public_can_download_collaboration_document(): void
    {
        Storage::fake('public');

        $prodi = Prodi::first();
        $filePath = 'collaborations/test_dokumen_pkm.pdf';
        Storage::disk('public')->put($filePath, '%PDF-1.4 Fake PkM Content');

        $collab = Collaboration::create([
            'nama_mitra' => 'Mitra Uji Unduh PkM',
            'judul_kerjasama' => 'Kegiatan Pengabdian Uji Coba Berkas',
            'jenis_kegiatan' => 'pengabdian',
            'kategori_mitra' => 'pemerintah',
            'prodi_id' => $prodi->id,
            'nomor_mou_pks' => 'MoU/TEST-PKM/2026/01',
            'tahun' => 2026,
            'status_kerjasama' => 'aktif',
            'deskripsi' => 'Pengujian dokumen pendukung kerjasama pengabdian.',
            'file_dokumen' => $filePath,
        ]);

        $response = $this->get(route('pengabdian.kerjasama.unduh', $collab));

        $response->assertStatus(200);
        $this->assertStringContainsString('attachment', (string) $response->headers->get('content-disposition'));
    }

    public function test_admin_can_filter_and_manage_pkm_collaboration_in_cms(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $this->assertNotNull($admin);

        // 1. Filter CMS berdasarkan jenis_kegiatan=pengabdian
        $response = $this->actingAs($admin)->get(route('admin.collaborations.index', ['jenis_kegiatan' => 'pengabdian']));
        $response->assertStatus(200);
        $response->assertSee('Dinas Perhubungan Kota Tegal');

        // 2. Tambah Data Kerjasama Pengabdian Baru
        $prodi = Prodi::where('kode_prodi', 'RSTJ')->first();
        $pdfFile = UploadedFile::fake()->create('dokumen_mou_baru.pdf', 500, 'application/pdf');

        $storeResponse = $this->actingAs($admin)->post(route('admin.collaborations.store'), [
            'nama_mitra' => 'Pemerintah Desa Muarareja Kota Tegal',
            'judul_kerjasama' => 'Pendampingan Desa Binaan Sadar Keselamatan dan Rambu Nelayan',
            'jenis_kegiatan' => 'pengabdian',
            'kategori_mitra' => 'lainnya',
            'prodi_id' => $prodi->id,
            'nomor_mou_pks' => 'MoU/DESA-MUARAREJA/PKTJ/2026/099',
            'tahun' => 2026,
            'status_kerjasama' => 'aktif',
            'deskripsi' => 'Program kemitraan desa binaan di kawasan pesisir jalur lintasan armada logistik.',
            'tanggal_mulai' => '2026-04-01',
            'tanggal_berakhir' => '2027-03-31',
            'file_dokumen' => $pdfFile,
        ]);

        $storeResponse->assertRedirect(route('admin.collaborations.index'));
        $this->assertDatabaseHas('collaborations', [
            'nama_mitra' => 'Pemerintah Desa Muarareja Kota Tegal',
            'jenis_kegiatan' => 'pengabdian',
            'nomor_mou_pks' => 'MoU/DESA-MUARAREJA/PKTJ/2026/099',
        ]);

        // 3. Ubah Data
        $collab = Collaboration::where('nomor_mou_pks', 'MoU/DESA-MUARAREJA/PKTJ/2026/099')->first();
        $updateResponse = $this->actingAs($admin)->put(route('admin.collaborations.update', $collab), [
            'nama_mitra' => 'Pemerintah Desa Muarareja Kota Tegal Diperbarui',
            'judul_kerjasama' => 'Pendampingan Desa Binaan Sadar Keselamatan Jalan & Lingkungan',
            'jenis_kegiatan' => 'pengabdian',
            'kategori_mitra' => 'lainnya',
            'prodi_id' => $prodi->id,
            'nomor_mou_pks' => 'MoU/DESA-MUARAREJA/PKTJ/2026/099',
            'tahun' => 2026,
            'status_kerjasama' => 'aktif',
            'deskripsi' => 'Deskripsi kegiatan kemitraan yang telah diperbarui.',
            'tanggal_mulai' => '2026-04-01',
            'tanggal_berakhir' => '2027-03-31',
        ]);

        $updateResponse->assertRedirect(route('admin.collaborations.index'));
        $this->assertDatabaseHas('collaborations', [
            'id' => $collab->id,
            'nama_mitra' => 'Pemerintah Desa Muarareja Kota Tegal Diperbarui',
        ]);

        // 4. Hapus Data
        $deleteResponse = $this->actingAs($admin)->delete(route('admin.collaborations.destroy', $collab));
        $deleteResponse->assertRedirect(route('admin.collaborations.index'));
        $this->assertDatabaseMissing('collaborations', ['id' => $collab->id]);
    }
}
