<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Shared\Models\HotelReservation;
use App\Shared\Models\HotelSetting;
use App\Services\WhatsAppNotificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendHotelCheckinReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hotel-reservations:send-checkin-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar recordatorios WhatsApp de check-in para reservas de hotel confirmadas según configuración de cada tienda';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔔 Iniciando envío de recordatorios de check-in para hoteles...');
        
        $whatsapp = app(WhatsAppNotificationService::class);
        
        if (!$whatsapp->isEnabled()) {
            $this->warn('⚠️ WhatsApp no está habilitado. Saltando envío de recordatorios.');
            return 0;
        }
        
        $sentCount = 0;
        $skippedCount = 0;
        $errorCount = 0;
        
        // Obtener todas las tiendas con configuración de recordatorios de check-in
        $settings = HotelSetting::where('send_checkin_reminder', true)
            ->with('store')
            ->get();
        
        foreach ($settings as $setting) {
            $reminderHours = $setting->reminder_hours ?? 24;
            
            // Buscar reservas confirmadas de esta tienda que:
            // 1. Estén confirmadas (aún no han hecho check-in)
            // 2. No hayan recibido recordatorio aún
            // 3. El check-in esté en el futuro
            $reservations = HotelReservation::where('store_id', $setting->store_id)
                ->where('status', 'confirmed')
                ->whereNull('reminder_sent_at')
                ->whereDate('check_in_date', '>=', today())
                ->with(['store', 'roomType', 'room'])
                ->get();
            
            foreach ($reservations as $reservation) {
                // Calcular la fecha/hora de check-in
                $checkInDate = Carbon::parse($reservation->check_in_date);
                $checkInTime = Carbon::parse($setting->check_in_time ?? '15:00:00');
                $checkInDateTime = $checkInDate->copy()->setTimeFromTimeString($checkInTime);
                
                // Verificar que el check-in aún no haya pasado
                if ($checkInDateTime->isPast()) {
                    $skippedCount++;
                    continue;
                }
                
                // Calcular horas hasta el check-in
                $hoursUntilCheckIn = Carbon::now()->diffInHours($checkInDateTime, false);
                
                // Verificar si estamos dentro del rango correcto para enviar recordatorio
                $hoursDifference = abs($hoursUntilCheckIn - $reminderHours);
                
                if ($hoursDifference > 1) {
                    // Muy temprano o muy tarde, saltar
                    $skippedCount++;
                    continue;
                }
                
                try {
                    // Enviar recordatorio
                    $success = $whatsapp->notifyHotelCheckinReminder($reservation);
                    
                    if ($success) {
                        // Marcar como enviado
                        $reservation->update(['reminder_sent_at' => now()]);
                        $sentCount++;
                        $this->line("  ✓ Recordatorio enviado: {$reservation->reservation_code} ({$reservation->store->name}) - Check-in en ~{$hoursUntilCheckIn}h");
                    } else {
                        $errorCount++;
                        $this->error("  ✗ Error enviando recordatorio: {$reservation->reservation_code}");
                    }
                } catch (\Exception $e) {
                    $errorCount++;
                    Log::error('Error enviando recordatorio de check-in', [
                        'reservation_id' => $reservation->id,
                        'error' => $e->getMessage()
                    ]);
                    $this->error("  ✗ Excepción: {$reservation->reservation_code} - {$e->getMessage()}");
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

