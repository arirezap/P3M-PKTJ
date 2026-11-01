<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Menampilkan daftar berita, agenda, dan pengumuman.
     */
    public function index(Request $request): View
    {
        $query = Post::with('author')->latest('tanggal_publikasi');

        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('ringkasan', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(10)->withQueryString();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Formulir penulisan berita / pengumuman baru.
     */
    public function create(): View
    {
        return view('admin.posts.create');
    }

    /**
     * Menyimpan berita / pengumuman baru ke basis data.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'in:berita,agenda,pengumuman'],
            'ringkasan' => ['nullable', 'string', 'max:500'],
            'konten' => ['required', 'string'],
            'gambar_sampul' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'status' => ['required', 'in:draft,published'],
            'tanggal_publikasi' => ['required', 'date'],
            'is_pinned' => ['nullable', 'boolean'],
        ], [
            'judul.required' => 'Judul publikasi wajib diisi.',
            'konten.required' => 'Isi konten berita wajib diisi.',
            'gambar_sampul.image' => 'Berkas sampul harus berupa berkas gambar (JPG, PNG, WebP).',
            'gambar_sampul.max' => 'Ukuran berkas gambar maksimal 2MB.',
        ]);

        $slug = Str::slug($validated['judul']);
        // Pastikan slug unik
        $originalSlug = $slug;
        $counter = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        $gambarPath = null;
        if ($request->hasFile('gambar_sampul')) {
            $gambarPath = $request->file('gambar_sampul')->store('posts', 'public');
        }

        Post::create([
            'judul' => $validated['judul'],
            'slug' => $slug,
            'kategori' => $validated['kategori'],
            'ringkasan' => $validated['ringkasan'],
            'konten' => $validated['konten'],
            'gambar_sampul' => $gambarPath,
            'user_id' => Auth::id(),
            'status' => $validated['status'],
            'tanggal_publikasi' => $validated['tanggal_publikasi'],
            'is_pinned' => $request->boolean('is_pinned'),
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Publikasi berhasil diterbitkan.');
    }

    /**
     * Formulir edit berita / pengumuman.
     */
    public function edit(Post $post): View
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Memperbarui berita / pengumuman.
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'in:berita,agenda,pengumuman'],
            'ringkasan' => ['nullable', 'string', 'max:500'],
            'konten' => ['required', 'string'],
            'gambar_sampul' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'status' => ['required', 'in:draft,published'],
            'tanggal_publikasi' => ['required', 'date'],
            'is_pinned' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('gambar_sampul')) {
            if ($post->gambar_sampul && Storage::disk('public')->exists($post->gambar_sampul)) {
                Storage::disk('public')->delete($post->gambar_sampul);
            }
            $post->gambar_sampul = $request->file('gambar_sampul')->store('posts', 'public');
        }

        $post->update([
            'judul' => $validated['judul'],
            'kategori' => $validated['kategori'],
            'ringkasan' => $validated['ringkasan'],
            'konten' => $validated['konten'],
            'status' => $validated['status'],
            'tanggal_publikasi' => $validated['tanggal_publikasi'],
            'is_pinned' => $request->boolean('is_pinned'),
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Publikasi berhasil diperbarui.');
    }

    /**
     * Menghapus berita / pengumuman.
     */
    public function destroy(Post $post): RedirectResponse
    {
        if ($post->gambar_sampul && Storage::disk('public')->exists($post->gambar_sampul)) {
            Storage::disk('public')->delete($post->gambar_sampul);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Publikasi berhasil dihapus.');
    }
}
