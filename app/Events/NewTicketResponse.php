<?php

namespace App\Events;

use App\Shared\Models\TicketResponse;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewTicketResponse implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $response;
    public $ticket;
    public $isForSupport;

    /**
     * Create a new event instance.
     */
    public function __construct(TicketResponse $response)
    {
        $this->response = $response;
        $this->ticket = $response->ticket;
        
        // Determinar si es para soporte (SuperAdmin) o para el admin de tienda
        $this->isForSupport = $this->response->is_from_store;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        if ($this->isForSupport) {
            // Si es del admin de tienda, notificar a SuperAdmin
            return new Channel('support.tickets');
        } else {
            // Si es de soporte, notificar al admin de la tienda específica
            return new Channel('store.' . $this->ticket->store_id . '.tickets');
        }
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'ticket.response';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'ticket_number' => $this->ticket->ticket_number,
            'subject' => $this->ticket->subject,
            'response_id' => $this->response->id,
            'message' => $this->response->message,
            'is_from_store' => $this->response->is_from_store,
            'sender_name' => $this->response->is_from_store 
                ? ($this->ticket->store->name ?? 'Admin de Tienda')
                : 'Soporte Linkiu',
            'created_at' => $this->response->created_at->format('H:i'),
            'url' => $this->isForSupport
                ? route('superlinkiu.tickets.show', $this->ticket->id)
                : route('tenant.admin.tickets.show', [$this->ticket->store->slug, $this->ticket->id])
        ];
    }
}

