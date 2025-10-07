<?php

namespace App\Features\TenantAdmin\Controllers;

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
        
        // Obtener pedidos recientes (últimos 5) - Sin caché porque son datos en tiempo real
        $recentOrders = Order::where('store_id', $store->id)
            ->with(['items.product.mainImage'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Estadísticas con caché de 5 minutos
        $stats = \Cache::remember("tenant_dashboard_stats_{$store->id}", 300, function () use ($store) {
            // Obtener conteos por estado en una sola query optimizada
            $statusCounts = Order::select('status', \DB::raw('count(*) as count'))
                ->where('store_id', $store->id)
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();
            
            $totalOrders = array_sum($statusCounts);
            $deliveredOrders = $statusCounts['delivered'] ?? 0;
            
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
            ];
        });
        
        // Agregar info del store y usuario (no cacheable)
        $stats['store_name'] = $store->name;
        $stats['plan_name'] = $store->plan->name;
        $stats['store_status'] = $store->status;
        $stats['store_verified'] = $store->verified;
        $stats['admin_name'] = $user->name;
        $stats['admin_email'] = $user->email;

        return view('tenant-admin::dashboard', compact('store', 'stats', 'recentOrders'));
    }
} 