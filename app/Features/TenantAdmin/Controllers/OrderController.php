<?php

namespace App\Features\TenantAdmin\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\Order;
use App\Shared\Models\OrderItem;
use App\Features\TenantAdmin\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Shared\Traits\LogsActivity;
use App\Shared\Traits\HandlesErrors;

class OrderController extends Controller
{
    use LogsActivity, HandlesErrors;
    /**
     * Display a listing of orders with advanced filters
     */
    public function index(Request $request): View
    {
        $store = $request->route('store');
        
        // Query base con relaciones (eager loading optimizado)
        $query = Order::byStore($store->id)
            ->with(['items.product.mainImage']) // Cargar imagen principal también
            ->orderBy('created_at', 'desc');

        // Filtros
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('payment_method')) {
            $query->byPaymentMethod($request->payment_method);
        }

        if ($request->filled('delivery_type')) {
            $query->byDeliveryType($request->delivery_type);
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->byDateRange($request->date_from, $request->date_to);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('amount_from')) {
            $query->where('total', '>=', $request->amount_from);
        }

        if ($request->filled('amount_to')) {
            $query->where('total', '<=', $request->amount_to);
        }

        $orders = $query->paginate(15)->withQueryString();

        // Estadísticas optimizadas con una sola query
        $statusCounts = Order::select('status', \DB::raw('count(*) as count'))
            ->where('store_id', $store->id)
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        
        $stats = [
            'total' => array_sum($statusCounts),
            'pending' => $statusCounts['pending'] ?? 0,
            'confirmed' => $statusCounts['confirmed'] ?? 0,
            'preparing' => $statusCounts['preparing'] ?? 0,
            'shipped' => $statusCounts['shipped'] ?? 0,
            'delivered' => $statusCounts['delivered'] ?? 0,
            'cancelled' => $statusCounts['cancelled'] ?? 0,
            'total_revenue' => Order::byStore($store->id)
                ->whereIn('status', ['delivered'])
                ->sum('total'),
            'avg_order_value' => Order::byStore($store->id)
                ->whereIn('status', ['delivered'])
                ->avg('total') ?? 0,
        ];

