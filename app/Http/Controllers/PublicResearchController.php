<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Research;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PublicResearchController extends Controller
{
    /**
     * Menampilkan direktori publik kegiatan penelitian P3M PKTJ
     * beserta grafik statistik, kartu metrik, dan tab sumber dana.
     */
    public function index(Request $request): View
    {
        // 1. Data Program Studi (D4 RSTJ, D4 TRO, D3 TO)
        $prodis = Prodi::where('status_aktif', true)->orderBy('id')->get();

        // 2. Query Utama Penelitian
        $query = Research::with(['prodi', 'user'])->orderByDesc('tahun')->latest('id');

        // Filter Program Studi
        if ($request->filled('prodi') && $request->prodi !== 'semua') {
            $prodiVal = $request->prodi;
            $query->whereHas('prodi', function ($q) use ($prodiVal) {
                if (is_numeric($prodiVal)) {
                    $q->where('id', $prodiVal);
                } else {
                    $q->where('kode_prodi', strtoupper($prodiVal));
                }
            });
        }

        // Filter Tahun
        if ($request->filled('tahun') && $request->tahun !== 'semua') {
            $query->where('tahun', $request->tahun);
        }

        // Filter Tab Kategori Sumber Dana
        $activeTab = $request->query('sumber_dana', 'semua');
        if ($activeTab !== 'semua') {
            if ($activeTab === 'dipa') {
                $query->where(function ($q) {
                    $q->where('sumber_dana', 'like', '%dipa%')
                        ->orWhere('sumber_dana', 'like', '%internal%');
                });
            } elseif ($activeTab === 'kemdiktisaintek') {
                $query->where(function ($q) {
                    $q->where('sumber_dana', 'like', '%kemdik%')
                        ->orWhere('sumber_dana', 'like', '%drtpm%')
                        ->orWhere('sumber_dana', 'like', '%bima%')
                        ->orWhere('sumber_dana', 'like', '%nasional%');
                });
            } elseif ($activeTab === 'industri') {
                $query->where(function ($q) {
                    $q->where('sumber_dana', 'like', '%industri%')
                        ->orWhere('sumber_dana', 'like', '%mitra%')
                        ->orWhere('sumber_dana', 'like', '%kerjasama%')
                        ->orWhere('sumber_dana', 'like', '%eksternal%');
                });
            } elseif ($activeTab === 'mandiri') {
                $query->where(function ($q) {
                    $q->where('sumber_dana', 'like', '%mandiri%')
                        ->orWhere('sumber_dana', 'like', '%swadana%');
                });
            }
        }

        // Pencarian Kata Kunci Judul / Ketua Peneliti
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                    ->orWhere('ketua_peneliti', 'like', "%{$keyword}%")
                    ->orWhere('anggota', 'like', "%{$keyword}%")
                    ->orWhere('abstrak', 'like', "%{$keyword}%");
            });
        }

        $researches = $query->get();

        // 3. Daftar Tahun Tersedia
        $availableYears = Research::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        // 4. Hitung Metrik Tab Sumber Dana (Bebas filter tab agar badge tetap akurat)
        $tabCounts = [
            'semua' => Research::count(),
            'dipa' => Research::where(function ($q) {
                $q->where('sumber_dana', 'like', '%dipa%')->orWhere('sumber_dana', 'like', '%internal%');
            })->count(),
            'kemdiktisaintek' => Research::where(function ($q) {
                $q->where('sumber_dana', 'like', '%kemdik%')
                    ->orWhere('sumber_dana', 'like', '%drtpm%')
                    ->orWhere('sumber_dana', 'like', '%bima%')
                    ->orWhere('sumber_dana', 'like', '%nasional%');
            })->count(),
            'industri' => Research::where(function ($q) {
                $q->where('sumber_dana', 'like', '%industri%')
                    ->orWhere('sumber_dana', 'like', '%mitra%')
                    ->orWhere('sumber_dana', 'like', '%kerjasama%')
                    ->orWhere('sumber_dana', 'like', '%eksternal%');
            })->count(),
            'mandiri' => Research::where(function ($q) {
                $q->where('sumber_dana', 'like', '%mandiri%')->orWhere('sumber_dana', 'like', '%swadana%');
            })->count(),
        ];

        // 5. Statistik Metrik Utama
        $allResearches = Research::all();
        $totalRiset = $allResearches->count();
        $totalDana = $allResearches->sum('anggaran');
        $avgDana = $totalRiset > 0 ? $totalDana / $totalRiset : 0;

        // 6. Statistik 3 Program Studi PKTJ
        $prodiStats = $prodis->map(function ($p) use ($allResearches) {
            $filtered = $allResearches->where('prodi_id', $p->id);

            return [
                'id' => $p->id,
                'kode' => $p->kode_prodi,
                'nama' => $p->nama_prodi,
                'total_riset' => $filtered->count(),
                'total_dana' => $filtered->sum('anggaran'),
            ];
        });

        // 7. Agregasi Tren Grafik per Tahun (Sorted Ascending untuk Chart)
        $yearlyStats = $availableYears->sort()->values()->map(function ($yr) use ($allResearches, $prodis) {
            $yearGroup = $allResearches->where('tahun', $yr);

            $dipaCount = $yearGroup->filter(fn ($r) => str_contains(strtolower($r->sumber_dana), 'dipa') || str_contains(strtolower($r->sumber_dana), 'internal'))->count();
            $kemdikCount = $yearGroup->filter(fn ($r) => str_contains(strtolower($r->sumber_dana), 'kemdik') || str_contains(strtolower($r->sumber_dana), 'nasional'))->count();
            $industriCount = $yearGroup->filter(fn ($r) => str_contains(strtolower($r->sumber_dana), 'industri') || str_contains(strtolower($r->sumber_dana), 'mitra') || str_contains(strtolower($r->sumber_dana), 'kerjasama') || str_contains(strtolower($r->sumber_dana), 'eksternal'))->count();
            $mandiriCount = $yearGroup->filter(fn ($r) => str_contains(strtolower($r->sumber_dana), 'mandiri') || str_contains(strtolower($r->sumber_dana), 'swadana'))->count();

            // Hitung per prodi
            $prodiCounts = [];
            foreach ($prodis as $pr) {
                $prodiCounts[$pr->kode_prodi] = $yearGroup->where('prodi_id', $pr->id)->count();
            }

            return [
                'tahun' => (string) $yr,
                'total_riset' => $yearGroup->count(),
                'total_dana' => $yearGroup->sum('anggaran'),
                'dipa' => $dipaCount,
                'kemdiktisaintek' => $kemdikCount,
                'industri' => $industriCount,
                'mandiri' => $mandiriCount,
                'rstj' => $prodiCounts['D4 RSTJ'] ?? 0,
                'tro' => $prodiCounts['D4 TRO'] ?? 0,
                'to' => $prodiCounts['D3 TO'] ?? 0,
            ];
        });

        // 8. Kelompokkan Data Hasil Pencarian Berdasarkan Tahun (Tersusun per Tahun Descending)
        $researchesByYear = $researches->groupBy('tahun');

        // 9. Payload Data untuk Inisialisasi Chart.js Interaktif
        $chartYearLabels = $yearlyStats->pluck('tahun')->values()->toArray();
        $chartDipa = $yearlyStats->pluck('dipa')->values()->toArray();
        $chartKemdik = $yearlyStats->pluck('kemdiktisaintek')->values()->toArray();
        $chartIndustri = $yearlyStats->pluck('industri')->values()->toArray();
        $chartMandiri = $yearlyStats->pluck('mandiri')->values()->toArray();
        $chartDanaRupiah = $yearlyStats->pluck('total_dana')->values()->toArray();

        $chartProdiLabels = $prodiStats->pluck('kode')->values()->toArray();
        $chartProdiCounts = $prodiStats->pluck('total_riset')->values()->toArray();
        $chartProdiDana = $prodiStats->pluck('total_dana')->values()->toArray();

        return view('riset.penelitian', [
            'researches' => $researches,
            'researchesByYear' => $researchesByYear,
            'prodis' => $prodis,
            'availableYears' => $availableYears,
            'activeTab' => $activeTab,
            'tabCounts' => $tabCounts,
            'totalRiset' => $totalRiset,
            'totalDana' => $totalDana,
            'avgDana' => $avgDana,
            'prodiStats' => $prodiStats,
            'yearlyStats' => $yearlyStats,
            'chartYearLabels' => $chartYearLabels,
            'chartDipa' => $chartDipa,
            'chartKemdik' => $chartKemdik,
            'chartIndustri' => $chartIndustri,
            'chartMandiri' => $chartMandiri,
            'chartDanaRupiah' => $chartDanaRupiah,
            'chartProdiLabels' => $chartProdiLabels,
            'chartProdiCounts' => $chartProdiCounts,
            'chartProdiDana' => $chartProdiDana,
        ]);
    }

    /**
     * Mengunduh berkas laporan penelitian publik.
     */
    public function downloadReport(Research $research): StreamedResponse|RedirectResponse
    {
        if ($research->berkas_laporan && Storage::disk('public')->exists($research->berkas_laporan)) {
            $filename = 'Laporan-Riset-'.str($research->judul)->slug()->limit(40).'.pdf';

            return Storage::disk('public')->download($research->berkas_laporan, $filename);
        }

        return back()->with('error', 'Berkas laporan penelitian belum tersedia untuk judul ini.');
    }
}
