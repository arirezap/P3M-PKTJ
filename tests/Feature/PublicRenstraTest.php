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
        $response->assertSee('Unduh Berkas PDF');
    }

    public function test_download_document_increments_counter(): void
    {
        Storage::fake('public');

        $doc = Document::where('kategori', 'renstra_penelitian')->first();
        if (! $doc) {
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

    public function test_public_views_renstra_page_with_embedded_pdf_tabs(): void
    {
        $response = $this->get(route('profil.rencana-strategis'));

        $response->assertStatus(200);
        $response->assertSee('activeTab: \'penelitian\'', false);
        $response->assertSee('Dokumen Rencana Strategis Penelitian 2026-2031');
        $response->assertSee('Dokumen Rencana Strategis Pengabdian Kepada Masyarakat');
        $response->assertSee('Unduh Berkas PDF');
    }

    public function test_renstra_page_appearance_is_consistent_and_does_not_show_cms_button(): void
    {
        $admin = User::where('role', 'admin')->first();
        $dosen = User::where('role', 'dosen')->first();

        $guestResponse = $this->get(route('profil.rencana-strategis'));
        $guestResponse->assertStatus(200);
        $guestResponse->assertDontSee('Kelola Dokumen di CMS');

        $adminResponse = $this->actingAs($admin)->get(route('profil.rencana-strategis'));
        $adminResponse->assertStatus(200);
        $adminResponse->assertDontSee('Kelola Dokumen di CMS');

        $dosenResponse = $this->actingAs($dosen)->get(route('profil.rencana-strategis'));
        $dosenResponse->assertStatus(200);
        $dosenResponse->assertDontSee('Kelola Dokumen di CMS');
    }

    public function test_non_admin_cannot_manage_renstra_via_cms(): void
    {
        $dosen = User::where('role', 'dosen')->first();
        $renstra = Document::where('kategori', 'renstra_penelitian')->first();

        $response = $this->actingAs($dosen)->put(route('admin.documents.update', $renstra), [
            'judul' => 'Perubahan Tidak Sah Oleh Dosen',
            'kategori' => 'renstra_penelitian',
            'deskripsi' => 'Mencoba meretas dokumen',
        ]);

        $response->assertRedirect('/dosen/dashboard');
    }

    public function test_download_non_existent_document_returns_404(): void
    {
        $response = $this->get('/dokumen/999999/unduh');

        $response->assertStatus(404);
    }
}
