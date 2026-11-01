<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\Post;
use App\Models\Prodi;
use App\Models\Research;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCmsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $dosen;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->admin = User::where('role', 'admin')->first();
        $this->dosen = User::where('role', 'dosen')->first();
    }

    public function test_admin_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Panel Kerja Administrator P3M');
    }

    public function test_admin_can_view_and_create_posts(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/posts');
        $response->assertStatus(200);

        $createResponse = $this->actingAs($this->admin)->get('/admin/posts/create');
        $createResponse->assertStatus(200);
        $createResponse->assertSee('Tulis Publikasi Baru');

        $postData = [
            'judul' => 'Pengujian Berita Baru CMS P3M',
            'kategori' => 'berita',
            'ringkasan' => 'Ringkasan berita pengujian sistem.',
            'konten' => '<p>Konten lengkap berita menggunakan TinyMCE.</p>',
            'status' => 'published',
            'tanggal_publikasi' => date('Y-m-d'),
        ];

        $storeResponse = $this->actingAs($this->admin)->post('/admin/posts', $postData);
        $storeResponse->assertRedirect('/admin/posts');

        $this->assertDatabaseHas('posts', [
            'judul' => 'Pengujian Berita Baru CMS P3M',
            'kategori' => 'berita',
        ]);
    }

    public function test_admin_can_view_and_upload_documents(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)->get('/admin/documents');
        $response->assertStatus(200);

        $file = UploadedFile::fake()->create('sop_pengujian.pdf', 500, 'application/pdf');

        $docData = [
            'judul' => 'SOP Pengujian Sistem SIM P3M',
            'kategori' => 'sop_penelitian',
            'deskripsi' => 'Keterangan dokumen pengujian.',
            'file_dokumen' => $file,
            'tahun' => '2026',
        ];

        $storeResponse = $this->actingAs($this->admin)->post('/admin/documents', $docData);
        $storeResponse->assertRedirect('/admin/documents');

        $this->assertDatabaseHas('documents', [
            'judul' => 'SOP Pengujian Sistem SIM P3M',
            'kategori' => 'sop_penelitian',
        ]);
    }

    public function test_admin_can_view_researches_and_community_services(): void
    {
        $responseRiset = $this->actingAs($this->admin)->get('/admin/researches');
        $responseRiset->assertStatus(200);
        $responseRiset->assertSee('Data Rekapitulasi Riset');

        $responsePkm = $this->actingAs($this->admin)->get('/admin/community-services');
        $responsePkm->assertStatus(200);
        $responsePkm->assertSee('Data Rekapitulasi Pengabdian');
    }

    public function test_admin_can_view_proposals_and_users(): void
    {
        $responseProp = $this->actingAs($this->admin)->get('/admin/proposals');
        $responseProp->assertStatus(200);

        $responseUser = $this->actingAs($this->admin)->get('/admin/users');
        $responseUser->assertStatus(200);
        $responseUser->assertSee('Manajemen Akun Dosen & Reviewer', false);
    }

    public function test_dosen_cannot_access_admin_cms_routes(): void
    {
        $response = $this->actingAs($this->dosen)->get('/admin/posts');
        $response->assertRedirect('/dosen/dashboard');

        $responseDocs = $this->actingAs($this->dosen)->get('/admin/documents');
        $responseDocs->assertRedirect('/dosen/dashboard');
    }
}
