<?php

namespace App\Features\Tenant\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\Store;
use App\Shared\Models\StoreReport;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PageController extends Controller
{
    /**
     * Mostrar página de políticas legales
     */
    public function legalPolicies(): View
    {
        $store = request()->route('store');
        return view('tenant::pages.legal-policies', compact('store'));
    }

    /**
     * Mostrar página "Acerca de Nosotros"
     */
    public function aboutUs(): View
    {
        $store = request()->route('store');
        return view('tenant::pages.about-us', compact('store'));
    }

    /**
     * Mostrar formulario para reportar problemas
     */
    public function reportProblem(): View
    {
        $store = request()->route('store');
        return view('tenant::pages.report-problem', compact('store'));
    }

    /**
     * Procesar reporte de problema
     */
    public function submitReport(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'reason' => 'required|string|in:producto_defectuoso,envio_tardio,mal_servicio,cobro_incorrecto,fraude,contenido_inapropiado,otro',
            'description' => 'required|string|max:1000',
            'reporter_email' => 'nullable|email|max:255',
        ], [
            'reason.required' => 'Debes seleccionar un motivo',
            'reason.in' => 'El motivo seleccionado no es válido',
            'description.required' => 'La descripción es obligatoria',
            'description.max' => 'La descripción no puede superar los 1000 caracteres',
            'reporter_email.email' => 'El email no es válido',
        ]);

        $store = request()->route('store');

        // Crear el reporte
        StoreReport::create([
            'store_id' => $store->id,
            'reason' => $validated['reason'],
            'description' => $validated['description'],
            'reporter_email' => $validated['reporter_email'] ?? null,
            'reporter_ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'pending',
        ]);

        return redirect()
            ->route('tenant.report-problem', $store->slug)
            ->with('success', '¡Gracias por tu reporte! Nuestro equipo lo revisará pronto.');
    }
}

