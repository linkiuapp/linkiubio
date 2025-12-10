<?php

namespace App\Jobs;

use App\Services\AWSPaymentProofValidationService;
use App\Shared\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Broadcast;

class ValidatePaymentProofJob implements ShouldQueue
{
    use Queueable;

    public $tries = 3;
    public $timeout = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Order $order,
        public ?string $selectedBank = null
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(AWSPaymentProofValidationService $validationService): void
    {
        try {
            // Verificar que el pedido tenga comprobante
            if (!$this->order->payment_proof_path) {
                Log::warning('Order #' . $this->order->order_number . ' has no payment proof to validate');
                return;
            }

            Log::info('Starting payment proof validation for order #' . $this->order->order_number, [
                'selected_bank' => $this->selectedBank,
            ]);

            // Validar el comprobante usando AWS con banco específico
            $result = $validationService->validateProof($this->order->payment_proof_path, $this->selectedBank);

            // Guardar resultados en la base de datos
            $this->order->update([
                'proof_validation_status' => $result['status'],
                'proof_validation_score' => $result['score'],
                'proof_validation_details' => $result['details'],
                'proof_validated_at' => now(),
            ]);

            Log::info('Payment proof validation completed for order #' . $this->order->order_number, [
                'status' => $result['status'],
                'score' => $result['score'],
            ]);

            // Notificar al tenant admin via Pusher
            $this->notifyTenantAdmin($result);

        } catch (\Exception $e) {
            Log::error('Error validating payment proof for order #' . $this->order->order_number . ': ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            // Guardar error en la base de datos
            $this->order->update([
                'proof_validation_status' => 'error',
                'proof_validation_score' => 0,
                'proof_validation_details' => [
                    'error' => $e->getMessage(),
                ],
                'proof_validated_at' => now(),
            ]);

            throw $e;
        }
    }

    /**
     * Notificar al tenant admin del resultado
     */
    protected function notifyTenantAdmin(array $result): void
    {
        try {
            $data = [
                'order_id' => $this->order->id,
                'order_number' => $this->order->order_number,
                'status' => $result['status'],
                'score' => $result['score'],
                'details' => $result['details'],
            ];

            // Broadcast via Pusher
            broadcast(new \App\Events\PaymentProofValidated($this->order, $result));

        } catch (\Exception $e) {
            Log::warning('Failed to broadcast proof validation result: ' . $e->getMessage());
        }
    }
}
