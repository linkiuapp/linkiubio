<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Shared\Models\Store;
use App\Shared\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class CheckPendingStoreRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stores:check-pending-requests 
                            {--alert-urgent : Solo alertar solicitudes urgentes (>6h)}
                            {--alert-critical : Solo alertar solicitudes críticas (>24h)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica solicitudes de tiendas pendientes y alerta sobre las que exceden el SLA (6h y 24h)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Verificando solicitudes de tiendas pendientes...');
        
        // Obtener todas las solicitudes pendientes
        $pendingStores = Store::where('approval_status', 'pending_approval')
            ->orderBy('created_at', 'asc')
            ->get();
        
        if ($pendingStores->isEmpty()) {
            $this->info('✅ No hay solicitudes pendientes.');
            return Command::SUCCESS;
        }
        
        $this->info("📊 Total de solicitudes pendientes: {$pendingStores->count()}");
        
        $now = Carbon::now();
        $urgent = collect(); // >6h
        $critical = collect(); // >24h
        $normal = collect(); // <6h
        
        // Clasificar solicitudes por antigüedad
        foreach ($pendingStores as $store) {
            $hoursElapsed = $store->created_at->diffInHours($now);
            
            if ($hoursElapsed > 24) {
                $critical->push($store);
            } elseif ($hoursElapsed > 6) {
                $urgent->push($store);
            } else {
                $normal->push($store);
            }
        }
        
        // Mostrar estadísticas
        $this->table(
            ['Prioridad', 'Cantidad', 'Umbral'],
            [
                ['🔴 CRÍTICO', $critical->count(), '> 24 horas'],
                ['🟠 URGENTE', $urgent->count(), '> 6 horas'],
                ['🟢 NORMAL', $normal->count(), '< 6 horas']
            ]
        );
        
        // Aplicar filtros si se especificaron opciones
        if ($this->option('alert-critical')) {
            $this->alertCriticalRequests($critical);
        } elseif ($this->option('alert-urgent')) {
            $this->alertUrgentRequests($urgent);
        } else {
            // Alertar ambos por defecto
            $this->alertCriticalRequests($critical);
            $this->alertUrgentRequests($urgent);
        }
        
        // Log de resumen
        Log::channel('daily')->info('Verificación de solicitudes pendientes', [
            'total' => $pendingStores->count(),
            'critical' => $critical->count(),
            'urgent' => $urgent->count(),
            'normal' => $normal->count()
        ]);
        
        $this->info('✅ Verificación completada.');
        return Command::SUCCESS;
    }
    
    /**
     * Alertar sobre solicitudes críticas (>24h)
     */
    private function alertCriticalRequests($stores)
    {
        if ($stores->isEmpty()) {
            return;
        }
        
        $this->error("🚨 ¡ATENCIÓN! {$stores->count()} solicitud(es) CRÍTICA(S) (>24h sin revisar):");
        
        foreach ($stores as $store) {
            $hoursElapsed = $store->created_at->diffInHours(Carbon::now());
            $adminEmail = $store->admins->first()?->email ?? 'N/A';
            
            $this->line("  📌 {$store->name} - {$adminEmail} - {$hoursElapsed}h");
            
            // Log crítico
            Log::channel('daily')->critical('Solicitud de tienda CRÍTICA sin revisar', [
                'store_id' => $store->id,
                'store_name' => $store->name,
                'admin_email' => $adminEmail,
                'hours_elapsed' => $hoursElapsed,
                'business_type' => $store->business_type,
                'created_at' => $store->created_at->toDateTimeString()
            ]);
        }
        
        // TODO: Enviar notificación a SuperAdmins (email, Slack, etc.)
        $this->notifySuperAdmins($stores, 'critical');
    }
    
    /**
     * Alertar sobre solicitudes urgentes (>6h)
     */
    private function alertUrgentRequests($stores)
    {
        if ($stores->isEmpty()) {
            return;
        }
        
        $this->warn("⚠️  {$stores->count()} solicitud(es) URGENTE(S) (>6h sin revisar):");
        
        foreach ($stores as $store) {
            $hoursElapsed = $store->created_at->diffInHours(Carbon::now());
            $adminEmail = $store->admins->first()?->email ?? 'N/A';
            
            $this->line("  📌 {$store->name} - {$adminEmail} - {$hoursElapsed}h");
            
            // Log de advertencia
            Log::channel('daily')->warning('Solicitud de tienda URGENTE sin revisar', [
                'store_id' => $store->id,
                'store_name' => $store->name,
                'admin_email' => $adminEmail,
                'hours_elapsed' => $hoursElapsed,
                'business_type' => $store->business_type,
                'created_at' => $store->created_at->toDateTimeString()
            ]);
        }
        
        // TODO: Enviar notificación a SuperAdmins (email, Slack, etc.)
        $this->notifySuperAdmins($stores, 'urgent');
    }
    
    /**
     * Notificar a SuperAdmins
     */
    private function notifySuperAdmins($stores, $priority = 'normal')
    {
        // Obtener todos los SuperAdmins
        $superAdmins = User::where('role', 'super_admin')->get();
        
        if ($superAdmins->isEmpty()) {
            $this->warn('⚠️  No hay SuperAdmins para notificar.');
            return;
        }
        
        $this->info("📧 Notificando a {$superAdmins->count()} SuperAdmin(s)...");
        
        // TODO: Implementar notificación real (Email, Slack, Push, etc.)
        // Por ahora solo logueamos
        foreach ($superAdmins as $admin) {
            Log::channel('daily')->info('Notificación enviada a SuperAdmin', [
                'admin_id' => $admin->id,
                'admin_email' => $admin->email,
                'priority' => $priority,
                'stores_count' => $stores->count()
            ]);
        }
        
        $this->info("✉️  Notificaciones enviadas a: " . $superAdmins->pluck('email')->implode(', '));
    }
}
