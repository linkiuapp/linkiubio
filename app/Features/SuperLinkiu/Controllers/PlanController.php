<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = Plan::withCount('stores')
            ->orderBy('sort_order')
            ->orderBy('created_at')
            ->paginate(10);
            
        return view('superlinkiu::plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superlinkiu::plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:plans,name,NULL,id,deleted_at,NULL',
            'description' => 'nullable|string',
            'allow_custom_slug' => 'boolean',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'duration_in_days' => 'required|integer|min:1',
            
            // Imagen del plan
            'plan_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            
            // Precios por período con descuentos
            'prices.monthly' => 'nullable|numeric|min:0',
            'prices.quarterly' => 'nullable|numeric|min:0',
            'prices.semester' => 'nullable|numeric|min:0',
            'prices.annual' => 'nullable|numeric|min:0',
            
            // PRODUCTOS Y CATÁLOGO
            'max_products' => 'required|integer|min:1',
            'max_categories' => 'required|integer|min:1',
            'max_variables' => 'required|integer|min:1',
            'max_product_images' => 'required|integer|min:1',
            
            // DISEÑO Y MARKETING
            'max_slider' => 'required|integer|min:0',
            'max_active_coupons' => 'required|integer|min:0',
            
            // ENVÍOS Y LOGÍSTICA
            'max_sedes' => 'required|integer|min:1',
            'max_delivery_zones' => 'required|integer|min:1',
            
            // PAGOS
            'max_payment_methods' => 'required|integer|min:1',
            'max_bank_accounts' => 'required|integer|min:1',
            
            // ADMINISTRACIÓN
            'max_admins' => 'required|integer|min:1',
            'max_tickets_per_month' => 'required|integer|min:1',
            'order_history_months' => 'required|integer|min:1',
            'analytics_retention_days' => 'required|integer|min:30',
            
            // INVENTARIO
            'inventory_tracking' => 'boolean',
            
            // INTEGRACIONES
            'whatsapp_integration' => 'boolean',
            'kiubot_enabled' => 'boolean',
            
            // PERÍODO DE PRUEBA
            'trial_days' => 'nullable|integer|min:0|max:90',
            'skip_payment_on_trial' => 'boolean',
            
            // LÍMITES VERTICAL RESTAURANT
            'max_tables' => 'nullable|integer|min:0',
            'max_daily_reservations' => 'nullable|integer|min:0',
            
            // LÍMITES VERTICAL HOTEL
            'max_rooms' => 'nullable|integer|min:0',
            'max_room_types' => 'nullable|integer|min:0',
            'max_daily_hotel_reservations' => 'nullable|integer|min:0',
            
            // SOPORTE
            'support_level' => 'required|in:basic,priority,premium',
            'support_response_time' => 'required|integer|min:1',
            
            // CONFIGURACIÓN
            'is_active' => 'boolean',
            'is_public' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer',
            
            // CARACTERÍSTICAS
            'features_list' => 'nullable|array',
            'features_list.*' => 'string',
        ]);

        // Preparar datos booleanos
        $validated['allow_custom_slug'] = $request->boolean('allow_custom_slug');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_public'] = $request->boolean('is_public');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['inventory_tracking'] = $request->boolean('inventory_tracking', true);
        $validated['whatsapp_integration'] = $request->boolean('whatsapp_integration', false);
        $validated['kiubot_enabled'] = $request->boolean('kiubot_enabled', false);
        $validated['skip_payment_on_trial'] = $request->boolean('skip_payment_on_trial', false);
        $validated['version'] = '1.0';
        
        // Asegurar valores por defecto si vienen vacíos
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['trial_days'] = $validated['trial_days'] ?? 0;
        
        // Manejar subida de imagen
        if ($request->hasFile('plan_image')) {
            $destinationPath = public_path('storage/plans/images');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $filename = 'plan_' . time() . '.' . $request->file('plan_image')->getClientOriginalExtension();
            $request->file('plan_image')->move($destinationPath, $filename);
            $validated['image_url'] = asset('storage/plans/images/' . $filename);
        }
        
        // Preparar precios
        if (isset($validated['prices'])) {
            $validated['prices'] = array_filter($validated['prices'], function($price) {
                return $price !== null && $price !== '';
            });
        }

        // Filtrar características vacías
        if (isset($validated['features_list'])) {
            $validated['features_list'] = array_values(array_filter($validated['features_list'], function($feature) {
                return !empty(trim($feature));
            }));
        }

        // Remover plan_image del array ya que se procesó como image_url
        unset($validated['plan_image']);

        Plan::create($validated);

        return redirect()
            ->route('superlinkiu.plans.index')
            ->with('success', 'Plan creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        $plan->loadCount('stores');
        
        // Calcular ingresos del plan
        $planRevenue = $this->calculatePlanRevenue($plan);
        
        return view('superlinkiu::plans.show', compact('plan', 'planRevenue'));
    }
    
    /**
     * Calcular ingresos de un plan
     */
    private function calculatePlanRevenue(Plan $plan): array
    {
        // MRR del plan
        $mrr = \App\Shared\Models\Subscription::whereHas('store', function($q) use ($plan) {
                $q->where('plan_id', $plan->id)->where('status', 'active');
            })
            ->where('status', 'active')
            ->sum('next_billing_amount');
        
        // Ingresos históricos (facturas pagadas)
        $historicRevenue = \App\Shared\Models\Invoice::whereHas('store', function($q) use ($plan) {
                $q->where('plan_id', $plan->id);
            })
            ->where('status', 'paid')
            ->sum('amount');
        
        // Ingresos últimos 30 días
        $last30Days = \App\Shared\Models\Invoice::whereHas('store', function($q) use ($plan) {
                $q->where('plan_id', $plan->id);
            })
            ->where('status', 'paid')
            ->where('paid_date', '>=', now()->subDays(30))
            ->sum('amount');
        
        // Tiendas en trial
        $storesInTrial = \App\Shared\Models\Subscription::whereHas('store', function($q) use ($plan) {
                $q->where('plan_id', $plan->id)->where('status', 'active');
            })
            ->whereNotNull('trial_end')
            ->where('trial_end', '>=', now())
            ->count();
        
        return [
            'mrr' => $mrr,
            'arr' => $mrr * 12,
            'historic_revenue' => $historicRevenue,
            'last_30_days' => $last30Days,
            'stores_in_trial' => $storesInTrial,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        return view('superlinkiu::plans.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:plans,name,' . $plan->id . ',id,deleted_at,NULL',
            'description' => 'nullable|string',
            'allow_custom_slug' => 'boolean',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'duration_in_days' => 'required|integer|min:1',
            
            // Precios por período
            'prices.monthly' => 'nullable|numeric|min:0',
            'prices.quarterly' => 'nullable|numeric|min:0',
            'prices.semester' => 'nullable|numeric|min:0',
            'prices.annual' => 'nullable|numeric|min:0',
            
            // PRODUCTOS Y CATÁLOGO
            'max_products' => 'required|integer|min:1',
            'max_categories' => 'required|integer|min:1',
            'max_variables' => 'required|integer|min:1',
            'max_product_images' => 'required|integer|min:1',
            
            // DISEÑO Y MARKETING
            'max_slider' => 'required|integer|min:0',
            'max_active_coupons' => 'required|integer|min:0',
            
            // ENVÍOS Y LOGÍSTICA
            'max_sedes' => 'required|integer|min:1',
            'max_delivery_zones' => 'required|integer|min:1',
            
            // PAGOS
            'max_payment_methods' => 'required|integer|min:1',
            'max_bank_accounts' => 'required|integer|min:1',
            
            // ADMINISTRACIÓN
            'max_admins' => 'required|integer|min:1',
            'max_tickets_per_month' => 'required|integer|min:1',
            'order_history_months' => 'required|integer|min:1',
            'analytics_retention_days' => 'required|integer|min:30',
            
            // INVENTARIO
            'inventory_tracking' => 'boolean',
            
            // INTEGRACIONES
            'whatsapp_integration' => 'boolean',
            'kiubot_enabled' => 'boolean',
            
            // PERÍODO DE PRUEBA
            'trial_days' => 'nullable|integer|min:0|max:90',
            'skip_payment_on_trial' => 'boolean',
            
            // LÍMITES VERTICAL RESTAURANT
            'max_tables' => 'nullable|integer|min:0',
            'max_daily_reservations' => 'nullable|integer|min:0',
            
            // LÍMITES VERTICAL HOTEL
            'max_rooms' => 'nullable|integer|min:0',
            'max_room_types' => 'nullable|integer|min:0',
            'max_daily_hotel_reservations' => 'nullable|integer|min:0',
            
            // SOPORTE
            'support_level' => 'required|in:basic,priority,premium',
            'support_response_time' => 'required|integer|min:1',
            
            // CONFIGURACIÓN
            'is_active' => 'boolean',
            'is_public' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer',
            
            // CARACTERÍSTICAS
            'features_list' => 'nullable|array',
            'features_list.*' => 'string',
        ]);

        // Preparar datos booleanos
        $validated['allow_custom_slug'] = $request->boolean('allow_custom_slug');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_public'] = $request->boolean('is_public');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['inventory_tracking'] = $request->boolean('inventory_tracking', true);
        $validated['whatsapp_integration'] = $request->boolean('whatsapp_integration', false);
        $validated['kiubot_enabled'] = $request->boolean('kiubot_enabled', false);
        $validated['skip_payment_on_trial'] = $request->boolean('skip_payment_on_trial', false);
        
        // Asegurar valores por defecto si vienen vacíos
        $validated['sort_order'] = $validated['sort_order'] ?? $plan->sort_order ?? 0;
        $validated['trial_days'] = $validated['trial_days'] ?? $plan->trial_days ?? 0;
        
        // Incrementar versión si hay cambios significativos
        $significantChanges = ['price', 'max_products', 'max_categories', 'max_sedes'];
        $hasSignificantChanges = false;
        
        foreach ($significantChanges as $field) {
            if (isset($validated[$field]) && $plan->$field != $validated[$field]) {
                $hasSignificantChanges = true;
                break;
            }
        }
        
        if ($hasSignificantChanges) {
            $currentVersion = floatval($plan->version);
            $validated['version'] = number_format($currentVersion + 0.1, 1);
        }
        
        // Preparar precios
        if (isset($validated['prices'])) {
            $validated['prices'] = array_filter($validated['prices'], function($price) {
                return $price !== null && $price !== '';
            });
        }

        // Filtrar características vacías
        if (isset($validated['features_list'])) {
            $validated['features_list'] = array_values(array_filter($validated['features_list'], function($feature) {
                return !empty(trim($feature));
            }));
        }

        $plan->update($validated);

        return redirect()
            ->route('superlinkiu.plans.index')
            ->with('success', 'Plan actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        // Verificar si tiene tiendas activas
        if ($plan->hasActiveStores()) {
            if (request()->wantsJson()) {
                return response()->json([
                    'error' => 'No se puede eliminar un plan con tiendas activas'
                ], 422);
            }
            return back()->with('error', 'No se puede eliminar un plan con tiendas activas');
        }

        $planName = $plan->name;
        $plan->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Plan \"{$planName}\" eliminado exitosamente"
            ]);
        }

        return redirect()
            ->route('superlinkiu.plans.index')
            ->with('success', "Plan \"{$planName}\" eliminado exitosamente");
    }
}
