<?php

namespace App\Events;

use App\Models\IconRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IconRequestApproved implements ShouldBroadcast, ShouldQueue
{
    use Dispatchable, InteractsWithSockets, InteractsWithBroadcasting, SerializesModels;

    public $iconRequest;
    
    /**
     * The number of times the job may be attempted.
     */
    public $tries = 3;

    public function __construct(IconRequest $iconRequest)
    {
        $this->iconRequest = $iconRequest;
        
        // Asegurar que las relaciones estén cargadas
        $this->iconRequest->load(['store', 'user', 'businessCategory']);
        
        // Usar Ably para notificaciones (igual que release notes)
        if (!empty(config('broadcasting.connections.ably-realtime.key')) || 
            !empty(config('broadcasting.connections.ably.key'))) {
            $this->broadcastVia(!empty(config('broadcasting.connections.ably-realtime.key')) ? 'ably-realtime' : 'ably');
        }
    }

    public function broadcastOn(): Channel
    {
        // Canal público para la tienda (como release notes)
        return new Channel('store.' . $this->iconRequest->store_id . '.notifications');
    }

    public function broadcastAs(): string
    {
        return 'icon.request.approved';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->iconRequest->id,
            'category_name' => $this->iconRequest->category_name,
            'message' => '✨ Tu solicitud de ícono "' . $this->iconRequest->category_name . '" ha sido aprobada',
            'timestamp' => $this->iconRequest->updated_at->toIso8601String(),
            'url' => route('tenant.admin.categories.index', $this->iconRequest->store->slug),
        ];
    }
}
