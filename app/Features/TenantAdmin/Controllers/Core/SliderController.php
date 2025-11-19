<?php

namespace App\Features\TenantAdmin\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Features\TenantAdmin\Models\Slider;
use App\Features\TenantAdmin\Models\Product;
use App\Features\TenantAdmin\Models\Category;
use App\Features\TenantAdmin\Services\Core\SliderImageService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    protected SliderImageService $imageService;

    public function __construct(SliderImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Mostrar lista de sliders
     */
    public function index(Request $request): View
    {
        $store = view()->shared('currentStore');
        
        $query = Slider::forStore($store->id)->ordered();

        // Filtros
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('scheduling')) {
            if ($request->scheduling === 'scheduled') {
                $query->where('is_scheduled', true);
            } elseif ($request->scheduling === 'permanent') {
                $query->where('is_scheduled', false);
            }
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $sliders = $query->paginate(20);
        
        // Obtener límites del plan
        $currentCount = $store->sliders()->count();
        $maxSliders = $store->plan->max_slider ?? 1;

        return view('tenant-admin::core.sliders.index', compact(
            'sliders',
            'store',
            'currentCount',
            'maxSliders'
        ));
    }

    /**
     * Buscar enlaces internos (categorías/productos) para sliders
     */
    public function searchInternalLinks(Request $request): JsonResponse
    {
        $store = view()->shared('currentStore');

        $query = trim((string) $request->get('q', ''));
        $minLength = 3;

        if (mb_strlen($query) < $minLength) {
            return response()->json([
                'results' => [],
                'min_length' => $minLength,
            ]);
        }

        $normalizedQuery = Str::lower($query);
        $sluggedQuery = Str::slug($query);

        $categories = Category::query()
            ->select(['id', 'name', 'slug'])
            ->where('store_id', $store->id)
            ->where(function ($builder) use ($normalizedQuery, $sluggedQuery) {
                $builder
                    ->whereRaw('LOWER(name) LIKE ?', ['%' . $normalizedQuery . '%'])
                    ->orWhereRaw('LOWER(slug) LIKE ?', ['%' . Str::lower($sluggedQuery) . '%']);
            })
            ->orderBy('name')
            ->limit(10)
            ->get()
            ->map(function (Category $category) {
                return [
                    'id' => 'category-' . $category->id,
                    'label' => $category->name,
                    'url' => '/categoria/' . $category->slug,
                    'type' => 'category',
                    'type_label' => 'Categoría',
                ];
            });

        $products = Product::query()
            ->select(['id', 'name', 'slug'])
            ->where('store_id', $store->id)
            ->where(function ($builder) use ($normalizedQuery, $sluggedQuery) {
                $builder
                    ->whereRaw('LOWER(name) LIKE ?', ['%' . $normalizedQuery . '%'])
                    ->orWhereRaw('LOWER(slug) LIKE ?', ['%' . Str::lower($sluggedQuery) . '%']);
            })
            ->orderBy('name')
            ->limit(10)
            ->get()
            ->map(function (Product $product) {
                return [
                    'id' => 'product-' . $product->id,
                    'label' => $product->name,
                    'url' => '/producto/' . $product->slug,
                    'type' => 'product',
                    'type_label' => 'Producto',
                ];
            });

        $results = $categories->merge($products)->values();

        return response()->json([
            'results' => $results,
            'min_length' => $minLength,
        ]);
    }

    /**
     * Mostrar formulario de creación
     */
    public function create(): View
    {
        $store = view()->shared('currentStore');
        
        // Verificar límite del plan
        $currentCount = $store->sliders()->count();
        $maxSliders = $store->plan->max_slider ?? 1;
        
        if ($currentCount >= $maxSliders) {
            return redirect()->route('tenant.admin.sliders.index', $store->slug)
                           ->with('error', 'Has alcanzado el límite de sliders de tu plan.');
        }

        return view('tenant-admin::core.sliders.create', compact('store'));
    }

    /**
     * Guardar nuevo slider
     */
    public function store(Request $request): RedirectResponse
    {
        $store = view()->shared('currentStore');
        
        // Verificar límite del plan
        $currentCount = $store->sliders()->count();
        $maxSliders = $store->plan->max_slider ?? 1;
        
        if ($currentCount >= $maxSliders) {
            return redirect()->route('tenant.admin.sliders.index', $store->slug)
                           ->with('error', 'Has alcanzado el límite de sliders de tu plan.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:sliders,name,NULL,id,store_id,' . $store->id,
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url' => 'nullable|string|max:500',
            'url_type' => 'required|in:internal,external,none',
            'is_active' => 'boolean',
            'is_scheduled' => 'boolean',
            'is_permanent' => 'boolean',
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'scheduled_days' => 'nullable|array',
            'scheduled_days.*' => 'boolean',
        ], [
            'name.required' => 'El nombre del slider es obligatorio',
            'name.max' => 'El nombre no puede exceder 255 caracteres',
            'name.unique' => 'Ya existe un slider con este nombre en tu tienda',
            'image.required' => 'La imagen del slider es obligatoria',
            'image.image' => 'El archivo debe ser una imagen válida',
            'image.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg o gif',
            'image.max' => 'La imagen no puede ser mayor a 2MB',
            'url.max' => 'La URL no puede exceder 500 caracteres',
            'url_type.required' => 'El tipo de URL es obligatorio',
            'url_type.in' => 'El tipo de URL debe ser: interna, externa o ninguna',
            'start_date.after_or_equal' => 'La fecha de inicio debe ser hoy o posterior',
            'end_date.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio',
            'start_time.date_format' => 'El formato de hora de inicio no es válido (debe ser HH:MM)',
            'end_time.date_format' => 'El formato de hora de fin no es válido (debe ser HH:MM)',
            'end_time.after' => 'La hora de fin debe ser posterior a la hora de inicio',
        ]);

        $urlErrors = [];
        switch ($request->url_type) {
            case 'none':
                $request->merge(['url' => null]);
                break;
            case 'external':
                if (!$request->url) {
                    $urlErrors['url'] = 'Debes ingresar una URL externa.';
                } elseif (!filter_var($request->url, FILTER_VALIDATE_URL)) {
                    $urlErrors['url'] = 'La URL externa no tiene un formato válido.';
                }
                break;
            case 'internal':
                if (!$request->url) {
                    $urlErrors['url'] = 'Debes seleccionar un recurso interno.';
                } elseif (!$this->validateInternalUrl($request->url, $store->id)) {
                    $urlErrors['url'] = 'La URL interna no es válida. Debe ser una categoría o producto existente.';
                }
                break;
        }

        if (!empty($urlErrors)) {
            return redirect()->back()->withInput()->withErrors($urlErrors);
        }

        try {
            $slider = new Slider();
            $slider->store_id = $store->id;
            $slider->name = $request->name;
            $slider->description = $request->description;
            $slider->url = $request->url;
            $slider->url_type = $request->url_type;
            $slider->is_active = $request->boolean('is_active', true);
            $slider->is_scheduled = $request->boolean('is_scheduled', false);
            $slider->is_permanent = $request->boolean('is_permanent', false);
            $slider->start_date = $request->start_date;
            $slider->end_date = $request->end_date;
            $slider->start_time = $request->start_time;
            $slider->end_time = $request->end_time;
            $slider->scheduled_days = $request->scheduled_days;
            $slider->transition_duration = $request->transition_duration ?? '5'; // Valor por defecto
            
            // Procesar imagen
            $imagePath = $this->imageService->processImage($slider, $request->file('image'));
            if (!$imagePath) {
                return redirect()->back()
                               ->withInput()
                               ->withErrors(['image' => 'Error al procesar la imagen. Verifica que sea válida y tenga dimensiones mínimas de 420x200px (se redimensionará automáticamente).']);
            }
            
            $slider->image_path = $imagePath;
            $slider->save();
            
            // Marcar paso de onboarding como completado
            \App\Shared\Models\StoreOnboardingStep::markAsCompleted($store->id, 'slider');

            return redirect()->route('tenant.admin.sliders.index', $store->slug)
                           ->with('slider_created', true);

        } catch (\Exception $e) {
            \Log::error('Error creando slider: ' . $e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->withErrors(['general' => 'Error al crear el slider. Inténtalo de nuevo.']);
        }
    }

    /**
     * Mostrar slider específico
     */
    public function show(Request $request, $store, $slider): View
    {
        $store = view()->shared('currentStore');
        
        $slider = Slider::where('id', $slider)
                       ->where('store_id', $store->id)
                       ->firstOrFail();

        return view('tenant-admin::core.sliders.show', compact('slider', 'store'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Request $request, $store, $slider): View
    {
        $store = view()->shared('currentStore');
        
        $slider = Slider::where('id', $slider)
                       ->where('store_id', $store->id)
                       ->firstOrFail();

        // Obtener límites del plan
        $currentCount = $store->sliders()->count();
        $maxSliders = $store->plan->max_slider ?? 1;

        return view('tenant-admin::core.sliders.edit', compact('slider', 'store', 'currentCount', 'maxSliders'));
    }

    /**
     * Actualizar slider
     */
    public function update(Request $request, $store, $slider): RedirectResponse
    {
        $store = view()->shared('currentStore');
        
        $slider = Slider::where('id', $slider)
                       ->where('store_id', $store->id)
                       ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255|unique:sliders,name,' . $slider->id . ',id,store_id,' . $store->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url' => 'nullable|string|max:500',
            'url_type' => 'required|in:internal,external,none',
            'is_active' => 'boolean',
            'is_scheduled' => 'boolean',
            'is_permanent' => 'boolean',
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'scheduled_days' => 'nullable|array',
            'scheduled_days.*' => 'boolean',
        ], [
            'name.required' => 'El nombre del slider es obligatorio',
            'name.max' => 'El nombre no puede exceder 255 caracteres',
            'name.unique' => 'Ya existe un slider con este nombre en tu tienda',
            'image.image' => 'El archivo debe ser una imagen válida',
            'image.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg o gif',
            'image.max' => 'La imagen no puede ser mayor a 2MB',
            'url.max' => 'La URL no puede exceder 500 caracteres',
            'url_type.required' => 'El tipo de URL es obligatorio',
            'url_type.in' => 'El tipo de URL debe ser: interna, externa o ninguna',
            'start_date.after_or_equal' => 'La fecha de inicio debe ser hoy o posterior',
            'end_date.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio',
            'start_time.date_format' => 'El formato de hora de inicio no es válido (debe ser HH:MM)',
            'end_time.date_format' => 'El formato de hora de fin no es válido (debe ser HH:MM)',
            'end_time.after' => 'La hora de fin debe ser posterior a la hora de inicio',
        ]);

        // Validar dimensiones de imagen si se proporcionó
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageInfo = getimagesize($image->getPathname());
            
            if ($imageInfo === false) {
                return redirect()->back()
                               ->withInput()
                               ->withErrors(['image' => 'El archivo no es una imagen válida.']);
            }
            
            $width = $imageInfo[0];
            $height = $imageInfo[1];
            
            // Validar dimensiones exactas (420x200px)
            if ($width !== 420 || $height !== 200) {
                return redirect()->back()
                               ->withInput()
                               ->withErrors(['image' => "La imagen debe ser exactamente de 420x200px. Tamaño actual: {$width}x{$height}px."]);
            }
        }

        $urlErrors = [];
        switch ($request->url_type) {
            case 'none':
                $request->merge(['url' => null]);
                break;
            case 'external':
                if (!$request->url) {
                    $urlErrors['url'] = 'Debes ingresar una URL externa.';
                } elseif (!filter_var($request->url, FILTER_VALIDATE_URL)) {
                    $urlErrors['url'] = 'La URL externa no tiene un formato válido.';
                }
                break;
            case 'internal':
                if (!$request->url) {
                    $urlErrors['url'] = 'Debes seleccionar un recurso interno.';
                } elseif (!$this->validateInternalUrl($request->url, $store->id)) {
                    $urlErrors['url'] = 'La URL interna no es válida. Debe ser una categoría o producto existente.';
                }
                break;
        }

        if (!empty($urlErrors)) {
            return redirect()->back()->withInput()->withErrors($urlErrors);
        }

        try {
            $slider->name = $request->name;
            $slider->description = $request->description;
            $slider->url = $request->url;
            $slider->url_type = $request->url_type;
            $slider->is_active = $request->boolean('is_active', true);
            $slider->is_scheduled = $request->boolean('is_scheduled', false);
            $slider->is_permanent = $request->boolean('is_permanent', false);
            $slider->start_date = $request->start_date;
            $slider->end_date = $request->end_date;
            $slider->start_time = $request->start_time;
            $slider->end_time = $request->end_time;
            $slider->scheduled_days = $request->scheduled_days;
            $slider->transition_duration = $request->transition_duration ?? '5'; // Valor por defecto
            
            // Procesar nueva imagen si se subió
            if ($request->hasFile('image')) {
                $oldImagePath = $slider->image_path;
                
                $imagePath = $this->imageService->processImage($slider, $request->file('image'));
                if (!$imagePath) {
                    return redirect()->back()
                                   ->withInput()
                                   ->withErrors(['image' => 'Error al procesar la imagen. Verifica que sea válida y tenga dimensiones mínimas de 420x200px (se redimensionará automáticamente).']);
                }
                
                $slider->image_path = $imagePath;
                
                // Eliminar imagen anterior
                if ($oldImagePath) {
                    $this->imageService->deleteImage($oldImagePath);
                }
            }
            
            $slider->save();

            return redirect()->route('tenant.admin.sliders.index', $store->slug)
                           ->with('slider_updated', true);

        } catch (\Exception $e) {
            \Log::error('Error actualizando slider: ' . $e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->withErrors(['general' => 'Error al actualizar el slider. Inténtalo de nuevo.']);
        }
    }

    /**
     * Eliminar slider
     */
    public function destroy(Request $request, $store, $slider): JsonResponse
    {
        $store = view()->shared('currentStore');
        
        $slider = Slider::where('id', $slider)
                       ->where('store_id', $store->id)
                       ->firstOrFail();

        try {
            $slider->delete();

            return response()->json([
                'success' => true,
                'message' => 'Slider eliminado exitosamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al eliminar el slider: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Duplicar slider
     */
    public function duplicate(Request $request, $store, $slider): JsonResponse
    {
        $store = view()->shared('currentStore');
        
        $slider = Slider::where('id', $slider)
                       ->where('store_id', $store->id)
                       ->firstOrFail();

        // Verificar límite del plan
        $currentCount = $store->sliders()->count();
        $maxSliders = $store->plan->max_slider ?? 1;
        
        if ($currentCount >= $maxSliders) {
            return response()->json([
                'success' => false,
                'error' => 'Has alcanzado el límite de sliders de tu plan.'
            ], 400);
        }

        try {
            $newSlider = $slider->replicate();
            $newSlider->name = $request->input('name', $slider->name . ' (Copia)');
            $newSlider->is_active = false; // Duplicar como inactivo
            
            // Duplicar imagen
            if ($slider->image_path) {
                $newImagePath = $this->imageService->duplicateImage($slider, $newSlider);
                if ($newImagePath) {
                    $newSlider->image_path = $newImagePath;
                }
            }
            
            $newSlider->save();

            return response()->json([
                'success' => true,
                'message' => 'Slider duplicado exitosamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al duplicar el slider: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cambiar estado del slider
     */
    public function toggleStatus(Request $request, $store, $slider): JsonResponse
    {
        $store = view()->shared('currentStore');
        
        $slider = Slider::where('id', $slider)
                       ->where('store_id', $store->id)
                       ->firstOrFail();

        try {
            $slider->update(['is_active' => !$slider->is_active]);

            $status = $slider->is_active ? 'activado' : 'desactivado';
            
            return response()->json([
                'success' => true,
                'message' => "Slider {$status} exitosamente.",
                'is_active' => $slider->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al cambiar el estado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar orden de sliders
     */
    public function updateOrder(Request $request): JsonResponse
    {
        $store = view()->shared('currentStore');
        
        $request->validate([
            'sliders' => 'required|array',
            'sliders.*.id' => 'required|integer|exists:sliders,id',
            'sliders.*.sort_order' => 'required|integer|min:0',
        ]);

        try {
            foreach ($request->sliders as $sliderData) {
                Slider::where('id', $sliderData['id'])
                      ->where('store_id', $store->id)
                      ->update(['sort_order' => $sliderData['sort_order']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Orden actualizado exitosamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al actualizar el orden: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validar URL interna
     */
    private function validateInternalUrl(string $url, int $storeId): bool
    {
        $url = ltrim($url, '/');
        $segments = explode('/', $url);

        // Validar rutas de productos: /producto/slug
        if (isset($segments[0]) && $segments[0] === 'producto' && isset($segments[1])) {
            return Product::where('slug', $segments[1])
                         ->where('store_id', $storeId)
                         ->exists();
        }

        // Validar rutas de categorías: /categoria/slug
        if (isset($segments[0]) && $segments[0] === 'categoria' && isset($segments[1])) {
            return Category::where('slug', $segments[1])
                          ->where('store_id', $storeId)
                          ->exists();
        }

        return false;
    }
} 