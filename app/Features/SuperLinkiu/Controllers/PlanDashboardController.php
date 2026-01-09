<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\Plan;
use App\Shared\Models\Store;
use App\Shared\Models\Subscription;
use App\Shared\Models\Invoice;
use App\Services\PlanUsageService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlanDashboardController extends Controller
{
    protected PlanUsageService $usageService;

    public function __construct(PlanUsageService $usageService)
    {
        $this->usageService = $usageService;
    }

    /**
     * Dashboard principal de planes
     */
    public function index()
    {
        // Estadísticas generales
        $stats = $this->getGeneralStats();
        
        // Distribución de tiendas por plan
        $planDistribution = $this->getPlanDistribution();
        
        // Ingresos mensuales recurrentes (MRR) por plan
        $mrrByPlan = $this->getMRRByPlan();
        
        // Tendencia de ingresos últimos 6 meses
        $revenueTrend = $this->getRevenueTrend();
        
        // Tiendas cerca de límites
        $storesNearLimits = $this->getStoresNearLimits();
        
        // Planes más rentables
        $topPlans = $this->getTopPlans();
        
        // Conversiones trial -> pago
        $trialConversions = $this->getTrialConversions();

        return view('superlinkiu::plans.dashboard', compact(
            'stats',
            'planDistribution',
            'mrrByPlan',
            'revenueTrend',
            'storesNearLimits',
            'topPlans',
            'trialConversions'
        ));
    }

    /**
     * Estadísticas generales
     */
    private function getGeneralStats(): array
    {
        $totalPlans = Plan::count();
        $activePlans = Plan::where('is_active', true)->count();
        $totalStores = Store::where('status', 'active')->count();
        
        // MRR total
        $mrr = Subscription::where('status', 'active')
            ->sum('next_billing_amount');
        
        // ARR estimado
        $arr = $mrr * 12;
        
        // Tiendas en trial
        $storesInTrial = Subscription::where('status', 'active')
            ->whereNotNull('trial_end')
            ->where('trial_end', '>=', now())
            ->count();
        
        // Churn rate (cancelaciones últimos 30 días / total activos)
        $cancelledLast30 = Subscription::where('status', 'cancelled')
            ->where('cancelled_at', '>=', now()->subDays(30))
            ->count();
        $churnRate = $totalStores > 0 ? round(($cancelledLast30 / $totalStores) * 100, 2) : 0;

        return [
            'total_plans' => $totalPlans,
            'active_plans' => $activePlans,
            'total_stores' => $totalStores,
            'mrr' => $mrr,
            'arr' => $arr,
            'stores_in_trial' => $storesInTrial,
            'churn_rate' => $churnRate,
            'cancelled_last_30' => $cancelledLast30,
        ];
    }

    /**
     * Distribución de tiendas por plan
     */
    private function getPlanDistribution(): array
    {
        return Plan::withCount(['stores' => function($query) {
                $query->where('status', 'active');
            }])
            ->where('is_active', true)
            ->orderByDesc('stores_count')
            ->get()
            ->map(fn($plan) => [
                'name' => $plan->name,
                'count' => $plan->stores_count,
                'color' => $this->getPlanColor($plan->id),
            ])
            ->toArray();
    }

    /**
     * MRR por plan
     */
    private function getMRRByPlan(): array
    {
        return Plan::select('plans.id', 'plans.name')
            ->leftJoin('stores', 'stores.plan_id', '=', 'plans.id')
            ->leftJoin('subscriptions', 'subscriptions.store_id', '=', 'stores.id')
            ->where('plans.is_active', true)
            ->where('stores.status', 'active')
            ->where('subscriptions.status', 'active')
            ->groupBy('plans.id', 'plans.name')
            ->selectRaw('SUM(subscriptions.next_billing_amount) as mrr')
            ->orderByDesc('mrr')
            ->get()
            ->map(fn($plan) => [
                'name' => $plan->name,
                'mrr' => $plan->mrr ?? 0,
            ])
            ->toArray();
    }

    /**
     * Tendencia de ingresos últimos 6 meses
     */
    private function getRevenueTrend(): array
    {
        $months = collect();
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->format('Y-m');
            $label = $date->locale('es')->isoFormat('MMM YY');
            
            $revenue = Invoice::where('status', 'paid')
                ->whereYear('paid_date', $date->year)
                ->whereMonth('paid_date', $date->month)
                ->sum('amount');
            
            $months->push([
                'month' => $label,
                'revenue' => $revenue,
            ]);
        }
        
        return $months->toArray();
    }

    /**
     * Tiendas cerca de límites (para alertas)
     */
    private function getStoresNearLimits(int $threshold = 80): array
    {
        $alerts = [];
        
        $stores = Store::with('plan')
            ->where('status', 'active')
            ->get();
        
        foreach ($stores as $store) {
            if (!$store->plan) continue;
            
            $storeAlerts = [];
            
            // Verificar productos
            $products = $store->products()->count();
            $maxProducts = $store->plan->max_products ?? 999;
            $productPercent = $maxProducts > 0 ? ($products / $maxProducts) * 100 : 0;
            
            if ($productPercent >= $threshold) {
                $storeAlerts[] = [
                    'resource' => 'Productos',
                    'used' => $products,
                    'limit' => $maxProducts,
                    'percent' => round($productPercent),
                ];
            }
            
            // Verificar categorías
            $categories = $store->categories()->count();
            $maxCategories = $store->plan->max_categories ?? 999;
            $categoryPercent = $maxCategories > 0 ? ($categories / $maxCategories) * 100 : 0;
            
            if ($categoryPercent >= $threshold) {
                $storeAlerts[] = [
                    'resource' => 'Categorías',
                    'used' => $categories,
                    'limit' => $maxCategories,
                    'percent' => round($categoryPercent),
                ];
            }
            
            // Verificar ubicaciones
            $locations = $store->locations()->count();
            $maxLocations = $store->plan->max_sedes ?? 999;
            $locationPercent = $maxLocations > 0 ? ($locations / $maxLocations) * 100 : 0;
            
            if ($locationPercent >= $threshold) {
                $storeAlerts[] = [
                    'resource' => 'Sedes',
                    'used' => $locations,
                    'limit' => $maxLocations,
                    'percent' => round($locationPercent),
                ];
            }
            
            if (!empty($storeAlerts)) {
                $alerts[] = [
                    'store' => $store,
                    'alerts' => $storeAlerts,
                ];
            }
        }
        
        // Ordenar por porcentaje más alto
        usort($alerts, function($a, $b) {
            $maxA = max(array_column($a['alerts'], 'percent'));
            $maxB = max(array_column($b['alerts'], 'percent'));
            return $maxB <=> $maxA;
        });
        
        return array_slice($alerts, 0, 10); // Top 10
    }

    /**
     * Planes más rentables
     */
    private function getTopPlans(): array
    {
        return Plan::select('plans.*')
            ->selectRaw('COUNT(stores.id) as stores_count')
            ->selectRaw('COALESCE(SUM(subscriptions.next_billing_amount), 0) as total_mrr')
            ->leftJoin('stores', function($join) {
                $join->on('stores.plan_id', '=', 'plans.id')
                    ->where('stores.status', 'active');
            })
            ->leftJoin('subscriptions', function($join) {
                $join->on('subscriptions.store_id', '=', 'stores.id')
                    ->where('subscriptions.status', 'active');
            })
            ->where('plans.is_active', true)
            ->groupBy('plans.id')
            ->orderByDesc('total_mrr')
            ->limit(5)
            ->get()
            ->map(fn($plan) => [
                'id' => $plan->id,
                'name' => $plan->name,
                'price' => $plan->price,
                'stores_count' => $plan->stores_count,
                'mrr' => $plan->total_mrr,
            ])
            ->toArray();
    }

    /**
     * Conversiones de trial a pago
     */
    private function getTrialConversions(): array
    {
        // Trials que terminaron en últimos 90 días
        $endedTrials = Subscription::whereNotNull('trial_end')
            ->where('trial_end', '<=', now())
            ->where('trial_end', '>=', now()->subDays(90))
            ->count();
        
        // De esos, cuántos siguen activos (convertidos)
        $converted = Subscription::whereNotNull('trial_end')
            ->where('trial_end', '<=', now())
            ->where('trial_end', '>=', now()->subDays(90))
            ->where('status', 'active')
            ->count();
        
        // Actualmente en trial
        $currentTrials = Subscription::whereNotNull('trial_end')
            ->where('trial_end', '>=', now())
            ->where('status', 'active')
            ->count();
        
        $conversionRate = $endedTrials > 0 ? round(($converted / $endedTrials) * 100, 1) : 0;

        return [
            'ended_trials' => $endedTrials,
            'converted' => $converted,
            'current_trials' => $currentTrials,
            'conversion_rate' => $conversionRate,
        ];
    }

    /**
     * Color para cada plan (consistente)
     */
    private function getPlanColor(int $planId): string
    {
        $colors = [
            '#3b82f6', // blue
            '#22c55e', // green
            '#f59e0b', // amber
            '#ef4444', // red
            '#8b5cf6', // violet
            '#06b6d4', // cyan
            '#f97316', // orange
            '#ec4899', // pink
        ];
        
        return $colors[$planId % count($colors)];
    }
}
