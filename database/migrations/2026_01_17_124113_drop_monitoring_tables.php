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
        // Drop monitoring tables
        Schema::dropIfExists('monitoring_alerts');
        Schema::dropIfExists('performance_logs');
        Schema::dropIfExists('error_logs');
        Schema::dropIfExists('traffic_logs');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No se recrean las tablas en el rollback
        // Si necesitas restaurarlas, ejecuta las migraciones originales
    }
};
