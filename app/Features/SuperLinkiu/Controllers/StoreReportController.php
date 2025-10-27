<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\StoreReport;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class StoreReportController extends Controller
{
    /**
     * Mostrar lista de reportes
     */
    public function index(Request $request): View
    {
        $query = StoreReport::with(['store', 'reviewer'])
            ->orderBy('created_at', 'desc');

        // Filtro por estado
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por tienda
        if ($request->filled('store_id')) {
            $query->where('store_id', $request->store_id);
        }

        // Filtro por motivo
        if ($request->filled('reason')) {
            $query->where('reason', $request->reason);
        }

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('reporter_email', 'like', "%{$search}%")
                  ->orWhereHas('store', function ($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $reports = $query->paginate(20)->withQueryString();

        // Estadísticas
        $stats = [
            'total' => StoreReport::count(),
            'pending' => StoreReport::where('status', 'pending')->count(),
            'reviewed' => StoreReport::where('status', 'reviewed')->count(),
            'resolved' => StoreReport::where('status', 'resolved')->count(),
        ];

        // Obtener tiendas para el filtro
        $stores = \App\Shared\Models\Store::select('id', 'name')
            ->whereHas('reports')
            ->orderBy('name')
            ->get();

        return view('superlinkiu::store-reports.index', compact('reports', 'stats', 'stores'));
    }

    /**
     * Mostrar detalle de un reporte
     */
    public function show(StoreReport $report): View
    {
        $report->load(['store', 'reviewer']);
        
        return view('superlinkiu::store-reports.show', compact('report'));
    }

    /**
     * Marcar reporte como revisado
     */
    public function markAsReviewed(Request $request, StoreReport $report): RedirectResponse
    {
        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $report->update([
            'status' => 'reviewed',
            'admin_notes' => $validated['admin_notes'] ?? null,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        return redirect()
            ->route('superlinkiu.store-reports.show', $report)
            ->with('success', 'Reporte marcado como revisado');
    }

    /**
     * Marcar reporte como resuelto
     */
    public function markAsResolved(Request $request, StoreReport $report): RedirectResponse
    {
        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $report->update([
            'status' => 'resolved',
            'admin_notes' => $validated['admin_notes'] ?? $report->admin_notes,
            'reviewed_at' => $report->reviewed_at ?? now(),
            'reviewed_by' => $report->reviewed_by ?? auth()->id(),
        ]);

        return redirect()
            ->route('superlinkiu.store-reports.show', $report)
            ->with('success', 'Reporte marcado como resuelto');
    }

    /**
     * Actualizar notas del reporte
     */
    public function updateNotes(Request $request, StoreReport $report): RedirectResponse
    {
        $validated = $request->validate([
            'admin_notes' => 'required|string|max:1000',
        ]);

        $report->update([
            'admin_notes' => $validated['admin_notes'],
        ]);

        return redirect()
            ->route('superlinkiu.store-reports.show', $report)
            ->with('success', 'Notas actualizadas correctamente');
    }

    /**
     * Eliminar reporte
     */
    public function destroy(StoreReport $report): RedirectResponse
    {
        $report->delete();

        return redirect()
            ->route('superlinkiu.store-reports.index')
            ->with('success', 'Reporte eliminado correctamente');
    }
}

