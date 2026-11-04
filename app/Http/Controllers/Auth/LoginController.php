<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman formulir login SIM P3M.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Memproses autentikasi pengguna (mendukung login via Email atau NIDN/NIP).
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Silakan masukkan Nama Pengguna (Email atau NIDN/NIP) Anda.',
            'password.required' => 'Silakan masukkan Kata Sandi Anda.',
        ]);

        $loginInput = $credentials['login'];
        $password = $credentials['password'];
        $remember = $request->boolean('remember');

        // Tentukan apakah input berupa email atau NIDN/NIP
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'nidn_nip';

        if (Auth::attempt([$fieldType => $loginInput, 'password' => $password], $remember)) {
            $user = Auth::user();

            if (! $user->status_aktif) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'login' => 'Akun Anda sedang dinonaktifkan. Silakan hubungi Administrator P3M.',
                ]);
            }

            $request->session()->regenerate();

            return $this->redirectBasedOnRole($user);
        }

        return back()->withInput($request->only('login', 'remember'))->withErrors([
            'login' => 'Email/NIDN atau kata sandi yang Anda masukkan tidak sesuai.',
        ]);
    }

    /**
     * Memproses keluar sistem (Logout).
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('status', 'Anda telah berhasil keluar dari sistem SIM P3M.');
    }

    /**
     * Pengalihan halaman otomatis berdasarkan peran pengguna (Role-Based Redirect).
     */
    protected function redirectBasedOnRole($user): RedirectResponse
    {
        if ($user->isAdmin()) {
            return redirect()->intended('/admin/dashboard');
        }

        if ($user->isReviewer()) {
            return redirect()->intended('/reviewer/dashboard');
        }

        return redirect()->intended('/dosen/dashboard');
    }
}
