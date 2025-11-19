<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Paso 1: Cambiar la columna a VARCHAR temporalmente
        DB::statement("ALTER TABLE orders MODIFY COLUMN delivery_type VARCHAR(50) NOT NULL");
        
        // Paso 2: Actualizar valores existentes de 'domicilio' a 'local'
        DB::table('orders')
            ->where('delivery_type', 'domicilio')
            ->update(['delivery_type' => 'local']);
        
        // Paso 3: Cambiar la columna de vuelta a ENUM con los nuevos valores
        DB::statement("ALTER TABLE orders MODIFY COLUMN delivery_type ENUM('pickup', 'local', 'national') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Paso 1: Cambiar a VARCHAR temporalmente
        DB::statement("ALTER TABLE orders MODIFY COLUMN delivery_type VARCHAR(50) NOT NULL");
        
        // Paso 2: Revertir los valores de 'local' a 'domicilio'
        DB::table('orders')
            ->where('delivery_type', 'local')
            ->update(['delivery_type' => 'domicilio']);
        
        // Paso 3: Revertir el ENUM a los valores originales
        DB::statement("ALTER TABLE orders MODIFY COLUMN delivery_type ENUM('domicilio', 'pickup') NOT NULL");
    }
};
