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
        Schema::create('traffic_logs', function (Blueprint $table) {
            $table->id();
            $table->string('method', 10); // GET, POST, PUT, DELETE
            $table->string('route');
            $table->string('ip_address', 45);
            $table->text('user_agent')->nullable();
            $table->integer('status_code');
            $table->integer('response_time_ms'); // Tiempo de respuesta en ms
            $table->integer('memory_usage_mb')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('store_id')->nullable()->constrained('stores')->onDelete('set null');
            $table->json('request_data')->nullable(); // Sanitizado
            $table->timestamp('logged_at');
            $table->timestamps();
            
            $table->index(['route', 'logged_at']);
            $table->index(['status_code', 'logged_at']);
            $table->index(['store_id', 'logged_at']);
            $table->index('logged_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traffic_logs');
    }
};
