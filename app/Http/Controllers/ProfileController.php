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
        $settings = Setting::where('group', 'renstra')->pluck('value', 'key')->toArray();

        $defaultSettings = [
            'renstra_badge' => 'Arah Kebijakan Kelembagaan 2026 - 2031',
            'renstra_title' => 'Rencana Strategis Penelitian & Pengabdian kepada Masyarakat',
            'renstra_lead' => 'Dokumen Rencana Strategis Penelitian 2026-2031 dan Dokumen Rencana Strategis Pengabdian Kepada Masyarakat Politeknik Keselamatan Transportasi Jalan.',
            'renstra_custom_html' => '',
        ];

        $mergedSettings = array_merge($defaultSettings, $settings);

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

        return view('profil.rencana-strategis', [
            'settings' => $mergedSettings,
            'renstraPenelitian' => $renstraPenelitian,
            'renstraPengabdian' => $renstraPengabdian,
        ]);
    }

    /**
     * Menampilkan halaman Profil > Roadmap Penelitian (Peta Jalan Riset Keselamatan PKTJ).
     */
    public function roadmapPenelitian(): View
    {
        $settings = Setting::where('group', 'roadmap')->pluck('value', 'key')->toArray();

        $defaultSettings = [
            'roadmap_badge' => 'Peta Jalan Riset Terapan PKTJ',
            'roadmap_title' => 'Roadmap Penelitian',
            'roadmap_lead' => 'Dokumen Roadmap Penelitian Politeknik Keselamatan Transportasi Jalan.',
            'roadmap_custom_html' => '',
        ];

        $mergedSettings = array_merge($defaultSettings, $settings);

        // Dokumen Utama Roadmap Penelitian
        $roadmapDokumen = Document::where('kategori', 'roadmap')
            ->orWhere(function ($q) {
                $q->where('judul', 'like', '%roadmap%');
            })
            ->latest()
            ->first();

        return view('profil.roadmap-penelitian', [
            'settings' => $mergedSettings,
            'roadmapDokumen' => $roadmapDokumen,
        ]);
    }

    /**
     * Menampilkan halaman Profil > Visi, Misi & Tujuan P3M PKTJ.
     */
    public function visiMisi(): View
    {
        $settings = Setting::where('group', 'visi_misi')->pluck('value', 'key')->toArray();

        $defaultSettings = [
            'visi_badge' => 'Arah Haluan Riset & Pengabdian PKTJ 2026 - 2031',
            'page_title' => 'Visi, Misi & Tujuan P3M',
            'page_lead' => 'Visi, Misi, dan Tujuan Pusat Penelitian dan Pengabdian kepada Masyarakat Politeknik Keselamatan Transportasi Jalan.',
            'visi_title' => 'Visi P3M Politeknik Keselamatan Transportasi Jalan',
            'visi_statement' => 'Menjadi pusat rujukan riset terapan dan pengabdian masyarakat unggulan berbasis keselamatan transportasi jalan yang solutif, berdaya saing global, dan berintegritas pada tahun 2031.',
            'visi_subtext' => 'Mengakselerasi terwujudnya transportasi darat nasional yang selamat, tertib, dan berkelanjutan melalui keunggulan riset vokasi sivitas akademika PKTJ di bawah Badan Pengembangan SDM Perhubungan.',
            'tujuan_lead' => 'Tujuan strategis P3M PKTJ dirumuskan untuk menjamin ketercapaian sasaran mutu kelembagaan dan kontribusi nyata bagi keselamatan lalu lintas nasional.',
        ];

        $merged = array_merge($defaultSettings, $settings);

        // Resolusi butir Misi dinamis dengan fallback ke format legacy/default
        $misiList = [];
        if (! empty($settings['misi_items'])) {
            $decoded = json_decode($settings['misi_items'], true);
            if (is_array($decoded) && count($decoded) > 0) {
                $misiList = array_values(array_filter($decoded, fn ($v) => ! is_null($v) && trim($v) !== ''));
            }
        }
        if (empty($misiList)) {
            for ($i = 1; $i <= 10; $i++) {
                if (! empty($settings["misi_{$i}"])) {
                    $misiList[] = $settings["misi_{$i}"];
                }
            }
        }
        if (empty($misiList)) {
            $misiList = [
                'Menyelenggarakan penelitian terapan yang inovatif dan solutif guna memitigasi titik rawan kecelakaan (black spot) dan meningkatkan keselamatan transportasi darat.',
                'Melaksanakan pengabdian kepada masyarakat berbasis aksi nyata, edukasi budaya keselamatan berkendara, pendampingan desa binaan, dan standardisasi bengkel rakyat.',
                'Mengembangkan kemitraan riset sinergis dengan Kementerian Perhubungan, Korlantas Polri, KNKT, pemerintah daerah, dan industri manufaktur otomotif nasional.',
                'Mendorong hilirisasi invensi teknologi keselamatan, percepatan perolehan Hak Kekayaan Intelektual (HKI/Paten), serta publikasi berkala pada jurnal ilmiah terakreditasi.',
                'Mengoptimalkan tata kelola kelembagaan P3M yang transparan, akuntabel, dan berbasis sistem informasi digital (SIM P3M) berstandar mutu pendidikan tinggi vokasi.',
            ];
        }

        // Resolusi butir Sasaran Tujuan dinamis dengan fallback ke format legacy/default
        $tujuanList = [];
        if (! empty($settings['tujuan_items'])) {
            $decoded = json_decode($settings['tujuan_items'], true);
            if (is_array($decoded) && count($decoded) > 0) {
                $tujuanList = array_values(array_filter($decoded, function ($item) {
                    return is_array($item) && (! empty(trim($item['title'] ?? '')) || ! empty(trim($item['desc'] ?? '')));
                }));
            }
        }
        if (empty($tujuanList)) {
            for ($i = 1; $i <= 10; $i++) {
                if (! empty($settings["tujuan_{$i}_title"])) {
                    $tujuanList[] = [
                        'title' => $settings["tujuan_{$i}_title"],
                        'desc' => $settings["tujuan_{$i}_desc"] ?? '',
                    ];
                }
            }
        }
        if (empty($tujuanList)) {
            $tujuanList = [
                [
                    'title' => 'Reduksi Fatalitas Kecelakaan',
                    'desc' => 'Menghasilkan rekomendasi teknis audit keselamatan jalan dan rekayasa simpang yang menurunkan angka fatalitas korban lalu lintas nasional.',
                ],
                [
                    'title' => 'Kemandirian Riset Vokasi',
                    'desc' => 'Meningkatkan kuantitas dan kualitas penelitian terapan dosen dan taruna yang didanai DIPA Kemenhub, Kemdiktisaintek, maupun mitra industri.',
                ],
                [
                    'title' => 'Penguatan HKI & Jurnal Ilmiah',
                    'desc' => 'Meningkatkan perolehan paten invensi, hak cipta desain industri, dan publikasi artikel ilmiah pada Indonesian Road Safety Journal terindeks SINTA.',
                ],
                [
                    'title' => 'Pemberdayaan Masyarakat Pantura',
                    'desc' => 'Memperluas jangkauan desa binaan tertib lalu lintas dan transfer teknologi standardisasi uji kelaikan armada ke bengkel UMKM mitra.',
                ],
            ];
        }

        return view('profil.visi-misi', [
            'settings' => $merged,
            'misiList' => $misiList,
            'tujuanList' => $tujuanList,
        ]);
    }

    /**
     * Menampilkan halaman Profil > Profil Peneliti (Direktori Dosen & Peneliti Aktif).
     */
    public function peneliti(Request $request): View
    {
        $query = User::with(['prodi', 'researches', 'outputs'])
            ->where('status_aktif', true)
            ->where(function ($q) {
                $q->whereIn('role', ['dosen', 'reviewer', 'peneliti'])
                    ->orWhereJsonContains('roles', 'peneliti')
                    ->orWhereJsonContains('roles', 'dosen')
                    ->orWhereJsonContains('roles', 'reviewer');
            })
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
        $totalPeneliti = User::where('status_aktif', true)
            ->where(function ($q) {
                $q->whereIn('role', ['dosen', 'reviewer', 'peneliti'])
                    ->orWhereJsonContains('roles', 'peneliti')
                    ->orWhereJsonContains('roles', 'dosen')
                    ->orWhereJsonContains('roles', 'reviewer');
            })
            ->count();
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
     * Menampilkan halaman detail profil dosen / peneliti aktif beserta data riset dan publikasi.
     */
    public function showPeneliti(User $user): View
    {
        // Pastikan pengguna berstatus aktif dan memiliki peran akademik
        if (! $user->status_aktif) {
            abort(404, 'Data peneliti tidak ditemukan atau berstatus tidak aktif.');
        }

        $roles = $user->getRolesList();
        $isAcademic = in_array('dosen', $roles) || in_array('peneliti', $roles) || in_array('reviewer', $roles) || in_array($user->role, ['dosen', 'peneliti', 'reviewer']);

        if (! $isAcademic) {
            abort(404, 'Data peneliti tidak ditemukan.');
        }

        $user->load([
            'prodi',
            'researches' => fn ($q) => $q->orderByDesc('tahun')->latest(),
            'outputs' => fn ($q) => $q->orderByDesc('tahun')->latest(),
        ]);

        return view('profil.peneliti-detail', [
            'dosen' => $user,
            'researches' => $user->researches,
            'outputs' => $user->outputs,
        ]);
    }

    /**
     * Menampilkan halaman Profil > Sumber Daya Manusia (Struktur Organisasi P3M PKTJ).
     */
    public function sdm(): View
    {
        $members = OrganizationMember::active()->ordered()->get();

        $settings = Setting::where('group', 'organization')->pluck('value', 'key')->toArray();

        $defaultSettings = [
            'org_title' => 'Struktur Organisasi P3M PKTJ',
            'org_sk_number' => 'SK Direktur PKTJ No. KP.004/1/12/PKTJ-2026',
            'org_period' => '2026 – 2031',
            'org_chart_image' => null,
            'org_lead_text' => 'Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) merupakan unit pelaksana strategis bidang riset terapan dan pengabdian masyarakat di lingkungan Politeknik Keselamatan Transportasi Jalan, berkedudukan langsung di bawah Direktur PKTJ dan dikoordinasikan oleh Wakil Direktur I Bidang Akademik sesuai ketentuan tata kelola Badan Pengembangan SDM Perhubungan.',
        ];

        $mergedSettings = array_merge($defaultSettings, $settings);

        // Pengelompokan personil berjenjang hierarki secara dinamis
        $pengarah = $members->filter(fn ($m) => (str_contains(strtolower($m->jabatan), 'pengarah') || str_contains(strtolower($m->jabatan), 'pelindung') || str_contains(strtolower($m->jabatan), 'direktur')) && ! str_contains(strtolower($m->jabatan), 'wakil'));
        $penanggungJawab = $members->filter(fn ($m) => ! $pengarah->contains($m) && (str_contains(strtolower($m->jabatan), 'penanggung jawab') || str_contains(strtolower($m->jabatan), 'wakil direktur') || str_contains(strtolower($m->jabatan), 'wadir')));
        $pimpinan = $members->filter(fn ($m) => ! $pengarah->contains($m) && ! $penanggungJawab->contains($m) && (str_contains(strtolower($m->jabatan), 'kepala pusat') || str_contains(strtolower($m->jabatan), 'kepala p3m') || str_contains(strtolower($m->jabatan), 'sekretaris')));
        $koordinator = $members->filter(fn ($m) => ! $pengarah->contains($m) && ! $penanggungJawab->contains($m) && ! $pimpinan->contains($m) && (str_contains(strtolower($m->jabatan), 'koordinator') || str_contains(strtolower($m->jabatan), 'bidang') || str_contains(strtolower($m->jabatan), 'sentra')));
        $staf = $members->reject(fn ($m) => $pengarah->contains($m) || $penanggungJawab->contains($m) || $pimpinan->contains($m) || $koordinator->contains($m));

        return view('profil.sdm', [
            'members' => $members,
            'settings' => $mergedSettings,
            'pengarah' => $pengarah,
            'penanggungJawab' => $penanggungJawab,
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
            $filename = str($document->judul)->slug().'.'.pathinfo($document->file_path, PATHINFO_EXTENSION);

            return Storage::disk('public')->download($document->file_path, $filename);
        }

        return redirect(asset('storage/'.$document->file_path));
    }
}
