<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // Añadir esta línea

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
    public function boot()
    {
        // Configurar el paginador para usar Bootstrap
        Paginator::useBootstrap();

        // Mantener la configuración existente
        view()->composer('includes._register_button', function ($view) {
            $user = Auth::user();
            $view->with('user', $user);
        });
    }
}
