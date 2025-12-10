{{--
    Componente: KiuBot Floating Button
    
    Botón flotante con el icono de KiuBot que aparece cuando hay un tour disponible.
    Permite iniciar el tour manualmente después de la primera vez.
    
    Props:
    - tour: nombre del tour (requerido)
    - position: posición del botón (default: 'bottom-right')
--}}

@props([
    'tour' => null,
    'position' => 'bottom-right',
])

@php
    $tourService = app(\App\Services\TourService::class);
    $store = view()->shared('currentStore');
    
    // Si no se especifica tour, intentar detectarlo automáticamente desde la ruta
    if (!$tour && $store) {
        $routeName = request()->route()->getName();
        $tourMap = [
            'tenant.admin.dashboard' => 'dashboard_bienvenida',
            'tenant.admin.store-design.*' => 'diseño_tienda',
            'tenant.admin.categories.index' => 'gestionar_categorias',
            'tenant.admin.categories.create' => 'crear_categoria',
            'tenant.admin.variables.index' => 'gestionar_variables',
            'tenant.admin.variables.create' => 'crear_variable',
            'tenant.admin.products.index' => 'gestionar_productos',
            'tenant.admin.products.create' => 'crear_producto',
            'tenant.admin.inventario.index' => 'gestionar_inventario',
            'tenant.admin.simple-shipping.index' => 'configurar_envios',
            'tenant.admin.payment-methods.index' => 'gestionar_metodos_pago',
            'tenant.admin.payment-methods.create' => 'crear_metodo_pago',
            'tenant.admin.locations.index' => 'gestionar_sedes',
            'tenant.admin.locations.create' => 'crear_sede',
            'tenant.admin.coupons.index' => 'gestionar_cupones',
            'tenant.admin.sliders.index' => 'gestionar_sliders',
            'tenant.admin.whatsapp-notifications.*' => 'notificaciones_whatsapp',
            'tenant.admin.coupons.create' => 'crear_cupon',
            'tenant.admin.sliders.create' => 'crear_slider',
        ];
        
        foreach ($tourMap as $pattern => $tourName) {
            if (request()->routeIs($pattern)) {
                $tour = $tourName;
                break;
            }
        }
    }
    
    // El botón debe aparecer siempre si hay un tour disponible para esta ruta
    // (incluso si ya fue completado, para permitir reiniciarlo manualmente)
    $shouldShow = $tour && $store ? true : false;
@endphp

@if($shouldShow)
{{-- Script inline para definir la función antes de que Alpine la necesite --}}
<script>
    (function() {
        // Definir la función globalmente inmediatamente
        if (typeof window.kiubotFloatingButton === 'undefined') {
            window.kiubotFloatingButton = function(tourName) {
                return {
                    tourName: tourName,
                    
                    toursReady: false,
                    
                    init() {
                        // Escuchar el evento cuando el sistema de tours esté listo
                        window.addEventListener('linkiu-tours-ready', () => {
                            this.toursReady = true;
                        });
                        
                        // También verificar si ya está disponible
                        if (window.LinkiuTours && typeof window.LinkiuTours.start === 'function') {
                            this.toursReady = true;
                        }
                    },
                    
                    startTour() {
                        // Validar que tenemos un tourName
                        if (!this.tourName) {
                            alert('Error: No se pudo identificar el tour. Por favor, recarga la página.');
                            return;
                        }
                        
                        // Función auxiliar para intentar iniciar el tour
                        const tryStartTour = () => {
                            // Intentar con LinkiuTours primero
                            if (window.LinkiuTours && typeof window.LinkiuTours.start === 'function') {
                                try {
                                    window.LinkiuTours.start(this.tourName, true);
                                    return true;
                                } catch (error) {
                                    // manejar error silenciosamente
                                }
                            }
                            
                            // Fallback a window.startTour
                            if (window.startTour && typeof window.startTour === 'function') {
                                try {
                                    window.startTour(this.tourName, true);
                                    return true;
                                } catch (error) {
                                    // manejar error silenciosamente
                                }
                            }
                            
                            return false;
                        };
                        
                        // Intentar iniciar inmediatamente
                        if (tryStartTour.call(this)) {
                            return;
                        }
                        
                        // Si no está disponible, esperar un poco y reintentar
                        let attempts = 0;
                        const maxAttempts = 50; // 5 segundos máximo
                        
                        const retryInterval = setInterval(() => {
                            attempts++;
                            
                            if (tryStartTour.call(this)) {
                                clearInterval(retryInterval);
                                return;
                            }
                            
                            if (attempts >= maxAttempts) {
                                clearInterval(retryInterval);
                                alert('El sistema de tours aún no está listo. Por favor, recarga la página e intenta de nuevo.');
                            }
                        }, 100);
                    }
                };
            };
            
            // Registrar en Alpine si está disponible
            if (window.Alpine) {
                Alpine.data('kiubotFloatingButton', window.kiubotFloatingButton);
            } else {
                // Esperar a que Alpine esté listo
                document.addEventListener('alpine:init', () => {
                    Alpine.data('kiubotFloatingButton', window.kiubotFloatingButton);
                });
            }
        }
    })();
</script>

<div 
    x-data="kiubotFloatingButton('{{ $tour }}')"
    class="fixed {{ $position === 'bottom-right' ? 'bottom-2 right-6' : 'bottom-2 left-6' }} z-[9999]"
    x-cloak
>
    {{-- Burbuja te muestro cómo se hace --}}
    <button 
        type="button"
        @click="startTour()"
        class="fixed z-10 bottom-28 right-8"
    >
        <div class="relative animate-bounce animate-duration-[1000ms] animate-delay-[5000ms] bg-gradient-to-br from-gray-100 to-gray-200 text-black text-sm font-medium px-2 py-2.5 rounded-2xl shadow-xl rounded-br-sm">
            <span>¿Te muestro cómo se hace? 🤖</span>
        </div>
    </button>

    {{-- Emoji KiuBot --}}
    <div class="relative flex items-center justify-center transition-all duration-300 cursor-pointer">
        {{-- Emoji KiuBot --}}
        <img 
            src="{{ asset('images-ui/emoji_kiubot_linkiu.svg') }}"
            alt="Emoji KiuBot"
            class="w-20 h-20 drop-shadow-lg transition-all duration-300 animate-bounce animate-duration-[2000ms]"
            style="filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));"
        />
    </div>
</div>

@endif

