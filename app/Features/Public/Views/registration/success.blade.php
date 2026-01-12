<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>¡Registro Completado! - Linkiu</title>
    
    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('images-ui/favico_linkiu.svg') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <!-- Calendly Script -->
    <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen" x-data="{ calendlyOpen: false }">
    
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-6xl w-full">
            
            {{-- Header con Icono --}}
            <div class="text-center mb-6 mt-4 md:mt-0">
                <h1 class="text-lg md:text-2xl font-bold text-slate-900 mb-2">¡Registro Completado con Éxito!</h1>
                <p class="text-base md:text-lg text-slate-600">Tu tienda está lista para comenzar</p>
            </div>

            {{-- Grid Principal - Dos Columnas --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                {{-- Columna Izquierda: Resumen de Orden --}}
                <div class="space-y-6">
                    
                    {{-- Resumen de Suscripción --}}
                    <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-200 overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-200">
                                <div class="w-10 h-10 bg-accent-300/10 rounded-xl flex items-center justify-center">
                                    <i data-lucide="receipt" class="w-5 h-5 text-accent-300"></i>
                                </div>
                                <h3 class="text-base font-bold text-slate-900">Resumen de tu Suscripción</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="text-xs text-slate-500 block mb-1">Tienda</span>
                                        <p class="text-sm font-semibold text-slate-900">{{ $store->name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs text-slate-500 block mb-1">Plan</span>
                                        <p class="text-sm font-semibold text-slate-900">{{ $subscription->plan->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $subscription->billing_cycle_label }}</p>
                                    </div>
                                </div>
                                
                                <div class="pt-4 border-t border-gray-200">
                                    @if($subscription->trial_end && $subscription->trial_end->isFuture())
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-slate-600">Período de prueba</span>
                                        <div class="text-right">
                                            <p class="text-sm font-semibold text-slate-900">
                                                Hasta {{ $subscription->trial_end->locale('es')->isoFormat('D MMM YYYY') }}
                                            </p>
                                            <p class="text-xs text-slate-500">
                                                {{ (int) now()->diffInDays($subscription->trial_end) }} días restantes
                                            </p>
                                        </div>
                                    </div>
                                    @else
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-slate-600">Válido hasta</span>
                                        <p class="text-sm font-semibold text-slate-900">
                                            {{ $subscription->current_period_end->locale('es')->isoFormat('D MMM YYYY') }}
                                        </p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Guía de acceso --}}
                    <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-200 overflow-hidden p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <i data-lucide="info" class="w-5 h-5 text-blue-600"></i>
                            <h3 class="text-base font-bold text-slate-900">¿Cómo acceder a tu tienda?</h3>
                        </div>
                        <ul class="space-y-2.5 text-sm text-slate-700">
                            <li class="flex items-start gap-2">
                                <span class="text-blue-600 font-bold mt-0.5">1.</span>
                                <span>Si deseas ir al <strong>Panel de Administración</strong>, da click en el botón <strong>"Ir a mi Panel"</strong>.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-blue-600 font-bold mt-0.5">2.</span>
                                <span>Si deseas ver tu <strong>Tienda Pública</strong>, da click en el botón <strong>"Ver mi Tienda"</strong>.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-blue-600 font-bold mt-0.5">3.</span>
                                <span>Una vez en el panel, podrás <strong>personalizar el diseño</strong>, <strong>agregar productos</strong> y <strong>configurar métodos de pago</strong>.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-blue-600 font-bold mt-0.5">4.</span>
                                <span>Si necesitas ayuda, <a href="#" @click.prevent="calendlyOpen = true" class="font-semibold text-accent-300 hover:text-accent-400 underline transition-colors">agenda una reunión</a>.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Columna Derecha: Botones y Guías --}}
                <div class="space-y-6">
                    
                    {{-- Botones de Acción --}}
                    <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-200 overflow-hidden p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                            <a href="{{ route('tenant.admin.dashboard', $store->slug) }}"
                               class="flex flex-row lg:flex-col items-center gap-4 lg:gap-3 p-4 rounded-xl border-2 border-gray-200 hover:border-accent-300 hover:bg-accent-50 transition-all group">
                                {{-- Wireframe tipo megamenu --}}
                                <div class="w-24 h-24 lg:w-26 lg:h-26 bg-white rounded-lg shadow-sm p-2 flex-shrink-0">
                                    <div class="w-full h-full bg-gray-50 rounded flex flex-col gap-1 p-1">
                                        <div class="h-2 bg-accent-300/30 rounded w-3/4"></div>
                                        <div class="flex-1 grid grid-cols-2 gap-1">
                                            <div class="bg-accent-300/20 rounded"></div>
                                            <div class="bg-accent-300/20 rounded"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-left lg:text-center flex-1">
                                    <p class="text-sm lg:text-base font-semibold text-slate-900 mb-1">Ir a mi Panel</p>
                                    <p class="text-sm lg:text-base text-slate-500">Administrar</p>
                                </div>
                            </a>
                            
                            <a href="{{ url('/' . $store->slug) }}"
                               target="_blank"
                               class="flex flex-row lg:flex-col items-center gap-4 lg:gap-3 p-4 rounded-xl border-2 border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all group">
                                {{-- Wireframe tipo megamenu --}}
                                <div class="w-24 h-24 lg:w-26 lg:h-26 bg-white rounded-lg shadow-sm p-2 flex-shrink-0">
                                    <div class="w-full h-full bg-gray-50 rounded flex flex-col gap-1 p-1">
                                        <div class="flex items-center gap-1">
                                            <div class="w-3 h-3 bg-blue-500/30 rounded"></div>
                                            <div class="h-2 bg-gray-200 rounded flex-1"></div>
                                        </div>
                                        <div class="flex-1 space-y-1">
                                            <div class="h-3 bg-blue-500/20 rounded"></div>
                                            <div class="h-3 bg-blue-500/20 rounded w-4/5"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-left lg:text-center flex-1">
                                    <p class="text-sm lg:text-base font-semibold text-slate-900 mb-1">Ver mi Tienda</p>
                                    <p class="text-sm lg:text-base text-slate-500">Pública</p>
                                </div>
                            </a>
                            
                            <a href="{{ route('register.step1') }}"
                               class="flex flex-row lg:flex-col items-center gap-4 lg:gap-3 p-4 rounded-xl border-2 border-gray-200 hover:border-slate-400 hover:bg-slate-50 transition-all group">
                                {{-- Wireframe tipo megamenu --}}
                                <div class="w-24 h-24 lg:w-26 lg:h-26 bg-white rounded-lg shadow-sm p-2 flex-shrink-0">
                                    <div class="w-full h-full bg-gray-50 rounded flex flex-col gap-1 p-1">
                                        <div class="h-2 bg-slate-400/30 rounded w-full"></div>
                                        <div class="flex-1 grid grid-cols-3 gap-0.5">
                                            <div class="bg-slate-400/20 rounded"></div>
                                            <div class="bg-slate-400/20 rounded"></div>
                                            <div class="bg-slate-400/20 rounded"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-left lg:text-center flex-1">
                                    <p class="text-sm lg:text-base font-semibold text-slate-900 mb-1">Crear Nueva</p>
                                    <p class="text-sm lg:text-base text-slate-500">Tienda</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    {{-- Consejos útiles --}}
                    <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-200 overflow-hidden p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <i data-lucide="sparkles" class="w-5 h-5 text-purple-600"></i>
                            <h3 class="text-base font-bold text-slate-900">Consejos para empezar</h3>
                        </div>
                        <ul class="space-y-2.5 text-sm text-slate-700">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check-circle" class="w-4 h-4 text-purple-600 flex-shrink-0 mt-0.5"></i>
                                <span>Te recomendamos <strong>cambiar tu contraseña</strong> después del primer inicio de sesión por seguridad.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check-circle" class="w-4 h-4 text-purple-600 flex-shrink-0 mt-0.5"></i>
                                <span>Configura tus <strong>métodos de pago</strong> para comenzar a recibir pedidos de inmediato.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check-circle" class="w-4 h-4 text-purple-600 flex-shrink-0 mt-0.5"></i>
                                <span>Personaliza el <strong>diseño de tu tienda</strong> para reflejar la identidad de tu marca.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check-circle" class="w-4 h-4 text-purple-600 flex-shrink-0 mt-0.5"></i>
                                <span>Agrega tus <strong>primeros productos</strong> y configura las categorías de tu negocio.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendly Modal -->
    <div 
        x-show="calendlyOpen" 
        x-cloak
        x-transition
        @click.self="calendlyOpen = false"
        @keydown.escape.window="calendlyOpen = false"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
    >
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden">
            <!-- Close Button -->
            <button 
                @click="calendlyOpen = false"
                class="absolute top-4 right-4 z-10 w-10 h-10 bg-white/90 hover:bg-white rounded-full flex items-center justify-center shadow-lg transition-colors"
            >
                <i data-lucide="x" class="w-5 h-5 text-gray-600"></i>
            </button>
            
            <!-- Calendly Widget -->
            <div class="calendly-inline-widget" data-url="https://calendly.com/linkiucloud/30min?hide_event_type_details=1&hide_gdpr_banner=1&text_color=050506&primary_color=ea0038" style="min-width:320px;height:700px;"></div>
        </div>
    </div>

    <script>

        // Confetti al cargar
        window.addEventListener('load', function() {
            setTimeout(() => {
                confetti({
                    particleCount: 100,
                    spread: 70,
                    origin: { y: 0.6 }
                });
                
                setTimeout(() => {
                    confetti({
                        particleCount: 50,
                        angle: 60,
                        spread: 55,
                        origin: { x: 0 }
                    });
                }, 200);
                
                setTimeout(() => {
                    confetti({
                        particleCount: 50,
                        angle: 120,
                        spread: 55,
                        origin: { x: 1 }
                    });
                }, 400);
            }, 300);
        });

        // Copiar al portapapeles
        function copyToClipboard(text, type) {
            navigator.clipboard.writeText(text).then(() => {
                const message = type === 'email' ? 'Email copiado' : 'Contraseña copiada';
                showToast(message);
            }).catch(() => {
                showToast('Error al copiar', 'error');
            });
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed bottom-8 right-8 ${type === 'success' ? 'bg-green-600' : 'bg-red-600'} text-white px-6 py-3 rounded-lg shadow-xl flex items-center gap-2 z-50`;
            toast.style.transform = 'translateY(0)';
            toast.style.transition = 'all 0.3s ease-out';
            toast.innerHTML = `
                <i data-lucide="${type === 'success' ? 'check-circle' : 'x-circle'}" class="w-5 h-5"></i>
                <span>${message}</span>
            `;
            document.body.appendChild(toast);
            
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-20px)';
                setTimeout(() => toast.remove(), 300);
            }, 2000);
        }

        // Limpiar localStorage del wizard al cargar la página de éxito
        document.addEventListener('DOMContentLoaded', function() {
            // Limpiar todos los datos del wizard guardados en localStorage
            const localStorageKeys = [
                'registration_step2',
                'registration_step3',
                'registration_step4'
            ];
            
            localStorageKeys.forEach(key => {
                localStorage.removeItem(key);
            });
            
            // Inicializar iconos Lucide
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
        
        // Re-inicializar iconos cuando Alpine cambie el DOM
        document.addEventListener('alpine:initialized', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
    
    <style>
    [x-cloak] { display: none !important; }
    
    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    
    .animate-bounce {
        animation: bounce 1s ease-in-out infinite;
    }
    </style>
</body>
</html>
