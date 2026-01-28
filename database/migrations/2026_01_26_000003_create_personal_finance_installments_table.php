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
        Schema::create('personal_finance_installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('debt_id')->constrained('personal_finance_debts')->onDelete('cascade');
            $table->integer('installment_number'); // Número de cuota (1, 2, 3...)
            $table->decimal('amount', 15, 2); // Monto de la cuota
            $table->date('due_date'); // Fecha de vencimiento
            $table->date('paid_date')->nullable(); // Fecha en que se pagó
            $table->enum('status', ['pending', 'paid', 'overdue', 'cancelled'])->default('pending');
            $table->string('payment_method')->nullable()->comment('Método usado para pagar');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('debt_id');
            $table->index('due_date');
            $table->index('status');
            $table->index(['debt_id', 'status']);
            $table->unique(['debt_id', 'installment_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_finance_installments');
    }
};
