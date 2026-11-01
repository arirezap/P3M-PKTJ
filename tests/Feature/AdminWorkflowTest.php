<?php

namespace Tests\Feature;

use App\Models\Prodi;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_login_page_renders_with_nama_pengguna_and_kata_sandi(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee('Nama Pengguna');
        $response->assertSee('Kata Sandi');
        $response->assertSee('Masuk ke SIM P3M');
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        $response = $this->post(route('login.post'), [
            'login' => 'admin@pktj.ac.id',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
        $this->assertEquals('admin', auth()->user()->role);
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        // 1. Pengguna Tamu (Guest)
        $guestResponse = $this->get(route('admin.dashboard'));
        $guestResponse->assertRedirect(route('login'));

        // 2. Pengguna Dosen
        $dosen = User::where('role', 'dosen')->first();
        $dosenResponse = $this->actingAs($dosen)->get(route('admin.dashboard'));
        $dosenResponse->assertRedirect(route('dosen.dashboard'));

        // 3. Pengguna Reviewer
        $reviewer = User::where('role', 'reviewer')->first();
        $reviewerResponse = $this->actingAs($reviewer)->get(route('admin.dashboard'));
        $reviewerResponse->assertRedirect(route('reviewer.dashboard'));
    }

    public function test_admin_dashboard_home_renders_three_main_submenus_and_pipeline(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        
        // Memeriksa keberadaan 3 Sub-Menu Utama sesuai dokumen Excel
        $response->assertSee('Pilihan Modul Kerja Utama');
        $response->assertSee('Sub-Menu 1');
        $response->assertSee('Penelitian');
        $response->assertSee('Akses Modul Penelitian');
        
        $response->assertSee('Sub-Menu 2');
        $response->assertSee('Pengabdian kepada Masyarakat');
        $response->assertSee('Akses Modul Pengabdian');

        $response->assertSee('Sub-Menu 3');
        $response->assertSee('Pengaturan');
        $response->assertSee('Buka Pengaturan Akun & Sistem', false);

        // Memeriksa keberadaan Pipeline Tahapan (Submission s.d. Archive)
        $response->assertSee('Pipeline Tahapan Kegiatan (Submission s.d. Archive)');
        $response->assertSee('Submission Masuk');
        $response->assertSee('Seleksi Berkas');
        $response->assertSee('Dalam Penilaian');
        $response->assertSee('Perbaikan Revisi');
        $response->assertSee('Didanai / Lolos');
        $response->assertSee('Pelaksanaan');
        $response->assertSee('Arsip Selesai');
    }

    public function test_admin_can_access_penelitian_module_and_filters(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get(route('admin.penelitian.index'));

        $response->assertStatus(200);
        $response->assertSee('Manajemen Usulan & Progres Kegiatan Penelitian', false);
        $response->assertSee('Submission');
        $response->assertSee('Verifikasi');
        $response->assertSee('Review');
        $response->assertSee('Archive');
        $response->assertSee('Program Studi');
        $response->assertSee('D4 RSTJ');
        $response->assertSee('D4 TRO');
        $response->assertSee('D3 TO');
    }

    public function test_admin_can_assign_reviewer_to_research_proposal(): void
    {
        $admin = User::where('role', 'admin')->first();
        $reviewer = User::where('role', 'reviewer')->first();
        $prodi = Prodi::first();
        $dosen = User::where('role', 'dosen')->first();

        $proposal = Proposal::create([
            'kode_usulan' => 'LIT-TEST-001',
            'jenis' => 'penelitian',
            'judul' => 'Riset Evaluasi Geometrik Simpang Pantura Tegal',
            'abstrak' => 'Abstrak riset keselamatan.',
            'prodi_id' => $prodi->id,
            'user_id' => $dosen->id,
            'tahun_anggaran' => 2026,
            'skema' => 'Penelitian DIPA',
            'sumber_dana' => 'DIPA PKTJ',
            'total_anggaran' => 35000000,
            'status' => 'diajukan',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.penelitian.assign-reviewer', $proposal), [
            'reviewer_id' => $reviewer->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertEquals('sedang_direview', $proposal->fresh()->status);
        $this->assertDatabaseHas('proposal_reviews', [
            'proposal_id' => $proposal->id,
            'reviewer_id' => $reviewer->id,
        ]);
    }

    public function test_admin_can_update_status_and_archive_research_proposal(): void
    {
        $admin = User::where('role', 'admin')->first();
        $prodi = Prodi::first();
        $dosen = User::where('role', 'dosen')->first();

        $proposal = Proposal::create([
            'kode_usulan' => 'LIT-TEST-002',
            'jenis' => 'penelitian',
            'judul' => 'Pengujian Durabilitas Rangka Kendaraan Listrik Taruna',
            'abstrak' => 'Abstrak uji ketahanan.',
            'prodi_id' => $prodi->id,
            'user_id' => $dosen->id,
            'tahun_anggaran' => 2026,
            'skema' => 'Penelitian Terapan',
            'sumber_dana' => 'DIPA PKTJ',
            'total_anggaran' => 45000000,
            'status' => 'diterima',
        ]);

        // 1. Update status ke Pelaksanaan
        $updateResponse = $this->actingAs($admin)->patch(route('admin.penelitian.update-status', $proposal), [
            'status' => 'pelaksanaan',
            'catatan_admin' => 'Pelaksanaan lapangan dan monev tengah semester.',
        ]);
        $updateResponse->assertRedirect();
        $this->assertEquals('pelaksanaan', $proposal->fresh()->status);

        // 2. Arsipkan Kegiatan (Archive)
        $archiveResponse = $this->actingAs($admin)->post(route('admin.penelitian.archive', $proposal), [
            'catatan_admin' => 'Laporan akhir selesai dan seluruh luaran tervalidasi.',
        ]);
        $archiveResponse->assertRedirect();
        $this->assertEquals('archive', $proposal->fresh()->status);
        $this->assertTrue($proposal->fresh()->isArchived());
    }

    public function test_admin_can_access_pengabdian_module_and_assign_reviewer(): void
    {
        $admin = User::where('role', 'admin')->first();
        $reviewer = User::where('role', 'reviewer')->first();
        $prodi = Prodi::first();
        $dosen = User::where('role', 'dosen')->first();

        $proposal = Proposal::create([
            'kode_usulan' => 'PKM-TEST-001',
            'jenis' => 'pengabdian',
            'judul' => 'Pendampingan Standar Keselamatan Bengkel Motor Pantura',
            'abstrak' => 'Abstrak pengabdian keselamatan berkendara.',
            'prodi_id' => $prodi->id,
            'user_id' => $dosen->id,
            'tahun_anggaran' => 2026,
            'skema' => 'Pengabdian Masyarakat',
            'sumber_dana' => 'DIPA PKTJ',
            'total_anggaran' => 25000000,
            'status' => 'diajukan',
        ]);

        // 1. Akses halaman PkM
        $indexResponse = $this->actingAs($admin)->get(route('admin.pengabdian.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Pendampingan Standar Keselamatan Bengkel Motor Pantura');

        // 2. Penugasan reviewer PkM
        $assignResponse = $this->actingAs($admin)->post(route('admin.pengabdian.assign-reviewer', $proposal), [
            'reviewer_id' => $reviewer->id,
        ]);
        $assignResponse->assertRedirect();
        $this->assertEquals('sedang_direview', $proposal->fresh()->status);

        // 3. Arsipkan PkM
        $archiveResponse = $this->actingAs($admin)->post(route('admin.pengabdian.archive', $proposal));
        $archiveResponse->assertRedirect();
        $this->assertEquals('archive', $proposal->fresh()->status);
    }
}
