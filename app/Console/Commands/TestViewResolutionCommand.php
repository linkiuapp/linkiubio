<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\View;

class TestViewResolutionCommand extends Command
{
    protected $signature = 'view:test-resolution';
    protected $description = 'Probar resolución de vistas con diferentes formatos';

    public function handle()
    {
        $this->info('🧪 PROBANDO RESOLUCIÓN DE VISTAS');
        $this->line('==========================================');
        
        $testViews = [
            'tenant-admin::core.auth.login',
            'tenant-admin::Core/auth/login',
            'tenant-admin::core.dashboard',
            'tenant-admin::core.products.index',
        ];
        
        foreach ($testViews as $viewName) {
            $this->line("\n🔍 Probando: {$viewName}");
            try {
                $view = view($viewName);
                $this->info("   ✅ ENCONTRADA");
                $this->line("   📁 Path: {$view->getPath()}");
            } catch (\Exception $e) {
                $this->error("   ❌ NO ENCONTRADA");
                $this->line("   Error: {$e->getMessage()}");
                
                // Mostrar qué está buscando Laravel
                $finder = View::getFinder();
                $hints = $finder->getHints();
                
                if (str_contains($viewName, '::')) {
                    [$namespace, $viewPath] = explode('::', $viewName, 2);
                    if (isset($hints[$namespace])) {
                        $namespacePath = $hints[$namespace][0];
                        $expectedPath = $namespacePath . '/' . str_replace('.', '/', $viewPath) . '.blade.php';
                        $this->line("   📁 Buscando en: {$expectedPath}");
                        $this->line("   " . (file_exists($expectedPath) ? '✅' : '❌') . " Existe: " . (file_exists($expectedPath) ? 'Sí' : 'No'));
                    }
                }
            }
        }
        
        return 0;
    }
}

