<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $proposals = Proposal::where('user_id', $user->id)->latest()->get();

        $stats = [
            'total_usulan' => $proposals->count(),
            'draft' => $proposals->where('status', 'draft')->count(),
            'diajukan' => $proposals->whereIn('status', ['diajukan', 'verifikasi_administrasi', 'sedang_direview'])->count(),
            'diterima' => $proposals->where('status', 'diterima')->count(),
        ];

        return view('dosen.dashboard', compact('user', 'proposals', 'stats'));
    }
}
