<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicGuidelinePageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_can_access_panduan_pedoman_page(): void
    {
        $response = $this->get(route('layanan.panduan-pedoman'));

        $response->assertStatus(200);
        $response->assertSee('Panduan & Pedoman Mutu Tridharma', false);
        $response->assertSee('Empat Pedoman Utama Pelaksanaan Tridharma');
        $response->assertSee('Pedoman Penelitian dan Pengembangan Sumberdaya Manusia');
        $response->assertSee('Pedoman Pengabdian kepada Masyarakat dan Pengembangan Kualitas Kepakaran');
        $response->assertSee('Dokumen Proses Pengabdian kepada Masyarakat');
        $response->assertSee('Buku Panduan Penggunaan Sistem Informasi (SIM P3M)');
        $response->assertSee('Tahapan Pelaksanaan Penelitian & Pengabdian', false);
        $response->assertSee('Tanya Jawab Seputar Panduan & Sistem', false);
    }

    public function test_filter_by_kategori_pedoman(): void
    {
        $response = $this->get(route('layanan.panduan-pedoman', ['kategori' => 'pedoman_penelitian']));

        $response->assertStatus(200);
        $response->assertSee('Pedoman Penelitian dan Pengembangan Sumberdaya Manusia');
    }

    public function test_filter_by_kategori_pengabdian(): void
    {
        $response = $this->get(route('layanan.panduan-pedoman', ['kategori' => 'pedoman_pengabdian']));

        $response->assertStatus(200);
        $response->assertSee('Pedoman Pengabdian kepada Masyarakat dan Pengembangan Kualitas Kepakaran');
    }

    public function test_filter_by_kategori_proses_pengabdian(): void
    {
        $response = $this->get(route('layanan.panduan-pedoman', ['kategori' => 'proses_pengabdian']));

        $response->assertStatus(200);
        $response->assertSee('Dokumen Proses Pengabdian kepada Masyarakat');
    }

    public function test_filter_by_kategori_panduan_sistem(): void
    {
        $response = $this->get(route('layanan.panduan-pedoman', ['kategori' => 'panduan_sistem']));

        $response->assertStatus(200);
        $response->assertSee('Buku Panduan Penggunaan Sistem Informasi (SIM P3M)');
    }

    public function test_search_document_by_keyword(): void
    {
        $response = $this->get(route('layanan.panduan-pedoman', ['q' => 'Sumberdaya']));

        $response->assertStatus(200);
        $response->assertSee('Pedoman Penelitian dan Pengembangan Sumberdaya Manusia');
    }

    public function test_download_guideline_increments_counter(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $file = UploadedFile::fake()->create('pedoman_test.pdf', 500, 'application/pdf');
        $path = $file->store('documents', 'public');

        $doc = Document::create([
            'judul' => 'Pedoman Riset Uji Petik',
            'kategori' => 'pedoman_penelitian',
            'deskripsi' => 'Deskripsi berkas uji coba unduhan.',
            'file_path' => $path,
            'file_size' => '500 KB',
            'tahun' => '2026',
            'user_id' => $admin->id,
            'download_count' => 5,
        ]);

        $response = $this->get(route('layanan.panduan-pedoman.unduh', $doc));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(6, $doc->fresh()->download_count);
    }

    public function test_admin_can_create_document_with_new_category(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();

        $file = UploadedFile::fake()->create('panduan_baru.pdf', 300, 'application/pdf');

        $response = $this->actingAs($admin)->post(route('admin.documents.store'), [
            'judul' => 'Pedoman Standar Keselamatan Bengkel',
            'kategori' => 'pedoman_pengabdian',
            'tahun' => '2026',
            'deskripsi' => 'Pedoman standardisasi bengkel rakyat binaan PKTJ.',
            'file_dokumen' => $file,
        ]);

        $response->assertRedirect(route('admin.documents.index'));
        $this->assertDatabaseHas('documents', [
            'judul' => 'Pedoman Standar Keselamatan Bengkel',
            'kategori' => 'pedoman_pengabdian',
            'tahun' => '2026',
        ]);
    }

    public function test_admin_can_update_document_category(): void
    {
        $admin = User::where('role', 'admin')->first();
        $doc = Document::where('kategori', 'pedoman_penelitian')->first();
        $this->assertNotNull($doc);

        $response = $this->actingAs($admin)->put(route('admin.documents.update', $doc), [
            'judul' => 'Pedoman Penelitian dan Pengembangan SDM Terpadu 2026',
            'kategori' => 'pedoman_penelitian',
            'tahun' => '2026',
            'deskripsi' => 'Pembaruan deskripsi pedoman SDM.',
        ]);

        $response->assertRedirect(route('admin.documents.index'));
        $this->assertDatabaseHas('documents', [
            'id' => $doc->id,
            'judul' => 'Pedoman Penelitian dan Pengembangan SDM Terpadu 2026',
        ]);
    }

    public function test_admin_can_delete_document(): void
    {
        $admin = User::where('role', 'admin')->first();
        $doc = Document::first();
        $this->assertNotNull($doc);

        $response = $this->actingAs($admin)->delete(route('admin.documents.destroy', $doc));

        $response->assertRedirect(route('admin.documents.index'));
        $this->assertDatabaseMissing('documents', [
            'id' => $doc->id,
        ]);
    }

    public function test_public_can_access_sop_page(): void
    {
        $response = $this->get(route('layanan.sop'));

        $response->assertStatus(200);
        $response->assertSee('Standar Operasional Prosedur (SOP)');
        $response->assertSee('SOP Bidang Penelitian');
        $response->assertSee('SOP Bidang Pengabdian kepada Masyarakat');
        $response->assertSee('Standar Operasional Prosedur (SOP) Pengusulan Riset DIPA');
        $response->assertSee('Standar Operasional Prosedur (SOP) Pengabdian kepada Masyarakat');
    }

    public function test_search_sop_by_keyword(): void
    {
        $response = $this->get(route('layanan.sop', ['q' => 'DIPA']));

        $response->assertStatus(200);
        $response->assertSee('Standar Operasional Prosedur (SOP) Pengusulan Riset DIPA');
        $response->assertDontSee('Standar Operasional Prosedur (SOP) Pengabdian kepada Masyarakat');
    }

    public function test_download_sop_increments_counter(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $file = UploadedFile::fake()->create('sop_test.pdf', 400, 'application/pdf');
        $path = $file->store('documents', 'public');

        $doc = Document::create([
            'judul' => 'SOP Pengujian Rem Kendaraan',
            'kategori' => 'sop_penelitian',
            'deskripsi' => 'Deskripsi berkas uji coba SOP unduhan.',
            'file_path' => $path,
            'file_size' => '400 KB',
            'tahun' => '2026',
            'user_id' => $admin->id,
            'download_count' => 2,
        ]);

        $response = $this->get(route('layanan.panduan-pedoman.unduh', $doc));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(3, $doc->fresh()->download_count);
    }
}
