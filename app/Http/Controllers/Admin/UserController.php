<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Menampilkan daftar akun dosen dan reviewer.
     */
    public function index(Request $request): View
    {
        $query = User::with('prodi')->latest();

        if ($request->filled('role') && $request->role !== 'semua') {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nidn_nip', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(15)->withQueryString();
        $prodis = Prodi::where('status_aktif', true)->get();

        return view('admin.users.index', compact('users', 'prodis'));
    }

    /**
     * Menyimpan akun baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'in:admin,dosen,reviewer'],
            'nidn_nip' => ['nullable', 'string', 'max:30'],
            'prodi_id' => ['nullable', 'exists:prodis,id'],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'keahlian' => ['nullable', 'string', 'max:255'],
        ], [
            'email.unique' => 'Email tersebut sudah terdaftar.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'nidn_nip' => $validated['nidn_nip'],
            'prodi_id' => $validated['prodi_id'],
            'no_telp' => $validated['no_telp'],
            'keahlian' => $validated['keahlian'],
            'status_aktif' => true,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir sunting profil peneliti & akun.
     */
    public function edit(User $user): View
    {
        $prodis = Prodi::where('status_aktif', true)->get();
        $user->load(['prodi', 'researches', 'outputs']);

        return view('admin.users.edit', compact('user', 'prodis'));
    }

    /**
     * Memperbarui profil peneliti & akun.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', 'in:admin,dosen,reviewer'],
            'nidn_nip' => ['nullable', 'string', 'max:30'],
            'prodi_id' => ['nullable', 'exists:prodis,id'],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'keahlian' => ['nullable', 'string', 'max:255'],
            'sinta_id' => ['nullable', 'string', 'max:50'],
            'scopus_id' => ['nullable', 'string', 'max:50'],
            'google_scholar' => ['nullable', 'string', 'max:255'],
            'status_aktif' => ['nullable', 'boolean'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'email.unique' => 'Email tersebut telah digunakan pengguna lain.',
            'password.min' => 'Kata sandi baru minimal 6 karakter.',
            'avatar.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'nidn_nip' => $validated['nidn_nip'],
            'prodi_id' => $validated['prodi_id'],
            'no_telp' => $validated['no_telp'],
            'keahlian' => $validated['keahlian'],
            'sinta_id' => $validated['sinta_id'],
            'scopus_id' => $validated['scopus_id'],
            'google_scholar' => $validated['google_scholar'],
            'status_aktif' => $request->has('status_aktif') ? (bool) $request->status_aktif : true,
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', "Profil peneliti {$user->name} berhasil diperbarui.");
    }

    /**
     * Mengubah status aktif akun pengguna.
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun sendiri.');
        }

        $user->update(['status_aktif' => !$user->status_aktif]);
        $statusStr = $user->status_aktif ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Akun {$user->name} berhasil {$statusStr}.");
    }
}
