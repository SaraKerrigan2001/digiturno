<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

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
        RateLimiter::for('kiosk', function (Request $request) {
            // En entorno de testing se deshabilita el throttle para no interferir con los tests
            if (app()->environment('testing')) {
                return Limit::none();
            }
            return Limit::perMinute(2)->by($request->ip())->response(function (Request $request) {
                return back()->with('error', 'Has excedido el límite de turnos permitidos por minuto. Por favor, espera un momento.');
            });
        });
    }
}
