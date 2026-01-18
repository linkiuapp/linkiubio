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
        Schema::create('ui_images', function (Blueprint $table) {
            $table->id();
            $table->enum('context', ['store', 'tenant_admin', 'website', 'super_admin'])->index();
            $table->string('category', 100)->index(); // checkout_success, login_banner, etc.
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('file_path'); // Ruta relativa desde public/
            $table->string('file_name'); // Nombre original del archivo
            $table->unsignedInteger('file_size'); // Tamaño en bytes
            $table->string('mime_type', 50); // image/svg+xml o image/webp
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->json('metadata')->nullable(); // width, height, etc.
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            
            // Índices compuestos para búsquedas frecuentes
            $table->index(['context', 'category', 'is_active']);
            $table->index(['context', 'category', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ui_images');
    }
};
