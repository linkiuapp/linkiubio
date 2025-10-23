<?php

namespace App\Services;

use App\Shared\Models\Invoice;
use App\Shared\Models\Store;
use App\Jobs\SendEmailJob;

class BillingNotificationService
{
    /**
     * Send invoice created notification
     */
    public function sendInvoiceCreatedNotification(Invoice $invoice): void
    {
        $storeAdminEmail = $this->getStoreAdminEmail($invoice->store);
        
        if (!$storeAdminEmail) {
            \Log::warning('No se pudo obtener email del admin para notificación de factura creada', [
                'invoice_id' => $invoice->id,
                'store_id' => $invoice->store_id
            ]);
            return;
        }

        SendEmailJob::dispatch(
            'template',
            $storeAdminEmail,
            [
                'template_key' => 'invoice_created',
                'variables' => [
                    'store_name' => $invoice->store->name,
                    'invoice_number' => $invoice->invoice_number,
                    'amount' => $invoice->getFormattedAmount(),
                    'due_date' => $invoice->due_date->format('d/m/Y'),
                    'plan_name' => $invoice->plan->name,
                    'period' => $invoice->getPeriodLabel(),
                    'days_to_pay' => $invoice->due_date->diffInDays(now()),
                    'payment_instructions' => 'Contacta con soporte para realizar el pago de tu factura.',
                    'support_email' => config('app.support_email', 'soporte@linkiu.bio'),
                    'dashboard_url' => $this->getDashboardUrl($invoice->store)
                ]
            ]
        );

        \Log::info('Notificación de factura creada enviada', [
            'invoice_id' => $invoice->id,
            'store_id' => $invoice->store_id,
            'recipient' => $storeAdminEmail
        ]);
    }

    /**
     * Send invoice due reminder (7 days before due date)
     */
    public function sendInvoiceDueReminder(Invoice $invoice): void
    {
        $storeAdminEmail = $this->getStoreAdminEmail($invoice->store);
        
        if (!$storeAdminEmail) {
            return;
        }

        SendEmailJob::dispatch(
            'template',
            $storeAdminEmail,
            [
                'template_key' => 'invoice_due_reminder',
                'variables' => [
                    'store_name' => $invoice->store->name,
                    'invoice_number' => $invoice->invoice_number,
                    'amount' => $invoice->getFormattedAmount(),
                    'due_date' => $invoice->due_date->format('d/m/Y'),
                    'days_remaining' => max(0, $invoice->due_date->diffInDays(now())),
                    'plan_name' => $invoice->plan->name,
                    'period' => $invoice->getPeriodLabel(),
                    'payment_instructions' => 'Para evitar la suspensión de tu tienda, asegúrate de pagar antes de la fecha de vencimiento.',
                    'support_email' => config('app.support_email', 'soporte@linkiu.bio'),
                    'dashboard_url' => $this->getDashboardUrl($invoice->store)
                ]
            ]
        );

        \Log::info('Recordatorio de vencimiento enviado', [
            'invoice_id' => $invoice->id,
            'store_id' => $invoice->store_id,
            'recipient' => $storeAdminEmail,
            'days_until_due' => $invoice->due_date->diffInDays(now())
        ]);
    }

    /**
     * Send overdue invoice notification
     */
    public function sendInvoiceOverdueNotification(Invoice $invoice): void
    {
        $storeAdminEmail = $this->getStoreAdminEmail($invoice->store);
        
        if (!$storeAdminEmail) {
            return;
        }

        $daysOverdue = $invoice->getDaysOverdue();

        SendEmailJob::dispatch(
            'template',
            $storeAdminEmail,
            [
                'template_key' => 'invoice_overdue',
                'variables' => [
                    'store_name' => $invoice->store->name,
                    'invoice_number' => $invoice->invoice_number,
                    'amount' => $invoice->getFormattedAmount(),
                    'due_date' => $invoice->due_date->format('d/m/Y'),
                    'days_overdue' => $daysOverdue,
                    'plan_name' => $invoice->plan->name,
                    'period' => $invoice->getPeriodLabel(),
                    'urgency_message' => $this->getUrgencyMessage($daysOverdue),
                    'suspension_warning' => $daysOverdue >= 20 ? 'Tu tienda será suspendida automáticamente si no realizas el pago en los próximos días.' : '',
                    'support_email' => config('app.support_email', 'soporte@linkiu.bio'),
                    'dashboard_url' => $this->getDashboardUrl($invoice->store)
                ]
            ]
        );

        \Log::info('Notificación de factura vencida enviada', [
            'invoice_id' => $invoice->id,
            'store_id' => $invoice->store_id,
            'recipient' => $storeAdminEmail,
            'days_overdue' => $daysOverdue
        ]);
    }

