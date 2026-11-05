<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\Research;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ResearchController extends Controller
{
    /**
     * Menampilkan daftar data riset.
     */
    public function index(Request $request): View
    {
        $query = Research::with('prodi')->latest('tahun');

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
                    ->orWhere('ketua_peneliti', 'like', "%{$search}%");
            });
        }

        $researches = $query->paginate(15)->withQueryString();
        $prodis = Prodi::where('status_aktif', true)->get();
        $tahunList = Research::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        return view('admin.researches.index', compact('researches', 'prodis', 'tahunList'));
    }

    /**
     * Formulir tambah data riset.
     */
    public function create(): View
    {
        $prodis = Prodi::where('status_aktif', true)->get();

        return view('admin.researches.create', compact('prodis'));
    }

    /**
     * Simpan data riset baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string'],
            'abstrak' => ['nullable', 'string'],
            'prodi_id' => ['required', 'exists:prodis,id'],
            'ketua_peneliti' => ['required', 'string', 'max:255'],
            'anggota' => ['nullable', 'string'],
            'tahun' => ['required', 'integer', 'min:2020', 'max:2035'],
            'skema' => ['nullable', 'string', 'max:150'],
            'sumber_dana' => ['required', 'string', 'max:150'],
            'anggaran' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:Berjalan,Selesai'],
            'berkas_laporan' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ], [
            'judul.required' => 'Judul riset wajib diisi.',
            'prodi_id.required' => 'Program studi wajib dipilih.',
            'ketua_peneliti.required' => 'Nama ketua peneliti wajib diisi.',
            'anggaran.required' => 'Nominal anggaran wajib diisi.',
            'berkas_laporan.mimes' => 'Berkas laporan harus berformat PDF (.pdf).',
            'berkas_laporan.max' => 'Ukuran berkas laporan maksimal 10 MB.',
        ]);

        if ($request->hasFile('berkas_laporan')) {
            $validated['berkas_laporan'] = $request->file('berkas_laporan')->store('researches/reports', 'public');
        }

        Research::create($validated);

        return redirect()->route('admin.researches.index')->with('success', 'Data riset berhasil ditambahkan.');
    }

    /**
     * Formulir ubah data riset.
     */
    public function edit(Research $research): View
    {
        $prodis = Prodi::where('status_aktif', true)->get();

        return view('admin.researches.edit', compact('research', 'prodis'));
    }

    /**
     * Perbarui data riset.
     */
    public function update(Request $request, Research $research): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string'],
            'abstrak' => ['nullable', 'string'],
            'prodi_id' => ['required', 'exists:prodis,id'],
            'ketua_peneliti' => ['required', 'string', 'max:255'],
            'anggota' => ['nullable', 'string'],
            'tahun' => ['required', 'integer', 'min:2020', 'max:2035'],
            'skema' => ['nullable', 'string', 'max:150'],
            'sumber_dana' => ['required', 'string', 'max:150'],
            'anggaran' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:Berjalan,Selesai'],
            'berkas_laporan' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ], [
            'judul.required' => 'Judul riset wajib diisi.',
            'prodi_id.required' => 'Program studi wajib dipilih.',
            'ketua_peneliti.required' => 'Nama ketua peneliti wajib diisi.',
            'anggaran.required' => 'Nominal anggaran wajib diisi.',
            'berkas_laporan.mimes' => 'Berkas laporan harus berformat PDF (.pdf).',
            'berkas_laporan.max' => 'Ukuran berkas laporan maksimal 10 MB.',
        ]);

        if ($request->hasFile('berkas_laporan')) {
            if ($research->berkas_laporan && Storage::disk('public')->exists($research->berkas_laporan)) {
                Storage::disk('public')->delete($research->berkas_laporan);
            }
            $validated['berkas_laporan'] = $request->file('berkas_laporan')->store('researches/reports', 'public');
        }

        $research->update($validated);

        return redirect()->route('admin.researches.index')->with('success', 'Data riset berhasil diperbarui.');
    }

    /**
     * Hapus data riset.
     */
    public function destroy(Research $research): RedirectResponse
    {
        if ($research->berkas_laporan && Storage::disk('public')->exists($research->berkas_laporan)) {
            Storage::disk('public')->delete($research->berkas_laporan);
        }

        $research->delete();

        return redirect()->route('admin.researches.index')->with('success', 'Data riset berhasil dihapus.');
    }

    /**
     * Fitur Impor Data Riset Massal via CSV.
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
                    Research::create([
                        'judul' => trim($row[0]),
                        'prodi_id' => $prodi->id,
                        'ketua_peneliti' => trim($row[2]),
                        'anggota' => isset($row[3]) ? trim($row[3]) : null,
                        'tahun' => (int) trim($row[4]),
                        'skema' => isset($row[5]) ? trim($row[5]) : 'Penelitian Terapan',
                        'sumber_dana' => isset($row[6]) ? trim($row[6]) : 'DIPA PKTJ',
                        'anggaran' => isset($row[7]) ? (float) preg_replace('/[^0-9.]/', '', $row[7]) : 0,
                        'status' => isset($row[8]) ? trim($row[8]) : 'Selesai',
                    ]);
                    $count++;
                }
            }
        }
        fclose($handle);

        return redirect()->route('admin.researches.index')->with('success', "Berhasil mengimpor {$count} data riset.");
    }
}
