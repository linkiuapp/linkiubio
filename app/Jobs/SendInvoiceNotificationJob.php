<?php

namespace App\Jobs;

use App\Shared\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * ⚠️ SISTEMA DE CORREOS DESACTIVADO TEMPORALMENTE
 * Este job se procesará exitosamente sin enviar emails
 */
class SendInvoiceNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1; // Reducido a 1 ya que no hace nada
    public $timeout = 5; // Timeout mínimo

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Invoice $invoice,
        public string $notificationType = 'created'
    ) {
    }

    /**
     * ⚠️ TEMPORALMENTE DESHABILITADO - Sistema de correos desactivado
     */
    public function handle(): void
    {
        // Sistema de correos temporalmente desactivado
        // Este job se procesa exitosamente sin hacer nada
        return;
    }
}
