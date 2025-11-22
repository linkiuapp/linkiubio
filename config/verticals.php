<?php

/**
 * Configuración de Verticales de Negocio
 * 
 * Define qué features (funcionalidades) están disponibles para cada vertical.
 * Este mapeo se usa para:
 * - Asignar automáticamente features a categorías de negocio
 * - Habilitar/deshabilitar items del sidebar según el vertical
 * - Determinar qué funcionalidades están disponibles para cada tipo de tienda
 */

return [
    'ecommerce' => [
        'name' => 'Ecommerce',
        'description' => 'Tienda online tradicional - Aún no tiene funcionalidades adicionales',
        'features' => [
            // Features base compartidos por todos
            'dashboard',
            'orders',
            'products',
            'categories',
            'variables',
            'shipping',
            'payments',
            'branches',
            'coupons',
            'slider',
            'account',
            'master_key',
            'business_profile',
            'store_design',
            'billing',
            'ads',
            'tickets',
            'notificaciones_whatsapp',
            // Nota: Ecommerce NO tiene carrito ni checkout como features específicos
            // (aunque técnicamente los usa, no son features diferenciadores)
        ],
        'sidebar_sections' => [
            'favoritos',
            'tienda_productos',
            'marketing',
            'anuncios_soporte',
        ],
    ],

    'restaurant' => [
        'name' => 'Restaurante',
        'description' => 'Restaurante con reservas de mesas y consumo en local',
        'features' => [
            // Features base compartidos
            'dashboard',
            'orders',
            'products',
            'categories',
            'variables',
            'shipping',
            'payments',
            'branches',
            'coupons',
            'slider',
            'account',
            'master_key',
            'business_profile',
            'store_design',
            'billing',
            'ads',
            'tickets',
            'notificaciones_whatsapp',
            // Features específicos de restaurante
            'reservas_mesas',
            'consumo_local',
            'carrito',
            'checkout',
        ],
        'sidebar_sections' => [
            'favoritos',
            'tienda_productos',
            'reservas_servicios',
            'marketing',
            'anuncios_soporte',
        ],
    ],

    'hotel' => [
        'name' => 'Hotel',
        'description' => 'Hotel con reservas de habitaciones, servicio a habitación y restaurante',
        'features' => [
            // Features base compartidos
            'dashboard',
            'orders',
            'products',
            'categories',
            'variables',
            'shipping',
            'payments',
            'branches',
            'coupons',
            'slider',
            'account',
            'master_key',
            'business_profile',
            'store_design',
            'billing',
            'ads',
            'tickets',
            'notificaciones_whatsapp',
            // Features específicos de hotel
            'reservas_hotel',
            'servicio_habitacion',
            'reservas_mesas',      // Para restaurantes dentro del hotel
            'consumo_local',       // Room service
            'carrito',
            'checkout',
        ],
        'sidebar_sections' => [
            'favoritos',
            'tienda_productos',
            'reservas_servicios',
            'marketing',
            'anuncios_soporte',
        ],
    ],

    'dropshipping' => [
        'name' => 'Dropshipping',
        'description' => 'Sistema de relist similar a Shopify, sin carrito ni checkout tradicional',
        'features' => [
            // Features base compartidos
            'dashboard',
            'orders',
            'products',
            'categories',
            'variables',
            'shipping',
            'payments',
            'branches',
            'coupons',
            'slider',
            'account',
            'master_key',
            'business_profile',
            'store_design',
            'billing',
            'ads',
            'tickets',
            'notificaciones_whatsapp',
            // Features específicos de dropshipping (cuando se implementen)
            // 'proveedores',
            // 'sincronizacion_productos',
            // 'automatizacion_pedidos',
        ],
        'sidebar_sections' => [
            'favoritos',
            'tienda_productos',
            'marketing',
            'anuncios_soporte',
        ],
        'note' => 'NO usa Carrito ni Checkout - Sistema relist directo',
    ],
];

