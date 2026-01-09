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
        Schema::create('dev_agenda_entries', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Título
            $table->text('description')->nullable();
            $table->enum('type', ['meeting', 'reminder', 'task', 'call', 'other'])->default('other');
            $table->date('date'); // Día
            $table->time('start_time'); // Hora inicio
            $table->time('end_time')->nullable(); // Hora fin
            $table->string('location')->nullable(); // Ubicación (opcional)
            
            // Relaciones opcionales
            $table->foreignId('project_id')->nullable()->constrained('dev_projects')->onDelete('set null');
            $table->foreignId('client_id')->nullable()->constrained('dev_clients')->onDelete('set null');
            
            // Recordatorios
            $table->integer('reminder_minutes')->nullable(); // Minutos antes para recordatorio
            $table->boolean('reminder_sent')->default(false); // Ya se notificó
            
            $table->string('color')->nullable(); // Color para el calendario (hex)
            $table->boolean('is_all_day')->default(false); // Evento de todo el día
            $table->timestamps();
            
            $table->index('date');
            $table->index(['date', 'start_time']);
            $table->index('project_id');
            $table->index('client_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dev_agenda_entries');
    }
};
