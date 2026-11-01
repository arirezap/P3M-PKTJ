<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Auth\Middleware\RedirectIfAuthenticated::redirectUsing(function ($request) {
            $user = auth()->user();
            if (!$user) {
                return '/';
            }
            if ($user->isAdmin()) {
                return route('admin.dashboard');
            }
            if ($user->isReviewer()) {
                return route('reviewer.dashboard');
            }
            return route('dosen.dashboard');
        });
    }
}