        return view('tenant-admin::orders.index', compact('orders', 'stats', 'store'));
    }

    /**
     * Show the form for creating a new order
     */
    public function create(Request $request): View
    {
        $store = $request->route('store');
        
        // Obtener productos activos de la tienda
        $products = Product::byStore($store->id)
            ->active()
            ->with(['variants', 'mainImage'])
            ->orderBy('name')
            ->get();

        // Obtener métodos de envío activos
        $shippingMethods = ShippingMethod::where('store_id', $store->id)
            ->active()
            ->with('activeZones')
            ->ordered()
            ->get();

        // Departamentos de Colombia (estático para MVP)
        $departments = [
            'Amazonas', 'Antioquia', 'Arauca', 'Atlántico', 'Bolívar', 'Boyacá', 
            'Caldas', 'Caquetá', 'Casanare', 'Cauca', 'Cesar', 'Chocó', 
            'Córdoba', 'Cundinamarca', 'Guainía', 'Guaviare', 'Huila', 'La Guajira', 
            'Magdalena', 'Meta', 'Nariño', 'Norte de Santander', 'Putumayo', 'Quindío', 
            'Risaralda', 'San Andrés y Providencia', 'Santander', 'Sucre', 'Tolima', 
            'Valle del Cauca', 'Vaupés', 'Vichada'
        ];

        return view('tenant-admin::orders.create', compact('products', 'shippingMethods', 'departments', 'store'));
    }

    /**
     * Store a newly created order
     */
    public function store(Request $request): RedirectResponse
    {
        $store = $request->route('store');

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'department' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'delivery_type' => 'required|in:domicilio,pickup',
            'payment_method' => 'required|in:transferencia,contra_entrega,efectivo',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.variants' => 'nullable|array',
            'shipping_zone_id' => 'nullable|exists:simple_shipping_zones,id',
            'payment_proof' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120' // 5MB
        ]);

        try {
            DB::beginTransaction();

            // Calcular costos de envío
            $shippingCost = 0;
            if ($validated['delivery_type'] === 'domicilio' && isset($validated['shipping_zone_id'])) {
                // Usar nuevo sistema de envío simple
                $zone = \App\Features\TenantAdmin\Models\SimpleShippingZone::find($validated['shipping_zone_id']);
                if ($zone && $zone->simpleShipping->store_id === $store->id) {
                    $shippingCost = $zone->cost;
                }
            }

            // Crear el pedido
            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'],
                'department' => $validated['department'],
                'city' => $validated['city'],
                'delivery_type' => $validated['delivery_type'],
                'payment_method' => $validated['payment_method'],
                'shipping_cost' => $shippingCost,
                'subtotal' => 0, // Se calculará con los items
                'coupon_discount' => 0,
                'total' => 0, // Se calculará con los items
                'notes' => $validated['notes'],
                'store_id' => $store->id,
                'status' => Order::STATUS_PENDING
            ]);

            // Agregar items al pedido
            foreach ($validated['items'] as $itemData) {
                $product = Product::find($itemData['product_id']);
                
                // Verificar que el producto pertenece a la tienda
                if ($product->store_id !== $store->id) {
                    throw new \Exception('Producto no válido para esta tienda');
                }

                $orderItemData = OrderItem::createFromProduct(
                    $product, 
                    $itemData['quantity'], 
                    $itemData['variants'] ?? null
                );

                $order->items()->create($orderItemData);
            }

            // Recalcular totales del pedido
            $order->recalculateTotals();

            // Procesar comprobante de pago si se subió
            if ($request->hasFile('payment_proof')) {
                $paymentProofPath = $this->handlePaymentProofUpload($request->file('payment_proof'), $order->order_number);
                $order->update(['payment_proof_path' => $paymentProofPath]);
            }

            DB::commit();

            return redirect()
                ->route('tenant.admin.orders.show', ['store' => $store->slug, 'order' => $order->id])
                ->with('success', 'Pedido creado exitosamente. Número: ' . $order->order_number);

        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->withErrors(['error' => 'Error al crear el pedido: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified order
     */
    public function show(Request $request, $storeSlug, Order $order): View
    {
        $store = $request->route('store');
        
        // Verificar que el pedido pertenece a la tienda
        if ($order->store_id !== $store->id) {
            abort(404);
        }

        // Cargar relaciones
        $order->load([
            'items.product.mainImage'
            // TODO: 'statusHistory' cuando se implemente
        ]);

        // Obtener configuración de envío simplificado
        $simpleShipping = \App\Features\TenantAdmin\Models\SimpleShipping::getOrCreateForStore($store->id);
        $simpleShipping->load('activeZones');

        return view('tenant-admin::orders.show', compact('order', 'store', 'simpleShipping'));
    }

    /**
     * Show the form for editing the specified order
     */
    public function edit(Request $request, $storeSlug, Order $order): View
    {
        $store = $request->route('store');
        
        // Verificar que el pedido pertenece a la tienda
        if ($order->store_id !== $store->id) {
            abort(404);
        }

        // Solo permitir edición en estados tempranos
        if (!$order->canBeEdited()) {
            return redirect()
                ->route('tenant.admin.orders.show', ['store' => $store->slug, 'order' => $order->id])
                ->with('error', 'No se puede editar un pedido en estado: ' . $order->status_label);
        }

        // Cargar datos necesarios
        $order->load('items.product.mainImage');
        
        $products = Product::byStore($store->id)
            ->active()
            ->with(['variants', 'mainImage'])
            ->orderBy('name')
            ->get();

        $simpleShipping = \App\Features\TenantAdmin\Models\SimpleShipping::getOrCreateForStore($store->id);
        $simpleShipping->load('activeZones');

        $departments = [
            'Amazonas', 'Antioquia', 'Arauca', 'Atlántico', 'Bolívar', 'Boyacá', 
            'Caldas', 'Caquetá', 'Casanare', 'Cauca', 'Cesar', 'Chocó', 
            'Córdoba', 'Cundinamarca', 'Guainía', 'Guaviare', 'Huila', 'La Guajira', 
            'Magdalena', 'Meta', 'Nariño', 'Norte de Santander', 'Putumayo', 'Quindío', 
            'Risaralda', 'San Andrés y Providencia', 'Santander', 'Sucre', 'Tolima', 
            'Valle del Cauca', 'Vaupés', 'Vichada'
        ];

        return view('tenant-admin::orders.edit', compact('order', 'products', 'simpleShipping', 'departments', 'store'));
    }

    /**
     * Update the specified order
     */
    public function update(Request $request, $storeSlug, Order $order): RedirectResponse
    {
        $store = $request->route('store');
        
        // Verificar que el pedido pertenece a la tienda
        if ($order->store_id !== $store->id) {
            abort(404);
        }

        // Solo permitir edición en estados tempranos
        if (!$order->canBeEdited()) {
            return redirect()
                ->route('tenant.admin.orders.show', ['store' => $store->slug, 'order' => $order->id])
                ->with('error', 'No se puede editar un pedido en estado: ' . $order->status_label);
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'department' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'delivery_type' => 'required|in:domicilio,pickup',
            'payment_method' => 'required|in:transferencia,contra_entrega,efectivo',
            'notes' => 'nullable|string|max:1000',
            'payment_proof' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'remove_payment_proof' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            // Actualizar datos básicos del pedido
            $order->update([
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'],
                'department' => $validated['department'],
                'city' => $validated['city'],
                'delivery_type' => $validated['delivery_type'],
                'payment_method' => $validated['payment_method'],
                'notes' => $validated['notes']
            ]);

            // Gestionar comprobante de pago
            if ($request->boolean('remove_payment_proof') && $order->payment_proof_path) {
                $this->deletePaymentProof($order->payment_proof_path);
                $order->update(['payment_proof_path' => null]);
            }

            if ($request->hasFile('payment_proof')) {
                // Eliminar comprobante anterior si existe
                if ($order->payment_proof_path) {
                    $this->deletePaymentProof($order->payment_proof_path);
                }
                
                $paymentProofPath = $this->handlePaymentProofUpload($request->file('payment_proof'), $order->order_number);
                $order->update(['payment_proof_path' => $paymentProofPath]);
            }

            DB::commit();

            return redirect()
                ->route('tenant.admin.orders.show', ['store' => $store->slug, 'order' => $order->id])
                ->with('success', 'Pedido actualizado exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->withErrors(['error' => 'Error al actualizar el pedido: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified order
     */
    public function destroy(Request $request, $storeSlug, Order $order)
    {
        $store = $request->route('store');
        
        // Verificar que el pedido pertenece a la tienda
        if ($order->store_id !== $store->id) {
            abort(404);
        }

        // Solo permitir eliminación en estado pendiente
        if ($order->status !== Order::STATUS_PENDING) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo se pueden eliminar pedidos en estado pendiente'
                ], 422);
            }
            
            return redirect()
                ->route('tenant.admin.orders.index', $store->slug)
                ->with('error', 'Solo se pueden eliminar pedidos en estado pendiente');
        }

        try {
            // Eliminar comprobante de pago si existe
            if ($order->payment_proof_path) {
                $this->deletePaymentProof($order->payment_proof_path);
            }

            $orderNumber = $order->order_number;
            $order->delete();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Pedido {$orderNumber} eliminado exitosamente"
                ]);
            }

            return redirect()
                ->route('tenant.admin.orders.index', $store->slug)
                ->with('success', "Pedido {$orderNumber} eliminado exitosamente");

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el pedido: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()
                ->route('tenant.admin.orders.index', $store->slug)
                ->with('error', 'Error al eliminar el pedido: ' . $e->getMessage());
        }
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $storeSlug, Order $order): JsonResponse
    {
        $store = $request->route('store');
        
        // Verificar que el pedido pertenece a la tienda
        if ($order->store_id !== $store->id) {
            return response()->json(['success' => false, 'message' => 'Pedido no encontrado'], 404);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,shipped,delivered,cancelled',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            $oldStatus = $order->status;
            
            // Validar transición de estado
            $order->validateStatusTransition($validated['status']);
            
            // Log de auditoría
            $this->logStateChange($order, 'status', $oldStatus, $validated['status']);
            
            $order->update(['status' => $validated['status']]);

            // TODO: El historial se registra automáticamente en el boot del modelo
            // if ($validated['notes']) {
            //     $order->statusHistory()->latest()->first()->update(['notes' => $validated['notes']]);
            // }

            // 🔔 Disparar evento de cambio de estado para notificar al cliente
            event(new \App\Events\OrderStatusChanged($order, $oldStatus, $validated['status']));

            return response()->json([
                'success' => true,
                'message' => "Estado cambiado de {$order::STATUSES[$oldStatus]} a {$order->status_label}",
                'new_status' => $validated['status'],
                'new_status_label' => $order->status_label,
                'status_color' => $order->status_color
            ]);

        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false, 
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Error al cambiar estado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Get order count for notifications
     */
    public function getOrderCount(Request $request): JsonResponse
    {
        $store = $request->route('store');
        
        try {
            $count = Order::byStore($store->id)->count();
            
            // Obtener el último pedido para notificaciones
            $latestOrder = Order::byStore($store->id)
                ->orderBy('created_at', 'desc')
                ->first();
            
            return response()->json([
                'success' => true,
                'count' => $count,
                'latest_order' => $latestOrder ? [
                    'id' => $latestOrder->id,
                    'order_number' => $latestOrder->order_number,
                    'customer_name' => $latestOrder->customer_name,
                    'total' => $latestOrder->total,
                    'created_at' => $latestOrder->created_at->format('Y-m-d H:i:s')
                ] : null
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener conteo de pedidos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get shipping cost for a zone
     */
    public function getShippingCost(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'zone_id' => 'required|exists:simple_shipping_zones,id',
            'subtotal' => 'required|numeric|min:0'
        ]);

        $store = $request->route('store');
        $zone = \App\Features\TenantAdmin\Models\SimpleShippingZone::where('id', $validated['zone_id'])
            ->whereHas('simpleShipping', function($query) use ($store) {
                $query->where('store_id', $store->id);
            })
            ->first();

        if (!$zone) {
            return response()->json(['success' => false, 'message' => 'Zona no encontrada'], 404);
        }

        $finalCost = $zone->getFinalCost($validated['subtotal']);
        $hasFreeShipping = $zone->hasFreeShipping($validated['subtotal']);

        return response()->json([
            'success' => true,
            'cost' => $finalCost,
            'formatted_cost' => '$' . number_format($finalCost, 0, ',', '.'),
            'has_free_shipping' => $hasFreeShipping,
            'free_shipping_message' => $zone->getFreeShippingMessage()
        ]);
    }

    /**
     * Duplicate an order
     */
    public function duplicate(Request $request, $storeSlug, Order $order): RedirectResponse
    {
        $store = $request->route('store');
        
        // Verificar que el pedido pertenece a la tienda
        if ($order->store_id !== $store->id) {
            abort(404);
        }

        try {
            DB::beginTransaction();

            // Duplicar pedido
            $newOrder = $order->replicate();
            $newOrder->order_number = null; // Se generará automáticamente
            $newOrder->status = Order::STATUS_PENDING;
            $newOrder->payment_proof_path = null; // No duplicar comprobante
            $newOrder->save();

            // Duplicar items
            foreach ($order->items as $item) {
                $newItem = $item->replicate();
                $newItem->order_id = $newOrder->id;
                $newItem->save();
            }

            // Recalcular totales
            $newOrder->recalculateTotals();

            DB::commit();

            return redirect()
                ->route('tenant.admin.orders.edit', ['store' => $store->slug, 'order' => $newOrder->id])
                ->with('success', "Pedido duplicado exitosamente. Nuevo número: {$newOrder->order_number}");

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al duplicar pedido: ' . $e->getMessage());
        }
    }

    /**
     * Handle payment proof upload
     */
    private function handlePaymentProofUpload($file, string $orderNumber): string
    {
        $filename = $orderNumber . '_' . time() . '.' . $file->getClientOriginalExtension();
        
        // ✅ Guardar usando Storage::disk('public') - Compatible con S3 (Laravel Cloud)
        $directory = 'orders/payment-proofs';
        
        try {
            // putFileAs guarda el archivo y retorna el path relativo
            $relativePath = Storage::disk('public')->putFileAs($directory, $file, $filename);
            
            if (!$relativePath) {
                throw new \Exception('Error guardando comprobante de pago en storage');
            }
            
            return $relativePath; // Devolver path relativo (ej: orders/payment-proofs/ABC123_123456789.jpg)
            
        } catch (\Exception $e) {
            \Log::error('Error subiendo comprobante de pago:', [
                'order_number' => $orderNumber,
                'error' => $e->getMessage()
            ]);
            throw new \Exception('Error guardando comprobante de pago');
        }
    }

    /**
     * Delete payment proof file
     */
    private function deletePaymentProof(string $filePath): void
    {
        Storage::disk('public')->delete($filePath); // Asumir que $filePath ya contiene el path completo
    }

    /**
     * Download payment proof
     */
    public function downloadPaymentProof(Request $request, $storeSlug, $orderId)
    {
        $store = $request->route('store');
        
        \Log::info('📥 Download payment proof request:', [
            'store_slug' => $storeSlug,
            'store_id' => $store->id,
            'order_id' => $orderId
        ]);
        
        // Buscar la orden manualmente
        $order = Order::where('id', $orderId)
            ->where('store_id', $store->id)
            ->first();
        
        if (!$order) {
            \Log::warning('⚠️ Order not found:', [
                'order_id' => $orderId,
                'store_id' => $store->id
            ]);
            abort(404, 'Pedido no encontrado');
        }
        
        if (!$order->payment_proof_path) {
            \Log::warning('⚠️ No payment proof path:', [
                'order_id' => $order->id,
                'order_number' => $order->order_number
            ]);
            abort(404, 'Este pedido no tiene comprobante de pago');
        }
        
        \Log::info('📄 Payment proof path:', [
            'path' => $order->payment_proof_path
        ]);

        // ✅ Intentar múltiples ubicaciones para compatibilidad con archivos antiguos
        $possiblePaths = [
            $order->payment_proof_path, // Path directo (nuevo sistema)
            'public/' . $order->payment_proof_path, // Path con public/ (sistema antiguo)
        ];
        
        $fileContent = null;
        $mimeType = null;
        $foundPath = null;
        
        // Intentar en disco 'public' (S3)
        foreach ($possiblePaths as $path) {
            if (Storage::disk('public')->exists($path)) {
                \Log::info('✅ File found in public disk:', ['path' => $path]);
                $foundPath = $path;
                $fileContent = Storage::disk('public')->get($path);
                $mimeType = Storage::disk('public')->mimeType($path);
                break;
            }
        }
        
        // Si no se encuentra en 'public', intentar en disco 'local' (fallback para archivos antiguos)
        if (!$fileContent) {
            \Log::info('🔍 File not found in public disk, trying local disk...');
            
            foreach ($possiblePaths as $path) {
                if (Storage::disk('local')->exists($path)) {
                    \Log::info('✅ File found in local disk:', ['path' => $path]);
                    $foundPath = $path;
                    $fileContent = Storage::disk('local')->get($path);
                    $mimeType = Storage::disk('local')->mimeType($path);
                    break;
                }
            }
        }
        
        if (!$fileContent) {
            \Log::error('❌ File not found in any storage:', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'attempted_paths' => $possiblePaths,
                'public_disk_checked' => true,
                'local_disk_checked' => true
            ]);
            
            // Redirigir a editar con mensaje de error
            return redirect()
                ->route('tenant.admin.orders.edit', [$storeSlug, $order->id])
                ->with('error', 'El archivo del comprobante no está disponible. Pudo haberse subido antes de la migración a S3. Por favor, vuelve a subir el comprobante usando el formulario a continuación.');
        }

        // Enviar archivo
        try {
            $filename = 'Comprobante_' . $order->order_number . '.' . pathinfo($order->payment_proof_path, PATHINFO_EXTENSION);
            
            \Log::info('✅ Sending file:', [
                'filename' => $filename,
                'mime_type' => $mimeType,
                'size' => strlen($fileContent),
                'found_in_path' => $foundPath
            ]);
            
            return response($fileContent, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
                
        } catch (\Exception $e) {
            \Log::error('❌ Error descargando comprobante:', [
                'order_id' => $order->id,
                'path' => $order->payment_proof_path,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Error al descargar el comprobante: ' . $e->getMessage());
        }
    }
} 