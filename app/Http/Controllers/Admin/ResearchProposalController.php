<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\Proposal;
use App\Models\ProposalReview;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResearchProposalController extends Controller
{
    /**
     * Menampilkan daftar usulan penelitian, penugasan reviewer,
     * serta pemantauan seluruh progres kegiatan dari submission hingga archive.
     */
    public function index(Request $request): View
    {
        $query = Proposal::with(['prodi', 'ketua', 'reviews.reviewer', 'monev', 'finalReport'])
            ->penelitian()
            ->latest('id');

        // 4 Menu/Tab Utama Sesuai Dokumen Acuan PDF Halaman 3
        $selectedTab = $request->query('tab', 'masuk');
        if ($selectedTab === 'belum_ditugaskan') {
            $query->whereIn('status', ['diajukan', 'verifikasi_administrasi'])
                  ->whereDoesntHave('reviews');
        } elseif ($selectedTab === 'sedang_ditugaskan') {
            $query->where(function ($q) {
                $q->where('status', 'sedang_direview')
                  ->orWhere(function ($sub) {
                      $sub->whereIn('status', ['verifikasi_administrasi', 'revisi'])
                          ->whereHas('reviews');
                  });
            });
        } elseif ($selectedTab === 'arsip') {
            $query->where('status', 'archive');
        }

        // Filter Tahapan / Status Siklus
        $selectedStatus = $request->query('status', 'semua');
        if ($selectedStatus !== 'semua' && !empty($selectedStatus)) {
            if ($selectedStatus === 'butuh_reviewer') {
                $query->whereIn('status', ['diajukan', 'verifikasi_administrasi'])
                      ->whereDoesntHave('reviews');
            } elseif ($selectedStatus === 'aktif') {
                $query->whereNotIn('status', ['draft', 'ditolak', 'archive']);
            } else {
                $query->where('status', $selectedStatus);
            }
        }

        // Filter Program Studi (3 Program Studi PKTJ: D4 RSTJ, D4 TRO, D3 TO)
        $selectedProdi = $request->query('prodi', 'semua');
        if ($selectedProdi !== 'semua' && !empty($selectedProdi)) {
            $query->whereHas('prodi', function ($q) use ($selectedProdi) {
                if (is_numeric($selectedProdi)) {
                    $q->where('id', $selectedProdi);
                } else {
                    $q->where('kode_prodi', strtoupper($selectedProdi));
                }
            });
        }

        // Filter Tahun Anggaran
        $selectedYear = $request->query('tahun', 'semua');
        if ($selectedYear !== 'semua' && !empty($selectedYear)) {
            $query->where('tahun_anggaran', $selectedYear);
        }

        // Pencarian Kata Kunci Judul / Kode Usulan / Nama Ketua
        $searchQuery = trim($request->query('search', ''));
        if (!empty($searchQuery)) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('judul', 'like', "%{$searchQuery}%")
                  ->orWhere('kode_usulan', 'like', "%{$searchQuery}%")
                  ->orWhereHas('ketua', function ($userQuery) use ($searchQuery) {
                      $userQuery->where('name', 'like', "%{$searchQuery}%");
                  });
            });
        }

        $proposals = $query->paginate(12)->withQueryString();

        // 3 Program Studi PKTJ
        $prodis = Prodi::where('status_aktif', true)->orderBy('id')->get();

        // Daftar Reviewer Aktif untuk Penugasan
        $reviewers = User::where('role', 'reviewer')
            ->where('status_aktif', true)
            ->with('prodi')
            ->orderBy('name')
            ->get();

        // Statistik Pipeline Siklus Hidup Penelitian (Submission hingga Archive)
        $stats = [
            'total' => Proposal::penelitian()->count(),
            'submission' => Proposal::penelitian()->where('status', 'diajukan')->count(),
            'verifikasi' => Proposal::penelitian()->where('status', 'verifikasi_administrasi')->count(),
            'review' => Proposal::penelitian()->where('status', 'sedang_direview')->count(),
            'revisi' => Proposal::penelitian()->where('status', 'revisi')->count(),
            'diterima' => Proposal::penelitian()->where('status', 'diterima')->count(),
            'pelaksanaan' => Proposal::penelitian()->where('status', 'pelaksanaan')->count(),
            'archive' => Proposal::penelitian()->where('status', 'archive')->count(),
            'ditolak' => Proposal::penelitian()->where('status', 'ditolak')->count(),
            'butuh_reviewer' => Proposal::penelitian()
                ->whereIn('status', ['diajukan', 'verifikasi_administrasi'])
                ->whereDoesntHave('reviews')
                ->count(),
        ];

        $availableYears = Proposal::penelitian()
            ->select('tahun_anggaran')
            ->distinct()
            ->orderByDesc('tahun_anggaran')
            ->pluck('tahun_anggaran');

        $tabCounts = [
            'masuk' => Proposal::penelitian()->count(),
            'belum_ditugaskan' => Proposal::penelitian()
                ->whereIn('status', ['diajukan', 'verifikasi_administrasi'])
                ->whereDoesntHave('reviews')
                ->count(),
            'sedang_ditugaskan' => Proposal::penelitian()
                ->where(function ($q) {
                    $q->where('status', 'sedang_direview')
                      ->orWhere(function ($sub) {
                          $sub->whereIn('status', ['verifikasi_administrasi', 'revisi'])
                              ->whereHas('reviews');
                      });
                })->count(),
            'arsip' => Proposal::penelitian()->where('status', 'archive')->count(),
        ];

        return view('admin.penelitian.index', compact(
            'proposals',
            'prodis',
            'reviewers',
            'stats',
            'tabCounts',
            'selectedTab',
            'selectedStatus',
            'selectedProdi',
            'selectedYear',
            'searchQuery',
            'availableYears'
        ));
    }

    /**
     * Menugaskan reviewer untuk usulan proposal penelitian.
     */
    public function assignReviewer(Request $request, Proposal $proposal): RedirectResponse
    {
        if ($proposal->jenis !== 'penelitian') {
            return back()->with('error', 'Proposal ini bukan merupakan usulan bidang penelitian.');
        }

        $validated = $request->validate([
            'reviewer_id' => ['required', 'exists:users,id'],
        ], [
            'reviewer_id.required' => 'Silakan pilih penilai (reviewer) yang akan ditugaskan.',
            'reviewer_id.exists' => 'Reviewer yang dipilih tidak valid dalam sistem.',
        ]);

        // Cek penugasan ganda reviewer yang sama
        $existing = ProposalReview::where('proposal_id', $proposal->id)
            ->where('reviewer_id', $validated['reviewer_id'])
            ->first();

        if ($existing) {
            return back()->with('error', 'Reviewer tersebut telah ditugaskan pada usulan penelitian ini.');
        }

        ProposalReview::create([
            'proposal_id' => $proposal->id,
            'reviewer_id' => $validated['reviewer_id'],
            'status_review' => 'menunggu',
        ]);

        // Update status proposal menjadi sedang_direview jika masih tahap diajukan / verifikasi
        if (in_array($proposal->status, ['diajukan', 'verifikasi_administrasi'])) {
            $proposal->update(['status' => 'sedang_direview']);
        }

        return back()->with('success', "Reviewer berhasil ditugaskan untuk usulan penelitian {$proposal->kode_usulan}.");
    }

    /**
     * Memperbarui status tahapan siklus usulan penelitian.
     */
    public function updateStatus(Request $request, Proposal $proposal): RedirectResponse
    {
        if ($proposal->jenis !== 'penelitian') {
            return back()->with('error', 'Proposal ini bukan merupakan usulan bidang penelitian.');
        }

        $validated = $request->validate([
            'status' => [
                'required',
                'in:diajukan,verifikasi_administrasi,sedang_direview,revisi,diterima,ditolak,pelaksanaan,archive'
            ],
            'catatan_admin' => ['nullable', 'string', 'max:1000'],
        ], [
            'status.required' => 'Status tahapan wajib dipilih.',
            'status.in' => 'Status tahapan yang dipilih tidak valid.',
        ]);

        $proposal->update($validated);

        return back()->with('success', "Status usulan penelitian {$proposal->kode_usulan} berhasil diperbarui.");
    }

    /**
     * Memindahkan kegiatan penelitian yang telah tuntas ke status Archive (Arsip).
     */
    public function archive(Request $request, Proposal $proposal): RedirectResponse
    {
        if ($proposal->jenis !== 'penelitian') {
            return back()->with('error', 'Proposal ini bukan merupakan usulan bidang penelitian.');
        }

        $proposal->update([
            'status' => 'archive',
            'catatan_admin' => $request->input('catatan_admin', 'Kegiatan penelitian telah selesai dan diarsipkan.'),
        ]);

        return back()->with('success', "Kegiatan penelitian {$proposal->kode_usulan} berhasil diarsipkan (Archive).");
    }

    /**
     * Cetak lembar rekapitulasi capaian dan arsip kegiatan (Printable Sheet).
     */
    public function print(Proposal $proposal): View
    {
        if ($proposal->jenis !== 'penelitian') {
            abort(404);
        }

        $proposal->load([
            'prodi',
            'ketua.prodi',
            'members',
            'budgets',
            'reviews.reviewer.prodi',
            'monev',
            'finalReport',
        ]);

        return view('admin.proposals.print', compact('proposal'));
    }
}

