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
            // Tickets
            $table->string('template_ticket_created_tenant')->nullable()->after('template_ticket_assigned_vars');
            $table->json('template_ticket_created_tenant_vars')->nullable()->after('template_ticket_created_tenant');
            $table->string('template_ticket_created_superadmin')->nullable()->after('template_ticket_created_tenant_vars');
            $table->json('template_ticket_created_superadmin_vars')->nullable()->after('template_ticket_created_superadmin');
            
            // Billing
            $table->string('template_subscription_expiring_soon')->nullable()->after('template_invoice_overdue_vars');
            $table->json('template_subscription_expiring_soon_vars')->nullable()->after('template_subscription_expiring_soon');
            
            // Security
            $table->string('template_password_changed_confirmation')->nullable()->after('template_subscription_expiring_soon_vars');
            $table->json('template_password_changed_confirmation_vars')->nullable()->after('template_password_changed_confirmation');
            $table->string('template_resend_store_credentials')->nullable()->after('template_password_changed_confirmation_vars');
            $table->json('template_resend_store_credentials_vars')->nullable()->after('template_resend_store_credentials');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_configurations', function (Blueprint $table) {
            $table->dropColumn([
                'template_ticket_created_tenant',
                'template_ticket_created_tenant_vars',
                'template_ticket_created_superadmin',
                'template_ticket_created_superadmin_vars',
                'template_subscription_expiring_soon',
                'template_subscription_expiring_soon_vars',
                'template_password_changed_confirmation',
                'template_password_changed_confirmation_vars',
                'template_resend_store_credentials',
                'template_resend_store_credentials_vars',
            ]);
        });
    }
};
