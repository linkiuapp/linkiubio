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
        Schema::create('dev_notification_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['client_update', 'daily_summary', 'task_reminder', 'webhook_response']);
            $table->string('recipient_phone');
            $table->enum('recipient_type', ['client', 'admin']);
            $table->string('message_id')->nullable(); // ID de Infobip
            $table->enum('status', ['pending', 'sent', 'delivered', 'read', 'failed'])->default('pending');
            $table->json('payload')->nullable(); // Datos enviados
            $table->text('error_message')->nullable(); // Si falló
            
            // Referencias opcionales
            $table->foreignId('project_id')->nullable()->constrained('dev_projects')->onDelete('set null');
            $table->foreignId('task_id')->nullable()->constrained('dev_tasks')->onDelete('set null');
            $table->foreignId('client_id')->nullable()->constrained('dev_clients')->onDelete('set null');
            
            $table->timestamp('created_at')->useCurrent();
            
            $table->index('type');
            $table->index('status');
            $table->index('recipient_phone');
            $table->index('message_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dev_notification_logs');
    }
};
