<?php

namespace App\Services;

use App\Shared\Models\Store;

/**
 * TourService - Controla qué tours mostrar según el estado de la tienda
 * 
 * Los tours solo se muestran cuando el usuario es nuevo y no ha creado
 * contenido en la sección correspondiente.
 */
class TourService
{
    /**
     * Tours disponibles por vertical
     */
    protected array $toursByVertical = [
        // Tours comunes a todas las verticales
        'common' => [
            'dashboard_bienvenida',
            'gestionar_categorias',
            'crear_categoria',
            'gestionar_variables',
            'crear_variable',
            'gestionar_productos',
            'crear_producto',
            'crear_metodo_pago',
            'diseño_tienda',
            'crear_cupon',
            'gestionar_pedido',
            'crear_slider',
            'gestionar_inventario',
            'notificaciones_whatsapp',
            'gestionar_metodos_pago',
            'gestionar_sedes',
            'gestionar_cupones',
            'gestionar_sliders',
        ],
        
        // Tours específicos por vertical
        'ecommerce' => [
            'configurar_envios',
            'crear_sede',
        ],
        
        'restaurant' => [
            'crear_mesa',
            'configurar_consumo_local',
        ],
        
        'hotel' => [
            'crear_tipo_habitacion',
            'crear_habitacion',
            'configurar_room_service',
        ],
        
        'dropshipping' => [
            'configurar_envios',
        ],
    ];

    /**
     * Obtener todos los tours disponibles para una tienda
     */
    public function getAvailableTours(Store $store): array
    {
        $tours = [];
        // Obtener vertical desde businessCategory
        $vertical = $store->businessCategory?->vertical ?? 'ecommerce';
        
        // Tours comunes
        foreach ($this->toursByVertical['common'] as $tour) {
            if ($this->shouldShowTour($store, $tour)) {
                $tours[] = $tour;
            }
        }
        
        // Tours específicos de la vertical
        if (isset($this->toursByVertical[$vertical])) {
            foreach ($this->toursByVertical[$vertical] as $tour) {
                if ($this->shouldShowTour($store, $tour)) {
                    $tours[] = $tour;
                }
            }
        }
        
        return $tours;
    }

    /**
     * Verificar si un tour específico debe mostrarse
     */
    public function shouldShowTour(Store $store, string $tourName): bool
    {
        return match($tourName) {
            // Tours comunes
            'dashboard_bienvenida' => $this->isNewStore($store),
            'gestionar_categorias' => true, // Siempre disponible para gestionar categorías
            'crear_categoria' => $store->categories()->count() === 0,
            'gestionar_variables' => true, // Siempre disponible para gestionar variables
            'crear_variable' => $store->variables()->count() === 0,
            'gestionar_productos' => true, // Siempre disponible para gestionar productos
            'crear_producto' => $store->products()->count() === 0,
            'crear_metodo_pago' => $store->paymentMethods()->count() === 0,
            'diseño_tienda' => empty($store->design?->logo),
            'crear_cupon' => $store->coupons()->count() === 0,
            'gestionar_pedido' => $store->orders()->count() === 1, // Exactamente 1
            'crear_slider' => $store->sliders()->count() === 0,
            'crear_variable' => $store->variables()->count() === 0,
            'gestionar_inventario' => true, // Siempre disponible, se muestra automáticamente en la secuencia
            'notificaciones_whatsapp' => empty($store->owner_phone), // Si no tiene número configurado
            'gestionar_metodos_pago' => true, // Siempre disponible para gestionar métodos de pago
            'gestionar_sedes' => true, // Siempre disponible para gestionar sedes
            'gestionar_cupones' => true, // Siempre disponible para gestionar cupones
            'gestionar_sliders' => true, // Siempre disponible para gestionar sliders
            
            // Ecommerce
            'configurar_envios' => $store->simpleShipping?->zones()->count() === 0 || !$store->simpleShipping,
            'crear_sede' => $store->locations()->count() === 0,
            
            // Restaurant
            'crear_mesa' => $this->featureEnabled($store, 'consumo_local') && 
                           $store->tables()->where('type', 'mesa')->count() === 0,
            'configurar_consumo_local' => $this->featureEnabled($store, 'consumo_local') && 
                                         !($store->dineInSettings?->is_enabled ?? false),
            
            // Hotel
            'crear_tipo_habitacion' => $this->featureEnabled($store, 'reservas_hotel') && 
                                      $store->roomTypes()->count() === 0,
            'crear_habitacion' => $this->featureEnabled($store, 'reservas_hotel') && 
                                 $store->rooms()->count() === 0,
            'configurar_room_service' => $this->featureEnabled($store, 'consumo_hotel') && 
                                        $store->tables()->where('type', 'habitacion')->count() === 0,
            
            default => false,
        };
    }

