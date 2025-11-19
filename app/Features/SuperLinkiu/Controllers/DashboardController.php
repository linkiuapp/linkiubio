<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\Store;
use App\Shared\Models\Plan;
use App\Shared\Models\StorePlanExtension;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas generales con caché de 5 minutos
        $stats = Cache::remember('dashboard_stats', 300, function () {
            $totalStores = Store::count();
            $activeStores = Store::where('status', 'active')->count();
            
            return [
                'total_stores' => $totalStores,
                'active_stores' => $activeStores,
                'verified_stores' => Store::where('verified', true)->count(),
                'suspended_stores' => Store::where('status', 'suspended')->count(),
                'active_percentage' => $totalStores > 0 
                    ? round(($activeStores / $totalStores) * 100, 1) 
                    : 0
            ];
        });
        
        // ✅ Estadísticas de solicitudes de tiendas (sin caché para datos en tiempo real)
        $pendingRequests = Store::where('approval_status', 'pending_approval')->get();
        $pendingStats = [
            'total' => $pendingRequests->count(),
            'critical' => $pendingRequests->filter(fn($s) => $s->created_at->diffInHours(now()) > 24)->count(),
            'urgent' => $pendingRequests->filter(fn($s) => $s->created_at->diffInHours(now()) > 6 && $s->created_at->diffInHours(now()) <= 24)->count(),
            'normal' => $pendingRequests->filter(fn($s) => $s->created_at->diffInHours(now()) <= 6)->count(),
            'avg_hours' => $pendingRequests->count() > 0 
                ? round($pendingRequests->avg(fn($s) => $s->created_at->diffInHours(now())), 1) 
                : 0,
            'oldest' => $pendingRequests->sortBy('created_at')->first()
        ];

        // Estadísticas por plan
        $storesByPlan = Store::select('plan_id', DB::raw('count(*) as total'))
            ->with('plan:id,name')
            ->groupBy('plan_id')
            ->get()
            ->map(function ($item) {
                return [
                    'plan' => $item->plan->name ?? 'Sin plan',
                    'total' => $item->total,
                    'color' => $this->getPlanColor($item->plan->name ?? '')
                ];
            });

        // Ingresos del mes (simulado por ahora)
        $monthlyRevenue = Store::where('status', 'active')
            ->whereHas('plan', function($q) {
                $q->where('price', '>', 0);
            })
            ->with('plan:id,price')
            ->get()
            ->sum(function($store) {
                return $store->plan->price ?? 0;
            });

        // Comparación con mes anterior (simulado)
        $previousMonthRevenue = $monthlyRevenue * 0.85; // Simulamos 15% menos
        $revenueGrowth = $previousMonthRevenue > 0 
            ? round((($monthlyRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100, 1)
            : 0;

        // Alertas de monitoreo
        $alerts = [];

        // Planes por vencer en los próximos 7 días
        $expiringPlans = StorePlanExtension::with(['store', 'plan'])
            ->where('end_date', '>=', now())
            ->where('end_date', '<=', now()->addDays(7))
            ->orderBy('end_date')
            ->limit(5)
            ->get();

        if ($expiringPlans->count() > 0) {
            $alerts[] = [
                'type' => 'warning',
                'icon' => 'solar-calendar-mark-outline',
                'title' => 'Planes por vencer',
                'message' => $expiringPlans->count() . ' planes vencerán en los próximos 7 días',
                'items' => $expiringPlans->map(function($extension) {
                    return [
                        'store' => $extension->store->name,
                        'plan' => $extension->plan->name,
                        'days' => now()->diffInDays($extension->end_date)
                    ];
                })
            ];
        }

        // Tiendas sin actividad (más de 30 días)
        $inactiveStores = Store::where('status', 'active')
            ->where(function($query) {
                $query->whereNull('last_active_at')
                      ->orWhere('last_active_at', '<', now()->subDays(30));
            })
            ->count();

        if ($inactiveStores > 0) {
            $alerts[] = [
                'type' => 'info',
                'icon' => 'solar-moon-sleep-outline',
                'title' => 'Tiendas inactivas',
                'message' => $inactiveStores . ' tiendas sin actividad en los últimos 30 días',
                'action' => route('superlinkiu.stores.index', ['status' => 'inactive'])
            ];
        }

        // Errores detectados (por ahora simulamos)
        $errorCount = 0; // En el futuro esto vendría de un sistema de logs
        if ($errorCount > 0) {
            $alerts[] = [
                'type' => 'error',
                'icon' => 'solar-danger-triangle-outline',
                'title' => 'Errores detectados',
                'message' => $errorCount . ' errores en las últimas 24 horas',
                'action' => '#' // Futura página de logs
            ];
        }

        // Datos para gráfico de crecimiento mensual (últimos 6 meses)
        $monthlyGrowth = $this->getMonthlyGrowthData();
        
        // Preparar datos para Chart.js - Crecimiento Mensual
        $growthChartData = [
            'labels' => array_column($monthlyGrowth, 'month'),
            'datasets' => [[
                'label' => 'Tiendas Nuevas',
                'data' => array_column($monthlyGrowth, 'count'),
                'borderColor' => '#7432F8',
                'backgroundColor' => 'rgba(116, 50, 248, 0.1)',
                'borderWidth' => 3,
                'fill' => true,
                'tension' => 0.4,
                'pointBackgroundColor' => '#7432F8',
                'pointBorderColor' => '#fff',
                'pointBorderWidth' => 2,
                'pointRadius' => 6,
                'pointHoverRadius' => 8
            ]]
        ];
        
        // Preparar datos para Chart.js - Distribución por Plan
        $planChartData = [
            'labels' => $storesByPlan->pluck('plan')->toArray(),
            'datasets' => [[
                'data' => $storesByPlan->pluck('total')->toArray(),
                'backgroundColor' => $storesByPlan->pluck('color')->toArray(),
                'borderWidth' => 0
            ]]
        ];

        // Últimas tiendas creadas
        $latestStores = Store::with('plan')
            ->latest()
            ->limit(10)
            ->get();

        return view('superlinkiu::dashboard', compact(
            'stats',
            'pendingStats',
            'storesByPlan',
            'monthlyRevenue',
            'revenueGrowth',
            'alerts',
            'monthlyGrowth',
            'latestStores',
            'growthChartData',
            'planChartData'
        ));
    }

    private function getMonthlyGrowthData()
    {
        $data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = Store::whereYear('created_at', $date->year)
                         ->whereMonth('created_at', $date->month)
                         ->count();
            
            $data[] = [
                'month' => $date->format('M'),
                'year' => $date->format('Y'),
                'count' => $count
            ];
        }

        return $data;
    }

    private function getPlanColor($planName)
    {
        $colors = [
            'Explorer' => '#73FFC2', // success
            'Master' => '#B48FFF',   // primary
            'Legend' => '#FFAD75',   // secondary
        ];

        return $colors[$planName] ?? '#8385FF'; // info por defecto
    }
} 