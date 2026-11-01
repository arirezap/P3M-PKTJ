<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicRoadmapTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_can_access_roadmap_penelitian_page(): void
    {
        $response = $this->get(route('profil.roadmap-penelitian'));

        $response->assertStatus(200);
        $response->assertSee('Roadmap Penelitian');
        $response->assertSee('Roadmap Penelitian Keselamatan Transportasi Terpadu');
        $response->assertSee('Visualisasi 3 Fase Peta Jalan Riset PKTJ');
        $response->assertSee('Fase 1');
        $response->assertSee('Fase 2');
        $response->assertSee('Fase 3');
        $response->assertSee('D4 RSTJ');
        $response->assertSee('D4 TRO');
        $response->assertSee('D3 TO');
    }

    public function test_download_roadmap_document_increments_counter(): void
    {
        Storage::fake('public');

        $doc = Document::where('kategori', 'roadmap')->first();
        if (!$doc) {
            $doc = Document::create([
                'judul' => 'Roadmap Penelitian Keselamatan Transportasi Terpadu',
                'kategori' => 'roadmap',
                'deskripsi' => 'Uji coba unduh roadmap',
                'file_path' => 'documents/test_roadmap.pdf',
                'file_size' => '1.5 MB',
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

    public function test_admin_can_update_roadmap_document_via_cms(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $file = UploadedFile::fake()->create('roadmap_revisi.pdf', 1024, 'application/pdf');

        $roadmap = Document::where('kategori', 'roadmap')->first();

        $updateResponse = $this->actingAs($admin)->put(route('admin.documents.update', $roadmap), [
            'judul' => 'Roadmap Penelitian Keselamatan Transportasi Terpadu Edisi 2026-2031',
            'kategori' => 'roadmap',
            'deskripsi' => 'Peta jalan riset hasil sinkronisasi dengan BPSDMP Kemenhub terbaru.',
            'tahun' => '2026 - 2031',
            'file_dokumen' => $file,
        ]);

        $updateResponse->assertRedirect(route('admin.documents.index'));
        $updateResponse->assertSessionHas('success');

        $this->assertDatabaseHas('documents', [
            'id' => $roadmap->id,
            'judul' => 'Roadmap Penelitian Keselamatan Transportasi Terpadu Edisi 2026-2031',
        ]);

        // Verifikasi halaman publik langsung menampilkan judul yang diperbarui
        $publicResponse = $this->get(route('profil.roadmap-penelitian'));
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('Roadmap Penelitian Keselamatan Transportasi Terpadu Edisi 2026-2031');
    }
}
