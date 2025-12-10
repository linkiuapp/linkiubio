<?php

namespace App\Jobs;

use App\Shared\Models\Invoice;
use App\Services\SendGridEmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendInvoiceNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Invoice $invoice,
        public string $notificationType = 'created'
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Cargar relaciones necesarias
            $this->invoice->load(['store.admins', 'plan']);
            
            // Obtener el email del primer admin de la tienda
            $storeAdmin = $this->invoice->store->admins()->first();
            
            if (!$storeAdmin) {
                \Log::warning('No se pudo enviar email de factura: sin admin', [
                    'invoice_id' => $this->invoice->id,
                    'store_id' => $this->invoice->store_id,
                    'notification_type' => $this->notificationType
                ]);
                return;
            }
            
            // Obtener configuración de SendGrid
            $emailConfig = \App\Models\EmailConfiguration::getActive();
            
            if (!$emailConfig) {
                \Log::warning('No se pudo enviar email de factura: EmailConfiguration no activa');
                return;
            }
            
            // Seleccionar template según tipo de notificación
            $templateId = match($this->notificationType) {
                'created' => $emailConfig->template_invoice_generated,
                'payment_received' => $emailConfig->template_payment_confirmed,
                default => null
            };
            
            if (!$templateId) {
                \Log::warning('No se pudo enviar email de factura: template no configurado', [
                    'notification_type' => $this->notificationType
                ]);
                return;
            }
            
            // Preparar datos para el template
            $emailData = [
                'first_name' => explode(' ', $storeAdmin->name)[0],
                'invoice_number' => $this->invoice->invoice_number,
                'amount' => '$' . number_format($this->invoice->amount, 0, ',', '.'),
                'due_date' => $this->invoice->due_date->format('d/m/Y'),
                'store_name' => $this->invoice->store->name,
                'invoice_url' => route('tenant.admin.invoices.show', [
                    'store' => $this->invoice->store->slug,
                    'invoice' => $this->invoice->id
                ])
            ];
            
            // Agregar datos adicionales según tipo de notificación
            if ($this->notificationType === 'payment_received' && $this->invoice->paid_date) {
                $emailData['payment_date'] = $this->invoice->paid_date->format('d/m/Y');
                $emailData['payment_method'] = 'Transferencia bancaria';
            }
            
            // Enviar email usando SendGrid
            $sendGridService = new SendGridEmailService();
            $result = $sendGridService->sendWithTemplate(
                $templateId,
                $storeAdmin->email,
                $emailData,
                $storeAdmin->name,
                'billing'
            );
            
            if ($result['success']) {
                \Log::info('Email de factura enviado exitosamente', [
                    'invoice_number' => $this->invoice->invoice_number,
                    'to' => $storeAdmin->email,
                    'type' => $this->notificationType
                ]);
            } else {
                \Log::error('Error enviando email de factura', [
                    'invoice_number' => $this->invoice->invoice_number,
                    'error' => $result['message'],
                    'type' => $this->notificationType
                ]);
            }

        } catch (\Exception $e) {
            \Log::error('Error crítico en SendInvoiceNotificationJob', [
                'invoice_id' => $this->invoice->id,
                'notification_type' => $this->notificationType,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Re-lanzar excepción para que Laravel intente nuevamente
            throw $e;
        }
    }
}
