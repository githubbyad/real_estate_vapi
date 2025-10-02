<?php

namespace App\Providers;

use App\Services\CachedData;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        // Use Bootstrap for pagination styling
        Paginator::useBootstrap();

        View::composer('*', function ($view) {
            $settings = CachedData::getSettings();

            $view->with('settings', $settings);
        });
    }
}
