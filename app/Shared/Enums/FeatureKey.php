<?php

namespace App\Shared\Enums;

enum FeatureKey: string
{
    // Features base (inglés - ya existentes)
    case DASHBOARD = 'dashboard';
    case ORDERS = 'orders';
    case PRODUCTS = 'products';
    case CATEGORIES = 'categories';
    case VARIABLES = 'variables';
    case SHIPPING = 'shipping';
    case PAYMENTS = 'payments';
    case BRANCHES = 'branches';
    case COUPONS = 'coupons';
    case SLIDER = 'slider';
    case ACCOUNT = 'account';
    case MASTER_KEY = 'master_key';
    case BUSINESS_PROFILE = 'business_profile';
    case STORE_DESIGN = 'store_design';
    case BILLING = 'billing';
    case ADS = 'ads';
    case TICKETS = 'tickets';

    // Features específicos (español - nuevos)
    case RESERVAS_MESAS = 'reservas_mesas';
    case CONSUMO_LOCAL = 'consumo_local';
    case FAVORITOS = 'favoritos';
    case RESERVAS_HOTEL = 'reservas_hotel';
    case CONSUMO_HOTEL = 'consumo_hotel';
    case NOTIFICACIONES_WHATSAPP = 'notificaciones_whatsapp';

    /**
     * Obtener el nombre legible del feature
     */
    public function label(): string
    {
        return match($this) {
            self::DASHBOARD => 'Dashboard',
            self::ORDERS => 'Pedidos',
            self::PRODUCTS => 'Productos',
            self::CATEGORIES => 'Categorías',
            self::VARIABLES => 'Variables',
            self::SHIPPING => 'Gestión de Envíos',
            self::PAYMENTS => 'Métodos de Pago',
            self::BRANCHES => 'Sedes',
            self::COUPONS => 'Cupones',
            self::SLIDER => 'Slider',
            self::ACCOUNT => 'Mi Cuenta',
            self::MASTER_KEY => 'Clave Maestra',
            self::BUSINESS_PROFILE => 'Perfil del Negocio',
            self::STORE_DESIGN => 'Diseño de la Tienda',
            self::BILLING => 'Plan y Facturación',
            self::ADS => 'Anuncios',
            self::TICKETS => 'Soporte y Tickets',
            self::RESERVAS_MESAS => 'Reservas de Mesas',
            self::CONSUMO_LOCAL => 'Consumo en Local',
            self::FAVORITOS => 'Favoritos',
            self::RESERVAS_HOTEL => 'Reservas de Hotel',
            self::CONSUMO_HOTEL => 'Servicio a Habitación',
            self::NOTIFICACIONES_WHATSAPP => 'Notificaciones WhatsApp',
        };
    }

    /**
     * Obtener el área del feature (admin, tenant, public)
     */
    public function area(): string
    {
        return match($this) {
            self::FAVORITOS => 'tenant',
            default => 'admin'
        };
    }
}

