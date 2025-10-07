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
        Schema::create('email_configurations', function (Blueprint $table) {
            $table->id();
            
            // Configuración principal de SendGrid
            $table->string('sendgrid_api_key', 500)->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamp('api_validated_at')->nullable();
            $table->string('from_email')->default('noreply@linkiu.com');
            $table->string('from_name')->default('Linkiu');
            
            // Templates de Gestión de Tiendas
            $table->string('template_store_created')->nullable()->comment('ID de plantilla cuando se crea una tienda');
            $table->json('template_store_created_vars')->nullable();
            
            $table->string('template_store_verified')->nullable()->comment('ID de plantilla cuando se verifica una tienda');
            $table->json('template_store_verified_vars')->nullable();
            
            $table->string('template_store_suspended')->nullable()->comment('ID de plantilla cuando se suspende una tienda');
            $table->json('template_store_suspended_vars')->nullable();
            
            $table->string('template_store_reactivated')->nullable()->comment('ID de plantilla cuando se reactiva una tienda');
            $table->json('template_store_reactivated_vars')->nullable();
            
            $table->string('template_plan_changed')->nullable()->comment('ID de plantilla cuando cambia el plan');
            $table->json('template_plan_changed_vars')->nullable();
            
            // Templates de Tickets/Soporte
            $table->string('template_ticket_response')->nullable()->comment('ID de plantilla para respuesta de ticket');
            $table->json('template_ticket_response_vars')->nullable();
            
            $table->string('template_ticket_resolved')->nullable()->comment('ID de plantilla cuando se resuelve un ticket');
            $table->json('template_ticket_resolved_vars')->nullable();
            
            $table->string('template_ticket_assigned')->nullable()->comment('ID de plantilla cuando se asigna un ticket');
            $table->json('template_ticket_assigned_vars')->nullable();
            
            // Templates de Facturación
            $table->string('template_invoice_generated')->nullable()->comment('ID de plantilla cuando se genera factura');
            $table->json('template_invoice_generated_vars')->nullable();
            
            $table->string('template_payment_confirmed')->nullable()->comment('ID de plantilla cuando se confirma pago');
            $table->json('template_payment_confirmed_vars')->nullable();
            
            $table->string('template_invoice_overdue')->nullable()->comment('ID de plantilla cuando vence factura');
            $table->json('template_invoice_overdue_vars')->nullable();
            
            // Metadata
            $table->json('test_emails')->nullable()->comment('Emails para pruebas');
            $table->json('stats')->nullable()->comment('Estadísticas de envío');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_configurations');
    }
};