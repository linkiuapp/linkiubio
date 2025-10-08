<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Services\SendGridEmailService;
use App\Models\EmailConfiguration;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3; // 3 reintentos máximo
    public $timeout = 60; // 60 segundos timeout

    public function __construct(
        public string $type,
        public string $recipientEmail,
        public array $data = []
    ) {}

    /**
     * Execute the job usando SendGrid
     */
    public function handle(): void
    {
        try {
            Log::info("📧 SEND EMAIL JOB: Procesando email en cola", [
                'type' => $this->type,
                'recipient' => $this->recipientEmail,
                'attempt' => $this->attempts()
            ]);

            if ($this->type === 'template') {
                // Emails con plantilla usando SendGrid
                $result = $this->sendTemplateEmail(
                    $this->data['template_key'],
                    $this->recipientEmail,
                    $this->data['variables'] ?? []
                );
            } else {
                throw new \Exception("Tipo de email no soportado: {$this->type}");
            }

            if ($result['success']) {
                Log::info("✅ SEND EMAIL JOB: Email enviado exitosamente", [
                    'type' => $this->type,
                    'recipient' => $this->recipientEmail,
                    'attempt' => $this->attempts()
                ]);
            } else {
                Log::error("❌ SEND EMAIL JOB: Email falló", [
                    'type' => $this->type,
                    'recipient' => $this->recipientEmail,
                    'error' => $result['message'],
                    'attempt' => $this->attempts()
                ]);
                
                // Fallar el job para que se reintente
                throw new \Exception($result['message']);
            }

        } catch (\Exception $e) {
            Log::error("❌ SEND EMAIL JOB: Error crítico", [
                'type' => $this->type,
                'recipient' => $this->recipientEmail,
                'error' => $e->getMessage(),
                'attempt' => $this->attempts()
            ]);
            
            throw $e; // Re-lanzar para reintentos
        }
    }

    /**
     * Enviar email con plantilla usando SendGrid
     */
    private function sendTemplateEmail(string $templateKey, string $email, array $variables): array
    {
        try {
            // Obtener configuración de email
            $emailConfig = EmailConfiguration::getActive();
            
            if (!$emailConfig) {
                throw new \Exception("No hay configuración de email activa");
            }

            // Mapear template_key a template_id de SendGrid
            $templateId = $this->getTemplateId($templateKey, $emailConfig);
            
            if (!$templateId) {
                throw new \Exception("Template '{$templateKey}' no configurado en SendGrid");
            }

            // Determinar categoría del email
            $category = $this->getEmailCategory($templateKey);

            // Enviar con SendGrid
            $sendGridService = new SendGridEmailService();
            $result = $sendGridService->sendWithTemplate(
                $templateId,
                $email,
                $variables,
                $variables['admin_name'] ?? $variables['store_name'] ?? null,
                $category
            );
            
            return $result;
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error enviando email: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Obtener el template ID de SendGrid según el template_key
     */
    private function getTemplateId(string $templateKey, EmailConfiguration $config): ?string
    {
        // Mapeo de template_keys a campos de la BD
        $mapping = [
            // Store Management Templates
            'store_created' => $config->template_store_created,
            'store_verified' => $config->template_store_verified,
            'store_suspended' => $config->template_store_suspended,
            'store_reactivated' => $config->template_store_reactivated,
            'plan_changed' => $config->template_plan_changed,
            
            // Ticket Templates
            'ticket_response' => $config->template_ticket_response,
            'ticket_resolved' => $config->template_ticket_resolved,
            'ticket_assigned' => $config->template_ticket_assigned,
            
            // Billing Templates
            'invoice_generated' => $config->template_invoice_generated,
            'payment_confirmed' => $config->template_payment_confirmed,
            'invoice_overdue' => $config->template_invoice_overdue,
        ];

        return $mapping[$templateKey] ?? null;
    }

    /**
     * Determinar la categoría del email para usar el sender correcto
     */
    private function getEmailCategory(string $templateKey): string
    {
        $categoryMapping = [
            // Store Management
            'store_created' => 'store_management',
            'store_verified' => 'store_management',
            'store_suspended' => 'store_management',
            'store_reactivated' => 'store_management',
            
            // Tickets
            'ticket_response' => 'tickets',
            'ticket_resolved' => 'tickets',
            'ticket_assigned' => 'tickets',
            
            // Billing
            'plan_changed' => 'billing',
            'invoice_generated' => 'billing',
            'payment_confirmed' => 'billing',
            'invoice_overdue' => 'billing',
        ];

        return $categoryMapping[$templateKey] ?? 'store_management';
    }

    /**
     * Handle job failure
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("❌ SEND EMAIL JOB: Falló completamente tras {$this->tries} intentos", [
            'type' => $this->type,
            'recipient' => $this->recipientEmail,
            'error' => $exception->getMessage(),
            'attempts' => $this->attempts()
        ]);
    }
}
