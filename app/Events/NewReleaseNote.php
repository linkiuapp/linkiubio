<?php

namespace App\Events;

use App\Features\SuperLinkiu\Models\ReleaseNote;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewReleaseNote implements ShouldBroadcast, ShouldQueue
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

    public $releaseNote;

    /**
     * Create a new event instance.
     */
    public function __construct(ReleaseNote $releaseNote)
    {
        $this->releaseNote = $releaseNote;
        
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
        // Canal público para todos los admins de tiendas
        return new Channel('platform.release-notes');
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'new.release-note';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        try {
            // Refrescar el modelo y cargar relaciones (necesario cuando se procesa en cola)
            // Si el modelo fue eliminado, refresh() puede fallar, así que lo manejamos
            if ($this->releaseNote->exists) {
                $this->releaseNote->refresh();
                $this->releaseNote->load('items');
            }
        } catch (\Exception $e) {
            \Log::warning('Error refreshing ReleaseNote in broadcastWith: ' . $e->getMessage());
            // Continuar con los datos que tenemos
        }
        
        $releaseNoteUrl = url(route('release-notes.index', [], false));
        $itemsCount = $this->releaseNote->items->count() ?? 0;
        
        return [
            'id' => $this->releaseNote->id,
            'title' => 'Nueva Actualización: v' . $this->releaseNote->version,
            'message' => 'Se ha publicado una nueva versión con ' . $itemsCount . ' actualización(es)',
            'type' => 'release-note',
            'type_icon' => '🚀',
            'type_label' => 'Nueva Actualización',
            'version' => $this->releaseNote->version,
            'url' => $releaseNoteUrl,
            'created_at' => $this->releaseNote->created_at->format('d/m/Y H:i')
        ];
    }
}
