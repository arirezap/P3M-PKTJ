<?php

namespace App\Http\Controllers;

use App\Models\Output;
use App\Models\Prodi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PublicOutputController extends Controller
{
    /**
     * Tampilkan halaman publik luaran penelitian (Publikasi, HKI, Produk/Jasa).
     */
    public function index(Request $request): View
    {
        $activeTab = $request->get('kategori', 'semua');
        $selectedProdi = $request->get('prodi');
        $selectedTahun = $request->get('tahun');
        $selectedLisensi = $request->get('lisensi');
        $search = $request->get('q');

        $query = Output::with(['prodi', 'user']);

        // 1. Filter Tab Pilar Kategori
        if ($activeTab !== 'semua' && in_array($activeTab, ['publikasi', 'hki', 'produk'])) {
            $query->where('kategori', $activeTab);
        }

        // 2. Filter Program Studi PKTJ (D4 RSTJ, D4 TRO, D3 TO)
        if ($selectedProdi && $selectedProdi !== 'semua') {
            $query->whereHas('prodi', function ($q) use ($selectedProdi) {
                $q->where('kode_prodi', $selectedProdi)
                    ->orWhere('id', $selectedProdi);
            });
        }

        // 3. Filter Tahun Realisasi
        if ($selectedTahun && $selectedTahun !== 'semua') {
            $query->where('tahun', $selectedTahun);
        }

        // 4. Filter Lisensi Terbuka
        if ($selectedLisensi && $selectedLisensi !== 'semua') {
            if ($selectedLisensi === 'terbuka') {
                $query->where(function ($q) {
                    $q->where('lisensi', 'like', '%Open%')
                        ->orWhere('lisensi', 'like', '%CC%')
                        ->orWhere('lisensi', 'like', '%MIT%')
                        ->orWhere('lisensi', 'like', '%GPL%')
                        ->orWhere('lisensi', 'like', '%Public Domain%');
                });
            }
        }

        // 5. Pencarian Kata Kunci
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('author_inventor', 'like', "%{$search}%")
                    ->orWhere('mitra_kerjasama', 'like', "%{$search}%")
                    ->orWhere('nama_jurnal_penerbit', 'like', "%{$search}%")
                    ->orWhere('nomor_registrasi_hki', 'like', "%{$search}%")
                    ->orWhere('deskripsi_kemanfaatan', 'like', "%{$search}%");
            });
        }

        // Urutkan tahun terbaru dan id terbaru
        $outputs = $query->orderByDesc('tahun')->orderByDesc('id')->paginate(12)->withQueryString();

        // 6. Agregasi Metrik & Payload Chart.js Interaktif
        $allOutputs = Output::all();
        $totalOutputs = $allOutputs->count();
        $totalPublikasi = $allOutputs->where('kategori', 'publikasi')->count();
        $totalHki = $allOutputs->where('kategori', 'hki')->count();
        $totalProduk = $allOutputs->where('kategori', 'produk')->count();
        $totalDanaRealisasi = (int) $allOutputs->sum('realisasi_dana');

        $openLicenseCount = $allOutputs->filter(function ($item) {
            $lisensi = strtolower($item->lisensi ?? '');

            return str_contains($lisensi, 'open')
                || str_contains($lisensi, 'cc')
                || str_contains($lisensi, 'mit')
                || str_contains($lisensi, 'gpl')
                || str_contains($lisensi, 'public domain');
        })->count();

        // Hitungan per Tab
        $tabCounts = [
            'semua' => $totalOutputs,
            'publikasi' => $totalPublikasi,
            'hki' => $totalHki,
            'produk' => $totalProduk,
        ];

        // Statistik 3 Program Studi PKTJ (D4 RSTJ, D4 TRO, D3 TO)
        $prodis = Prodi::where('status_aktif', true)->orderBy('id')->get();
        $prodiStats = [];
        $chartProdiLabels = [];
        $chartProdiPublikasi = [];
        $chartProdiHki = [];
        $chartProdiProduk = [];
        $chartProdiDana = [];

        foreach ($prodis as $p) {
            $prodiOutputs = $allOutputs->where('prodi_id', $p->id);
            $pubCount = $prodiOutputs->where('kategori', 'publikasi')->count();
            $hkiCount = $prodiOutputs->where('kategori', 'hki')->count();
            $prodCount = $prodiOutputs->where('kategori', 'produk')->count();
            $danaTotal = (int) $prodiOutputs->sum('realisasi_dana');

            $prodiStats[] = [
                'id' => $p->id,
                'kode' => $p->kode_prodi,
                'nama' => $p->nama_prodi,
                'jenjang' => $p->jenjang,
                'count' => $prodiOutputs->count(),
                'dana' => $danaTotal,
            ];

            $chartProdiLabels[] = ($p->jenjang ? $p->jenjang.' ' : '').$p->kode_prodi;
            $chartProdiPublikasi[] = $pubCount;
            $chartProdiHki[] = $hkiCount;
            $chartProdiProduk[] = $prodCount;
            $chartProdiDana[] = $danaTotal;
        }

        // Payload Chart 1: Proporsi 3 Pilar Luaran
        $chartPilarLabels = ['Publikasi Ilmiah', 'Hak Kekayaan Intelektual (HKI)', 'Produk & Jasa Teknologi'];
        $chartPilarCounts = [$totalPublikasi, $totalHki, $totalProduk];

        // Daftar tahun untuk dropdown filter
        $tahunList = Output::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        return view('riset.luaran', compact(
            'outputs',
            'activeTab',
            'selectedProdi',
            'selectedTahun',
            'selectedLisensi',
            'search',
            'totalOutputs',
            'totalPublikasi',
            'totalHki',
            'totalProduk',
            'totalDanaRealisasi',
            'openLicenseCount',
            'tabCounts',
            'prodis',
            'prodiStats',
            'chartPilarLabels',
            'chartPilarCounts',
            'chartProdiLabels',
            'chartProdiPublikasi',
            'chartProdiHki',
            'chartProdiProduk',
            'chartProdiDana',
            'tahunList'
        ));
    }

    /**
     * Unduh berkas dokumen bukti luaran penelitian (PDF).
     */
    public function downloadFile(Output $output): StreamedResponse|RedirectResponse
    {
        if (! $output->berkas_luaran || ! Storage::disk('public')->exists($output->berkas_luaran)) {
            return back()->with('error', 'Berkas dokumen bukti luaran penelitian belum tersedia atau belum diunggah.');
        }

        $filename = Str::slug($output->judul).'-'.$output->tahun.'.pdf';

        return Storage::disk('public')->download($output->berkas_luaran, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
