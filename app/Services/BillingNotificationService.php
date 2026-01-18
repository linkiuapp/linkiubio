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
     * Send preventive warning (before due date)
     */
    public function sendPreventiveWarning(Invoice $invoice, string $warningType, int $daysBefore): void
    {
        $storeAdminEmail = $this->getStoreAdminEmail($invoice->store);
        
        if (!$storeAdminEmail) {
            return;
        }

        $warningMessages = $this->getPreventiveWarningMessages($warningType, $daysBefore);

        SendEmailJob::dispatch(
            'template',
            $storeAdminEmail,
            [
                'template_key' => 'invoice_due_reminder',
                'variables' => array_merge([
                    'store_name' => $invoice->store->name,
                    'invoice_number' => $invoice->invoice_number,
                    'amount' => $invoice->getFormattedAmount(),
                    'due_date' => $invoice->due_date->format('d/m/Y'),
                    'days_before' => $daysBefore,
                    'days_remaining' => $daysBefore,
                    'plan_name' => $invoice->plan->name,
                    'period' => $invoice->getPeriodLabel(),
                    'support_email' => config('app.support_email', 'soporte@linkiu.bio'),
                    'dashboard_url' => $this->getDashboardUrl($invoice->store)
                ], $warningMessages)
            ]
        );

        \Log::info('Aviso preventivo de factura enviado', [
            'invoice_id' => $invoice->id,
            'store_id' => $invoice->store_id,
            'recipient' => $storeAdminEmail,
            'warning_type' => $warningType,
            'days_before' => $daysBefore
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
     * Get preventive warning messages (before due date)
     */
    private function getPreventiveWarningMessages(string $warningType, int $daysBefore): array
    {
        return match($warningType) {
            'preventive_15_days' => [
                'urgency_message' => 'Recordatorio: Tu factura vence en ' . $daysBefore . ' días.',
                'suspension_warning' => 'Asegúrate de realizar el pago antes de la fecha de vencimiento para evitar la suspensión de tu tienda.',
                'reminder_type' => 'Recordatorio temprano',
            ],
            'preventive_7_days' => [
                'urgency_message' => 'Recordatorio: Tu factura vence en ' . $daysBefore . ' días.',
                'suspension_warning' => 'Recuerda realizar el pago antes de la fecha de vencimiento para mantener tu tienda activa.',
                'reminder_type' => 'Recordatorio medio',
            ],
            'preventive_5_days' => [
                'urgency_message' => '⚠️ URGENTE: Tu factura vence en ' . $daysBefore . ' días.',
                'suspension_warning' => 'IMPORTANTE: Realiza el pago antes del vencimiento para evitar la suspensión automática de tu tienda.',
                'reminder_type' => 'Recordatorio urgente',
            ],
            default => [
                'urgency_message' => 'Tu factura vence en ' . $daysBefore . ' días.',
                'suspension_warning' => 'Realiza el pago antes de la fecha de vencimiento.',
                'reminder_type' => 'Recordatorio',
            ]
        };
    }

    /**
     * Get warning messages based on warning type (corrective warnings after due date)
     */
    private function getWarningMessages(string $warningType, int $daysOverdue): array
    {
        return match($warningType) {
            'overdue_1_day' => [
                'urgency_message' => '🚨 Tu factura está vencida desde hace ' . $daysOverdue . ' día.',
                'suspension_warning' => 'URGENTE: Tu tienda será suspendida automáticamente si no realizas el pago pronto.',
            ],
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

    /**
     * Send trial expiration warning (days before trial ends)
     */
    public function sendTrialExpirationWarning(Store $store, $subscription, int $daysBefore): void
    {
        $storeAdminEmail = $this->getStoreAdminEmail($store);
        
        if (!$storeAdminEmail) {
            return;
        }

        SendEmailJob::dispatch(
            'template',
            $storeAdminEmail,
            [
                'template_key' => 'trial_expiration_warning',
                'variables' => [
                    'store_name' => $store->name,
                    'plan_name' => $subscription->plan->name ?? 'Tu plan',
                    'days_remaining' => $daysBefore,
                    'trial_end_date' => $subscription->trial_end->format('d/m/Y'),
                    'amount_to_pay' => '$' . number_format($subscription->plan->getPriceForPeriod($subscription->billing_cycle), 0, ',', '.'),
                    'billing_cycle' => $this->getBillingCycleLabel($subscription->billing_cycle),
                    'action_required' => $daysBefore <= 1 
                        ? '¡Tu período de prueba termina mañana! Realiza el pago para continuar usando tu tienda.'
                        : "Quedan {$daysBefore} días de tu período de prueba. Prepárate para continuar con tu plan.",
                    'dashboard_url' => $this->getDashboardUrl($store),
                    'checkout_url' => route('tenant.admin.billing.checkout', $store->slug),
                    'support_email' => config('app.support_email', 'soporte@linkiu.bio'),
                ]
            ]
        );

        \Log::info('Aviso de vencimiento de trial enviado', [
            'store_id' => $store->id,
            'store_name' => $store->name,
            'days_before' => $daysBefore,
            'trial_end' => $subscription->trial_end,
        ]);
    }

    /**
     * Send invoice notification when trial ends
     */
    public function sendTrialEndedInvoice(Store $store, Invoice $invoice): void
    {
        $storeAdminEmail = $this->getStoreAdminEmail($store);
        
        if (!$storeAdminEmail) {
            return;
        }

        SendEmailJob::dispatch(
            'template',
            $storeAdminEmail,
            [
                'template_key' => 'trial_ended_invoice',
                'variables' => [
                    'store_name' => $store->name,
                    'plan_name' => $invoice->plan->name ?? 'Tu plan',
                    'invoice_number' => $invoice->invoice_number,
                    'amount' => $invoice->getFormattedAmount(),
                    'due_date' => $invoice->due_date->format('d/m/Y'),
                    'days_to_pay' => $invoice->due_date->diffInDays(now()),
                    'grace_period_message' => 'Tienes un período de gracia de 3 días para realizar el pago sin interrupción del servicio.',
                    'dashboard_url' => $this->getDashboardUrl($store),
                    'checkout_url' => route('tenant.admin.billing.checkout', $store->slug),
                    'support_email' => config('app.support_email', 'soporte@linkiu.bio'),
                ]
            ]
        );

        \Log::info('Factura de fin de trial enviada', [
            'store_id' => $store->id,
            'invoice_id' => $invoice->id,
            'amount' => $invoice->amount,
        ]);
    }

    /**
     * Send grace period warning
     */
    public function sendGracePeriodWarning(Store $store, $subscription, int $daysLeft): void
    {
        $storeAdminEmail = $this->getStoreAdminEmail($store);
        
        if (!$storeAdminEmail) {
            return;
        }

        SendEmailJob::dispatch(
            'template',
            $storeAdminEmail,
            [
                'template_key' => 'grace_period_warning',
                'variables' => [
                    'store_name' => $store->name,
                    'plan_name' => $subscription->plan->name ?? 'Tu plan',
                    'days_left' => $daysLeft,
                    'grace_end_date' => $subscription->grace_period_end->format('d/m/Y'),
                    'urgency_message' => $daysLeft <= 1 
                        ? '🚨 URGENTE: Tu período de gracia termina mañana. Realiza el pago hoy para evitar la suspensión.'
                        : "Quedan {$daysLeft} días de período de gracia. Paga ahora para evitar interrupciones.",
                    'suspension_warning' => 'Si no pagas antes del fin del período de gracia, tu tienda será suspendida automáticamente.',
                    'dashboard_url' => $this->getDashboardUrl($store),
                    'checkout_url' => route('tenant.admin.billing.checkout', $store->slug),
                    'support_email' => config('app.support_email', 'soporte@linkiu.bio'),
                ]
            ]
        );

        \Log::info('Aviso de período de gracia enviado', [
            'store_id' => $store->id,
            'days_left' => $daysLeft,
            'grace_period_end' => $subscription->grace_period_end,
        ]);
    }

    /**
     * Send trial suspension notification
     */
    public function sendTrialSuspensionNotification(Store $store, $subscription): void
    {
        $storeAdminEmail = $this->getStoreAdminEmail($store);
        
        if (!$storeAdminEmail) {
            return;
        }

        SendEmailJob::dispatch(
            'template',
            $storeAdminEmail,
            [
                'template_key' => 'trial_suspension',
                'variables' => [
                    'store_name' => $store->name,
                    'plan_name' => $subscription->plan->name ?? 'Tu plan',
                    'suspension_date' => now()->format('d/m/Y H:i'),
                    'suspension_reason' => 'Tu período de prueba finalizó y no se registró ningún pago.',
                    'reactivation_instructions' => 'Para reactivar tu tienda, realiza el pago de tu suscripción.',
                    'data_preservation' => 'Todos tus datos (productos, categorías, configuraciones) están seguros y serán preservados.',
                    'amount_to_pay' => '$' . number_format($subscription->plan->getPriceForPeriod($subscription->billing_cycle), 0, ',', '.'),
                    'checkout_url' => route('tenant.admin.billing.checkout', $store->slug),
                    'support_email' => config('app.support_email', 'soporte@linkiu.bio'),
                    'support_phone' => config('app.support_phone', '+57 310 459 4344'),
                ]
            ]
        );

        \Log::warning('Notificación de suspensión por trial vencido enviada', [
            'store_id' => $store->id,
            'store_name' => $store->name,
            'suspended_at' => now(),
        ]);
    }

    /**
     * Get billing cycle label in Spanish
     */
    private function getBillingCycleLabel(string $cycle): string
    {
        return match($cycle) {
            'monthly' => 'Mensual',
            'quarterly' => 'Trimestral',
            'semester' => 'Semestral',
            'annual' => 'Anual',
            default => $cycle
        };
    }
}
