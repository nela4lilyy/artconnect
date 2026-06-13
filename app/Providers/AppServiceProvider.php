<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- Tambahan: Untuk mengaktifkan fitur pengatur URL

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
        // Tambahan: Paksa Laravel menggunakan HTTPS jika aplikasi berjalan di Railway (production)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}