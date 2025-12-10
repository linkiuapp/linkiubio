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
        Schema::create('product_variable', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('variable_id')->constrained('product_variables')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->string('custom_label')->nullable();
            $table->timestamps();
            
            // Índices
            $table->unique(['product_id', 'variable_id']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variable');
    }
};
