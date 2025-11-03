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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->foreignId('table_id')->nullable()->constrained('tables')->onDelete('set null');
            
            // Cliente
            $table->string('customer_name', 255);
            $table->string('customer_phone', 20);
            $table->integer('party_size'); // número de personas
            
            // Fecha y hora
            $table->date('reservation_date');
            $table->time('reservation_time');
            
            // Estado
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            
            // Anticipo
            $table->boolean('requires_deposit')->default(false);
            $table->decimal('deposit_amount', 10, 2)->nullable();
            $table->boolean('deposit_paid')->default(false);
            $table->string('payment_proof', 255)->nullable(); // path al archivo
            
            // Notas
            $table->text('notes')->nullable();
            $table->text('cancellation_reason')->nullable();
            
            // Referencia única para seguimiento
            $table->string('reference_code', 20)->unique();
            
            // Control
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('reminder_sent_at')->nullable();
            $table->timestamps();
            
            // Índices
            $table->index(['store_id', 'status']);
            $table->index(['reservation_date', 'reservation_time']);
            $table->index('status');
            $table->index('reference_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
