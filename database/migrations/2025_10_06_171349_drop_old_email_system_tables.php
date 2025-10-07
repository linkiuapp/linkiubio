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
        // Eliminar tablas del sistema de emails antiguo
        Schema::dropIfExists('email_templates');
        Schema::dropIfExists('email_settings');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No vamos a recrear las tablas viejas
        // Si necesitas revertir, usa las migraciones originales
    }
};