    /**
     * Send payment received confirmation
     */
    public function sendPaymentReceivedNotification(Invoice $invoice): void
    {
        $storeAdminEmail = $this->getStoreAdminEmail($invoice->store);
        
        if (!$storeAdminEmail) {
            return;
        }

        SendEmailJob::dispatch(
            'template',
            $storeAdminEmail,
            [
                'template_key' => 'payment_confirmed', // ✅ Corregido de 'payment_received' a 'payment_confirmed'
                'variables' => [
                    'invoice_number' => $invoice->invoice_number,
                    'amount' => '$' . number_format($invoice->amount, 0, ',', '.'),
                    'payment_date' => $invoice->paid_date->format('d/m/Y'),
                    'payment_method' => 'Transferencia bancaria', // Método por defecto
                    'next_due_date' => $invoice->store->subscription ? 
                        $invoice->store->subscription->next_billing_date->format('d/m/Y') : 'Por definir',
                    'store_name' => $invoice->store->name,
                    'plan_name' => $invoice->plan->name,
                ]
            ]
        );

        \Log::info('Confirmación de pago recibido enviada', [
            'invoice_id' => $invoice->id,
            'store_id' => $invoice->store_id,
            'recipient' => $storeAdminEmail,
            'paid_date' => $invoice->paid_date
        ]);
    }

    /**
     * Send billing warning (escalating warnings before suspension)
     */
    public function sendBillingWarning(Invoice $invoice, string $warningType, int $daysOverdue): void
    {
        $storeAdminEmail = $this->getStoreAdminEmail($invoice->store);
        
        if (!$storeAdminEmail) {
            return;
        }

        $warningMessages = $this->getWarningMessages($warningType, $daysOverdue);

        SendEmailJob::dispatch(
            'template',
            $storeAdminEmail,
            [
                'template_key' => 'invoice_overdue', // Usamos la misma plantilla pero con diferentes variables
                'variables' => array_merge([
                    'store_name' => $invoice->store->name,
                    'invoice_number' => $invoice->invoice_number,
                    'amount' => $invoice->getFormattedAmount(),
                    'due_date' => $invoice->due_date->format('d/m/Y'),
                    'days_overdue' => $daysOverdue,
                    'plan_name' => $invoice->plan->name,
                    'period' => $invoice->getPeriodLabel(),
                    'support_email' => config('app.support_email', 'soporte@linkiu.bio'),
                    'dashboard_url' => $this->getDashboardUrl($invoice->store)
                ], $warningMessages)
            ]
        );

        \Log::info('Aviso de factura vencida enviado', [
            'invoice_id' => $invoice->id,
            'store_id' => $invoice->store_id,
            'recipient' => $storeAdminEmail,
            'warning_type' => $warningType,
            'days_overdue' => $daysOverdue
        ]);
    }

    /**
     * Send suspension notification
     */
    public function sendSuspensionNotification(Store $store, Invoice $invoice, int $daysOverdue): void
    {
        $storeAdminEmail = $this->getStoreAdminEmail($store);
        
        if (!$storeAdminEmail) {
            return;
        }

        SendEmailJob::dispatch(
            'template',
            $storeAdminEmail,
            [
                'template_key' => 'subscription_suspended',
                'variables' => [
                    'store_name' => $store->name,
                    'suspension_date' => now()->format('d/m/Y H:i'),
                    'invoice_number' => $invoice->invoice_number,
                    'amount' => $invoice->getFormattedAmount(),
                    'days_overdue' => $daysOverdue,
                    'plan_name' => $invoice->plan->name,
                    'suspension_reason' => 'Falta de pago por más de 30 días',
                    'reactivation_instructions' => 'Para reactivar tu tienda, ponte en contacto con soporte y realiza el pago de las facturas pendientes.',
                    'data_preservation' => 'Tus datos están seguros y serán preservados durante el período de suspensión.',
                    'support_email' => config('app.support_email', 'soporte@linkiu.bio'),
                    'support_phone' => config('app.support_phone', '+57 300 123 4567')
                ]
            ]
        );

        \Log::warning('Notificación de suspensión enviada', [
            'store_id' => $store->id,
            'store_name' => $store->name,
            'recipient' => $storeAdminEmail,
            'invoice_id' => $invoice->id,
            'days_overdue' => $daysOverdue,
            'suspended_at' => now()
        ]);
    }

