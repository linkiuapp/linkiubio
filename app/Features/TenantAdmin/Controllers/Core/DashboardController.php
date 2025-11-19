<?php

namespace App\Features\TenantAdmin\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shared\Models\Order;

class DashboardController extends Controller
{
    /**
     * Show the dashboard for store admin
     */
    public function index(Request $request)
    {
        // El middleware ya identificó la tienda
        $store = view()->shared('currentStore');
        
        // Verificar que el usuario autenticado sea admin de esta tienda
        if (!auth()->check() || 
            auth()->user()->role !== 'store_admin' || 
            auth()->user()->store_id !== $store->id) {
            return redirect()->route('tenant.admin.login', ['store' => $store->slug]);
        }

        $user = auth()->user();
        
        // Eager loading del plan
        $store->load('plan');
        
        // Obtener pedidos recientes - Sin caché porque son datos en tiempo real
        // Se filtrarán por tipo en el frontend con Alpine.js
        // Orden: más reciente primero (desc)
        $recentOrders = Order::where('store_id', $store->id)
            ->with(['items.product.mainImage'])
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($order) {
                return $this->mapOrder($order);
            });
        
        // Estadísticas con caché de 5 minutos
        $stats = \Cache::remember("tenant_dashboard_stats_{$store->id}", 300, function () use ($store) {
            // Obtener conteos por estado en una sola query optimizada
            $statusCounts = Order::select('status', \DB::raw('count(*) as count'))
                ->where('store_id', $store->id)
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();
            
            // Obtener conteos por tipo de orden
            $orderTypeCounts = Order::select('order_type', \DB::raw('count(*) as count'))
                ->where('store_id', $store->id)
                ->groupBy('order_type')
                ->pluck('count', 'order_type')
                ->toArray();
            
            $totalOrders = array_sum($statusCounts);
            $deliveredOrders = $statusCounts['delivered'] ?? 0;
            
            // Contar delivery (delivery + pickup)
            $deliveryCount = ($orderTypeCounts['delivery'] ?? 0) + ($orderTypeCounts['pickup'] ?? 0);
            $dineInCount = $orderTypeCounts['dine_in'] ?? 0;
            $roomServiceCount = $orderTypeCounts['room_service'] ?? 0;
            
            // Mesas activas (dine_in con status != delivered/cancelled)
            $activeDineIn = Order::byStore($store->id)
                ->dineIn()
                ->whereNotIn('status', ['delivered', 'cancelled'])
                ->count();
            
            // Habitaciones activas (room_service con status != delivered/cancelled)
            $activeRoomService = Order::byStore($store->id)
                ->roomService()
                ->whereNotIn('status', ['delivered', 'cancelled'])
                ->count();
            
            return [
                'total' => $totalOrders,
                'pending' => $statusCounts['pending'] ?? 0,
                'confirmed' => $statusCounts['confirmed'] ?? 0,
                'preparing' => $statusCounts['preparing'] ?? 0,
                'shipped' => $statusCounts['shipped'] ?? 0,
                'delivered' => $deliveredOrders,
                'cancelled' => $statusCounts['cancelled'] ?? 0,
                'total_revenue' => Order::byStore($store->id)
                    ->whereIn('status', ['delivered'])
                    ->sum('total'),
                'avg_order_value' => Order::byStore($store->id)
                    ->whereIn('status', ['delivered'])
                    ->avg('total') ?? 0,
                // Métricas adicionales
                'conversion_rate' => $totalOrders > 0 ? round(($deliveredOrders / $totalOrders) * 100, 1) : 0,
                'orders_today' => Order::byStore($store->id)
                    ->whereDate('created_at', today())
                    ->count(),
                'revenue_today' => Order::byStore($store->id)
                    ->whereDate('created_at', today())
                    ->whereIn('status', ['delivered'])
                    ->sum('total'),
                // Stats por tipo de orden (para tabs)
                'total_count' => $totalOrders,
                'delivery_count' => $deliveryCount,
                'dine_in_count' => $dineInCount,
                'room_service_count' => $roomServiceCount,
                // Stats activas
                'active_dine_in' => $activeDineIn,
                'active_room_service' => $activeRoomService,
            ];
        });
        
        // Agregar info del store y usuario (no cacheable)
        $stats['store_name'] = $store->name;
        $stats['plan_name'] = $store->plan->name;
        $stats['store_status'] = $store->status;
        $stats['store_verified'] = $store->verified;
        $stats['admin_name'] = $user->name;
        $stats['admin_email'] = $user->email;

        // Obtener todos los pedidos mezclados para la tabla única
        // Ordenar por prioridad: pendientes primero, luego por fecha (más recientes primero)
        $allOrders = Order::where('store_id', $store->id)
            ->with(['items.product.mainImage'])
            ->orderByRaw("CASE 
                WHEN status = 'pending' THEN 1 
                WHEN status = 'confirmed' THEN 2 
                WHEN status = 'preparing' THEN 3 
                WHEN status = 'shipped' THEN 4 
                WHEN status = 'delivered' THEN 5 
                WHEN status = 'cancelled' THEN 6 
                ELSE 99 
            END")
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($order) {
                return $this->mapOrder($order);
            });

        return view('tenant-admin::core.dashboard', compact('store', 'stats', 'allOrders'));
    }
    
    /**
     * Mapear orden a formato para frontend
     */
    private function mapOrder($order)
    {
        return [
            'id' => $order->id,
            'order_number' => $order->order_number,
            'customer_name' => $order->customer_name,
            'status' => $order->status,
            'order_type' => $order->order_type,
            'table_number' => $order->table_number,
            'room_number' => $order->room_number,
            'total' => $order->total,
            'created_at' => $order->created_at->toISOString(),
            'items' => $order->items->map(function ($item) {
                return [
                    'product_name' => $item->product_name,
                    'product' => $item->product ? [
                        'main_image' => $item->product->mainImage ? [
                            'image_url' => $item->product->mainImage->image_url
                        ] : null
                    ] : null
                ];
            })
        ];
    }
} 