<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('sub_clients')->cascadeOnDelete();
            $table->foreignId('service_type_id')->nullable()->constrained('sub_service_types')->nullOnDelete();
            $table->string('service_name'); // Nombre personalizado del servicio
            $table->text('description')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('COP');
            $table->enum('billing_period', ['monthly', 'quarterly', 'semiannual', 'annual'])->default('annual');
            $table->date('start_date');
            $table->date('next_billing_date');
            $table->enum('status', ['active', 'pending_payment', 'expired', 'cancelled'])->default('active');
            $table->string('payment_token', 64)->unique(); // Token único para link público
            $table->text('notes')->nullable();
            $table->boolean('auto_remind')->default(true);
            $table->timestamps();

            $table->index('status');
            $table->index('next_billing_date');
            $table->index('payment_token');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_subscriptions');
    }
};
