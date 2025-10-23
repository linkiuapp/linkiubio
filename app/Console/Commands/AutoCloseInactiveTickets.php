<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Shared\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AutoCloseInactiveTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:auto-close-inactive
                            {--days=7 : Número de días de inactividad antes de cerrar}
                            {--dry-run : Mostrar qué tickets se cerrarían sin cerrarlos realmente}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cierra automáticamente tickets resueltos que llevan más de X días sin actividad';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = (int) $this->option('days');
        $dryRun = $this->option('dry-run');
        
        $this->info("🔍 Buscando tickets resueltos con {$days}+ días de inactividad...");
        
        // Buscar tickets resueltos que no han tenido actividad en X días
        $inactiveSince = Carbon::now()->subDays($days);
        
        $tickets = Ticket::where('status', 'resolved')
            ->where('resolved_at', '<=', $inactiveSince)
            ->whereDoesntHave('responses', function ($query) use ($inactiveSince) {
                $query->where('created_at', '>', $inactiveSince);
            })
            ->with('store')
            ->get();
        
        if ($tickets->isEmpty()) {
            $this->info('✅ No hay tickets para cerrar automáticamente');
            return Command::SUCCESS;
        }
        
        $this->info("📋 Encontrados {$tickets->count()} ticket(s) para cerrar:");
        
        $closedCount = 0;
        $table = [];
        
        foreach ($tickets as $ticket) {
            $table[] = [
                $ticket->ticket_number,
                $ticket->store->name ?? 'N/A',
                $ticket->title,
                $ticket->resolved_at->diffInDays(now()) . ' días',
                $ticket->resolved_at->format('d/m/Y H:i')
            ];
            
            if (!$dryRun) {
                // Cerrar el ticket
                $ticket->markAsClosed();
                
                // Agregar nota interna
                $ticket->addResponse(
                    null, // Sistema
                    "Ticket cerrado automáticamente por inactividad después de {$days} días sin respuesta",
                    'status_change',
                    false
                );
                
                // Enviar email de notificación al Tenant Admin
                $this->sendAutoClosedEmail($ticket, $days);
                
                $closedCount++;
            }
        }
        
        $this->table(
            ['Ticket', 'Tienda', 'Título', 'Inactivo', 'Resuelto el'],
            $table
        );
        
        if ($dryRun) {
            $this->warn('🧪 DRY RUN: No se cerraron tickets realmente');
            $this->info("💡 Ejecuta sin --dry-run para cerrar estos {$tickets->count()} tickets");
        } else {
            $this->info("✅ Se cerraron {$closedCount} tickets automáticamente");
            
            Log::info('🤖 Auto-cierre de tickets inactivos completado', [
                'tickets_closed' => $closedCount,
                'days_inactive' => $days,
                'executed_at' => now()->toDateTimeString()
            ]);
        }
        
        return Command::SUCCESS;
    }
    
    /**
     * Enviar email de ticket cerrado automáticamente
     */
    private function sendAutoClosedEmail(Ticket $ticket, int $days): void
    {
        try {
            $storeAdmin = $ticket->store->admins()->first();
            
            if (!$storeAdmin) {
                Log::warning('📧 No se pudo enviar email de auto-cierre (sin admin)', [
                    'ticket_id' => $ticket->id,
                    'ticket_number' => $ticket->ticket_number
                ]);
                return;
            }
            
            \App\Jobs\SendEmailJob::dispatch('template', $storeAdmin->email, [
                'template_key' => 'ticket_auto_closed',
                'variables' => [
                    'user_name' => $storeAdmin->name,
                    'store_name' => $ticket->store->name,
                    'ticket_number' => $ticket->ticket_number,
                    'ticket_title' => $ticket->title,
                    'closed_date' => now()->format('d/m/Y H:i'),
                    'days_inactive' => (string) $days,
                    'reopen_message' => 'Si el problema persiste, puedes reabrir este ticket desde tu panel de administración.',
                    'ticket_url' => route('tenant.admin.tickets.show', [
                        'store' => $ticket->store->slug,
                        'ticket' => $ticket->id
                    ])
                ]
            ]);
            
            Log::info('📧 Email de auto-cierre enviado', [
                'ticket_id' => $ticket->id,
                'ticket_number' => $ticket->ticket_number,
                'admin_email' => $storeAdmin->email
            ]);
            
        } catch (\Exception $e) {
            Log::error('❌ Error enviando email de auto-cierre', [
                'ticket_id' => $ticket->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
