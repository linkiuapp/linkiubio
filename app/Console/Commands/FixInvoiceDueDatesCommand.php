<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Shared\Models\Invoice;
use App\Shared\Models\Subscription;
use Carbon\Carbon;

class FixInvoiceDueDatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'billing:fix-due-dates {--dry-run : Show what would be done without actually doing it}';

    /**
     * The console command description.
     */
    protected $description = 'Fix invoice due_dates to match subscription period_end dates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        
        if ($isDryRun) {
            $this->warn('🔍 DRY RUN MODE - No changes will be made');
            $this->newLine();
        }

        $this->info('🔧 Fixing invoice due_dates...');
        $this->newLine();

        // Obtener todas las facturas con suscripción
        $invoices = Invoice::whereNotNull('subscription_id')
            ->with(['subscription'])
            ->get();

        $fixed = 0;
        $skipped = 0;
        $errors = 0;

        foreach ($invoices as $invoice) {
            if (!$invoice->subscription) {
                $this->line("  ⚠️  Invoice #{$invoice->invoice_number} - No subscription found");
                $errors++;
                continue;
            }

            $subscription = $invoice->subscription;
            $correctDueDate = Carbon::parse($subscription->current_period_end);
            $currentDueDate = Carbon::parse($invoice->due_date);

            // Si ya coinciden, saltar
            if ($correctDueDate->isSameDay($currentDueDate)) {
                $skipped++;
                continue;
            }

            $diff = $currentDueDate->diffInDays($correctDueDate, false);
            $storeName = $invoice->store ? $invoice->store->name : 'Unknown';

            $this->line("  📄 Invoice #{$invoice->invoice_number} (Store: {$storeName})");
            $this->line("     Current due_date: {$currentDueDate->format('Y-m-d')}");
            $this->line("     Correct due_date: {$correctDueDate->format('Y-m-d')}");
            $this->line("     Difference: {$diff} days");

            if (!$isDryRun) {
                $invoice->update(['due_date' => $correctDueDate->toDateString()]);
                $this->line("     <fg=green>✓ Fixed</>");
                $fixed++;
            } else {
                $this->line("     <fg=blue>Would fix</>");
                $fixed++;
            }

            $this->newLine();
        }

        // Resumen
        $this->newLine();
        $this->info('📊 Summary:');
        $this->line("  • Total invoices checked: " . $invoices->count());
        $this->line("  • Fixed: <fg=green>{$fixed}</>");
        $this->line("  • Already correct: <fg=blue>{$skipped}</>");
        if ($errors > 0) {
            $this->line("  • Errors: <fg=red>{$errors}</>");
        }

        if ($isDryRun && $fixed > 0) {
            $this->newLine();
            $this->warn('⚠️  This was a DRY RUN. Run without --dry-run to apply changes.');
        } elseif ($fixed > 0) {
            $this->newLine();
            $this->info('✅ All due_dates have been fixed!');
        } else {
            $this->newLine();
            $this->info('✅ All due_dates are already correct!');
        }

        return 0;
    }
}
