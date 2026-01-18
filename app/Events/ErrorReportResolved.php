<?php

namespace App\Events;

use App\Models\ErrorReport;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ErrorReportResolved implements ShouldBroadcast, ShouldQueue
{
    use Dispatchable, InteractsWithSockets, InteractsWithBroadcasting, SerializesModels;

    public $errorReport;
    
    /**
     * The number of times the job may be attempted.
     */
    public $tries = 3;

    public function __construct(ErrorReport $errorReport)
    {
        $this->errorReport = $errorReport;
        
        // Asegurar que las relaciones estén cargadas
        $this->errorReport->load(['store', 'user']);
        
        // Usar Ably para notificaciones (igual que release notes)
        if (!empty(config('broadcasting.connections.ably-realtime.key')) || 
            !empty(config('broadcasting.connections.ably.key'))) {
            $this->broadcastVia(!empty(config('broadcasting.connections.ably-realtime.key')) ? 'ably-realtime' : 'ably');
        }
    }

    public function broadcastOn(): Channel
    {
        // Canal público para la tienda (como release notes)
        return new Channel('store.' . $this->errorReport->store_id . '.notifications');
    }

    public function broadcastAs(): string
    {
        return 'error.report.resolved';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->errorReport->id,
            'title' => $this->errorReport->title,
            'message' => '✅ Tu reporte "' . $this->errorReport->title . '" ha sido resuelto',
            'timestamp' => $this->errorReport->updated_at->toIso8601String(),
            'url' => null, // No hay URL específica para error reports en tenant admin
        ];
    }
}
