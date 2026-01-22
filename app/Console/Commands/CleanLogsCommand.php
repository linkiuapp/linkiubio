<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CleanLogsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitoring:clean-logs {--days=30 : Número de días a mantener}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpiar logs antiguos de monitoreo de la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = (int) $this->option('days');
        $cutoffDate = Carbon::now()->subDays($days);
        
        $this->info("🧹 Limpiando logs más antiguos de {$days} días (antes del {$cutoffDate->format('d/m/Y H:i')})...");
        
        $totalDeleted = 0;
        
        // Limpiar error_logs
        $errorLogsDeleted = DB::table('error_logs')
            ->where('created_at', '<', $cutoffDate)
            ->delete();
        $this->line("   ✓ error_logs: {$errorLogsDeleted} registros eliminados");
        $totalDeleted += $errorLogsDeleted;
        
        // Limpiar traffic_logs
        $trafficLogsDeleted = DB::table('traffic_logs')
            ->where('logged_at', '<', $cutoffDate)
            ->delete();
        $this->line("   ✓ traffic_logs: {$trafficLogsDeleted} registros eliminados");
        $totalDeleted += $trafficLogsDeleted;
        
        // Limpiar performance_logs
        $performanceLogsDeleted = DB::table('performance_logs')
            ->where('logged_at', '<', $cutoffDate)
            ->delete();
        $this->line("   ✓ performance_logs: {$performanceLogsDeleted} registros eliminados");
        $totalDeleted += $performanceLogsDeleted;
        
        $this->newLine();
        $this->info("✅ Limpieza completada. Total: {$totalDeleted} registros eliminados.");
        
        return 0;
    }
}
