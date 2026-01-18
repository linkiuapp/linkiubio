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
        Schema::create('ai_generated_category_icons', function (Blueprint $table) {
            $table->id();
            
            // Relaciones
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            
            // Imágenes
            $table->string('reference_image_path')->nullable()->comment('Imagen de referencia subida por el usuario');
            $table->text('user_description')->comment('Descripción del producto por el usuario');
            $table->text('generated_prompt')->nullable()->comment('Prompt usado para DALL-E');
            $table->text('original_dall_e_url')->nullable()->comment('URL original de DALL-E');
            $table->string('processed_icon_path')->comment('Ruta del ícono procesado (500x500, WebP, sin fondo)');
            $table->integer('file_size')->nullable()->comment('Tamaño del archivo en bytes');
            
            // Estado y aprobación
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->boolean('is_global')->default(false)->comment('Disponible para todas las tiendas');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            
            // Metadata
            $table->json('metadata')->nullable()->comment('Info adicional: dimensiones, costo, tiempo generación');
            
            $table->timestamps();
            
            // Índices
            $table->index(['store_id', 'status']);
            $table->index('is_global');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_generated_category_icons');
    }
};
