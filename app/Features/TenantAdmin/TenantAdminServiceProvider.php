<?php

namespace App\Features\TenantAdmin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class TenantAdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Registrar vistas con namespace en register() para que esté disponible antes
        $this->loadViewsFrom(__DIR__ . '/Views', 'tenant-admin');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // No cargamos rutas aquí porque se manejan dinámicamente
        // en el RouteServiceProvider principal
        
        // Registrar componentes específicos del admin de tienda
        Blade::componentNamespace('App\\Features\\TenantAdmin\\Views\\Components', 'tenant-admin');
    }
} 