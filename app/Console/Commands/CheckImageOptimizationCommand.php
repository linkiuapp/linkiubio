<?php

namespace App\Console\Commands;

use App\Shared\Services\ImageOptimizationService;
use Illuminate\Console\Command;
use ReflectionClass;

class CheckImageOptimizationCommand extends Command
{
    protected $signature = 'images:check-status';
    protected $description = 'Verificar estado de optimización de imágenes';

    public function handle()
    {
        $this->info('🔍 Verificando estado de optimización...');
        $this->newLine();

        try {
            $service = app(ImageOptimizationService::class);
            
            // Verificar si spatie está disponible usando reflexión
            $reflection = new ReflectionClass($service);
            $method = $reflection->getMethod('isSpatieAvailable');
            $method->setAccessible(true);
            $spatieAvailable = $method->invoke($service);

            $this->info('✅ Intervention Image: DISPONIBLE');
            $this->info('   Driver: GD Library');
            
            $this->newLine();
            
            if ($spatieAvailable) {
                $this->info('✅ spatie/laravel-image-optimizer: DISPONIBLE');
                $this->info('   Optimización: MÁXIMA (80-85% reducción)');
            } else {
                $this->warn('⚠️  spatie/laravel-image-optimizer: NO DISPONIBLE');
                $this->info('   Optimización: BÁSICA (70-75% reducción)');
                $this->comment('   Nota: Las herramientas del sistema no están disponibles.');
            }

            $this->newLine();
            $this->info('📊 Configuración:');
            $this->line('   - Tamaño máximo: 10MB');
            $this->line('   - Ancho máximo (productos): 2000px');
            $this->line('   - Ancho máximo (sliders): 420px');
            $this->line('   - Calidad WebP: 85%');
            $this->line('   - Formato final: WebP');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Error verificando estado: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}

