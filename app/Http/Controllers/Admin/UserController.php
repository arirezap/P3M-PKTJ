<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Menampilkan daftar akun dosen dan reviewer dengan dukungan filter peran sub-menu.
     */
    public function index(Request $request): View
    {
        $selectedRole = $request->input('role', 'semua');
        $query = User::with('prodi')->latest();

        if ($selectedRole !== 'semua') {
            $query->where(function ($q) use ($selectedRole) {
                if ($selectedRole === 'peneliti' || $selectedRole === 'dosen') {
                    $q->whereJsonContains('roles', 'peneliti')
                        ->orWhereJsonContains('roles', 'dosen')
                        ->orWhere('role', 'dosen');
                } else {
                    $q->whereJsonContains('roles', $selectedRole)
                        ->orWhere('role', $selectedRole);
                }
            });
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

        // Statistik jumlah pengguna untuk tab sub-menu
        $stats = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->orWhereJsonContains('roles', 'admin')->count(),
            'reviewer' => User::where('role', 'reviewer')->orWhereJsonContains('roles', 'reviewer')->count(),
            'peneliti' => User::whereIn('role', ['dosen', 'peneliti'])->orWhereJsonContains('roles', 'peneliti')->orWhereJsonContains('roles', 'dosen')->count(),
        ];

        return view('admin.users.index', compact('users', 'prodis', 'stats', 'selectedRole'));
    }

    /**
     * Memperbarui peran (roles) pengguna secara langsung melalui checkbox multi-role.
     */
    public function updateRoles(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['in:admin,reviewer,peneliti,dosen'],
        ], [
            'roles.required' => 'Setiap pengguna wajib memiliki minimal satu peran aktif.',
            'roles.min' => 'Pilih minimal satu peran untuk pengguna ini.',
        ]);

        $roles = array_map(function ($r) {
            return $r === 'dosen' ? 'peneliti' : $r;
        }, $validated['roles']);
        $roles = array_values(array_unique($roles));

        // Proteksi: jangan sampai admin mencabut peran admin dari akunnya sendiri
        if ($user->id === auth()->id() && ! in_array('admin', $roles, true)) {
            return back()->with('error', 'Anda tidak dapat mencabut peran Administrator dari akun Anda sendiri.');
        }

        // Tentukan primary role untuk kompatibilitas mundur
        $primaryRole = in_array('admin', $roles, true)
            ? 'admin'
            : (in_array('reviewer', $roles, true) ? 'reviewer' : 'dosen');

        $user->update([
            'roles' => $roles,
            'role' => $primaryRole,
        ]);

        $rolesLabel = implode(', ', array_map(function ($r) {
            return match ($r) {
                'admin' => 'Admin',
                'reviewer' => 'Reviewer',
                'peneliti' => 'Peneliti',
                default => ucfirst($r),
            };
        }, $roles));

        return back()->with('success', "Peran untuk {$user->name} berhasil diperbarui: {$rolesLabel}.");
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
            'role' => ['nullable', 'in:admin,dosen,reviewer,peneliti'],
            'roles' => ['nullable', 'array', 'min:1'],
            'roles.*' => ['in:admin,reviewer,peneliti,dosen'],
            'nidn_nip' => ['nullable', 'string', 'max:30'],
            'prodi_id' => ['nullable', 'exists:prodis,id'],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'keahlian' => ['nullable', 'string', 'max:255'],
        ], [
            'email.unique' => 'Email tersebut sudah terdaftar.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
        ]);

        $rolesList = $request->input('roles', []);
        if (empty($rolesList)) {
            $defaultRole = $validated['role'] ?? 'dosen';
            $rolesList = [$defaultRole === 'dosen' ? 'peneliti' : $defaultRole];
        } else {
            $rolesList = array_map(fn ($r) => $r === 'dosen' ? 'peneliti' : $r, $rolesList);
        }
        $rolesList = array_values(array_unique($rolesList));

        $primaryRole = in_array('admin', $rolesList, true)
            ? 'admin'
            : (in_array('reviewer', $rolesList, true) ? 'reviewer' : 'dosen');

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $primaryRole,
            'roles' => $rolesList,
            'nidn_nip' => $validated['nidn_nip'] ?? null,
            'prodi_id' => $validated['prodi_id'] ?? null,
            'no_telp' => $validated['no_telp'] ?? null,
            'keahlian' => $validated['keahlian'] ?? null,
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
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['nullable', 'in:admin,dosen,reviewer,peneliti'],
            'roles' => ['nullable', 'array', 'min:1'],
            'roles.*' => ['in:admin,reviewer,peneliti,dosen'],
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
            'roles.min' => 'Pilih minimal satu peran untuk pengguna ini.',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nidn_nip' => $validated['nidn_nip'] ?? null,
            'prodi_id' => $validated['prodi_id'] ?? null,
            'no_telp' => $validated['no_telp'] ?? null,
            'keahlian' => $validated['keahlian'] ?? null,
            'sinta_id' => $validated['sinta_id'] ?? null,
            'scopus_id' => $validated['scopus_id'] ?? null,
            'google_scholar' => $validated['google_scholar'] ?? null,
            'status_aktif' => $request->has('status_aktif') ? (bool) $request->status_aktif : true,
        ];

        $rolesList = $request->input('roles');
        if (is_array($rolesList) && ! empty($rolesList)) {
            $rolesList = array_map(fn ($r) => $r === 'dosen' ? 'peneliti' : $r, $rolesList);
            $rolesList = array_values(array_unique($rolesList));

            // Proteksi: jangan sampai admin mencabut peran admin dari akunnya sendiri
            if ($user->id === auth()->id() && ! in_array('admin', $rolesList, true)) {
                return back()->with('error', 'Anda tidak dapat mencabut peran Administrator dari akun Anda sendiri.');
            }

            $data['roles'] = $rolesList;
            $data['role'] = in_array('admin', $rolesList, true)
                ? 'admin'
                : (in_array('reviewer', $rolesList, true) ? 'reviewer' : 'dosen');
        } elseif ($request->filled('role')) {
            $singleRole = $validated['role'];
            $data['role'] = $singleRole;
            $data['roles'] = [$singleRole === 'dosen' ? 'peneliti' : $singleRole];
        }

        if (! empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
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

        $user->update(['status_aktif' => ! $user->status_aktif]);
        $statusStr = $user->status_aktif ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Akun {$user->name} berhasil {$statusStr}.");
    }
}
