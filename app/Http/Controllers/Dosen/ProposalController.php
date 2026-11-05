<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProposalController extends Controller
{
    /**
     * Tampilkan formulir pembuatan usulan baru.
     */
    public function create(): View
    {
        $user = Auth::user();
        $prodis = Prodi::orderBy('jenjang', 'desc')->get();
        $dosenList = User::where('role', 'dosen')
            ->where('id', '!=', $user->id)
            ->where('status_aktif', true)
            ->with('prodi')
            ->orderBy('name')
            ->get();

        $kategoriBelanja = [
            'bahan_habis_pakai' => 'Belanja Bahan Habis Pakai & ATK',
            'sewa_alat' => 'Sewa Peralatan Lab / Pengujian Lapangan',
            'perjalanan_lapangan' => 'Perjalanan Dinas & Survei Lapangan',
            'honorarium' => 'Honorarium Pembantu Peneliti / Surveyor',
            'publikasi_diseminasi' => 'Biaya Publikasi Jurnal & Pendaftaran HKI',
            'lainnya' => 'Operasional & Pelaporan Akhir',
        ];

        return view('dosen.proposals.create', compact('user', 'prodis', 'dosenList', 'kategoriBelanja'));
    }

    /**
     * Simpan usulan proposal baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $rules = [
            'jenis' => 'required|in:penelitian,pengabdian',
            'judul' => 'required|string|max:500',
            'abstrak' => 'nullable|string',
            'prodi_id' => 'required|exists:prodis,id',
            'skema' => 'required|string|max:150',
            'tahun_anggaran' => 'required|integer|digits:4',
            'sumber_dana' => 'nullable|string|max:100',
            'kata_kunci' => 'nullable|string|max:255',
            'bidang_fokus' => 'nullable|string|max:150',
            'lama_kegiatan_tahun' => 'nullable|integer|min:1|max:5',
            'topik_kegiatan' => 'nullable|string|max:255',
            'lokasi_kegiatan' => 'nullable|string|max:255',
            'bank_nama' => 'nullable|string|max:100',
            'bank_rekening' => 'nullable|string|max:50',
            'bank_pemilik' => 'nullable|string|max:150',
            'nama_berkas_proposal' => 'nullable|string|max:255',
            'nama_mitra' => 'nullable|string|max:255',
            'kontribusi_mitra' => 'nullable|string|max:255',
            'dana_mitra' => 'nullable|numeric|min:0',
            'dana_tambahan' => 'nullable|numeric|min:0',
            'file_mitra' => 'nullable|file|mimes:pdf|max:10240',
            'action_type' => 'required|in:draft,diajukan',
            'file_proposal' => 'nullable|file|mimes:pdf|max:10240',
            'persetujuan_konfirmasi' => 'nullable|boolean',
            'luaran_target' => 'nullable|array',
            'luaran_target.*.jenis' => 'required_with:luaran_target|string|max:100',
            'luaran_target.*.keterangan' => 'nullable|string|max:500',
            'jadwal_kegiatan' => 'nullable|array',
            'jadwal_kegiatan.*.nama_kegiatan' => 'required_with:jadwal_kegiatan|string|max:255',
            'jadwal_kegiatan.*.tahun' => 'nullable|integer|min:1|max:5',
            'jadwal_kegiatan.*.tanggal_mulai' => 'nullable|date',
            'jadwal_kegiatan.*.tanggal_selesai' => 'nullable|date',
            'members' => 'nullable|array',
            'members.*.nama' => 'required_with:members|string|max:255',
            'members.*.peran' => 'required_with:members|string|max:50',
            'members.*.kategori_anggota' => 'nullable|string|max:30',
            'members.*.asal_instansi' => 'nullable|string|max:255',
            'members.*.negara' => 'nullable|string|max:100',
            'members.*.nidn_nim' => 'nullable|string|max:30',
            'members.*.tugas' => 'nullable|string|max:255',
            'budgets' => 'nullable|array',
            'budgets.*.kategori_belanja' => 'required_with:budgets|string|max:50',
            'budgets.*.tahun_ke' => 'nullable|integer|min:1|max:5',
            'budgets.*.uraian' => 'required_with:budgets|string|max:255',
            'budgets.*.volume' => 'required_with:budgets|numeric|min:0.01',
            'budgets.*.satuan' => 'required_with:budgets|string|max:50',
            'budgets.*.harga_satuan' => 'required_with:budgets|numeric|min:0',
        ];

        if ($request->action_type === 'diajukan') {
            $rules['file_proposal'] = 'required|file|mimes:pdf|max:10240';
        }

        $validated = $request->validate($rules);

        DB::beginTransaction();
        try {
            // Generate Kode Usulan Otomatis
            $prodi = Prodi::findOrFail($validated['prodi_id']);
            $prefix = ($validated['jenis'] === 'penelitian') ? 'PR' : 'PKM';
            $year = $validated['tahun_anggaran'];
            $kodeProdi = $prodi->kode_prodi;

            $count = Proposal::where('jenis', $validated['jenis'])
                ->where('tahun_anggaran', $year)
                ->where('prodi_id', $prodi->id)
                ->count() + 1;

            $kodeUsulan = sprintf('%s-%s-%s-%03d', $prefix, $year, $kodeProdi, $count);

            // Unggah file jika ada
            $filePath = null;
            if ($request->hasFile('file_proposal')) {
                $filePath = $request->file('file_proposal')->store('proposals', 'public');
            }

            // Unggah berkas mitra jika ada
            $fileMitraPath = null;
            if ($request->hasFile('file_mitra')) {
                $fileMitraPath = $request->file('file_mitra')->store('proposals_mitra', 'public');
            }

            // Hitung total anggaran dari item RAB
            $totalAnggaran = 0;
            $budgetItems = [];
            if (! empty($validated['budgets'])) {
                foreach ($validated['budgets'] as $b) {
                    $volume = (float) $b['volume'];
                    $hargaSatuan = (float) $b['harga_satuan'];
                    $subtotal = $volume * $hargaSatuan;
                    $totalAnggaran += $subtotal;

                    $budgetItems[] = [
                        'kategori_belanja' => $b['kategori_belanja'],
                        'tahun_ke' => $b['tahun_ke'] ?? 1,
                        'uraian' => $b['uraian'],
                        'volume' => $volume,
                        'satuan' => $b['satuan'],
                        'harga_satuan' => $hargaSatuan,
                        'total_harga' => $subtotal,
                    ];
                }
            }

            $proposal = Proposal::create([
                'kode_usulan' => $kodeUsulan,
                'jenis' => $validated['jenis'],
                'judul' => $validated['judul'],
                'abstrak' => $validated['abstrak'] ?? null,
                'kata_kunci' => $validated['kata_kunci'] ?? null,
                'bidang_fokus' => $validated['bidang_fokus'] ?? null,
                'lama_kegiatan_tahun' => $validated['lama_kegiatan_tahun'] ?? 1,
                'topik_kegiatan' => $validated['topik_kegiatan'] ?? null,
                'lokasi_kegiatan' => $validated['lokasi_kegiatan'] ?? null,
                'prodi_id' => $validated['prodi_id'],
                'user_id' => $user->id,
                'tahun_anggaran' => $validated['tahun_anggaran'],
                'skema' => $validated['skema'],
                'sumber_dana' => $validated['sumber_dana'] ?? 'DIPA PKTJ',
                'total_anggaran' => $totalAnggaran,
                'bank_nama' => $validated['bank_nama'] ?? null,
                'bank_rekening' => $validated['bank_rekening'] ?? null,
                'bank_pemilik' => $validated['bank_pemilik'] ?? null,
                'nama_berkas_proposal' => $validated['nama_berkas_proposal'] ?? null,
                'nama_mitra' => $validated['nama_mitra'] ?? null,
                'kontribusi_mitra' => $validated['kontribusi_mitra'] ?? null,
                'dana_mitra' => $validated['dana_mitra'] ?? null,
                'dana_tambahan' => $validated['dana_tambahan'] ?? null,
                'luaran_target' => $validated['luaran_target'] ?? null,
                'jadwal_kegiatan' => $validated['jadwal_kegiatan'] ?? null,
                'persetujuan_konfirmasi' => (bool) ($request->input('persetujuan_konfirmasi', false)),
                'file_mitra' => $fileMitraPath,
                'file_proposal' => $filePath,
                'status' => $validated['action_type'],
            ]);

            // Simpan Anggota Tim
            if (! empty($validated['members'])) {
                foreach ($validated['members'] as $m) {
                    // Cari user dosen jika ada kecocokan NIDN
                    $userId = null;
                    if ($m['peran'] === 'dosen_anggota' && ! empty($m['nidn_nim'])) {
                        $matchedUser = User::where('nidn_nip', $m['nidn_nim'])->first();
                        $userId = $matchedUser?->id;
                    }

                    $kategori = $m['kategori_anggota'] ?? (($m['peran'] === 'mahasiswa') ? 'taruna' : 'internal');

                    $proposal->members()->create([
                        'user_id' => $userId,
                        'nama' => $m['nama'],
                        'peran' => $m['peran'],
                        'kategori_anggota' => $kategori,
                        'asal_instansi' => $m['asal_instansi'] ?? 'Politeknik Keselamatan Transportasi Jalan',
                        'negara' => $m['negara'] ?? 'Indonesia',
                        'nidn_nim' => $m['nidn_nim'] ?? null,
                        'tugas' => $m['tugas'] ?? null,
                    ]);
                }
            }

            // Simpan Item RAB
            foreach ($budgetItems as $item) {
                $proposal->budgets()->create($item);
            }

            DB::commit();

            $pesan = ($validated['action_type'] === 'diajukan')
                ? 'Usulan proposal berhasil diajukan ke P3M PKTJ.'
                : 'Draf usulan proposal berhasil disimpan.';

            return redirect()->route('dosen.proposals.show', $proposal)->with('success', $pesan);
        } catch (\Throwable $e) {
            DB::rollBack();
            if (isset($filePath) && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            return back()->withInput()->with('error', 'Terjadi kendala saat menyimpan usulan: '.$e->getMessage());
        }
    }

    /**
     * Tampilkan detail dan alur pelacak status usulan.
     */
    public function show(Proposal $proposal): View
    {
        $this->authorizeAccess($proposal);

        $proposal->load([
            'prodi',
            'ketua.prodi',
            'members',
            'budgets',
            'reviews.reviewer.prodi',
        ]);

        return view('dosen.proposals.show', compact('proposal'));
    }

    /**
     * Tampilkan formulir edit usulan (hanya untuk status draft dan revisi).
     */
    public function edit(Proposal $proposal): View|RedirectResponse
    {
        $this->authorizeAccess($proposal);

        if (! in_array($proposal->status, ['draft', 'revisi'])) {
            return redirect()->route('dosen.proposals.show', $proposal)
                ->with('error', 'Usulan yang sedang diproses atau telah diverifikasi tidak dapat diubah.');
        }

        $user = Auth::user();
        $prodis = Prodi::orderBy('jenjang', 'desc')->get();
        $dosenList = User::where('role', 'dosen')
            ->where('id', '!=', $user->id)
            ->where('status_aktif', true)
            ->with('prodi')
            ->orderBy('name')
            ->get();

        $kategoriBelanja = [
            'bahan_habis_pakai' => 'Belanja Bahan Habis Pakai & ATK',
            'sewa_alat' => 'Sewa Peralatan Lab / Pengujian Lapangan',
            'perjalanan_lapangan' => 'Perjalanan Dinas & Survei Lapangan',
            'honorarium' => 'Honorarium Pembantu Peneliti / Surveyor',
            'publikasi_diseminasi' => 'Biaya Publikasi Jurnal & Pendaftaran HKI',
            'lainnya' => 'Operasional & Pelaporan Akhir',
        ];

        $proposal->load(['members', 'budgets']);

        return view('dosen.proposals.edit', compact('proposal', 'user', 'prodis', 'dosenList', 'kategoriBelanja'));
    }

    /**
     * Perbarui data usulan proposal.
     */
    public function update(Request $request, Proposal $proposal): RedirectResponse
    {
        $this->authorizeAccess($proposal);

        if (! in_array($proposal->status, ['draft', 'revisi'])) {
            return redirect()->route('dosen.proposals.show', $proposal)
                ->with('error', 'Usulan tidak dalam status yang dapat diubah.');
        }

        $rules = [
            'jenis' => 'required|in:penelitian,pengabdian',
            'judul' => 'required|string|max:500',
            'abstrak' => 'nullable|string',
            'prodi_id' => 'required|exists:prodis,id',
            'skema' => 'required|string|max:150',
            'tahun_anggaran' => 'required|integer|digits:4',
            'sumber_dana' => 'nullable|string|max:100',
            'kata_kunci' => 'nullable|string|max:255',
            'bidang_fokus' => 'nullable|string|max:150',
            'lama_kegiatan_tahun' => 'nullable|integer|min:1|max:5',
            'topik_kegiatan' => 'nullable|string|max:255',
            'lokasi_kegiatan' => 'nullable|string|max:255',
            'bank_nama' => 'nullable|string|max:100',
            'bank_rekening' => 'nullable|string|max:50',
            'bank_pemilik' => 'nullable|string|max:150',
            'nama_berkas_proposal' => 'nullable|string|max:255',
            'nama_mitra' => 'nullable|string|max:255',
            'kontribusi_mitra' => 'nullable|string|max:255',
            'dana_mitra' => 'nullable|numeric|min:0',
            'dana_tambahan' => 'nullable|numeric|min:0',
            'file_mitra' => 'nullable|file|mimes:pdf|max:10240',
            'action_type' => 'required|in:draft,diajukan',
            'file_proposal' => 'nullable|file|mimes:pdf|max:10240',
            'persetujuan_konfirmasi' => 'nullable|boolean',
            'luaran_target' => 'nullable|array',
            'luaran_target.*.jenis' => 'required_with:luaran_target|string|max:100',
            'luaran_target.*.keterangan' => 'nullable|string|max:500',
            'jadwal_kegiatan' => 'nullable|array',
            'jadwal_kegiatan.*.nama_kegiatan' => 'required_with:jadwal_kegiatan|string|max:255',
            'jadwal_kegiatan.*.tahun' => 'nullable|integer|min:1|max:5',
            'jadwal_kegiatan.*.tanggal_mulai' => 'nullable|date',
            'jadwal_kegiatan.*.tanggal_selesai' => 'nullable|date',
            'members' => 'nullable|array',
            'members.*.nama' => 'required_with:members|string|max:255',
            'members.*.peran' => 'required_with:members|string|max:50',
            'members.*.kategori_anggota' => 'nullable|string|max:30',
            'members.*.asal_instansi' => 'nullable|string|max:255',
            'members.*.negara' => 'nullable|string|max:100',
            'members.*.nidn_nim' => 'nullable|string|max:30',
            'members.*.tugas' => 'nullable|string|max:255',
            'budgets' => 'nullable|array',
            'budgets.*.kategori_belanja' => 'required_with:budgets|string|max:50',
            'budgets.*.tahun_ke' => 'nullable|integer|min:1|max:5',
            'budgets.*.uraian' => 'required_with:budgets|string|max:255',
            'budgets.*.volume' => 'required_with:budgets|numeric|min:0.01',
            'budgets.*.satuan' => 'required_with:budgets|string|max:50',
            'budgets.*.harga_satuan' => 'required_with:budgets|numeric|min:0',
        ];

        $validated = $request->validate($rules);

        DB::beginTransaction();
        try {
            $filePath = $proposal->file_proposal;
            if ($request->hasFile('file_proposal')) {
                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                $filePath = $request->file('file_proposal')->store('proposals', 'public');
            }

            // Unggah berkas mitra jika ada
            $fileMitraPath = $proposal->file_mitra;
            if ($request->hasFile('file_mitra')) {
                if ($fileMitraPath && Storage::disk('public')->exists($fileMitraPath)) {
                    Storage::disk('public')->delete($fileMitraPath);
                }
                $fileMitraPath = $request->file('file_mitra')->store('proposals_mitra', 'public');
            }

            // Hitung total anggaran
            $totalAnggaran = 0;
            $budgetItems = [];
            if (! empty($validated['budgets'])) {
                foreach ($validated['budgets'] as $b) {
                    $volume = (float) $b['volume'];
                    $hargaSatuan = (float) $b['harga_satuan'];
                    $subtotal = $volume * $hargaSatuan;
                    $totalAnggaran += $subtotal;

                    $budgetItems[] = [
                        'kategori_belanja' => $b['kategori_belanja'],
                        'tahun_ke' => $b['tahun_ke'] ?? 1,
                        'uraian' => $b['uraian'],
                        'volume' => $volume,
                        'satuan' => $b['satuan'],
                        'harga_satuan' => $hargaSatuan,
                        'total_harga' => $subtotal,
                    ];
                }
            }

            $newStatus = $proposal->status;
            if ($proposal->status === 'draft' && $validated['action_type'] === 'diajukan') {
                $newStatus = 'diajukan';
            }

            $proposal->update([
                'jenis' => $validated['jenis'],
                'judul' => $validated['judul'],
                'abstrak' => $validated['abstrak'] ?? null,
                'kata_kunci' => $validated['kata_kunci'] ?? null,
                'bidang_fokus' => $validated['bidang_fokus'] ?? null,
                'lama_kegiatan_tahun' => $validated['lama_kegiatan_tahun'] ?? 1,
                'topik_kegiatan' => $validated['topik_kegiatan'] ?? null,
                'lokasi_kegiatan' => $validated['lokasi_kegiatan'] ?? null,
                'prodi_id' => $validated['prodi_id'],
                'tahun_anggaran' => $validated['tahun_anggaran'],
                'skema' => $validated['skema'],
                'sumber_dana' => $validated['sumber_dana'] ?? 'DIPA PKTJ',
                'total_anggaran' => $totalAnggaran,
                'bank_nama' => $validated['bank_nama'] ?? null,
                'bank_rekening' => $validated['bank_rekening'] ?? null,
                'bank_pemilik' => $validated['bank_pemilik'] ?? null,
                'nama_berkas_proposal' => $validated['nama_berkas_proposal'] ?? $proposal->nama_berkas_proposal,
                'nama_mitra' => $validated['nama_mitra'] ?? null,
                'kontribusi_mitra' => $validated['kontribusi_mitra'] ?? null,
                'dana_mitra' => $validated['dana_mitra'] ?? null,
                'dana_tambahan' => $validated['dana_tambahan'] ?? null,
                'luaran_target' => $validated['luaran_target'] ?? null,
                'jadwal_kegiatan' => $validated['jadwal_kegiatan'] ?? null,
                'persetujuan_konfirmasi' => (bool) ($request->input('persetujuan_konfirmasi', false)),
                'file_mitra' => $fileMitraPath,
                'file_proposal' => $filePath,
                'status' => $newStatus,
            ]);

            // Hapus anggota tim lama dan perbarui
            $proposal->members()->delete();
            if (! empty($validated['members'])) {
                foreach ($validated['members'] as $m) {
                    $userId = null;
                    if ($m['peran'] === 'dosen_anggota' && ! empty($m['nidn_nim'])) {
                        $matchedUser = User::where('nidn_nip', $m['nidn_nim'])->first();
                        $userId = $matchedUser?->id;
                    }

                    $kategori = $m['kategori_anggota'] ?? (($m['peran'] === 'mahasiswa') ? 'taruna' : 'internal');

                    $proposal->members()->create([
                        'user_id' => $userId,
                        'nama' => $m['nama'],
                        'peran' => $m['peran'],
                        'kategori_anggota' => $kategori,
                        'asal_instansi' => $m['asal_instansi'] ?? 'Politeknik Keselamatan Transportasi Jalan',
                        'negara' => $m['negara'] ?? 'Indonesia',
                        'nidn_nim' => $m['nidn_nim'] ?? null,
                        'tugas' => $m['tugas'] ?? null,
                    ]);
                }
            }

            // Hapus item RAB lama dan perbarui
            $proposal->budgets()->delete();
            foreach ($budgetItems as $item) {
                $proposal->budgets()->create($item);
            }

            DB::commit();

            return redirect()->route('dosen.proposals.show', $proposal)
                ->with('success', 'Pembaruan usulan proposal berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Gagal memperbarui usulan: '.$e->getMessage());
        }
    }

    /**
     * Hapus proposal (hanya jika masih status draft).
     */
    public function destroy(Proposal $proposal): RedirectResponse
    {
        $this->authorizeAccess($proposal);

        if ($proposal->status !== 'draft') {
            return back()->with('error', 'Hanya usulan berstatus draf yang dapat dihapus.');
        }

        if ($proposal->file_proposal && Storage::disk('public')->exists($proposal->file_proposal)) {
            Storage::disk('public')->delete($proposal->file_proposal);
        }

        $proposal->delete();

        return redirect()->route('dosen.dashboard')->with('success', 'Draf usulan proposal berhasil dihapus.');
    }

    /**
     * Kirimkan proposal berstatus draft menjadi diajukan.
     */
    public function submit(Proposal $proposal): RedirectResponse
    {
        $this->authorizeAccess($proposal);

        if ($proposal->status !== 'draft') {
            return back()->with('error', 'Usulan telah dikirimkan sebelumnya.');
        }

        if (! $proposal->file_proposal) {
            return back()->with('error', 'Mohon unggah berkas proposal PDF sebelum mengirimkan usulan.');
        }

        $proposal->update(['status' => 'diajukan']);

        return redirect()->route('dosen.proposals.show', $proposal)
            ->with('success', 'Usulan proposal berhasil dikirimkan ke P3M PKTJ untuk proses verifikasi berkas.');
    }

    /**
     * Unggah berkas perbaikan / revisi proposal yang diminta reviewer/admin.
     */
    public function uploadRevision(Request $request, Proposal $proposal): RedirectResponse
    {
        $this->authorizeAccess($proposal);

        if ($proposal->status !== 'revisi') {
            return back()->with('error', 'Usulan tidak dalam status revisi.');
        }

        $request->validate([
            'file_revisi' => 'required|file|mimes:pdf|max:10240',
        ]);

        if ($proposal->file_revisi && Storage::disk('public')->exists($proposal->file_revisi)) {
            Storage::disk('public')->delete($proposal->file_revisi);
        }

        $filePath = $request->file('file_revisi')->store('proposals_revisi', 'public');

        $proposal->update([
            'file_revisi' => $filePath,
            'status' => 'sedang_direview',
        ]);

        return redirect()->route('dosen.proposals.show', $proposal)
            ->with('success', 'Berkas revisi proposal berhasil diunggah. Usulan kini kembali dalam penilaian reviewer.');
    }

    /**
     * Proteksi otorisasi kepemilikan usulan.
     */
    protected function authorizeAccess(Proposal $proposal): void
    {
        if ($proposal->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak: Anda bukan ketua pengusul usulan ini.');
        }
    }
}
