<?php

namespace App\Features\Public;

use Illuminate\Support\ServiceProvider;

class PublicServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Cargar vistas de Public
        $this->loadViewsFrom(__DIR__ . '/Views', 'public');
    }
}

