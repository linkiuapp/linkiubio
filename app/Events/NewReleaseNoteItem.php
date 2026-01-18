<?php

namespace App\Events;

use App\Features\SuperLinkiu\Models\ReleaseNoteItem;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewReleaseNoteItem implements ShouldBroadcast, ShouldQueue
{
    use Dispatchable, InteractsWithSockets, InteractsWithBroadcasting, SerializesModels;
    
    /**
     * The number of times the job may be attempted.
     */
    public $tries = 3;
    
    /**
     * Determine if the event should broadcast.
     * Usa Ably para notificaciones de release notes
     */
    public function shouldBroadcast(): bool
    {
        try {
            // Prioridad 1: Usar Ably si está configurado (misma lógica que pedidos)
            if (!empty(config('broadcasting.connections.ably.key')) || 
                !empty(config('broadcasting.connections.ably-realtime.key'))) {
                return true;
            }
            
            // Prioridad 2: Fallback a Pusher si está configurado (compatibilidad)
            if (config('broadcasting.default') === 'pusher' 
                && !empty(config('broadcasting.connections.pusher.key'))) {
                return true;
            }
            
            return false;
        } catch (\Exception $e) {
            \Log::warning('Broadcasting check failed: ' . $e->getMessage());
            return false;
        }
    }

    public $item;

    /**
     * Create a new event instance.
     */
    public function __construct(ReleaseNoteItem $item)
    {
        $this->item = $item;
        
        // Usar Ably para notificaciones de release notes (misma conexión que pedidos)
        if (!empty(config('broadcasting.connections.ably-realtime.key')) || 
            !empty(config('broadcasting.connections.ably.key'))) {
            // Usar ably-realtime si está disponible (misma que pedidos), sino usar ably
            $this->broadcastVia(!empty(config('broadcasting.connections.ably-realtime.key')) ? 'ably-realtime' : 'ably');
        }
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        return new Channel('platform.release-notes');
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'new.release-note-item';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        try {
            // Refrescar el modelo y cargar relaciones (necesario cuando se procesa en cola)
            // Si el modelo fue eliminado, refresh() puede fallar, así que lo manejamos
            if ($this->item->exists) {
                $this->item->refresh();
                $this->item->load('releaseNote');
            }
        } catch (\Exception $e) {
            \Log::warning('Error refreshing ReleaseNoteItem in broadcastWith: ' . $e->getMessage());
            // Continuar con los datos que tenemos
        }
        
        $releaseNote = $this->item->releaseNote;
        $releaseNoteUrl = url(route('release-notes.index', [], false));
        
        $typeLabels = [
            'new' => 'Nueva Función',
            'fix' => 'Corrección',
            'improvement' => 'Mejora',
            'deprecated' => 'Deprecado'
        ];
        
        $typeIcons = [
            'new' => '✨',
            'fix' => '🔧',
            'improvement' => '⚡',
            'deprecated' => '⚠️'
        ];
        
        $version = $releaseNote->version ?? 'N/A';
        
        return [
            'id' => $this->item->id,
            'title' => ($typeLabels[$this->item->type] ?? 'Actualización') . ': v' . $version,
            'message' => \Str::limit($this->item->description, 150),
            'type' => 'release-note-item',
            'type_icon' => $typeIcons[$this->item->type] ?? '🚀',
            'type_label' => $typeLabels[$this->item->type] ?? 'Actualización',
            'item_type' => $this->item->type,
            'version' => $version,
            'url' => $this->item->link ?: $releaseNoteUrl,
            'created_at' => $this->item->created_at->format('d/m/Y H:i')
        ];
    }
}
