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
        // Verificar columnas antes de agregar
        $hasInventoryTracking = Schema::hasColumn('plans', 'inventory_tracking');
        $hasWhatsappIntegration = Schema::hasColumn('plans', 'whatsapp_integration');
        $hasMaxProductImages = Schema::hasColumn('plans', 'max_product_images');
        $hasMaxPaymentMethods = Schema::hasColumn('plans', 'max_payment_methods');
        $hasMaxDeliveryZones = Schema::hasColumn('plans', 'max_delivery_zones');
        $hasMaxAdmins = Schema::hasColumn('plans', 'max_admins');
        $hasMaxTicketsPerMonth = Schema::hasColumn('plans', 'max_tickets_per_month');
        $hasOrderHistoryMonths = Schema::hasColumn('plans', 'order_history_months');
        $hasIsFeatured = Schema::hasColumn('plans', 'is_featured');
        $hasPrices = Schema::hasColumn('plans', 'prices');
        $hasSortOrder = Schema::hasColumn('plans', 'sort_order');
        
        // Límites de verticales
        $hasMaxTables = Schema::hasColumn('plans', 'max_tables');
        $hasMaxDailyReservations = Schema::hasColumn('plans', 'max_daily_reservations');
        $hasMaxRooms = Schema::hasColumn('plans', 'max_rooms');
        $hasMaxRoomTypes = Schema::hasColumn('plans', 'max_room_types');
        $hasMaxDailyHotelReservations = Schema::hasColumn('plans', 'max_daily_hotel_reservations');

        Schema::table('plans', function (Blueprint $table) use (
            $hasInventoryTracking,
            $hasWhatsappIntegration,
            $hasMaxProductImages,
            $hasMaxPaymentMethods,
            $hasMaxDeliveryZones,
            $hasMaxAdmins,
            $hasMaxTicketsPerMonth,
            $hasOrderHistoryMonths,
            $hasIsFeatured,
            $hasPrices,
            $hasSortOrder,
            $hasMaxTables,
            $hasMaxDailyReservations,
            $hasMaxRooms,
            $hasMaxRoomTypes,
            $hasMaxDailyHotelReservations
        ) {
            // INVENTARIO
            if (!$hasInventoryTracking) {
                $table->boolean('inventory_tracking')->default(true)->after('max_variables')
                    ->comment('Permite usar control de inventario/stock');
            }
            
            // INTEGRACIONES
            if (!$hasWhatsappIntegration) {
                $table->boolean('whatsapp_integration')->default(false)->after('analytics_retention_days')
                    ->comment('Permite integración con WhatsApp Business');
            }
            
            // LÍMITES ADICIONALES
            if (!$hasMaxProductImages) {
                $table->integer('max_product_images')->default(5)->after('max_variables')
                    ->comment('Máximo de imágenes por producto');
            }
            
            if (!$hasMaxPaymentMethods) {
                $table->integer('max_payment_methods')->default(4)->after('max_bank_accounts')
                    ->comment('Máximo de métodos de pago activos');
            }
            
            if (!$hasMaxDeliveryZones) {
                $table->integer('max_delivery_zones')->default(3)->after('max_sedes')
                    ->comment('Máximo de zonas de reparto');
            }
            
            if (!$hasMaxAdmins) {
                $table->integer('max_admins')->default(1)->after('max_payment_methods')
                    ->comment('Máximo de administradores');
            }
            
            if (!$hasMaxTicketsPerMonth) {
                $table->integer('max_tickets_per_month')->default(5)->after('support_response_time')
                    ->comment('Máximo de tickets de soporte por mes');
            }
            
            if (!$hasOrderHistoryMonths) {
                $table->integer('order_history_months')->default(6)->after('analytics_retention_days')
                    ->comment('Meses de retención de historial de pedidos');
            }
            
            // VISUALIZACIÓN Y DESTACADO
            if (!$hasIsFeatured) {
                $table->boolean('is_featured')->default(false)->after('is_public')
                    ->comment('Marcar plan como destacado/popular');
            }
            
            if (!$hasSortOrder) {
                $table->integer('sort_order')->default(0)->after('is_featured')
                    ->comment('Orden de visualización (menor = primero)');
            }
            
            // PRECIOS POR PERÍODO (JSON)
            if (!$hasPrices) {
                $table->json('prices')->nullable()->after('price')
                    ->comment('Precios por período: {monthly: 49900, quarterly: 141557, semester: 269460, annual: 509580}');
            }
            
            // LÍMITES PARA VERTICAL RESTAURANT
            if (!$hasMaxTables) {
                $table->integer('max_tables')->default(0)->after('whatsapp_integration')
                    ->comment('Máximo de mesas (restaurant). 0 = ilimitado');
            }
            
            if (!$hasMaxDailyReservations) {
                $table->integer('max_daily_reservations')->default(0)->after('max_tables')
                    ->comment('Máximo de reservas por día (restaurant). 0 = ilimitado');
            }
            
            // LÍMITES PARA VERTICAL HOTEL
            if (!$hasMaxRooms) {
                $table->integer('max_rooms')->default(0)->after('max_daily_reservations')
                    ->comment('Máximo de habitaciones (hotel). 0 = ilimitado');
            }
            
            if (!$hasMaxRoomTypes) {
                $table->integer('max_room_types')->default(0)->after('max_rooms')
                    ->comment('Máximo de tipos de habitación (hotel). 0 = ilimitado');
            }
            
            if (!$hasMaxDailyHotelReservations) {
                $table->integer('max_daily_hotel_reservations')->default(0)->after('max_room_types')
                    ->comment('Máximo de reservas de hotel por día. 0 = ilimitado');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn([
                'inventory_tracking',
                'whatsapp_integration',
                'max_product_images',
                'max_payment_methods',
                'max_delivery_zones',
                'max_admins',
                'max_tickets_per_month',
                'order_history_months',
                'is_featured',
                'sort_order',
                'prices',
                'max_tables',
                'max_daily_reservations',
                'max_rooms',
                'max_room_types',
                'max_daily_hotel_reservations',
            ]);
        });
    }
};
