<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\ProposalReview;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProposalController extends Controller
{
    /**
     * Menampilkan daftar proposal usulan yang masuk.
     */
    public function index(Request $request): View
    {
        $query = Proposal::with(['prodi', 'ketua', 'reviews.reviewer'])->latest();

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis') && $request->jenis !== 'semua') {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('kode_usulan', 'like', "%{$search}%");
            });
        }

        $proposals = $query->paginate(15)->withQueryString();
        $reviewers = User::where('role', 'reviewer')->where('status_aktif', true)->get();

        return view('admin.proposals.index', compact('proposals', 'reviewers'));
    }

    /**
     * Verifikasi status administrasi proposal.
     */
    public function updateStatus(Request $request, Proposal $proposal): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:draft,diajukan,verifikasi_administrasi,sedang_direview,revisi,diterima,ditolak'],
            'catatan_admin' => ['nullable', 'string'],
        ]);

        $proposal->update($validated);

        return back()->with('success', "Status usulan {$proposal->kode_usulan} berhasil diperbarui.");
    }

    /**
     * Penugasan reviewer untuk proposal usulan.
     */
    public function assignReviewer(Request $request, Proposal $proposal): RedirectResponse
    {
        $validated = $request->validate([
            'reviewer_id' => ['required', 'exists:users,id'],
        ], [
            'reviewer_id.required' => 'Pilih penilai (reviewer) yang akan ditugaskan.',
        ]);

        // Cek apakah reviewer sudah ditugaskan sebelumnya
        $existing = ProposalReview::where('proposal_id', $proposal->id)
            ->where('reviewer_id', $validated['reviewer_id'])
            ->first();

        if ($existing) {
            return back()->with('error', 'Reviewer tersebut telah ditugaskan pada proposal ini.');
        }

        ProposalReview::create([
            'proposal_id' => $proposal->id,
            'reviewer_id' => $validated['reviewer_id'],
            'status_review' => 'menunggu',
        ]);

        $proposal->update(['status' => 'sedang_direview']);

        return back()->with('success', "Penugasan reviewer untuk {$proposal->kode_usulan} berhasil disimpan.");
    }
}
