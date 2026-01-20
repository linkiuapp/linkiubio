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
        Schema::create('linkiu_tools', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre de la herramienta
            $table->string('category')->nullable(); // Categoría (pagos, hosting, email, etc.)
            $table->text('description')->nullable(); // Para qué sirve (generado por IA)
            $table->text('usage_in_linkiu')->nullable(); // Para qué lo usamos en Linkiu (generado por IA)
            $table->string('url')->nullable(); // URL principal
            $table->string('dashboard_url')->nullable(); // URL del panel de administración
            $table->string('api_docs_url')->nullable(); // URL de documentación API
            $table->date('start_date')->nullable(); // Fecha de inicio
            $table->enum('billing_type', ['free', 'monthly', 'yearly', 'pay_per_use'])->default('free'); // Tipo de facturación
            $table->decimal('monthly_cost', 10, 2)->nullable(); // Costo mensual
            $table->decimal('yearly_cost', 10, 2)->nullable(); // Costo anual
            $table->string('currency', 3)->default('USD'); // Moneda
            $table->text('username')->nullable(); // Usuario (encriptado)
            $table->text('password')->nullable(); // Contraseña (encriptado)
            $table->text('api_key')->nullable(); // API Key (encriptado)
            $table->text('api_secret')->nullable(); // API Secret (encriptado)
            $table->string('account_id')->nullable(); // ID de cuenta
            $table->text('notes')->nullable(); // Notas adicionales
            $table->enum('status', ['active', 'inactive', 'deprecated'])->default('active'); // Estado
            $table->boolean('is_critical')->default(false); // ¿Es crítica para el funcionamiento?
            $table->string('responsible_team')->nullable(); // Equipo responsable
            $table->date('last_renewal_date')->nullable(); // Última renovación
            $table->date('next_renewal_date')->nullable(); // Próxima renovación
            $table->string('notification_phone')->nullable(); // Teléfono para notificaciones WhatsApp (formato: +57XXXXXXXXXX)
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linkiu_tools');
    }
};
