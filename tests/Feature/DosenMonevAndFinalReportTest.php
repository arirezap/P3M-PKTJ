<?php

namespace Tests\Feature;

use App\Models\Prodi;
use App\Models\Proposal;
use App\Models\ProposalBudget;
use App\Models\ProposalFinalReport;
use App\Models\ProposalMonev;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DosenMonevAndFinalReportTest extends TestCase
{
    use RefreshDatabase;

    protected User $dosen;

    protected User $otherDosen;

    protected Prodi $prodi;

    protected Proposal $proposal;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->prodi = Prodi::create([
            'kode_prodi' => 'TRO',
            'nama_prodi' => 'Teknologi Rekayasa Otomotif',
            'jenjang' => 'D4',
        ]);

        $this->dosen = User::create([
            'name' => 'Dr. Ir. Hendro Wibowo, M.T.',
            'email' => 'dosen.hendro@pktj.ac.id',
            'password' => bcrypt('password'),
            'role' => 'dosen',
            'nidn_nip' => '0612048001',
            'prodi_id' => $this->prodi->id,
            'status_aktif' => true,
        ]);

        $this->otherDosen = User::create([
            'name' => 'Budi Santoso, S.T., M.Sc.',
            'email' => 'dosen.budi@pktj.ac.id',
            'password' => bcrypt('password'),
            'role' => 'dosen',
            'nidn_nip' => '0615028501',
            'prodi_id' => $this->prodi->id,
            'status_aktif' => true,
        ]);

        $this->proposal = Proposal::create([
            'kode_usulan' => 'PR-2026-TRO-001',
            'jenis' => 'penelitian',
            'judul' => 'Pengujian Efektivitas Sensor Rem Otomatis Bus Sekolah',
            'abstrak' => 'Uji coba lapangan sensor pada kendaraan bus sekolah...',
            'prodi_id' => $this->prodi->id,
            'user_id' => $this->dosen->id,
            'tahun_anggaran' => 2026,
            'skema' => 'Penelitian Terapan Vokasi',
            'sumber_dana' => 'DIPA PKTJ',
            'total_anggaran' => 25000000,
            'status' => 'diterima',
        ]);

        ProposalBudget::create([
            'proposal_id' => $this->proposal->id,
            'kategori_belanja' => 'bahan_habis_pakai',
            'uraian' => 'Modul Sensor Ultrasonik & Mikrokontroler',
            'volume' => 5,
            'satuan' => 'Unit',
            'harga_satuan' => 2000000,
            'total_harga' => 10000000,
        ]);

        ProposalBudget::create([
            'proposal_id' => $this->proposal->id,
            'kategori_belanja' => 'perjalanan_lapangan',
            'uraian' => 'Survei dan Pengujian Sirkuit',
            'volume' => 3,
            'satuan' => 'Hari',
            'harga_satuan' => 5000000,
            'total_harga' => 15000000,
        ]);
    }

    public function test_dosen_can_view_monev_form_when_proposal_accepted(): void
    {
        $response = $this->actingAs($this->dosen)
            ->get(route('dosen.proposals.monev.create', $this->proposal));

        $response->assertStatus(200);
        $response->assertSee('Instrumen Pemantauan dan Evaluasi (Monev)');
        $response->assertSee('7 Butir Indikator Capaian Kinerja');
        $response->assertSee('7 Butir Evaluasi Pelaksanaan Kegiatan');
    }

    public function test_dosen_cannot_access_monev_if_proposal_still_draft(): void
    {
        $this->proposal->update(['status' => 'draft']);

        $response = $this->actingAs($this->dosen)
            ->get(route('dosen.proposals.monev.create', $this->proposal));

        $response->assertRedirect(route('dosen.proposals.show', $this->proposal));
        $response->assertSessionHas('error');
    }

    public function test_other_dosen_cannot_access_monev_page(): void
    {
        $response = $this->actingAs($this->otherDosen)
            ->get(route('dosen.proposals.monev.create', $this->proposal));

        $response->assertStatus(403);
    }

    public function test_dosen_can_submit_monev_successfully(): void
    {
        $file = UploadedFile::fake()->create('bukti_luaran_monev.pdf', 1500, 'application/pdf');

        $payload = [
            'capaian_penelitian' => '50%',
            'publikasi_ilmiah' => 'submitted',
            'pemakalah_ilmiah' => 'mengirim_abstrak',
            'hki' => 'penyiapan_dokumen',
            'teknologi_tepat_guna' => 'desain_alat',
            'produk_purwarupa' => 'prototipe_awal',
            'buku_ajar' => 'draf_naskah',
            'kegiatan_terlaksana' => 'Pengadaan komponen sensor dan perakitan pada bus sekolah PKTJ.',
            'kesesuaian_waktu' => 'Pelaksanaan sesuai dengan jadwal matriks tahapan riset.',
            'kesesuaian_metode' => 'Menggunakan metode eksperimen langsung di sirkuit keselamatan PKTJ.',
            'kesesuaian_personalia' => 'Ketua memimpin pengujian, anggota dan taruna mencatat data telemetri.',
            'kesesuaian_anggaran' => 'Realisasi penyerapan dana telah mencapai 50% dari alokasi.',
            'kesesuaian_sarpras' => 'Fasilitas bengkel otomotif dan lintasan uji PKTJ sangat memadai.',
            'kesesuaian_target' => 'Target berjalan sesuai usulan awal tanpa kendala signifikan.',
            'file_bukti_luaran' => $file,
            'pernyataan_integritas' => '1',
        ];

        $response = $this->actingAs($this->dosen)
            ->post(route('dosen.proposals.monev.store', $this->proposal), $payload);

        $response->assertRedirect(route('dosen.proposals.monev.show', $this->proposal));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('proposal_monevs', [
            'proposal_id' => $this->proposal->id,
            'capaian_penelitian' => '50%',
            'publikasi_ilmiah' => 'submitted',
            'status_monev' => 'terkirim',
        ]);

        $this->assertEquals('pelaksanaan', $this->proposal->fresh()->status);
    }

    public function test_dosen_can_view_monev_show_page(): void
    {
        ProposalMonev::create([
            'proposal_id' => $this->proposal->id,
            'user_id' => $this->dosen->id,
            'capaian_penelitian' => '75%',
            'publikasi_ilmiah' => 'under_review',
            'pemakalah_ilmiah' => 'menyajikan_makalah',
            'hki' => 'pendaftaran_djki',
            'teknologi_tepat_guna' => 'uji_lapangan',
            'produk_purwarupa' => 'produk_teruji',
            'buku_ajar' => 'editing',
            'kegiatan_terlaksana' => 'Pengujian kecepatan respon pengereman.',
            'kesesuaian_waktu' => 'Sesuai timeline.',
            'kesesuaian_metode' => 'Metode uji standar ISO.',
            'kesesuaian_personalia' => 'Seluruh tim berkontribusi aktif.',
            'kesesuaian_anggaran' => 'Serapan 75%.',
            'kesesuaian_sarpras' => 'Sarpras lengkap.',
            'kesesuaian_target' => 'Target tercapai 75%.',
            'status_monev' => 'terkirim',
            'tanggal_monev' => now(),
        ]);

        $response = $this->actingAs($this->dosen)
            ->get(route('dosen.proposals.monev.show', $this->proposal));

        $response->assertStatus(200);
        $response->assertSee('Hasil Pemantauan dan Evaluasi (Monev)');
        $response->assertSee('Monev Terkirim ke P3M');
        $response->assertSee('Pengujian kecepatan respon pengereman.');
    }

    public function test_dosen_can_view_final_report_form_when_in_execution(): void
    {
        $this->proposal->update(['status' => 'pelaksanaan']);

        $response = $this->actingAs($this->dosen)
            ->get(route('dosen.proposals.final-report.create', $this->proposal));

        $response->assertStatus(200);
        $response->assertSee('Penyampaian Laporan Akhir Kegiatan');
        $response->assertSee('Realisasi Serapan Anggaran Biaya (100%)');
    }

    public function test_other_dosen_cannot_access_final_report_form(): void
    {
        $this->proposal->update(['status' => 'pelaksanaan']);

        $response = $this->actingAs($this->otherDosen)
            ->get(route('dosen.proposals.final-report.create', $this->proposal));

        $response->assertStatus(403);
    }

    public function test_dosen_can_submit_final_report_successfully(): void
    {
        $this->proposal->update(['status' => 'pelaksanaan']);

        $laporanFile = UploadedFile::fake()->create('laporan_akhir_lengkap.pdf', 3000, 'application/pdf');
        $spjFile = UploadedFile::fake()->create('bukti_spj_rekap.pdf', 2000, 'application/pdf');

        $payload = [
            'file_laporan_akhir' => $laporanFile,
            'ringkasan_hasil' => 'Penelitian menghasilkan sistem rem cerdas berbasis sensor dengan waktu henti 30% lebih cepat.',
            'perubahan_anggota' => 'Tidak ada perubahan susunan anggota.',
            'file_bukti_spj' => $spjFile,
            'realisasi' => [
                [
                    'kategori' => 'bahan_habis_pakai',
                    'uraian' => 'Modul Sensor Ultrasonik & Mikrokontroler',
                    'anggaran_usulan' => 10000000,
                    'realisasi' => 9800000,
                    'keterangan' => 'Sesuai nota pembelian toko elektro',
                ],
                [
                    'kategori' => 'perjalanan_lapangan',
                    'uraian' => 'Survei dan Pengujian Sirkuit',
                    'anggaran_usulan' => 15000000,
                    'realisasi' => 15000000,
                    'keterangan' => 'Kuitansi sewa lintasan & BBM',
                ],
            ],
            'luaran' => [
                'jurnal' => [
                    'nama_jurnal' => 'Jurnal Keselamatan Transportasi Jalan (Sinta 2)',
                    'doi_url' => 'https://doi.org/10.1234/jktj.2026.01',
                ],
                'hki' => [
                    'judul_hki' => 'Paten Sederhana Perangkat Rem Otomatis',
                    'nomor_hki' => 'S00202601234',
                ],
            ],
            'pernyataan_keaslian' => '1',
        ];

        $response = $this->actingAs($this->dosen)
            ->post(route('dosen.proposals.final-report.store', $this->proposal), $payload);

        $response->assertRedirect(route('dosen.proposals.final-report.show', $this->proposal));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('proposal_final_reports', [
            'proposal_id' => $this->proposal->id,
            'total_realisasi_anggaran' => 24800000.00,
            'status_laporan' => 'terkirim',
        ]);

        $this->assertEquals('laporan_akhir', $this->proposal->fresh()->status);
    }

    public function test_dosen_can_upload_revision_for_final_report(): void
    {
        $report = ProposalFinalReport::create([
            'proposal_id' => $this->proposal->id,
            'user_id' => $this->dosen->id,
            'file_laporan_akhir' => 'final_reports/dummy.pdf',
            'total_realisasi_anggaran' => 25000000,
            'status_laporan' => 'revisi',
            'catatan_reviewer' => 'Mohon tambahkan grafik komparasi pengujian lintasan basah pada Bab 4.',
            'tanggal_penyerahan' => now(),
        ]);

        $revisionFile = UploadedFile::fake()->create('laporan_akhir_revisi.pdf', 3500, 'application/pdf');

        $response = $this->actingAs($this->dosen)
            ->post(route('dosen.proposals.final-report.revision', $this->proposal), [
                'file_revisi_laporan' => $revisionFile,
            ]);

        $response->assertRedirect(route('dosen.proposals.final-report.show', $this->proposal));
        $response->assertSessionHas('success');

        $this->assertEquals('proses_review', $report->fresh()->status_laporan);
        $this->assertNotNull($report->fresh()->file_revisi_laporan);
    }
}
