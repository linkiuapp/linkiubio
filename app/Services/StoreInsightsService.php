<?php

namespace App\Services;

use App\Shared\Models\Store;
use App\Shared\Models\Order;
use App\Features\TenantAdmin\Models\Product;
use App\Features\TenantAdmin\Models\Category;
use App\Features\TenantAdmin\Models\Coupon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;

/**
 * StoreInsightsService - Análisis inteligente de datos de tienda
 * 
 * Genera alertas, sugerencias y métricas para ayudar al admin a crecer ventas.
 */
class StoreInsightsService
{
    protected Store $store;
    protected array $insights = [];

    public function __construct()
    {
        // Constructor vacío, se inicializa con setStore()
    }

    /**
     * Establecer la tienda a analizar
     */
    public function setStore(Store $store): self
    {
        $this->store = $store;
        return $this;
    }

    /**
     * Obtener todos los insights de la tienda
     */
    public function getAllInsights(): array
    {
        $cacheKey = "store_insights_{$this->store->id}";
        
        return Cache::remember($cacheKey, now()->addMinutes(30), function () {
            return [
                'alerts' => $this->getAlerts(),
                'opportunities' => $this->getOpportunities(),
                'performance' => $this->getPerformanceMetrics(),
                'seasonal' => $this->getSeasonalSuggestions(),
                'catalog' => $this->getCatalogOptimizations(),
                'goals' => $this->getGoalsAndComparisons(),
            ];
        });
    }

    /**
     * Invalidar cache de insights
     */
    public function clearCache(): void
    {
        Cache::forget("store_insights_{$this->store->id}");
    }

    // ==========================================
    // ALERTAS PROACTIVAS
    // ==========================================

    /**
     * Obtener alertas prioritarias
     */
    public function getAlerts(): array
    {
        $alerts = [];

        // 1. Productos sin stock
        $outOfStock = $this->getOutOfStockProducts();
        if ($outOfStock['count'] > 0) {
            $alerts[] = [
                'type' => 'warning',
                'priority' => 'high',
                'icon' => 'package-x',
                'title' => "Tienes {$outOfStock['count']} productos agotados",
                'message' => "Los clientes no pueden comprar estos productos. ¿Quieres ver cuáles son?",
                'action' => [
                    'label' => 'Ver productos',
                    'route' => 'tenant.admin.inventario.index',
                ],
                'data' => $outOfStock['products'],
            ];
        }

        // 2. Productos con stock bajo
        $lowStock = $this->getLowStockProducts();
        if ($lowStock['count'] > 0) {
            $alerts[] = [
                'type' => 'warning',
                'priority' => 'medium',
                'icon' => 'alert-triangle',
                'title' => "{$lowStock['count']} productos con stock bajo",
                'message' => "Estos productos podrían agotarse pronto.",
                'action' => [
                    'label' => 'Revisar stock',
                    'route' => 'tenant.admin.inventario.index',
                ],
                'data' => $lowStock['products'],
            ];
        }

        // 3. Pedidos pendientes sin atender
        $pendingOrders = $this->getPendingOrders();
        if ($pendingOrders['count'] > 0) {
            $alerts[] = [
                'type' => 'info',
                'priority' => 'high',
                'icon' => 'clock',
                'title' => "{$pendingOrders['count']} pedidos esperando confirmación",
                'message' => "Los clientes esperan que confirmes sus pedidos.",
                'action' => [
                    'label' => 'Ver pedidos',
                    'route' => 'tenant.admin.orders.index',
                ],
                'data' => $pendingOrders['orders'],
            ];
        }

        // 4. Cupones por vencer
        $expiringCoupons = $this->getExpiringCoupons();
        if ($expiringCoupons['count'] > 0) {
            $alerts[] = [
                'type' => 'info',
                'priority' => 'low',
                'icon' => 'ticket',
                'title' => "{$expiringCoupons['count']} cupones expiran pronto",
                'message' => "Considera promocionarlos antes de que venzan.",
                'action' => [
                    'label' => 'Ver cupones',
                    'route' => 'tenant.admin.coupons.index',
                ],
                'data' => $expiringCoupons['coupons'],
            ];
        }

        // 5. Sin pedidos en X días
        $daysSinceLastOrder = $this->getDaysSinceLastOrder();
        if ($daysSinceLastOrder > 7) {
            $alerts[] = [
                'type' => 'warning',
                'priority' => 'high',
                'icon' => 'trending-down',
                'title' => "Sin pedidos hace {$daysSinceLastOrder} días",
                'message' => "¿Te gustaría que te sugiera ideas para reactivar las ventas?",
                'action' => [
                    'label' => 'Ver sugerencias',
                    'type' => 'chat',
                    'prompt' => '¿Qué ideas de promoción me sugieres para reactivar ventas?',
                ],
            ];
        }

        // Ordenar por prioridad
        usort($alerts, function ($a, $b) {
            $priorities = ['high' => 0, 'medium' => 1, 'low' => 2];
            return ($priorities[$a['priority']] ?? 3) <=> ($priorities[$b['priority']] ?? 3);
        });

        return $alerts;
    }

