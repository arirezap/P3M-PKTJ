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
        $response->assertSee('Formulir Pendaftaran Proposal Usulan');
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

    public function test_dosen_can_save_and_update_extended_attributes_and_external_members(): void
    {
        Storage::fake('public');

        $partnerFile = UploadedFile::fake()->create('surat_mitra.pdf', 300, 'application/pdf');

        $payload = [
            'jenis' => 'penelitian',
            'judul' => 'Pengembangan Sistem Telematika dan Deteksi Blindspot Terpadu',
            'abstrak' => 'Penelitian ini mengembangkan algoritma deteksi dini blind spot...',
            'kata_kunci' => 'telematika, blindspot, keselamatan jalan',
            'bidang_fokus' => 'Keselamatan & Rekayasa Otomotif',
            'lama_kegiatan_tahun' => 2,
            'topik_kegiatan' => 'Deteksi Blindspot Angkutan Umum',
            'lokasi_kegiatan' => 'Koridor Pantura Kota Tegal',
            'bank_nama' => 'Bank Mandiri',
            'bank_rekening' => '137-00-1234567-8',
            'bank_pemilik' => 'Dr. Ir. Hendro Wibowo, M.T.',
            'nama_mitra' => 'Dinas Perhubungan Kota Tegal',
            'kontribusi_mitra' => 'Penyediaan 3 unit bus uji coba',
            'file_mitra' => $partnerFile,
            'prodi_id' => $this->prodi->id,
            'skema' => 'Penelitian Terapan Vokasi Keselamatan Transportasi',
            'tahun_anggaran' => 2026,
            'sumber_dana' => 'DIPA PKTJ',
            'action_type' => 'draft',
            'members' => [
                [
                    'nama' => 'Dr. Bambang Sutrisno, M.Sc.',
                    'peran' => 'dosen_anggota',
                    'kategori_anggota' => 'eksternal',
                    'asal_instansi' => 'Institut Teknologi Bandung',
                    'negara' => 'Indonesia',
                    'nidn_nim' => '0011223344',
                    'tugas' => 'Reviewer algoritma sinyal telematika',
                ],
                [
                    'nama' => 'Taruna Gilang Ramadhan',
                    'peran' => 'mahasiswa',
                    'kategori_anggota' => 'taruna',
                    'asal_instansi' => 'Politeknik Keselamatan Transportasi Jalan',
                    'negara' => 'Indonesia',
                    'nidn_nim' => '2203001',
                    'tugas' => 'Pengambilan data sensor di bus',
                ],
            ],
            'budgets' => [
                [
                    'kategori_belanja' => 'bahan_habis_pakai',
                    'uraian' => 'Modul LiDAR Sensor dan Kabel Uji',
                    'volume' => 3,
                    'satuan' => 'Unit',
                    'harga_satuan' => 2500000,
                ],
            ],
        ];

        // 1. Simpan usulan dengan atribut lengkap
        $response = $this->actingAs($this->dosen)->post(route('dosen.proposals.store'), $payload);

        $proposal = Proposal::first();
        $this->assertNotNull($proposal);
        $this->assertEquals('telematika, blindspot, keselamatan jalan', $proposal->kata_kunci);
        $this->assertEquals('Keselamatan & Rekayasa Otomotif', $proposal->bidang_fokus);
        $this->assertEquals(2, $proposal->lama_kegiatan_tahun);
        $this->assertEquals('Bank Mandiri', $proposal->bank_nama);
        $this->assertEquals('Dinas Perhubungan Kota Tegal', $proposal->nama_mitra);
        $this->assertNotNull($proposal->file_mitra);
        Storage::disk('public')->assertExists($proposal->file_mitra);

        $this->assertCount(2, $proposal->members);
        $externalMember = $proposal->members()->where('kategori_anggota', 'eksternal')->first();
        $this->assertNotNull($externalMember);
        $this->assertEquals('Institut Teknologi Bandung', $externalMember->asal_instansi);

        // 2. Tampilkan halaman show dan periksa elemen render
        $showResponse = $this->actingAs($this->dosen)->get(route('dosen.proposals.show', $proposal));
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Keselamatan &amp; Rekayasa Otomotif', false);
        $showResponse->assertSee('Bank Mandiri');
        $showResponse->assertSee('Dinas Perhubungan Kota Tegal');
        $showResponse->assertSee('Institut Teknologi Bandung');

        // 3. Update usulan
        $updatePayload = $payload;
        $updatePayload['judul'] = 'Judul Hasil Pembaruan Sistem Telematika';
        $updatePayload['bank_nama'] = 'Bank BRI';
        $updatePayload['lama_kegiatan_tahun'] = 3;

        $updateResponse = $this->actingAs($this->dosen)->put(route('dosen.proposals.update', $proposal), $updatePayload);
        $updateResponse->assertRedirect(route('dosen.proposals.show', $proposal));

        $proposal->refresh();
        $this->assertEquals('Judul Hasil Pembaruan Sistem Telematika', $proposal->judul);
        $this->assertEquals('Bank BRI', $proposal->bank_nama);
        $this->assertEquals(3, $proposal->lama_kegiatan_tahun);
    }

    public function test_dosen_can_create_proposal_with_complete_8_submenus_data(): void
    {
        Storage::fake('public');

        $pdfFile = UploadedFile::fake()->create('naskah_usulan.pdf', 500, 'application/pdf');
        $mitraFile = UploadedFile::fake()->create('surat_mitra.pdf', 300, 'application/pdf');

        $payload = [
            'jenis' => 'penelitian',
            'judul' => 'Pengembangan Sistem Sensor Cerdas Otomasi Rem Bus Vokasi',
            'abstrak' => 'Ringkasan komprehensif pengujian sistem sensor otomatis...',
            'prodi_id' => $this->prodi->id,
            'skema' => 'Penelitian Terapan Vokasi Keselamatan Transportasi',
            'tahun_anggaran' => 2026,
            'sumber_dana' => 'DIPA PKTJ',
            'kata_kunci' => 'sensor, rem otomatis, vokasi transportasi',
            'bidang_fokus' => 'Keselamatan & Rekayasa Transportasi Jalan',
            'lama_kegiatan_tahun' => 2,
            'topik_kegiatan' => 'Pencegahan blind spot armada angkutan',
            'lokasi_kegiatan' => 'Jalur Uji Coba PKTJ Tegal',
            'bank_nama' => 'Bank BNI',
            'bank_rekening' => '9876543210',
            'bank_pemilik' => 'Dr. Ir. Hendro Wibowo, M.T.',
            'nama_berkas_proposal' => 'Proposal_Sensor_Rem_2026.pdf',
            'file_proposal' => $pdfFile,
            'nama_mitra' => 'PT Trans Transportasi Indonesia',
            'kontribusi_mitra' => 'Penyediaan armada pengujian lapangan',
            'dana_mitra' => 15000000,
            'dana_tambahan' => 5000000,
            'file_mitra' => $mitraFile,
            'action_type' => 'diajukan',
            'persetujuan_konfirmasi' => 1,
            'members' => [
                [
                    'nama' => 'Budi Santoso, S.T., M.Sc.',
                    'peran' => 'dosen_anggota',
                    'kategori_anggota' => 'internal',
                    'nidn_nim' => '0615028501',
                    'tugas' => 'Analisis data telematika',
                ],
                [
                    'nama' => 'Taruna Bintang',
                    'peran' => 'mahasiswa',
                    'kategori_anggota' => 'taruna',
                    'nidn_nim' => '2201099',
                    'tugas' => 'Pengujian instrumen sensor lapangan',
                ],
            ],
            'luaran_target' => [
                ['jenis' => 'Jurnal Nasional', 'keterangan' => 'Artikel terakreditasi Sinta 2'],
                ['jenis' => 'HKI', 'keterangan' => 'Hak Cipta program kontrol rem otomatis'],
            ],
            'budgets' => [
                [
                    'kategori_belanja' => 'bahan_habis_pakai',
                    'tahun_ke' => 1,
                    'uraian' => 'Modul Sensor Jarak & Mikrokontroler',
                    'volume' => 3,
                    'satuan' => 'Unit',
                    'harga_satuan' => 2000000,
                ],
                [
                    'kategori_belanja' => 'perjalanan_lapangan',
                    'tahun_ke' => 2,
                    'uraian' => 'Survei Uji Lapangan Armada',
                    'volume' => 2,
                    'satuan' => 'Hari',
                    'harga_satuan' => 2500000,
                ],
            ],
            'jadwal_kegiatan' => [
                [
                    'nama_kegiatan' => 'Tahap 1: Perakitan Sensor & Pengujian Lab',
                    'tahun' => 1,
                    'tanggal_mulai' => '2026-03-01',
                    'tanggal_selesai' => '2026-06-30',
                ],
                [
                    'nama_kegiatan' => 'Tahap 2: Pengujian Lapangan & Evaluasi Hasil',
                    'tahun' => 2,
                    'tanggal_mulai' => '2026-07-01',
                    'tanggal_selesai' => '2026-11-30',
                ],
            ],
        ];

        $response = $this->actingAs($this->dosen)->post(route('dosen.proposals.store'), $payload);

        $proposal = Proposal::where('judul', $payload['judul'])->first();
        $this->assertNotNull($proposal);
        $this->assertEquals('diajukan', $proposal->status);
        $this->assertEquals(11000000, $proposal->total_anggaran); // (3*2jt) + (2*2.5jt) = 11jt
        $this->assertEquals('Proposal_Sensor_Rem_2026.pdf', $proposal->nama_berkas_proposal);
        $this->assertEquals(15000000, $proposal->dana_mitra);
        $this->assertEquals(5000000, $proposal->dana_tambahan);
        $this->assertTrue($proposal->persetujuan_konfirmasi);
        $this->assertCount(2, $proposal->luaran_target);
        $this->assertCount(2, $proposal->jadwal_kegiatan);
        $this->assertCount(2, $proposal->members);
        $this->assertCount(2, $proposal->budgets);

        $response->assertRedirect(route('dosen.proposals.show', $proposal));

        // Verifikasi tampilan detail proposal
        $showResponse = $this->actingAs($this->dosen)->get(route('dosen.proposals.show', $proposal));
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Artikel terakreditasi Sinta 2');
        $showResponse->assertSee('Tahap 1: Perakitan Sensor');
        $showResponse->assertSee('1. Terkirim');
        $showResponse->assertSee('2. Proses Review');
    }

    public function test_dosen_dashboard_filters_by_tabs(): void
    {
        Proposal::create([
            'kode_usulan' => 'PR-2026-TRO-101',
            'jenis' => 'penelitian',
            'judul' => 'Riset Keselamatan Kendaraan',
            'prodi_id' => $this->prodi->id,
            'user_id' => $this->dosen->id,
            'tahun_anggaran' => 2026,
            'skema' => 'Penelitian Terapan',
            'status' => 'draft',
        ]);

        Proposal::create([
            'kode_usulan' => 'PKM-2026-TRO-102',
            'jenis' => 'pengabdian',
            'judul' => 'Pengabdian Sosialisasi Tertib Lalu Lintas',
            'prodi_id' => $this->prodi->id,
            'user_id' => $this->dosen->id,
            'tahun_anggaran' => 2026,
            'skema' => 'Pengabdian Kemitraan Masyarakat',
            'status' => 'diajukan',
        ]);

        // Tab Semua
        $resSemua = $this->actingAs($this->dosen)->get(route('dosen.dashboard', ['tab' => 'semua']));
        $resSemua->assertStatus(200);
        $resSemua->assertSee('Riset Keselamatan Kendaraan');
        $resSemua->assertSee('Pengabdian Sosialisasi Tertib Lalu Lintas');

        // Tab Penelitian
        $resPenelitian = $this->actingAs($this->dosen)->get(route('dosen.dashboard', ['tab' => 'penelitian']));
        $resPenelitian->assertStatus(200);
        $resPenelitian->assertSee('Riset Keselamatan Kendaraan');
        $resPenelitian->assertDontSee('Pengabdian Sosialisasi Tertib Lalu Lintas');

        // Tab Pengabdian
        $resPengabdian = $this->actingAs($this->dosen)->get(route('dosen.dashboard', ['tab' => 'pengabdian']));
        $resPengabdian->assertStatus(200);
        $resPengabdian->assertDontSee('Riset Keselamatan Kendaraan');
        $resPengabdian->assertSee('Pengabdian Sosialisasi Tertib Lalu Lintas');
    }
}
