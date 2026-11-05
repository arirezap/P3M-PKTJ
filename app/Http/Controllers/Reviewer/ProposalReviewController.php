<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\ProposalReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProposalReviewController extends Controller
{
    /**
     * Tampilkan formulir lembar penilaian usulan untuk reviewer yang ditugaskan.
     */
    public function show(ProposalReview $review): View
    {
        if ($review->reviewer_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menilai usulan ini.');
        }

        // Inisialisasi batas waktu review default jika belum ada (H+7)
        if (! $review->batas_waktu_review) {
            $review->update([
                'batas_waktu_review' => now()->addDays(7)->toDateString(),
            ]);
        }

        $review->load([
            'proposal.prodi',
            'proposal.ketua',
            'proposal.members',
            'proposal.budgets',
            'proposal.monev',
            'proposal.finalReport',
        ]);

        return view('reviewer.reviews.show', compact('review'));
    }

    /**
     * Setujui penugasan telaah usulan pada tahap Permintaan (PDF Hal. 16 & 18).
     */
    public function agreeReview(Request $request, ProposalReview $review): RedirectResponse
    {
        if ($review->reviewer_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menyetujui penugasan ini.');
        }

        $request->validate([
            'persetujuan_komitmen' => ['required'],
        ], [
            'persetujuan_komitmen.required' => 'Anda wajib mencentang persetujuan kesediaan menelaah usulan secara objektif.',
        ]);

        $review->update([
            'disetujui_review_at' => now(),
            'persetujuan_komitmen' => true,
            'batas_waktu_review' => $review->batas_waktu_review ?? now()->addDays(7)->toDateString(),
        ]);

        return redirect()->route('reviewer.reviews.show', $review)
            ->with('success', "Penugasan telaah usulan {$review->proposal->kode_usulan} telah disetujui. Silakan mengisi lembar rubrik penilaian di bawah ini.");
    }

    /**
     * Simpan hasil evaluasi rubrik penilaian baku (skala 1-7), catatan revisi, dan rekomendasi reviewer.
     */
    public function update(Request $request, ProposalReview $review): RedirectResponse
    {
        if ($review->reviewer_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menilai usulan ini.');
        }

        $proposal = $review->proposal;
        $isPenelitian = ($proposal->jenis === 'penelitian');

        // Validasi Rubrik Skor Baku 6 Tingkat: 1, 2, 3, 5, 6, 7 (Skor 4 ditiadakan)
        $rules = [
            'rekomendasi' => ['required', 'in:diterima,revisi,diterima_dengan_revisi,ditolak'],
            'catatan_reviewer' => ['required', 'string', 'min:10'],
            'file_catatan_revisi' => ['nullable', 'file', 'mimes:doc,docx,pdf', 'max:10240'],
            'persetujuan_komitmen' => ['required'],
            'konfirmasi_hasil' => ['nullable', 'in:setuju,tidak_setuju'],
        ];

        if ($isPenelitian) {
            // 5 Kriteria Penilaian Proposal Penelitian (PDF Hal. 16)
            $rules['kriteria_1'] = ['required', 'in:1,2,3,5,6,7']; // Perumusan Masalah & Roadmap (15%)
            $rules['kriteria_2'] = ['required', 'in:1,2,3,5,6,7']; // Luaran Proses & Produk (35%)
            $rules['kriteria_3'] = ['required', 'in:1,2,3,5,6,7']; // Tinjauan Pustaka (15%)
            $rules['kriteria_4'] = ['required', 'in:1,2,3,5,6,7']; // Metode Penelitian (20%)
            $rules['kriteria_5'] = ['required', 'in:1,2,3,5,6,7']; // Kelayakan Pelaksanaan (15%)
        } else {
            // 6 Kriteria Penilaian Proposal PkM (PDF Hal. 18)
            $rules['kriteria_1'] = ['required', 'in:1,2,3,5,6,7']; // Analisis Situasi (20%)
            $rules['kriteria_2'] = ['required', 'in:1,2,3,5,6,7']; // Permasalahan Prioritas & Solusi (15%)
            $rules['kriteria_3'] = ['required', 'in:1,2,3,5,6,7']; // Target Luaran (15%)
            $rules['kriteria_4'] = ['required', 'in:1,2,3,5,6,7']; // Ketepatan Metode Pendekatan (20%)
            $rules['kriteria_5'] = ['required', 'in:1,2,3,5,6,7']; // Kelayakan Institusi (10%)
            $rules['kriteria_6'] = ['required', 'in:1,2,3,5,6,7']; // Kelayakan Anggaran (20%)
        }

        $validated = $request->validate($rules, [
            'in' => 'Skor penilaian wajib menggunakan skala mutu baku: 1, 2, 3, 5, 6, atau 7 (skor 4 ditiadakan).',
            'catatan_reviewer.required' => 'Catatan evaluasi reviewer wajib diisi.',
            'catatan_reviewer.min' => 'Catatan evaluasi minimal berisi 10 karakter untuk panduan pengusul.',
            'persetujuan_komitmen.required' => 'Anda wajib menyetujui pernyataan integritas dan objektivitas penelaahan.',
            'konfirmasi_hasil.required' => 'Pilih konfirmasi persetujuan hasil penelaahan.',
            'konfirmasi_hasil.in' => 'Pilihan konfirmasi tidak valid.',
        ]);

        $konfirmasiHasil = $validated['konfirmasi_hasil'] ?? 'setuju';
        if ($konfirmasiHasil === 'tidak_setuju') {
            return back()->withInput()->withErrors([
                'konfirmasi_hasil' => 'Anda wajib memilih konfirmasi "Setuju" untuk menyelesaikan penyerahan telaah usulan.',
            ]);
        }

        // Perhitungan Akumulasi Nilai Terbobot (PRD 7.1)
        if ($isPenelitian) {
            $skorItems = [
                'kriteria_1' => (float) $validated['kriteria_1'],
                'kriteria_2' => (float) $validated['kriteria_2'],
                'kriteria_3' => (float) $validated['kriteria_3'],
                'kriteria_4' => (float) $validated['kriteria_4'],
                'kriteria_5' => (float) $validated['kriteria_5'],
            ];

            $totalSkor = (
                ($skorItems['kriteria_1'] * 0.15) +
                ($skorItems['kriteria_2'] * 0.35) +
                ($skorItems['kriteria_3'] * 0.15) +
                ($skorItems['kriteria_4'] * 0.20) +
                ($skorItems['kriteria_5'] * 0.15)
            );
        } else {
            $skorItems = [
                'kriteria_1' => (float) $validated['kriteria_1'],
                'kriteria_2' => (float) $validated['kriteria_2'],
                'kriteria_3' => (float) $validated['kriteria_3'],
                'kriteria_4' => (float) $validated['kriteria_4'],
                'kriteria_5' => (float) $validated['kriteria_5'],
                'kriteria_6' => (float) $validated['kriteria_6'],
            ];

            $totalSkor = (
                ($skorItems['kriteria_1'] * 0.20) +
                ($skorItems['kriteria_2'] * 0.15) +
                ($skorItems['kriteria_3'] * 0.15) +
                ($skorItems['kriteria_4'] * 0.20) +
                ($skorItems['kriteria_5'] * 0.10) +
                ($skorItems['kriteria_6'] * 0.20)
            );
        }

        // Unggah Berkas Tabel Catatan Revisi jika ada
        $fileRevisiPath = $review->file_catatan_revisi;
        if ($request->hasFile('file_catatan_revisi')) {
            if ($fileRevisiPath && Storage::disk('public')->exists($fileRevisiPath)) {
                Storage::disk('public')->delete($fileRevisiPath);
            }
            $fileRevisiPath = $request->file('file_catatan_revisi')->store('review_revisi_docs', 'public');
        }

        $rekomendasi = $validated['rekomendasi'];
        if ($rekomendasi === 'diterima_dengan_revisi') {
            $rekomendasi = 'revisi';
        }

        $review->update([
            'detail_nilai' => $skorItems,
            'total_skor' => round($totalSkor, 2),
            'catatan_reviewer' => $validated['catatan_reviewer'],
            'file_catatan_revisi' => $fileRevisiPath,
            'rekomendasi' => $rekomendasi,
            'status_review' => 'selesai',
            'persetujuan_komitmen' => true,
            'konfirmasi_hasil' => $konfirmasiHasil,
            'disetujui_review_at' => $review->disetujui_review_at ?? now(),
            'tanggal_review' => now(),
        ]);

        // Sinkronisasi status proposal jika rekomendasi memerlukan revisi
        if ($rekomendasi === 'revisi') {
            $proposal->update([
                'status' => 'revisi',
                'catatan_admin' => $validated['catatan_reviewer'],
            ]);
        }

        return redirect()->route('reviewer.reviews.show', $review)
            ->with('success', "Penilaian usulan {$proposal->kode_usulan} berhasil disimpan dan diserahkan ke P3M.");
    }

    /**
     * Tampilkan formulir evaluasi instrumen Monev oleh reviewer (PDF Hal. 17 & 19).
     */
    public function monevShow(ProposalReview $review): View
    {
        if ($review->reviewer_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menilai monev usulan ini.');
        }

        $proposal = $review->proposal->load(['monev', 'prodi', 'ketua']);
        $monev = $proposal->monev;

        if (! $monev) {
            abort(404, 'Instrumen Monev belum diisi oleh pengusul.');
        }

        return view('reviewer.reviews.monev', compact('review', 'proposal', 'monev'));
    }

    /**
     * Simpan hasil evaluasi 7 komponen Monev (skala 1-7) dan masukan reviewer.
     */
    public function monevUpdate(Request $request, ProposalReview $review): RedirectResponse
    {
        if ($review->reviewer_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menilai monev usulan ini.');
        }

        $proposal = $review->proposal;
        $monev = $proposal->monev;

        if (! $monev) {
            abort(404, 'Instrumen Monev belum diisi oleh pengusul.');
        }

        $validated = $request->validate([
            'monev_1' => ['required', 'in:1,2,3,5,6,7'], // Capaian Penelitian / Kegiatan Utama (Bobot 25)
            'monev_2' => ['required', 'in:1,2,3,5,6,7'], // Publikasi Ilmiah (Bobot 20)
            'monev_3' => ['required', 'in:1,2,3,5,6,7'], // Pemakalah dalam Pertemuan Ilmiah (Bobot 10)
            'monev_4' => ['required', 'in:1,2,3,5,6,7'], // HKI (Bobot 5)
            'monev_5' => ['required', 'in:1,2,3,5,6,7'], // Teknologi Tepat Guna (Bobot 10)
            'monev_6' => ['required', 'in:1,2,3,5,6,7'], // Produk / Purwarupa / Rekayasa (Bobot 20)
            'monev_7' => ['required', 'in:1,2,3,5,6,7'], // Buku Ajar / Monograf (Bobot 10)
            'catatan_reviewer' => ['required', 'string', 'min:10'],
            'konfirmasi_hasil' => ['nullable', 'in:setuju,tidak_setuju'],
        ], [
            'in' => 'Skor penilaian Monev wajib menggunakan skala baku: 1, 2, 3, 5, 6, atau 7 (skor 4 ditiadakan).',
            'catatan_reviewer.required' => 'Catatan evaluasi Monev wajib diisi.',
            'catatan_reviewer.min' => 'Catatan evaluasi Monev minimal berisi 10 karakter.',
        ]);

        $konfirmasiHasil = $validated['konfirmasi_hasil'] ?? 'setuju';
        if ($konfirmasiHasil === 'tidak_setuju') {
            return back()->withInput()->withErrors([
                'konfirmasi_hasil' => 'Anda wajib memilih konfirmasi "Setuju" untuk menyelesaikan penyerahan evaluasi Monev.',
            ]);
        }

        // Perhitungan Total Nilai Monev (Bobot: 25, 20, 10, 5, 10, 20, 10 = 100)
        $totalSkorMonev = (
            ((float) $validated['monev_1'] * 0.25) +
            ((float) $validated['monev_2'] * 0.20) +
            ((float) $validated['monev_3'] * 0.10) +
            ((float) $validated['monev_4'] * 0.05) +
            ((float) $validated['monev_5'] * 0.10) +
            ((float) $validated['monev_6'] * 0.20) +
            ((float) $validated['monev_7'] * 0.10)
        );

        $monev->update([
            'total_skor_monev' => round($totalSkorMonev, 2),
            'catatan_reviewer' => $validated['catatan_reviewer'],
            'konfirmasi_hasil' => $konfirmasiHasil,
            'status_monev' => 'dinilai',
        ]);

        return redirect()->route('reviewer.reviews.show', $review)
            ->with('success', "Penilaian instrumen Monev untuk usulan {$proposal->kode_usulan} berhasil disimpan.");
    }

    /**
     * Tampilkan formulir evaluasi Laporan Akhir oleh reviewer (PDF Hal. 17 & 19).
     */
    public function finalReportShow(ProposalReview $review): View
    {
        if ($review->reviewer_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menilai laporan akhir usulan ini.');
        }

        $proposal = $review->proposal->load(['finalReport', 'prodi', 'ketua']);
        $finalReport = $proposal->finalReport;

        if (! $finalReport) {
            abort(404, 'Dokumen Laporan Akhir belum diunggah oleh pengusul.');
        }

        return view('reviewer.reviews.final-report', compact('review', 'proposal', 'finalReport'));
    }

    /**
     * Simpan hasil evaluasi 4 kriteria Laporan Akhir (skala 1-7) dan rekomendasi kelulusan.
     */
    public function finalReportUpdate(Request $request, ProposalReview $review): RedirectResponse
    {
        if ($review->reviewer_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menilai laporan akhir usulan ini.');
        }

        $proposal = $review->proposal;
        $finalReport = $proposal->finalReport;

        if (! $finalReport) {
            abort(404, 'Dokumen Laporan Akhir belum diunggah oleh pengusul.');
        }

        $validated = $request->validate([
            'kriteria_1' => ['required', 'in:1,2,3,5,6,7'], // Kesesuaian Hasil vs Tujuan (Bobot 30%)
            'kriteria_2' => ['required', 'in:1,2,3,5,6,7'], // Realisasi Capaian Luaran Definitif (Bobot 30%)
            'kriteria_3' => ['required', 'in:1,2,3,5,6,7'], // Tingkat Kemanfaatan Hasil (Bobot 25%)
            'kriteria_4' => ['required', 'in:1,2,3,5,6,7'], // Kesiapan & Presentasi Hasil (Bobot 15%)
            'rekomendasi' => ['required', 'in:revisi,diterima'],
            'file_catatan_revisi' => ['nullable', 'file', 'mimes:doc,docx,pdf', 'max:10240'],
            'catatan_reviewer' => ['required', 'string', 'min:10'],
            'konfirmasi_hasil' => ['nullable', 'in:setuju,tidak_setuju'],
        ], [
            'in' => 'Skor penilaian Laporan Akhir wajib menggunakan skala baku: 1, 2, 3, 5, 6, atau 7 (skor 4 ditiadakan).',
            'rekomendasi.required' => 'Pilih rekomendasi kelulusan Laporan Akhir (Revisi / Diterima).',
            'catatan_reviewer.required' => 'Catatan evaluasi Laporan Akhir wajib diisi.',
            'catatan_reviewer.min' => 'Catatan evaluasi Laporan Akhir minimal berisi 10 karakter.',
        ]);

        $konfirmasiHasil = $validated['konfirmasi_hasil'] ?? 'setuju';
        if ($konfirmasiHasil === 'tidak_setuju') {
            return back()->withInput()->withErrors([
                'konfirmasi_hasil' => 'Anda wajib memilih konfirmasi "Setuju" untuk menyelesaikan penyerahan evaluasi Laporan Akhir.',
            ]);
        }

        // Unggah Berkas Catatan Revisi Laporan Akhir jika ada
        $fileRevisiPath = $finalReport->file_catatan_revisi;
        if ($request->hasFile('file_catatan_revisi')) {
            if ($fileRevisiPath && Storage::disk('public')->exists($fileRevisiPath)) {
                Storage::disk('public')->delete($fileRevisiPath);
            }
            $fileRevisiPath = $request->file('file_catatan_revisi')->store('review_laporan_revisi_docs', 'public');
        }

        // Perhitungan Total Nilai Laporan Akhir (Bobot: 30%, 30%, 25%, 15% = 100%)
        $totalSkorLaporan = (
            ((float) $validated['kriteria_1'] * 0.30) +
            ((float) $validated['kriteria_2'] * 0.30) +
            ((float) $validated['kriteria_3'] * 0.25) +
            ((float) $validated['kriteria_4'] * 0.15)
        );

        $finalReport->update([
            'total_skor_laporan' => round($totalSkorLaporan, 2),
            'catatan_reviewer' => $validated['catatan_reviewer'],
            'file_catatan_revisi' => $fileRevisiPath,
            'konfirmasi_hasil' => $konfirmasiHasil,
            'status_laporan' => $validated['rekomendasi'],
        ]);

        return redirect()->route('reviewer.reviews.show', $review)
            ->with('success', "Penilaian Laporan Akhir untuk usulan {$proposal->kode_usulan} berhasil disimpan.");
    }
}
