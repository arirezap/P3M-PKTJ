<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityService;
use App\Models\CommunityServiceOutput;
use App\Models\Prodi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CommunityServiceOutputController extends Controller
{
    /**
     * Menampilkan daftar data luaran pengabdian masyarakat di panel CMS.
     */
    public function index(Request $request): View
    {
        $query = CommunityServiceOutput::with(['prodi', 'communityService'])->latest('tahun')->latest('id');

        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('prodi_id') && $request->prodi_id !== 'semua') {
            $query->where('prodi_id', $request->prodi_id);
        }

        if ($request->filled('tahun') && $request->tahun !== 'semua') {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('pelaksana', 'like', "%{$search}%")
                    ->orWhere('mitra_sasaran', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%")
                    ->orWhere('indikator_keberhasilan', 'like', "%{$search}%");
            });
        }

        $outputs = $query->paginate(15)->withQueryString();
        $prodis = Prodi::where('status_aktif', true)->get();
        $tahunList = CommunityServiceOutput::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        return view('admin.community-service-outputs.index', compact('outputs', 'prodis', 'tahunList'));
    }

    /**
     * Formulir tambah data luaran PkM.
     */
    public function create(): View
    {
        $prodis = Prodi::where('status_aktif', true)->get();
        $communityServices = CommunityService::orderByDesc('tahun')->latest('id')->get();

        return view('admin.community-service-outputs.create', compact('prodis', 'communityServices'));
    }

    /**
     * Simpan data luaran PkM baru ke basis data.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kategori' => ['required', 'in:publikasi,ttg,modul,hki,desa_binaan'],
            'judul' => ['required', 'string'],
            'community_service_id' => ['nullable', 'exists:community_services,id'],
            'prodi_id' => ['required', 'exists:prodis,id'],
            'pelaksana' => ['required', 'string', 'max:255'],
            'tahun' => ['required', 'integer', 'min:2020', 'max:2035'],
            'mitra_sasaran' => ['nullable', 'string', 'max:255'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'deskripsi_manfaat' => ['nullable', 'string'],
            'indikator_keberhasilan' => ['nullable', 'string', 'max:255'],
            'tingkat_kepuasan_mitra' => ['nullable', 'string', 'max:100'],
            'link_dokumen' => ['nullable', 'string', 'max:255'],
            'berkas_luaran' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ], [
            'kategori.required' => 'Kategori luaran pengabdian wajib dipilih.',
            'judul.required' => 'Judul luaran wajib diisi.',
            'prodi_id.required' => 'Program studi wajib dipilih.',
            'pelaksana.required' => 'Nama tim pelaksana wajib diisi.',
            'berkas_luaran.mimes' => 'Berkas bukti laporan harus berformat PDF (.pdf).',
            'berkas_luaran.max' => 'Ukuran berkas bukti maksimal 10 MB.',
        ]);

        if ($request->hasFile('berkas_luaran')) {
            $validated['berkas_luaran'] = $request->file('berkas_luaran')->store('community_services/outputs', 'public');
        }

        CommunityServiceOutput::create($validated);

        return redirect()->route('admin.community-service-outputs.index')
            ->with('success', 'Data luaran pengabdian masyarakat berhasil ditambahkan.');
    }

    /**
     * Formulir ubah data luaran PkM.
     */
    public function edit(CommunityServiceOutput $communityServiceOutput): View
    {
        $prodis = Prodi::where('status_aktif', true)->get();
        $communityServices = CommunityService::orderByDesc('tahun')->latest('id')->get();

        return view('admin.community-service-outputs.edit', compact('communityServiceOutput', 'prodis', 'communityServices'));
    }

    /**
     * Perbarui data luaran PkM.
     */
    public function update(Request $request, CommunityServiceOutput $communityServiceOutput): RedirectResponse
    {
        $validated = $request->validate([
            'kategori' => ['required', 'in:publikasi,ttg,modul,hki,desa_binaan'],
            'judul' => ['required', 'string'],
            'community_service_id' => ['nullable', 'exists:community_services,id'],
            'prodi_id' => ['required', 'exists:prodis,id'],
            'pelaksana' => ['required', 'string', 'max:255'],
            'tahun' => ['required', 'integer', 'min:2020', 'max:2035'],
            'mitra_sasaran' => ['nullable', 'string', 'max:255'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'deskripsi_manfaat' => ['nullable', 'string'],
            'indikator_keberhasilan' => ['nullable', 'string', 'max:255'],
            'tingkat_kepuasan_mitra' => ['nullable', 'string', 'max:100'],
            'link_dokumen' => ['nullable', 'string', 'max:255'],
            'berkas_luaran' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        if ($request->hasFile('berkas_luaran')) {
            if ($communityServiceOutput->berkas_luaran && Storage::disk('public')->exists($communityServiceOutput->berkas_luaran)) {
                Storage::disk('public')->delete($communityServiceOutput->berkas_luaran);
            }
            $validated['berkas_luaran'] = $request->file('berkas_luaran')->store('community_services/outputs', 'public');
        }

        $communityServiceOutput->update($validated);

        return redirect()->route('admin.community-service-outputs.index')
            ->with('success', 'Data luaran pengabdian masyarakat berhasil diperbarui.');
    }

    /**
     * Hapus data luaran PkM.
     */
    public function destroy(CommunityServiceOutput $communityServiceOutput): RedirectResponse
    {
        if ($communityServiceOutput->berkas_luaran && Storage::disk('public')->exists($communityServiceOutput->berkas_luaran)) {
            Storage::disk('public')->delete($communityServiceOutput->berkas_luaran);
        }

        $communityServiceOutput->delete();

        return redirect()->route('admin.community-service-outputs.index')
            ->with('success', 'Data luaran pengabdian masyarakat berhasil dihapus.');
    }

    /**
     * Impor data luaran massal dari berkas CSV.
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file_csv' => ['required', 'file', 'mimes:csv,txt'],
        ], [
            'file_csv.required' => 'Silakan pilih berkas CSV untuk diimpor.',
            'file_csv.mimes' => 'Format berkas harus CSV (.csv).',
        ]);

        $file = $request->file('file_csv');
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle, 1000, ',');

        $count = 0;
        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            if (count($row) >= 5) {
                $kodeProdi = trim($row[2]);
                $prodi = Prodi::where('kode_prodi', $kodeProdi)->first();

                if ($prodi) {
                    $kategori = strtolower(trim($row[0]));
                    if (! in_array($kategori, ['publikasi', 'ttg', 'modul', 'hki', 'desa_binaan'])) {
                        $kategori = 'publikasi';
                    }

                    CommunityServiceOutput::create([
                        'kategori' => $kategori,
                        'judul' => trim($row[1]),
                        'prodi_id' => $prodi->id,
                        'pelaksana' => trim($row[3]),
                        'tahun' => (int) trim($row[4]),
                        'mitra_sasaran' => isset($row[5]) && $row[5] !== '' ? trim($row[5]) : null,
                        'lokasi' => isset($row[6]) && $row[6] !== '' ? trim($row[6]) : null,
                        'deskripsi_manfaat' => isset($row[7]) && $row[7] !== '' ? trim($row[7]) : null,
                        'indikator_keberhasilan' => isset($row[8]) && $row[8] !== '' ? trim($row[8]) : null,
                        'tingkat_kepuasan_mitra' => isset($row[9]) && $row[9] !== '' ? trim($row[9]) : '90% (Baik)',
                        'link_dokumen' => isset($row[10]) && $row[10] !== '' ? trim($row[10]) : null,
                    ]);
                    $count++;
                }
            }
        }
        fclose($handle);

        return redirect()->route('admin.community-service-outputs.index')
            ->with('success', "Berhasil mengimpor {$count} data luaran pengabdian masyarakat.");
    }
}
