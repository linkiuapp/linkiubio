<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained('sub_subscriptions')->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('COP');
            $table->date('period_start');
            $table->date('period_end');
            $table->enum('status', ['pending', 'paid', 'failed', 'cancelled'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->string('payment_method')->nullable(); // pse, cash, nequi, daviplata, card
            $table->string('payment_reference')->nullable();
            $table->string('epayco_ref')->nullable();
            $table->string('payment_token', 64)->unique(); // Token único para este pago específico
            $table->text('notes')->nullable();
            $table->json('epayco_data')->nullable(); // Respuesta completa de ePayco
            $table->timestamps();

            $table->index('status');
            $table->index('payment_token');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_payments');
    }
};
