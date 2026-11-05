<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DocumentController extends Controller
{
    /**
     * Menampilkan daftar dokumen regulasi dan SOP.
     */
    public function index(Request $request): View
    {
        $query = Document::latest();

        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%");
        }

        $documents = $query->paginate(10)->withQueryString();

        return view('admin.documents.index', compact('documents'));
    }

    /**
     * Formulir unggah dokumen baru.
     */
    public function create(): View
    {
        return view('admin.documents.create');
    }

    /**
     * Menyimpan dokumen baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'in:pedoman_penelitian,pedoman_pengabdian,proses_pengabdian,panduan_sistem,renstra,renstra_penelitian,renstra_pengabdian,roadmap,sop_penelitian,sop_pengabdian,panduan'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
            'file_dokumen' => ['required', 'file', 'mimes:pdf,docx,xlsx', 'max:20480'], // max 20MB
            'tahun' => ['nullable', 'string', 'max:50'],
        ], [
            'judul.required' => 'Judul dokumen wajib diisi.',
            'file_dokumen.required' => 'Silakan pilih berkas dokumen yang akan diunggah.',
            'file_dokumen.mimes' => 'Format berkas harus PDF, DOCX, atau XLSX.',
            'file_dokumen.max' => 'Ukuran berkas maksimal 20 MB.',
        ]);

        $file = $request->file('file_dokumen');
        $fileSize = round($file->getSize() / 1024 / 1024, 2).' MB';
        if ($file->getSize() < 1048576) {
            $fileSize = round($file->getSize() / 1024).' KB';
        }

        $filePath = $file->store('documents', 'public');

        Document::create([
            'judul' => $validated['judul'],
            'kategori' => $validated['kategori'],
            'deskripsi' => $validated['deskripsi'],
            'file_path' => $filePath,
            'file_size' => $fileSize,
            'tahun' => $validated['tahun'] ?? date('Y'),
            'user_id' => Auth::id(),
            'download_count' => 0,
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil diunggah.');
    }

    /**
     * Formulir ubah informasi dokumen.
     */
    public function edit(Document $document): View
    {
        return view('admin.documents.edit', compact('document'));
    }

    /**
     * Memperbarui dokumen.
     */
    public function update(Request $request, Document $document): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'in:pedoman_penelitian,pedoman_pengabdian,proses_pengabdian,panduan_sistem,renstra,renstra_penelitian,renstra_pengabdian,roadmap,sop_penelitian,sop_pengabdian,panduan'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
            'file_dokumen' => ['nullable', 'file', 'mimes:pdf,docx,xlsx', 'max:20480'],
            'tahun' => ['nullable', 'string', 'max:50'],
        ]);

        if ($request->hasFile('file_dokumen')) {
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }
            $file = $request->file('file_dokumen');
            $fileSize = round($file->getSize() / 1024 / 1024, 2).' MB';
            if ($file->getSize() < 1048576) {
                $fileSize = round($file->getSize() / 1024).' KB';
            }

            $document->file_path = $file->store('documents', 'public');
            $document->file_size = $fileSize;
        }

        $document->update([
            'judul' => $validated['judul'],
            'kategori' => $validated['kategori'],
            'deskripsi' => $validated['deskripsi'],
            'tahun' => $validated['tahun'] ?? $document->tahun,
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    /**
     * Menghapus dokumen.
     */
    public function destroy(Document $document): RedirectResponse
    {
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
