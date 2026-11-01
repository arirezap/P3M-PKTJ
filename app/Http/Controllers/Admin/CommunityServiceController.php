<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityService;
use App\Models\Prodi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CommunityServiceController extends Controller
{
    /**
     * Menampilkan daftar data pengabdian masyarakat.
     */
    public function index(Request $request): View
    {
        $query = CommunityService::with('prodi')->latest('tahun')->latest('id');

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
                  ->orWhere('ketua_pelaksana', 'like', "%{$search}%")
                  ->orWhere('mitra', 'like', "%{$search}%")
                  ->orWhere('lokasi_kegiatan', 'like', "%{$search}%")
                  ->orWhere('ringkasan', 'like', "%{$search}%");
            });
        }

        $services = $query->paginate(15)->withQueryString();
        $prodis = Prodi::where('status_aktif', true)->get();
        $tahunList = CommunityService::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        return view('admin.community-services.index', compact('services', 'prodis', 'tahunList'));
    }

    /**
     * Formulir tambah data PkM.
     */
    public function create(): View
    {
        $prodis = Prodi::where('status_aktif', true)->get();
        return view('admin.community-services.create', compact('prodis'));
    }

    /**
     * Simpan data PkM baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string'],
            'ringkasan' => ['nullable', 'string'],
            'prodi_id' => ['required', 'exists:prodis,id'],
            'ketua_pelaksana' => ['required', 'string', 'max:255'],
            'anggota' => ['nullable', 'string'],
            'tahun' => ['required', 'integer', 'min:2020', 'max:2035'],
            'skema' => ['nullable', 'string', 'max:150'],
            'mitra' => ['nullable', 'string', 'max:255'],
            'lokasi_kegiatan' => ['nullable', 'string', 'max:255'],
            'sumber_dana' => ['required', 'string', 'max:150'],
            'anggaran' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:Berjalan,Selesai'],
            'berkas_laporan' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ], [
            'judul.required' => 'Judul kegiatan pengabdian wajib diisi.',
            'prodi_id.required' => 'Program studi wajib dipilih.',
            'ketua_pelaksana.required' => 'Nama ketua pelaksana wajib diisi.',
            'anggaran.required' => 'Nominal anggaran wajib diisi.',
            'berkas_laporan.mimes' => 'Berkas laporan harus berformat PDF (.pdf).',
            'berkas_laporan.max' => 'Ukuran berkas laporan maksimal 10 MB.',
        ]);

        if ($request->hasFile('berkas_laporan')) {
            $validated['berkas_laporan'] = $request->file('berkas_laporan')->store('community_services/reports', 'public');
        }

        CommunityService::create($validated);

        return redirect()->route('admin.community-services.index')->with('success', 'Data kegiatan pengabdian berhasil ditambahkan.');
    }

    /**
     * Formulir ubah data PkM.
     */
    public function edit(CommunityService $communityService): View
    {
        $prodis = Prodi::where('status_aktif', true)->get();
        return view('admin.community-services.edit', compact('communityService', 'prodis'));
    }

    /**
     * Perbarui data PkM.
     */
    public function update(Request $request, CommunityService $communityService): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string'],
            'ringkasan' => ['nullable', 'string'],
            'prodi_id' => ['required', 'exists:prodis,id'],
            'ketua_pelaksana' => ['required', 'string', 'max:255'],
            'anggota' => ['nullable', 'string'],
            'tahun' => ['required', 'integer', 'min:2020', 'max:2035'],
            'skema' => ['nullable', 'string', 'max:150'],
            'mitra' => ['nullable', 'string', 'max:255'],
            'lokasi_kegiatan' => ['nullable', 'string', 'max:255'],
            'sumber_dana' => ['required', 'string', 'max:150'],
            'anggaran' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:Berjalan,Selesai'],
            'berkas_laporan' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ], [
            'judul.required' => 'Judul kegiatan pengabdian wajib diisi.',
            'prodi_id.required' => 'Program studi wajib dipilih.',
            'ketua_pelaksana.required' => 'Nama ketua pelaksana wajib diisi.',
            'anggaran.required' => 'Nominal anggaran wajib diisi.',
            'berkas_laporan.mimes' => 'Berkas laporan harus berformat PDF (.pdf).',
            'berkas_laporan.max' => 'Ukuran berkas laporan maksimal 10 MB.',
        ]);

        if ($request->hasFile('berkas_laporan')) {
            if ($communityService->berkas_laporan && Storage::disk('public')->exists($communityService->berkas_laporan)) {
                Storage::disk('public')->delete($communityService->berkas_laporan);
            }
            $validated['berkas_laporan'] = $request->file('berkas_laporan')->store('community_services/reports', 'public');
        }

        $communityService->update($validated);

        return redirect()->route('admin.community-services.index')->with('success', 'Data kegiatan pengabdian berhasil diperbarui.');
    }

    /**
     * Hapus data PkM.
     */
    public function destroy(CommunityService $communityService): RedirectResponse
    {
        if ($communityService->berkas_laporan && Storage::disk('public')->exists($communityService->berkas_laporan)) {
            Storage::disk('public')->delete($communityService->berkas_laporan);
        }

        $communityService->delete();

        return redirect()->route('admin.community-services.index')->with('success', 'Data kegiatan pengabdian berhasil dihapus.');
    }

    /**
     * Fitur Impor Data PkM Massal via CSV.
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
            if (count($row) >= 6) {
                $kodeProdi = trim($row[1]);
                $prodi = Prodi::where('kode_prodi', $kodeProdi)->first();

                if ($prodi) {
                    CommunityService::create([
                        'judul' => trim($row[0]),
                        'prodi_id' => $prodi->id,
                        'ketua_pelaksana' => trim($row[2]),
                        'anggota' => isset($row[3]) && $row[3] !== '' ? trim($row[3]) : null,
                        'tahun' => (int) trim($row[4]),
                        'skema' => isset($row[5]) && $row[5] !== '' ? trim($row[5]) : 'PkM Kemitraan',
                        'mitra' => isset($row[6]) && $row[6] !== '' ? trim($row[6]) : null,
                        'lokasi_kegiatan' => isset($row[7]) && $row[7] !== '' ? trim($row[7]) : null,
                        'sumber_dana' => isset($row[8]) && $row[8] !== '' ? trim($row[8]) : 'DIPA PKTJ',
                        'anggaran' => isset($row[9]) ? (float) preg_replace('/[^0-9.]/', '', $row[9]) : 0,
                        'status' => isset($row[10]) && $row[10] !== '' ? trim($row[10]) : 'Selesai',
                        'ringkasan' => isset($row[11]) && $row[11] !== '' ? trim($row[11]) : null,
                    ]);
                    $count++;
                }
            }
        }
        fclose($handle);

        return redirect()->route('admin.community-services.index')->with('success', "Berhasil mengimpor {$count} data pengabdian masyarakat.");
    }
}
