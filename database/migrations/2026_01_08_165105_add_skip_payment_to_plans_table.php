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
        Schema::table('plans', function (Blueprint $table) {
            // Si el plan tiene trial y este campo es true, 
            // no se requiere pago ni comprobante en el registro
            $table->boolean('skip_payment_on_trial')->default(false)->after('trial_days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('skip_payment_on_trial');
        });
    }
};
