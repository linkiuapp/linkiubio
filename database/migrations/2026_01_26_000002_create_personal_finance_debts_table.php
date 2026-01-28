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
        Schema::create('personal_finance_debts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('account_id')->nullable()->constrained('personal_finance_accounts')->onDelete('set null');
            $table->string('name'); // ej: "Préstamo Bancolombia", "Cuota de carro"
            $table->text('description')->nullable();
            $table->decimal('total_amount', 15, 2); // Monto total de la deuda
            $table->decimal('interest_rate', 5, 2)->nullable()->comment('Tasa de interés anual');
            $table->integer('total_installments'); // Total de cuotas
            $table->integer('paid_installments')->default(0);
            $table->date('start_date');
            $table->date('end_date')->nullable()->comment('Fecha estimada de finalización');
            $table->enum('payment_frequency', ['monthly', 'biweekly', 'weekly', 'daily'])->default('monthly');
            $table->enum('status', ['active', 'paid', 'cancelled', 'overdue'])->default('active');
            $table->boolean('auto_calculate_installments')->default(true)->comment('Si calcula cuotas automáticamente');
            $table->timestamps();

            $table->index('user_id');
            $table->index('account_id');
            $table->index(['user_id', 'status']);
            $table->index('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_finance_debts');
    }
};
