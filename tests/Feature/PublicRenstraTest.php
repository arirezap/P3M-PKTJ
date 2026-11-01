<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicRenstraTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_can_access_rencana_strategis_page(): void
    {
        $response = $this->get(route('profil.rencana-strategis'));

        $response->assertStatus(200);
        $response->assertSee('Rencana Strategis');
        $response->assertSee('Dokumen Rencana Strategis Penelitian 2026-2031');
        $response->assertSee('Dokumen Rencana Strategis Pengabdian Kepada Masyarakat');
        $response->assertSee('D4 RSTJ');
        $response->assertSee('D4 TRO');
        $response->assertSee('D3 TO');
    }

    public function test_download_document_increments_counter(): void
    {
        Storage::fake('public');

        $doc = Document::where('kategori', 'renstra_penelitian')->first();
        if (!$doc) {
            $doc = Document::create([
                'judul' => 'Dokumen Rencana Strategis Penelitian 2026-2031',
                'kategori' => 'renstra_penelitian',
                'deskripsi' => 'Uji coba unduh renstra',
                'file_path' => 'documents/test_renstra.pdf',
                'file_size' => '1.0 MB',
                'tahun' => '2026-2031',
                'download_count' => 0,
            ]);
        }

        // Simpan file tiruan di storage
        Storage::disk('public')->put($doc->file_path, '%PDF-1.4 sample content');

        $initialCount = $doc->download_count;

        $response = $this->get(route('documents.download', $doc));

        $response->assertOk();
        $this->assertEquals($initialCount + 1, $doc->fresh()->download_count);
    }

    public function test_admin_can_manage_renstra_documents_via_cms(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $file = UploadedFile::fake()->create('renstra_revisi.pdf', 1024, 'application/pdf');

        $renstra = Document::where('kategori', 'renstra_penelitian')->first();

        $updateResponse = $this->actingAs($admin)->put(route('admin.documents.update', $renstra), [
            'judul' => 'Dokumen Rencana Strategis Penelitian 2026-2031 Edisi Pemutakhiran',
            'kategori' => 'renstra_penelitian',
            'deskripsi' => 'Arah kebijakan riset keselamatan transportasi darat hasil pemutakhiran terpadu.',
            'tahun' => '2026 - 2031',
            'file_dokumen' => $file,
        ]);

        $updateResponse->assertRedirect(route('admin.documents.index'));
        $updateResponse->assertSessionHas('success');

        $this->assertDatabaseHas('documents', [
            'id' => $renstra->id,
            'judul' => 'Dokumen Rencana Strategis Penelitian 2026-2031 Edisi Pemutakhiran',
        ]);

        // Verifikasi halaman publik langsung menampilkan judul yang diperbarui
        $publicResponse = $this->get(route('profil.rencana-strategis'));
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('Dokumen Rencana Strategis Penelitian 2026-2031 Edisi Pemutakhiran');
    }
}
