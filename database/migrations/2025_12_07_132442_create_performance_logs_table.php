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
        Schema::create('performance_logs', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // slow_query, high_memory, slow_route
            $table->string('route')->nullable();
            $table->text('query')->nullable(); // Para slow queries
            $table->integer('execution_time_ms');
            $table->integer('memory_usage_mb')->nullable();
            $table->json('context')->nullable();
            $table->timestamp('logged_at');
            $table->timestamps();
            
            $table->index(['type', 'logged_at']);
            $table->index('logged_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_logs');
    }
};
