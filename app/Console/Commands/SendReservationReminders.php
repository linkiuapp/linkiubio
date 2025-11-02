<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Shared\Models\Reservation;
use App\Shared\Models\ReservationSetting;
use App\Services\WhatsAppNotificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendReservationReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar recordatorios WhatsApp de reservaciones confirmadas según configuración de cada tienda';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔔 Iniciando envío de recordatorios de reservaciones...');
        
        $whatsapp = app(WhatsAppNotificationService::class);
        
        if (!$whatsapp->isEnabled()) {
            $this->warn('⚠️ WhatsApp no está habilitado. Saltando envío de recordatorios.');
            return 0;
        }
        
        $sentCount = 0;
        $skippedCount = 0;
        $errorCount = 0;
        
        // Obtener todas las tiendas con reservaciones activas y configuración de recordatorios
        $settings = ReservationSetting::where('send_reminder', true)
            ->with('store')
            ->get();
        
        foreach ($settings as $setting) {
            $reminderHours = $setting->reminder_hours ?? 24;
            
            // Buscar reservaciones confirmadas de esta tienda que:
            // 1. Estén confirmadas
            // 2. No hayan recibido recordatorio aún
            // 3. La fecha/hora de reserva esté en el futuro
            $reservations = Reservation::where('store_id', $setting->store_id)
                ->where('status', 'confirmed')
                ->whereNull('reminder_sent_at')
                ->where(function($query) {
                    $query->whereDate('reservation_date', '>', now())
                        ->orWhere(function($q) {
                            $q->whereDate('reservation_date', '=', now())
                              ->whereTime('reservation_time', '>', now()->format('H:i'));
                        });
                })
                ->with(['store', 'table'])
                ->get();
            
            foreach ($reservations as $reservation) {
                // Calcular la fecha/hora completa de la reserva
                $reservationDateTime = Carbon::parse($reservation->reservation_date . ' ' . $reservation->reservation_time);
                
                // Verificar que la reserva aún no haya pasado
                if ($reservationDateTime->isPast()) {
                    $skippedCount++;
                    continue;
                }
                
                // Calcular horas hasta la reserva
                $hoursUntilReservation = Carbon::now()->diffInHours($reservationDateTime, false);
                
                // Verificar si estamos dentro del rango correcto para enviar recordatorio
                // Permitimos un margen de ±1 hora para que el comando pueda ejecutarse cada 2 horas
                $hoursDifference = abs($hoursUntilReservation - $reminderHours);
                
                if ($hoursDifference > 1) {
                    // Muy temprano o muy tarde, saltar
                    $skippedCount++;
                    continue;
                }
                
                try {
                    // Enviar recordatorio
                    $success = $whatsapp->notifyReservationReminder($reservation);
                    
                    if ($success) {
                        // Marcar como enviado
                        $reservation->update(['reminder_sent_at' => now()]);
                        $sentCount++;
                        $this->line("  ✓ Recordatorio enviado: {$reservation->reference_code} ({$reservation->store->name}) - Faltan ~{$hoursUntilReservation}h");
                    } else {
                        $errorCount++;
                        $this->error("  ✗ Error enviando recordatorio: {$reservation->reference_code}");
                    }
                } catch (\Exception $e) {
                    $errorCount++;
                    Log::error('Error enviando recordatorio de reserva', [
                        'reservation_id' => $reservation->id,
                        'error' => $e->getMessage()
                    ]);
                    $this->error("  ✗ Excepción: {$reservation->reference_code} - {$e->getMessage()}");
                }
            }
        }
        
        $this->info("✅ Proceso completado:");
        $this->info("   - {$sentCount} recordatorios enviados");
        $this->info("   - {$skippedCount} reservas omitidas");
        if ($errorCount > 0) {
            $this->warn("   - {$errorCount} errores");
        }
        
        return 0;
    }
}

