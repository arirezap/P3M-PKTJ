<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();
        $selectedTab = $request->query('tab', 'semua');
        if (!in_array($selectedTab, ['semua', 'penelitian', 'pengabdian'])) {
            $selectedTab = 'semua';
        }

        $allProposals = Proposal::where('user_id', $user->id)->latest()->get();

        $tabCounts = [
            'semua' => $allProposals->count(),
            'penelitian' => $allProposals->where('jenis', 'penelitian')->count(),
            'pengabdian' => $allProposals->where('jenis', 'pengabdian')->count(),
        ];

        $proposals = match ($selectedTab) {
            'penelitian' => $allProposals->where('jenis', 'penelitian'),
            'pengabdian' => $allProposals->where('jenis', 'pengabdian'),
            default => $allProposals,
        };

        $stats = [
            'total_usulan' => $allProposals->count(),
            'draft' => $allProposals->where('status', 'draft')->count(),
            'diajukan' => $allProposals->whereIn('status', ['diajukan', 'verifikasi_administrasi', 'sedang_direview'])->count(),
            'diterima' => $allProposals->where('status', 'diterima')->count(),
        ];

        return view('dosen.dashboard', compact('user', 'proposals', 'stats', 'selectedTab', 'tabCounts'));
    }
}
