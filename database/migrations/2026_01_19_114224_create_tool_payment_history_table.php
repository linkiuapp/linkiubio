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
        Schema::create('tool_payment_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tool_id')->constrained('linkiu_tools')->cascadeOnDelete();
            $table->date('payment_date'); // Fecha de pago
            $table->decimal('amount', 10, 2); // Monto pagado
            $table->enum('payment_type', ['monthly', 'yearly', 'renewal', 'one_time', 'other', 'recharge']); // Tipo de pago/recarga
            $table->string('currency', 3)->default('USD'); // Moneda
            $table->string('receipt_path')->nullable(); // Ruta del comprobante (opcional)
            $table->text('notes')->nullable(); // Notas sobre el pago
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tool_payment_histories');
    }
};
