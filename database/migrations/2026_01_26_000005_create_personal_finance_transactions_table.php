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
        // Eliminar la tabla si existe (para corregir el índice)
        Schema::dropIfExists('personal_finance_transactions');
        
        Schema::create('personal_finance_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('account_id')->constrained('personal_finance_accounts')->onDelete('cascade');
            $table->enum('type', ['income', 'expense']);
            $table->string('category'); // ej: "Alimentación", "Transporte", "Salario", "Freelance"
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->date('transaction_date');
            $table->enum('payment_method', ['transfer', 'cash', 'card', 'nequi', 'daviplata', 'other'])->default('transfer');
            $table->string('receipt_file')->nullable();
            $table->json('tags')->nullable()->comment('Tags para filtrado');
            $table->timestamps();

            $table->index('user_id');
            $table->index('account_id');
            $table->index('type');
            $table->index('transaction_date');
            $table->index('category');
            $table->index(['user_id', 'type', 'transaction_date'], 'pf_transactions_user_type_date_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_finance_transactions');
    }
};
