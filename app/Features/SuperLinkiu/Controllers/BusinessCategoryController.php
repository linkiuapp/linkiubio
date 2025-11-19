<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\BusinessCategory;
use App\Shared\Models\BusinessFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BusinessCategoryController extends Controller
{
    /**
     * Display a listing of business categories
     */
    public function index()
    {
        $categories = BusinessCategory::ordered()
            ->with('features')
            ->withCount('stores')
            ->paginate(20);

        // Transformar features para el modal
        foreach ($categories as $category) {
            $category->feature_ids = $category->features->pluck('id')->toArray();
        }

        $stats = [
            'total' => BusinessCategory::count(),
            'active' => BusinessCategory::active()->count(),
            'auto_approve' => BusinessCategory::autoApprove()->count(),
            'manual_review' => BusinessCategory::manualReview()->count()
        ];

        // Cargar todos los features disponibles
        $features = \App\Shared\Models\BusinessFeature::ordered()->get();

        return view('superlinkiu::business-categories.index', compact('categories', 'stats', 'features'));
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:business_categories,name',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:500',
            'vertical' => 'required|in:ecommerce,restaurant,hotel,dropshipping',
            'requires_manual_approval' => 'required|boolean',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
            'features' => 'nullable|array',
            'features.*' => 'exists:business_features,id'
        ]);

        $validated['created_by'] = auth()->id();
        $validated['slug'] = Str::slug($validated['name']);
        
        if (!isset($validated['order'])) {
            $validated['order'] = BusinessCategory::max('order') + 1;
        }

        $category = BusinessCategory::create($validated);

        // Asignar features automáticamente según vertical
        if (isset($validated['vertical'])) {
            $verticalFeatures = config("verticals.{$validated['vertical']}.features", []);
            $featureIds = BusinessFeature::whereIn('key', $verticalFeatures)->pluck('id');
            $category->features()->sync($featureIds);
        } elseif (isset($validated['features'])) {
            // Fallback: Si no hay vertical, usar features manuales (compatibilidad temporal)
            $category->features()->sync($validated['features']);
        }

        // Invalidar caché de features para esta categoría
        $resolver = app(\App\Shared\Services\FeatureResolver::class);
        $resolver->invalidateCategoryCache($category->id);

        return redirect()
            ->route('superlinkiu.business-categories.index')
            ->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, BusinessCategory $businessCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:business_categories,name,' . $businessCategory->id,
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:500',
            'vertical' => 'required|in:ecommerce,restaurant,hotel,dropshipping',
            'requires_manual_approval' => 'required|boolean',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
            'features' => 'nullable|array',
            'features.*' => 'exists:business_features,id'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $verticalChanged = $businessCategory->vertical !== $validated['vertical'];
        
        $businessCategory->update($validated);

        // Si cambió el vertical o se especificó vertical, asignar features automáticamente
        if (isset($validated['vertical'])) {
            $verticalFeatures = config("verticals.{$validated['vertical']}.features", []);
            $featureIds = BusinessFeature::whereIn('key', $verticalFeatures)->pluck('id');
            $businessCategory->features()->sync($featureIds);
        } elseif (isset($validated['features'])) {
            // Fallback: Si no hay vertical, usar features manuales (compatibilidad temporal)
            $businessCategory->features()->sync($validated['features']);
        }
        
        // Invalidar caché de todas las tiendas de esta categoría
        $resolver = app(\App\Shared\Services\FeatureResolver::class);
        $resolver->invalidateCategoryCache($businessCategory->id);

        return redirect()
            ->route('superlinkiu.business-categories.index')
            ->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Remove the specified category
     */
    public function destroy(BusinessCategory $businessCategory)
    {
        // Verificar que no tenga tiendas asociadas
        if ($businessCategory->stores()->count() > 0) {
            return back()->with('error', 'No se puede eliminar una categoría con tiendas asociadas.');
        }

        $businessCategory->delete();

        return redirect()
            ->route('superlinkiu.business-categories.index')
            ->with('success', 'Categoría eliminada exitosamente.');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(BusinessCategory $businessCategory)
    {
        $businessCategory->update([
            'is_active' => !$businessCategory->is_active
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $businessCategory->is_active,
            'message' => $businessCategory->is_active ? 'Categoría activada' : 'Categoría desactivada'
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Update order of categories
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:business_categories,id',
            'categories.*.order' => 'required|integer|min:0'
        ]);

        foreach ($validated['categories'] as $categoryData) {
            BusinessCategory::where('id', $categoryData['id'])
                ->update(['order' => $categoryData['order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Orden actualizado exitosamente'
        ]);
    }

    /**
     * Mostrar panel de migración de verticales
     */
    public function migrateVerticals()
    {
        // Obtener categorías sin vertical
        $categoriesWithoutVertical = BusinessCategory::withoutVertical()
            ->with('features')
            ->get();

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

        return view('superlinkiu::business-categories.migrate-verticals', compact('suggestions', 'verticals'));
    }

    /**
     * Aplicar verticales masivamente
     */
    public function applyVerticals(Request $request)
    {
        $validated = $request->validate([
            'assignments' => 'required|array',
            'assignments.*.category_id' => 'required|exists:business_categories,id',
            'assignments.*.vertical' => 'required|in:ecommerce,restaurant,hotel,dropshipping'
        ]);

        $applied = 0;
        $errors = [];

        foreach ($validated['assignments'] as $assignment) {
            try {
                $category = BusinessCategory::findOrFail($assignment['category_id']);
                $vertical = $assignment['vertical'];

                // Actualizar vertical
                $category->update(['vertical' => $vertical]);

                // Asignar features automáticamente
                $verticalFeatures = config("verticals.{$vertical}.features", []);
                $featureIds = BusinessFeature::whereIn('key', $verticalFeatures)->pluck('id');
                $category->features()->sync($featureIds);

                // Invalidar caché
                $resolver = app(\App\Shared\Services\FeatureResolver::class);
                $resolver->invalidateCategoryCache($category->id);

                $applied++;
            } catch (\Exception $e) {
                $errors[] = "Error al asignar vertical a categoría ID {$assignment['category_id']}: {$e->getMessage()}";
            }
        }

        if (!empty($errors)) {
            return back()->withErrors(['errors' => $errors])->with('success', "Aplicadas: {$applied} categorías");
        }

        return redirect()
            ->route('superlinkiu.business-categories.index')
            ->with('success', "Se asignaron verticales a {$applied} categorías exitosamente.");
    }
}

