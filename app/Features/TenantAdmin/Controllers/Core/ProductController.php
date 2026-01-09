<?php

namespace App\Features\TenantAdmin\Controllers\Core;

use App\Features\TenantAdmin\Models\Product;
use App\Features\TenantAdmin\Models\ProductImage;
use App\Features\TenantAdmin\Models\Category;
use App\Features\TenantAdmin\Models\ProductVariable;
use App\Features\TenantAdmin\Models\ProductVariableAssignment;
use App\Features\TenantAdmin\Models\VariableOption;
use App\Features\TenantAdmin\Models\ProductVariant;
use App\Features\TenantAdmin\Services\Core\ProductImageService;
use App\Services\KiuBotService;
use App\Shared\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Shared\Traits\LogsActivity;
use App\Shared\Traits\HandlesErrors;

class ProductController extends Controller
{
    use LogsActivity, HandlesErrors;
    
    protected $imageService;

    public function __construct(ProductImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Mostrar lista de productos
     */
    public function index(Request $request): View
    {
        // Obtener la tienda actual desde el contexto compartido
        $store = view()->shared('currentStore');
        
        // Obtener límites del plan
        $plan = $store->plan;
        $currentCount = Product::byStore($store->id)->count();
        $maxProducts = $plan->max_products ?? 0;
        
        // Obtener categorías para los filtros
        $categories = Category::where('store_id', $store->id)->get();
        
        // Consulta base de productos
        $query = Product::byStore($store->id)
            ->with(['images', 'categories', 'variants'])
            ->orderBy('created_at', 'desc');

        // Aplicar filtros
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('type')) {
            if ($request->type === 'simple') {
                $query->simple();
            } elseif ($request->type === 'variable') {
                $query->variable();
            }
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        $products = $query->paginate(20);
        
        return view('tenant-admin::Core/products.index', compact('products', 'store', 'currentCount', 'maxProducts', 'categories'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create(Request $request): View
    {
        // Obtener la tienda actual desde el contexto compartido
        $store = view()->shared('currentStore');
        
        // Verificar límites del plan
        $plan = $store->plan;
        $currentCount = Product::byStore($store->id)->count();
        $maxProducts = $plan->max_products ?? 0;

        if ($currentCount >= $maxProducts) {
            return redirect()->route('tenant.admin.products.index', $store->slug)
                ->with('error', 'Has alcanzado el límite de productos para tu plan actual.');
        }

        $categories = Category::where('store_id', $store->id)->get();
        $variables = ProductVariable::where('store_id', $store->id)
            ->withCount('assignments')
            ->with('activeOptions')
            ->get();

        return view('tenant-admin::Core/products.create', compact(
            'store',
            'categories',
            'variables',
            'currentCount',
            'maxProducts'
        ));
    }

    /**
     * Guardar nuevo producto
     */
    public function store(Request $request): RedirectResponse
    {
        // Obtener la tienda actual desde el contexto compartido
        $store = view()->shared('currentStore');
        
        // Validación básica
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sku' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            // Campos de stock
            'controla_stock' => 'boolean',
            'tipo_stock' => 'nullable|in:ilimitado,limitado',
            'cantidad_stock' => 'nullable|integer|min:0',
            'umbral_alerta_stock' => 'nullable|integer|min:1|max:1000',
            // Campos de bajo pedido
            'is_made_to_order' => 'boolean',
            'preparation_days' => 'nullable|integer|min:1|max:365',
            'requires_deposit' => 'boolean',
            'deposit_type' => 'nullable|in:percentage,fixed',
            'deposit_value' => 'nullable|numeric|min:0',
        ], [
            'name.required' => 'El nombre del producto es obligatorio',
            'name.max' => 'El nombre no puede exceder 255 caracteres',
            'price.required' => 'El precio es obligatorio',
            'price.numeric' => 'El precio debe ser un número válido',
            'price.min' => 'El precio no puede ser negativo',
            'sku.max' => 'El SKU no puede exceder 100 caracteres',
            'preparation_days.min' => 'Los días de preparación deben ser al menos 1',
            'preparation_days.max' => 'Los días de preparación no pueden exceder 365',
            'deposit_value.min' => 'El valor del anticipo no puede ser negativo',
        ]);

        // Validar que el anticipo fijo no sea mayor al precio del producto
        if ($request->boolean('requires_deposit') && 
            $request->input('deposit_type') === 'fixed' && 
            $request->input('deposit_value') >= $request->input('price')) {
            return back()->withErrors([
                'deposit_value' => 'El anticipo fijo debe ser menor al precio del producto ($' . number_format($request->input('price'), 0, ',', '.') . ')'
            ])->withInput();
        }

        // Crear producto
        $product = Product::create([
            'store_id' => $store->id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'sku' => $request->sku,
            'is_active' => $request->boolean('is_active', true),
            'type' => $request->type ?? 'simple',
            // Campos de stock
            'controla_stock' => $request->boolean('controla_stock', false),
            'tipo_stock' => $request->input('tipo_stock', 'ilimitado'),
            'cantidad_stock' => $request->input('cantidad_stock'),
            'umbral_alerta_stock' => $request->input('umbral_alerta_stock', 1),
            // Campos de precio promocional
            'precio_promocional' => $request->input('precio_promocional'),
            'promocion_activa' => $request->boolean('promocion_activa', false),
            'promocion_fecha_inicio' => $request->input('promocion_fecha_inicio'),
            'promocion_fecha_fin' => $request->input('promocion_fecha_fin'),
            // Campos de bajo pedido
            'is_made_to_order' => $request->boolean('is_made_to_order', false),
            'preparation_days' => $request->boolean('is_made_to_order') ? $request->input('preparation_days') : null,
            'requires_deposit' => $request->boolean('is_made_to_order') ? $request->boolean('requires_deposit', false) : false,
            'deposit_type' => $request->boolean('requires_deposit') ? $request->input('deposit_type') : null,
            'deposit_value' => $request->boolean('requires_deposit') ? $request->input('deposit_value') : null,
        ]);

        // Procesar imágenes si se subieron
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $this->imageService->processImages($product, $images);
        }

        // Asignar categorías si se seleccionaron
        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        // Asignar variables si el producto es tipo 'variable'
        if ($product->type === 'variable' && $request->has('variables')) {
            $this->syncProductVariables($product, $request->variables);
        }

        // Crear variaciones manuales si vienen del formulario
        if ($product->type === 'variable' && $request->has('variations')) {
            $this->createManualVariations($product, $request->variations);
        }
        
        return redirect()->route('tenant.admin.products.index', $store->slug)
            ->with('success', 'Producto creado exitosamente');
    }

    /**
     * Mostrar producto específico
     */
    public function show(Request $request, $store, $product): View
    {
        // Obtener la tienda actual desde el contexto compartido
        $store = view()->shared('currentStore');
        
        // Buscar el producto manualmente
        $product = Product::where('id', $product)
            ->where('store_id', $store->id)
            ->firstOrFail();
        
        $product->load([
            'images', 
            'categories', 
            'variants',
            'variableAssignments.variable.activeOptions'
        ]);
        
        return view('tenant-admin::Core/products.show', compact('product', 'store'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Request $request, $store, $product): View
    {
        // Obtener la tienda actual desde el contexto compartido
        $store = view()->shared('currentStore');
        
        // Buscar el producto manualmente
        $product = Product::where('id', $product)
            ->where('store_id', $store->id)
            ->firstOrFail();
        
        $product->load(['images', 'categories', 'variants', 'variableAssignments']);
        $categories = Category::where('store_id', $store->id)->get();
        $variables = ProductVariable::where('store_id', $store->id)->with('activeOptions')->get();

        return view('tenant-admin::Core/products.edit', compact(
            'product',
            'store',
            'categories',
            'variables'
        ));
    }

    /**
     * Actualizar producto
     */
    public function update(Request $request, $store, $product): RedirectResponse
    {
        // Obtener la tienda actual desde el contexto compartido
        $store = view()->shared('currentStore');
        
        // Buscar el producto manualmente
        $product = Product::where('id', $product)
            ->where('store_id', $store->id)
            ->firstOrFail();
        
        // Validación básica
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sku' => 'nullable|string|max:100',
            'type' => 'required|in:simple,variable',
            'is_active' => 'boolean',
            // Campos de stock
            'controla_stock' => 'boolean',
            'tipo_stock' => 'nullable|in:ilimitado,limitado',
            'cantidad_stock' => 'nullable|integer|min:0',
            'umbral_alerta_stock' => 'nullable|integer|min:1|max:1000',
            // Campos de bajo pedido
            'is_made_to_order' => 'boolean',
            'preparation_days' => 'nullable|integer|min:1|max:365',
            'requires_deposit' => 'boolean',
            'deposit_type' => 'nullable|in:percentage,fixed',
            'deposit_value' => 'nullable|numeric|min:0',
        ]);

        // Validar que el anticipo fijo no sea mayor al precio del producto
        if ($request->boolean('requires_deposit') && 
            $request->input('deposit_type') === 'fixed' && 
            $request->input('deposit_value') >= $request->input('price')) {
            return back()->withErrors([
                'deposit_value' => 'El anticipo fijo debe ser menor al precio del producto ($' . number_format($request->input('price'), 0, ',', '.') . ')'
            ])->withInput();
        }

        // Obtener el tipo del request antes de actualizar
        $newType = $request->input('type', $product->type);
        $oldType = $product->type;

        // Actualizar producto incluyendo el tipo y stock
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'sku' => $request->sku,
            'type' => $newType,
            'is_active' => $request->boolean('is_active', true),
            // Campos de stock
            'controla_stock' => $request->boolean('controla_stock', false),
            'tipo_stock' => $request->input('tipo_stock', 'ilimitado'),
            'cantidad_stock' => $request->input('cantidad_stock'),
            'umbral_alerta_stock' => $request->input('umbral_alerta_stock', 1),
            // Campos de precio promocional
            'precio_promocional' => $request->input('precio_promocional'),
            'promocion_activa' => $request->boolean('promocion_activa', false),
            'promocion_fecha_inicio' => $request->input('promocion_fecha_inicio'),
            'promocion_fecha_fin' => $request->input('promocion_fecha_fin'),
            // Campos de bajo pedido
            'is_made_to_order' => $request->boolean('is_made_to_order', false),
            'preparation_days' => $request->boolean('is_made_to_order') ? $request->input('preparation_days') : null,
            'requires_deposit' => $request->boolean('is_made_to_order') ? $request->boolean('requires_deposit', false) : false,
            'deposit_type' => $request->boolean('requires_deposit') ? $request->input('deposit_type') : null,
            'deposit_value' => $request->boolean('requires_deposit') ? $request->input('deposit_value') : null,
        ]);

