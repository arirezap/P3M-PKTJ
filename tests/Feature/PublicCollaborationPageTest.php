<?php

namespace Tests\Feature;

use App\Models\Collaboration;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicCollaborationPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_can_access_kerjasama_penelitian_page(): void
    {
        $response = $this->get(route('riset.kerjasama'));

        $response->assertStatus(200);
        $response->assertSee('Kerjasama Bidang Penelitian');
        $response->assertSee('Korps Lalu Lintas (Korlantas) Polri');
        $response->assertSee('PT Hino Motors Manufacturing Indonesia');
    }

    public function test_stat_cards_display_metrics(): void
    {
        $response = $this->get(route('riset.kerjasama'));

        $response->assertStatus(200);
        $response->assertSee('Total Kemitraan');
        $response->assertSee('Kerjasama Aktif');
        $response->assertSee('Industri & BUMN', false);
        $response->assertSee('Dokumen Legalitas');
    }

    public function test_filter_by_kategori_mitra(): void
    {
        $response = $this->get(route('riset.kerjasama', ['kategori' => 'pemerintah']));

        $response->assertStatus(200);
        $response->assertSee('Korps Lalu Lintas (Korlantas) Polri');
        $response->assertDontSee('PT Hino Motors Manufacturing Indonesia');
    }

    public function test_filter_by_prodi(): void
    {
        $prodiRstj = Prodi::where('kode_prodi', 'RSTJ')->first();

        $response = $this->get(route('riset.kerjasama', ['prodi' => $prodiRstj->id]));

        $response->assertStatus(200);
        $response->assertSee('Korps Lalu Lintas (Korlantas) Polri');
    }

    public function test_filter_by_year(): void
    {
        $response = $this->get(route('riset.kerjasama', ['tahun' => 2024]));

        $response->assertStatus(200);
        $response->assertSee('Institut Teknologi Bandung');
        $response->assertDontSee('PT Hino Motors Manufacturing Indonesia');
    }

    public function test_filter_by_status(): void
    {
        $response = $this->get(route('riset.kerjasama', ['status' => 'selesai']));

        $response->assertStatus(200);
        $response->assertSee('Perum DAMRI');
    }

    public function test_keyword_search(): void
    {
        $response = $this->get(route('riset.kerjasama', ['q' => 'Pertamina']));

        $response->assertStatus(200);
        $response->assertSee('PT Pertamina Patra Niaga');
        $response->assertDontSee('Institut Teknologi Bandung');
    }

    public function test_download_collaboration_document(): void
    {
        $collab = Collaboration::whereNotNull('file_dokumen')->first();

        $response = $this->get(route('riset.kerjasama.unduh', $collab->id));

        $response->assertOk();
        $this->assertTrue(
            str_contains($response->headers->get('content-disposition'), 'attachment')
        );
    }

    public function test_admin_can_manage_collaboration_via_cms(): void
    {
        Storage::fake('public');
        $admin = User::where('role', 'admin')->first();
        $prodiTro = Prodi::where('kode_prodi', 'TRO')->first();

        // 1. Akses halaman index CMS
        $response = $this->actingAs($admin)->get(route('admin.collaborations.index'));
        $response->assertStatus(200);
        $response->assertSee('Data Kerjasama Bidang Penelitian');

        // 2. Akses halaman create CMS
        $responseCreate = $this->actingAs($admin)->get(route('admin.collaborations.create'));
        $responseCreate->assertStatus(200);

        // 3. Tambah data kerjasama baru
        $fakePdf = UploadedFile::fake()->create('mou_toyota_2026.pdf', 500, 'application/pdf');
        $storeResponse = $this->actingAs($admin)->post(route('admin.collaborations.store'), [
            'nama_mitra' => 'PT Toyota Motor Manufacturing Indonesia',
            'judul_kerjasama' => 'Kajian Uji Crash Safety & Rangka Bus Listrik Vokasi',
            'jenis_kegiatan' => 'penelitian',
            'kategori_mitra' => 'industri',
            'prodi_id' => $prodiTro->id,
            'nomor_mou_pks' => 'TMMIN/CSR/PKTJ/2026/01',
            'tahun' => 2026,
            'status_kerjasama' => 'aktif',
            'deskripsi' => 'Pengujian kekuatan impak struktur rangka bus listrik.',
            'tanggal_mulai' => '2026-03-01',
            'tanggal_berakhir' => '2027-02-28',
            'file_dokumen' => $fakePdf,
        ]);

        $storeResponse->assertRedirect(route('admin.collaborations.index'));
        $this->assertDatabaseHas('collaborations', [
            'nama_mitra' => 'PT Toyota Motor Manufacturing Indonesia',
            'nomor_mou_pks' => 'TMMIN/CSR/PKTJ/2026/01',
        ]);

        $created = Collaboration::where('nomor_mou_pks', 'TMMIN/CSR/PKTJ/2026/01')->first();
        $this->assertNotNull($created->file_dokumen);
        Storage::disk('public')->assertExists($created->file_dokumen);

        // 4. Update data kerjasama
        $updateResponse = $this->actingAs($admin)->put(route('admin.collaborations.update', $created->id), [
            'nama_mitra' => 'PT Toyota Motor Manufacturing Indonesia (TMMIN)',
            'judul_kerjasama' => 'Kajian Uji Crash Safety & Rangka Bus Listrik Vokasi Terpadu',
            'jenis_kegiatan' => 'penelitian',
            'kategori_mitra' => 'industri',
            'prodi_id' => $prodiTro->id,
            'nomor_mou_pks' => 'TMMIN/CSR/PKTJ/2026/01-REV',
            'tahun' => 2026,
            'status_kerjasama' => 'aktif',
            'deskripsi' => 'Pengujian kekuatan impak struktur rangka bus listrik revisi.',
        ]);

        $updateResponse->assertRedirect(route('admin.collaborations.index'));
        $this->assertDatabaseHas('collaborations', [
            'nama_mitra' => 'PT Toyota Motor Manufacturing Indonesia (TMMIN)',
            'nomor_mou_pks' => 'TMMIN/CSR/PKTJ/2026/01-REV',
        ]);

        // 5. Hapus data kerjasama
        $deleteResponse = $this->actingAs($admin)->delete(route('admin.collaborations.destroy', $created->id));
        $deleteResponse->assertRedirect(route('admin.collaborations.index'));
        $this->assertDatabaseMissing('collaborations', [
            'id' => $created->id,
        ]);
    }

    public function test_guest_and_dosen_cannot_manage_collaborations(): void
    {
        $dosen = User::where('role', 'dosen')->first();

        // Tamu ditolak
        $responseGuest = $this->get(route('admin.collaborations.index'));
        $responseGuest->assertRedirect('/login');

        // Dosen diarahkan ke dashboard dosen
        $responseDosen = $this->actingAs($dosen)->get(route('admin.collaborations.index'));
        $responseDosen->assertRedirect('/dosen/dashboard');
    }
}
