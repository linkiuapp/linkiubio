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
            // Templates para el flujo de aprobación de tiendas
            $table->string('template_store_pending_review')->nullable()->after('template_plan_changed')
                ->comment('ID de plantilla SendGrid cuando tienda queda en revisión');
            $table->json('template_store_pending_review_vars')->nullable();
            
            $table->string('template_store_approved')->nullable()->after('template_store_pending_review_vars')
                ->comment('ID de plantilla SendGrid cuando tienda es aprobada');
            $table->json('template_store_approved_vars')->nullable();
            
            $table->string('template_store_rejected')->nullable()->after('template_store_approved_vars')
                ->comment('ID de plantilla SendGrid cuando tienda es rechazada');
            $table->json('template_store_rejected_vars')->nullable();
            
            $table->string('template_new_store_request_superadmin')->nullable()->after('template_store_rejected_vars')
                ->comment('ID de plantilla SendGrid para notificar nueva solicitud al SuperAdmin');
            $table->json('template_new_store_request_superadmin_vars')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_configurations', function (Blueprint $table) {
            $table->dropColumn([
                'template_store_pending_review',
                'template_store_pending_review_vars',
                'template_store_approved',
                'template_store_approved_vars',
                'template_store_rejected',
                'template_store_rejected_vars',
                'template_new_store_request_superadmin',
                'template_new_store_request_superadmin_vars'
            ]);
        });
    }
};