    /**
     * Verificar si es una tienda nueva (sin pedidos)
     */
    protected function isNewStore(Store $store): bool
    {
        return $store->orders()->count() === 0;
    }

    /**
     * Verificar si un feature está habilitado
     */
    protected function featureEnabled(Store $store, string $feature): bool
    {
        return function_exists('featureEnabled') ? featureEnabled($store, $feature) : false;
    }

    /**
     * Obtener información del tour para el frontend
     */
    public function getTourInfo(string $tourName): array
    {
        $tourInfo = [
            'dashboard_bienvenida' => [
                'title' => '¡Bienvenido a tu tienda!',
                'description' => 'Te mostraremos cómo funciona tu panel de administración.',
                'steps' => 8,
            ],
            'gestionar_categorias' => [
                'title' => 'Gestionar tus categorías',
                'description' => 'Organiza tus productos en categorías.',
                'steps' => 2,
            ],
            'crear_categoria' => [
                'title' => 'Crear tu primera categoría',
                'description' => 'Organiza tus productos en categorías.',
                'steps' => 5,
            ],
            'gestionar_variables' => [
                'title' => 'Gestionar tus variables',
                'description' => 'Crea variables para tus productos (tallas, colores, etc.).',
                'steps' => 2,
            ],
            'crear_variable' => [
                'title' => 'Crear tu primera variable',
                'description' => 'Crea variables para tus productos.',
                'steps' => 5,
            ],
            'gestionar_productos' => [
                'title' => 'Gestionar tus productos',
                'description' => 'Crea y administra tus productos.',
                'steps' => 2,
            ],
            'crear_producto' => [
                'title' => 'Crear tu primer producto',
                'description' => 'Aprende a agregar productos a tu tienda.',
                'steps' => 10,
            ],
            'crear_metodo_pago' => [
                'title' => 'Configurar métodos de pago',
                'description' => 'Define cómo te pagarán tus clientes.',
                'steps' => 5,
            ],
            'configurar_envios' => [
                'title' => 'Configurar zonas de envío',
                'description' => 'Define dónde entregas y cuánto cobras.',
                'steps' => 5,
            ],
            'diseño_tienda' => [
                'title' => 'Personalizar tu tienda',
                'description' => 'Agrega tu logo y colores de marca.',
                'steps' => 11,
            ],
            'crear_cupon' => [
                'title' => 'Crear un cupón de descuento',
                'description' => 'Atrae clientes con promociones.',
                'steps' => 20,
            ],
            'crear_slider' => [
                'title' => 'Crear slider',
                'description' => 'Aprende a crear sliders promocionales para tu tienda.',
                'steps' => 15,
            ],
            'gestionar_pedido' => [
                'title' => '¡Tu primer pedido!',
                'description' => 'Aprende a gestionar pedidos.',
                'steps' => 5,
            ],
            'gestionar_metodos_pago' => [
                'title' => 'Gestionar métodos de pago',
                'description' => 'Configura cómo te pagarán tus clientes.',
                'steps' => 7,
            ],
            'gestionar_sedes' => [
                'title' => 'Gestionar sedes',
                'description' => 'Administra las sedes de tu tienda.',
                'steps' => 2,
            ],
            'crear_sede' => [
                'title' => 'Crear tu primera sede',
                'description' => 'Aprende a crear y configurar sedes para tu tienda.',
                'steps' => 14,
            ],
            'gestionar_cupones' => [
                'title' => 'Gestionar cupones',
                'description' => 'Administra los cupones de descuento de tu tienda.',
                'steps' => 2,
            ],
            'gestionar_sliders' => [
                'title' => 'Gestionar sliders',
                'description' => 'Administra los sliders promocionales de tu tienda.',
                'steps' => 2,
            ],
            'notificaciones_whatsapp' => [
                'title' => 'Configurar notificaciones WhatsApp',
                'description' => 'Configura tu número para recibir notificaciones automáticas.',
                'steps' => 3,
            ],
        ];

        return $tourInfo[$tourName] ?? [
            'title' => 'Tutorial',
            'description' => 'Aprende a usar esta funcionalidad.',
            'steps' => 5,
        ];
    }
}

