<?php

namespace Tests\Feature;

use App\Models\Prodi;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DosenProposalTest extends TestCase
{
    use RefreshDatabase;

    protected User $dosen;
    protected User $otherDosen;
    protected Prodi $prodi;

    protected function setUp(): void
    {
        parent::setUp();

        $this->prodi = Prodi::create([
            'kode_prodi' => 'TRO',
            'nama_prodi' => 'Teknologi Rekayasa Otomotif',
            'jenjang' => 'D4',
        ]);

        $this->dosen = User::create([
            'name' => 'Dr. Ir. Hendro Wibowo, M.T.',
            'email' => 'dosen@pktj.ac.id',
            'password' => bcrypt('password'),
            'role' => 'dosen',
            'nidn_nip' => '0612048001',
            'prodi_id' => $this->prodi->id,
            'status_aktif' => true,
        ]);

        $this->otherDosen = User::create([
            'name' => 'Budi Santoso, S.T., M.Sc.',
            'email' => 'budi@pktj.ac.id',
            'password' => bcrypt('password'),
            'role' => 'dosen',
            'nidn_nip' => '0615028501',
            'prodi_id' => $this->prodi->id,
            'status_aktif' => true,
        ]);
    }

    public function test_dosen_can_view_create_proposal_page(): void
    {
        $response = $this->actingAs($this->dosen)->get(route('dosen.proposals.create'));
        $response->assertStatus(200);
        $response->assertSee('Formulir Pengajuan Usulan Baru');
        $response->assertSee('Teknologi Rekayasa Otomotif');
    }

    public function test_dosen_can_save_draft_proposal_with_members_and_budgets(): void
    {
        $payload = [
            'jenis' => 'penelitian',
            'judul' => 'Pengujian Efektivitas Sistem Sensor Rem Cerdas pada Kendaraan Vokasi',
            'abstrak' => 'Ringkasan pengujian sensor otomatis keselamatan transportasi...',
            'prodi_id' => $this->prodi->id,
            'skema' => 'Penelitian Terapan Vokasi Keselamatan Transportasi',
            'tahun_anggaran' => 2026,
            'sumber_dana' => 'DIPA PKTJ',
            'action_type' => 'draft',
            'members' => [
                [
                    'nama' => 'Budi Santoso, S.T., M.Sc.',
                    'peran' => 'dosen_anggota',
                    'nidn_nim' => '0615028501',
                    'tugas' => 'Analisis data lapangan',
                ],
                [
                    'nama' => 'Ahmad Taruna',
                    'peran' => 'mahasiswa',
                    'nidn_nim' => '2201001',
                    'tugas' => 'Membantu pengujian alat',
                ],
            ],
            'budgets' => [
                [
                    'kategori_belanja' => 'bahan_habis_pakai',
                    'uraian' => 'Kertas & Sensor Pengujian',
                    'volume' => 2,
                    'satuan' => 'Paket',
                    'harga_satuan' => 1500000,
                ],
                [
                    'kategori_belanja' => 'perjalanan_lapangan',
                    'uraian' => 'Survei Jalur Pantura',
                    'volume' => 1,
                    'satuan' => 'Hari',
                    'harga_satuan' => 2000000,
                ],
            ],
        ];

        $response = $this->actingAs($this->dosen)->post(route('dosen.proposals.store'), $payload);

        $proposal = Proposal::first();
        $this->assertNotNull($proposal);
        $this->assertEquals('draft', $proposal->status);
        $this->assertEquals(5000000, $proposal->total_anggaran); // (2*1.5jt) + (1*2jt) = 5jt
        $this->assertCount(2, $proposal->members);
        $this->assertCount(2, $proposal->budgets);

        $response->assertRedirect(route('dosen.proposals.show', $proposal));
    }

    public function test_dosen_can_submit_proposal_with_pdf_file(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('proposal_riset.pdf', 1000, 'application/pdf');

        $payload = [
            'jenis' => 'penelitian',
            'judul' => 'Inovasi Detektor Titik Buta (Blind Spot) Berbasis Kecerdasan Buatan',
            'abstrak' => 'Studi eksperimental sensor jarak blind spot...',
            'prodi_id' => $this->prodi->id,
            'skema' => 'Penelitian Terapan Vokasi Keselamatan Transportasi',
            'tahun_anggaran' => 2026,
            'sumber_dana' => 'DIPA PKTJ',
            'action_type' => 'diajukan',
            'file_proposal' => $file,
            'budgets' => [
                [
                    'kategori_belanja' => 'bahan_habis_pakai',
                    'uraian' => 'Komponen Mikrokontroler',
                    'volume' => 1,
                    'satuan' => 'Paket',
                    'harga_satuan' => 3000000,
                ],
            ],
        ];

        $response = $this->actingAs($this->dosen)->post(route('dosen.proposals.store'), $payload);

        $proposal = Proposal::first();
        $this->assertNotNull($proposal);
        $this->assertEquals('diajukan', $proposal->status);
        $this->assertNotNull($proposal->file_proposal);
        Storage::disk('public')->assertExists($proposal->file_proposal);

        $response->assertRedirect(route('dosen.proposals.show', $proposal));
    }

    public function test_dosen_can_view_own_proposal_detail_and_tracker(): void
    {
        $proposal = Proposal::create([
            'kode_usulan' => 'PR-2026-TRO-001',
            'jenis' => 'penelitian',
            'judul' => 'Riset Sistem Keselamatan Armada',
            'prodi_id' => $this->prodi->id,
            'user_id' => $this->dosen->id,
            'tahun_anggaran' => 2026,
            'skema' => 'Penelitian Terapan Vokasi',
            'status' => 'verifikasi_administrasi',
            'total_anggaran' => 10000000,
        ]);

        $response = $this->actingAs($this->dosen)->get(route('dosen.proposals.show', $proposal));
        $response->assertStatus(200);
        $response->assertSee('PR-2026-TRO-001');
        $response->assertSee('Tahapan Alur Seleksi Proposal');
        $response->assertSee('Lolos Berkas Administrasi');
    }

    public function test_dosen_cannot_view_other_dosens_proposal(): void
    {
        $proposal = Proposal::create([
            'kode_usulan' => 'PR-2026-TRO-002',
            'jenis' => 'penelitian',
            'judul' => 'Usulan Dosen Lain',
            'prodi_id' => $this->prodi->id,
            'user_id' => $this->otherDosen->id,
            'tahun_anggaran' => 2026,
            'skema' => 'Penelitian Terapan Vokasi',
            'status' => 'diajukan',
        ]);

        $response = $this->actingAs($this->dosen)->get(route('dosen.proposals.show', $proposal));
        $response->assertStatus(403);
    }

    public function test_dosen_can_submit_draft_proposal(): void
    {
        Storage::fake('public');
        $filePath = UploadedFile::fake()->create('proposal.pdf', 500, 'application/pdf')->store('proposals', 'public');

        $proposal = Proposal::create([
            'kode_usulan' => 'PR-2026-TRO-003',
            'jenis' => 'penelitian',
            'judul' => 'Draf Usulan yang Mau Dikirim',
            'prodi_id' => $this->prodi->id,
            'user_id' => $this->dosen->id,
            'tahun_anggaran' => 2026,
            'skema' => 'Penelitian Terapan Vokasi',
            'status' => 'draft',
            'file_proposal' => $filePath,
        ]);

        $response = $this->actingAs($this->dosen)->post(route('dosen.proposals.submit', $proposal));

        $proposal->refresh();
        $this->assertEquals('diajukan', $proposal->status);
        $response->assertRedirect(route('dosen.proposals.show', $proposal));
    }

    public function test_dosen_can_upload_revision_when_status_is_revisi(): void
    {
        Storage::fake('public');

        $proposal = Proposal::create([
            'kode_usulan' => 'PR-2026-TRO-004',
            'jenis' => 'penelitian',
            'judul' => 'Usulan Memerlukan Revisi',
            'prodi_id' => $this->prodi->id,
            'user_id' => $this->dosen->id,
            'tahun_anggaran' => 2026,
            'skema' => 'Penelitian Terapan Vokasi',
            'status' => 'revisi',
            'catatan_admin' => 'Perbaiki rincian anggaran honorarium',
        ]);

        $revisionFile = UploadedFile::fake()->create('revisi_proposal.pdf', 600, 'application/pdf');

        $response = $this->actingAs($this->dosen)->post(route('dosen.proposals.upload-revision', $proposal), [
            'file_revisi' => $revisionFile,
        ]);

        $proposal->refresh();
        $this->assertEquals('sedang_direview', $proposal->status);
        $this->assertNotNull($proposal->file_revisi);
        Storage::disk('public')->assertExists($proposal->file_revisi);

        $response->assertRedirect(route('dosen.proposals.show', $proposal));
    }
}
