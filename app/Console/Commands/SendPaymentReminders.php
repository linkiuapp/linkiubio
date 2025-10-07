<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Shared\Models\Invoice;
use App\Services\SendGridEmailService;
use App\Models\EmailConfiguration;
use Carbon\Carbon;

class SendPaymentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar recordatorios de pago: 7 días antes, 3 días antes, y 1 día después del vencimiento';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔔 Iniciando envío de recordatorios de pago...');
        
        $emailConfig = EmailConfiguration::getActive();
        
        if (!$emailConfig) {
            $this->error('❌ No hay configuración de email activa');
            return 1;
        }
        
        $sendGridService = new SendGridEmailService();
        $sentCount = 0;
        
        // 1. Facturas que vencen en 7 días
        $sevenDaysReminders = $this->send7DaysReminders($emailConfig, $sendGridService);
        $sentCount += $sevenDaysReminders;
        
        // 2. Facturas que vencen en 3 días (más urgente)
        $threeDaysReminders = $this->send3DaysReminders($emailConfig, $sendGridService);
        $sentCount += $threeDaysReminders;
        
        // 3. Facturas vencidas hace 1 día (último aviso antes de suspensión)
        $overdueReminders = $this->sendOverdueReminders($emailConfig, $sendGridService);
        $sentCount += $overdueReminders;
        
        $this->info("✅ Proceso completado. {$sentCount} emails enviados.");
        
        return 0;
    }
    
    /**
     * Enviar recordatorios 7 días antes del vencimiento
     */
    private function send7DaysReminders(EmailConfiguration $emailConfig, SendGridEmailService $sendGridService): int
    {
        if (!$emailConfig->template_invoice_generated) {
            return 0;
        }
        
        $sevenDaysFromNow = Carbon::now()->addDays(7)->startOfDay();
        
        $invoices = Invoice::where('status', 'pending')
            ->whereDate('due_date', $sevenDaysFromNow)
            ->with('store.admins', 'plan')
            ->get();
        
        $this->info("📧 Enviando {$invoices->count()} recordatorios (7 días antes)...");
        
        $sent = 0;
        foreach ($invoices as $invoice) {
            if ($this->sendInvoiceReminder($invoice, $emailConfig, $sendGridService, '7 días')) {
                $sent++;
            }
        }
        
        return $sent;
    }
    
    /**
     * Enviar recordatorios 3 días antes del vencimiento
     */
    private function send3DaysReminders(EmailConfiguration $emailConfig, SendGridEmailService $sendGridService): int
    {
        if (!$emailConfig->template_invoice_generated) {
            return 0;
        }
        
        $threeDaysFromNow = Carbon::now()->addDays(3)->startOfDay();
        
        $invoices = Invoice::where('status', 'pending')
            ->whereDate('due_date', $threeDaysFromNow)
            ->with('store.admins', 'plan')
            ->get();
        
        $this->warn("⚠️ Enviando {$invoices->count()} recordatorios URGENTES (3 días antes)...");
        
        $sent = 0;
        foreach ($invoices as $invoice) {
            if ($this->sendInvoiceReminder($invoice, $emailConfig, $sendGridService, '3 días')) {
                $sent++;
            }
        }
        
        return $sent;
    }
    
    /**
     * Enviar avisos de facturas vencidas (1 día después)
     */
    private function sendOverdueReminders(EmailConfiguration $emailConfig, SendGridEmailService $sendGridService): int
    {
        if (!$emailConfig->template_invoice_overdue) {
            return 0;
        }
        
        $oneDayAgo = Carbon::now()->subDay()->startOfDay();
        
        $invoices = Invoice::where('status', 'overdue')
            ->whereDate('due_date', $oneDayAgo)
            ->with('store.admins', 'plan')
            ->get();
        
        $this->error("🚨 Enviando {$invoices->count()} avisos de VENCIMIENTO...");
        
        $sent = 0;
        foreach ($invoices as $invoice) {
            if ($this->sendOverdueNotice($invoice, $emailConfig, $sendGridService)) {
                $sent++;
            }
        }
        
        return $sent;
    }
    
    /**
     * Enviar recordatorio de factura individual
     */
    private function sendInvoiceReminder(Invoice $invoice, EmailConfiguration $emailConfig, SendGridEmailService $sendGridService, string $daysRemaining): bool
    {
        try {
            $storeAdmin = $invoice->store->admins()->first();
            
            if (!$storeAdmin) {
                return false;
            }
            
            $emailData = [
                'first_name' => explode(' ', $storeAdmin->name)[0],
                'invoice_number' => $invoice->invoice_number,
                'amount' => '$' . number_format($invoice->amount, 0, ',', '.'),
                'due_date' => $invoice->due_date->format('d/m/Y'),
                'store_name' => $invoice->store->name,
                'invoice_url' => route('tenant.admin.invoices.show', [
                    'store' => $invoice->store->slug,
                    'invoice' => $invoice->id
                ]),
                'days_remaining' => $daysRemaining
            ];
            
            $result = $sendGridService->sendWithTemplate(
                $emailConfig->template_invoice_generated,
                $storeAdmin->email,
                $emailData,
                $storeAdmin->name,
                'billing'
            );
            
            if ($result['success']) {
                $this->line("  ✓ Enviado a {$storeAdmin->email} ({$invoice->invoice_number})");
                return true;
            } else {
                $this->error("  ✗ Error: {$result['message']}");
                return false;
            }
            
        } catch (\Exception $e) {
            $this->error("  ✗ Excepción: {$e->getMessage()}");
            return false;
        }
    }
    
    /**
     * Enviar aviso de factura vencida
     */
    private function sendOverdueNotice(Invoice $invoice, EmailConfiguration $emailConfig, SendGridEmailService $sendGridService): bool
    {
        try {
            $storeAdmin = $invoice->store->admins()->first();
            
            if (!$storeAdmin) {
                return false;
            }
            
            $daysOverdue = Carbon::now()->diffInDays($invoice->due_date);
            $suspensionDate = Carbon::now()->addDays(6); // 7 días total de gracia
            
            $emailData = [
                'first_name' => explode(' ', $storeAdmin->name)[0],
                'invoice_number' => $invoice->invoice_number,
                'amount' => '$' . number_format($invoice->amount, 0, ',', '.'),
                'days_overdue' => (string)$daysOverdue,
                'payment_url' => route('tenant.admin.billing.index', ['store' => $invoice->store->slug]),
                'suspension_date' => $suspensionDate->format('d/m/Y')
            ];
            
            $result = $sendGridService->sendWithTemplate(
                $emailConfig->template_invoice_overdue,
                $storeAdmin->email,
                $emailData,
                $storeAdmin->name,
                'billing'
            );
            
            if ($result['success']) {
                $this->line("  ✓ Aviso vencimiento enviado a {$storeAdmin->email}");
                return true;
            } else {
                $this->error("  ✗ Error: {$result['message']}");
                return false;
            }
            
        } catch (\Exception $e) {
            $this->error("  ✗ Excepción: {$e->getMessage()}");
            return false;
        }
    }
}