    // ==========================================
    // ANÁLISIS INTELIGENTE DE DATOS
    // ==========================================

    /**
     * Obtener métricas de rendimiento
     */
    public function getPerformanceMetrics(): array
    {
        $now = Carbon::now();
        $startOfWeek = $now->copy()->startOfWeek();
        $startOfLastWeek = $now->copy()->subWeek()->startOfWeek();
        $endOfLastWeek = $now->copy()->subWeek()->endOfWeek();
        $startOfMonth = $now->copy()->startOfMonth();

        // Ventas esta semana
        $salesThisWeek = Order::where('store_id', $this->store->id)
            ->where('status', 'delivered')
            ->where('created_at', '>=', $startOfWeek)
            ->sum('total');

        // Ventas semana pasada
        $salesLastWeek = Order::where('store_id', $this->store->id)
            ->where('status', 'delivered')
            ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
            ->sum('total');

        // Ventas este mes
        $salesThisMonth = Order::where('store_id', $this->store->id)
            ->where('status', 'delivered')
            ->where('created_at', '>=', $startOfMonth)
            ->sum('total');

        // Pedidos esta semana
        $ordersThisWeek = Order::where('store_id', $this->store->id)
            ->where('created_at', '>=', $startOfWeek)
            ->count();

        // Pedidos semana pasada
        $ordersLastWeek = Order::where('store_id', $this->store->id)
            ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
            ->count();

        // Calcular cambio porcentual
        $salesChange = $salesLastWeek > 0 
            ? round((($salesThisWeek - $salesLastWeek) / $salesLastWeek) * 100, 1)
            : ($salesThisWeek > 0 ? 100 : 0);

        $ordersChange = $ordersLastWeek > 0 
            ? round((($ordersThisWeek - $ordersLastWeek) / $ordersLastWeek) * 100, 1)
            : ($ordersThisWeek > 0 ? 100 : 0);

        // Producto más vendido
        $topProduct = $this->getTopSellingProduct();

        // Hora pico
        $peakHour = $this->getPeakOrderHour();

        // Ticket promedio
        $avgTicket = Order::where('store_id', $this->store->id)
            ->where('status', 'delivered')
            ->where('created_at', '>=', $startOfMonth)
            ->avg('total') ?? 0;

        return [
            'sales' => [
                'this_week' => $salesThisWeek,
                'last_week' => $salesLastWeek,
                'this_month' => $salesThisMonth,
                'change_percent' => $salesChange,
                'trend' => $salesChange >= 0 ? 'up' : 'down',
            ],
            'orders' => [
                'this_week' => $ordersThisWeek,
                'last_week' => $ordersLastWeek,
                'change_percent' => $ordersChange,
                'trend' => $ordersChange >= 0 ? 'up' : 'down',
            ],
            'top_product' => $topProduct,
            'peak_hour' => $peakHour,
            'avg_ticket' => round($avgTicket, 0),
        ];
    }

