<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\ReleaseNote;
use App\Features\SuperLinkiu\Models\ReleaseNoteItem;
use App\Events\NewReleaseNote;
use App\Events\NewReleaseNoteItem;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ReleaseNoteController extends Controller
{
    /**
     * Display a listing of release notes.
     */
    public function index(Request $request): View
    {
        $query = ReleaseNote::with('items');

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('version', 'like', "%{$search}%")
                  ->orWhereHas('items', function ($itemQuery) use ($search) {
                      $itemQuery->where('description', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $releaseNotes = $query->ordered()->paginate(15)->withQueryString();

        // Estadísticas
        $stats = [
            'total' => ReleaseNote::count(),
            'active' => ReleaseNote::where('is_active', true)->count(),
            'inactive' => ReleaseNote::where('is_active', false)->count(),
            'current' => ReleaseNote::where('is_current', true)->count(),
        ];

        return view('superlinkiu::release-notes.index', compact('releaseNotes', 'stats'));
    }

    /**
     * Show the form for creating a new release note.
     */
    public function create(): View
    {
        // Preparar items por defecto para evitar problemas de sintaxis en Blade
        $defaultItems = [
            ['type' => 'new', 'description' => '', 'link' => '', 'notify_tenants' => false, 'order' => 0]
        ];
        
        return view('superlinkiu::release-notes.create', compact('defaultItems'));
    }

    /**
     * Store a newly created release note.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'version' => 'required|string|max:20|unique:release_notes,version',
            'release_date' => 'required|date',
            'is_current' => 'boolean',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'notify_tenants' => 'boolean',
            'items' => 'required|array|min:1',
            'items.*.type' => 'required|in:new,fix,improvement,deprecated',
            'items.*.description' => 'required|string|max:1000',
            'items.*.link' => 'nullable|url|max:500',
            'items.*.order' => 'nullable|integer|min:0',
        ]);

        // Si se marca como actual, desmarcar las demás
        if ($validated['is_current'] ?? false) {
            ReleaseNote::where('is_current', true)->update(['is_current' => false]);
        }

        // Crear release note
        $releaseNote = ReleaseNote::create([
            'version' => $validated['version'],
            'release_date' => $validated['release_date'],
            'is_current' => $validated['is_current'] ?? false,
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
            'notify_tenants' => $validated['notify_tenants'] ?? false,
        ]);

        // Crear items
        foreach ($validated['items'] as $index => $item) {
            $newItem = ReleaseNoteItem::create([
                'release_note_id' => $releaseNote->id,
                'type' => $item['type'],
                'description' => $item['description'],
                'link' => $item['link'] ?? null,
                'notify_tenants' => $item['notify_tenants'] ?? false,
                'order' => $item['order'] ?? $index,
            ]);
            
            // Si el item tiene notify_tenants y el release note está activo, notificar
            if ($newItem->notify_tenants && $releaseNote->is_active) {
                event(new NewReleaseNoteItem($newItem));
            }
        }

        // Si se marcó para notificar el release note completo, enviar notificación
        if ($releaseNote->notify_tenants && $releaseNote->is_active) {
            // Cargar la relación items antes de crear el evento
            $releaseNote->load('items');
            event(new NewReleaseNote($releaseNote));
        }

        return redirect()
            ->route('superlinkiu.release-notes.index')
            ->with('success', 'Nota de versión creada exitosamente');
    }

    /**
     * Show the form for editing the specified release note.
     */
    public function edit(ReleaseNote $releaseNote): View
    {
        $releaseNote->load('items');
        
        // Preparar items para evitar problemas de sintaxis en Blade
        $defaultItems = $releaseNote->items->map(function($item) {
            return [
                'id' => $item->id,
                'type' => $item->type,
                'description' => $item->description,
                'link' => $item->link,
                'notify_tenants' => $item->notify_tenants,
                'order' => $item->order
            ];
        })->toArray();
        
        return view('superlinkiu::release-notes.edit', compact('releaseNote', 'defaultItems'));
    }

    /**
     * Update the specified release note.
     */
    public function update(Request $request, ReleaseNote $releaseNote): RedirectResponse
    {
        $validated = $request->validate([
            'version' => 'required|string|max:20|unique:release_notes,version,' . $releaseNote->id,
            'release_date' => 'required|date',
            'is_current' => 'boolean',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'notify_tenants' => 'boolean',
            'items' => 'required|array|min:1',
            'items.*.id' => 'nullable|exists:release_note_items,id',
            'items.*.type' => 'required|in:new,fix,improvement,deprecated',
            'items.*.description' => 'required|string|max:1000',
            'items.*.link' => 'nullable|url|max:500',
            'items.*.notify_tenants' => 'boolean',
            'items.*.order' => 'nullable|integer|min:0',
        ]);

        // Si se marca como actual, desmarcar las demás
        if ($validated['is_current'] ?? false) {
            ReleaseNote::where('is_current', true)
                ->where('id', '!=', $releaseNote->id)
                ->update(['is_current' => false]);
        }

        // Guardar si se debe notificar (antes de actualizar)
        $shouldNotify = ($validated['notify_tenants'] ?? false) && ($validated['is_active'] ?? false);
        $wasNotified = $releaseNote->notify_tenants;

        // Actualizar release note
        $releaseNote->update([
            'version' => $validated['version'],
            'release_date' => $validated['release_date'],
            'is_current' => $validated['is_current'] ?? false,
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
            'notify_tenants' => $validated['notify_tenants'] ?? false,
        ]);

        // Obtener IDs de items existentes
        $existingItemIds = $releaseNote->items->pluck('id')->toArray();
        $updatedItemIds = [];

        // Actualizar o crear items
        foreach ($validated['items'] as $index => $itemData) {
            if (isset($itemData['id']) && in_array($itemData['id'], $existingItemIds)) {
                // Actualizar item existente
                $item = ReleaseNoteItem::find($itemData['id']);
                $wasNotified = $item->notify_tenants;
                $item->update([
                    'type' => $itemData['type'],
                    'description' => $itemData['description'],
                    'link' => $itemData['link'] ?? null,
                    'notify_tenants' => $itemData['notify_tenants'] ?? false,
                    'order' => $itemData['order'] ?? $index,
                ]);
                
                // Si se marcó para notificar y no se había notificado antes, enviar notificación
                if ($item->notify_tenants && !$wasNotified && $releaseNote->is_active) {
                    event(new NewReleaseNoteItem($item));
                }
                
                $updatedItemIds[] = $itemData['id'];
            } else {
                // Crear nuevo item
                $newItem = ReleaseNoteItem::create([
                    'release_note_id' => $releaseNote->id,
                    'type' => $itemData['type'],
                    'description' => $itemData['description'],
                    'link' => $itemData['link'] ?? null,
                    'notify_tenants' => $itemData['notify_tenants'] ?? false,
                    'order' => $itemData['order'] ?? $index,
                ]);
                
                // Si el item tiene notify_tenants y el release note está activo, notificar
                if ($newItem->notify_tenants && $releaseNote->is_active) {
                    event(new NewReleaseNoteItem($newItem));
                }
                
                $updatedItemIds[] = $newItem->id;
            }
        }

        // Eliminar items que no están en la lista
        ReleaseNoteItem::where('release_note_id', $releaseNote->id)
            ->whereNotIn('id', $updatedItemIds)
            ->delete();

        // Si se marcó para notificar y no se había notificado antes, enviar notificación
        if ($shouldNotify && !$wasNotified) {
            // Cargar la relación items antes de crear el evento
            $freshReleaseNote = $releaseNote->fresh();
            $freshReleaseNote->load('items');
            event(new NewReleaseNote($freshReleaseNote));
        }

        return redirect()
            ->route('superlinkiu.release-notes.index')
            ->with('success', 'Nota de versión actualizada exitosamente');
    }

    /**
     * Remove the specified release note.
     */
    public function destroy(ReleaseNote $releaseNote): RedirectResponse
    {
        $releaseNote->delete();

        return redirect()
            ->route('superlinkiu.release-notes.index')
            ->with('success', 'Nota de versión eliminada exitosamente');
    }
}
