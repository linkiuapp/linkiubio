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
        Schema::table('email_configurations', function (Blueprint $table) {
            // Template: Ticket cerrado automáticamente
            $table->string('template_ticket_auto_closed')->nullable()->after('template_ticket_assigned_vars');
            $table->json('template_ticket_auto_closed_vars')->nullable()->after('template_ticket_auto_closed');
            
            // Template: Ticket reabierto
            $table->string('template_ticket_reopened')->nullable()->after('template_ticket_auto_closed_vars');
            $table->json('template_ticket_reopened_vars')->nullable()->after('template_ticket_reopened');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_configurations', function (Blueprint $table) {
            $table->dropColumn([
                'template_ticket_auto_closed',
                'template_ticket_auto_closed_vars',
                'template_ticket_reopened',
                'template_ticket_reopened_vars',
            ]);
        });
    }
};
