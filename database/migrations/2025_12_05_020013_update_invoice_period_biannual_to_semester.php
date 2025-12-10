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
        // Actualizar todas las facturas existentes con período 'biannual' a 'semester'
        DB::table('invoices')
            ->where('period', 'biannual')
            ->update(['period' => 'semester']);
            
        // Actualizar suscripciones existentes con período 'biannual' a 'semester'
        DB::table('subscriptions')
            ->where('billing_cycle', 'biannual')
            ->update(['billing_cycle' => 'semester']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir cambios
        DB::table('invoices')
            ->where('period', 'semester')
            ->update(['period' => 'biannual']);
            
        DB::table('subscriptions')
            ->where('billing_cycle', 'semester')
            ->update(['billing_cycle' => 'biannual']);
    }
};
