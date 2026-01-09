<?php

namespace App\Features\SuperLinkiu\Controllers\LinkiuDev;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\DevClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    /**
     * Listar todos los clientes
     */
    public function index(Request $request)
    {
        $query = DevClient::withCount(['projects', 'projects as active_projects_count' => function ($q) {
            $q->whereNotIn('status', ['completed', 'cancelled']);
        }]);

        // Búsqueda
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filtro por estado activo
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $clients = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('superlinkiu::linkiudev.clients.index', compact('clients'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('superlinkiu::linkiudev.clients.create');
    }

    /**
     * Guardar nuevo cliente
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'country_code' => 'required|string|max:5',
            'notes' => 'nullable|string|max:1000',
        ]);

        $client = DevClient::create($validated);

        Log::info('LinkiuDev: Cliente creado', ['client_id' => $client->id, 'name' => $client->name]);

        return redirect()
            ->route('superlinkiu.linkiudev.clients.show', $client)
            ->with('success', 'Cliente creado correctamente.');
    }

    /**
     * Ver detalle del cliente
     */
    public function show(DevClient $client)
    {
        $client->load([
            'projects' => function ($q) {
                $q->withCount('tasks')->orderBy('created_at', 'desc');
            },
            'agendaEntries' => function ($q) {
                $q->where('date', '>=', today())->orderBy('date')->take(5);
            }
        ]);

        return view('superlinkiu::linkiudev.clients.show', compact('client'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(DevClient $client)
    {
        return view('superlinkiu::linkiudev.clients.edit', compact('client'));
    }

    /**
     * Actualizar cliente
     */
    public function update(Request $request, DevClient $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'country_code' => 'required|string|max:5',
            'notes' => 'nullable|string|max:1000',
        ]);

        $client->update($validated);

        Log::info('LinkiuDev: Cliente actualizado', ['client_id' => $client->id]);

        return redirect()
            ->route('superlinkiu.linkiudev.clients.show', $client)
            ->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Eliminar cliente
     */
    public function destroy(DevClient $client)
    {
        $clientName = $client->name;
        
        // Verificar si tiene proyectos
        if ($client->projects()->exists()) {
            return back()->with('error', 'No se puede eliminar un cliente con proyectos. Elimina primero los proyectos.');
        }

        $client->delete();

        Log::info('LinkiuDev: Cliente eliminado', ['client_name' => $clientName]);

        return redirect()
            ->route('superlinkiu.linkiudev.clients.index')
            ->with('success', "Cliente '{$clientName}' eliminado correctamente.");
    }

    /**
     * Toggle estado activo/inactivo
     */
    public function toggleActive(DevClient $client)
    {
        $client->update(['is_active' => !$client->is_active]);

        $status = $client->is_active ? 'activado' : 'desactivado';

        return back()->with('success', "Cliente {$status} correctamente.");
    }
}
