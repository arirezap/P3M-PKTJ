<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\ProposalFinalReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FinalReportController extends Controller
{
    /**
     * Tampilkan formulir pengunggahan Laporan Akhir, realisasi RAB 100%, dan luaran definitif.
     */
    public function create(Proposal $proposal): View|RedirectResponse
    {
        $this->authorizeAccess($proposal);

        if (!in_array($proposal->status, ['diterima', 'pelaksanaan', 'laporan_akhir', 'archive'])) {
            return redirect()->route('dosen.proposals.show', $proposal)
                ->with('error', 'Laporan akhir hanya dapat disampaikan untuk kegiatan yang telah disetujui / dalam pelaksanaan.');
        }

        if ($proposal->finalReport && $proposal->finalReport->status_laporan !== 'revisi') {
            return redirect()->route('dosen.proposals.final-report.show', $proposal);
        }

        $proposal->load(['budgets', 'members']);

        return view('dosen.final-reports.create', compact('proposal'));
    }

    /**
     * Simpan naskah Laporan Akhir beserta pembukuan realisasi anggaran 100%.
     */
    public function store(Request $request, Proposal $proposal): RedirectResponse
    {
        $this->authorizeAccess($proposal);

        if (!in_array($proposal->status, ['diterima', 'pelaksanaan', 'laporan_akhir'])) {
            return redirect()->route('dosen.proposals.show', $proposal)
                ->with('error', 'Status usulan saat ini tidak mengizinkan penyerahan laporan akhir.');
        }

        $validated = $request->validate([
            'file_laporan_akhir' => 'required|file|mimes:pdf|max:20480',
            'ringkasan_hasil' => 'nullable|string',
            'perubahan_anggota' => 'nullable|string',
            'realisasi' => 'nullable|array',
            'total_realisasi_anggaran' => 'nullable|numeric|min:0',
            'file_bukti_spj' => 'nullable|file|mimes:pdf,zip,rar|max:20480',
            'luaran' => 'nullable|array',
        ]);

        // Unggah Berkas Laporan Akhir PDF
        $fileLaporanPath = $request->file('file_laporan_akhir')->store('final_reports', 'public');

        // Unggah Bukti SPJ jika ada
        $fileSpjPath = null;
        if ($request->hasFile('file_bukti_spj')) {
            $fileSpjPath = $request->file('file_bukti_spj')->store('final_reports_spj', 'public');
        }

        // Hitung akumulasi realisasi anggaran
        $totalRealisasi = 0;
        if (!empty($validated['realisasi'])) {
            foreach ($validated['realisasi'] as $item) {
                $totalRealisasi += (float) ($item['realisasi'] ?? 0);
            }
        } elseif (!empty($validated['total_realisasi_anggaran'])) {
            $totalRealisasi = (float) $validated['total_realisasi_anggaran'];
        }

        $proposal->finalReport()->updateOrCreate(
            ['proposal_id' => $proposal->id],
            [
                'user_id' => Auth::id(),
                'file_laporan_akhir' => $fileLaporanPath,
                'ringkasan_hasil' => $validated['ringkasan_hasil'] ?? null,
                'perubahan_anggota' => $validated['perubahan_anggota'] ?? null,
                'total_realisasi_anggaran' => $totalRealisasi,
                'rincian_realisasi' => $validated['realisasi'] ?? null,
                'file_bukti_spj' => $fileSpjPath ?? ($proposal->finalReport?->file_bukti_spj),
                'capaian_luaran' => $validated['luaran'] ?? null,
                'status_laporan' => 'terkirim',
                'tanggal_penyerahan' => now(),
            ]
        );

        $proposal->update(['status' => 'laporan_akhir']);

        return redirect()->route('dosen.proposals.final-report.show', $proposal)
            ->with('success', 'Naskah Laporan Akhir dan rekapitulasi realisasi anggaran berhasil diserahkan ke P3M PKTJ.');
    }

    /**
     * Tampilkan detail dokumen Laporan Akhir dan status telaah reviewer.
     */
    public function show(Proposal $proposal): View|RedirectResponse
    {
        $this->authorizeAccess($proposal);

        $finalReport = $proposal->finalReport;
        if (!$finalReport) {
            return redirect()->route('dosen.proposals.final-report.create', $proposal)
                ->with('info', 'Laporan akhir belum disampaikan. Silakan unggah dokumen laporan akhir.');
        }

        return view('dosen.final-reports.show', compact('proposal', 'finalReport'));
    }

    /**
     * Unggah berkas perbaikan / revisi laporan akhir jika diminta reviewer.
     */
    public function uploadRevision(Request $request, Proposal $proposal): RedirectResponse
    {
        $this->authorizeAccess($proposal);

        $finalReport = $proposal->finalReport;
        if (!$finalReport || $finalReport->status_laporan !== 'revisi') {
            return back()->with('error', 'Laporan akhir tidak dalam status revisi.');
        }

        $request->validate([
            'file_revisi_laporan' => 'required|file|mimes:pdf|max:20480',
        ]);

        if ($finalReport->file_revisi_laporan && Storage::disk('public')->exists($finalReport->file_revisi_laporan)) {
            Storage::disk('public')->delete($finalReport->file_revisi_laporan);
        }

        $filePath = $request->file('file_revisi_laporan')->store('final_reports_revisi', 'public');

        $finalReport->update([
            'file_revisi_laporan' => $filePath,
            'status_laporan' => 'proses_review',
        ]);

        return redirect()->route('dosen.proposals.final-report.show', $proposal)
            ->with('success', 'Berkas revisi Laporan Akhir berhasil diunggah. Dokumen kini dalam proses evaluasi kembali.');
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

