<?php

namespace App\Services;

use App\Models\AssistantConversation;
use App\Models\AssistantMessage;
use App\Models\KiuBotResponseCache;
use App\Shared\Models\Store;
use App\Shared\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * KiuBotAssistantService - Asistente virtual para dashboard
 * 
 * Proporciona ayuda educativa y sugerencias personalizadas
 * basadas en los datos de la tienda.
 */
class KiuBotAssistantService extends KiuBotService
{
    protected ?StoreInsightsService $insightsService = null;

    /**
     * Establecer el servicio de insights
     */
    public function setInsightsService(StoreInsightsService $service): self
    {
        $this->insightsService = $service;
        return $this;
    }
    /**
     * Base de conocimiento con todas las funcionalidades del sidebar
     */
    protected function getKnowledgeBase(): array
    {
        return [
            // FAVORITOS
            'dashboard' => [
                'keywords' => ['dashboard', 'panel', 'inicio', 'principal', 'estadísticas', 'métricas'],
                'title' => 'Dashboard',
                'description' => 'El dashboard es tu panel principal donde puedes ver estadísticas de tu tienda, pedidos recientes y accesos rápidos.',
                'steps' => [
                    '1. El dashboard muestra estadísticas de pedidos por estado (Total, Pendientes, Confirmados, Preparando, Enviados, Entregados)',
                    '2. Puedes ver tus pedidos más recientes en la parte inferior',
                    '3. Usa las acciones rápidas para crear contenido rápidamente',
                    '4. Los anuncios importantes de Linkiu aparecen en la parte superior'
                ],
                'route' => 'tenant.admin.dashboard',
            ],
            'pedidos' => [
                'keywords' => ['pedidos', 'ordenes', 'orden', 'pedido', 'ventas', 'compras'],
                'title' => 'Pedidos',
                'description' => 'Gestiona todos los pedidos de tu tienda, cambia estados, ve detalles y más.',
                'steps' => [
                    '1. Ve a "Pedidos" en el menú lateral (Favoritos)',
                    '2. Verás una lista de todos tus pedidos con filtros por estado, tipo, método de pago, etc.',
                    '3. Haz clic en un pedido para ver detalles completos',
                    '4. Puedes cambiar el estado del pedido desde la lista o desde el detalle',
                    '5. Usa los filtros para encontrar pedidos específicos',
                    '6. Puedes crear pedidos manualmente desde el botón "Nuevo Pedido"'
                ],
                'route' => 'tenant.admin.orders.index',
            ],

            // TIENDA Y PRODUCTOS
            'categorias' => [
                'keywords' => ['categoría', 'categorias', 'categoria', 'categorías', 'categorizar', 'organizar productos'],
                'title' => 'Categorías',
                'description' => 'Organiza tus productos en categorías para facilitar la navegación de tus clientes.',
                'steps' => [
                    '1. Ve a "Categorías" en el menú lateral (Tienda y productos)',
                    '2. Haz clic en "Nueva Categoría"',
                    '3. Selecciona un ícono del selector visual (requerido). Si necesitas un ícono que no está disponible, contacta al WhatsApp de Linkiu para solicitarlo',
                    '4. Completa el formulario: nombre (requerido), descripción (opcional), categoría padre (opcional)',
                    '5. Guarda la categoría',
                    '6. Asigna productos a categorías desde la edición de cada producto',
                    '7. Las categorías aparecen en tu tienda pública para que los clientes naveguen'
                ],
                'route' => 'tenant.admin.categories.index',
            ],
            'variables' => [
                'keywords' => ['variable', 'variables', 'variante', 'variantes', 'talla', 'color', 'tamaño'],
                'title' => 'Variables',
                'description' => 'Crea variables para tus productos como tallas, colores, sabores, etc.',
                'steps' => [
                    '1. Ve a "Variables" en el menú lateral (Tienda y productos)',
                    '2. Haz clic en "Nueva Variable"',
                    '3. Ingresa el nombre de la variable (ej: Talla, Color, Sabor)',
                    '4. Agrega los valores posibles (ej: S, M, L, XL para Talla)',
                    '5. Guarda la variable',
                    '6. Asigna variables a tus productos desde la edición de cada producto',
                    '7. Los clientes podrán seleccionar variantes al agregar productos al carrito'
                ],
                'route' => 'tenant.admin.variables.index',
            ],
            'productos' => [
                'keywords' => ['producto', 'productos', 'agregar producto', 'crear producto', 'nuevo producto'],
                'title' => 'Productos',
                'description' => 'Gestiona todos tus productos: crea, edita, activa/desactiva y más.',
                'steps' => [
                    '1. Ve a "Productos" en el menú lateral (Tienda y productos)',
                    '2. Haz clic en "Nuevo Producto"',
                    '3. Completa la información básica: nombre, descripción, precio',
                    '4. Sube imágenes del producto (puedes usar KiuBot para mejorar la descripción)',
                    '5. Asigna categorías y variables si las tienes',
                    '6. Configura el stock y disponibilidad',
                    '7. Activa o desactiva el producto según quieras mostrarlo en tu tienda',
                    '8. Guarda el producto',
                    '9. Puedes editar productos existentes haciendo clic en ellos'
                ],
                'route' => 'tenant.admin.products.index',
            ],
            'inventario' => [
                'keywords' => ['inventario', 'stock', 'almacén', 'existencias', 'cantidad'],
                'title' => 'Inventario',
                'description' => 'Gestiona el stock de tus productos y controla las existencias.',
                'steps' => [
                    '1. Ve a "Inventario" en el menú lateral (dentro de Tienda y productos)',
                    '2. Verás una lista de todos tus productos con su stock actual',
                    '3. Puedes filtrar por productos con stock bajo o sin stock',
                    '4. Haz clic en un producto para actualizar su stock',
                    '5. Ingresa la cantidad disponible y guarda',
                    '6. El sistema te alertará cuando el stock esté bajo',
                    '7. Los productos sin stock no se mostrarán como disponibles en tu tienda'
                ],
                'route' => 'tenant.admin.inventario.index',
            ],
            'envios' => [
                'keywords' => ['envío', 'envios', 'entrega', 'zonas', 'delivery', 'domicilio'],
                'title' => 'Gestión de Envíos',
                'description' => 'Configura zonas de entrega y costos de envío para tu tienda.',
                'steps' => [
                    '1. Ve a "Gestión de Envíos" en el menú lateral (Tienda y productos)',
                    '2. Haz clic en "Nueva Zona"',
                    '3. Ingresa el nombre de la zona (ej: Zona Centro, Zona Norte)',
                    '4. Define el área de cobertura (puedes dibujar en el mapa o ingresar direcciones)',
                    '5. Establece el costo de envío para esa zona',
                    '6. Guarda la zona',
                    '7. Los clientes verán el costo de envío según su ubicación al hacer checkout',
                    '8. Puedes editar o eliminar zonas existentes'
                ],
                'route' => 'tenant.admin.simple-shipping.index',
            ],
            'metodos_pago' => [
                'keywords' => ['método de pago', 'metodos de pago', 'pago', 'pagos', 'transferencia', 'efectivo', 'nequi', 'daviplata'],
                'title' => 'Métodos de Pago',
                'description' => 'Configura los métodos de pago que aceptas en tu tienda.',
                'steps' => [
                    '1. Ve a "Métodos de Pago" en el menú lateral (Tienda y productos)',
                    '2. Haz clic en "Nuevo Método de Pago"',
                    '3. Selecciona el tipo de método (Transferencia, Efectivo, Nequi, Daviplata, etc.)',
                    '4. Completa la información requerida (número de cuenta, nombre, etc.)',
                    '5. Sube una imagen del comprobante si es necesario',
                    '6. Activa o desactiva el método según quieras mostrarlo',
                    '7. Guarda el método',
                    '8. Los clientes verán los métodos disponibles al hacer checkout'
                ],
                'route' => 'tenant.admin.payment-methods.index',
            ],
            'sedes' => [
                'keywords' => ['sede', 'sedes', 'ubicación', 'ubicaciones', 'local', 'tienda física', 'dirección'],
                'title' => 'Sedes',
                'description' => 'Gestiona las ubicaciones físicas de tu negocio.',
                'steps' => [
                    '1. Ve a "Sedes" en el menú lateral (Tienda y productos)',
                    '2. Haz clic en "Nueva Sede"',
                    '3. Ingresa la información: nombre, dirección, teléfono',
                    '4. Agrega la ubicación en el mapa',
                    '5. Configura horarios de atención si aplica',
                    '6. Guarda la sede',
                    '7. Los clientes podrán ver tus sedes en tu tienda pública',
                    '8. Puedes tener múltiples sedes según tu plan'
                ],
                'route' => 'tenant.admin.locations.index',
            ],

            // MARKETING
            'diseno_tienda' => [
                'keywords' => ['diseño', 'diseño de tienda', 'apariencia', 'logo', 'colores', 'personalizar'],
                'title' => 'Diseño de la Tienda',
                'description' => 'Personaliza la apariencia de tu tienda: logo, colores, banner, etc.',
                'steps' => [
                    '1. Ve a "Diseño de la Tienda" en el menú lateral (Marketing)',
                    '2. Sube tu logo (aparecerá en tu tienda pública)',
                    '3. Selecciona los colores de tu marca (primario, secundario)',
                    '4. Sube un banner principal para la página de inicio',
                    '5. Configura imágenes adicionales si lo deseas',
                    '6. Guarda los cambios',
                    '7. Los cambios se reflejarán inmediatamente en tu tienda pública'
                ],
                'route' => 'tenant.admin.store-design.index',
            ],
            'cupones' => [
                'keywords' => ['cupón', 'cupones', 'descuento', 'promoción', 'oferta', 'código promocional'],
                'title' => 'Cupones',
                'description' => 'Crea cupones de descuento para promocionar tu tienda y aumentar ventas.',
                'steps' => [
                    '1. Ve a "Cupones" en el menú lateral (Marketing)',
                    '2. Haz clic en "Nuevo Cupón"',
                    '3. Ingresa el código del cupón (ej: DESCUENTO20)',
                    '4. Selecciona el tipo de descuento (porcentaje o monto fijo)',
                    '5. Establece el valor del descuento',
                    '6. Configura fechas de vigencia (inicio y fin)',
                    '7. Opcional: establece un monto mínimo de compra',
                    '8. Opcional: limita el número de usos',
                    '9. Activa el cupón y guarda',
                    '10. Comparte el código con tus clientes para que lo usen al comprar'
                ],
                'route' => 'tenant.admin.coupons.index',
            ],
            'slider' => [
                'keywords' => ['slider', 'carrusel', 'banner', 'imágenes', 'promociones visuales'],
                'title' => 'Slider',
                'description' => 'Crea un carrusel de imágenes promocionales en la página principal de tu tienda.',
                'steps' => [
                    '1. Ve a "Slider" en el menú lateral (Marketing)',
                    '2. Haz clic en "Nuevo Slider"',
                    '3. Sube una imagen (recomendado: 1920x600px)',
                    '4. Agrega un título y descripción opcional',
                    '5. Opcional: agrega un enlace (puede llevar a un producto, categoría, etc.)',
                    '6. Establece el orden de aparición',
                    '7. Activa el slider y guarda',
                    '8. Los sliders aparecerán en la parte superior de tu tienda pública',
                    '9. Puedes tener múltiples sliders que rotan automáticamente'
                ],
                'route' => 'tenant.admin.sliders.index',
            ],

            // SOPORTE
            'tickets' => [
                'keywords' => ['ticket', 'tickets', 'soporte', 'ayuda', 'problema', 'consulta', 'reporte'],
                'title' => 'Soporte y Tickets',
                'description' => 'Crea tickets de soporte para recibir ayuda del equipo de Linkiu.',
                'steps' => [
                    '1. Ve a "Soporte y Tickets" en el menú lateral (Anuncios y soporte)',
                    '2. Haz clic en "Crear Ticket"',
                    '3. Selecciona la categoría del problema',
                    '4. Escribe una descripción detallada de tu consulta o problema',
                    '5. Opcional: adjunta imágenes o archivos',
                    '6. Envía el ticket',
                    '7. Recibirás notificaciones cuando el equipo responda',
                    '8. Puedes ver el historial de todos tus tickets y sus respuestas'
                ],
                'route' => 'tenant.admin.tickets.index',
            ],
            'anuncios' => [
                'keywords' => ['anuncio', 'anuncios', 'noticias', 'actualizaciones', 'novedades'],
                'title' => 'Anuncios de Linkiu',
                'description' => 'Mantente informado sobre las últimas novedades y actualizaciones de Linkiu.',
                'steps' => [
                    '1. Ve a "Anuncios de Linkiu" en el menú lateral (Anuncios y soporte)',
                    '2. Verás una lista de todos los anuncios importantes',
                    '3. Los anuncios no leídos aparecen marcados',
                    '4. Haz clic en un anuncio para leerlo completo',
                    '5. Los anuncios pueden incluir nuevas funcionalidades, tips, promociones, etc.',
                    '6. Mantente al día revisando los anuncios regularmente'
                ],
                'route' => 'tenant.admin.announcements.index',
            ],

            // PERFIL Y CONFIGURACIÓN
            'perfil' => [
                'keywords' => ['perfil', 'mi cuenta', 'usuario', 'datos personales'],
                'title' => 'Mi Cuenta',
                'description' => 'Gestiona tu información personal y configuración de cuenta.',
                'steps' => [
                    '1. Haz clic en tu nombre en la parte inferior del menú lateral',
                    '2. Selecciona "Mi Cuenta"',
                    '3. Actualiza tu información personal: nombre, email, teléfono',
                    '4. Cambia tu contraseña si lo deseas',
                    '5. Guarda los cambios'
                ],
                'route' => 'tenant.admin.profile.index',
            ],
            'perfil_negocio' => [
                'keywords' => ['perfil del negocio', 'información del negocio', 'datos de la tienda', 'negocio'],
                'title' => 'Perfil del Negocio',
                'description' => 'Gestiona la información pública de tu negocio.',
                'steps' => [
                    '1. Haz clic en tu nombre en la parte inferior del menú lateral',
                    '2. Selecciona "Perfil del Negocio"',
                    '3. Actualiza la información: nombre, descripción, teléfono, email',
                    '4. Agrega redes sociales si las tienes',
                    '5. Configura horarios de atención',
                    '6. Guarda los cambios',
                    '7. Esta información aparecerá en tu tienda pública'
                ],
                'route' => 'tenant.admin.business-profile.index',
            ],
            'billing' => [
                'keywords' => ['facturación', 'plan', 'suscripción', 'pago', 'billing'],
                'title' => 'Plan y Facturación',
                'description' => 'Gestiona tu plan de suscripción y facturación.',
                'steps' => [
                    '1. Haz clic en tu nombre en la parte inferior del menú lateral',
                    '2. Selecciona "Plan y Facturación"',
                    '3. Verás información sobre tu plan actual',
                    '4. Puedes ver tus facturas y descargarlas',
                    '5. Si quieres cambiar de plan, contacta a soporte',
                    '6. Revisa los límites de tu plan (productos, categorías, etc.)'
                ],
                'route' => 'tenant.admin.billing.index',
            ],
            'master_key' => [
                'keywords' => ['clave maestra', 'clave maestra', 'master key', 'recuperación clave'],
                'title' => 'Clave Maestra',
                'description' => 'Gestiona tu clave maestra para acceder a funciones administrativas importantes.',
                'steps' => [
                    '1. Haz clic en tu nombre en la parte inferior del menú lateral',
                    '2. Selecciona "Clave Maestra"',
                    '3. Configura o cambia tu clave maestra',
                    '4. Si la olvidaste, puedes solicitar recuperación'
                ],
                'route' => 'tenant.admin.master-key.index',
            ],
            'whatsapp_notifications' => [
                'keywords' => ['whatsapp', 'notificaciones whatsapp', 'notificación whatsapp', 'mensajes whatsapp'],
                'title' => 'Notificaciones WhatsApp',
                'description' => 'Configura las notificaciones por WhatsApp para estar al día con tu tienda.',
                'steps' => [
                    '1. Ve a "Notificaciones WhatsApp" en el menú lateral (Reservas y Servicios)',
                    '2. Activa o desactiva las notificaciones',
                    '3. Configura qué tipos de notificaciones quieres recibir',
                    '4. Verifica que el número de WhatsApp esté correcto'
                ],
                'route' => 'tenant.admin.whatsapp-notifications.index',
            ],
            'table_reservations' => [
                'keywords' => ['reserva de mesa', 'reservas de mesas', 'reservar mesa', 'reservación mesa', 'mesa reservada'],
                'title' => 'Reservas de Mesas',
                'description' => 'Gestiona las reservas de mesas de tu restaurante.',
                'steps' => [
                    '1. Ve a "Reservas de Mesas" en el menú lateral (Reservas y Servicios)',
                    '2. Crea reservas manualmente o gestiona las reservas de clientes',
                    '3. Configura horarios disponibles y gestiona las mesas',
                    '4. Confirma, completa o cancela reservas según corresponda'
                ],
                'route' => 'tenant.admin.reservations.index',
            ],
            'dine_in' => [
                'keywords' => ['consumo en local', 'dine in', 'mesas', 'pedidos en local', 'qr mesa'],
                'title' => 'Consumo en Local',
                'description' => 'Gestiona el consumo en local con códigos QR para que los clientes pidan desde las mesas.',
                'steps' => [
                    '1. Ve a "Consumo en Local" en el menú lateral (Reservas y Servicios)',
                    '2. Crea mesas y genera códigos QR para cada una',
                    '3. Los clientes escanean el QR y hacen pedidos desde su celular',
                    '4. Gestiona los pedidos activos desde el dashboard'
                ],
                'route' => 'tenant.admin.dine-in.tables.index',
            ],
            'hotel_reservations' => [
                'keywords' => ['reserva de hotel', 'reservas de hotel', 'reservar habitación', 'reservación hotel', 'check in', 'check out'],
                'title' => 'Reservas de Hotel',
                'description' => 'Gestiona las reservas de habitaciones de tu hotel.',
                'steps' => [
                    '1. Ve a "Reservas de Hotel" en el menú lateral (Reservas y Servicios)',
                    '2. Configura tipos de habitación y crea habitaciones',
                    '3. Crea reservas manualmente o gestiona las reservas de clientes',
                    '4. Realiza check-in, check-out y gestiona el estado de las habitaciones'
                ],
                'route' => 'tenant.admin.hotel.reservations.index',
            ],
            'room_service' => [
                'keywords' => ['servicio a habitación', 'room service', 'habitación', 'pedidos habitación', 'qr habitación'],
                'title' => 'Servicio a Habitación',
                'description' => 'Gestiona el servicio a habitación con códigos QR para que los huéspedes pidan desde sus habitaciones.',
                'steps' => [
                    '1. Ve a "Servicio a Habitación" en el menú lateral (Reservas y Servicios)',
                    '2. Las habitaciones tienen códigos QR automáticos',
                    '3. Los huéspedes escanean el QR y hacen pedidos desde su celular',
                    '4. Gestiona los pedidos activos desde el dashboard'
                ],
                'route' => 'tenant.admin.dine-in.tables.index',
            ],
        ];
    }

