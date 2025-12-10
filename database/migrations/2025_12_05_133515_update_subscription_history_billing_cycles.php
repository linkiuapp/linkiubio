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
        // Actualizar ENUM para incluir 'semester' y 'annual'
        DB::statement("ALTER TABLE subscription_history MODIFY old_billing_cycle ENUM('monthly', 'quarterly', 'semester', 'annual', 'biannual') NULL");
        DB::statement("ALTER TABLE subscription_history MODIFY new_billing_cycle ENUM('monthly', 'quarterly', 'semester', 'annual', 'biannual') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE subscription_history MODIFY old_billing_cycle ENUM('monthly', 'quarterly', 'biannual') NULL");
        DB::statement("ALTER TABLE subscription_history MODIFY new_billing_cycle ENUM('monthly', 'quarterly', 'biannual') NULL");
    }
};
