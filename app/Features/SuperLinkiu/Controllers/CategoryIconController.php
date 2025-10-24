<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\CategoryIcon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class CategoryIconController extends Controller
{
    /**
     * Display a listing of category icons
     */
    public function index()
    {
        // Obtener todos los iconos (sin paginación para el filtrado por JavaScript)
        $icons = CategoryIcon::with('businessCategories')
            ->orderBy('display_name')
            ->get();

        // Estadísticas
        $totalIcons = $icons->count();
        $activeIcons = $icons->where('is_active', true)->count();
        $globalIcons = $icons->where('is_global', true)->count();

        // Categorías de negocio con conteo de iconos
        $businessCategories = \App\Shared\Models\BusinessCategory::active()
            ->ordered()
            ->withCount('icons')
            ->get();

        $categoriesWithIcons = $businessCategories->where('icons_count', '>', 0)->count();

        return view('superlinkiu::category-icons.index', compact(
            'icons',
            'totalIcons', 
            'activeIcons',
            'globalIcons',
            'businessCategories',
            'categoriesWithIcons'
        ));
    }

    /**
     * Show the form for creating a new category icon
     */
    public function create()
    {
        $businessCategories = \App\Shared\Models\BusinessCategory::active()
            ->ordered()
            ->get();

        return view('superlinkiu::category-icons.create', compact('businessCategories'));
    }

    /**
     * Store a newly created category icon
     */
    public function store(Request $request)
    {
        $request->validate([
            'display_name' => ['required', 'string', 'max:255'],
            'name' => ['nullable', 'string', 'max:255', 'unique:category_icons,name'],
            'icon_file' => ['required', 'file', 'mimes:svg,png,jpg,jpeg,webp', 'max:2048'],
            'is_active' => ['boolean'],
            'is_global' => ['boolean'],
            'business_categories' => ['nullable', 'array'],
            'business_categories.*' => ['exists:business_categories,id'],
        ]);

        // Validar que tenga al menos una categoría O sea global
        if (!$request->boolean('is_global') && empty($request->business_categories)) {
            return back()
                ->withErrors(['business_categories' => 'Debes seleccionar al menos una categoría de negocio o marcar el icono como global.'])
                ->withInput();
        }

        try {
            // Auto-generar name si no se proporciona
            $name = $request->name ?: Str::slug($request->display_name);
            
            // Verificar unicidad del name generado
            $originalName = $name;
            $counter = 1;
            while (CategoryIcon::where('name', $name)->exists()) {
                $name = $originalName . '-' . $counter;
                $counter++;
            }

            // Inicializar variable de imagen
            $imagePath = null;

            // Manejar subida del archivo
            if ($request->hasFile('icon_file')) {
                $file = $request->file('icon_file');
                $filename = $name . '.' . $file->getClientOriginalExtension();
                
                // ✅ Guardar usando Storage::disk('public')->putFileAs()
                // Compatible con S3 (Laravel Cloud) y filesystem local
                $imagePath = Storage::disk('public')->putFileAs('category-icons', $file, $filename);
            } else {
                throw new \Exception('No se recibió el archivo de imagen');
            }

            // Crear el icono
            $categoryIcon = CategoryIcon::create([
                'name' => $name,
                'display_name' => $request->display_name,
                'image_path' => $imagePath,
                'is_active' => $request->boolean('is_active', true),
                'is_global' => $request->boolean('is_global', false),
                'sort_order' => 0, // Se puede ordenar después con drag & drop
            ]);

            if (!$categoryIcon) {
                throw new \Exception('Error al guardar el icono en la base de datos');
            }

            // Asociar con categorías de negocio (si no es global)
            if (!$request->boolean('is_global') && !empty($request->business_categories)) {
                $syncData = [];
                foreach ($request->business_categories as $index => $categoryId) {
                    $syncData[$categoryId] = ['sort_order' => $index];
                }
                $categoryIcon->businessCategories()->sync($syncData);
            }

            return redirect()
                ->route('superlinkiu.category-icons.index')
                ->with('success', 'Icono de categoría creado exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error creating category icon: ' . $e->getMessage());
            return back()
                ->withErrors(['general' => 'Error al crear el icono: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified category icon
     */
    public function edit(CategoryIcon $categoryIcon)
    {
        $businessCategories = \App\Shared\Models\BusinessCategory::active()
            ->ordered()
            ->get();

        // IDs de categorías ya asociadas
        $selectedCategories = $categoryIcon->businessCategories()->pluck('business_categories.id')->toArray();

        return view('superlinkiu::category-icons.edit', compact('categoryIcon', 'businessCategories', 'selectedCategories'));
    }

    /**
     * Update the specified category icon
     */
    public function update(Request $request, CategoryIcon $categoryIcon)
    {
        $request->validate([
            'display_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255', Rule::unique('category_icons')->ignore($categoryIcon->id)],
            'icon_file' => ['nullable', 'file', 'mimes:svg,png,jpg,jpeg,webp', 'max:2048'],
            'is_active' => ['boolean'],
            'is_global' => ['boolean'],
            'business_categories' => ['nullable', 'array'],
            'business_categories.*' => ['exists:business_categories,id'],
        ]);

        // Validar que tenga al menos una categoría O sea global
        if (!$request->boolean('is_global') && empty($request->business_categories)) {
            return back()
                ->withErrors(['business_categories' => 'Debes seleccionar al menos una categoría de negocio o marcar el icono como global.'])
                ->withInput();
        }

        try {
            $data = [
                'name' => $request->name,
                'display_name' => $request->display_name,
                'is_active' => $request->boolean('is_active'),
                'is_global' => $request->boolean('is_global', false),
            ];

            // Manejar nuevo archivo si se sube
            if ($request->hasFile('icon_file')) {
                // ✅ Eliminar archivo anterior del storage
                if ($categoryIcon->image_path) {
                    Storage::disk('public')->delete($categoryIcon->image_path);
                }

                // ✅ Guardar nuevo archivo usando Storage::disk('public')->putFileAs()
                // Compatible con S3 (Laravel Cloud) y filesystem local
                $file = $request->file('icon_file');
                $filename = $request->name . '.' . $file->getClientOriginalExtension();
                
                // Guardar en storage/category-icons/
                $savedPath = Storage::disk('public')->putFileAs('category-icons', $file, $filename);
                
                $data['image_path'] = $savedPath; // Guardar path relativo
            }

            $categoryIcon->update($data);

            // Sincronizar categorías de negocio (si no es global)
            if (!$request->boolean('is_global') && !empty($request->business_categories)) {
                $syncData = [];
                foreach ($request->business_categories as $index => $categoryId) {
                    $syncData[$categoryId] = ['sort_order' => $index];
                }
                $categoryIcon->businessCategories()->sync($syncData);
            } else {
                // Si es global, eliminar todas las asociaciones
                $categoryIcon->businessCategories()->detach();
            }

            return redirect()
                ->route('superlinkiu.category-icons.index')
                ->with('success', 'Icono de categoría actualizado exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error updating category icon: ' . $e->getMessage());
            return back()
                ->withErrors(['general' => 'Error al actualizar el icono: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Toggle active status of category icon
     */
    public function toggleActive(CategoryIcon $categoryIcon)
    {
        try {
            $categoryIcon->update([
                'is_active' => !$categoryIcon->is_active
            ]);

            return response()->json([
                'success' => true,
                'is_active' => $categoryIcon->is_active,
                'message' => $categoryIcon->is_active ? 'Icono activado' : 'Icono desactivado'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar estado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update sort order of category icons
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'icons' => ['required', 'array'],
            'icons.*.id' => ['required', 'exists:category_icons,id'],
            'icons.*.sort_order' => ['required', 'integer', 'min:0'],
        ]);

        try {
            foreach ($request->icons as $iconData) {
                CategoryIcon::where('id', $iconData['id'])
                    ->update(['sort_order' => $iconData['sort_order']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Orden actualizado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar orden: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified category icon
     */
    public function destroy(CategoryIcon $categoryIcon)
    {
        try {
            // Verificar si el icono está siendo usado
            $categoriesCount = \App\Features\TenantAdmin\Models\Category::where('icon_id', $categoryIcon->id)->count();
            
            if ($categoriesCount > 0) {
                return redirect()
                    ->route('superlinkiu.category-icons.index')
                    ->with('error', "No se puede eliminar el icono porque está siendo usado por {$categoriesCount} categoría(s).");
            }

            // ✅ Eliminar archivo usando método estándar
            if ($categoryIcon->image_path) {
                $filePath = public_path('storage/' . $categoryIcon->image_path);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Eliminar registro
            $categoryIcon->delete();

            return redirect()
                ->route('superlinkiu.category-icons.index')
                ->with('success', 'Icono de categoría eliminado exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error deleting category icon: ' . $e->getMessage());
            return redirect()
                ->route('superlinkiu.category-icons.index')
                ->with('error', 'Error al eliminar el icono: ' . $e->getMessage());
        }
    }
} 