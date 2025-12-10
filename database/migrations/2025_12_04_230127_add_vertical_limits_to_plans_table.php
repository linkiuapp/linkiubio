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
        Schema::table('plans', function (Blueprint $table) {
            // LÍMITES PARA VERTICAL RESTAURANT
            if (!Schema::hasColumn('plans', 'max_tables')) {
                $table->integer('max_tables')->default(0)->after('whatsapp_integration')
                    ->comment('Máximo de mesas (restaurant). 0 = ilimitado');
            }
            
            if (!Schema::hasColumn('plans', 'max_daily_reservations')) {
                $table->integer('max_daily_reservations')->default(0)->after('max_tables')
                    ->comment('Máximo de reservas por día (restaurant). 0 = ilimitado');
            }
            
            // LÍMITES PARA VERTICAL HOTEL
            if (!Schema::hasColumn('plans', 'max_rooms')) {
                $table->integer('max_rooms')->default(0)->after('max_daily_reservations')
                    ->comment('Máximo de habitaciones (hotel). 0 = ilimitado');
            }
            
            if (!Schema::hasColumn('plans', 'max_room_types')) {
                $table->integer('max_room_types')->default(0)->after('max_rooms')
                    ->comment('Máximo de tipos de habitación (hotel). 0 = ilimitado');
            }
            
            if (!Schema::hasColumn('plans', 'max_daily_hotel_reservations')) {
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
                'max_tables',
                'max_daily_reservations',
                'max_rooms',
                'max_room_types',
                'max_daily_hotel_reservations',
            ]);
        });
    }
};
