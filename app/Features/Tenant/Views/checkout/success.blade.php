@extends('frontend.layouts.app')

{{-- ===================  STYLES  =================== --}}
@push('styles')
    <style>
        @keyframes check {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        .animate-check {
            animation: check 0.5s ease-out;
        }
    </style>
@endpush

{{-- ===================  JS & PUSHER  =================== --}}
@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Pusher para notificaciones en tiempo real -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        function bannerSlider() {
            return {
                currentIndex: 1, // Empezar en 1 porque el primero (0) es el duplicado
                totalSlides: 2, // Número real de slides
                isTransitioning: true,
                displayIndex: 0, // Índice mostrado al usuario (0 o 1)

                init() {
                    // Cambiar slide automáticamente cada 5 segundos
                    this.interval = setInterval(() => {
                        this.nextSlide();
                    }, 5000);
                },

                nextSlide() {
                    this.isTransitioning = true;
                    this.currentIndex++;
                    this.displayIndex = ((this.currentIndex - 1) % this.totalSlides);
                },

                goToSlide(slideIndex) {
                    // Ir al slide real (sumamos 1 porque el índice 0 es el duplicado)
                    this.isTransitioning = true;
                    this.currentIndex = slideIndex + 1;
                    this.displayIndex = slideIndex;
                    // Reiniciar el intervalo
                    clearInterval(this.interval);
                    this.interval = setInterval(() => {
                        this.nextSlide();
                    }, 5000);
                },

                handleTransitionEnd() {
                    // Si llegamos al final (último duplicado), saltar al inicio sin transición
                    if (this.currentIndex === this.totalSlides + 1) {
                        this.isTransitioning = false;
                        this.currentIndex = 1;
                    }
                    // Si estamos en el duplicado del inicio (índice 0), saltar al final sin transición
                    else if (this.currentIndex === 0) {
                        this.isTransitioning = false;
                        this.currentIndex = this.totalSlides;
                    }
                }
            };
        }
    </script>
@endpush

{{-- ===================  CONTENT (HTML)  =================== --}}
@section('content')
    <div class="max-w-2xl mx-auto px-4 py-6 space-y-6 relative z-0" data-order-id="{{ $order->id }}">
        <!-- Slider de banners -->
        <div class="relative overflow-hidden rounded-lg" x-data="bannerSlider()">
            <div class="flex"
                 :style="'transform: translateX(-' + currentIndex * 100 + '%); transition: ' + (isTransitioning ? 'transform 0.5s ease-in-out' : 'none') + ';'"
                 @transitionend="handleTransitionEnd()">

                <!-- Duplicar último slide al inicio para efecto infinito -->
                <a href="https://wa.me/573104594344?text=Quiero%20ser%20parte%20de%20Linkiu" target="_blank" rel="noopener" class="flex-shrink-0 w-full flex items-center justify-center relative">
                    <img src="{{ asset('images-ui/banner_info_succces_linkiu_02.svg') }}" alt="Banner 2" class="w-full">
                </a>
                <!-- Slides originales -->
                <a href="https://wa.me/573104594344?text=Quiero%20ser%20parte%20de%20Linkiu" target="_blank" rel="noopener" class="flex-shrink-0 w-full flex items-center justify-center relative">
                    <img src="{{ asset('images-ui/banner_info_succces_linkiu_01.svg') }}" alt="Banner 1" class="w-full">
                </a>
                <a href="https://wa.me/573104594344?text=Quiero%20ser%20parte%20de%20Linkiu" target="_blank" rel="noopener" class="flex-shrink-0 w-full flex items-center justify-center relative">
                    <img src="{{ asset('images-ui/banner_info_succces_linkiu_02.svg') }}" alt="Banner 2" class="w-full">
                </a>
                <!-- Duplicar primer slide al final para efecto infinito -->
                <a href="https://wa.me/573104594344?text=Quiero%20ser%20parte%20de%20Linkiu" target="_blank" rel="noopener" class="flex-shrink-0 w-full flex items-center justify-center relative">
                    <img src="{{ asset('images-ui/banner_info_succces_linkiu_01.svg') }}" alt="Banner 1" class="w-full">
                </a>
            </div>

            <!-- Indicadores de posición -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2">
                <button @click="goToSlide(0)"
                        :class="displayIndex === 0 ? 'bg-white' : 'bg-white/50'"
                        class="w-2 h-2 rounded-full transition-all"></button>
                <button @click="goToSlide(1)"
                        :class="displayIndex === 1 ? 'bg-white' : 'bg-white/50'"
                        class="w-2 h-2 rounded-full transition-all"></button>
            </div>
        </div>

        <div class="relative">
            <!-- Borde serrado superior tipo factura -->
            <div class="relative h-4">
                <svg class="absolute top-0 left-0 w-full h-full" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 400 12">
                    <path d="M0,0 L0,6 L10,0 L20,6 L30,0 L40,6 L50,0 L60,6 L70,0 L80,6 L90,0 L100,6 L110,0 L120,6 L130,0 L140,6 L150,0 L160,6 L170,0 L180,6 L190,0 L200,6 L210,0 L220,6 L230,0 L240,6 L250,0 L260,6 L270,0 L280,6 L290,0 L300,6 L310,0 L320,6 L330,0 L340,6 L350,0 L360,6 L370,0 L380,6 L390,0 L400,6 L400,12 L0,12 Z" fill="white"/>
                </svg>
            </div>
            <!-- Estado del pedido y detalles tipo factura -->
            <div class="bg-white">
                <div class="px-4 pb-4">
                    <!-- Código de pedido destacado -->
                    <div class="flex items-center justify-center w-full pt-6 pb-4">
                        <div class="flex bg-green-100 rounded-full relative items-center justify-center py-2 px-4 mx-auto gap-4">
                            <p class="text-lg font-bold text-green-900 tracking-wider" id="order-code">{{ $order->order_number ?? 'N/A' }}</p>
                            <button onclick="copyOrderCode()" class="bg-slate-900 text-white hover:bg-slate-800 px-3 py-2 rounded-full transition-colors">
                                Copiar
                            </button>
                        </div>
                    </div>

                    <!-- Header dinámico según método de envío -->
                    <div class="text-center pb-4">
                        @if(($order->delivery_type ?? '') === 'domicilio')
                            <h1 class="text-lg font-bold text-slate-950">¡Tu pedido viene en camino!</h1>
                        @else
                            <h1 class="text-lg font-bold text-slate-950">¡Tu pedido está listo!</h1>
                        @endif
                    </div>

                    <!-- Estado del pedido en tiempo real (Stepper horizontal) -->
                    <div class="py-4">
                        <div id="order-status-tracker" class="w-full">
                            <!-- Los estados se cargan dinámicamente -->
                            <div class="text-center py-4">
                                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500 mx-auto"></div>
                                <p class="text-sm text-gray-600 mt-2">Cargando estado...</p>
                            </div>
                        </div>
                        <!-- Texto dinámico del estado actual -->
                        <div id="order-status-text" class="text-center mt-4">
                            <p class="text-base font-bold text-slate-900"></p>
                        </div>
                    </div>

                    <!-- Detalles del pedido -->
                    <div class="border-t border-gray-200 pt-4">
                        <h3 class="text-base font-bold text-gray-900 pb-4">
                            Detalles del pedido
                        </h3>
                        <div class="space-y-4 px-4 pt-4">
                            <!-- Información del cliente -->
                            <h4 class="text-sm font-semibold text-gray-900 mb-3">Información del Cliente</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm font-normal text-gray-600">Nombre:</span>
                                    <span class="text-sm font-normal text-gray-900">{{ $order->customer_name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm font-normal text-gray-600">Teléfono:</span>
                                    <span class="text-sm font-normal text-gray-900">{{ $order->customer_phone ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <!-- Información de entrega -->
                            <h4 class="text-sm font-semibold text-gray-900 mb-3">
                                @if(($order->delivery_type ?? '') === 'domicilio')
                                    Información de Envío
                                @else
                                    Información de Recogida
                                @endif
                            </h4>
                            <div class="space-y-2">
                                @if(($order->delivery_type ?? '') === 'domicilio')
                                    <div class="flex justify-between">
                                        <span class="text-sm font-normal text-gray-600">Dirección:</span>
                                        <span class="text-sm font-normal text-gray-900 text-right">{{ $order->customer_address ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-normal text-gray-600">Ciudad:</span>
                                        <span class="text-sm font-normal text-gray-900">{{ $order->city ?? 'N/A' }}</span>
                                    </div>
                                @else
                                    <div class="flex justify-between">
                                        <span class="text-sm font-normal text-gray-600">Dirección tienda:</span>
                                        <span class="text-sm font-normal text-gray-900 text-right">{{ $store->address ?? 'Ver en Google Maps' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-normal text-gray-600">Horario:</span>
                                        <span class="text-sm font-normal text-gray-900">{{ $store->schedule ?? 'Lun-Vie 9am-6pm' }}</span>
                                    </div>
                                @endif
                            </div>
                            <!-- Resumen de pago -->
                            <h4 class="text-sm font-semibold text-gray-900 mb-3">Resumen de Pago</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm font-normal text-gray-600">Método:</span>
                                    <span class="text-sm font-normal text-gray-900">
                                        @if(($order->payment_method ?? '') === 'efectivo' || ($order->payment_method ?? '') === 'cash')
                                            Efectivo
                                        @elseif(($order->payment_method ?? '') === 'transferencia' || ($order->payment_method ?? '') === 'bank_transfer')
                                            Transferencia
                                        @elseif(($order->payment_method ?? '') === 'contra_entrega')
                                            Contra Entrega
                                        @elseif(($order->payment_method ?? '') === 'card_terminal')
                                            Terminal de Pago
                                        @else
                                            {{ ucfirst(str_replace('_', ' ', $order->payment_method ?? 'N/A')) }}
                                        @endif
                                    </span>
                                </div>
                                @if((($order->payment_method ?? '') === 'efectivo' || ($order->payment_method ?? '') === 'cash') && isset($order->cash_amount))
                                    <div class="flex justify-between">
                                        <span class="text-sm font-normal text-gray-600">Pagas con:</span>
                                        <span class="text-sm font-normal text-gray-900">${{ number_format($order->cash_amount, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-normal text-gray-600">Tu cambio:</span>
                                        <span class="text-sm font-normal text-gray-900">${{ number_format($order->cash_amount - $order->total, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                                <div class="border-t border-accent-200 pt-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-normal text-gray-600">Total:</span>
                                        <span class="text-sm font-bold text-gray-900">${{ number_format($order->total ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- border serrado inferior-->
            <div class="relative h-4">
                <svg class="absolute bottom-0 left-0 w-full h-full" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 400 12">
                    <path d="M0,12 L0,6 L10,12 L20,6 L30,12 L40,6 L50,12 L60,6 L70,12 L80,6 L90,12 L100,6 L110,12 L120,6 L130,12 L140,6 L150,12 L160,6 L170,12 L180,6 L190,12 L200,6 L210,12 L220,6 L230,12 L240,6 L250,12 L260,6 L270,12 L280,6 L290,12 L300,6 L310,12 L320,6 L330,12 L340,6 L350,12 L360,6 L370,12 L380,6 L390,12 L400,6 L400,0 L0,0 Z" fill="white"/>
                </svg>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Acciones de compartir -->
            <div class="flex justify-between bg-gray-50 rounded-xl p-4 border border-gray-200">
                <div class="flex justify-between gap-4 w-full">
                    <button onclick="refreshOrderStatus()" class="flex flex-col items-center justify-center bg-green-50 text-green-900 hover:text-green-50 p-4 rounded-xl hover:bg-green-600 transition-colors cursor-pointer">
                        <i data-lucide="refresh-cw" class="w-4 h-4 mb-2"></i>
                        <h3 class="text-sm font-semibold">Actualizar estado</h3>
                    </button>
                    <!-- Compartir con el negocio -->
                    <button onclick="shareWithBusiness()" class="flex flex-col items-center justify-center bg-blue-50 text-blue-900 hover:text-blue-50 p-4 rounded-xl hover:bg-blue-600 transition-colors cursor-pointer">
                        <i data-lucide="phone" class="w-4 h-4 mb-2"></i>
                        <h3 class="text-sm font-semibold">Llamar al negocio</h3>
                    </button>
                    <!-- Compartir con un amigo -->
                    <button onclick="shareWithFriend()" class="flex flex-col items-center justify-center bg-pink-50 text-pink-900 hover:text-pink-50 p-4 rounded-xl hover:bg-pink-600 transition-colors cursor-pointer">
                        <i data-lucide="heart" class="w-4 h-4 mb-2"></i>
                        <h3 class="text-sm font-semibold">Enviar a un amigo</h3>
                    </button>
                </div>
            </div>
            <!-- Acciones principales -->
            <div class="flex justify-center">
                <a href="{{ route('tenant.home', $store->slug) }}"
                    class="flex gap-2 items-center justify-center w-full bg-purple-600 text-white py-2 px-4 rounded-xl hover:bg-purple-700 transition-colors cursor-pointer">
                    <i data-lucide="shopping-cart" class="w-6 h-6 mb-2"></i>
                    <h3 class="text-md font-semibold">Continuar comprando</h3>
                </a>
            </div>
        </div>
    </div>
@endsection

{{-- ===================  SCRIPTS FINALES (FUNCIONALIDAD)  =================== --}}
@push('scripts')
<script>
const ORDER_ID = {{ $order->id ?? 'null' }};
const STORE_SLUG = '{{ $store->slug ?? '' }}';
const STORE_PHONE = '{{ $store->phone ?? '' }}';
const CUSTOMER_PHONE = '{{ $order->customer_phone ?? '' }}';
const DELIVERY_TYPE = '{{ $order->delivery_type ?? 'domicilio' }}';

// Cargar estado del pedido al iniciar
document.addEventListener('DOMContentLoaded', function() {
    loadOrderStatus();

    // ✅ RESETEAR CARRITO DESPUÉS DE PEDIDO COMPLETADO
    resetCartAfterOrder();

    // 🎉 CONFETTI DE CELEBRACIÓN - Solo en primera carga
    if (!sessionStorage.getItem('order_confetti_shown_{{ $order->id }}')) {
        if (typeof window.confetti === 'function') {
            setTimeout(() => {
                // Confetti sutil desde arriba
                window.confetti({
                    particleCount: 80,
                    spread: 70,
                    origin: { y: 0.4 },
                    colors: ['#da27a7', '#0000fe', '#00c76f', '#e8e6fb'],
                    startVelocity: 25,
                    ticks: 50,
                    gravity: 0.8
                });

                // Segundo burst más pequeño
                setTimeout(() => {
                    window.confetti({
                        particleCount: 40,
                        spread: 50,
                        origin: { y: 0.4 },
                        colors: ['#da27a7', '#0000fe', '#00c76f', '#e8e6fb'],
                        startVelocity: 20,
                        ticks: 40
                    });
                }, 250);
            }, 300);

            // Marcar que ya se mostró
            sessionStorage.setItem('order_confetti_shown_{{ $order->id }}', 'true');
        }
    }

    // 🔔 INICIALIZAR PUSHER PARA ESCUCHAR CAMBIOS EN TIEMPO REAL
    initRealtimeNotifications();

    // Actualizar cada 30 segundos (backup por si Pusher falla)
    setInterval(loadOrderStatus, 30000);
});

// Función para resetear el carrito después de completar el pedido
function resetCartAfterOrder() {
    try {
        // Si existe la función global clearCart (del cart.js)
        if (typeof window.clearCart === 'function') {
            window.clearCart();
            console.log('🛒 Carrito reseteado después del pedido');
        }

        // También limpiar localStorage por si acaso
        localStorage.removeItem('cart_items');
        localStorage.removeItem('cart_count');

        // Limpiar sessionStorage
        sessionStorage.removeItem('cart_data');

    } catch (error) {
        console.error('Error reseteando carrito:', error);
    }
}

// Cargar estado del pedido
async function loadOrderStatus() {
    if (!ORDER_ID) return;

    try {
        const response = await fetch(`/${STORE_SLUG}/checkout/api/order-status?id=${ORDER_ID}`);
        const data = await response.json();

        if (data.success) {
            renderOrderStatus(data.order);
        }
    } catch (error) {
        console.error('Error cargando estado:', error);
    }
}

// Mapear estados de inglés (BD) a español (frontend)
function mapOrderStatus(dbStatus) {
    const statusMap = {
        'pending': 'pendiente',
        'confirmed': 'confirmado',
        'preparing': 'en_preparacion',
        'ready': 'listo',
        'shipped': 'en_camino',
        'delivered': 'entregado'
    };
    return statusMap[dbStatus] || dbStatus;
}

// Renderizar estado del pedido
function renderOrderStatus(order) {
    const container = document.getElementById('order-status-tracker');
    const statusTextContainer = document.getElementById('order-status-text');

    // Mapear el estado de la BD al español
    let currentStatus = mapOrderStatus(order.status);

    // Si el estado es "listo", lo tratamos como "en_preparacion" completado
    // y el siguiente paso activo será "en_camino"
    if (currentStatus === 'listo') {
        currentStatus = 'en_preparacion';
    }

    console.log('🔄 Estado actualizado:', {
        original: order.status,
        mapped: currentStatus,
        order: order
    });

    // Determinar textos según tipo de envío
    const isDelivery = DELIVERY_TYPE === 'domicilio';
    const enCaminoText = isDelivery
        ? 'Tu pedido está en camino a tu dirección'
        : 'Tu pedido está listo para recoger';
    const entregadoText = isDelivery
        ? '¡Tu pedido ha sido entregado!'
        : '¡Tu pedido ha sido recogido!';

    const statusSteps = [
        {
            key: 'pendiente',
            label: 'Pedido Recibido',
            description: 'Tu pedido ha sido registrado',
            activeText: 'Tu pedido ha sido recibido',
            icon: 'circle'
        },
        {
            key: 'confirmado',
            label: 'Confirmado',
            description: 'Confirmamos tu pedido',
            activeText: 'Tu pedido ha sido confirmado',
            icon: 'circle'
        },
        {
            key: 'en_preparacion',
            label: 'En Preparación',
            description: 'Preparamos tu pedido',
            activeText: 'Tu pedido está en preparación',
            icon: 'circle'
        },
        {
            key: 'en_camino',
            label: isDelivery ? 'En Camino' : 'Listo',
            description: isDelivery ? 'Camino a tu dirección' : 'Listo para recoger',
            activeText: enCaminoText,
            icon: 'circle'
        },
        {
            key: 'entregado',
            label: 'Entregado',
            description: '¡Disfruta tu pedido!',
            activeText: entregadoText,
            icon: 'circle'
        }
    ];

    // Obtener el orden numérico del estado actual
    const originalStatusOrder = getStatusOrder(mapOrderStatus(order.status));

    // Encontrar el paso activo y su texto
    const activeStep = statusSteps.find(step => {
        return currentStatus === step.key || (order.status === 'ready' && step.key === 'en_camino');
    });

    // Actualizar texto del estado actual
    if (activeStep && statusTextContainer) {
        statusTextContainer.querySelector('p').textContent = activeStep.activeText;
    }

    let html = `
        <!-- Stepper horizontal -->
        <div class="flex items-center justify-between relative md:px-4 p-0">
    `;

    statusSteps.forEach((step, index) => {
        const stepOrder = getStatusOrder(step.key);
        const isActive = currentStatus === step.key || (order.status === 'ready' && step.key === 'en_camino');
        const isCompleted = originalStatusOrder > stepOrder || (order.status === 'ready' && step.key === 'en_preparacion');
        const isLast = index === statusSteps.length - 1;

        // Determinar clases y contenido del círculo
        let circleContent = '';
        let circleClass = '';

        if (isCompleted) {
            // Paso completado: checkmark verde
            circleClass = 'bg-green-600 border-2 border-green-600 transition-all duration-300 hover:scale-110';
            circleContent = `
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            `;
        } else if (isActive) {
            // Paso activo: círculo blanco con borde verde y efecto pulse
            circleClass = 'bg-white border-2 border-green-500 transition-all duration-300 hover:scale-110 animate-pulse';
            // Icono general: círculo relleno verde visible
            circleContent = `
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#10b981">
                    <circle cx="12" cy="12" r="5"></circle>
                </svg>
            `;
        } else {
            // Paso pendiente: número gris con efecto hover
            circleClass = 'bg-gray-200 transition-all duration-300 hover:bg-gray-300 hover:scale-105';
            const pendingNumber = index + 1;
            circleContent = `<span class="text-gray-500 font-semibold text-sm">${pendingNumber}</span>`;
        }

        // Línea horizontal (excepto en el último paso)
        const lineClass = isCompleted ? 'bg-green-600' : 'bg-gray-300';

        html += `
            <div class="flex items-center ${isLast ? '' : 'flex-1'} cursor-pointer group" title="${step.description}">
                <div class="flex flex-col items-center flex-1">
                    <!-- Círculo del paso -->
                    <div class="w-10 h-10 ${circleClass} rounded-full flex items-center justify-center relative z-10">
                        ${circleContent}
                    </div>
                </div>
                ${!isLast ? `<div class="h-0.5 flex-1 ${lineClass} transition-colors duration-300"></div>` : ''}
            </div>
        `;
    });

    html += '</div>'; // Cerrar el contenedor del stepper
    container.innerHTML = html;
}

// Obtener orden numérico del estado
function getStatusOrder(status) {
    const order = {
        'pendiente': 1,
        'confirmado': 2,
        'en_preparacion': 3,
        'listo': 4, // Estado intermedio, se trata como en_preparacion completado
        'en_camino': 5,
        'entregado': 6
    };
    return order[status] || 0;
}

// Copiar código de pedido
function copyOrderCode() {
    const code = document.getElementById('order-code').textContent;

    navigator.clipboard.writeText(code).then(() => {
        alert('📋 Código copiado: ' + code);
    }).catch(() => {
        alert('Código del pedido: ' + code);
    });
}

// Compartir con el negocio via WhatsApp
function shareWithBusiness() {
    const orderNumber = '{{ $order->order_number ?? "N/A" }}';
    const customerName = '{{ $order->customer_name ?? "Cliente" }}';
    const total = '{{ $order->total ?? 0 }}';
    const storeName = '{{ $store->name ?? "Tienda" }}';

    let message = `🛍️ *Confirmación de Pedido*\n\n`;
    message += `👋 ¡Hola ${storeName}! Soy *${customerName}*\n\n`;
    message += `📋 *Pedido:* #${orderNumber}\n`;
    message += `💰 *Total:* $${formatPrice(total)}\n\n`;

    @if(($order->delivery_type ?? '') === 'domicilio')
        message += `🚚 *Tipo:* Domicilio\n`;
        message += `📍 *Dirección:* {{ $order->customer_address ?? 'N/A' }}\n`;
    @else
        message += `🏪 *Tipo:* Recogida en tienda\n`;
    @endif

    message += `📞 *Teléfono:* {{ $order->customer_phone ?? 'N/A' }}\n\n`;
    message += `¿Podrían confirmar que recibieron mi pedido? ¡Gracias! 😊`;

    const whatsappNumber = STORE_PHONE || '{{ $store->phone ?? "" }}';
    if (!whatsappNumber) {
        alert('Número de WhatsApp no configurado para esta tienda');
        return;
    }

    const url = `https://wa.me/${whatsappNumber.replace(/\D/g, '')}?text=${encodeURIComponent(message)}`;
    window.open(url, '_blank');
}

// Compartir con un amigo
function shareWithFriend() {
    const orderCode = document.getElementById('order-code').textContent;
    const message = `¡Acabo de hacer un pedido en {{ $store->name ?? 'esta tienda' }}! 🛍️\n\nCódigo: ${orderCode}\n\nRevisa sus productos: ${window.location.origin}/{{ $store->slug ?? '' }}`;

    if (CUSTOMER_PHONE) {
        const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(message)}`;
        window.open(whatsappUrl, '_blank');
    } else {
        // Copiar al portapapeles si no hay teléfono
        navigator.clipboard.writeText(message).then(() => {
            alert('📋 Mensaje copiado. Compártelo donde quieras!');
        }).catch(() => {
            alert('Mensaje para compartir:\n\n' + message);
        });
    }
}

// Actualizar estado manualmente
function refreshOrderStatus() {
    const button = event.target;
    const originalText = button.innerHTML;

    button.innerHTML = '<span class="mr-2">⏳</span>Actualizando...';
    button.disabled = true;

    loadOrderStatus().then(() => {
        setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        }, 1000);
    });
}

// 🔔 INICIALIZAR NOTIFICACIONES EN TIEMPO REAL CON PUSHER
function initRealtimeNotifications() {
    if (!ORDER_ID) {
        console.log('❌ No hay ORDER_ID, no se inicializa Pusher');
        return;
    }

    try {
        console.log('🔔 Inicializando Pusher para pedido:', ORDER_ID);

        // Inicializar Pusher
        const pusher = new Pusher('{{ config("broadcasting.connections.pusher.key") }}', {
            cluster: '{{ config("broadcasting.connections.pusher.options.cluster") }}',
            forceTLS: true
        });

        // Suscribirse al canal del pedido
        const orderChannel = pusher.subscribe(`order.${ORDER_ID}`);

        console.log('📡 Suscrito al canal: order.' + ORDER_ID);

        // Escuchar cambios de estado
        orderChannel.bind('status.changed', function(data) {
            console.log('🔔 ¡Estado del pedido cambió!', data);
            // Mostrar notificación visual
            showStatusChangeNotification(data);
            // Reproducir sonido
            playNotificationSound();
            // Actualizar el estado en la página
            loadOrderStatus();
        });

        console.log('✅ Pusher inicializado correctamente');
    } catch (error) {
        console.error('❌ Error inicializando Pusher:', error);
    }
}

// Mostrar notificación de cambio de estado
function showStatusChangeNotification(data) {
    // Crear toast
    const toast = document.createElement('div');
    toast.className = 'fixed top-4 right-4 bg-success-300 text-white px-6 py-4 rounded-lg shadow-lg z-[9999] max-w-md animate-slide-in';
    toast.innerHTML = `
        <div class="flex items-center gap-3">
            <span class="text-2xl">🔔</span>
            <div class="flex-1">
                <strong class="block mb-1">¡Estado actualizado!</strong>
                <span class="text-sm">${data.message}</span>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="text-white hover:text-accent-100">
                ✕
            </button>
        </div>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}

// Reproducir sonido de notificación
function playNotificationSound() {
    try {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();

        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);

        oscillator.frequency.value = 800;
        gainNode.gain.value = 0.1;

        oscillator.start();
        oscillator.stop(audioContext.currentTime + 0.1);
    } catch (e) {
        console.log('No se pudo reproducir sonido:', e);
    }
}
</script>
@endpush
