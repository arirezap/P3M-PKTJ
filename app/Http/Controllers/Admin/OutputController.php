<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Output;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class OutputController extends Controller
{
    /**
     * Tampilkan daftar luaran riset (Publikasi, HKI, Produk/Jasa).
     */
    public function index(Request $request): View
    {
        $query = Output::with(['prodi', 'user'])->latest();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('prodi_id')) {
            $query->where('prodi_id', $request->prodi_id);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('author_inventor', 'like', "%{$search}%")
                  ->orWhere('mitra_kerjasama', 'like', "%{$search}%")
                  ->orWhere('nomor_registrasi_hki', 'like', "%{$search}%");
            });
        }

        $outputs = $query->paginate(15)->withQueryString();
        $prodis = Prodi::where('status_aktif', true)->get();
        $tahunList = Output::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        $counts = [
            'total' => Output::count(),
            'publikasi' => Output::where('kategori', 'publikasi')->count(),
            'hki' => Output::where('kategori', 'hki')->count(),
            'produk' => Output::where('kategori', 'produk')->count(),
        ];

        return view('admin.outputs.index', compact('outputs', 'prodis', 'tahunList', 'counts'));
    }

    /**
     * Tampilkan formulir penambahan luaran riset baru.
     */
    public function create(): View
    {
        $prodis = Prodi::where('status_aktif', true)->get();
        $users = User::where('role', 'dosen')->where('status_aktif', true)->orderBy('name')->get();

        return view('admin.outputs.create', compact('prodis', 'users'));
    }

    /**
     * Simpan luaran riset baru ke basis data.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kategori' => ['required', 'in:publikasi,hki,produk'],
            'judul' => ['required', 'string'],
            'prodi_id' => ['required', 'exists:prodis,id'],
            'user_id' => ['nullable', 'exists:users,id'],
            'author_inventor' => ['required', 'string', 'max:255'],
            'tahun' => ['required', 'integer', 'min:2020', 'max:2035'],
            'nama_jurnal_penerbit' => ['nullable', 'string', 'max:255'],
            'nomor_registrasi_hki' => ['nullable', 'string', 'max:150'],
            'tingkat_kesiapan_terapan' => ['nullable', 'string', 'max:50'],
            'lisensi' => ['nullable', 'string', 'max:150'],
            'fase_roadmap' => ['nullable', 'string', 'max:150'],
            'deskripsi_kemanfaatan' => ['nullable', 'string'],
            'mitra_kerjasama' => ['nullable', 'string', 'max:255'],
            'sumber_dana' => ['nullable', 'string', 'max:150'],
            'realisasi_dana' => ['nullable', 'numeric', 'min:0'],
            'link_dokumen' => ['nullable', 'url', 'max:500'],
            'berkas_luaran' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ], [
            'kategori.required' => 'Pilar kategori luaran wajib dipilih.',
            'judul.required' => 'Judul luaran riset wajib diisi.',
            'prodi_id.required' => 'Program studi wajib dipilih.',
            'author_inventor.required' => 'Nama penulis atau inventor wajib diisi.',
            'tahun.required' => 'Tahun luaran wajib diisi.',
            'link_dokumen.url' => 'Format tautan dokumen harus diawali dengan http:// atau https://.',
            'berkas_luaran.mimes' => 'Berkas bukti luaran harus berformat PDF (.pdf).',
            'berkas_luaran.max' => 'Ukuran berkas bukti luaran maksimal 10 MB.',
        ]);

        if ($request->hasFile('berkas_luaran')) {
            $validated['berkas_luaran'] = $request->file('berkas_luaran')->store('outputs', 'public');
        }

        Output::create($validated);

        return redirect()->route('admin.outputs.index')
            ->with('success', 'Data luaran penelitian berhasil ditambahkan.');
    }

    /**
     * Tampilkan formulir edit luaran riset.
     */
    public function edit(Output $output): View
    {
        $prodis = Prodi::where('status_aktif', true)->get();
        $users = User::where('role', 'dosen')->where('status_aktif', true)->orderBy('name')->get();

        return view('admin.outputs.edit', compact('output', 'prodis', 'users'));
    }

    /**
     * Perbarui data luaran riset.
     */
    public function update(Request $request, Output $output): RedirectResponse
    {
        $validated = $request->validate([
            'kategori' => ['required', 'in:publikasi,hki,produk'],
            'judul' => ['required', 'string'],
            'prodi_id' => ['required', 'exists:prodis,id'],
            'user_id' => ['nullable', 'exists:users,id'],
            'author_inventor' => ['required', 'string', 'max:255'],
            'tahun' => ['required', 'integer', 'min:2020', 'max:2035'],
            'nama_jurnal_penerbit' => ['nullable', 'string', 'max:255'],
            'nomor_registrasi_hki' => ['nullable', 'string', 'max:150'],
            'tingkat_kesiapan_terapan' => ['nullable', 'string', 'max:50'],
            'lisensi' => ['nullable', 'string', 'max:150'],
            'fase_roadmap' => ['nullable', 'string', 'max:150'],
            'deskripsi_kemanfaatan' => ['nullable', 'string'],
            'mitra_kerjasama' => ['nullable', 'string', 'max:255'],
            'sumber_dana' => ['nullable', 'string', 'max:150'],
            'realisasi_dana' => ['nullable', 'numeric', 'min:0'],
            'link_dokumen' => ['nullable', 'url', 'max:500'],
            'berkas_luaran' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ], [
            'kategori.required' => 'Pilar kategori luaran wajib dipilih.',
            'judul.required' => 'Judul luaran riset wajib diisi.',
            'prodi_id.required' => 'Program studi wajib dipilih.',
            'author_inventor.required' => 'Nama penulis atau inventor wajib diisi.',
            'tahun.required' => 'Tahun luaran wajib diisi.',
            'link_dokumen.url' => 'Format tautan dokumen harus diawali dengan http:// atau https://.',
            'berkas_luaran.mimes' => 'Berkas bukti luaran harus berformat PDF (.pdf).',
            'berkas_luaran.max' => 'Ukuran berkas bukti luaran maksimal 10 MB.',
        ]);

        if ($request->hasFile('berkas_luaran')) {
            if ($output->berkas_luaran && Storage::disk('public')->exists($output->berkas_luaran)) {
                Storage::disk('public')->delete($output->berkas_luaran);
            }
            $validated['berkas_luaran'] = $request->file('berkas_luaran')->store('outputs', 'public');
        }

        $output->update($validated);

        return redirect()->route('admin.outputs.index')
            ->with('success', 'Data luaran penelitian berhasil diperbarui.');
    }

    /**
     * Hapus luaran riset dan berkas pendukungnya.
     */
    public function destroy(Output $output): RedirectResponse
    {
        if ($output->berkas_luaran && Storage::disk('public')->exists($output->berkas_luaran)) {
            Storage::disk('public')->delete($output->berkas_luaran);
        }

        $output->delete();

        return redirect()->route('admin.outputs.index')
            ->with('success', 'Data luaran penelitian berhasil dihapus.');
    }
}
