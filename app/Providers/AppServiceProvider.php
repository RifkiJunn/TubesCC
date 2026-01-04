<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

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
        // Force HTTPS in production
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Fix SSL certificate issue for Socialite in development
        if (config('app.env') === 'local' || config('app.debug')) {
            // Set default HTTP client options to disable SSL verification for development
            Http::macro('withoutSslVerification', function () {
                return Http::withOptions([
                    'verify' => false,
                ]);
            });
        }
    }
}