    /**
     * Obtener producto más vendido
     */
    protected function getTopSellingProduct(): ?array
    {
        $startOfMonth = Carbon::now()->startOfMonth();

        $topProduct = \DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.store_id', $this->store->id)
            ->where('orders.status', 'delivered')
            ->where('orders.created_at', '>=', $startOfMonth)
            ->select('products.id', 'products.name', \DB::raw('SUM(order_items.quantity) as total_sold'), \DB::raw('SUM(order_items.item_total) as total_revenue'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->first();

        if (!$topProduct) {
            return null;
        }

        return [
            'id' => $topProduct->id,
            'name' => $topProduct->name,
            'units_sold' => $topProduct->total_sold,
            'revenue' => $topProduct->total_revenue,
        ];
    }

    /**
     * Obtener hora pico de pedidos
     */
    protected function getPeakOrderHour(): ?array
    {
        $last30Days = Carbon::now()->subDays(30);

        $peakHour = Order::where('store_id', $this->store->id)
            ->where('created_at', '>=', $last30Days)
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
            ->groupBy('hour')
            ->orderByDesc('count')
            ->first();

        if (!$peakHour) {
            return null;
        }

        $hour = $peakHour->hour;
        $nextHour = ($hour + 1) % 24;

        return [
            'hour' => $hour,
            'formatted' => sprintf('%d:00 - %d:00', $hour, $nextHour),
            'orders_count' => $peakHour->count,
        ];
    }

    // ==========================================
    // SUGERENCIAS DE MARKETING POR TEMPORADA
    // ==========================================

    /**
     * Obtener sugerencias estacionales
     */
    public function getSeasonalSuggestions(): array
    {
        $suggestions = [];
        $today = Carbon::now();
        $vertical = $this->store->vertical ?? 'ecommerce';

        // Definir fechas especiales (Colombia)
        $specialDates = [
            ['name' => 'San Valentín', 'date' => Carbon::create($today->year, 2, 14), 'days_before' => 14],
            ['name' => 'Día de la Mujer', 'date' => Carbon::create($today->year, 3, 8), 'days_before' => 7],
            ['name' => 'Día de la Madre', 'date' => $this->getMothersDayDate($today->year), 'days_before' => 14],
            ['name' => 'Día del Padre', 'date' => $this->getFathersDayDate($today->year), 'days_before' => 14],
            ['name' => 'Amor y Amistad', 'date' => Carbon::create($today->year, 9, 21), 'days_before' => 14],
            ['name' => 'Halloween', 'date' => Carbon::create($today->year, 10, 31), 'days_before' => 14],
            ['name' => 'Black Friday', 'date' => $this->getBlackFridayDate($today->year), 'days_before' => 7],
            ['name' => 'Navidad', 'date' => Carbon::create($today->year, 12, 25), 'days_before' => 21],
            ['name' => 'Año Nuevo', 'date' => Carbon::create($today->year + 1, 1, 1), 'days_before' => 7],
        ];

        foreach ($specialDates as $event) {
            $daysUntil = $today->diffInDays($event['date'], false);
            
            // Si la fecha ya pasó este año, saltar
            if ($daysUntil < 0) {
                continue;
            }

            // Si estamos dentro del rango de días antes
            if ($daysUntil <= $event['days_before']) {
                $suggestion = $this->generateSeasonalSuggestion($event['name'], $daysUntil, $vertical);
                if ($suggestion) {
                    $suggestions[] = $suggestion;
                }
            }
        }

        return $suggestions;
    }

    /**
     * Generar sugerencia específica para una fecha
     */
    protected function generateSeasonalSuggestion(string $eventName, int $daysUntil, string $vertical): ?array
    {
        $couponCode = strtoupper(str_replace(' ', '', $eventName)) . date('y');
        
        $templates = [
            'San Valentín' => [
                'icon' => 'heart',
                'color' => 'red',
                'message' => "San Valentín está a {$daysUntil} días. ¿Creamos una promoción romántica?",
                'suggestion' => "Crea un cupón '$couponCode' con 15% de descuento en productos para parejas.",
            ],
            'Día de la Madre' => [
                'icon' => 'gift',
                'color' => 'pink',
                'message' => "El Día de la Madre está a {$daysUntil} días. ¡Es una de las fechas más vendedoras!",
                'suggestion' => "Destaca productos de regalo y crea combos especiales.",
            ],
            'Black Friday' => [
                'icon' => 'percent',
                'color' => 'black',
                'message' => "Black Friday está a {$daysUntil} días. ¿Preparamos ofertas irresistibles?",
                'suggestion' => "Crea descuentos del 20-50% en productos seleccionados. Usa el cupón '$couponCode'.",
            ],
            'Navidad' => [
                'icon' => 'gift',
                'color' => 'green',
                'message' => "¡Navidad está a {$daysUntil} días! Es temporada alta de ventas.",
                'suggestion' => "Actualiza tu slider con temática navideña y ofrece envío gratis en compras mayores.",
            ],
        ];

        $template = $templates[$eventName] ?? [
            'icon' => 'calendar',
            'color' => 'blue',
            'message' => "$eventName está a {$daysUntil} días.",
            'suggestion' => "Considera crear una promoción especial con el código '$couponCode'.",
        ];

        return [
            'event' => $eventName,
            'days_until' => $daysUntil,
            'icon' => $template['icon'],
            'color' => $template['color'],
            'message' => $template['message'],
            'suggestion' => $template['suggestion'],
            'suggested_coupon' => $couponCode,
            'action' => [
                'label' => 'Crear cupón',
                'route' => 'tenant.admin.coupons.create',
            ],
        ];
    }

    // ==========================================
    // OPTIMIZACIÓN DE CATÁLOGO
    // ==========================================

    /**
     * Obtener oportunidades de optimización del catálogo
     */
    public function getCatalogOptimizations(): array
    {
        $optimizations = [];

        // 1. Productos sin imagen
        $noImage = Product::where('store_id', $this->store->id)
            ->where('is_active', true)
            ->whereDoesntHave('images')
            ->count();

        if ($noImage > 0) {
            $optimizations[] = [
                'type' => 'no_image',
                'icon' => 'image-off',
                'priority' => 'high',
                'count' => $noImage,
                'title' => "{$noImage} productos sin imagen",
                'message' => "Los productos con foto venden hasta 3 veces más.",
                'action' => [
                    'label' => 'Ver productos',
                    'route' => 'tenant.admin.products.index',
                ],
            ];
        }

        // 2. Productos con descripción muy corta
        $shortDesc = Product::where('store_id', $this->store->id)
            ->where('is_active', true)
            ->whereRaw('CHAR_LENGTH(description) < 50')
            ->count();

        if ($shortDesc > 0) {
            $optimizations[] = [
                'type' => 'short_description',
                'icon' => 'file-text',
                'priority' => 'medium',
                'count' => $shortDesc,
                'title' => "{$shortDesc} productos con descripción muy corta",
                'message' => "Las descripciones detalladas mejoran las ventas y el SEO.",
                'action' => [
                    'label' => 'Mejorar descripciones',
                    'route' => 'tenant.admin.products.index',
                ],
            ];
        }

        // 3. Productos sin categoría
        $noCategory = Product::where('store_id', $this->store->id)
            ->where('is_active', true)
            ->whereDoesntHave('categories')
            ->count();

        if ($noCategory > 0) {
            $optimizations[] = [
                'type' => 'no_category',
                'icon' => 'folder-x',
                'priority' => 'medium',
                'count' => $noCategory,
                'title' => "{$noCategory} productos sin categoría",
                'message' => "Los clientes no podrán encontrar estos productos navegando.",
                'action' => [
                    'label' => 'Asignar categorías',
                    'route' => 'tenant.admin.products.index',
                ],
            ];
        }

        // 4. Productos inactivos
        $inactive = Product::where('store_id', $this->store->id)
            ->where('is_active', false)
            ->count();

        if ($inactive > 0) {
            $optimizations[] = [
                'type' => 'inactive',
                'icon' => 'eye-off',
                'priority' => 'low',
                'count' => $inactive,
                'title' => "{$inactive} productos desactivados",
                'message' => "Revisa si alguno debería estar disponible.",
                'action' => [
                    'label' => 'Revisar productos',
                    'route' => 'tenant.admin.products.index',
                ],
            ];
        }

        // 5. Precios redondeados (oportunidad de pricing psicológico)
        $roundPrices = Product::where('store_id', $this->store->id)
            ->where('is_active', true)
            ->whereRaw('price = ROUND(price, -3)') // Precios múltiplos de 1000
            ->where('price', '>', 10000)
            ->count();

        if ($roundPrices > 3) {
            $optimizations[] = [
                'type' => 'round_prices',
                'icon' => 'dollar-sign',
                'priority' => 'low',
                'count' => $roundPrices,
                'title' => 'Oportunidad de pricing psicológico',
                'message' => "Precios como \$29.900 suelen vender mejor que \$30.000.",
                'action' => [
                    'label' => 'Ver productos',
                    'route' => 'tenant.admin.products.index',
                ],
            ];
        }

        return $optimizations;
    }

    // ==========================================
    // METAS Y COMPARATIVAS
    // ==========================================

    /**
     * Obtener metas y comparativas
     */
    public function getGoalsAndComparisons(): array
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        // Ventas este mes
        $salesThisMonth = Order::where('store_id', $this->store->id)
            ->where('status', 'delivered')
            ->where('created_at', '>=', $startOfMonth)
            ->sum('total');

        // Ventas mes pasado (completo)
        $salesLastMonth = Order::where('store_id', $this->store->id)
            ->where('status', 'delivered')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('total');

        // Pedidos este mes
        $ordersThisMonth = Order::where('store_id', $this->store->id)
            ->where('created_at', '>=', $startOfMonth)
            ->count();

        // Pedidos mes pasado
        $ordersLastMonth = Order::where('store_id', $this->store->id)
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->count();

        // Días transcurridos del mes
        $daysInMonth = $now->daysInMonth;
        $daysPassed = $now->day;
        $daysRemaining = $daysInMonth - $daysPassed;

        // Proyección del mes
        $projectedSales = $daysPassed > 0 
            ? round(($salesThisMonth / $daysPassed) * $daysInMonth, 0)
            : 0;

        // Meta sugerida (10% más que el mes pasado)
        $suggestedGoal = $salesLastMonth > 0 
            ? round($salesLastMonth * 1.1, 0)
            : $projectedSales;

        // Progreso hacia la meta
        $goalProgress = $suggestedGoal > 0 
            ? round(($salesThisMonth / $suggestedGoal) * 100, 1)
            : 0;

        // Cuánto falta para la meta
        $amountToGoal = max(0, $suggestedGoal - $salesThisMonth);

        // Pedidos necesarios para alcanzar meta (basado en ticket promedio)
        $avgTicket = Order::where('store_id', $this->store->id)
            ->where('status', 'delivered')
            ->where('created_at', '>=', $startOfMonth)
            ->avg('total') ?? 0;

        $ordersNeeded = $avgTicket > 0 
            ? ceil($amountToGoal / $avgTicket)
            : 0;

        return [
            'current_month' => [
                'sales' => $salesThisMonth,
                'orders' => $ordersThisMonth,
                'days_passed' => $daysPassed,
                'days_remaining' => $daysRemaining,
            ],
            'last_month' => [
                'sales' => $salesLastMonth,
                'orders' => $ordersLastMonth,
            ],
            'projection' => $projectedSales,
            'goal' => [
                'amount' => $suggestedGoal,
                'progress_percent' => $goalProgress,
                'amount_remaining' => $amountToGoal,
                'orders_needed' => $ordersNeeded,
            ],
            'comparison' => [
                'sales_change' => $salesLastMonth > 0 
                    ? round((($salesThisMonth - $salesLastMonth) / $salesLastMonth) * 100, 1)
                    : 0,
                'orders_change' => $ordersLastMonth > 0 
                    ? round((($ordersThisMonth - $ordersLastMonth) / $ordersLastMonth) * 100, 1)
                    : 0,
            ],
        ];
    }

    // ==========================================
    // OPORTUNIDADES DE CRECIMIENTO
    // ==========================================

    /**
     * Obtener oportunidades detectadas
     */
    public function getOpportunities(): array
    {
        $opportunities = [];

        // Productos destacados que no están en slider
        $topProduct = $this->getTopSellingProduct();
        if ($topProduct) {
            $opportunities[] = [
                'type' => 'highlight_bestseller',
                'icon' => 'trending-up',
                'message' => "'{$topProduct['name']}' es tu más vendido. ¿Quieres destacarlo en el slider?",
                'action' => [
                    'label' => 'Crear slider',
                    'route' => 'tenant.admin.sliders.create',
                ],
            ];
        }

        // Hora pico para promociones
        $peakHour = $this->getPeakOrderHour();
        if ($peakHour) {
            $opportunities[] = [
                'type' => 'peak_hour_promo',
                'icon' => 'clock',
                'message' => "Recibes más pedidos entre {$peakHour['formatted']}. Considera promociones en esas horas.",
            ];
        }

        return $opportunities;
    }

    // ==========================================
    // MÉTODOS AUXILIARES
    // ==========================================

    protected function getOutOfStockProducts(): array
    {
        $products = Product::where('store_id', $this->store->id)
            ->where('is_active', true)
            ->where('controla_stock', true)
            ->where('tipo_stock', 'limitado')
            ->where('cantidad_stock', '<=', 0)
            ->take(5)
            ->get(['id', 'name', 'sku']);

        return [
            'count' => Product::where('store_id', $this->store->id)
                ->where('is_active', true)
                ->where('controla_stock', true)
                ->where('tipo_stock', 'limitado')
                ->where('cantidad_stock', '<=', 0)
                ->count(),
            'products' => $products->toArray(),
        ];
    }

    protected function getLowStockProducts(): array
    {
        $products = Product::where('store_id', $this->store->id)
            ->where('is_active', true)
            ->where('controla_stock', true)
            ->where('tipo_stock', 'limitado')
            ->whereColumn('cantidad_stock', '<=', 'umbral_alerta_stock')
            ->where('cantidad_stock', '>', 0)
            ->take(5)
            ->get(['id', 'name', 'sku', 'cantidad_stock', 'umbral_alerta_stock']);

        return [
            'count' => Product::where('store_id', $this->store->id)
                ->where('is_active', true)
                ->where('controla_stock', true)
                ->where('tipo_stock', 'limitado')
                ->whereColumn('cantidad_stock', '<=', 'umbral_alerta_stock')
                ->where('cantidad_stock', '>', 0)
                ->count(),
            'products' => $products->toArray(),
        ];
    }

    protected function getPendingOrders(): array
    {
        $orders = Order::where('store_id', $this->store->id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->take(5)
            ->get(['id', 'order_number', 'customer_name', 'total', 'created_at']);

        return [
            'count' => Order::where('store_id', $this->store->id)
                ->where('status', 'pending')
                ->count(),
            'orders' => $orders->toArray(),
        ];
    }

    protected function getExpiringCoupons(): array
    {
        $coupons = Coupon::where('store_id', $this->store->id)
            ->where('is_active', true)
            ->whereNotNull('end_date')
            ->where('end_date', '<=', Carbon::now()->addDays(7))
            ->where('end_date', '>', Carbon::now())
            ->get(['id', 'code', 'end_date', 'current_uses']);

        return [
            'count' => $coupons->count(),
            'coupons' => $coupons->toArray(),
        ];
    }

    protected function getDaysSinceLastOrder(): int
    {
        $lastOrder = Order::where('store_id', $this->store->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$lastOrder) {
            return 999; // Nunca ha tenido pedidos
        }

        return Carbon::now()->diffInDays($lastOrder->created_at);
    }

    // Calcular Día de la Madre (segundo domingo de mayo)
    protected function getMothersDayDate(int $year): Carbon
    {
        $may = Carbon::create($year, 5, 1);
        $firstSunday = $may->copy()->next(Carbon::SUNDAY);
        return $firstSunday->addWeek();
    }

    // Calcular Día del Padre (tercer domingo de junio)
    protected function getFathersDayDate(int $year): Carbon
    {
        $june = Carbon::create($year, 6, 1);
        $firstSunday = $june->copy()->next(Carbon::SUNDAY);
        return $firstSunday->addWeeks(2);
    }

    // Calcular Black Friday (cuarto viernes de noviembre)
    protected function getBlackFridayDate(int $year): Carbon
    {
        $november = Carbon::create($year, 11, 1);
        $firstFriday = $november->dayOfWeek === Carbon::FRIDAY 
            ? $november 
            : $november->next(Carbon::FRIDAY);
        return $firstFriday->addWeeks(3);
    }
}

