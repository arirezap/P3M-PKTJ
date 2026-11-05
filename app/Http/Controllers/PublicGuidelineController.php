<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PublicGuidelineController extends Controller
{
    /**
     * Menampilkan repositori Layanan > Panduan dan Pedoman P3M PKTJ,
     * menyajikan 4 dokumen mandat utama, filter kategori, pencarian, dan infografis alur proses.
     */
    public function index(Request $request): View
    {
        // 1. Dokumen Utama (4 Mandat Institusi)
        $docPedomanPenelitian = Document::where('kategori', 'pedoman_penelitian')->latest('id')->first();
        $docPedomanPengabdian = Document::where('kategori', 'pedoman_pengabdian')->latest('id')->first();
        $docProsesPengabdian = Document::where('kategori', 'proses_pengabdian')->latest('id')->first();
        $docPanduanSistem = Document::whereIn('kategori', ['panduan_sistem', 'panduan'])->latest('id')->first();

        $featuredDocs = [
            'pedoman_penelitian' => [
                'key' => 'pedoman_penelitian',
                'title' => 'Pedoman Penelitian & SDM',
                'subtitle' => 'Pengembangan Kapasitas Peneliti & Kode Etik',
                'doc' => $docPedomanPenelitian,
                'default_desc' => 'Pedoman tata kelola penelitian terapan vokasi transportasi jalan, pembinaan integritas akademik, serta peningkatan jenjang kepakaran dosen dan taruna PKTJ.',
                'badge' => 'Pedoman Mutu Riset',
                'icon_color' => 'indigo',
            ],
            'pedoman_pengabdian' => [
                'key' => 'pedoman_pengabdian',
                'title' => 'Pedoman PkM & Kepakaran',
                'subtitle' => 'Hilirisasi Sains & Peningkatan Kualitas Kepakaran',
                'doc' => $docPedomanPengabdian,
                'default_desc' => 'Panduan komprehensif pelaksanaan pengabdian kepada masyarakat berbasis kepakaran keselamatan transportasi, pendampingan desa binaan, dan standardisasi bengkel rakyat.',
                'badge' => 'Pedoman Mutu PkM',
                'icon_color' => 'emerald',
            ],
            'proses_pengabdian' => [
                'key' => 'proses_pengabdian',
                'title' => 'Proses Pengabdian kepada Masyarakat',
                'subtitle' => 'Standar Tahapan Pelaksanaan & Pelaporan',
                'doc' => $docProsesPengabdian,
                'default_desc' => 'Bagan alur dan tata laksana pengusulan, verifikasi kelayakan mitra, monev lapangan, hingga penyusunan laporan akhir dan publikasi luaran berdaya guna.',
                'badge' => 'Standar Operasional',
                'icon_color' => 'teal',
            ],
            'panduan_sistem' => [
                'key' => 'panduan_sistem',
                'title' => 'Buku Panduan SIM P3M',
                'subtitle' => 'Panduan Teknis Operasional Portal Digital',
                'doc' => $docPanduanSistem,
                'default_desc' => 'Buku petunjuk teknis pengoperasian sistem informasi terpadu SIM P3M bagi Dosen Pengusul, Reviewer Substansi, dan Admin Verifikator.',
                'badge' => 'Panduan Sistem',
                'icon_color' => 'blue',
            ],
        ];

        // 2. Query Daftar Dokumen Lengkap (dengan Filter & Pencarian)
        $query = Document::query()->latest('id');

        // Filter Kategori
        $selectedKategori = $request->query('kategori', 'semua');
        if ($selectedKategori !== 'semua' && ! empty($selectedKategori)) {
            if ($selectedKategori === 'sop') {
                $query->where(function ($q) {
                    $q->where('kategori', 'like', 'sop%');
                });
            } elseif ($selectedKategori === 'renstra') {
                $query->where(function ($q) {
                    $q->where('kategori', 'like', 'renstra%')
                        ->orWhere('kategori', 'roadmap');
                });
            } elseif ($selectedKategori === 'panduan_sistem') {
                $query->whereIn('kategori', ['panduan_sistem', 'panduan']);
            } else {
                $query->where('kategori', $selectedKategori);
            }
        }

        // Filter Pencarian
        $searchQuery = trim($request->query('q', ''));
        if (! empty($searchQuery)) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('judul', 'like', "%{$searchQuery}%")
                    ->orWhere('deskripsi', 'like', "%{$searchQuery}%")
                    ->orWhere('tahun', 'like', "%{$searchQuery}%");
            });
        }

        $documents = $query->paginate(9)->withQueryString();

        // 3. Statistik Ringkasan
        $stats = [
            'total_dokumen' => Document::count(),
            'total_unduhan' => Document::sum('download_count'),
            'tahun_terkini' => Document::max('tahun') ?? date('Y'),
        ];

        return view('layanan.panduan-pedoman', compact(
            'featuredDocs',
            'documents',
            'stats',
            'selectedKategori',
            'searchQuery'
        ));
    }

    /**
     * Menampilkan repositori Layanan > Standar Operasional Prosedur (SOP) P3M PKTJ,
     * menyajikan pemisahan tegas antara SOP Bidang Penelitian dan SOP Bidang Pengabdian kepada Masyarakat.
     */
    public function sop(Request $request): View
    {
        $searchQuery = trim($request->query('q', ''));

        $queryPenelitian = Document::where('kategori', 'sop_penelitian')->latest('id');
        $queryPengabdian = Document::where('kategori', 'sop_pengabdian')->latest('id');

        if (! empty($searchQuery)) {
            $queryPenelitian->where(function ($q) use ($searchQuery) {
                $q->where('judul', 'like', "%{$searchQuery}%")
                    ->orWhere('deskripsi', 'like', "%{$searchQuery}%")
                    ->orWhere('tahun', 'like', "%{$searchQuery}%");
            });

            $queryPengabdian->where(function ($q) use ($searchQuery) {
                $q->where('judul', 'like', "%{$searchQuery}%")
                    ->orWhere('deskripsi', 'like', "%{$searchQuery}%")
                    ->orWhere('tahun', 'like', "%{$searchQuery}%");
            });
        }

        $sopPenelitian = $queryPenelitian->get();
        $sopPengabdian = $queryPengabdian->get();

        $stats = [
            'total_penelitian' => Document::where('kategori', 'sop_penelitian')->count(),
            'total_pengabdian' => Document::where('kategori', 'sop_pengabdian')->count(),
            'total_sop' => Document::whereIn('kategori', ['sop_penelitian', 'sop_pengabdian'])->count(),
            'total_unduhan' => Document::whereIn('kategori', ['sop_penelitian', 'sop_pengabdian'])->sum('download_count'),
        ];

        return view('layanan.sop', compact(
            'sopPenelitian',
            'sopPengabdian',
            'stats',
            'searchQuery'
        ));
    }

    /**
     * Mengunduh berkas pedoman dan mencatat akumulasi jumlah unduhan.
     */
    public function download(Document $document): StreamedResponse|RedirectResponse
    {
        $document->increment('download_count');

        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            $extension = pathinfo($document->file_path, PATHINFO_EXTENSION);
            $cleanName = str($document->judul)->slug().'.'.($extension ?: 'pdf');

            return Storage::disk('public')->download($document->file_path, $cleanName);
        }

        return redirect(asset('storage/'.$document->file_path));
    }
}
