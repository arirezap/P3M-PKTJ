<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\ProposalReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProposalReviewController extends Controller
{
    /**
     * Tampilkan formulir lembar penilaian usulan untuk reviewer yang ditugaskan.
     */
    public function show(ProposalReview $review): View
    {
        // Pastikan hanya reviewer yang ditugaskan yang dapat mengakses
        if ($review->reviewer_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menilai usulan ini.');
        }

        $review->load([
            'proposal.prodi',
            'proposal.ketua',
            'proposal.members',
            'proposal.budgets',
        ]);

        return view('reviewer.reviews.show', compact('review'));
    }

    /**
     * Simpan hasil evaluasi rubrik penilaian dan rekomendasi reviewer.
     */
    public function update(Request $request, ProposalReview $review): RedirectResponse
    {
        // Pastikan hanya reviewer yang ditugaskan yang dapat menyimpan
        if ($review->reviewer_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menilai usulan ini.');
        }

        $validated = $request->validate([
            'skor_urgensi' => ['required', 'numeric', 'min:0', 'max:100'],
            'skor_metodologi' => ['required', 'numeric', 'min:0', 'max:100'],
            'skor_kelayakan_rab' => ['required', 'numeric', 'min:0', 'max:100'],
            'skor_luaran' => ['required', 'numeric', 'min:0', 'max:100'],
            'rekomendasi' => ['required', 'in:diterima,diterima_dengan_revisi,ditolak'],
            'catatan_reviewer' => ['required', 'string', 'min:10'],
        ], [
            'skor_urgensi.required' => 'Nilai skor urgensi wajib diisi (0 - 100).',
            'skor_metodologi.required' => 'Nilai skor metodologi wajib diisi (0 - 100).',
            'skor_kelayakan_rab.required' => 'Nilai skor kelayakan RAB wajib diisi (0 - 100).',
            'skor_luaran.required' => 'Nilai skor target luaran wajib diisi (0 - 100).',
            'rekomendasi.required' => 'Pilih rekomendasi akhir usulan.',
            'catatan_reviewer.required' => 'Catatan evaluasi reviewer wajib diisi.',
            'catatan_reviewer.min' => 'Catatan evaluasi minimal berisi 10 karakter untuk panduan pengusul.',
        ]);

        // Perhitungan Bobot Standar PKTJ Tegal:
        // Urgensi: 25%, Metodologi: 30%, Kelayakan RAB: 20%, Target Luaran: 25%
        $totalSkor = (
            ($validated['skor_urgensi'] * 0.25) +
            ($validated['skor_metodologi'] * 0.30) +
            ($validated['skor_kelayakan_rab'] * 0.20) +
            ($validated['skor_luaran'] * 0.25)
        );

        $review->update([
            'skor_urgensi' => $validated['skor_urgensi'],
            'skor_metodologi' => $validated['skor_metodologi'],
            'skor_kelayakan_rab' => $validated['skor_kelayakan_rab'],
            'skor_luaran' => $validated['skor_luaran'],
            'total_skor' => round($totalSkor, 2),
            'catatan_reviewer' => $validated['catatan_reviewer'],
            'rekomendasi' => $validated['rekomendasi'],
            'status_review' => 'selesai',
            'tanggal_review' => now(),
        ]);

        // Sinkronisasi status proposal jika rekomendasi memerlukan revisi
        $proposal = $review->proposal;
        if ($validated['rekomendasi'] === 'diterima_dengan_revisi') {
            $proposal->update([
                'status' => 'revisi',
                'catatan_admin' => $validated['catatan_reviewer'],
            ]);
        }

        return redirect()->route('reviewer.reviews.show', $review)
            ->with('success', "Penilaian usulan {$proposal->kode_usulan} berhasil disimpan dan diserahkan ke P3M.");
    }
}
