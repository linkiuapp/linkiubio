<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\Store;
use App\Shared\Models\Order;
use App\Shared\Models\OrderItem;
use App\Features\TenantAdmin\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StoreStatisticsController extends Controller
{
    /**
     * Mostrar lista de tiendas con estadísticas
     */
    public function index(Request $request)
    {
        $query = Store::query();

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('plan_id')) {
            $query->where('plan_id', $request->plan_id);
        }

        // Rango de fechas para estadísticas
        $dateFrom = $request->filled('date_from') 
            ? Carbon::parse($request->date_from)->startOfDay()
            : Carbon::now()->subMonths(3)->startOfDay();
        
        $dateTo = $request->filled('date_to')
            ? Carbon::parse($request->date_to)->endOfDay()
            : Carbon::now()->endOfDay();

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        
        $validSortFields = ['name', 'created_at'];
        if (!in_array($sortBy, $validSortFields)) {
            $sortBy = 'name';
        }
        
        $query->orderBy($sortBy, $sortOrder);

        // Obtener tiendas paginadas
        $stores = $query->with('plan')->paginate(20)->withQueryString();

        // Calcular estadísticas para cada tienda
        $storeStats = [];
        foreach ($stores as $store) {
            $storeStats[$store->id] = $this->calculateStoreStatistics($store->id, $dateFrom, $dateTo);
        }

        // Calcular resumen general
        $summaryStats = $this->calculateSummaryStatistics($dateFrom, $dateTo);

        // Obtener planes para filtro
        $plans = \App\Shared\Models\Plan::active()->get();

        return view('superlinkiu::store-statistics.index', compact(
            'stores',
            'storeStats',
            'summaryStats',
            'plans',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Mostrar estadísticas detalladas de una tienda
     */
    public function show(Request $request, Store $store)
    {
        // Rango de fechas
        $dateFrom = $request->filled('date_from') 
            ? Carbon::parse($request->date_from)->startOfDay()
            : Carbon::now()->subMonths(6)->startOfDay();
        
        $dateTo = $request->filled('date_to')
            ? Carbon::parse($request->date_to)->endOfDay()
            : Carbon::now()->endOfDay();

        // Estadísticas generales
        $stats = $this->calculateStoreStatistics($store->id, $dateFrom, $dateTo);

        // Gráfico de ventas mensuales
        $monthlySales = $this->getMonthlySales($store->id, $dateFrom, $dateTo);

        // Gráfico de ingresos mensuales
        $monthlyRevenue = $this->getMonthlyRevenue($store->id, $dateFrom, $dateTo);

        // Top productos vendidos
        $topProducts = $this->getTopProducts($store->id, $dateFrom, $dateTo, 10);

        // Distribución por categorías
        $categoryDistribution = $this->getCategoryDistribution($store->id, $dateFrom, $dateTo);

        // Ingresos por tipo de entrega
        $revenueByDeliveryType = $this->getRevenueByDeliveryType($store->id, $dateFrom, $dateTo);

        // Tendencias (comparación con período anterior)
        $previousPeriodStats = $this->calculateStoreStatistics(
            $store->id,
            $dateFrom->copy()->subMonths($dateFrom->diffInMonths($dateTo)),
            $dateFrom->copy()->subDay()
        );

        return view('superlinkiu::store-statistics.show', compact(
            'store',
            'stats',
            'monthlySales',
            'monthlyRevenue',
            'topProducts',
            'categoryDistribution',
            'revenueByDeliveryType',
            'previousPeriodStats',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Calcular estadísticas de una tienda
     */
    private function calculateStoreStatistics(int $storeId, Carbon $dateFrom, Carbon $dateTo): array
    {
        // Productos creados (total activos)
        $productsCreated = Product::where('store_id', $storeId)
            ->where('is_active', true)
            ->count();

        // Productos vendidos (productos únicos que tienen al menos una venta completada)
        $productsSold = OrderItem::whereHas('order', function($query) use ($storeId, $dateFrom, $dateTo) {
                $query->where('store_id', $storeId)
                      ->where('status', 'delivered')
                      ->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->distinct('product_id')
            ->count('product_id');

        // Ventas totales (pedidos completados)
        $totalSales = Order::where('store_id', $storeId)
            ->where('status', 'delivered')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->count();

        // Ingresos totales
        $totalRevenue = Order::where('store_id', $storeId)
            ->where('status', 'delivered')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->sum('total');

        // Ingresos por domicilios (order_type = 'delivery' o delivery_type = 'domicilio')
        $deliveryRevenue = Order::where('store_id', $storeId)
            ->where('status', 'delivered')
            ->where(function($query) {
                $query->where('order_type', 'delivery')
                      ->orWhere('delivery_type', 'domicilio');
            })
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->sum('total');

        // Cantidad de pedidos por domicilio
        $deliveryOrders = Order::where('store_id', $storeId)
            ->where('status', 'delivered')
            ->where(function($query) {
                $query->where('order_type', 'delivery')
                      ->orWhere('delivery_type', 'domicilio');
            })
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->count();

        // Métricas adicionales
        $conversionRate = $productsCreated > 0 
            ? round(($productsSold / $productsCreated) * 100, 2) 
            : 0;

        $averageTicket = $totalSales > 0 
            ? round($totalRevenue / $totalSales, 2) 
            : 0;

        $averageDeliveryTicket = $deliveryOrders > 0 
            ? round($deliveryRevenue / $deliveryOrders, 2) 
            : 0;

        return [
            'products_created' => $productsCreated,
            'products_sold' => $productsSold,
            'total_sales' => $totalSales,
            'total_revenue' => $totalRevenue,
            'delivery_revenue' => $deliveryRevenue,
            'delivery_orders' => $deliveryOrders,
            'conversion_rate' => $conversionRate,
            'average_ticket' => $averageTicket,
            'average_delivery_ticket' => $averageDeliveryTicket,
        ];
    }

    /**
     * Calcular estadísticas generales (resumen)
     */
    private function calculateSummaryStatistics(Carbon $dateFrom, Carbon $dateTo): array
    {
        // Productos creados totales
        $totalProductsCreated = Product::where('is_active', true)
            ->count();

        // Productos vendidos únicos (across all stores)
        $totalProductsSold = OrderItem::whereHas('order', function($query) use ($dateFrom, $dateTo) {
                $query->where('status', 'delivered')
                      ->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->distinct('product_id')
            ->count('product_id');

        // Ventas totales
        $totalSales = Order::where('status', 'delivered')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->count();

        // Ingresos totales
        $totalRevenue = Order::where('status', 'delivered')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->sum('total');

        // Ingresos por domicilios
        $totalDeliveryRevenue = Order::where('status', 'delivered')
            ->where(function($query) {
                $query->where('order_type', 'delivery')
                      ->orWhere('delivery_type', 'domicilio');
            })
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->sum('total');

        // Pedidos por domicilio
        $totalDeliveryOrders = Order::where('status', 'delivered')
            ->where(function($query) {
                $query->where('order_type', 'delivery')
                      ->orWhere('delivery_type', 'domicilio');
            })
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->count();

        return [
            'total_products_created' => $totalProductsCreated,
            'total_products_sold' => $totalProductsSold,
            'total_sales' => $totalSales,
            'total_revenue' => $totalRevenue,
            'total_delivery_revenue' => $totalDeliveryRevenue,
            'total_delivery_orders' => $totalDeliveryOrders,
        ];
    }

    /**
     * Obtener ventas mensuales para gráfico
     */
    private function getMonthlySales(int $storeId, Carbon $dateFrom, Carbon $dateTo): array
    {
        $sales = Order::where('store_id', $storeId)
            ->where('status', 'delivered')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return [
            'labels' => $sales->pluck('month')->toArray(),
            'data' => $sales->pluck('count')->toArray(),
        ];
    }

    /**
     * Obtener ingresos mensuales para gráfico
     */
    private function getMonthlyRevenue(int $storeId, Carbon $dateFrom, Carbon $dateTo): array
    {
        $revenue = Order::where('store_id', $storeId)
            ->where('status', 'delivered')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(total) as total')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return [
            'labels' => $revenue->pluck('month')->toArray(),
            'data' => $revenue->pluck('total')->toArray(),
        ];
    }

    /**
     * Obtener top productos vendidos
     */
    private function getTopProducts(int $storeId, Carbon $dateFrom, Carbon $dateTo, int $limit = 10): array
    {
        $topProducts = OrderItem::whereHas('order', function($query) use ($storeId, $dateFrom, $dateTo) {
                $query->where('store_id', $storeId)
                      ->where('status', 'delivered')
                      ->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->select(
                'product_id',
                'product_name',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('SUM(item_total) as total_revenue')
            )
            ->groupBy('product_id', 'product_name')
            ->orderBy('total_quantity', 'desc')
            ->limit($limit)
            ->get();

        return $topProducts->map(function($item) {
            return [
                'product_id' => $item->product_id,
                'product_name' => $item->product_name,
                'total_quantity' => $item->total_quantity,
                'total_revenue' => $item->total_revenue,
            ];
        })->toArray();
    }

    /**
     * Obtener distribución por categorías
     */
    private function getCategoryDistribution(int $storeId, Carbon $dateFrom, Carbon $dateTo): array
    {
        $distribution = OrderItem::whereHas('order', function($query) use ($storeId, $dateFrom, $dateTo) {
                $query->where('store_id', $storeId)
                      ->where('status', 'delivered')
                      ->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('product_categories', 'products.id', '=', 'product_categories.product_id')
            ->join('categories', 'product_categories.category_id', '=', 'categories.id')
            ->where('categories.store_id', $storeId) // Asegurar que las categorías pertenecen a la tienda
            ->select(
                'categories.id',
                'categories.name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.item_total) as total_revenue')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_quantity', 'desc')
            ->get();

        return $distribution->map(function($item) {
            return [
                'category_id' => $item->id,
                'category_name' => $item->name,
                'total_quantity' => $item->total_quantity,
                'total_revenue' => $item->total_revenue,
            ];
        })->toArray();
    }

    /**
     * Obtener ingresos por tipo de entrega
     */
    private function getRevenueByDeliveryType(int $storeId, Carbon $dateFrom, Carbon $dateTo): array
    {
        $revenue = Order::where('store_id', $storeId)
            ->where('status', 'delivered')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->select(
                'order_type',
                'delivery_type',
                DB::raw('COUNT(*) as orders_count'),
                DB::raw('SUM(total) as total_revenue')
            )
            ->groupBy('order_type', 'delivery_type')
            ->get();

        $result = [
            'delivery' => ['orders' => 0, 'revenue' => 0],
            'pickup' => ['orders' => 0, 'revenue' => 0],
            'dine_in' => ['orders' => 0, 'revenue' => 0],
            'room_service' => ['orders' => 0, 'revenue' => 0],
        ];

        foreach ($revenue as $item) {
            $type = $item->order_type ?? $item->delivery_type ?? 'pickup';
            
            if (isset($result[$type])) {
                $result[$type]['orders'] += $item->orders_count;
                $result[$type]['revenue'] += $item->total_revenue;
            }
        }

        return $result;
    }
}