    /**
     * Send store reactivation notification
     */
    public function sendReactivationNotification(Store $store): void
    {
        $storeAdminEmail = $this->getStoreAdminEmail($store);
        
        if (!$storeAdminEmail) {
            return;
        }

        SendEmailJob::dispatch(
            'template',
            $storeAdminEmail,
            [
                'template_key' => 'store_reactivated', // Necesitamos crear esta plantilla
                'variables' => [
                    'store_name' => $store->name,
                    'reactivation_date' => now()->format('d/m/Y H:i'),
                    'welcome_back_message' => '¡Bienvenido de nuevo! Tu tienda ha sido reactivada exitosamente.',
                    'service_status' => 'Todos los servicios están funcionando normalmente.',
                    'next_steps' => 'Puedes continuar usando tu tienda sin restricciones.',
                    'dashboard_url' => $this->getDashboardUrl($store),
                    'store_url' => $this->getStoreUrl($store),
                    'support_email' => config('app.support_email', 'soporte@linkiu.bio')
                ]
            ]
        );

        \Log::info('Notificación de reactivación enviada', [
            'store_id' => $store->id,
            'store_name' => $store->name,
            'recipient' => $storeAdminEmail,
            'reactivated_at' => now()
        ]);
    }

    /**
     * Get store admin email
     */
    private function getStoreAdminEmail(Store $store): ?string
    {
        // Prioridad: admin_email, luego email de la tienda, luego email del usuario admin
        return $store->admin_email ?? 
               $store->email ?? 
               $store->users()->where('role', 'store_admin')->first()?->email;
    }

    /**
     * Get dashboard URL for store
     */
    private function getDashboardUrl(Store $store): string
    {
        return route('tenant.admin.billing.index', $store->slug);
    }

    /**
     * Get store frontend URL
     */
    private function getStoreUrl(Store $store): string
    {
        return route('tenant.store', $store->slug);
    }

    /**
     * Get urgency message based on days overdue
     */
    private function getUrgencyMessage(int $daysOverdue): string
    {
        return match(true) {
            $daysOverdue <= 3 => 'Tu factura acaba de vencer. Por favor, realiza el pago lo antes posible.',
            $daysOverdue <= 7 => 'Tu factura lleva varios días vencida. Es importante que realices el pago pronto.',
            $daysOverdue <= 15 => '⚠️ Tu factura está significativamente vencida. Riesgo de suspensión.',
            $daysOverdue <= 25 => '🚨 URGENTE: Tu factura está muy vencida. Suspensión inminente.',
            default => '🔥 CRÍTICO: Tu tienda puede ser suspendida en cualquier momento.'
        };
    }

    /**
     * Get warning messages based on warning type
     */
    private function getWarningMessages(string $warningType, int $daysOverdue): array
    {
        return match($warningType) {
            'first_warning' => [
                'urgency_message' => 'Primera notificación: Tu factura lleva ' . $daysOverdue . ' días vencida.',
                'suspension_warning' => 'Si no realizas el pago en los próximos días, tu tienda podría ser suspendida.',
            ],
            'second_warning' => [
                'urgency_message' => '⚠️ Segundo aviso: Tu factura lleva ' . $daysOverdue . ' días vencida.',
                'suspension_warning' => 'IMPORTANTE: Tu tienda será suspendida automáticamente si no pagas pronto.',
            ],
            'final_warning' => [
                'urgency_message' => '🚨 ÚLTIMO AVISO: Tu factura lleva ' . $daysOverdue . ' días vencida.',
                'suspension_warning' => 'URGENTE: Tu tienda será suspendida automáticamente en los próximos días si no realizas el pago.',
            ],
            default => [
                'urgency_message' => $this->getUrgencyMessage($daysOverdue),
                'suspension_warning' => 'Contacta con soporte para evitar la suspensión.',
            ]
        };
    }
}
