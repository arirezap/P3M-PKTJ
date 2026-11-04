<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
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
        View::composer(['components.public-navbar', 'components.public-footer', 'layouts.public'], function ($view) {
            $view->with('navSettings', Setting::getNavigationSettings());
        });

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
