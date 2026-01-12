<?php

namespace App\Features\Public\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PlansController extends Controller
{
    /**
     * Mostrar página pública de planes
     */
    public function index(): View
    {
        // Obtener planes públicos y activos ordenados
        $plans = Plan::where('is_public', true)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('price')
            ->get();

        // Obtener el máximo de días de prueba de los planes activos
        $maxTrialDays = Plan::where('is_active', true)
            ->where('is_public', true)
            ->max('trial_days') ?? 15; // Default a 15 si no hay planes

        return view('public::plans.index', compact('plans', 'maxTrialDays'));
    }

    /**
     * Seleccionar plan y redirigir al registro
     */
    public function selectPlan(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'billing_period' => 'required|in:monthly,quarterly,semester,annual',
        ]);

        // Guardar en sesión
        Session::put('wizard.plan_id', $validated['plan_id']);
        Session::put('wizard.billing_period', $validated['billing_period']);

        // Redirigir al step 2 del registro
        return redirect()->route('register.step2');
    }
}
