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
        Schema::create('payment_gateway_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_gateway_id')->constrained()->onDelete('cascade');
            $table->string('transaction_id')->unique(); // ID de la transacción en el gateway
            $table->string('reference', 100)->index(); // Referencia del registro/pedido
            $table->string('reference_type', 50)->default('registration'); // registration, order, etc.
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('COP');
            $table->enum('status', ['pending', 'processing', 'approved', 'rejected', 'cancelled', 'refunded'])->default('pending');
            $table->json('request_data')->nullable(); // Datos enviados al gateway
            $table->json('response_data')->nullable(); // Respuesta del gateway
            $table->text('error_message')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateway_transactions');
    }
};
