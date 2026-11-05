<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\ProposalReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan dasbor reviewer dengan filter tab: Semua Penugasan, Penelitian, dan Pengabdian.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $tab = $request->query('tab', 'semua');

        $allReviews = ProposalReview::with([
            'proposal.prodi',
            'proposal.ketua',
            'proposal.monev',
            'proposal.finalReport',
        ])
            ->where('reviewer_id', $user->id)
            ->latest()
            ->get();

        $stats = [
            'total_penugasan' => $allReviews->count(),
            'menunggu' => $allReviews->where('status_review', 'menunggu')->count(),
            'selesai' => $allReviews->where('status_review', 'selesai')->count(),
            'monev_antrean' => $allReviews->filter(fn ($r) => $r->proposal && $r->proposal->monev && $r->proposal->monev->status_monev !== 'dinilai')->count(),
            'laporan_antrean' => $allReviews->filter(fn ($r) => $r->proposal && $r->proposal->finalReport && $r->proposal->finalReport->status_laporan !== 'diterima')->count(),
        ];

        $reviews = match ($tab) {
            'penelitian' => $allReviews->filter(fn ($r) => $r->proposal && $r->proposal->jenis === 'penelitian'),
            'pengabdian' => $allReviews->filter(fn ($r) => $r->proposal && $r->proposal->jenis === 'pengabdian'),
            default => $allReviews,
        };

        return view('reviewer.dashboard', compact('user', 'reviews', 'stats', 'tab'));
    }
}
