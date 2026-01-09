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
        Schema::create('dev_clients', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre o empresa
            $table->string('email')->nullable();
            $table->string('phone'); // Celular con código país
            $table->string('country_code', 5)->default('+57'); // Código país
            $table->text('notes')->nullable(); // Notas adicionales
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('phone');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dev_clients');
    }
};
