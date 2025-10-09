<?php

namespace App\Events;

use App\Shared\Models\Store;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreRequestCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $store;

    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('platform.store.requests');
    }

    public function broadcastAs(): string
    {
        return 'store.request.created';
    }

    public function broadcastWith(): array
    {
        $timeElapsed = $this->store->created_at->diffForHumans();
        
        return [
            'store_id' => $this->store->id,
            'store_name' => $this->store->name,
            'business_type' => $this->store->business_type,
            'document_type' => $this->store->business_document_type,
            'document_number' => $this->store->business_document_number,
            'admin_name' => $this->store->admins->first()?->name ?? 'N/A',
            'admin_email' => $this->store->admins->first()?->email ?? 'N/A',
            'created_at' => $this->store->created_at->format('d/m/Y H:i'),
            'time_elapsed' => $timeElapsed,
            'review_url' => route('superlinkiu.store-requests.show', $this->store->id)
        ];
    }
}