    /**
     * Procesar mensaje del usuario
     */
    public function processMessage(string $message, Store $store, User $user, ?string $sessionId = null): array
    {
        try {
            // Generar o obtener session_id
            if (!$sessionId) {
                $sessionId = Str::uuid()->toString();
            }

            // Obtener o crear conversación
            $conversation = AssistantConversation::getOrCreateSession($sessionId, $store->id, $user->id);

            // Analizar intención
            $intent = $this->analyzeIntent($message);

            // Verificar si es una solicitud de insights/datos
            if ($intent === 'insights') {
                $response = $this->generateInsightsResponse($message, $store);
            } else {
                // ✅ CACHE: Buscar respuesta cacheada para preguntas educativas
                $cachedResponse = $this->findCachedResponse($message, $store->vertical);
                
                if ($cachedResponse) {
                    $response = [
                        'message' => $cachedResponse->response,
                        'actions' => [],
                        'tokens_used' => 0,
                        'cached' => true,
                    ];
                } else {
                    // Buscar en base de conocimiento
                    $knowledgeMatch = $this->findInKnowledgeBase($message);

                    // Construir contexto
                    $context = $this->buildStoreContext($store);

                    // Generar respuesta
                    if ($knowledgeMatch && $intent === 'educational') {
                        $response = $this->generateEducationalResponse($message, $knowledgeMatch, $context, $store);
                    } elseif ($intent === 'suggestion') {
                        $response = $this->generateSuggestionResponse($message, $store);
                    } else {
                        $response = $this->generateGeneralResponse($message, $context, $store);
                    }

                    // ✅ CACHE: Guardar respuestas educativas y sugerencias para futuro uso
                    if (in_array($intent, ['educational', 'suggestion']) && ($response['tokens_used'] ?? 0) > 0) {
                        $this->cacheResponse($message, $response['message'], $intent, $store->vertical);
                    }
                }
            }

            // Guardar mensajes
            AssistantMessage::create([
                'conversation_id' => $conversation->id,
                'role' => 'user',
                'message' => $message,
            ]);

            $assistantMessage = AssistantMessage::create([
                'conversation_id' => $conversation->id,
                'role' => 'assistant',
                'message' => $response['message'],
                'metadata' => $response['actions'] ?? null,
                'tokens_used' => $response['tokens_used'] ?? 0,
            ]);

            return [
                'success' => true,
                'message' => $response['message'],
                'actions' => $response['actions'] ?? [],
                'tokens_used' => $response['tokens_used'] ?? 0,
                'session_id' => $sessionId,
                'cached' => $response['cached'] ?? false,
            ];

        } catch (\Exception $e) {
            Log::error('KiuBotAssistant: Error procesando mensaje', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Lo siento, ocurrió un error al procesar tu mensaje. Por favor intenta nuevamente.',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Buscar respuesta cacheada
     */
    protected function findCachedResponse(string $question, ?string $vertical): ?KiuBotResponseCache
    {
        try {
            return KiuBotResponseCache::findCachedResponse($question, $vertical);
        } catch (\Exception $e) {
            // Si la tabla no existe aún, continuar sin cache
            return null;
        }
    }

    /**
     * Guardar respuesta en cache
     */
    protected function cacheResponse(string $question, string $response, string $category, ?string $vertical): void
    {
        try {
            KiuBotResponseCache::cacheResponse($question, $response, $category, $vertical);
        } catch (\Exception $e) {
            // Si la tabla no existe, ignorar silenciosamente
            Log::debug('KiuBot: No se pudo cachear respuesta', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Generar respuesta basada en insights de la tienda
     */
    protected function generateInsightsResponse(string $message, Store $store): array
    {
        $insights = $this->getStoreInsights($store);
        $lowerMessage = strtolower($message);
        
        // Determinar qué tipo de insight quiere el usuario
        if (str_contains($lowerMessage, 'venta') || str_contains($lowerMessage, 'vendido')) {
            return $this->formatSalesInsight($insights, $store);
        }
        
        if (str_contains($lowerMessage, 'stock') || str_contains($lowerMessage, 'inventario') || str_contains($lowerMessage, 'agotado')) {
            return $this->formatStockInsight($insights, $store);
        }
        
        if (str_contains($lowerMessage, 'promoción') || str_contains($lowerMessage, 'promocion') || str_contains($lowerMessage, 'navidad') || str_contains($lowerMessage, 'temporada')) {
            return $this->formatSeasonalInsight($insights, $store);
        }
        
        if (str_contains($lowerMessage, 'meta') || str_contains($lowerMessage, 'objetivo') || str_contains($lowerMessage, 'cómo voy') || str_contains($lowerMessage, 'como voy')) {
            return $this->formatGoalsInsight($insights, $store);
        }
        
        if (str_contains($lowerMessage, 'mejorar') || str_contains($lowerMessage, 'optimizar') || str_contains($lowerMessage, 'catálogo') || str_contains($lowerMessage, 'catalogo')) {
            return $this->formatCatalogInsight($insights, $store);
        }
        
        // Respuesta general de resumen
        return $this->formatSummaryInsight($insights, $store);
    }

    /**
     * Obtener insights de la tienda
     */
    protected function getStoreInsights(Store $store): array
    {
        if ($this->insightsService) {
            return $this->insightsService->setStore($store)->getAllInsights();
        }
        
        // Si no hay servicio de insights, intentar crearlo
        try {
            $service = app(StoreInsightsService::class)->setStore($store);
            return $service->getAllInsights();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Formatear insight de ventas
     */
    protected function formatSalesInsight(array $insights, Store $store): array
    {
        $performance = $insights['performance'] ?? [];
        $goals = $insights['goals'] ?? [];
        
        $salesThisWeek = $performance['sales']['this_week'] ?? 0;
        $salesLastWeek = $performance['sales']['last_week'] ?? 0;
        $changePercent = $performance['sales']['change_percent'] ?? 0;
        $trend = $changePercent >= 0 ? '📈' : '📉';
        $trendText = $changePercent >= 0 ? 'más' : 'menos';
        
        $topProduct = $performance['top_product'] ?? null;
        $peakHour = $performance['peak_hour'] ?? null;
        
        $message = "Resumen de ventas de {$store->name}:\n\n";
        $message .= "Esta semana: $" . number_format($salesThisWeek, 0, ',', '.') . " {$trend}\n";
        $message .= "Semana pasada: $" . number_format($salesLastWeek, 0, ',', '.') . "\n";
        $message .= "Cambio: " . abs($changePercent) . "% {$trendText}\n\n";
        
        if ($topProduct) {
            $message .= "Tu producto estrella este mes: {$topProduct['name']} ({$topProduct['units_sold']} vendidos)\n";
        }
        
        if ($peakHour) {
            $message .= "Hora pico de pedidos: {$peakHour['formatted']}\n";
        }
        
        $actions = [];
        if ($topProduct) {
            $actions[] = [
                'type' => 'link',
                'label' => 'Destacar producto estrella',
                'url' => route('tenant.admin.sliders.create', ['store' => $store->slug]),
            ];
        }
        
        return [
            'message' => trim($message),
            'actions' => $actions,
            'tokens_used' => 0,
        ];
    }

    /**
     * Formatear insight de stock
     */
    protected function formatStockInsight(array $insights, Store $store): array
    {
        $alerts = $insights['alerts'] ?? [];
        
        $outOfStock = collect($alerts)->firstWhere('type', 'warning');
        $lowStock = collect($alerts)->filter(fn($a) => str_contains($a['title'] ?? '', 'stock bajo'))->first();
        
        $message = "Estado de inventario de {$store->name}:\n\n";
        
        if ($outOfStock && str_contains($outOfStock['title'], 'agotados')) {
            $message .= "⚠️ {$outOfStock['title']}\n";
            $message .= "{$outOfStock['message']}\n\n";
        } else {
            $message .= "✅ No tienes productos agotados\n\n";
        }
        
        if ($lowStock) {
            $message .= "⚠️ {$lowStock['title']}\n";
        }
        
        $message .= "\nRecomendación: Revisa tu inventario regularmente para evitar perder ventas por falta de stock.";
        
        return [
            'message' => trim($message),
            'actions' => [
                [
                    'type' => 'link',
                    'label' => 'Ver inventario',
                    'url' => route('tenant.admin.inventario.index', ['store' => $store->slug]),
                ],
            ],
            'tokens_used' => 0,
        ];
    }

    /**
     * Formatear insight estacional
     */
    protected function formatSeasonalInsight(array $insights, Store $store): array
    {
        $seasonal = $insights['seasonal'] ?? [];
        
        if (empty($seasonal)) {
            $message = "No hay fechas especiales próximas, pero siempre es buen momento para crear promociones.\n\n";
            $message .= "Sugerencia: Crea un cupón de descuento para atraer nuevos clientes.";
        } else {
            $nextEvent = $seasonal[0];
            $message = "¡{$nextEvent['event']} está a {$nextEvent['days_until']} días!\n\n";
            $message .= "{$nextEvent['suggestion']}\n\n";
            $message .= "Código sugerido: {$nextEvent['suggested_coupon']}";
        }
        
        return [
            'message' => trim($message),
            'actions' => [
                [
                    'type' => 'link',
                    'label' => 'Crear cupón',
                    'url' => route('tenant.admin.coupons.create', ['store' => $store->slug]),
                ],
            ],
            'tokens_used' => 0,
        ];
    }

    /**
     * Formatear insight de metas
     */
    protected function formatGoalsInsight(array $insights, Store $store): array
    {
        $goals = $insights['goals'] ?? [];
        
        $currentSales = $goals['current_month']['sales'] ?? 0;
        $goalAmount = $goals['goal']['amount'] ?? 0;
        $progress = $goals['goal']['progress_percent'] ?? 0;
        $remaining = $goals['goal']['amount_remaining'] ?? 0;
        $ordersNeeded = $goals['goal']['orders_needed'] ?? 0;
        $daysRemaining = $goals['current_month']['days_remaining'] ?? 0;
        
        $progressBar = $this->generateProgressBar($progress);
        
        $message = "Tu progreso este mes:\n\n";
        $message .= "{$progressBar} {$progress}%\n\n";
        $message .= "Ventas: $" . number_format($currentSales, 0, ',', '.') . " / $" . number_format($goalAmount, 0, ',', '.') . "\n";
        
        if ($remaining > 0) {
            $message .= "\nPara alcanzar tu meta:\n";
            $message .= "- Faltan: $" . number_format($remaining, 0, ',', '.') . "\n";
            $message .= "- Necesitas: {$ordersNeeded} pedidos más\n";
            $message .= "- Tienes: {$daysRemaining} días restantes\n";
            
            if ($ordersNeeded > $daysRemaining) {
                $message .= "\n¡Considera crear una promoción para acelerar las ventas!";
            }
        } else {
            $message .= "\n¡Felicidades! Ya superaste tu meta del mes.";
        }
        
        return [
            'message' => trim($message),
            'actions' => [],
            'tokens_used' => 0,
        ];
    }

    /**
     * Formatear insight de catálogo
     */
    protected function formatCatalogInsight(array $insights, Store $store): array
    {
        $catalog = $insights['catalog'] ?? [];
        
        if (empty($catalog)) {
            $message = "Tu catálogo está en buen estado. No detecté problemas importantes.\n\n";
            $message .= "Tip: Los productos con buenas fotos y descripciones detalladas venden hasta 3 veces más.";
        } else {
            $message = "Oportunidades para mejorar tu catálogo:\n\n";
            
            foreach (array_slice($catalog, 0, 3) as $opt) {
                $icon = match($opt['type']) {
                    'no_image' => '📷',
                    'short_description' => '📝',
                    'no_category' => '📁',
                    'inactive' => '👁️',
                    'round_prices' => '💰',
                    default => '•',
                };
                $message .= "{$icon} {$opt['title']}\n";
                $message .= "   {$opt['message']}\n\n";
            }
        }
        
        return [
            'message' => trim($message),
            'actions' => [
                [
                    'type' => 'link',
                    'label' => 'Ver productos',
                    'url' => route('tenant.admin.products.index', ['store' => $store->slug]),
                ],
            ],
            'tokens_used' => 0,
        ];
    }

    /**
     * Formatear resumen general
     */
    protected function formatSummaryInsight(array $insights, Store $store): array
    {
        $alerts = $insights['alerts'] ?? [];
        $performance = $insights['performance'] ?? [];
        $goals = $insights['goals'] ?? [];
        
        $message = "Resumen de {$store->name}:\n\n";
        
        // Ventas
        $salesThisWeek = $performance['sales']['this_week'] ?? 0;
        $changePercent = $performance['sales']['change_percent'] ?? 0;
        $trend = $changePercent >= 0 ? '📈' : '📉';
        $message .= "Ventas semana: $" . number_format($salesThisWeek, 0, ',', '.') . " {$trend}\n";
        
        // Meta
        $progress = $goals['goal']['progress_percent'] ?? 0;
        $message .= "Meta del mes: {$progress}% completada\n\n";
        
        // Alertas importantes
        $importantAlerts = collect($alerts)->where('priority', 'high')->take(2);
        if ($importantAlerts->count() > 0) {
            $message .= "Requiere atención:\n";
            foreach ($importantAlerts as $alert) {
                $message .= "⚠️ {$alert['title']}\n";
            }
        }
        
        $message .= "\n¿Sobre qué te gustaría saber más? Puedes preguntarme sobre ventas, stock, promociones o metas.";
        
        return [
            'message' => trim($message),
            'actions' => [],
            'tokens_used' => 0,
        ];
    }

    /**
     * Generar barra de progreso visual
     */
    protected function generateProgressBar(float $percent): string
    {
        $filled = min(10, (int)($percent / 10));
        $empty = 10 - $filled;
        
        return '▓' . str_repeat('█', $filled) . str_repeat('░', $empty) . '▓';
    }

    /**
     * Generar respuesta de sugerencias
     */
    protected function generateSuggestionResponse(string $message, Store $store): array
    {
        $insights = $this->getStoreInsights($store);
        $vertical = $store->vertical ?? 'ecommerce';
        $lowerMessage = strtolower($message);
        
        // Si pregunta por promociones o ideas
        if (str_contains($lowerMessage, 'promoción') || str_contains($lowerMessage, 'promocion') || str_contains($lowerMessage, 'idea')) {
            return $this->generatePromotionSuggestions($insights, $store);
        }
        
        // Si pregunta por qué hacer
        if (str_contains($lowerMessage, 'qué puedo') || str_contains($lowerMessage, 'que puedo') || str_contains($lowerMessage, 'sugerencia')) {
            return $this->generateActionSuggestions($insights, $store);
        }
        
        // Respuesta general de sugerencias
        return $this->generateGeneralSuggestions($insights, $store);
    }

    /**
     * Generar sugerencias de promociones
     */
    protected function generatePromotionSuggestions(array $insights, Store $store): array
    {
        $seasonal = $insights['seasonal'] ?? [];
        $performance = $insights['performance'] ?? [];
        $topProduct = $performance['top_product'] ?? null;
        
        $message = "Ideas de promoción para {$store->name}:\n\n";
        
        // 1. Sugerencia estacional
        if (!empty($seasonal)) {
            $event = $seasonal[0];
            $message .= "1. Promoción de {$event['event']}\n";
            $message .= "   - Código: {$event['suggested_coupon']}\n";
            $message .= "   - Descuento sugerido: 15-20%\n\n";
        }
        
        // 2. Destacar producto estrella
        if ($topProduct) {
            $message .= "2. Destaca tu producto estrella\n";
            $message .= "   - '{$topProduct['name']}' es tu más vendido\n";
            $message .= "   - Créale un slider o descuento especial\n\n";
        }
        
        // 3. Sugerencia por horario
        $peakHour = $performance['peak_hour'] ?? null;
        if ($peakHour) {
            $message .= "3. Happy Hour\n";
            $message .= "   - Tu hora pico es {$peakHour['formatted']}\n";
            $message .= "   - Ofrece envío gratis de 6pm a 9pm\n\n";
        }
        
        // 4. Sugerencia general
        $message .= "4. Compra mínima con regalo\n";
        $message .= "   - Envío gratis en compras mayores a $X\n";
        
        return [
            'message' => trim($message),
            'actions' => [
                [
                    'type' => 'link',
                    'label' => 'Crear cupón',
                    'url' => route('tenant.admin.coupons.create', ['store' => $store->slug]),
                ],
                [
                    'type' => 'link',
                    'label' => 'Crear slider',
                    'url' => route('tenant.admin.sliders.create', ['store' => $store->slug]),
                ],
            ],
            'tokens_used' => 0,
        ];
    }

    /**
     * Generar sugerencias de acciones
     */
    protected function generateActionSuggestions(array $insights, Store $store): array
    {
        $alerts = $insights['alerts'] ?? [];
        $catalog = $insights['catalog'] ?? [];
        
        $message = "Cosas que puedes hacer ahora:\n\n";
        $actions = [];
        $count = 1;
        
        // Alertas prioritarias
        foreach (array_slice($alerts, 0, 2) as $alert) {
            if ($alert['priority'] === 'high') {
                $message .= "{$count}. {$alert['title']}\n";
                $message .= "   {$alert['message']}\n\n";
                $count++;
                
                if (isset($alert['action']['route'])) {
                    $actions[] = [
                        'type' => 'link',
                        'label' => $alert['action']['label'],
                        'url' => route($alert['action']['route'], ['store' => $store->slug]),
                    ];
                }
            }
        }
        
        // Optimizaciones de catálogo
        foreach (array_slice($catalog, 0, 2) as $opt) {
            $message .= "{$count}. {$opt['title']}\n";
            $message .= "   {$opt['message']}\n\n";
            $count++;
        }
        
        return [
            'message' => trim($message),
            'actions' => array_slice($actions, 0, 3),
            'tokens_used' => 0,
        ];
    }

    /**
     * Generar sugerencias generales
     */
    protected function generateGeneralSuggestions(array $insights, Store $store): array
    {
        $message = "Aquí tienes algunas sugerencias para mejorar:\n\n";
        $message .= "1. Revisa tu inventario regularmente\n";
        $message .= "2. Mantén fotos de calidad en tus productos\n";
        $message .= "3. Crea promociones para fechas especiales\n";
        $message .= "4. Responde rápido a los pedidos nuevos\n\n";
        $message .= "¿Quieres que te dé ideas más específicas sobre promociones, ventas o tu catálogo?";
        
        return [
            'message' => trim($message),
            'actions' => [],
            'tokens_used' => 0,
        ];
    }

    /**
     * Analizar intención del usuario
     */
    protected function analyzeIntent(string $message): string
    {
        $lowerMessage = strtolower($message);
        
        // Keywords para insights/datos de la tienda
        $insightsKeywords = [
            'cómo voy', 'como voy', 'cómo van', 'como van', 
            'mis ventas', 'cuánto he vendido', 'cuanto he vendido',
            'mi stock', 'mi inventario', 'productos agotados',
            'meta del mes', 'mi meta', 'mi objetivo',
            'resumen', 'estadísticas', 'métricas',
            'qué tal va', 'que tal va', 'estado de mi tienda'
        ];
        
        $educationalKeywords = ['cómo', 'como', 'pasos', 'guía', 'tutorial', 'enseñame', 'explicame', 'ayuda con', 'dónde está', 'donde esta', 'dónde encuentro', 'donde encuentro'];
        $suggestionKeywords = ['sugerencia', 'idea', 'recomendación', 'promoción', 'qué puedo', 'que puedo', 'sugiere', 'qué hago', 'que hago'];
        
        // Primero verificar insights (más específico)
        foreach ($insightsKeywords as $keyword) {
            if (str_contains($lowerMessage, $keyword)) {
                return 'insights';
            }
        }
        
        foreach ($suggestionKeywords as $keyword) {
            if (str_contains($lowerMessage, $keyword)) {
                return 'suggestion';
            }
        }
        
        foreach ($educationalKeywords as $keyword) {
            if (str_contains($lowerMessage, $keyword)) {
                return 'educational';
            }
        }
        
        return 'general';
    }

    /**
     * Buscar en base de conocimiento
     */
    protected function findInKnowledgeBase(string $message): ?array
    {
        $lowerMessage = strtolower($message);
        $knowledgeBase = $this->getKnowledgeBase();

        foreach ($knowledgeBase as $key => $knowledge) {
            foreach ($knowledge['keywords'] as $keyword) {
                if (str_contains($lowerMessage, strtolower($keyword))) {
                    return array_merge($knowledge, ['key' => $key]);
                }
            }
        }

        return null;
    }

    /**
     * Generar respuesta educativa
     */
    protected function generateEducationalResponse(string $message, array $knowledge, array $context, Store $store): array
    {
        // Intentar cargar documentación específica desde archivo .md (FUENTE ÚNICA DE VERDAD)
        $docContent = $this->loadDocumentation($knowledge['key'] ?? null);
        
        // Si hay documentación .md, usarla directamente sin OpenAI para mayor precisión
        if ($docContent) {
            $response = $this->formatDocumentationResponse($docContent, $message);
        } else {
            // Fallback: usar base de conocimiento + OpenAI (solo si no hay .md)
            $systemPrompt = $this->buildSystemPrompt($context, $store);
            
            $userPrompt = "El usuario pregunta: \"{$message}\"\n\n";
            $userPrompt .= "Información sobre {$knowledge['title']}:\n";
            $userPrompt .= "{$knowledge['description']}\n\n";
            
            if (isset($knowledge['steps']) && is_array($knowledge['steps'])) {
                $userPrompt .= "Pasos para usar esta funcionalidad:\n";
                foreach ($knowledge['steps'] as $step) {
                    $userPrompt .= "{$step}\n";
                }
            }
            
            $userPrompt .= "\nIMPORTANTE: Responde de manera CONCISA y PRECISA. ";
            $userPrompt .= "NO uses asteriscos (**) ni formato markdown. ";
            $userPrompt .= "Usa texto plano con saltos de línea. ";
            $userPrompt .= "Formatea los pasos numerados así: 1. Paso uno\n2. Paso dos\n3. Paso tres\n";
            $userPrompt .= "Máximo 150 palabras. ";
            $userPrompt .= "Sé directo y específico sobre los pasos exactos.";

            $openAIResponse = $this->callOpenAI($systemPrompt, $userPrompt);
            $response = [
                'message' => $this->cleanMarkdown($openAIResponse['message']),
                'tokens_used' => $openAIResponse['tokens_used'] ?? 0,
            ];
        }

        // Extraer acciones (enlaces) desde la base de conocimiento
        $actions = [];
        if (isset($knowledge['route'])) {
            $actions[] = [
                'type' => 'link',
                'label' => $knowledge['title'],
                'url' => route($knowledge['route'], ['store' => $store->slug]),
            ];
        }

        return [
            'message' => $response['message'],
            'actions' => $actions,
            'tokens_used' => $response['tokens_used'] ?? 0,
        ];
    }

    /**
     * Formatear respuesta desde documentación .md (FUENTE ÚNICA DE VERDAD)
     */
    protected function formatDocumentationResponse(string $docContent, string $userQuestion): array
    {
        // Extraer la sección relevante basada en la pregunta
        $lowerQuestion = strtolower($userQuestion);
        
        // Buscar sección "Cómo crear" o similar
        if (preg_match('/crear|crea|nuevo|nueva/i', $lowerQuestion)) {
            $section = $this->extractSection($docContent, 'crear');
        } elseif (preg_match('/editar|edita|modificar|modifica|actualizar|actualiza/i', $lowerQuestion)) {
            $section = $this->extractSection($docContent, 'editar');
        } else {
            // Usar la primera sección relevante
            $section = $this->extractSection($docContent, null);
        }
        
        if ($section) {
            // Formatear la respuesta con numeración automática
            $formatted = $this->formatStepsWithNumbers($section);
            return [
                'message' => $formatted,
                'tokens_used' => 0, // No se usó OpenAI, respuesta directa del .md
            ];
        }
        
        // Si no se encuentra sección específica, usar todo el contenido
        return [
            'message' => $this->formatStepsWithNumbers($docContent),
            'tokens_used' => 0,
        ];
    }

    /**
     * Extraer sección específica del documento
     */
    protected function extractSection(string $content, ?string $type): ?string
    {
        if ($type === 'crear') {
            if (preg_match('/## Cómo crear[^#]*(?=##|$)/s', $content, $matches)) {
                return $matches[0];
            }
            if (preg_match('/## Crear[^#]*(?=##|$)/s', $content, $matches)) {
                return $matches[0];
            }
        } elseif ($type === 'editar') {
            if (preg_match('/## Cómo editar[^#]*(?=##|$)/s', $content, $matches)) {
                return $matches[0];
            }
            if (preg_match('/## Editar[^#]*(?=##|$)/s', $content, $matches)) {
                return $matches[0];
            }
        }
        
        // Si no hay tipo específico, devolver la primera sección con pasos
        if (preg_match('/##[^#]+(?:\n(?:[^#]|\d+\.)[^#]*)*(?=##|$)/s', $content, $matches)) {
            return $matches[0];
        }
        
        return null;
    }

    /**
     * Formatear pasos con numeración automática desde .md
     */
    protected function formatStepsWithNumbers(string $content): string
    {
        // Remover headers markdown (##, ###, etc.) pero mantener el texto
        $content = preg_replace('/^#+\s+/m', '', $content);
        
        // Remover "Para crear..." o similar del inicio, pero mantener el resto
        $content = preg_replace('/^Para[^:]+:\s*/i', '', $content);
        
        // Dividir en líneas
        $lines = explode("\n", $content);
        $formatted = [];
        $inSubList = false;
        
        foreach ($lines as $line) {
            $originalLine = $line;
            $trimmedLine = trim($line);
            
            // Línea vacía
            if (empty($trimmedLine)) {
                if (!$inSubList) {
                    $formatted[] = '';
                }
                $inSubList = false;
                continue;
            }
            
            // Si la línea ya tiene numeración (1., 2., etc.), PRESERVARLA EXACTAMENTE
            if (preg_match('/^(\d+)\.\s+(.+)$/', $trimmedLine, $matches)) {
                $formatted[] = "{$matches[1]}. {$matches[2]}";
                $inSubList = false;
            }
            // Si es un guion o asterisco al inicio (lista), convertir a número
            elseif (preg_match('/^[-*]\s+(.+)$/', $trimmedLine, $matches)) {
                // Contar cuántos pasos numerados ya hay para continuar la numeración
                $currentNumber = count(array_filter($formatted, function($item) {
                    return preg_match('/^\d+\.\s+/', trim($item));
                })) + 1;
                $formatted[] = "{$currentNumber}. {$matches[1]}";
                $inSubList = false;
            }
            // Si es una sublista (guion con indentación) - mantener como sublista
            elseif (preg_match('/^\s{2,}[-*]\s+(.+)$/', $originalLine, $matches)) {
                $formatted[] = "   - {$matches[1]}";
                $inSubList = true;
            }
            // Si empieza con texto que parece un paso (sin numeración previa)
            elseif (preg_match('/^(En el|Ve a|Haz clic|Selecciona|Completa|Guarda|Ingresa|Sube|Agrega|Establece|Activa|Modifica)/i', $trimmedLine)) {
                $currentNumber = count(array_filter($formatted, function($item) {
                    return preg_match('/^\d+\.\s+/', trim($item));
                })) + 1;
                $formatted[] = "{$currentNumber}. {$trimmedLine}";
                $inSubList = false;
            }
            // Si es "Nota:" o información adicional, mantenerla sin numerar
            elseif (preg_match('/^(Nota|Importante|Recuerda|Tip):/i', $trimmedLine)) {
                $formatted[] = "\n{$trimmedLine}";
                $inSubList = false;
            }
            // Texto normal (continuación de un paso o información)
            else {
                // Si está dentro de una sublista, mantener indentación
                if ($inSubList) {
                    $formatted[] = "   {$trimmedLine}";
                } else {
                    // Si el último elemento es un paso numerado, agregar como continuación
                    $lastItem = end($formatted);
                    if ($lastItem && preg_match('/^\d+\.\s+/', trim($lastItem))) {
                        $formatted[count($formatted) - 1] .= " {$trimmedLine}";
                    } else {
                        $formatted[] = $trimmedLine;
                    }
                }
            }
        }
        
        $result = implode("\n", $formatted);
        
        // Limpiar líneas vacías múltiples (máximo 2 seguidas)
        $result = preg_replace('/\n{3,}/', "\n\n", $result);
        
        // Limpiar espacios al inicio y final
        return trim($result);
    }

    /**
     * Cargar documentación desde archivo .md
     */
    protected function loadDocumentation(?string $key): ?string
    {
        if (!$key) {
            return null;
        }

        $docPath = base_path("docs/assistant/{$key}.md");
        
        if (file_exists($docPath)) {
            return file_get_contents($docPath);
        }

        return null;
    }

    /**
     * Limpiar markdown de la respuesta
     */
    protected function cleanMarkdown(string $text): string
    {
        // Remover asteriscos de negrita
        $text = preg_replace('/\*\*(.*?)\*\*/', '$1', $text);
        // Remover asteriscos simples
        $text = preg_replace('/\*(.*?)\*/', '$1', $text);
        // Remover guiones de lista markdown
        $text = preg_replace('/^[\s]*[-*+]\s+/m', '', $text);
        // Remover numeración markdown
        $text = preg_replace('/^\d+\.\s+/m', '', $text);
        // Limpiar espacios múltiples
        $text = preg_replace('/\n{3,}/', "\n\n", $text);
        
        return trim($text);
    }

    /**
     * Generar respuesta general
     */
    protected function generateGeneralResponse(string $message, array $context, Store $store): array
    {
        $systemPrompt = $this->buildSystemPrompt($context, $store);
        
        $userPrompt = "El usuario pregunta: \"{$message}\"\n\n";
        $userPrompt .= "Responde de manera útil y amigable. Si la pregunta es sobre cómo hacer algo en Linkiu, ";
        $userPrompt .= "proporciona pasos claros. Si es una pregunta general, responde de manera concisa. ";
        $userPrompt .= "NO uses asteriscos (**) ni formato markdown. Usa texto plano. Máximo 150 palabras.";

        $response = $this->callOpenAI($systemPrompt, $userPrompt);

        // Limpiar markdown
        $cleanMessage = $this->cleanMarkdown($response['message']);

        return [
            'message' => $cleanMessage,
            'actions' => [],
            'tokens_used' => $response['tokens_used'] ?? 0,
        ];
    }

    /**
     * Construir prompt del sistema
     */
    protected function buildSystemPrompt(array $context, Store $store): string
    {
        $vertical = $store->vertical ?? 'ecommerce';
        $verticalName = match($vertical) {
            'restaurant' => 'restaurante',
            'hotel' => 'hotel',
            'dropshipping' => 'dropshipping',
            default => 'ecommerce',
        };

        return "Eres KiuBot, un asistente virtual experto en Linkiu, una plataforma para crear tiendas online.

Tu objetivo es ayudar a los administradores de tiendas a:
1. Aprender a usar todas las funcionalidades de la plataforma
2. Entender cómo funciona cada sección del menú lateral
3. Resolver dudas sobre el uso de la plataforma

Contexto de la tienda:
- Nombre: {$store->name}
- Tipo de negocio: {$verticalName}
- Plan: {$context['store']['plan']}

REGLAS IMPORTANTES:
- Responde SIEMPRE en español de Colombia
- NO uses asteriscos (**) ni formato markdown
- Usa texto plano con saltos de línea
- Sé CONCISO: máximo 150 palabras
- Proporciona pasos EXACTOS y PRECISOS
- Menciona dónde encontrar la opción en el menú lateral
- Si hay documentación específica, úsala como referencia exacta

Funcionalidades disponibles en el menú lateral:
- Dashboard: Panel principal con estadísticas
- Pedidos: Gestión de pedidos y ventas
- Categorías: Organización de productos
- Variables: Tallas, colores, etc. para productos
- Productos: Gestión de catálogo
- Inventario: Control de stock
- Gestión de Envíos: Zonas y costos de entrega
- Métodos de Pago: Configuración de pagos
- Sedes: Ubicaciones físicas
- Diseño de la Tienda: Personalización visual
- Cupones: Descuentos y promociones
- Slider: Carrusel de imágenes
- Soporte y Tickets: Ayuda del equipo
- Anuncios: Novedades de Linkiu";
    }

    /**
     * Construir contexto de la tienda
     */
    protected function buildStoreContext(Store $store): array
    {
        $store->load('plan');
        
        return [
            'store' => [
                'name' => $store->name,
                'vertical' => $store->vertical ?? 'ecommerce',
                'plan' => $store->plan->name ?? 'N/A',
            ],
            'stats' => [
                'total_products' => $store->products()->count(),
                'total_categories' => $store->categories()->count(),
                'total_orders' => $store->orders()->count(),
            ],
        ];
    }

    /**
     * Llamar a OpenAI
     */
    protected function callOpenAI(string $systemPrompt, string $userPrompt): array
    {
        try {
            $response = $this->client->chat()->create([
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemPrompt
                    ],
                    [
                        'role' => 'user',
                        'content' => $userPrompt
                    ]
                ],
                'max_tokens' => 300,
                'temperature' => 0.5,
            ]);

            $message = is_object($response) 
                ? $response->choices[0]->message->content 
                : $response['choices'][0]['message']['content'];

            $tokensUsed = is_object($response)
                ? ($response->usage->totalTokens ?? 0)
                : ($response['usage']['total_tokens'] ?? 0);

            return [
                'message' => trim($message),
                'tokens_used' => $tokensUsed,
            ];

        } catch (\Exception $e) {
            Log::error('KiuBotAssistant: Error llamando a OpenAI', [
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}

