<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\ProposalReview;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $reviews = ProposalReview::with('proposal.prodi', 'proposal.ketua')
            ->where('reviewer_id', $user->id)
            ->latest()
            ->get();

        $stats = [
            'total_penugasan' => $reviews->count(),
            'menunggu' => $reviews->where('status_review', 'menunggu')->count(),
            'selesai' => $reviews->where('status_review', 'selesai')->count(),
        ];

        return view('reviewer.dashboard', compact('user', 'reviews', 'stats'));
    }
}
