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
        Schema::create('personal_finance_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name'); // ej: "Bancolombia", "Nequi", "Tarjeta Visa"
            $table->enum('type', ['checking', 'savings', 'credit_card', 'loan', 'other'])->default('other');
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable()->comment('Encriptado');
            $table->decimal('current_balance', 15, 2)->default(0);
            $table->decimal('credit_limit', 15, 2)->nullable()->comment('Para tarjetas de crédito');
            $table->string('currency', 3)->default('COP');
            $table->string('color', 7)->default('#3B82F6')->comment('Color hex para UI');
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index(['user_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_finance_accounts');
    }
};
