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
        Schema::create('personal_finance_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('installment_id')->constrained('personal_finance_installments')->onDelete('cascade');
            $table->foreignId('account_id')->constrained('personal_finance_accounts')->onDelete('cascade')->comment('Cuenta desde la que se pagó');
            $table->decimal('amount', 15, 2); // Monto pagado
            $table->date('payment_date');
            $table->enum('payment_method', ['transfer', 'cash', 'card', 'nequi', 'daviplata', 'other'])->default('transfer');
            $table->string('reference_number')->nullable()->comment('Número de referencia/transacción');
            $table->string('receipt_file')->nullable()->comment('Path al archivo del comprobante');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('installment_id');
            $table->index('account_id');
            $table->index('payment_date');
            $table->index(['user_id', 'payment_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_finance_payments');
    }
};
