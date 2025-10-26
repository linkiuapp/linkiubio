<?php

namespace App\Features\TenantAdmin\Controllers;

use App\Http\Controllers\Controller;
use App\Features\TenantAdmin\Models\Category;
use App\Shared\Models\CategoryIcon;
use App\Shared\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories
     */
    public function index(Request $request)
    {
        $store = $request->route('store');
        
        // Obtener límite según el plan
        $categoryLimit = $this->getCategoryLimit($store);
        
        // Obtener categorías con relaciones
        $categories = Category::where('store_id', $store->id)
            ->with(['icon', 'parent', 'children'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);
            
        // Contar total de categorías
        $totalCategories = Category::where('store_id', $store->id)->count();

        // Vista (tabla o cards)
        $viewType = $request->get('view', 'table');
        
        return view('tenant-admin::categories.index', compact(
            'store',
            'categories',
            'totalCategories',
            'categoryLimit',
            'viewType'
        ));

        
    }

    /**
     * Display the specified category
     */
    public function show(Request $request, $storeSlug, Category $category)
    {
        $store = $request->route('store');
        
        // Verificar que la categoría pertenezca a la tienda
        if ($category->store_id !== $store->id) {
            abort(404);
        }
        
        // Cargar relaciones necesarias
        $category->load(['icon', 'parent', 'children.icon']);
        
        return view('tenant-admin::categories.show', compact('store', 'category'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create(Request $request)
    {
        $store = $request->route('store');
        
        // Verificar límite
        $categoryLimit = $this->getCategoryLimit($store);
        $totalCategories = Category::where('store_id', $store->id)->count();
        
        if ($totalCategories >= $categoryLimit) {
            return redirect()
                ->route('tenant.admin.categories.index', $store->slug)
                ->with('error', "Has alcanzado el límite de categorías ({$categoryLimit}) para tu plan {$store->plan->name}. Actualiza tu plan para crear más categorías.");
        }
        
        // Obtener iconos filtrados por categoría de negocio de la tienda
        $businessCategoryId = $store->business_category_id;
        
        $icons = CategoryIcon::active()
            ->where(function($query) use ($businessCategoryId) {
                // Iconos globales (aparecen para todos)
                $query->where('is_global', true)
                    // O iconos específicos de esta categoría de negocio
                    ->orWhereHas('businessCategories', function($q) use ($businessCategoryId) {
                        $q->where('business_categories.id', $businessCategoryId);
                    });
            })
            ->orderBy('display_name')
            ->get();
        
        // Obtener categorías principales para seleccionar como padre
        $parentCategories = Category::where('store_id', $store->id)
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();
        
        return view('tenant-admin::categories.create', compact(
            'store',
            'icons',
            'parentCategories',
            'totalCategories',
            'categoryLimit'
        ));
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $store = $request->route('store');
        
        // Verificar límite nuevamente
        $categoryLimit = $this->getCategoryLimit($store);
        $totalCategories = Category::where('store_id', $store->id)->count();
        
        if ($totalCategories >= $categoryLimit) {
            return response()->json([
                'error' => "Has alcanzado el límite de categorías para tu plan."
            ], 403);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories')->where(function ($query) use ($store) {
                    return $query->where('store_id', $store->id);
                })
            ],
            'description' => 'nullable|string|max:1000',
            'icon_id' => 'required|exists:category_icons,id',
            'parent_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ], [
            'name.required' => 'El nombre de la categoría es obligatorio',
            'name.max' => 'El nombre no puede exceder 255 caracteres',
            'slug.max' => 'El slug no puede exceder 255 caracteres',
            'slug.unique' => 'Ya existe una categoría con este slug en tu tienda',
            'description.max' => 'La descripción no puede exceder 1000 caracteres',
            'icon_id.required' => 'El ícono es obligatorio',
            'icon_id.exists' => 'El ícono seleccionado no existe',
            'parent_id.exists' => 'La categoría padre seleccionada no existe',
            'sort_order.integer' => 'El orden debe ser un número entero',
            'sort_order.min' => 'El orden no puede ser negativo',
        ]);
        
        // Generar slug si no se proporciona
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            
            // Asegurar que el slug sea único
            $baseSlug = $validated['slug'];
            $counter = 1;
            while (Category::where('store_id', $store->id)->where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $baseSlug . '-' . $counter;
                $counter++;
            }
        }
        
        // Verificar que el parent_id pertenezca a la misma tienda
        if (!empty($validated['parent_id'])) {
            $parentExists = Category::where('id', $validated['parent_id'])
                ->where('store_id', $store->id)
                ->exists();
                
            if (!$parentExists) {
                return response()->json(['error' => 'Categoría padre inválida'], 422);
            }
        }
        
        $validated['store_id'] = $store->id;
        $validated['is_active'] = $request->boolean('is_active', true);
        
        $category = Category::create($validated);
        
        // Marcar paso de onboarding como completado
        \App\Shared\Models\StoreOnboardingStep::markAsCompleted($store->id, 'categories');
        
        return redirect()
            ->route('tenant.admin.categories.index', $store->slug)
            ->with('swal_success', 'Categoría creada exitosamente');
    }

    /**
     * Show the form for editing a category
     */
    public function edit(Request $request, $storeSlug, Category $category)
    {
        $store = $request->route('store');
        
        // Verificar que la categoría pertenece a la tienda
        if ($category->store_id !== $store->id) {
            abort(404);
        }
        
        // Obtener iconos filtrados por categoría de negocio de la tienda
        $businessCategoryId = $store->business_category_id;
        
        $icons = CategoryIcon::active()
            ->where(function($query) use ($businessCategoryId) {
                // Iconos globales (aparecen para todos)
                $query->where('is_global', true)
                    // O iconos específicos de esta categoría de negocio
                    ->orWhereHas('businessCategories', function($q) use ($businessCategoryId) {
                        $q->where('business_categories.id', $businessCategoryId);
                    });
            })
            ->orderBy('display_name')
            ->get();
        
        // Obtener categorías principales (excluyendo la actual y sus hijos)
        $excludeIds = [$category->id];
        $excludeIds = array_merge($excludeIds, $category->children->pluck('id')->toArray());
        
        $parentCategories = Category::where('store_id', $store->id)
            ->whereNull('parent_id')
            ->whereNotIn('id', $excludeIds)
            ->orderBy('name')
            ->get();
            
        // Obtener límites
        $categoryLimit = $this->getCategoryLimit($store);
        $totalCategories = Category::where('store_id', $store->id)->count();
        
        return view('tenant-admin::categories.edit', compact(
            'store',
            'category',
            'icons',
            'parentCategories',
            'totalCategories',
            'categoryLimit'
        ));
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, $storeSlug, Category $category)
    {
        $store = $request->route('store');
        
        // Verificar que la categoría pertenece a la tienda
        if ($category->store_id !== $store->id) {
            abort(404);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories')->where(function ($query) use ($store) {
                    return $query->where('store_id', $store->id);
                })->ignore($category->id)
            ],
            'description' => 'nullable|string|max:1000',
            'icon_id' => 'required|exists:category_icons,id',
            'parent_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ], [
            'name.required' => 'El nombre de la categoría es obligatorio',
            'name.max' => 'El nombre no puede exceder 255 caracteres',
            'slug.max' => 'El slug no puede exceder 255 caracteres',
            'slug.unique' => 'Ya existe una categoría con este slug en tu tienda',
            'description.max' => 'La descripción no puede exceder 1000 caracteres',
            'icon_id.required' => 'El ícono es obligatorio',
            'icon_id.exists' => 'El ícono seleccionado no existe',
            'parent_id.exists' => 'La categoría padre seleccionada no existe',
            'sort_order.integer' => 'El orden debe ser un número entero',
            'sort_order.min' => 'El orden no puede ser negativo',
        ]);
        
        // Verificar que no se asigne como padre a sí misma o a sus hijos
        if (!empty($validated['parent_id'])) {
            $invalidParentIds = [$category->id];
            $invalidParentIds = array_merge($invalidParentIds, $category->children->pluck('id')->toArray());
            
            if (in_array($validated['parent_id'], $invalidParentIds)) {
                return back()->withErrors(['parent_id' => 'No se puede asignar esta categoría como padre']);
            }
        }
        
        $validated['is_active'] = $request->boolean('is_active', true);
        
        $category->update($validated);
        
        return redirect()
            ->route('tenant.admin.categories.index', $store->slug)
            ->with('swal_success', 'Categoría actualizada exitosamente');
    }

    /**
     * Remove the specified category
     */
    public function destroy(Request $request, $storeSlug, Category $category)
    {
        $store = $request->route('store');
        
        // Verificar que la categoría pertenece a la tienda
        if ($category->store_id !== $store->id) {
            abort(404);
        }
        
        // Verificar si tiene productos asociados
        if ($category->products_count > 0) {
            return response()->json([
                'error' => 'No se puede eliminar una categoría con productos asociados'
            ], 422);
        }
        
        $category->delete();
        
        return response()->json([
            'success' => 'Categoría eliminada exitosamente'
        ]);
    }

    /**
     * Toggle category status
     */
    public function toggleStatus(Request $request, $storeSlug, Category $category)
    {
        $store = $request->route('store');
        
        // Verificar que la categoría pertenece a la tienda
        if ($category->store_id !== $store->id) {
            abort(404);
        }
        
        $category->update(['is_active' => !$category->is_active]);
        
        return response()->json([
            'success' => true,
            'is_active' => $category->is_active
        ]);
    }

    /**
     * Update categories order
     */
    public function updateOrder(Request $request)
    {
        $store = $request->route('store');
        
        $validated = $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:categories,id',
            'categories.*.sort_order' => 'required|integer|min:0'
        ]);
        
        foreach ($validated['categories'] as $item) {
            Category::where('id', $item['id'])
                ->where('store_id', $store->id)
                ->update(['sort_order' => $item['sort_order']]);
        }
        
        return response()->json(['success' => true]);
    }

    /**
     * Get category limit based on plan
     */
    private function getCategoryLimit(Store $store): int
    {
        // Usar el límite real del plan desde la base de datos
        return $store->plan->max_categories ?? 3;
    }
} 