<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MonitoringAlert;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MonitoringAlertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = MonitoringAlert::query();

        // Filtros
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('channel')) {
            $query->byChannel($request->channel);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $alerts = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        // Estadísticas
        $stats = [
            'total' => MonitoringAlert::count(),
            'active' => MonitoringAlert::where('is_active', true)->count(),
            'inactive' => MonitoringAlert::where('is_active', false)->count(),
            'recently_triggered' => MonitoringAlert::where('last_triggered_at', '>=', now()->subHours(24))->count(),
        ];

        return view('superlinkiu::monitoring.alerts.index', compact('alerts', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('superlinkiu::monitoring.alerts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:error_rate,traffic_spike,slow_response,high_memory,custom',
            'conditions' => 'required|array',
            'channel' => 'required|in:email,whatsapp,in_app',
            'is_active' => 'boolean',
            'cooldown_minutes' => 'required|integer|min:1|max:1440',
        ]);

        // Asegurar que is_active sea boolean
        $validated['is_active'] = $request->has('is_active') ? (bool)$request->input('is_active') : false;

        // Normalizar condiciones: convertir strings numéricos a enteros
        if (isset($validated['conditions']['threshold'])) {
            $validated['conditions']['threshold'] = (int)$validated['conditions']['threshold'];
        }
        if (isset($validated['conditions']['threshold_ms'])) {
            $validated['conditions']['threshold_ms'] = (int)$validated['conditions']['threshold_ms'];
        }
        if (isset($validated['conditions']['threshold_mb'])) {
            $validated['conditions']['threshold_mb'] = (int)$validated['conditions']['threshold_mb'];
        }
        if (isset($validated['conditions']['minutes'])) {
            $validated['conditions']['minutes'] = (int)$validated['conditions']['minutes'];
        }
        // Limpiar route_pattern si está vacío
        if (isset($validated['conditions']['route_pattern']) && empty(trim($validated['conditions']['route_pattern']))) {
            unset($validated['conditions']['route_pattern']);
        }

        MonitoringAlert::create($validated);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Alerta creada exitosamente'
            ]);
        }

        return redirect()
            ->route('superlinkiu.monitoring.alerts.index')
            ->with('success', 'Alerta creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $alert = MonitoringAlert::findOrFail($id);

        return view('superlinkiu::monitoring.alerts.show', compact('alert'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $alert = MonitoringAlert::findOrFail($id);

        return view('superlinkiu::monitoring.alerts.edit', compact('alert'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $alert = MonitoringAlert::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:error_rate,traffic_spike,slow_response,high_memory,custom',
            'conditions' => 'required|array',
            'channel' => 'required|in:email,whatsapp,in_app',
            'is_active' => 'boolean',
            'cooldown_minutes' => 'required|integer|min:1|max:1440',
        ]);

        // Asegurar que is_active sea boolean
        $validated['is_active'] = $request->has('is_active') ? (bool)$request->input('is_active') : false;

        // Normalizar condiciones: convertir strings numéricos a enteros
        if (isset($validated['conditions']['threshold'])) {
            $validated['conditions']['threshold'] = (int)$validated['conditions']['threshold'];
        }
        if (isset($validated['conditions']['threshold_ms'])) {
            $validated['conditions']['threshold_ms'] = (int)$validated['conditions']['threshold_ms'];
        }
        if (isset($validated['conditions']['threshold_mb'])) {
            $validated['conditions']['threshold_mb'] = (int)$validated['conditions']['threshold_mb'];
        }
        if (isset($validated['conditions']['minutes'])) {
            $validated['conditions']['minutes'] = (int)$validated['conditions']['minutes'];
        }
        // Limpiar route_pattern si está vacío
        if (isset($validated['conditions']['route_pattern']) && empty(trim($validated['conditions']['route_pattern']))) {
            unset($validated['conditions']['route_pattern']);
        }

        $alert->update($validated);

        return redirect()
            ->route('superlinkiu.monitoring.alerts.index')
            ->with('success', 'Alerta actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $alert = MonitoringAlert::findOrFail($id);
        $alert->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Alerta eliminada exitosamente'
            ]);
        }

        return redirect()
            ->route('superlinkiu.monitoring.alerts.index')
            ->with('success', 'Alerta eliminada exitosamente');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(string $id): RedirectResponse
    {
        $alert = MonitoringAlert::findOrFail($id);
        $alert->update(['is_active' => !$alert->is_active]);

        return redirect()
            ->route('superlinkiu.monitoring.alerts.index')
            ->with('success', 'Estado de la alerta actualizado');
    }
}
