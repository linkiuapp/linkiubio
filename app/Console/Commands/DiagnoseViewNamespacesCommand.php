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
        try {
            $view = view('tenant-admin::core.auth.login');
            $this->info('   ✅ Vista encontrada correctamente');
            $this->line("   📁 Path: {$view->getPath()}");
        } catch (\Exception $e) {
            $this->error('   ❌ Vista NO encontrada');
            $this->line("   Error: {$e->getMessage()}");
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

