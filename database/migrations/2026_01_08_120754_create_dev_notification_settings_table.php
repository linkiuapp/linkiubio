<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dev_notification_settings', function (Blueprint $table) {
            $table->id();
            $table->string('whatsapp_number'); // Tu número para notificaciones
            $table->string('country_code', 5)->default('+57');
            
            // Resumen diario
            $table->boolean('daily_summary_enabled')->default(true);
            $table->time('daily_summary_time')->default('07:00:00'); // Hora del resumen
            
            // Recordatorios de tareas
            $table->boolean('task_reminders_enabled')->default(true);
            $table->integer('default_reminder_minutes')->default(30); // Minutos default para tareas nuevas
            
            // Notificaciones a clientes
            $table->boolean('client_notifications_enabled')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dev_notification_settings');
    }
};
