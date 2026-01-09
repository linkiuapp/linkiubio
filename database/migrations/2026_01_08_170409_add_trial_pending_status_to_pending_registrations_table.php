<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modificar el ENUM para incluir 'trial_pending'
        DB::statement("ALTER TABLE pending_registrations MODIFY COLUMN status ENUM('pending', 'approved', 'rejected', 'trial_pending') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Primero actualizar los registros trial_pending a pending
        DB::statement("UPDATE pending_registrations SET status = 'pending' WHERE status = 'trial_pending'");
        
        // Revertir al ENUM original
        DB::statement("ALTER TABLE pending_registrations MODIFY COLUMN status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'");
    }
};
