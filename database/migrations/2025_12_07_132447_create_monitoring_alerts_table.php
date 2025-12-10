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
        Schema::create('monitoring_alerts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['error_rate', 'traffic_spike', 'slow_response', 'high_memory', 'custom']);
            $table->json('conditions'); // Condiciones del alert
            $table->enum('channel', ['email', 'whatsapp', 'in_app'])->default('email');
            $table->boolean('is_active')->default(true);
            $table->integer('cooldown_minutes')->default(60); // Tiempo entre alertas
            $table->timestamp('last_triggered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_alerts');
    }
};
