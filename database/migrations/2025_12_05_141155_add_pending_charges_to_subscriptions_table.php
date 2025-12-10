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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->decimal('pending_charges', 10, 2)->default(0)->after('next_billing_amount')
                ->comment('Cargos pendientes por upgrades que se cobrarán en próxima factura');
            $table->json('pending_charges_details')->nullable()->after('pending_charges')
                ->comment('Detalles de los cargos pendientes (upgrades, ajustes, etc.)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn(['pending_charges', 'pending_charges_details']);
        });
    }
};
