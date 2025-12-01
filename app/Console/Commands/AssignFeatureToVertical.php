<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Shared\Models\BusinessCategory;
use App\Shared\Models\BusinessFeature;
use App\Shared\Services\FeatureResolver;

class AssignFeatureToVertical extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'features:assign-to-vertical 
                            {feature : El key del feature a asignar (ej: favoritos)}
                            {vertical : El vertical al que asignar (ecommerce, restaurant, hotel, dropshipping)}
                            {--force : Asignar incluso si ya lo tiene}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Asigna un feature específico a todas las categorías de un vertical';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $featureKey = $this->argument('feature');
        $vertical = $this->argument('vertical');
        $force = $this->option('force');

        // Validar vertical
        $validVerticals = ['ecommerce', 'restaurant', 'hotel', 'dropshipping'];
        if (!in_array($vertical, $validVerticals)) {
            $this->error("❌ Vertical inválido. Debe ser uno de: " . implode(', ', $validVerticals));
            return 1;
        }

        // Buscar el feature
        $feature = BusinessFeature::where('key', $featureKey)->first();
        if (!$feature) {
            $this->error("❌ Feature '{$featureKey}' no encontrado en la base de datos.");
            $this->info("💡 Ejecuta: php artisan db:seed --class=BusinessFeatureSeeder");
            return 1;
        }

        $this->info("✅ Feature encontrado: {$feature->name} (ID: {$feature->id})");
        $this->newLine();

        // Buscar categorías con el vertical especificado
        $categories = BusinessCategory::where('vertical', $vertical)->get();

        if ($categories->isEmpty()) {
            $this->warn("⚠️  No se encontraron categorías con vertical '{$vertical}'");
            return 0;
        }

        $this->info("📦 Encontradas {$categories->count()} categorías con vertical '{$vertical}'");
        $this->newLine();

        $assigned = 0;
        $alreadyHad = 0;
        $skipped = 0;

        $progressBar = $this->output->createProgressBar($categories->count());
        $progressBar->start();

        foreach ($categories as $category) {
            // Verificar si ya tiene el feature
            $hasFeature = $category->features()->where('business_feature_id', $feature->id)->exists();

            if ($hasFeature && !$force) {
                $alreadyHad++;
                $progressBar->advance();
                continue;
            }

            if ($hasFeature && $force) {
                // Ya lo tiene pero forzamos reasignación (skip, no hace falta hacer nada)
                $alreadyHad++;
                $progressBar->advance();
                continue;
            }

            // Asignar el feature
            try {
                $category->features()->attach($feature->id);
                
                // Invalidar caché
                $resolver = app(FeatureResolver::class);
                $resolver->invalidateCategoryCache($category->id);
                
                $assigned++;
            } catch (\Exception $e) {
                $this->newLine();
                $this->error("  ❌ Error al asignar a categoría '{$category->name}': {$e->getMessage()}");
                $skipped++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        // Resumen
        $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->info("✅ Proceso completado");
        $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->table(
            ['Métrica', 'Cantidad'],
            [
                ['Categorías procesadas', $categories->count()],
                ['Asignaciones nuevas', $assigned],
                ['Ya tenían el feature', $alreadyHad],
                ['Errores/Omitidos', $skipped],
            ]
        );

        if ($assigned > 0) {
            $this->newLine();
            $this->info("🎉 Feature '{$feature->name}' asignado exitosamente a {$assigned} categorías del vertical '{$vertical}'");
        }

        return 0;
    }
}

