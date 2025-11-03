<?php

namespace App\Console\Commands;

use App\Shared\Services\ImageOptimizationService;
use App\Shared\Models\CategoryIcon;
use App\Features\TenantAdmin\Models\ProductImage;
use App\Features\TenantAdmin\Models\Slider;
use App\Jobs\OptimizeImageJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class OptimizeExistingImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:optimize-existing 
                            {--context=all : Tipo de imágenes a optimizar (products, sliders, icons, all)}
                            {--limit=10 : Número máximo de imágenes por lote (default: 10 para evitar timeout)}
                            {--batch=1 : Número de lote a procesar}
                            {--dry-run : Solo mostrar qué se procesaría sin hacer cambios}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimizar imágenes existentes en lotes';

    /**
     * Execute the console command.
     */
    public function handle(ImageOptimizationService $optimizationService)
    {
        $context = $this->option('context');
        $limit = (int) $this->option('limit');
        $batch = (int) $this->option('batch');
        $dryRun = $this->option('dry-run');

        $this->info("🚀 Iniciando optimización de imágenes existentes...");
        $this->info("Contexto: {$context} | Lote: {$batch} | Límite: {$limit}");
        
        if ($dryRun) {
            $this->warn("⚠️  MODO DRY-RUN: No se realizarán cambios");
        }

        $totalProcessed = 0;
        $totalQueued = 0;

        // Optimizar imágenes de productos
        if ($context === 'all' || $context === 'products') {
            $this->info("\n📦 Procesando imágenes de productos...");
            
            $offset = ($batch - 1) * $limit;
            $productImages = ProductImage::whereNotNull('image_path')
                ->offset($offset)
                ->limit($limit)
                ->get();

            foreach ($productImages as $productImage) {
                // Solo procesar si no es WebP
                $extension = pathinfo($productImage->image_path, PATHINFO_EXTENSION);
                if (strtolower($extension) === 'webp') {
                    continue;
                }

                // Verificar que el archivo existe
                if (!Storage::disk('public')->exists($productImage->image_path)) {
                    $this->warn("  ⚠️  Archivo no encontrado: {$productImage->image_path}");
                    continue;
                }

                if ($dryRun) {
                    $this->line("  📄 Se optimizaría: {$productImage->image_path}");
                    $totalProcessed++;
                } else {
                    OptimizeImageJob::dispatch(
                        $productImage->image_path,
                        'product',
                        2000,
                        'ProductImage',
                        $productImage->id
                    )->onQueue('images');
                    
                    $totalQueued++;
                }
            }

            $this->info("  ✅ Productos: {$totalProcessed} encontrados" . ($dryRun ? '' : ", {$totalQueued} encolados"));
        }

        // Optimizar imágenes de sliders
        if ($context === 'all' || $context === 'sliders') {
            $this->info("\n🖼️  Procesando imágenes de sliders...");
            
            $offset = ($batch - 1) * $limit;
            $sliders = Slider::whereNotNull('image_path')
                ->offset($offset)
                ->limit($limit)
                ->get();

            foreach ($sliders as $slider) {
                $extension = pathinfo($slider->image_path, PATHINFO_EXTENSION);
                if (strtolower($extension) === 'webp') {
                    continue;
                }

                if (!Storage::disk('public')->exists($slider->image_path)) {
                    $this->warn("  ⚠️  Archivo no encontrado: {$slider->image_path}");
                    continue;
                }

                if ($dryRun) {
                    $this->line("  📄 Se optimizaría: {$slider->image_path}");
                    $totalProcessed++;
                } else {
                    OptimizeImageJob::dispatch(
                        $slider->image_path,
                        'slider',
                        420,
                        'Slider',
                        $slider->id
                    )->onQueue('images');
                    
                    $totalQueued++;
                }
            }

            $this->info("  ✅ Sliders: {$totalProcessed} encontrados" . ($dryRun ? '' : ", {$totalQueued} encolados"));
        }

        // Optimizar iconos de categoría
        if ($context === 'all' || $context === 'icons') {
            $this->info("\n🎨 Procesando iconos de categoría...");
            
            $processedIcons = 0;
            $queuedIcons = 0;
            
            $offset = ($batch - 1) * $limit;
            $icons = CategoryIcon::whereNotNull('image_path')
                ->offset($offset)
                ->limit($limit)
                ->get();

            foreach ($icons as $icon) {
                $extension = strtolower(pathinfo($icon->image_path, PATHINFO_EXTENSION));
                
                // Saltar SVG y WebP ya optimizados
                if ($extension === 'svg' || $extension === 'webp') {
                    continue;
                }

                if (!Storage::disk('public')->exists($icon->image_path)) {
                    $this->warn("  ⚠️  Archivo no encontrado: {$icon->image_path}");
                    continue;
                }

                if ($dryRun) {
                    $this->line("  📄 Se optimizaría: {$icon->image_path}");
                    $processedIcons++;
                } else {
                    OptimizeImageJob::dispatch(
                        $icon->image_path,
                        'icon',
                        256, // maxWidth
                        256, // maxHeight (para crop desde centro)
                        'CategoryIcon',
                        $icon->id
                    )->onQueue('images');
                    
                    $queuedIcons++;
                }
            }

            $this->info("  ✅ Iconos: {$processedIcons} encontrados" . ($dryRun ? '' : ", {$queuedIcons} encolados"));
            
            if (!$dryRun) {
                $totalQueued += $queuedIcons;
            }
            if ($dryRun) {
                $totalProcessed += $processedIcons;
            }
        }

        $this->info("\n✅ Proceso completado!");
        $this->info("Total procesado: " . ($dryRun ? $totalProcessed : $totalQueued));
        
        if (!$dryRun && $totalQueued > 0) {
            $this->info("\n💡 Ejecuta uno de estos comandos para procesar las imágenes:");
            $this->line("   Opción 1 (recomendado para Laravel Cloud): php artisan images:process-queue --limit=10");
            $this->line("   Opción 2 (si tienes acceso SSH): php artisan queue:work --queue=images --stop-when-empty");
        }

        return Command::SUCCESS;
    }
}

