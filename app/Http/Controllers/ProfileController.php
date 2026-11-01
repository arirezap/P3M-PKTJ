<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\OrganizationMember;
use App\Models\Output;
use App\Models\Prodi;
use App\Models\Research;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman Profil > Rencana Strategis (Renstra Penelitian & Renstra Pengabdian).
     */
    public function rencanaStrategis(): View
    {
        // 1. Dokumen Rencana Strategis Penelitian 2026-2031
        $renstraPenelitian = Document::where('kategori', 'renstra_penelitian')
            ->orWhere(function ($q) {
                $q->where('kategori', 'renstra')
                  ->where('judul', 'like', '%penelitian%');
            })
            ->latest()
            ->first();

        // 2. Dokumen Rencana Strategis Pengabdian kepada Masyarakat
        $renstraPengabdian = Document::where('kategori', 'renstra_pengabdian')
            ->orWhere(function ($q) {
                $q->where('kategori', 'renstra')
                  ->where('judul', 'like', '%pengabdian%');
            })
            ->latest()
            ->first();

        // 3. Dokumen Terkait Regulasi & SOP Pendukung
        $dokumenPendukung = Document::whereNotIn('id', array_filter([
                $renstraPenelitian?->id,
                $renstraPengabdian?->id,
            ]))
            ->latest()
            ->take(3)
            ->get();

        return view('profil.rencana-strategis', compact(
            'renstraPenelitian',
            'renstraPengabdian',
            'dokumenPendukung'
        ));
    }

    /**
     * Menampilkan halaman Profil > Roadmap Penelitian (Peta Jalan Riset Keselamatan PKTJ).
     */
    public function roadmapPenelitian(): View
    {
        // 1. Dokumen Utama Roadmap Penelitian
        $roadmapDokumen = Document::where('kategori', 'roadmap')
            ->orWhere(function ($q) {
                $q->where('judul', 'like', '%roadmap%');
            })
            ->latest()
            ->first();

        // 2. Dokumen Rencana Strategis Terkait
        $renstraDokumen = Document::whereIn('kategori', ['renstra_penelitian', 'renstra'])
            ->latest()
            ->first();

        // 3. Dokumen Regulasi & SOP Pendukung
        $dokumenPendukung = Document::whereNotIn('id', array_filter([
                $roadmapDokumen?->id,
                $renstraDokumen?->id,
            ]))
            ->latest()
            ->take(3)
            ->get();

        return view('profil.roadmap-penelitian', compact(
            'roadmapDokumen',
            'renstraDokumen',
            'dokumenPendukung'
        ));
    }

    /**
     * Menampilkan halaman Profil > Visi, Misi & Tujuan P3M PKTJ.
     */
    public function visiMisi(): View
    {
        $settings = \App\Models\Setting::where('group', 'visi_misi')->pluck('value', 'key')->toArray();

        $defaultSettings = [
            'visi_title' => 'Visi P3M Politeknik Keselamatan Transportasi Jalan',
            'visi_statement' => 'Menjadi pusat rujukan riset terapan dan pengabdian masyarakat unggulan berbasis keselamatan transportasi jalan yang solutif, berdaya saing global, dan berintegritas pada tahun 2031.',
            'visi_subtext' => 'Mengakselerasi terwujudnya transportasi darat nasional yang selamat, tertib, dan berkelanjutan melalui keunggulan riset vokasi sivitas akademika PKTJ di bawah Badan Pengembangan SDM Perhubungan.',
            'misi_1' => 'Menyelenggarakan penelitian terapan yang inovatif dan solutif guna memitigasi titik rawan kecelakaan (black spot) dan meningkatkan keselamatan transportasi darat.',
            'misi_2' => 'Melaksanakan pengabdian kepada masyarakat berbasis aksi nyata, edukasi budaya keselamatan berkendara, pendampingan desa binaan, dan standardisasi bengkel rakyat.',
            'misi_3' => 'Mengembangkan kemitraan riset sinergis dengan Kementerian Perhubungan, Korlantas Polri, KNKT, pemerintah daerah, dan industri manufaktur otomotif nasional.',
            'misi_4' => 'Mendorong hilirisasi invensi teknologi keselamatan, percepatan perolehan Hak Kekayaan Intelektual (HKI/Paten), serta publikasi berkala pada jurnal ilmiah terakreditasi.',
            'misi_5' => 'Mengoptimalkan tata kelola kelembagaan P3M yang transparan, akuntabel, dan berbasis sistem informasi digital (SIM P3M) berstandar mutu pendidikan tinggi vokasi.',
            'tujuan_lead' => 'Tujuan strategis P3M PKTJ dirumuskan untuk menjamin ketercapaian sasaran mutu kelembagaan dan kontribusi nyata bagi keselamatan lalu lintas nasional.',
            'tujuan_1_title' => 'Reduksi Fatalitas Kecelakaan',
            'tujuan_1_desc' => 'Menghasilkan rekomendasi teknis audit keselamatan jalan dan rekayasa simpang yang menurunkan angka fatalitas korban lalu lintas nasional.',
            'tujuan_2_title' => 'Kemandirian Riset Vokasi',
            'tujuan_2_desc' => 'Meningkatkan kuantitas dan kualitas penelitian terapan dosen dan taruna yang didanai DIPA Kemenhub, Kemdiktisaintek, maupun mitra industri.',
            'tujuan_3_title' => 'Penguatan HKI & Jurnal Ilmiah',
            'tujuan_3_desc' => 'Meningkatkan perolehan paten invensi, hak cipta desain industri, dan publikasi artikel ilmiah pada Indonesian Road Safety Journal terindeks SINTA.',
            'tujuan_4_title' => 'Pemberdayaan Masyarakat Pantura',
            'tujuan_4_desc' => 'Memperluas jangkauan desa binaan tertib lalu lintas dan transfer teknologi standardisasi uji kelaikan armada ke bengkel UMKM mitra.',
        ];

        $merged = array_merge($defaultSettings, $settings);

        $renstraDokumen = Document::whereIn('kategori', ['renstra_penelitian', 'renstra'])->latest()->first();
        $roadmapDokumen = Document::where('kategori', 'roadmap')->latest()->first();

        return view('profil.visi-misi', [
            'settings' => $merged,
            'renstraDokumen' => $renstraDokumen,
            'roadmapDokumen' => $roadmapDokumen,
        ]);
    }

    /**
     * Menampilkan halaman Profil > Profil Peneliti (Direktori Dosen & Peneliti Aktif).
     */
    public function peneliti(Request $request): View
    {
        $query = User::with(['prodi', 'researches', 'outputs'])
            ->where('status_aktif', true)
            ->whereIn('role', ['dosen', 'reviewer'])
            ->orderBy('name');

        if ($request->filled('prodi') && $request->prodi !== 'semua') {
            $prodiCode = strtoupper($request->prodi);
            $query->whereHas('prodi', function ($q) use ($prodiCode) {
                $q->where('kode_prodi', $prodiCode);
            });
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nidn_nip', 'like', "%{$search}%")
                  ->orWhere('keahlian', 'like', "%{$search}%");
            });
        }

        $peneliti = $query->paginate(12)->withQueryString();

        // 3 Program Studi PKTJ
        $prodis = Prodi::where('status_aktif', true)->orderBy('id')->get();

        // Statistik Metrik
        $totalPeneliti = User::where('status_aktif', true)->whereIn('role', ['dosen', 'reviewer'])->count();
        $totalRiset = Research::count();
        $totalPublikasi = Output::count();

        return view('profil.peneliti', compact(
            'peneliti',
            'prodis',
            'totalPeneliti',
            'totalRiset',
            'totalPublikasi'
        ));
    }

    /**
     * Menampilkan halaman Profil > Sumber Daya Manusia (Struktur Organisasi P3M PKTJ).
     */
    public function sdm(): View
    {
        $members = OrganizationMember::active()->ordered()->get();

        $settings = Setting::where('group', 'organization')->pluck('value', 'key')->toArray();

        $defaultSettings = [
            'org_title' => 'Struktur Organisasi & Tata Kelola P3M PKTJ',
            'org_sk_number' => 'SK Direktur PKTJ No. KP.004/1/12/PKTJ-2026',
            'org_period' => '2026 – 2031',
            'org_chart_image' => null,
            'org_lead_text' => 'Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) merupakan unit pelaksana strategis bidang riset terapan dan pengabdian masyarakat di lingkungan Politeknik Keselamatan Transportasi Jalan, berkedudukan langsung di bawah Direktur PKTJ dan dikoordinasikan oleh Wakil Direktur I Bidang Akademik sesuai ketentuan tata kelola Badan Pengembangan SDM Perhubungan.',
        ];

        $mergedSettings = array_merge($defaultSettings, $settings);

        // Group members by level or role for clear hierarchy visualization
        $pengarah = $members->filter(fn($m) => str_contains(strtolower($m->jabatan), 'pengarah') || str_contains(strtolower($m->jabatan), 'pelindung') || str_contains(strtolower($m->jabatan), 'penanggung jawab') || str_contains(strtolower($m->jabatan), 'direktur'));
        $pimpinan = $members->filter(fn($m) => !$pengarah->contains($m) && (str_contains(strtolower($m->jabatan), 'kepala pusat') || str_contains(strtolower($m->jabatan), 'kepala p3m') || str_contains(strtolower($m->jabatan), 'sekretaris')));
        $koordinator = $members->filter(fn($m) => !$pengarah->contains($m) && !$pimpinan->contains($m) && (str_contains(strtolower($m->jabatan), 'koordinator') || str_contains(strtolower($m->jabatan), 'bidang')));
        $staf = $members->reject(fn($m) => $pengarah->contains($m) || $pimpinan->contains($m) || $koordinator->contains($m));

        return view('profil.sdm', [
            'members' => $members,
            'settings' => $mergedSettings,
            'pengarah' => $pengarah,
            'pimpinan' => $pimpinan,
            'koordinator' => $koordinator,
            'staf' => $staf,
        ]);
    }

    /**
     * Mengunduh berkas dokumen dan mencatat penambahan jumlah unduhan.
     */
    public function downloadDocument(Document $document): StreamedResponse|RedirectResponse
    {
        $document->increment('download_count');

        if (Storage::disk('public')->exists($document->file_path)) {
            $filename = str($document->judul)->slug() . '.' . pathinfo($document->file_path, PATHINFO_EXTENSION);
            return Storage::disk('public')->download($document->file_path, $filename);
        }

        return redirect(asset('storage/' . $document->file_path));
    }
}
