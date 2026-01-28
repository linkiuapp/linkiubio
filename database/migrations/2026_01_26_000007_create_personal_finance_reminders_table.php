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
        Schema::create('personal_finance_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('debt_id')->nullable()->constrained('personal_finance_debts')->onDelete('cascade')->comment('NULL = recordatorio global');
            $table->integer('reminder_days_before')->comment('Días antes del vencimiento (ej: 3, 7, 15)');
            $table->enum('notification_method', ['email', 'whatsapp', 'both'])->default('whatsapp');
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_sent_at')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('debt_id');
            $table->index(['user_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_finance_reminders');
    }
};
