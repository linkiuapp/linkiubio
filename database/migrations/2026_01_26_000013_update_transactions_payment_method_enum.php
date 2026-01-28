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
        // Actualizar enum en personal_finance_transactions
        DB::statement("ALTER TABLE `personal_finance_transactions` MODIFY COLUMN `payment_method` ENUM('transfer', 'cash', 'account_bank', 'card', 'nequi', 'daviplata', 'other') DEFAULT 'transfer'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `personal_finance_transactions` MODIFY COLUMN `payment_method` ENUM('transfer', 'cash', 'card', 'nequi', 'daviplata', 'other') DEFAULT 'transfer'");
    }
};
