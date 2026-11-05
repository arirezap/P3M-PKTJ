<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collaboration;
use App\Models\Prodi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CollaborationController extends Controller
{
    /**
     * Tampilkan daftar data kerjasama penelitian di CMS Admin.
     */
    public function index(Request $request): View
    {
        $query = Collaboration::with('prodi')->latest('id');

        if ($request->filled('jenis_kegiatan')) {
            $query->where('jenis_kegiatan', $request->jenis_kegiatan);
        }

        if ($request->filled('kategori_mitra')) {
            $query->where('kategori_mitra', $request->kategori_mitra);
        }

        if ($request->filled('prodi_id')) {
            $query->where('prodi_id', $request->prodi_id);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('status_kerjasama')) {
            $query->where('status_kerjasama', $request->status_kerjasama);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_mitra', 'like', "%{$search}%")
                    ->orWhere('judul_kerjasama', 'like', "%{$search}%")
                    ->orWhere('nomor_mou_pks', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $collaborations = $query->paginate(15)->withQueryString();
        $prodis = Prodi::where('status_aktif', true)->get();
        $tahunList = Collaboration::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        $counts = [
            'total' => Collaboration::count(),
            'penelitian' => Collaboration::where('jenis_kegiatan', 'penelitian')->count(),
            'pengabdian' => Collaboration::where('jenis_kegiatan', 'pengabdian')->count(),
            'keduanya' => Collaboration::where('jenis_kegiatan', 'keduanya')->count(),
            'aktif' => Collaboration::where('status_kerjasama', 'aktif')->count(),
            'selesai' => Collaboration::where('status_kerjasama', 'selesai')->count(),
            'pemerintah' => Collaboration::where('kategori_mitra', 'pemerintah')->count(),
            'bumn' => Collaboration::where('kategori_mitra', 'bumn')->count(),
            'industri' => Collaboration::where('kategori_mitra', 'industri')->count(),
            'perguruan_tinggi' => Collaboration::where('kategori_mitra', 'perguruan_tinggi')->count(),
            'lainnya' => Collaboration::where('kategori_mitra', 'lainnya')->count(),
        ];

        return view('admin.collaborations.index', compact('collaborations', 'prodis', 'tahunList', 'counts'));
    }

    /**
     * Formulir penambahan data kerjasama baru.
     */
    public function create(): View
    {
        $prodis = Prodi::where('status_aktif', true)->get();

        return view('admin.collaborations.create', compact('prodis'));
    }

    /**
     * Simpan data kerjasama baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_mitra' => ['required', 'string', 'max:255'],
            'judul_kerjasama' => ['nullable', 'string', 'max:255'],
            'jenis_kegiatan' => ['required', 'in:penelitian,pengabdian,keduanya'],
            'kategori_mitra' => ['required', 'in:pemerintah,bumn,industri,perguruan_tinggi,lainnya'],
            'prodi_id' => ['nullable', 'exists:prodis,id'],
            'nomor_mou_pks' => ['nullable', 'string', 'max:255'],
            'tahun' => ['required', 'integer', 'min:2020', 'max:2035'],
            'status_kerjasama' => ['required', 'in:aktif,selesai'],
            'deskripsi' => ['nullable', 'string'],
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_berakhir' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'file_dokumen' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ], [
            'nama_mitra.required' => 'Nama mitra atau instansi wajib diisi.',
            'jenis_kegiatan.required' => 'Klasifikasi kegiatan kerjasama wajib dipilih.',
            'kategori_mitra.required' => 'Kategori mitra kerjasama wajib dipilih.',
            'tahun.required' => 'Tahun pelaksanaan kerjasama wajib diisi.',
            'status_kerjasama.required' => 'Status kerjasama wajib ditentukan.',
            'tanggal_berakhir.after_or_equal' => 'Tanggal berakhir harus sama atau setelah tanggal mulai.',
            'file_dokumen.mimes' => 'Berkas dokumen kerjasama harus berformat PDF (.pdf).',
            'file_dokumen.max' => 'Ukuran berkas dokumen maksimal 10 MB.',
        ]);

        if ($request->hasFile('file_dokumen')) {
            $validated['file_dokumen'] = $request->file('file_dokumen')->store('collaborations', 'public');
        }

        Collaboration::create($validated);

        return redirect()->route('admin.collaborations.index')
            ->with('success', 'Data kerjasama penelitian berhasil ditambahkan.');
    }

    /**
     * Formulir edit data kerjasama.
     */
    public function edit(Collaboration $collaboration): View
    {
        $prodis = Prodi::where('status_aktif', true)->get();

        return view('admin.collaborations.edit', compact('collaboration', 'prodis'));
    }

    /**
     * Perbarui data kerjasama di basis data.
     */
    public function update(Request $request, Collaboration $collaboration): RedirectResponse
    {
        $validated = $request->validate([
            'nama_mitra' => ['required', 'string', 'max:255'],
            'judul_kerjasama' => ['nullable', 'string', 'max:255'],
            'jenis_kegiatan' => ['required', 'in:penelitian,pengabdian,keduanya'],
            'kategori_mitra' => ['required', 'in:pemerintah,bumn,industri,perguruan_tinggi,lainnya'],
            'prodi_id' => ['nullable', 'exists:prodis,id'],
            'nomor_mou_pks' => ['nullable', 'string', 'max:255'],
            'tahun' => ['required', 'integer', 'min:2020', 'max:2035'],
            'status_kerjasama' => ['required', 'in:aktif,selesai'],
            'deskripsi' => ['nullable', 'string'],
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_berakhir' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'file_dokumen' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ], [
            'nama_mitra.required' => 'Nama mitra atau instansi wajib diisi.',
            'jenis_kegiatan.required' => 'Klasifikasi kegiatan kerjasama wajib dipilih.',
            'kategori_mitra.required' => 'Kategori mitra kerjasama wajib dipilih.',
            'tahun.required' => 'Tahun pelaksanaan kerjasama wajib diisi.',
            'status_kerjasama.required' => 'Status kerjasama wajib ditentukan.',
            'tanggal_berakhir.after_or_equal' => 'Tanggal berakhir harus sama atau setelah tanggal mulai.',
            'file_dokumen.mimes' => 'Berkas dokumen kerjasama harus berformat PDF (.pdf).',
            'file_dokumen.max' => 'Ukuran berkas dokumen maksimal 10 MB.',
        ]);

        if ($request->hasFile('file_dokumen')) {
            if ($collaboration->file_dokumen && Storage::disk('public')->exists($collaboration->file_dokumen)) {
                Storage::disk('public')->delete($collaboration->file_dokumen);
            }
            $validated['file_dokumen'] = $request->file('file_dokumen')->store('collaborations', 'public');
        }

        $collaboration->update($validated);

        return redirect()->route('admin.collaborations.index')
            ->with('success', 'Data kerjasama penelitian berhasil diperbarui.');
    }

    /**
     * Hapus data kerjasama dan berkas dokumen pendukungnya.
     */
    public function destroy(Collaboration $collaboration): RedirectResponse
    {
        if ($collaboration->file_dokumen && Storage::disk('public')->exists($collaboration->file_dokumen)) {
            Storage::disk('public')->delete($collaboration->file_dokumen);
        }

        $collaboration->delete();

        return redirect()->route('admin.collaborations.index')
            ->with('success', 'Data kerjasama penelitian berhasil dihapus.');
    }
}
