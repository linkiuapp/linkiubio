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
        Schema::create('error_logs', function (Blueprint $table) {
            $table->id();
            $table->string('level', 20); // ERROR, WARNING, INFO, DEBUG
            $table->text('message');
            $table->text('stack_trace')->nullable();
            $table->string('file')->nullable();
            $table->integer('line')->nullable();
            $table->string('route')->nullable(); // Ruta donde ocurrió
            $table->string('method', 10)->nullable(); // GET, POST, etc.
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('store_id')->nullable()->constrained('stores')->onDelete('set null');
            $table->json('context')->nullable(); // Datos adicionales
            $table->json('request_data')->nullable(); // Request data (sanitizado)
            $table->integer('occurrence_count')->default(1); // Si es el mismo error repetido
            $table->timestamp('first_occurred_at');
            $table->timestamp('last_occurred_at');
            $table->timestamps();
            
            $table->index(['level', 'created_at']);
            $table->index(['route', 'created_at']);
            $table->index(['store_id', 'created_at']);
            $table->index('first_occurred_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('error_logs');
    }
};
