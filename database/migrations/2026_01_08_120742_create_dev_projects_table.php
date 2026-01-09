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
        Schema::create('dev_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('dev_clients')->onDelete('cascade');
            $table->string('name'); // Nombre del proyecto
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'on_hold', 'completed', 'cancelled'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->boolean('notify_client_on_status_change')->default(true); // Notificar auto al cambiar estado
            $table->decimal('budget', 12, 2)->nullable(); // Presupuesto (para futuro)
            $table->timestamps();
            
            $table->index('status');
            $table->index('client_id');
            $table->index(['status', 'due_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dev_projects');
    }
};
