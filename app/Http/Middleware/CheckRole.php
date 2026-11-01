<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if (!in_array($user->role, $roles)) {
            // Jika pengguna mengakses rute peran lain, arahkan ke dasbor perannya sendiri
            if ($user->isAdmin()) {
                return redirect('/admin/dashboard');
            } elseif ($user->isReviewer()) {
                return redirect('/reviewer/dashboard');
            } else {
                return redirect('/dosen/dashboard');
            }
        }

        return $next($request);
    }
}
