<?php

namespace App\Http\Controllers;

use App\Models\CommunityServiceOutput;
use App\Models\Prodi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PublicCommunityServiceOutputController extends Controller
{
    /**
     * Menampilkan direktori dan dashboard hasil analisis luaran Pengabdian kepada Masyarakat (PkM)
     * beserta grafik tren, evaluasi dampak, metrik kepuasan mitra, dan filter multi-kriteria.
     */
    public function index(Request $request): View
    {
        // 1. Data 3 Program Studi PKTJ (D4 RSTJ, D4 TRO, D3 TO)
        $prodis = Prodi::where('status_aktif', true)->orderBy('id')->get();

        // 2. Query Utama Luaran Pengabdian
        $query = CommunityServiceOutput::with(['prodi', 'communityService'])->orderByDesc('tahun')->latest('id');

        // Filter Tab Kategori Luaran
        $activeTab = $request->query('kategori', 'semua');
        if ($activeTab !== 'semua') {
            $query->where('kategori', $activeTab);
        }

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

        // Filter Tahun Anggaran
        if ($request->filled('tahun') && $request->tahun !== 'semua') {
            $query->where('tahun', $request->tahun);
        }

        // Pencarian Kata Kunci
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                    ->orWhere('pelaksana', 'like', "%{$keyword}%")
                    ->orWhere('mitra_sasaran', 'like', "%{$keyword}%")
                    ->orWhere('lokasi', 'like', "%{$keyword}%")
                    ->orWhere('deskripsi_manfaat', 'like', "%{$keyword}%")
                    ->orWhere('indikator_keberhasilan', 'like', "%{$keyword}%");
            });
        }

        $outputs = $query->get();

        // 3. Daftar Tahun Tersedia
        $availableYears = CommunityServiceOutput::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        // 4. Hitung Metrik Tab Kategori Luaran (Global Counter)
        $tabCounts = [
            'semua' => CommunityServiceOutput::count(),
            'publikasi' => CommunityServiceOutput::where('kategori', 'publikasi')->count(),
            'ttg' => CommunityServiceOutput::where('kategori', 'ttg')->count(),
            'modul' => CommunityServiceOutput::where('kategori', 'modul')->count(),
            'hki' => CommunityServiceOutput::where('kategori', 'hki')->count(),
            'desa_binaan' => CommunityServiceOutput::where('kategori', 'desa_binaan')->count(),
        ];

        // 5. Statistik & Analisis Dampak Keseluruhan
        $allOutputs = CommunityServiceOutput::all();
        $totalLuaran = $allOutputs->count();
        $totalMitra = $allOutputs->pluck('mitra_sasaran')->filter()->unique()->count();
        $totalDesaBinaan = $allOutputs->where('kategori', 'desa_binaan')->count();
        $totalTtgModul = $allOutputs->whereIn('kategori', ['ttg', 'modul'])->count();

        // Rata-rata Kepuasan Mitra (diekstraksi dari persentase)
        $satisfactionValues = $allOutputs->map(function ($out) {
            preg_match('/(\d+)%/', $out->tingkat_kepuasan_mitra ?? '', $matches);

            return isset($matches[1]) ? (int) $matches[1] : 90;
        });
        $avgKepuasan = $satisfactionValues->count() > 0 ? round($satisfactionValues->average(), 1) : 94.5;

        // 6. Analisis Capaian 3 Program Studi PKTJ
        $prodiStats = $prodis->map(function ($p) use ($allOutputs) {
            $filtered = $allOutputs->where('prodi_id', $p->id);

            return [
                'id' => $p->id,
                'kode' => $p->kode_prodi,
                'nama' => $p->nama_prodi,
                'total' => $filtered->count(),
                'publikasi' => $filtered->where('kategori', 'publikasi')->count(),
                'ttg' => $filtered->where('kategori', 'ttg')->count(),
                'modul' => $filtered->where('kategori', 'modul')->count(),
                'hki' => $filtered->where('kategori', 'hki')->count(),
                'desa_binaan' => $filtered->where('kategori', 'desa_binaan')->count(),
            ];
        });

        // 7. Agregasi Tren Tahunan & Komposisi Kategori Luaran (Sorted Ascending untuk Grafik)
        $yearlyStats = $availableYears->sort()->values()->map(function ($yr) use ($allOutputs, $prodis) {
            $yearGroup = $allOutputs->where('tahun', $yr);

            $prodiCounts = [];
            foreach ($prodis as $pr) {
                $prodiCounts[$pr->kode_prodi] = $yearGroup->where('prodi_id', $pr->id)->count();
            }

            return [
                'tahun' => (string) $yr,
                'total' => $yearGroup->count(),
                'publikasi' => $yearGroup->where('kategori', 'publikasi')->count(),
                'ttg' => $yearGroup->where('kategori', 'ttg')->count(),
                'modul' => $yearGroup->where('kategori', 'modul')->count(),
                'hki' => $yearGroup->where('kategori', 'hki')->count(),
                'desa_binaan' => $yearGroup->where('kategori', 'desa_binaan')->count(),
                'rstj' => $prodiCounts['RSTJ'] ?? $prodiCounts['D4 RSTJ'] ?? 0,
                'tro' => $prodiCounts['TRO'] ?? $prodiCounts['D4 TRO'] ?? 0,
                'to' => $prodiCounts['TO'] ?? $prodiCounts['D3 TO'] ?? 0,
            ];
        });

        // 8. Kelompokkan Data Hasil Pencarian Berdasarkan Tahun (Tersusun per Tahun Descending)
        $outputsByYear = $outputs->groupBy('tahun');

        return view('pengabdian.luaran', [
            'outputs' => $outputs,
            'outputsByYear' => $outputsByYear,
            'prodis' => $prodis,
            'availableYears' => $availableYears,
            'activeTab' => $activeTab,
            'tabCounts' => $tabCounts,
            'totalLuaran' => $totalLuaran,
            'totalMitra' => $totalMitra,
            'totalDesaBinaan' => $totalDesaBinaan,
            'totalTtgModul' => $totalTtgModul,
            'avgKepuasan' => $avgKepuasan,
            'prodiStats' => $prodiStats,
            'yearlyStats' => $yearlyStats,
        ]);
    }

    /**
     * Mengunduh berkas bukti laporan hasil analisis luaran pengabdian masyarakat.
     */
    public function downloadFile(CommunityServiceOutput $communityServiceOutput): StreamedResponse|RedirectResponse
    {
        if ($communityServiceOutput->berkas_luaran && Storage::disk('public')->exists($communityServiceOutput->berkas_luaran)) {
            $cleanTitle = str($communityServiceOutput->judul)->slug()->limit(40);
            $filename = 'Luaran-PkM-'.$cleanTitle.'.pdf';

            return Storage::disk('public')->download($communityServiceOutput->berkas_luaran, $filename);
        }

        return back()->with('error', 'Berkas bukti luaran belum tersedia untuk pengabdian ini.');
    }
}
