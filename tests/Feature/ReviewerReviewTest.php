<?php

namespace Tests\Feature;

use App\Models\Prodi;
use App\Models\Proposal;
use App\Models\ProposalFinalReport;
use App\Models\ProposalMonev;
use App\Models\ProposalReview;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ReviewerReviewTest extends TestCase
{
    use RefreshDatabase;

    protected User $reviewer;

    protected User $otherReviewer;

    protected User $dosen;

    protected Prodi $prodi;

    protected Proposal $proposalPenelitian;

    protected Proposal $proposalPengabdian;

    protected ProposalReview $reviewPenelitian;

    protected ProposalReview $reviewPengabdian;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->prodi = Prodi::create([
            'kode_prodi' => 'RSTJ',
            'nama_prodi' => 'Rekayasa Sistem Transportasi Jalan',
            'jenjang' => 'D4',
        ]);

        $this->dosen = User::create([
            'name' => 'Dr. Bambang Kusumo, M.T.',
            'email' => 'dosen.bambang@pktj.ac.id',
            'password' => bcrypt('password'),
            'role' => 'dosen',
            'prodi_id' => $this->prodi->id,
            'status_aktif' => true,
        ]);

        $this->reviewer = User::create([
            'name' => 'Prof. Dr. Ir. Suyitno, M.Sc.',
            'email' => 'reviewer.suyitno@pktj.ac.id',
            'password' => bcrypt('password'),
            'role' => 'reviewer',
            'prodi_id' => $this->prodi->id,
            'status_aktif' => true,
        ]);

        $this->otherReviewer = User::create([
            'name' => 'Dr. Ahmad Fauzi, M.T.',
            'email' => 'reviewer.fauzi@pktj.ac.id',
            'password' => bcrypt('password'),
            'role' => 'reviewer',
            'prodi_id' => $this->prodi->id,
            'status_aktif' => true,
        ]);

        // Proposal Penelitian
        $this->proposalPenelitian = Proposal::create([
            'kode_usulan' => 'PR-2026-RSTJ-001',
            'jenis' => 'penelitian',
            'judul' => 'Audit Keselamatan Geometrik Jalan Lingkar Kota Tegal',
            'prodi_id' => $this->prodi->id,
            'user_id' => $this->dosen->id,
            'tahun_anggaran' => 2026,
            'skema' => 'Penelitian Terapan Vokasi',
            'status' => 'sedang_direview',
            'total_anggaran' => 25000000,
        ]);

        $this->reviewPenelitian = ProposalReview::create([
            'proposal_id' => $this->proposalPenelitian->id,
            'reviewer_id' => $this->reviewer->id,
            'status_review' => 'menunggu',
        ]);

        // Proposal Pengabdian kepada Masyarakat (PkM)
        $this->proposalPengabdian = Proposal::create([
            'kode_usulan' => 'PKM-2026-RSTJ-001',
            'jenis' => 'pengabdian',
            'judul' => 'Pelatihan Keselamatan Berkendara bagi Pengemudi Angkutan Umum Tegal',
            'prodi_id' => $this->prodi->id,
            'user_id' => $this->dosen->id,
            'tahun_anggaran' => 2026,
            'skema' => 'Pengabdian Kemitraan Vokasi',
            'status' => 'sedang_direview',
            'total_anggaran' => 15000000,
        ]);

        $this->reviewPengabdian = ProposalReview::create([
            'proposal_id' => $this->proposalPengabdian->id,
            'reviewer_id' => $this->reviewer->id,
            'status_review' => 'menunggu',
        ]);
    }

    public function test_reviewer_can_view_evaluation_page_with_research_rubric_5_criteria(): void
    {
        $response = $this->actingAs($this->reviewer)
            ->get(route('reviewer.reviews.show', $this->reviewPenelitian));

        $response->assertStatus(200);
        $response->assertSee('PR-2026-RSTJ-001');
        $response->assertSee('Rubrik Penelitian (5 Kriteria)');
        $response->assertSee('Perumusan Masalah, Tujuan, dan Peta Jalan');
        $response->assertSee('Luaran (Proses dan Produk)');
        $response->assertSee('Tinjauan Pustaka');
        $response->assertSee('Metode Penelitian');
        $response->assertSee('Kelayakan Pelaksanaan');
        $response->assertSee('Bobot: 35%');
    }

    public function test_reviewer_can_view_evaluation_page_with_community_service_rubric_6_criteria(): void
    {
        $response = $this->actingAs($this->reviewer)
            ->get(route('reviewer.reviews.show', $this->reviewPengabdian));

        $response->assertStatus(200);
        $response->assertSee('PKM-2026-RSTJ-001');
        $response->assertSee('Rubrik Pengabdian (6 Kriteria)');
        $response->assertSee('Analisis Situasi');
        $response->assertSee('Permasalahan Prioritas & Solusi');
        $response->assertSee('Target Luaran');
        $response->assertSee('Ketepatan Metode Pendekatan');
        $response->assertSee('Kelayakan Institusi Perguruan Tinggi');
        $response->assertSee('Kelayakan Usulan Anggaran Biaya');
    }

    public function test_reviewer_cannot_view_evaluation_page_assigned_to_another_reviewer(): void
    {
        $response = $this->actingAs($this->otherReviewer)
            ->get(route('reviewer.reviews.show', $this->reviewPenelitian));

        $response->assertStatus(403);
    }

    public function test_reviewer_submits_scores_using_standard_1_to_7_scale_for_research(): void
    {
        // Kriteria Penelitian: 15%, 35%, 15%, 20%, 15%
        // Skor: 6, 7, 6, 7, 6 -> (6*0.15) + (7*0.35) + (6*0.15) + (7*0.20) + (6*0.15)
        // = 0.90 + 2.45 + 0.90 + 1.40 + 0.90 = 6.55
        $payload = [
            'kriteria_1' => 6,
            'kriteria_2' => 7,
            'kriteria_3' => 6,
            'kriteria_4' => 7,
            'kriteria_5' => 6,
            'rekomendasi' => 'diterima',
            'catatan_reviewer' => 'Metode riset dan rancangan pengujian lapangan sangat komprehensif serta relevan.',
            'persetujuan_komitmen' => '1',
        ];

        $response = $this->actingAs($this->reviewer)
            ->put(route('reviewer.reviews.update', $this->reviewPenelitian), $payload);

        $response->assertRedirect(route('reviewer.reviews.show', $this->reviewPenelitian));
        $response->assertSessionHas('success');

        $this->reviewPenelitian->refresh();
        $this->assertEquals('selesai', $this->reviewPenelitian->status_review);
        $this->assertEquals(6.55, (float) $this->reviewPenelitian->total_skor);
        $this->assertEquals('diterima', $this->reviewPenelitian->rekomendasi);
        $this->assertNotNull($this->reviewPenelitian->tanggal_review);
        $this->assertIsArray($this->reviewPenelitian->detail_nilai);
    }

    public function test_submitting_with_revision_recommendation_updates_proposal_status_to_revisi(): void
    {
        $fileRevisi = UploadedFile::fake()->create('catatan_revisi_reviewer.pdf', 500, 'application/pdf');

        $payload = [
            'kriteria_1' => 5,
            'kriteria_2' => 5,
            'kriteria_3' => 3,
            'kriteria_4' => 5,
            'kriteria_5' => 5,
            'rekomendasi' => 'revisi',
            'catatan_reviewer' => 'Harap perbaiki tinjauan pustaka jurnal 5 tahun terakhir dan perbaiki rincian RAB.',
            'file_catatan_revisi' => $fileRevisi,
            'persetujuan_komitmen' => '1',
        ];

        $response = $this->actingAs($this->reviewer)
            ->put(route('reviewer.reviews.update', $this->reviewPenelitian), $payload);

        $response->assertRedirect(route('reviewer.reviews.show', $this->reviewPenelitian));

        $this->reviewPenelitian->refresh();
        $this->assertEquals('revisi', $this->reviewPenelitian->rekomendasi);
        $this->assertNotNull($this->reviewPenelitian->file_catatan_revisi);

        $this->proposalPenelitian->refresh();
        $this->assertEquals('revisi', $this->proposalPenelitian->status);
        $this->assertEquals($payload['catatan_reviewer'], $this->proposalPenelitian->catatan_admin);
    }

    public function test_submitting_invalid_score_such_as_4_is_rejected(): void
    {
        // Skor 4 sengaja ditiadakan dalam PRD 7.1
        $payload = [
            'kriteria_1' => 4, // Invalid: skor 4 dilarang
            'kriteria_2' => 7,
            'kriteria_3' => 6,
            'kriteria_4' => 7,
            'kriteria_5' => 6,
            'rekomendasi' => 'diterima',
            'catatan_reviewer' => 'Catatan evaluasi cukup panjang.',
            'persetujuan_komitmen' => '1',
        ];

        $response = $this->actingAs($this->reviewer)
            ->put(route('reviewer.reviews.update', $this->reviewPenelitian), $payload);

        $response->assertSessionHasErrors(['kriteria_1']);
    }

    public function test_reviewer_can_evaluate_monev_instrument(): void
    {
        $monev = ProposalMonev::create([
            'proposal_id' => $this->proposalPenelitian->id,
            'user_id' => $this->dosen->id,
            'capaian_penelitian' => '50%',
            'publikasi_ilmiah' => 'submitted',
            'pemakalah_ilmiah' => 'mengirim_abstrak',
            'hki' => 'penyiapan_dokumen',
            'teknologi_tepat_guna' => 'desain_alat',
            'produk_purwarupa' => 'prototipe_awal',
            'buku_ajar' => 'draf_naskah',
            'kegiatan_terlaksana' => 'Pengujian sensor di lapangan.',
            'kesesuaian_waktu' => 'Sesuai timeline.',
            'kesesuaian_metode' => 'Metode sesuai usulan.',
            'kesesuaian_personalia' => 'Personalia aktif.',
            'kesesuaian_anggaran' => 'Serapan 50%.',
            'kesesuaian_sarpras' => 'Sarpras lengkap.',
            'kesesuaian_target' => 'Target tercapai.',
            'status_monev' => 'terkirim',
            'tanggal_monev' => now(),
        ]);

        // Cek akses halaman monev
        $resShow = $this->actingAs($this->reviewer)
            ->get(route('reviewer.reviews.monev.show', $this->reviewPenelitian));
        $resShow->assertStatus(200);
        $resShow->assertSee('Evaluasi Pemantauan dan Evaluasi (Monev)');
        $resShow->assertSee('Pengujian sensor di lapangan.');

        // Reviewer submit skor monev (bobot: 25, 20, 10, 5, 10, 20, 10)
        // Skor: 6, 7, 6, 5, 6, 7, 5
        // (6*0.25) + (7*0.20) + (6*0.10) + (5*0.05) + (6*0.10) + (7*0.20) + (5*0.10)
        // = 1.50 + 1.40 + 0.60 + 0.25 + 0.60 + 1.40 + 0.50 = 6.25
        $payloadMonev = [
            'monev_1' => 6,
            'monev_2' => 7,
            'monev_3' => 6,
            'monev_4' => 5,
            'monev_5' => 6,
            'monev_6' => 7,
            'monev_7' => 5,
            'catatan_reviewer' => 'Kemajuan capaian monev sangat baik, segera finalisasi naskah publikasi menuju laporan akhir.',
        ];

        $resUpdate = $this->actingAs($this->reviewer)
            ->put(route('reviewer.reviews.monev.update', $this->reviewPenelitian), $payloadMonev);

        $resUpdate->assertRedirect(route('reviewer.reviews.show', $this->reviewPenelitian));
        $resUpdate->assertSessionHas('success');

        $monev->refresh();
        $this->assertEquals(6.25, (float) $monev->total_skor_monev);
        $this->assertEquals('dinilai', $monev->status_monev);
        $this->assertEquals($payloadMonev['catatan_reviewer'], $monev->catatan_reviewer);
    }

    public function test_reviewer_can_evaluate_final_report_and_give_recommendation(): void
    {
        $finalReport = ProposalFinalReport::create([
            'proposal_id' => $this->proposalPenelitian->id,
            'user_id' => $this->dosen->id,
            'file_laporan_akhir' => 'final_reports/dummy_laporan.pdf',
            'ringkasan_hasil' => 'Hasil riset membuktikan efektivitas sistem pengereman otomatis.',
            'total_realisasi_anggaran' => 25000000,
            'status_laporan' => 'terkirim',
            'tanggal_penyerahan' => now(),
        ]);

        // Cek akses halaman laporan akhir
        $resShow = $this->actingAs($this->reviewer)
            ->get(route('reviewer.reviews.final-report.show', $this->reviewPenelitian));
        $resShow->assertStatus(200);
        $resShow->assertSee('Evaluasi Laporan Akhir Kegiatan');
        $resShow->assertSee('Hasil riset membuktikan efektivitas sistem pengereman otomatis.');

        // Reviewer submit skor laporan akhir (bobot: 30%, 30%, 25%, 15%)
        // Skor: 7, 6, 7, 6 -> (7*0.30) + (6*0.30) + (7*0.25) + (6*0.15)
        // = 2.10 + 1.80 + 1.75 + 0.90 = 6.55
        $payloadLaporan = [
            'kriteria_1' => 7,
            'kriteria_2' => 6,
            'kriteria_3' => 7,
            'kriteria_4' => 6,
            'rekomendasi' => 'diterima',
            'catatan_reviewer' => 'Laporan akhir tersusun sangat rapi, analisis mendalam, dan luaran HKI telah didaftarkan.',
        ];

        $resUpdate = $this->actingAs($this->reviewer)
            ->put(route('reviewer.reviews.final-report.update', $this->reviewPenelitian), $payloadLaporan);

        $resUpdate->assertRedirect(route('reviewer.reviews.show', $this->reviewPenelitian));
        $resUpdate->assertSessionHas('success');

        $finalReport->refresh();
        $this->assertEquals(6.55, (float) $finalReport->total_skor_laporan);
        $this->assertEquals('diterima', $finalReport->status_laporan);
        $this->assertEquals($payloadLaporan['catatan_reviewer'], $finalReport->catatan_reviewer);
    }

    public function test_dosen_cannot_access_reviewer_routes(): void
    {
        $response = $this->actingAs($this->dosen)
            ->get(route('reviewer.reviews.show', $this->reviewPenelitian));

        $response->assertRedirect('/dosen/dashboard');
    }

    public function test_reviewer_can_filter_dashboard_by_research_and_community_service(): void
    {
        // Tab Semua Penugasan
        $resSemua = $this->actingAs($this->reviewer)
            ->get(route('reviewer.dashboard', ['tab' => 'semua']));
        $resSemua->assertStatus(200);
        $resSemua->assertSee('PR-2026-RSTJ-001');
        $resSemua->assertSee('PKM-2026-RSTJ-001');

        // Tab Penelitian
        $resPenelitian = $this->actingAs($this->reviewer)
            ->get(route('reviewer.dashboard', ['tab' => 'penelitian']));
        $resPenelitian->assertStatus(200);
        $resPenelitian->assertSee('PR-2026-RSTJ-001');
        $resPenelitian->assertDontSee('PKM-2026-RSTJ-001');

        // Tab Pengabdian kepada Masyarakat
        $resPengabdian = $this->actingAs($this->reviewer)
            ->get(route('reviewer.dashboard', ['tab' => 'pengabdian']));
        $resPengabdian->assertStatus(200);
        $resPengabdian->assertDontSee('PR-2026-RSTJ-001');
        $resPengabdian->assertSee('PKM-2026-RSTJ-001');
    }

    public function test_reviewer_can_agree_to_assigned_review_request(): void
    {
        $this->assertNull($this->reviewPenelitian->disetujui_review_at);

        $response = $this->actingAs($this->reviewer)
            ->post(route('reviewer.reviews.agree', $this->reviewPenelitian), [
                'persetujuan_komitmen' => '1',
            ]);

        $response->assertRedirect(route('reviewer.reviews.show', $this->reviewPenelitian));
        $response->assertSessionHas('success');

        $this->reviewPenelitian->refresh();
        $this->assertNotNull($this->reviewPenelitian->disetujui_review_at);
        $this->assertTrue($this->reviewPenelitian->persetujuan_komitmen);
    }

    public function test_reviewer_rejects_confirmation_when_tidak_setuju_is_selected(): void
    {
        $payload = [
            'kriteria_1' => 6,
            'kriteria_2' => 7,
            'kriteria_3' => 6,
            'kriteria_4' => 7,
            'kriteria_5' => 6,
            'rekomendasi' => 'diterima',
            'catatan_reviewer' => 'Metode riset sangat baik namun penyerahan belum disetujui.',
            'persetujuan_komitmen' => '1',
            'konfirmasi_hasil' => 'tidak_setuju',
        ];

        $response = $this->actingAs($this->reviewer)
            ->put(route('reviewer.reviews.update', $this->reviewPenelitian), $payload);

        $response->assertSessionHasErrors(['konfirmasi_hasil']);
    }

    public function test_reviewer_can_upload_revision_notes_for_final_report(): void
    {
        $finalReport = ProposalFinalReport::create([
            'proposal_id' => $this->proposalPenelitian->id,
            'user_id' => $this->dosen->id,
            'file_laporan_akhir' => 'final_reports/dummy_laporan.pdf',
            'ringkasan_hasil' => 'Hasil penelitian sistem keselamatan jalan.',
            'total_realisasi_anggaran' => 25000000,
            'status_laporan' => 'terkirim',
            'tanggal_penyerahan' => now(),
        ]);

        $fileCatatanRevisi = UploadedFile::fake()->create('catatan_revisi_laporan.pdf', 800, 'application/pdf');

        $payload = [
            'kriteria_1' => 5,
            'kriteria_2' => 5,
            'kriteria_3' => 5,
            'kriteria_4' => 5,
            'rekomendasi' => 'revisi',
            'file_catatan_revisi' => $fileCatatanRevisi,
            'catatan_reviewer' => 'Perbaiki lampiran kuitansi SPJ dan daftar pustaka laporan akhir.',
            'konfirmasi_hasil' => 'setuju',
        ];

        $response = $this->actingAs($this->reviewer)
            ->put(route('reviewer.reviews.final-report.update', $this->reviewPenelitian), $payload);

        $response->assertRedirect(route('reviewer.reviews.show', $this->reviewPenelitian));

        $finalReport->refresh();
        $this->assertEquals('revisi', $finalReport->status_laporan);
        $this->assertNotNull($finalReport->file_catatan_revisi);
        Storage::disk('public')->assertExists($finalReport->file_catatan_revisi);
    }
}
