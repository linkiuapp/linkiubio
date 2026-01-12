<?php

namespace App\Features\Public\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class RestaurantController extends Controller
{
    /**
     * Mostrar página pública de Restaurantes
     */
    public function index(): View
    {
        // Obtener tiendas activas con logos para el carrusel
        try {
            $featuredStores = \App\Shared\Models\Store::where('status', 'active')
                ->where('approval_status', 'approved')
                ->with('design')
                ->get()
                ->filter(function($store) {
                    if (!$store->design) {
                        return false;
                    }
                    
                    $logoUrl = $store->design->logo_url ?? null;
                    if (empty($logoUrl)) {
                        $rawLogoUrl = $store->design->getAttributes()['logo_url'] ?? null;
                        if (empty($rawLogoUrl)) {
                            return false;
                        }
                        $logoUrl = $store->design->logo_url;
                    }
                    
                    return !empty($logoUrl);
                })
                ->take(12)
                ->values()
                ->map(function($store) {
                    return [
                        'slug' => $store->slug,
                        'name' => $store->name,
                        'logo_url' => $store->design->logo_url,
                        'url' => route('tenant.home', $store->slug),
                    ];
                });
        } catch (\Exception $e) {
            \Log::error('Error obteniendo tiendas destacadas para restaurantes', [
                'error' => $e->getMessage()
            ]);
            $featuredStores = collect([]);
        }
        
        // Obtener el máximo de días de prueba de los planes activos
        $maxTrialDays = \App\Shared\Models\Plan::where('is_active', true)
            ->where('is_public', true)
            ->max('trial_days') ?? 15; // Default a 15 si no hay planes
        
        return view('public::restaurant.index', compact('featuredStores', 'maxTrialDays'));
    }
}
