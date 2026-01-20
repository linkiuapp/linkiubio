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
        // Modificar el enum para incluir 'recharge'
        DB::statement("ALTER TABLE `tool_payment_histories` MODIFY COLUMN `payment_type` ENUM('monthly', 'yearly', 'renewal', 'one_time', 'other', 'recharge') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir a enum sin 'recharge' (solo si no hay registros con 'recharge')
        DB::statement("ALTER TABLE `tool_payment_histories` MODIFY COLUMN `payment_type` ENUM('monthly', 'yearly', 'renewal', 'one_time', 'other') NOT NULL");
    }
};
