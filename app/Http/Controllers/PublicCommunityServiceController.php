<?php

namespace App\Http\Controllers;

use App\Models\CommunityService;
use App\Models\Prodi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PublicCommunityServiceController extends Controller
{
    /**
     * Menampilkan direktori publik kegiatan Pengabdian kepada Masyarakat (PkM) P3M PKTJ
     * beserta kartu statistik metrik, diagram tren & komposisi sumber dana, dan filter interaktif.
     */
    public function index(Request $request): View
    {
        // 1. Data 3 Program Studi PKTJ (D4 RSTJ, D4 TRO, D3 TO)
        $prodis = Prodi::where('status_aktif', true)->orderBy('id')->get();

        // 2. Query Utama Kegiatan PkM
        $query = CommunityService::with('prodi')->orderByDesc('tahun')->latest('id');

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
                      ->orWhere('sumber_dana', 'like', '%csr%')
                      ->orWhere('sumber_dana', 'like', '%kerjasama%');
                });
            } elseif ($activeTab === 'mandiri') {
                $query->where(function ($q) {
                    $q->where('sumber_dana', 'like', '%mandiri%')
                      ->orWhere('sumber_dana', 'like', '%swadana%');
                });
            }
        }

        // Pencarian Kata Kunci Judul / Ketua / Lokasi / Mitra / Ringkasan
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                  ->orWhere('ketua_pelaksana', 'like', "%{$keyword}%")
                  ->orWhere('anggota', 'like', "%{$keyword}%")
                  ->orWhere('mitra', 'like', "%{$keyword}%")
                  ->orWhere('lokasi_kegiatan', 'like', "%{$keyword}%")
                  ->orWhere('ringkasan', 'like', "%{$keyword}%")
                  ->orWhere('skema', 'like', "%{$keyword}%");
            });
        }

        $services = $query->get();

        // 3. Daftar Tahun Tersedia
        $availableYears = CommunityService::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        // 4. Hitung Metrik Tab Sumber Dana (Bebas filter tab aktif)
        $tabCounts = [
            'semua' => CommunityService::count(),
            'dipa' => CommunityService::where(function ($q) {
                $q->where('sumber_dana', 'like', '%dipa%')->orWhere('sumber_dana', 'like', '%internal%');
            })->count(),
            'kemdiktisaintek' => CommunityService::where(function ($q) {
                $q->where('sumber_dana', 'like', '%kemdik%')
                  ->orWhere('sumber_dana', 'like', '%drtpm%')
                  ->orWhere('sumber_dana', 'like', '%bima%')
                  ->orWhere('sumber_dana', 'like', '%nasional%');
            })->count(),
            'industri' => CommunityService::where(function ($q) {
                $q->where('sumber_dana', 'like', '%industri%')
                  ->orWhere('sumber_dana', 'like', '%mitra%')
                  ->orWhere('sumber_dana', 'like', '%csr%')
                  ->orWhere('sumber_dana', 'like', '%kerjasama%');
            })->count(),
            'mandiri' => CommunityService::where(function ($q) {
                $q->where('sumber_dana', 'like', '%mandiri%')->orWhere('sumber_dana', 'like', '%swadana%');
            })->count(),
        ];

        // 5. Statistik Metrik Utama Keseluruhan
        $allServices = CommunityService::all();
        $totalKegiatan = $allServices->count();
        $totalDana = $allServices->sum('anggaran');
        $avgDana = $totalKegiatan > 0 ? $totalDana / $totalKegiatan : 0;
        $totalMitra = $allServices->pluck('mitra')->filter()->unique()->count();
        $totalLokasi = $allServices->pluck('lokasi_kegiatan')->filter()->unique()->count();

        // 6. Statistik 3 Program Studi PKTJ
        $prodiStats = $prodis->map(function ($p) use ($allServices) {
            $filtered = $allServices->where('prodi_id', $p->id);
            return [
                'id' => $p->id,
                'kode' => $p->kode_prodi,
                'nama' => $p->nama_prodi,
                'total_kegiatan' => $filtered->count(),
                'total_dana' => $filtered->sum('anggaran'),
            ];
        });

        // 7. Agregasi Tren Tahunan & Komposisi Sumber Dana (Sorted Ascending untuk Grafik)
        $yearlyStats = $availableYears->sort()->values()->map(function ($yr) use ($allServices, $prodis) {
            $yearGroup = $allServices->where('tahun', $yr);

            $dipaCount = $yearGroup->filter(fn($r) => str_contains(strtolower($r->sumber_dana), 'dipa') || str_contains(strtolower($r->sumber_dana), 'internal'))->count();
            $kemdikCount = $yearGroup->filter(fn($r) => str_contains(strtolower($r->sumber_dana), 'kemdik') || str_contains(strtolower($r->sumber_dana), 'nasional'))->count();
            $industriCount = $yearGroup->filter(fn($r) => str_contains(strtolower($r->sumber_dana), 'industri') || str_contains(strtolower($r->sumber_dana), 'mitra') || str_contains(strtolower($r->sumber_dana), 'csr') || str_contains(strtolower($r->sumber_dana), 'kerjasama'))->count();
            $mandiriCount = $yearGroup->filter(fn($r) => str_contains(strtolower($r->sumber_dana), 'mandiri') || str_contains(strtolower($r->sumber_dana), 'swadana'))->count();

            // Hitung per prodi
            $prodiCounts = [];
            foreach ($prodis as $pr) {
                $prodiCounts[$pr->kode_prodi] = $yearGroup->where('prodi_id', $pr->id)->count();
            }

            return [
                'tahun' => (string) $yr,
                'total_kegiatan' => $yearGroup->count(),
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
        $servicesByYear = $services->groupBy('tahun');

        return view('pengabdian.pkm', [
            'services' => $services,
            'servicesByYear' => $servicesByYear,
            'prodis' => $prodis,
            'availableYears' => $availableYears,
            'activeTab' => $activeTab,
            'tabCounts' => $tabCounts,
            'totalKegiatan' => $totalKegiatan,
            'totalDana' => $totalDana,
            'avgDana' => $avgDana,
            'totalMitra' => $totalMitra,
            'totalLokasi' => $totalLokasi,
            'prodiStats' => $prodiStats,
            'yearlyStats' => $yearlyStats,
        ]);
    }

    /**
     * Mengunduh berkas laporan hasil kegiatan pengabdian kepada masyarakat.
     */
    public function downloadReport(CommunityService $communityService): StreamedResponse|RedirectResponse
    {
        if ($communityService->berkas_laporan && Storage::disk('public')->exists($communityService->berkas_laporan)) {
            $cleanTitle = str($communityService->judul)->slug()->limit(40);
            $filename = 'Laporan-PkM-' . $cleanTitle . '.pdf';
            return Storage::disk('public')->download($communityService->berkas_laporan, $filename);
        }

        return back()->with('error', 'Berkas laporan pengabdian belum tersedia untuk kegiatan ini.');
    }
}
