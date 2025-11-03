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
        Schema::table('tables', function (Blueprint $table) {
            // Tipo: 'mesa' para restaurantes, 'habitacion' para hoteles
            $table->enum('type', ['mesa', 'habitacion'])
                  ->default('mesa')
                  ->after('table_number');
            
            // QR Code (SVG/PNG base64 o path)
            $table->text('qr_code')
                  ->nullable()
                  ->after('capacity');
            
            // URL que apunta el QR (ej: /mesa/5 o /habitacion/205)
            $table->string('qr_url', 255)
                  ->nullable()
                  ->after('qr_code');
            
            // Estado
            $table->enum('status', ['available', 'occupied', 'reserved'])
                  ->default('available')
                  ->after('is_active');
            
            // Pedido activo actual
            $table->foreignId('current_order_id')
                  ->nullable()
                  ->after('status')
                  ->constrained('orders')
                  ->onDelete('set null');
            
            // Índices adicionales
            $table->index(['store_id', 'status']);
            $table->index(['store_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->dropForeign(['current_order_id']);
            $table->dropIndex(['store_id', 'status']);
            $table->dropIndex(['store_id', 'type']);
            
            $table->dropColumn([
                'type',
                'qr_code',
                'qr_url',
                'status',
                'current_order_id'
            ]);
        });
    }
};
