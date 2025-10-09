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
        Schema::table('stores', function (Blueprint $table) {
            // Información del negocio
            $table->string('business_type')->nullable()->after('description')
                ->comment('Tipo de negocio reportado por el usuario (texto libre)');
            $table->enum('business_document_type', ['NIT', 'CC', 'CE', 'RUT'])->nullable()->after('business_type')
                ->comment('Tipo de documento del negocio');
            $table->string('business_document_number', 20)->nullable()->after('business_document_type')
                ->comment('Número de documento del negocio');
            $table->boolean('document_verified')->default(false)->after('business_document_number')
                ->comment('Si el documento fue verificado manualmente');
            
            // Estado de aprobación
            $table->enum('approval_status', ['pending_approval', 'approved', 'rejected'])
                ->default('pending_approval')->after('document_verified')
                ->comment('Estado de la solicitud de la tienda');
            
            // Datos de aprobación
            $table->timestamp('approved_at')->nullable()->after('approval_status');
            $table->foreignId('approved_by')->nullable()->after('approved_at')
                ->constrained('users')->nullOnDelete()
                ->comment('SuperAdmin que aprobó la tienda');
            
            // Datos de rechazo
            $table->string('rejection_reason')->nullable()->after('approved_by')
                ->comment('Motivo del rechazo');
            $table->text('rejection_message')->nullable()->after('rejection_reason')
                ->comment('Mensaje personalizado al usuario');
            $table->timestamp('rejected_at')->nullable()->after('rejection_message');
            $table->timestamp('can_reapply_at')->nullable()->after('rejected_at')
                ->comment('Fecha a partir de la cual puede volver a aplicar');
            
            // Notas internas
            $table->text('admin_notes')->nullable()->after('can_reapply_at')
                ->comment('Notas internas del SuperAdmin');
            
            // Relación con categoría de negocio (FK agregada después de crear la tabla)
            $table->unsignedBigInteger('business_category_id')->nullable()->after('admin_notes');
            
            // Índices para búsquedas frecuentes
            $table->index('approval_status');
            $table->index('business_document_number');
            $table->index(['approval_status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropIndex(['approval_status']);
            $table->dropIndex(['business_document_number']);
            $table->dropIndex(['approval_status', 'created_at']);
            
            $table->dropForeign(['approved_by']);
            
            $table->dropColumn([
                'business_type',
                'business_document_type',
                'business_document_number',
                'document_verified',
                'approval_status',
                'approved_at',
                'approved_by',
                'rejection_reason',
                'rejection_message',
                'rejected_at',
                'can_reapply_at',
                'admin_notes',
                'business_category_id'
            ]);
        });
    }
};
