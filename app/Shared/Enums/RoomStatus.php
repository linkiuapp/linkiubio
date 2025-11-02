<?php

namespace App\Shared\Enums;

enum RoomStatus: string
{
    case AVAILABLE = 'available';
    case OCCUPIED = 'occupied';
    case MAINTENANCE = 'maintenance';
    case BLOCKED = 'blocked';

    /**
     * Obtener el nombre legible del estado
     */
    public function label(): string
    {
        return match($this) {
            self::AVAILABLE => 'Disponible',
            self::OCCUPIED => 'Ocupada',
            self::MAINTENANCE => 'Mantenimiento',
            self::BLOCKED => 'Bloqueada',
        };
    }

    /**
     * Obtener clase de color para UI
     */
    public function colorClass(): string
    {
        return match($this) {
            self::AVAILABLE => 'text-brandSuccess-400',
            self::OCCUPIED => 'text-brandError-400',
            self::MAINTENANCE => 'text-brandWarning-400',
            self::BLOCKED => 'text-brandNeutral-300',
        };
    }
}

