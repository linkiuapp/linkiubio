<?php

namespace App\Features\Tenant\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\Store;
use App\Shared\Models\Table;
use App\Shared\Models\DineInSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DineInController extends Controller
{
    /**
     * Detectar mesa/habitación desde QR y mostrar banner + catálogo
     * Ruta: /mesa/{number} o /habitacion/{number}
     */
    public function detectTable(Request $request, $identifier)
    {
        // El middleware ya identificó la tienda
        $store = view()->shared('currentStore');
        
        // Si $identifier es un objeto Store (route model binding incorrecto), obtener el número de la URL
        if (is_object($identifier) && $identifier instanceof Store) {
            // Obtener el número directamente de la URL
            $identifier = $request->segment(2); // {store}/habitacion/{number} -> segment(2) es 'habitacion', segment(3) sería {number}
            // Intentar obtener desde el route parameter directamente
            $routeParams = $request->route()->parameters();
            foreach ($routeParams as $key => $value) {
                if ($key === 'number' && !is_object($value)) {
                    $identifier = $value;
                    break;
                }
            }
            // Si aún no lo tenemos, extraer de la URL
            if (is_object($identifier) || empty($identifier)) {
                $pathSegments = explode('/', trim($request->getPathInfo(), '/'));
                // Formato: {store}/habitacion/{number} o {store}/mesa/{number}
                if (count($pathSegments) >= 3) {
                    $identifier = $pathSegments[2]; // El tercer segmento debería ser el número
                }
            }
        }
        
        // Asegurar que identifier es un string/número válido
        $identifier = (string) $identifier;
        
        // Determinar si es mesa o habitación basándose en la ruta
        $type = $request->route()->getName() === 'tenant.dine-in.table' 
            ? Table::TYPE_MESA 
            : Table::TYPE_HABITACION;
        
        // Log para debugging
        \Log::info('DineInController@detectTable', [
            'store_id' => $store->id,
            'store_slug' => $store->slug,
            'identifier' => $identifier,
            'identifier_type' => gettype($identifier),
            'type' => $type,
            'route_name' => $request->route()->getName(),
            'path_info' => $request->getPathInfo(),
            'route_params' => $request->route()->parameters(),
        ]);
        
        // Buscar la mesa/habitación por número (comparación flexible para manejar strings y números)
        $table = Table::where('store_id', $store->id)
            ->where('type', $type)
            ->get()
            ->first(function($t) use ($identifier) {
                // Comparación flexible: puede ser string o número
                return (string)$t->table_number === (string)$identifier || 
                       $t->table_number == $identifier;
            });
        
        // Si no se encontró, buscar también sin restricción de is_active para debugging
        if (!$table) {
            $tableInactive = Table::where('store_id', $store->id)
                ->where('type', $type)
                ->get()
                ->first(function($t) use ($identifier) {
                    return (string)$t->table_number === (string)$identifier || 
                           $t->table_number == $identifier;
                });
            
            \Log::warning('Table not found in detectTable', [
                'store_id' => $store->id,
                'identifier' => $identifier,
                'type' => $type,
                'found_inactive' => $tableInactive ? [
                    'id' => $tableInactive->id,
                    'table_number' => $tableInactive->table_number,
                    'is_active' => $tableInactive->is_active,
                ] : null,
                'all_tables_for_store' => Table::where('store_id', $store->id)
                    ->where('type', $type)
                    ->get(['id', 'table_number', 'is_active'])
                    ->toArray(),
            ]);
            
            abort(404, 'Mesa/Habitación no encontrada o inactiva');
        }
        
        // Verificar si está activa
        if (!$table->is_active) {
            \Log::warning('Table found but inactive', [
                'table_id' => $table->id,
                'table_number' => $table->table_number,
                'is_active' => $table->is_active,
            ]);
            abort(404, 'Mesa/Habitación inactiva');
        }
        
        // Guardar en sesión para usar en checkout
        Session::put('dine_in_table_id', $table->id);
        Session::put('dine_in_table_number', $table->table_number);
        Session::put('dine_in_type', $type);
        
        // Obtener configuración de dine-in
        $dineInSettings = DineInSetting::getOrCreateForStore($store->id);
        
        // Verificar si está habilitado
        if (!$dineInSettings->is_enabled) {
            return view('tenant::dine-in.disabled', compact('store', 'table'));
        }
        
        // Redirigir al catálogo (el banner se mostrará desde la sesión)
        return redirect()->route('tenant.catalog', $store->slug);
    }

    /**
     * Mostrar checkout simplificado para mesa/habitación
     */
    public function checkout(Request $request)
    {
        $store = view()->shared('currentStore');
        
        // Obtener datos de sesión
        $tableId = Session::get('dine_in_table_id');
        $tableNumber = Session::get('dine_in_table_number');
        $type = Session::get('dine_in_type');
        
        if (!$tableId || !$tableNumber) {
            return redirect()->route('tenant.catalog', $store->slug)
                ->with('error', 'No se detectó una mesa/habitación activa. Por favor, escanea el QR nuevamente.');
        }
        
        // Recuperar la mesa
        $table = Table::find($tableId);
        if (!$table || $table->store_id !== $store->id) {
            return redirect()->route('tenant.catalog', $store->slug)
                ->with('error', 'Mesa/Habitación no válida.');
        }
        
        // Obtener configuración
        $dineInSettings = DineInSetting::getOrCreateForStore($store->id);
        
        // Obtener carrito de sesión
        $cartRaw = Session::get('cart', []);
        
        if (empty($cartRaw)) {
            return redirect()->route('tenant.cart.index', $store->slug)
                ->with('error', 'Tu carrito está vacío.');
        }
        
        // Procesar carrito y obtener productos completos (igual que OrderController@create)
        $cart = [];
        $subtotal = 0;
        
        foreach ($cartRaw as $item) {
            $product = \App\Features\TenantAdmin\Models\Product::where('id', $item['product_id'])
                ->where('store_id', $store->id)
                ->where('is_active', true)
                ->with('mainImage')
                ->first();
                
            if ($product) {
                // Formatear item igual que en OrderController
                $quantity = $item['quantity'] ?? 1;
                $price = $item['product_price'] ?? $item['price'] ?? $product->price;
                $itemTotal = $price * $quantity;
                
                $cart[] = [
                    'product_id' => $product->id,
                    'name' => $item['product_name'] ?? $product->name,
                    'price' => $price,
                    'quantity' => $quantity,
                    'item_total' => $itemTotal,
                    'image_url' => $item['image_url'] ?? $product->mainImage?->url ?? null,
                    'variants' => $item['variants'] ?? [],
                    'product' => $product, // Producto completo para referencia
                ];
                
                $subtotal += $itemTotal;
            }
        }
        
        // Si el carrito procesado está vacío, redirigir
        if (empty($cart)) {
            return redirect()->route('tenant.cart.index', $store->slug)
                ->with('error', 'No se encontraron productos válidos en tu carrito.');
        }
        
        // Calcular cargo de servicio si está habilitado
        $serviceCharge = 0;
        if ($dineInSettings->charge_service_fee) {
            if ($dineInSettings->service_fee_type === 'percentage') {
                $serviceCharge = $subtotal * ($dineInSettings->service_fee_percentage / 100);
            } else {
                $serviceCharge = $dineInSettings->service_fee_fixed;
            }
        }
        
        // Opciones de propina
        $tipOptions = $dineInSettings->tip_options ?? [0, 10, 15, 20];
        
        return view('tenant::dine-in.checkout', compact(
            'store',
            'table',
            'type',
            'cart',
            'subtotal',
            'serviceCharge',
            'dineInSettings',
            'tipOptions'
        ));
    }
}
