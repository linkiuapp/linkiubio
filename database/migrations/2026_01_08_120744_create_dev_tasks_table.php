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
        Schema::create('dev_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('dev_projects')->onDelete('cascade');
            $table->string('name'); // Nombre tarea
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'review', 'completed', 'cancelled'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->integer('order')->default(0); // Orden en lista
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            
            // Campos para agenda
            $table->date('scheduled_date')->nullable(); // Día en agenda
            $table->time('scheduled_start_time')->nullable(); // Hora inicio
            $table->time('scheduled_end_time')->nullable(); // Hora fin
            $table->integer('reminder_minutes')->nullable(); // Minutos antes para recordatorio (configurable)
            $table->boolean('reminder_sent')->default(false); // Ya se envió recordatorio
            
            $table->timestamp('completed_at')->nullable();
            $table->boolean('notify_on_complete')->default(true); // Notificar cliente al completar
            $table->timestamps();
            
            $table->index('project_id');
            $table->index('status');
            $table->index('scheduled_date');
            $table->index(['scheduled_date', 'scheduled_start_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dev_tasks');
    }
};
