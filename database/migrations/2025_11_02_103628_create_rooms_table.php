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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->foreignId('room_type_id')->constrained('room_types')->onDelete('cascade');
            
            // Identificación
            $table->string('room_number', 50); // "301", "Penthouse A"
            $table->string('floor', 50)->nullable();
            $table->text('location_notes')->nullable();
            
            // Estado
            $table->enum('status', ['available', 'occupied', 'maintenance', 'blocked'])->default('available');
            
            $table->timestamps();
            
            // Índices
            $table->unique(['store_id', 'room_number']);
            $table->index(['store_id', 'room_type_id']);
            $table->index(['status', 'room_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
