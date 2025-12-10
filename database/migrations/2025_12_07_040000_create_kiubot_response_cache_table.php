<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Tabla para cachear respuestas frecuentes de KiuBot
     * Ahorra tokens de OpenAI y mejora tiempo de respuesta
     */
    public function up(): void
    {
        Schema::create('kiubot_response_cache', function (Blueprint $table) {
            $table->id();
            $table->string('question_hash', 32)->index(); // Hash MD5 de la pregunta normalizada
            $table->text('question'); // Pregunta original
            $table->text('response'); // Respuesta cacheada
            $table->string('category', 50)->nullable()->index(); // Categoría: navigation, help, suggestion, etc.
            $table->string('vertical', 30)->nullable(); // Vertical si aplica: ecommerce, restaurant, etc.
            $table->unsignedInteger('hit_count')->default(0); // Veces que se ha usado
            $table->timestamp('last_hit_at')->nullable(); // Última vez usada
            $table->timestamps();
            
            // Índice compuesto para búsqueda rápida
            $table->index(['question_hash', 'vertical'], 'kiubot_cache_hash_vertical_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kiubot_response_cache');
    }
};

