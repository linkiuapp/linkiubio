<?php

namespace App\Events;

use App\Shared\Models\Store;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreVerificationChanged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, InteractsWithBroadcasting, SerializesModels;

    public $tries = 3;

    public $store;
    public $verified;
    public $changedBy;

    /**
     * Create a new event instance.
     */
    public function __construct(Store $store, bool $verified, ?string $changedBy = null)
    {
        $this->store = $store;
        $this->verified = $verified;
        $this->changedBy = $changedBy ?? 'SuperAdmin';
        
        // Siempre usar Ably para notificaciones de verificación
        $this->broadcastVia('ably-realtime');
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        // Canal específico de la tienda
        return new Channel('store.' . $this->store->id . '.notifications');
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'store.verification.changed';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => uniqid('verification_'),
            'type' => 'store_verification_changed',
            'store_id' => $this->store->id,
            'store_name' => $this->store->name,
            'verified' => $this->verified,
            'message' => $this->verified 
                ? '🎉 ¡Increíble! Tu tienda ahora tiene el badge oficial de verificación de Linkiu'
                : 'El badge de verificación de tu tienda ha sido removido temporalmente',
            'title' => $this->verified ? '✨ ¡Felicitaciones, tienda verificada!' : '📋 Verificación Removida',
            'changed_by' => $this->changedBy,
            'timestamp' => now()->toIso8601String(),
            'url' => null
        ];
    }
}
