<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MonevController extends Controller
{
    /**
     * Tampilkan formulir pengisian instrumen Monev (7 PG + 7 Essai).
     */
    public function create(Proposal $proposal): View|RedirectResponse
    {
        $this->authorizeAccess($proposal);

        if (! in_array($proposal->status, ['diterima', 'pelaksanaan', 'laporan_akhir', 'archive'])) {
            return redirect()->route('dosen.proposals.show', $proposal)
                ->with('error', 'Instrumen Monev hanya dapat diisi setelah usulan disetujui / dalam tahap pelaksanaan.');
        }

        if ($proposal->monev) {
            return redirect()->route('dosen.proposals.monev.show', $proposal);
        }

        return view('dosen.monev.create', compact('proposal'));
    }

    /**
     * Simpan instrumen Monev ke dalam database.
     */
    public function store(Request $request, Proposal $proposal): RedirectResponse
    {
        $this->authorizeAccess($proposal);

        if (! in_array($proposal->status, ['diterima', 'pelaksanaan'])) {
            return redirect()->route('dosen.proposals.show', $proposal)
                ->with('error', 'Status usulan saat ini tidak mengizinkan pengisian Monev.');
        }

        $validated = $request->validate([
            // 7 Pertanyaan Pilihan Ganda Capaian
            'capaian_penelitian' => 'required|string|max:50',
            'publikasi_ilmiah' => 'required|string|max:50',
            'pemakalah_ilmiah' => 'required|string|max:50',
            'hki' => 'required|string|max:50',
            'teknologi_tepat_guna' => 'required|string|max:50',
            'produk_purwarupa' => 'required|string|max:50',
            'buku_ajar' => 'required|string|max:50',

            // 7 Pertanyaan Essai Kesesuaian
            'kegiatan_terlaksana' => 'required|string',
            'kesesuaian_waktu' => 'required|string',
            'kesesuaian_metode' => 'required|string',
            'kesesuaian_personalia' => 'required|string',
            'kesesuaian_anggaran' => 'required|string',
            'kesesuaian_sarpras' => 'required|string',
            'kesesuaian_target' => 'required|string',

            // Berkas bukti luaran sementara
            'file_bukti_luaran' => 'nullable|file|mimes:pdf,zip,rar|max:20480',
        ]);

        $filePath = null;
        if ($request->hasFile('file_bukti_luaran')) {
            $filePath = $request->file('file_bukti_luaran')->store('monev_bukti', 'public');
        }

        $proposal->monev()->updateOrCreate(
            ['proposal_id' => $proposal->id],
            [
                'user_id' => Auth::id(),
                'capaian_penelitian' => $validated['capaian_penelitian'],
                'publikasi_ilmiah' => $validated['publikasi_ilmiah'],
                'pemakalah_ilmiah' => $validated['pemakalah_ilmiah'],
                'hki' => $validated['hki'],
                'teknologi_tepat_guna' => $validated['teknologi_tepat_guna'],
                'produk_purwarupa' => $validated['produk_purwarupa'],
                'buku_ajar' => $validated['buku_ajar'],
                'kegiatan_terlaksana' => $validated['kegiatan_terlaksana'],
                'kesesuaian_waktu' => $validated['kesesuaian_waktu'],
                'kesesuaian_metode' => $validated['kesesuaian_metode'],
                'kesesuaian_personalia' => $validated['kesesuaian_personalia'],
                'kesesuaian_anggaran' => $validated['kesesuaian_anggaran'],
                'kesesuaian_sarpras' => $validated['kesesuaian_sarpras'],
                'kesesuaian_target' => $validated['kesesuaian_target'],
                'file_bukti_luaran' => $filePath ?? ($proposal->monev?->file_bukti_luaran),
                'status_monev' => 'terkirim',
                'tanggal_monev' => now(),
            ]
        );

        if ($proposal->status === 'diterima') {
            $proposal->update(['status' => 'pelaksanaan']);
        }

        return redirect()->route('dosen.proposals.monev.show', $proposal)
            ->with('success', 'Instrumen pemantauan dan evaluasi (Monev) berhasil dikirimkan.');
    }

    /**
     * Tampilkan detail hasil pengisian instrumen Monev dan masukan reviewer.
     */
    public function show(Proposal $proposal): View|RedirectResponse
    {
        $this->authorizeAccess($proposal);

        $monev = $proposal->monev;
        if (! $monev) {
            return redirect()->route('dosen.proposals.monev.create', $proposal)
                ->with('info', 'Instrumen Monev belum diisi. Silakan lengkapi formulir berikut.');
        }

        return view('dosen.monev.show', compact('proposal', 'monev'));
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
