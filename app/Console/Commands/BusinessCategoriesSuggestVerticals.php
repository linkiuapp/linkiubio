<?php

namespace App\Console\Commands;

use App\Shared\Models\BusinessCategory;
use App\Shared\Models\BusinessFeature;
use Illuminate\Console\Command;

class BusinessCategoriesSuggestVerticals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'business-categories:suggest-verticals 
                            {--apply : Aplicar sugerencias automáticamente (solo para categorías con score >= 90%)}
                            {--force : Forzar aplicación incluso para scores bajos}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analiza categorías de negocio sin vertical y sugiere el vertical más apropiado según sus features actuales';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Analizando categorías de negocio sin vertical asignado...');
        $this->newLine();

        // Obtener categorías sin vertical
        $categoriesWithoutVertical = BusinessCategory::withoutVertical()->get();

        if ($categoriesWithoutVertical->isEmpty()) {
            $this->info('✅ Todas las categorías ya tienen vertical asignado.');
            return Command::SUCCESS;
        }

        $this->info("📊 Encontradas {$categoriesWithoutVertical->count()} categorías sin vertical.");
        $this->newLine();

        $suggestions = [];
        $verticals = config('verticals', []);

        // Analizar cada categoría
        foreach ($categoriesWithoutVertical as $category) {
            $categoryFeatures = $category->features->pluck('key')->toArray();
            
            if (empty($categoryFeatures)) {
                $suggestions[] = [
                    'category' => $category,
                    'suggestions' => [],
                    'status' => 'no_features',
                    'message' => 'No tiene features asignados'
                ];
                continue;
            }

            // Calcular score para cada vertical
            $scores = [];
            foreach ($verticals as $verticalKey => $verticalConfig) {
                $verticalFeatures = $verticalConfig['features'] ?? [];
                $matchingFeatures = array_intersect($categoryFeatures, $verticalFeatures);
                $score = count($matchingFeatures);
                
                if ($score > 0) {
                    $totalVerticalFeatures = count($verticalFeatures);
                    $percentage = ($score / $totalVerticalFeatures) * 100;
                    
                    $scores[$verticalKey] = [
                        'score' => $score,
                        'percentage' => round($percentage, 2),
                        'matching_features' => $matchingFeatures,
                        'missing_features' => array_diff($verticalFeatures, $categoryFeatures)
                    ];
                }
            }

            // Ordenar por score (mayor primero)
            arsort($scores);
            
            // Determinar estado
            $topScore = !empty($scores) ? reset($scores) : null;
            $status = 'ambiguous';
            $message = '';

            if (empty($scores)) {
                $status = 'no_match';
                $message = 'No hay coincidencias con ningún vertical';
            } elseif ($topScore['percentage'] >= 90) {
                $status = 'clear';
                $message = "Sugerencia clara: {$topScore['percentage']}% de coincidencia";
            } elseif ($topScore['percentage'] >= 60) {
                $status = 'likely';
                $message = "Sugerencia probable: {$topScore['percentage']}% de coincidencia";
            } else {
                $status = 'ambiguous';
                $message = "Coincidencia baja: {$topScore['percentage']}% - Requiere revisión manual";
            }

            $suggestions[] = [
                'category' => $category,
                'suggestions' => $scores,
                'status' => $status,
                'message' => $message
            ];
        }

        // Mostrar resultados
        $this->displayResults($suggestions);

        // Aplicar sugerencias si se solicita
        if ($this->option('apply') || $this->option('force')) {
            $this->applySuggestions($suggestions);
        }

        return Command::SUCCESS;
    }

    /**
     * Mostrar resultados del análisis
     */
    private function displayResults(array $suggestions): void
    {
        $headers = ['ID', 'Categoría', 'Estado', 'Sugerencia', 'Score', 'Features Coincidentes'];
        $rows = [];

        foreach ($suggestions as $suggestion) {
            $category = $suggestion['category'];
            $status = $suggestion['status'];
            $scores = $suggestion['suggestions'];

            if (empty($scores)) {
                $rows[] = [
                    $category->id,
                    $category->name,
                    $this->getStatusBadge($status),
                    'N/A',
                    '0%',
                    '0'
                ];
                continue;
            }

            $topSuggestion = reset($scores);
            $verticalKey = array_key_first($scores);
            $verticalName = $this->getVerticalName($verticalKey);

            $rows[] = [
                $category->id,
                $category->name,
                $this->getStatusBadge($status),
                $verticalName,
                "{$topSuggestion['percentage']}%",
                count($topSuggestion['matching_features'])
            ];
        }

        $this->table($headers, $rows);
        $this->newLine();

        // Resumen
        $clear = count(array_filter($suggestions, fn($s) => $s['status'] === 'clear'));
        $likely = count(array_filter($suggestions, fn($s) => $s['status'] === 'likely'));
        $ambiguous = count(array_filter($suggestions, fn($s) => $s['status'] === 'ambiguous'));
        $noMatch = count(array_filter($suggestions, fn($s) => $s['status'] === 'no_match' || $s['status'] === 'no_features'));

        $this->info("📈 Resumen:");
        $this->line("  ✅ Sugerencias claras (≥90%): {$clear}");
        $this->line("  ⚠️  Sugerencias probables (≥60%): {$likely}");
        $this->line("  ❓ Requieren revisión manual (<60%): {$ambiguous}");
        $this->line("  ❌ Sin coincidencias: {$noMatch}");
        $this->newLine();

        // Mostrar detalles de categorías ambiguas
        $ambiguousCategories = array_filter($suggestions, fn($s) => $s['status'] === 'ambiguous' || $s['status'] === 'no_match');
        if (!empty($ambiguousCategories)) {
            $this->warn("⚠️  Categorías que requieren revisión manual:");
            foreach ($ambiguousCategories as $suggestion) {
                $category = $suggestion['category'];
                $this->line("  - {$category->name} (ID: {$category->id}): {$suggestion['message']}");
            }
            $this->newLine();
        }
    }

    /**
     * Aplicar sugerencias automáticamente
     */
    private function applySuggestions(array $suggestions): void
    {
        $this->info('🔄 Aplicando sugerencias...');
        $this->newLine();

        $applied = 0;
        $skipped = 0;

        foreach ($suggestions as $suggestion) {
            $category = $suggestion['category'];
            $scores = $suggestion['suggestions'];

            if (empty($scores)) {
                $this->warn("  ⏭️  Saltando {$category->name}: No hay sugerencias");
                $skipped++;
                continue;
            }

            $topSuggestion = reset($scores);
            $verticalKey = array_key_first($scores);

            // Solo aplicar si score >= 90% o si se usa --force
            if (!$this->option('force') && $topSuggestion['percentage'] < 90) {
                $this->warn("  ⏭️  Saltando {$category->name}: Score bajo ({$topSuggestion['percentage']}%) - Usa --force para aplicar");
                $skipped++;
                continue;
            }

            // Aplicar vertical
            $category->update(['vertical' => $verticalKey]);
            
            // Asignar features automáticamente
            $verticalFeatures = config("verticals.{$verticalKey}.features", []);
            $featureIds = BusinessFeature::whereIn('key', $verticalFeatures)->pluck('id');
            $category->features()->sync($featureIds);

            // Invalidar caché
            $resolver = app(\App\Shared\Services\FeatureResolver::class);
            $resolver->invalidateCategoryCache($category->id);

            $this->info("  ✅ {$category->name} → {$this->getVerticalName($verticalKey)} ({$topSuggestion['percentage']}%)");
            $applied++;
        }

        $this->newLine();
        $this->info("✅ Aplicadas: {$applied} | ⏭️  Saltadas: {$skipped}");
    }

    /**
     * Obtener badge de estado
     */
    private function getStatusBadge(string $status): string
    {
        return match($status) {
            'clear' => '<fg=green>✅ Claro</>',
            'likely' => '<fg=yellow>⚠️  Probable</>',
            'ambiguous' => '<fg=red>❓ Ambiguo</>',
            'no_match' => '<fg=red>❌ Sin match</>',
            'no_features' => '<fg=red>❌ Sin features</>',
            default => $status
        };
    }

    /**
     * Obtener nombre legible del vertical
     */
    private function getVerticalName(string $vertical): string
    {
        return match($vertical) {
            'ecommerce' => 'Ecommerce',
            'restaurant' => 'Restaurante',
            'hotel' => 'Hotel',
            'dropshipping' => 'Dropshipping',
            default => $vertical
        };
    }
}
