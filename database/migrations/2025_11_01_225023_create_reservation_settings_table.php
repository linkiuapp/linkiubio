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
        Schema::create('reservation_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->unique()->constrained('stores')->onDelete('cascade');
            
            // Horarios (JSON)
            // Ejemplo: {"monday": [{"start":"12:00","end":"15:00"},{"start":"18:00","end":"22:00"}], ...}
            $table->json('time_slots')->nullable();
            
            // Configuración de slots
            $table->integer('slot_duration')->default(60); // minutos
            
            // Anticipo
            $table->boolean('require_deposit')->default(false);
            $table->decimal('deposit_per_person', 10, 2)->default(0);
            
            // Notificaciones
            $table->boolean('send_confirmation')->default(true);
            $table->boolean('send_reminder')->default(true);
            $table->integer('reminder_hours')->default(24);
            
            // Anticipación mínima (horas antes de la reserva)
            $table->integer('min_advance_hours')->default(2);
            
            $table->timestamps();
            
            // Índices
            $table->index('store_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_settings');
    }
};
