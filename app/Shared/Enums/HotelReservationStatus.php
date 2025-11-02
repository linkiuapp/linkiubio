<?php

namespace App\Shared\Enums;

enum HotelReservationStatus: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case CHECKED_IN = 'checked_in';
    case CHECKED_OUT = 'checked_out';
    case CANCELLED = 'cancelled';

    /**
     * Obtener el nombre legible del estado
     */
    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pendiente',
            self::CONFIRMED => 'Confirmada',
            self::CHECKED_IN => 'Check-In Realizado',
            self::CHECKED_OUT => 'Check-Out Realizado',
            self::CANCELLED => 'Cancelada',
        };
    }

    /**
     * Obtener clase de color para UI
     */
    public function colorClass(): string
    {
        return match($this) {
            self::PENDING => 'text-brandWarning-400',
            self::CONFIRMED => 'text-brandSuccess-400',
            self::CHECKED_IN => 'text-brandPrimary-400',
            self::CHECKED_OUT => 'text-brandNeutral-400',
            self::CANCELLED => 'text-brandError-400',
        };
    }

    /**
     * Obtener ícono para UI
     */
    public function icon(): string
    {
        return match($this) {
            self::PENDING => 'hourglass',
            self::CONFIRMED => 'check-circle',
            self::CHECKED_IN => 'log-in',
            self::CHECKED_OUT => 'log-out',
            self::CANCELLED => 'x-circle',
        };
    }

    /**
     * Verificar si el estado es activo (no cancelado ni completado)
     */
    public function isActive(): bool
    {
        return in_array($this, [self::PENDING, self::CONFIRMED, self::CHECKED_IN]);
    }
}

