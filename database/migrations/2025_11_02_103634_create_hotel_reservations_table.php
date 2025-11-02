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
        Schema::create('hotel_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->foreignId('room_type_id')->constrained('room_types')->onDelete('cascade');
            $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('set null'); // asignada al confirmar
            
            // Código de reserva único
            $table->string('reservation_code', 20)->unique(); // "HTL-20251115-001"
            
            // Fechas
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('num_nights'); // calculado
            $table->string('estimated_arrival_time', 50)->nullable(); // "2:00 PM - 3:00 PM"
            
            // Huéspedes
            $table->integer('num_adults')->default(1);
            $table->integer('num_children')->default(0);
            
            // Datos huésped principal
            $table->string('guest_name', 255);
            $table->string('guest_phone', 20);
            $table->string('guest_email', 255)->nullable();
            $table->string('guest_document', 100)->nullable(); // cédula/pasaporte
            
            // Pricing
            $table->decimal('base_price_per_night', 10, 2); // precio base de la habitación
            $table->decimal('extra_person_charge', 10, 2)->default(0); // cargo por personas extra
            $table->decimal('services_total', 10, 2)->default(0); // total servicios adicionales
            $table->decimal('subtotal', 10, 2); // (base + extra_person + services) × nights
            $table->decimal('security_deposit', 10, 2)->default(0); // depósito de seguridad
            $table->decimal('deposit_amount', 10, 2); // anticipo requerido
            $table->boolean('deposit_paid')->default(false);
            $table->string('payment_proof', 255)->nullable(); // path al archivo
            $table->decimal('total', 10, 2); // subtotal + security_deposit
            
            // Servicios adicionales seleccionados (JSON)
            $table->json('selected_services')->nullable();
            // Ejemplo: [{"name":"Spa","price":50000,"quantity":2}]
            
            // Estado
            $table->enum('status', ['pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled'])->default('pending');
            
            // Notas
            $table->text('special_requests')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->text('admin_notes')->nullable();
            
            // Control
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null'); // admin que creó
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('checked_out_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('reminder_sent_at')->nullable();
            
            $table->timestamps();
            
            // Índices para optimización
            $table->index(['store_id', 'check_in_date', 'check_out_date']);
            $table->index(['store_id', 'status']);
            $table->index(['room_type_id', 'status']);
            $table->index(['check_in_date', 'check_out_date']);
            $table->index('reservation_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_reservations');
    }
};
