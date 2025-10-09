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
        Schema::create('business_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique()
                ->comment('Nombre de la categoría (ej: Restaurante, Cafetería)');
            $table->string('slug', 100)->unique()
                ->comment('Slug para URLs amigables');
            $table->string('icon', 50)->nullable()
                ->comment('Emoji o icono para la categoría');
            $table->text('description')->nullable()
                ->comment('Descripción de la categoría');
            $table->boolean('is_active')->default(true)
                ->comment('Si la categoría está habilitada para nuevos registros');
            $table->boolean('requires_manual_approval')->default(false)
                ->comment('Si requiere aprobación manual del SuperAdmin');
            $table->integer('order')->default(0)
                ->comment('Orden de visualización');
            $table->foreignId('created_by')->nullable()
                ->constrained('users')->nullOnDelete()
                ->comment('SuperAdmin que creó la categoría');
            $table->timestamps();
            
            // Índices
            $table->index('is_active');
            $table->index('requires_manual_approval');
            $table->index('order');
        });
        
        // Agregar FK en stores DESPUÉS de crear la tabla business_categories
        Schema::table('stores', function (Blueprint $table) {
            $table->foreign('business_category_id')
                ->references('id')
                ->on('business_categories')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Primero eliminar FK de stores
        Schema::table('stores', function (Blueprint $table) {
            $table->dropForeign(['business_category_id']);
        });
        
        // Luego eliminar la tabla
        Schema::dropIfExists('business_categories');
    }
};
