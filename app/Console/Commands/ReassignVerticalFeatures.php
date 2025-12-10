<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Shared\Models\BusinessCategory;
use App\Shared\Models\BusinessFeature;
use App\Shared\Services\FeatureResolver;

class ReassignVerticalFeatures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verticals:reassign-features 
                            {--force : Forzar reasignación incluso si ya tienen features}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reasigna features a todas las categorías según su vertical configurado en config/verticals.php';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Reasignando features a categorías según verticales...');
        $this->newLine();

        // Verificar que existan features
        $featuresCount = BusinessFeature::count();
        if ($featuresCount === 0) {
            $this->error('❌ No hay features en la base de datos.');
            $this->info('💡 Ejecuta primero: php artisan db:seed --class=BusinessFeatureSeeder');
            return 1;
        }

        $this->info("✅ Encontrados {$featuresCount} features en la base de datos");
        $this->newLine();

        // Obtener todas las categorías con vertical
        $categories = BusinessCategory::whereNotNull('vertical')
            ->where('vertical', '!=', '')
            ->get();

        if ($categories->isEmpty()) {
            $this->warn('⚠️  No se encontraron categorías con vertical asignado');
            return 0;
        }

        $this->info("📦 Encontradas {$categories->count()} categorías con vertical");
        $this->newLine();

        $assigned = 0;
        $skipped = 0;
        $errors = 0;

        $verticals = config('verticals', []);

        foreach ($categories as $category) {
            $vertical = $category->vertical;

            if (!isset($verticals[$vertical])) {
                $this->warn("  ⚠️  Categoría '{$category->name}': Vertical '{$vertical}' no existe en config/verticals.php");
                $errors++;
                continue;
            }

            // Obtener features del vertical desde config
            $verticalFeatures = $verticals[$vertical]['features'] ?? [];

            if (empty($verticalFeatures)) {
                $this->warn("  ⚠️  Categoría '{$category->name}': No hay features definidos para vertical '{$vertical}'");
                $errors++;
                continue;
            }

            // Obtener IDs de features
            $featureIds = BusinessFeature::whereIn('key', $verticalFeatures)->pluck('id');

            if ($featureIds->isEmpty()) {
                $this->warn("  ⚠️  Categoría '{$category->name}': No se encontraron features con keys: " . implode(', ', $verticalFeatures));
                $errors++;
                continue;
            }

            // Verificar si ya tiene los features correctos
            $currentFeatureIds = $category->features()->pluck('business_features.id')->sort()->values();
            $newFeatureIds = $featureIds->sort()->values();

            if (!$this->option('force') && $currentFeatureIds->toArray() === $newFeatureIds->toArray()) {
                $this->info("  ✓ {$category->name} ({$vertical}): Ya tiene los features correctos");
                $skipped++;
                continue;
            }

            // Asignar features
            try {
                $category->features()->sync($featureIds->toArray());

                // Invalidar caché
                $resolver = app(FeatureResolver::class);
                $resolver->invalidateCategoryCache($category->id);

                $this->info("  ✅ {$category->name} ({$vertical}): {$featureIds->count()} features asignados");
                $assigned++;
            } catch (\Exception $e) {
                $this->error("  ❌ Error en '{$category->name}': {$e->getMessage()}");
                $errors++;
            }
        }

        $this->newLine();
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('✅ Proceso completado');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->table(
            ['Métrica', 'Cantidad'],
            [
                ['Categorías procesadas', $categories->count()],
                ['Features reasignados', $assigned],
                ['Ya tenían features correctos', $skipped],
                ['Errores', $errors],
            ]
        );

        if ($assigned > 0) {
            $this->newLine();
            $this->info("🎉 Features reasignados exitosamente a {$assigned} categorías");
        }

        return 0;
    }
}

