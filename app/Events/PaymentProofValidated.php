<?php

namespace App\Events;

use App\Shared\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PaymentProofValidated implements ShouldBroadcast, ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tries = 3;
    public $delay = 0;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Order $order,
        public array $validationResult
    ) {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('store.' . $this->order->store_id . '.orders'),
        ];
    }

    /**
     * El nombre del evento que escuchará el frontend
     */
    public function broadcastAs(): string
    {
        return 'proof.validated';
    }

    /**
     * Los datos que se enviarán al frontend
     */
    public function broadcastWith(): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'status' => $this->validationResult['status'],
            'score' => $this->validationResult['score'],
            'details' => $this->validationResult['details'],
        ];
    }

    /**
     * Verificar si debe hacer broadcast
     */
    public function shouldBroadcast(): bool
    {
        try {
            return config('broadcasting.default') === 'pusher'
                && !empty(config('broadcasting.connections.pusher.key'));
        } catch (\Exception $e) {
            Log::warning('Broadcasting check failed: ' . $e->getMessage());
            return false;
        }
    }
}
