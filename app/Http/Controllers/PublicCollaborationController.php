<?php

namespace App\Http\Controllers;

use App\Models\Collaboration;
use App\Models\Prodi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PublicCollaborationController extends Controller
{
    /**
     * Menampilkan halaman publik direktori kerjasama bidang penelitian P3M PKTJ,
     * tersusun per tahun dilengkapi filter kategori mitra, prodi, status, dan pencarian.
     */
    public function index(Request $request): View
    {
        // 1. Data 3 Program Studi PKTJ
        $prodis = Prodi::where('status_aktif', true)->orderBy('id')->get();

        // 2. Query Kerjasama Penelitian
        $query = Collaboration::with('prodi')
            ->penelitian()
            ->orderByDesc('tahun')
            ->latest('id');

        // Filter Tahun
        $selectedYear = $request->query('tahun', 'semua');
        if ($selectedYear !== 'semua' && ! empty($selectedYear)) {
            $query->where('tahun', $selectedYear);
        }

        // Filter Kategori Mitra
        $selectedKategori = $request->query('kategori', 'semua');
        if ($selectedKategori !== 'semua' && ! empty($selectedKategori)) {
            $query->where('kategori_mitra', $selectedKategori);
        }

        // Filter Program Studi (3 Prodi)
        $selectedProdi = $request->query('prodi', 'semua');
        if ($selectedProdi !== 'semua' && ! empty($selectedProdi)) {
            $query->whereHas('prodi', function ($q) use ($selectedProdi) {
                if (is_numeric($selectedProdi)) {
                    $q->where('id', $selectedProdi);
                } else {
                    $q->where('kode_prodi', strtoupper($selectedProdi));
                }
            });
        }

        // Filter Status Kerjasama (Aktif / Selesai)
        $selectedStatus = $request->query('status', 'semua');
        if ($selectedStatus !== 'semua' && ! empty($selectedStatus)) {
            $query->where('status_kerjasama', $selectedStatus);
        }

        // Pencarian Kata Kunci
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_mitra', 'like', "%{$keyword}%")
                    ->orWhere('judul_kerjasama', 'like', "%{$keyword}%")
                    ->orWhere('nomor_mou_pks', 'like', "%{$keyword}%")
                    ->orWhere('deskripsi', 'like', "%{$keyword}%");
            });
        }

        $collaborations = $query->get();

        // 3. Kelompokkan Data Berdasarkan Tahun (Tersusun per Tahun Descending)
        $collaborationsByYear = $collaborations->groupBy('tahun');

        // 4. Daftar Tahun Tersedia
        $availableYears = Collaboration::penelitian()
            ->select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        // 5. Metrik Statistik Ringkasan Utama
        $allPenelitian = Collaboration::penelitian()->get();
        $totalKerjasama = $allPenelitian->count();
        $totalAktif = $allPenelitian->where('status_kerjasama', 'aktif')->count();
        $totalIndustriBumn = $allPenelitian->whereIn('kategori_mitra', ['industri', 'bumn'])->count();
        $totalDokumen = $allPenelitian->filter(fn ($c) => ! empty($c->file_dokumen))->count();

        // 6. Hitung Kategori untuk Filter Tabs / Badges
        $kategoriCounts = [
            'semua' => $totalKerjasama,
            'pemerintah' => $allPenelitian->where('kategori_mitra', 'pemerintah')->count(),
            'bumn' => $allPenelitian->where('kategori_mitra', 'bumn')->count(),
            'industri' => $allPenelitian->where('kategori_mitra', 'industri')->count(),
            'perguruan_tinggi' => $allPenelitian->where('kategori_mitra', 'perguruan_tinggi')->count(),
        ];

        return view('riset.kerjasama', [
            'collaborations' => $collaborations,
            'collaborationsByYear' => $collaborationsByYear,
            'prodis' => $prodis,
            'availableYears' => $availableYears,
            'selectedYear' => $selectedYear,
            'selectedKategori' => $selectedKategori,
            'selectedProdi' => $selectedProdi,
            'selectedStatus' => $selectedStatus,
            'totalKerjasama' => $totalKerjasama,
            'totalAktif' => $totalAktif,
            'totalIndustriBumn' => $totalIndustriBumn,
            'totalDokumen' => $totalDokumen,
            'kategoriCounts' => $kategoriCounts,
        ]);
    }

    /**
     * Mengunduh berkas dokumen legalitas/pendukung kerjasama (MoU/PKS).
     */
    public function downloadDocument(Collaboration $collaboration): StreamedResponse|RedirectResponse
    {
        if ($collaboration->file_dokumen && Storage::disk('public')->exists($collaboration->file_dokumen)) {
            $filename = 'Dokumen-Kerjasama-'.str($collaboration->nama_mitra)->slug()->limit(35).'-'.$collaboration->tahun.'.pdf';

            return Storage::disk('public')->download($collaboration->file_dokumen, $filename);
        }

        return back()->with('error', 'Berkas dokumen MoU/PKS belum tersedia untuk data kerjasama ini.');
    }
}