        // Si cambió de variable a simple, eliminar todas las asignaciones de variables
        if ($oldType === 'variable' && $newType === 'simple') {
            $product->variableAssignments()->delete();
        }

        // Eliminar imágenes marcadas para eliminación
        if ($request->has('delete_images')) {
            $imageIds = $request->delete_images;
            foreach ($imageIds as $imageId) {
                // Validar que el ID no sea null o vacío
                if (!empty($imageId) && is_numeric($imageId)) {
                    $image = ProductImage::where('id', $imageId)
                        ->where('product_id', $product->id)
                        ->first();
                    if ($image) {
                        $this->imageService->deleteImage($image);
                    }
                }
            }
        }

        // Procesar nuevas imágenes si se subieron
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $this->imageService->processImages($product, $images);
        }

        // Actualizar categorías si se seleccionaron
        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        // Actualizar variables si el producto es tipo 'variable'
        if ($newType === 'variable') {
            if ($request->has('variables')) {
                $this->syncProductVariables($product, $request->variables);
            } else {
                // Si no hay variables en el request y es nuevo tipo variable, eliminar todas las asignaciones
                if ($oldType !== 'variable') {
                    $product->variableAssignments()->delete();
                }
            }
            
            // Actualizar variaciones manuales
            if ($request->has('variations')) {
                $this->createManualVariations($product, $request->variations);
            }
        }

        return redirect()->route('tenant.admin.products.index', $store->slug)
            ->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * Eliminar producto
     */
    public function destroy(Request $request, $store, $product): JsonResponse|RedirectResponse
    {
        // Obtener la tienda actual desde el contexto compartido
        $store = view()->shared('currentStore');
        
        // Buscar el producto manualmente
        $product = Product::where('id', $product)
            ->where('store_id', $store->id)
            ->firstOrFail();
        
        try {
            // Eliminar asignaciones de variables antes de eliminar el producto
            $product->variableAssignments()->delete();
            
            $product->delete();

            // Si es una petición AJAX, retornar JSON (para el index)
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Producto eliminado exitosamente.'
                ]);
            }

            // Si no es AJAX, redirigir al index con mensaje de éxito (para show)
            return redirect()->route('tenant.admin.products.index', $store->slug)
                ->with('success', 'Producto eliminado exitosamente.');
        } catch (\Exception $e) {
            // Si es una petición AJAX, retornar JSON con error
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Error al eliminar el producto: ' . $e->getMessage()
                ], 500);
            }

            // Si no es AJAX, redirigir con error
            return redirect()->route('tenant.admin.products.index', $store->slug)
                ->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }

    /**
     * Cambiar estado del producto
     */
    public function toggleStatus(Request $request, $store, $product): JsonResponse
    {
        // Obtener la tienda actual desde el contexto compartido
        $store = view()->shared('currentStore');
        
        // Buscar el producto manualmente
        $product = Product::where('id', $product)
            ->where('store_id', $store->id)
            ->firstOrFail();
        
        try {
            $product->update(['is_active' => !$product->is_active]);

            return response()->json([
                'success' => true,
                'is_active' => $product->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al cambiar el estado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Establecer imagen principal del producto
     */
    public function setMainImage(Request $request, $store, $product): RedirectResponse
    {
        // Obtener la tienda actual desde el contexto compartido
        $store = view()->shared('currentStore');
        
        // Buscar el producto manualmente
        $product = Product::where('id', $product)
            ->where('store_id', $store->id)
            ->firstOrFail();

        // Buscar la imagen
        $image = ProductImage::where('id', $request->image_id)
            ->where('product_id', $product->id)
            ->firstOrFail();

        // Establecer como imagen principal
        $this->imageService->setMainImage($product, $image);

        return redirect()->route('tenant.admin.products.edit', [$store->slug, $product->id])
            ->with('swal_success', 'Imagen principal establecida exitosamente.');
    }

    /**
     * Toggle allow_sharing del producto
     */
    public function toggleSharing(Request $request, $storeSlug, $product): JsonResponse
    {
        try {
            // Obtener la tienda actual
            $store = view()->shared('currentStore');
            
            // Buscar el producto
            $product = Product::where('id', $product)
                ->where('store_id', $store->id)
                ->firstOrFail();

            // Validar input
            $validated = $request->validate([
                'allow_sharing' => 'required|boolean'
            ]);

            // Actualizar
            $product->update(['allow_sharing' => $validated['allow_sharing']]);

            return response()->json([
                'success' => true,
                'allow_sharing' => $product->allow_sharing
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al actualizar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Sincronizar variables del producto
     */
    protected function syncProductVariables(Product $product, array $variables)
    {
        // Eliminar asignaciones existentes
        $product->variableAssignments()->delete();
        
        // Preparar estructura de cantidades por opción
        $optionQuantities = [];
        
        // Preparar datos para la tabla pivote product_variable (sistema manual)
        $pivotData = [];
        
        // Crear nuevas asignaciones
        foreach ($variables as $variableId => $data) {
            // Solo procesar si está marcado como enabled
            if (isset($data['enabled']) && $data['enabled']) {
                ProductVariableAssignment::create([
                    'product_id' => $product->id,
                    'variable_id' => $variableId,
                    'is_required' => isset($data['is_required']) && $data['is_required'] ? true : false,
                    'custom_label' => $data['custom_label'] ?? null,
                    'display_order' => $data['display_order'] ?? 999,
                    'selected_options' => isset($data['options']) && is_array($data['options']) ? $data['options'] : null,
                ]);
                
                // Preparar datos para la tabla pivote (sistema manual)
                $pivotData[$variableId] = [
                    'is_active' => true,
                    'custom_label' => $data['custom_label'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                // Guardar cantidades por opción si existen
                if (isset($data['quantities']) && is_array($data['quantities'])) {
                    $optionQuantities[$variableId] = [];
                    foreach ($data['quantities'] as $optionId => $quantity) {
                        $quantity = (int) $quantity;
                        if ($quantity > 0) {
                            $optionQuantities[$variableId][$optionId] = $quantity;
                        }
                    }
                    // Si no hay cantidades para esta variable, eliminar la entrada
                    if (empty($optionQuantities[$variableId])) {
                        unset($optionQuantities[$variableId]);
                    }
                }
            }
        }
        
        // Sincronizar la tabla pivote product_variable (sistema manual para storefront)
        $product->variables()->sync($pivotData);
        
        // ⚠️ YA NO SE USA option_quantities ni stock_variantes_productos
        // El stock ahora se maneja directamente en product_variants
    }

    /**
     * Crear variaciones manuales del producto
     */
    protected function createManualVariations(Product $product, array $variations)
    {
        // Eliminar variaciones existentes
        $product->variants()->delete();

        if (empty($variations)) {
            return;
        }

        Log::info('Creando variaciones manuales', [
            'product_id' => $product->id,
            'variations_count' => count($variations)
        ]);

        foreach ($variations as $variationData) {
            // Validar que tenga opciones seleccionadas
            if (empty($variationData['options'])) {
                continue;
            }

            // Construir variant_options y is_required
            $variantOptions = [];
            $requiredOptions = [];

            foreach ($variationData['options'] as $variableId => $optionId) {
                if (!empty($optionId)) {
                    $variantOptions[$variableId] = $optionId;
                    
                    // Verificar si esta opción es obligatoria
                    if (isset($variationData['is_required'][$variableId])) {
                        $requiredOptions[$variableId] = true;
                    }
                }
            }

            // Si no tiene opciones válidas, saltar
            if (empty($variantOptions)) {
                continue;
            }

            // Generar SKU si no viene del formulario
            $sku = $variationData['sku'] ?? $this->generateVariantSkuFromOptions($product, $variantOptions);

            // Crear la variación
            $product->variants()->create([
                'sku' => $sku,
                'price_modifier' => $variationData['price_modifier'] ?? 0,
                'stock' => $variationData['stock'] ?? 0,
                'is_active' => true,
                'variant_options' => $variantOptions,
                'required_options' => !empty($requiredOptions) ? $requiredOptions : null
            ]);
        }

        Log::info('Variaciones manuales creadas', [
            'product_id' => $product->id,
            'total_variants' => $product->variants()->count()
        ]);
    }

    /**
     * Generar SKU para variación basado en las opciones seleccionadas
     */
    protected function generateVariantSkuFromOptions(Product $product, array $variantOptions): string
    {
        $baseSku = $product->sku ?? 'VAR';
        $suffix = [];

        foreach ($variantOptions as $variableId => $optionId) {
            $option = VariableOption::find($optionId);
            if ($option) {
                $suffix[] = strtoupper(substr($option->name, 0, 2));
            }
        }

        $sku = $baseSku . '-' . implode('-', $suffix);
        
        // Asegurar que sea único
        $counter = 1;
        $originalSku = $sku;
        while (ProductVariant::where('sku', $sku)->exists()) {
            $sku = $originalSku . '-' . $counter;
            $counter++;
        }

        return $sku;
    }



    /**
     * Mejorar descripción de producto usando KiuBot
     */
    public function improveDescription(Request $request): JsonResponse
    {
        try {
            // Validar la solicitud
            $request->validate([
                'description' => 'required|string|min:10|max:5000',
                'product_name' => 'nullable|string|max:255'
            ]);

            $originalText = $request->input('description');
            $productName = $request->input('product_name');

            // Obtener la tienda y su vertical
            $store = view()->shared('currentStore');
            $vertical = $store->businessCategory->vertical ?? 'ecommerce';

            // Llamar al servicio de KiuBot
            $kiuBot = app(KiuBotService::class);
            $result = $kiuBot->improveProductDescription($originalText, $productName, $vertical);

            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'error' => $result['error'] ?? 'Error al mejorar la descripción'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'original_text' => $originalText,
                'improved_text' => $result['improved_text'],
                'tokens_used' => $result['tokens_used'] ?? 0
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Validación fallida: ' . $e->getMessage()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error en improveDescription', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor'
            ], 500);
        }
    }
} 
