<?php

namespace Tests\Feature;

use App\Models\Prodi;
use App\Models\Proposal;
use App\Models\ProposalReview;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewerReviewTest extends TestCase
{
    use RefreshDatabase;

    protected User $reviewer;
    protected User $otherReviewer;
    protected User $dosen;
    protected Prodi $prodi;
    protected Proposal $proposal;
    protected ProposalReview $review;

    protected function setUp(): void
    {
        parent::setUp();

        $this->prodi = Prodi::create([
            'kode_prodi' => 'RSTJ',
            'nama_prodi' => 'Rekayasa Sistem Transportasi Jalan',
            'jenjang' => 'D4',
        ]);

        $this->dosen = User::create([
            'name' => 'Dr. Bambang Kusumo, M.T.',
            'email' => 'dosen@pktj.ac.id',
            'password' => bcrypt('password'),
            'role' => 'dosen',
            'prodi_id' => $this->prodi->id,
            'status_aktif' => true,
        ]);

        $this->reviewer = User::create([
            'name' => 'Prof. Dr. Ir. Suyitno, M.Sc.',
            'email' => 'reviewer@pktj.ac.id',
            'password' => bcrypt('password'),
            'role' => 'reviewer',
            'prodi_id' => $this->prodi->id,
            'status_aktif' => true,
        ]);

        $this->otherReviewer = User::create([
            'name' => 'Dr. Ahmad Fauzi, M.T.',
            'email' => 'fauzi@pktj.ac.id',
            'password' => bcrypt('password'),
            'role' => 'reviewer',
            'prodi_id' => $this->prodi->id,
            'status_aktif' => true,
        ]);

        $this->proposal = Proposal::create([
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

        $this->review = ProposalReview::create([
            'proposal_id' => $this->proposal->id,
            'reviewer_id' => $this->reviewer->id,
            'status_review' => 'menunggu',
        ]);
    }

    public function test_reviewer_can_view_evaluation_page_for_assigned_proposal(): void
    {
        $response = $this->actingAs($this->reviewer)->get(route('reviewer.reviews.show', $this->review));

        $response->assertStatus(200);
        $response->assertSee('PR-2026-RSTJ-001');
        $response->assertSee('Audit Keselamatan Geometrik Jalan Lingkar Kota Tegal');
        $response->assertSee('Rubrik Penilaian Usulan & Penetapan Rekomendasi', false);
        $response->assertSee('Urgensi Masalah & Relevansi Keselamatan Transportasi', false);
    }

    public function test_reviewer_cannot_view_evaluation_page_assigned_to_another_reviewer(): void
    {
        $response = $this->actingAs($this->otherReviewer)->get(route('reviewer.reviews.show', $this->review));

        $response->assertStatus(403);
    }

    public function test_reviewer_can_submit_evaluation_rubric_and_total_score_is_calculated(): void
    {
        $payload = [
            'skor_urgensi' => 80,       // 80 * 0.25 = 20.0
            'skor_metodologi' => 90,     // 90 * 0.30 = 27.0
            'skor_kelayakan_rab' => 85,  // 85 * 0.20 = 17.0
            'skor_luaran' => 80,         // 80 * 0.25 = 20.0
            'rekomendasi' => 'diterima',
            'catatan_reviewer' => 'Metode riset dan rancangan pengujian lapangan sangat komprehensif serta relevan dengan isu blackspot.',
        ];

        $response = $this->actingAs($this->reviewer)->put(route('reviewer.reviews.update', $this->review), $payload);

        $response->assertRedirect(route('reviewer.reviews.show', $this->review));

        $this->review->refresh();
        $this->assertEquals('selesai', $this->review->status_review);
        $this->assertEquals(84.00, (float) $this->review->total_skor); // 20 + 27 + 17 + 20 = 84.00
        $this->assertEquals('diterima', $this->review->rekomendasi);
        $this->assertNotNull($this->review->tanggal_review);
    }

    public function test_submitting_with_revision_recommendation_updates_proposal_status_to_revisi(): void
    {
        $payload = [
            'skor_urgensi' => 70,
            'skor_metodologi' => 70,
            'skor_kelayakan_rab' => 60,
            'skor_luaran' => 75,
            'rekomendasi' => 'diterima_dengan_revisi',
            'catatan_reviewer' => 'Harap kurangi anggaran sewa kendaraan operasional dan perbaiki rincian luaran jurnal terakreditasi.',
        ];

        $response = $this->actingAs($this->reviewer)->put(route('reviewer.reviews.update', $this->review), $payload);

        $response->assertRedirect(route('reviewer.reviews.show', $this->review));

        $this->review->refresh();
        $this->assertEquals('diterima_dengan_revisi', $this->review->rekomendasi);

        $this->proposal->refresh();
        $this->assertEquals('revisi', $this->proposal->status);
        $this->assertEquals($payload['catatan_reviewer'], $this->proposal->catatan_admin);
    }

    public function test_validation_fails_when_scores_are_outside_valid_range(): void
    {
        $payload = [
            'skor_urgensi' => 120, // Invalid: max 100
            'skor_metodologi' => -10, // Invalid: min 0
            'skor_kelayakan_rab' => 80,
            'skor_luaran' => 80,
            'rekomendasi' => 'diterima',
            'catatan_reviewer' => 'Catatan cukup panjang.',
        ];

        $response = $this->actingAs($this->reviewer)->put(route('reviewer.reviews.update', $this->review), $payload);

        $response->assertSessionHasErrors(['skor_urgensi', 'skor_metodologi']);
    }

    public function test_dosen_cannot_access_reviewer_routes(): void
    {
        $response = $this->actingAs($this->dosen)->get(route('reviewer.reviews.show', $this->review));

        $response->assertRedirect('/dosen/dashboard');
    }
}
