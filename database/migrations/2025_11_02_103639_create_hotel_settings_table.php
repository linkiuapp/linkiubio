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
        Schema::create('hotel_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->unique()->constrained('stores')->onDelete('cascade');
            
            // Horarios
            $table->time('check_in_time')->default('15:00:00'); // 3pm
            $table->time('check_out_time')->default('12:00:00'); // 12pm
            
            // Políticas de pago
            $table->enum('deposit_type', ['percentage', 'fixed'])->default('percentage');
            $table->integer('deposit_percentage')->default(50); // % del total
            $table->decimal('deposit_fixed_amount', 10, 2)->default(0);
            
            // Depósito de seguridad
            $table->boolean('require_security_deposit')->default(false);
            $table->decimal('security_deposit_amount', 10, 2)->default(0);
            
            // Políticas de cancelación
            $table->integer('cancellation_hours')->default(48); // horas antes para reembolso
            
            // Restricciones
            $table->integer('min_guest_age')->default(18);
            $table->integer('min_advance_hours')->default(2); // anticipación mínima
            
            // Notificaciones
            $table->boolean('send_confirmation')->default(true);
            $table->boolean('send_checkin_reminder')->default(true);
            $table->integer('reminder_hours')->default(24); // horas antes del check-in
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_settings');
    }
};
