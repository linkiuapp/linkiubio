<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained('sub_subscriptions')->cascadeOnDelete();
            $table->foreignId('payment_id')->nullable()->constrained('sub_payments')->nullOnDelete();
            $table->string('type', 20); // reminder_30d, reminder_15d, reminder_7d, reminder_5d, reminder_3d, reminder_1d
            $table->enum('status', ['sent', 'failed', 'pending'])->default('pending');
            $table->timestamp('sent_at')->nullable();
            $table->string('message_id')->nullable(); // ID del mensaje de WhatsApp
            $table->text('error_message')->nullable();
            $table->timestamps();

            $table->index(['subscription_id', 'type']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_reminders');
    }
};
