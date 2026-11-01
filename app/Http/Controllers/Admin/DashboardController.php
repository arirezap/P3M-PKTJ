<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityService;
use App\Models\Document;
use App\Models\Post;
use App\Models\Proposal;
use App\Models\Research;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dasbor Utama (Home) Administrator SIM P3M PKTJ
     * Memfasilitasi pemilihan modul utama (Penelitian, Pengabdian kepada Masyarakat, Pengaturan),
     * serta visualisasi pipeline pemantauan progres usulan dari submission hingga archive.
     */
    public function index(): View
    {
        // 1. Metrik Modul Sub-Menu 1: Penelitian
        $penelitianStats = [
            'total' => Proposal::penelitian()->count(),
            'butuh_tindakan' => Proposal::penelitian()->whereIn('status', ['diajukan', 'verifikasi_administrasi'])->count(),
            'sedang_direview' => Proposal::penelitian()->where('status', 'sedang_direview')->count(),
            'revisi' => Proposal::penelitian()->where('status', 'revisi')->count(),
            'diterima' => Proposal::penelitian()->where('status', 'diterima')->count(),
            'pelaksanaan' => Proposal::penelitian()->where('status', 'pelaksanaan')->count(),
            'archive' => Proposal::penelitian()->where('status', 'archive')->count(),
            'total_dana' => Proposal::penelitian()->whereIn('status', ['diterima', 'pelaksanaan', 'archive'])->sum('total_anggaran'),
        ];

        // 2. Metrik Modul Sub-Menu 2: Pengabdian kepada Masyarakat (PkM)
        $pengabdianStats = [
            'total' => Proposal::pengabdian()->count(),
            'butuh_tindakan' => Proposal::pengabdian()->whereIn('status', ['diajukan', 'verifikasi_administrasi'])->count(),
            'sedang_direview' => Proposal::pengabdian()->where('status', 'sedang_direview')->count(),
            'revisi' => Proposal::pengabdian()->where('status', 'revisi')->count(),
            'diterima' => Proposal::pengabdian()->where('status', 'diterima')->count(),
            'pelaksanaan' => Proposal::pengabdian()->where('status', 'pelaksanaan')->count(),
            'archive' => Proposal::pengabdian()->where('status', 'archive')->count(),
            'total_dana' => Proposal::pengabdian()->whereIn('status', ['diterima', 'pelaksanaan', 'archive'])->sum('total_anggaran'),
        ];

        // 3. Metrik Modul Sub-Menu 3: Pengaturan & Pengguna
        $pengaturanStats = [
            'total_users' => User::count(),
            'total_dosen' => User::where('role', 'dosen')->count(),
            'total_reviewer' => User::where('role', 'reviewer')->count(),
            'reviewer_aktif' => User::where('role', 'reviewer')->where('status_aktif', true)->count(),
        ];

        // 4. Pipeline Gabungan Siklus Hidup Usulan (Submission hingga Archive)
        $pipelineStats = [
            'submission' => Proposal::where('status', 'diajukan')->count(),
            'verifikasi' => Proposal::where('status', 'verifikasi_administrasi')->count(),
            'review' => Proposal::where('status', 'sedang_direview')->count(),
            'revisi' => Proposal::where('status', 'revisi')->count(),
            'diterima' => Proposal::where('status', 'diterima')->count(),
            'pelaksanaan' => Proposal::where('status', 'pelaksanaan')->count(),
            'archive' => Proposal::where('status', 'archive')->count(),
        ];

        // 5. Usulan Mendesak yang Perlu Penugasan Reviewer / Verifikasi Admin
        $urgentProposals = Proposal::with(['prodi', 'ketua', 'reviews'])
            ->whereIn('status', ['diajukan', 'verifikasi_administrasi'])
            ->latest('id')
            ->take(6)
            ->get();

        // 6. Rekap Data Publik CMS Eksisting (Preserved for compatibility)
        $stats = [
            'total_users' => $pengaturanStats['total_users'],
            'total_dosen' => $pengaturanStats['total_dosen'],
            'total_reviewer' => $pengaturanStats['total_reviewer'],
            'total_posts' => Post::count(),
            'total_documents' => Document::count(),
            'total_researches' => Research::count(),
            'total_community_services' => CommunityService::count(),
            'total_proposals' => Proposal::count(),
        ];

        return view('admin.dashboard', compact(
            'penelitianStats',
            'pengabdianStats',
            'pengaturanStats',
            'pipelineStats',
            'urgentProposals',
            'stats'
        ));
    }
}
