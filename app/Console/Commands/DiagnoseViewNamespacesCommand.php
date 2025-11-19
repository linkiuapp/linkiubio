<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\View;

class DiagnoseViewNamespacesCommand extends Command
{
    protected $signature = 'view:diagnose-namespaces';
    protected $description = 'Diagnosticar namespaces de vistas registrados';

    public function handle()
    {
        $this->info('🔍 DIAGNÓSTICO DE NAMESPACES DE VISTAS');
        $this->line('==========================================');
        
        // Obtener todos los namespaces registrados
        $finder = View::getFinder();
        $hints = $finder->getHints();
        
        $this->info('📋 Namespaces registrados:');
        foreach ($hints as $namespace => $paths) {
            $this->line("   ✅ {$namespace}:");
            foreach ($paths as $path) {
                $exists = is_dir($path) ? '✅' : '❌';
                $this->line("      {$exists} {$path}");
            }
        }
        
        // Verificar vista específica
        $this->info("\n🔍 Verificando vista: tenant-admin::core.auth.login");
        
        // Verificar ruta esperada
        $expectedPath = base_path('app/Features/TenantAdmin/Views/Core/auth/login.blade.php');
        $this->line("   📁 Ruta esperada: {$expectedPath}");
        $this->line("   " . (file_exists($expectedPath) ? '✅' : '❌') . " Archivo existe: " . (file_exists($expectedPath) ? 'Sí' : 'No'));
        
        // Verificar namespace
        if (isset($hints['tenant-admin'])) {
            $namespacePath = $hints['tenant-admin'][0];
            $fullPath = $namespacePath . '/Core/auth/login.blade.php';
            $this->line("   📁 Ruta completa según namespace: {$fullPath}");
            $this->line("   " . (file_exists($fullPath) ? '✅' : '❌') . " Archivo existe: " . (file_exists($fullPath) ? 'Sí' : 'No'));
        }
        
        try {
            $view = view('tenant-admin::core.auth.login');
            $this->info('   ✅ Vista encontrada correctamente');
            $this->line("   📁 Path: {$view->getPath()}");
        } catch (\Exception $e) {
            $this->error('   ❌ Vista NO encontrada');
            $this->line("   Error: {$e->getMessage()}");
            $this->line("\n   💡 Solución: Ejecutar 'php artisan view:clear' y 'php artisan optimize:clear'");
        }
        
        // Verificar Service Providers
        $this->info("\n📦 Service Providers registrados:");
        $providers = config('app.providers', []);
        if (empty($providers)) {
            $providers = require base_path('bootstrap/providers.php');
        }
        
        $tenantAdminProvider = 'App\Features\TenantAdmin\TenantAdminServiceProvider';
        if (in_array($tenantAdminProvider, $providers)) {
            $this->info("   ✅ {$tenantAdminProvider} está registrado");
        } else {
            $this->error("   ❌ {$tenantAdminProvider} NO está registrado");
        }
        
        return 0;
    }
}

