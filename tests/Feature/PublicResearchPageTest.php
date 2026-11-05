<?php

namespace Tests\Feature;

use App\Models\Prodi;
use App\Models\Research;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicResearchPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_can_access_kegiatan_penelitian_page(): void
    {
        $response = $this->get(route('riset.penelitian'));

        $response->assertStatus(200);
        $response->assertSee('Kegiatan & Rekapitulasi Penelitian Terapan', false);
        $response->assertSee('D4 RSTJ');
        $response->assertSee('D4 TRO');
        $response->assertSee('D3 TO');
        $response->assertSee('Semua Sumber Dana');
        $response->assertSee('DIPA PKTJ / Kemenhub');
        $response->assertSee('Kemdiktisaintek / Nasional');
        $response->assertSee('Mitra Industri / Eksternal');
        $response->assertSee('Mandiri / Swadana');
        $response->assertSee('researchTrendChart');
        $response->assertSee('prodiDistributionChart');
    }

    public function test_ketua_peneliti_is_clickable_when_user_exists(): void
    {
        $dosen = User::where('role', 'dosen')->where('status_aktif', true)->first();
        $this->assertNotNull($dosen);

        $research = Research::first();
        $this->assertNotNull($research);

        $research->update([
            'user_id' => $dosen->id,
            'ketua_peneliti' => $dosen->name,
        ]);

        $response = $this->get(route('riset.penelitian'));
        $response->assertStatus(200);
        $response->assertSee(route('profil.peneliti.show', $dosen));
    }

    public function test_real_research_2025_data_is_seeded_and_displayed(): void
    {
        $this->assertEquals(27, Research::where('tahun', 2025)->count());
        $this->assertEquals(56, Research::whereNotNull('kode_penelitian')->count());

        $sample = Research::where('kode_penelitian', '2025/PT/01')->first();
        $this->assertNotNull($sample);
        $this->assertStringContainsString('Brasie Pradana', $sample->ketua_peneliti);
        $this->assertEquals('PT / Mandiri', $sample->sumber_dana);
        $this->assertEquals(6000000, (float) $sample->anggaran);
        $this->assertNotNull($sample->user_id);

        $response = $this->get(route('riset.penelitian', ['tahun' => 2025]));
        $response->assertStatus(200);
        $response->assertSee('Brasie Pradana');
        $response->assertSee('Evaluasi Efektivitas Implementasi Laboratorium Virtual Reality');
        $response->assertSee('2025/PT/01');
    }

    public function test_filter_by_prodi(): void
    {
        $troProdi = Prodi::where('kode_prodi', 'TRO')->first();
        $this->assertNotNull($troProdi);

        $response = $this->get(route('riset.penelitian', ['prodi' => 'TRO']));

        $response->assertStatus(200);
        $response->assertSee('D4 TRO');
    }

    public function test_filter_by_sumber_dana_tab(): void
    {
        $response = $this->get(route('riset.penelitian', ['sumber_dana' => 'dipa']));

        $response->assertStatus(200);
        $response->assertSee('DIPA');
    }

    public function test_filter_by_year(): void
    {
        $response = $this->get(route('riset.penelitian', ['tahun' => 2025]));

        $response->assertStatus(200);
        $response->assertSee('Tahun Anggaran 2025');
    }

    public function test_keyword_search(): void
    {
        $research = Research::first();
        $this->assertNotNull($research);

        $response = $this->get(route('riset.penelitian', ['q' => substr($research->judul, 0, 10)]));

        $response->assertStatus(200);
        $response->assertSee($research->judul);
    }

    public function test_download_research_report_pdf(): void
    {
        Storage::fake('public');

        $research = Research::first();
        $filePath = 'researches/sample_report.pdf';
        Storage::disk('public')->put($filePath, '%PDF-1.4 sample content');

        $research->update(['berkas_laporan' => $filePath]);

        $response = $this->get(route('riset.penelitian.unduh', $research));
        $response->assertOk();

        // Uji kasus berkas tidak ada
        $researchEmpty = Research::create([
            'prodi_id' => $research->prodi_id,
            'ketua_peneliti' => 'Dr. Ir. Contoh Peneliti, M.T.',
            'judul' => 'Penelitian Tanpa Berkas Unduhan',
            'skema' => 'Penelitian Dosen Pemula',
            'sumber_dana' => 'DIPA PKTJ',
            'anggaran' => 20000000,
            'tahun' => 2026,
            'status' => 'Selesai',
            'abstrak' => 'Contoh abstrak penelitian tanpa berkas laporan.',
            'berkas_laporan' => null,
        ]);

        $failResponse = $this->get(route('riset.penelitian.unduh', $researchEmpty));
        $failResponse->assertRedirect();
        $failResponse->assertSessionHas('error');
    }

    public function test_admin_can_manage_research_with_pdf_via_cms(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $prodi = Prodi::where('kode_prodi', 'RSTJ')->first();
        $this->assertNotNull($prodi);

        $pdfFile = UploadedFile::fake()->create('laporan_akhir.pdf', 1024, 'application/pdf');

        // 1. Tambah Data Baru
        $storeResponse = $this->actingAs($admin)->post(route('admin.researches.store'), [
            'prodi_id' => $prodi->id,
            'ketua_peneliti' => 'Dr. Ir. Agus Hendra, M.T.',
            'judul' => 'Audit Keselamatan Tikungan Tajam Ruas Pantura Tegal',
            'skema' => 'Terapan Vokasi',
            'sumber_dana' => 'DIPA PKTJ',
            'anggaran' => 45000000,
            'tahun' => 2026,
            'status' => 'Selesai',
            'anggota' => 'Ir. Sudirman, M.T.',
            'abstrak' => 'Penelitian ini menganalisis titik rawan kecelakaan di ruas jalur Pantura Barat Kota Tegal.',
            'berkas_laporan' => $pdfFile,
        ]);

        $storeResponse->assertRedirect(route('admin.researches.index'));
        $storeResponse->assertSessionHas('success');

        $createdResearch = Research::where('judul', 'Audit Keselamatan Tikungan Tajam Ruas Pantura Tegal')->first();
        $this->assertNotNull($createdResearch);
        $this->assertNotNull($createdResearch->berkas_laporan);
        Storage::disk('public')->assertExists($createdResearch->berkas_laporan);

        // 2. Perbarui Data dengan File Baru
        $newPdf = UploadedFile::fake()->create('laporan_revisi.pdf', 1500, 'application/pdf');
        $oldPath = $createdResearch->berkas_laporan;

        $updateResponse = $this->actingAs($admin)->put(route('admin.researches.update', $createdResearch), [
            'prodi_id' => $prodi->id,
            'ketua_peneliti' => 'Dr. Ir. Agus Hendra, M.T.',
            'judul' => 'Audit Keselamatan Tikungan Tajam Ruas Pantura Tegal - Revisi Final',
            'skema' => 'Terapan Vokasi',
            'sumber_dana' => 'DIPA PKTJ',
            'anggaran' => 50000000,
            'tahun' => 2026,
            'status' => 'Selesai',
            'anggota' => 'Ir. Sudirman, M.T.',
            'abstrak' => 'Abstrak hasil revisi akhir evaluasi rekayasa geometrik.',
            'berkas_laporan' => $newPdf,
        ]);

        $updateResponse->assertRedirect(route('admin.researches.index'));
        $updateResponse->assertSessionHas('success');

        $updatedResearch = $createdResearch->fresh();
        $this->assertEquals('Audit Keselamatan Tikungan Tajam Ruas Pantura Tegal - Revisi Final', $updatedResearch->judul);
        $this->assertNotEquals($oldPath, $updatedResearch->berkas_laporan);
        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($updatedResearch->berkas_laporan);

        // 3. Verifikasi Muncul di Halaman Publik
        $publicCheck = $this->get(route('riset.penelitian'));
        $publicCheck->assertStatus(200);
        $publicCheck->assertSee('Audit Keselamatan Tikungan Tajam Ruas Pantura Tegal - Revisi Final');

        // 4. Hapus Data
        $deleteResponse = $this->actingAs($admin)->delete(route('admin.researches.destroy', $updatedResearch));
        $deleteResponse->assertRedirect(route('admin.researches.index'));
        $this->assertDatabaseMissing('researches', ['id' => $updatedResearch->id]);
        Storage::disk('public')->assertMissing($updatedResearch->berkas_laporan);
    }
}
