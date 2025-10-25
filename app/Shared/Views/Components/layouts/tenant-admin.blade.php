<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - {{ $store->name }}</title>
    
    <!-- Favicon -->
    @php
        // Función para obtener el favicon más reciente del SuperAdmin
        $getLatestAppFavicon = function() {
            try {
                // Primero verificar sesión temporal
                $tempFavicon = session('temp_app_favicon');
                if ($tempFavicon) {
                    return $tempFavicon;
                }
                
                // Luego verificar variable de entorno
                $envFavicon = env('APP_FAVICON');
                if ($envFavicon) {
                    return $envFavicon;
                }
                
                // Temporalmente desactivado para evitar problemas con fileinfo
                // TODO: Reactivar cuando se solucione el problema de finfo en producción
                /*
                // Finalmente, buscar el favicon más reciente en S3
                if (config('filesystems.disks.s3.bucket')) {
                    try {
                        $files = Storage::disk('public')->files('system');
                        $faviconFiles = array_filter($files, function($file) {
                            return str_contains(basename($file), 'favicon_');
                        });
                    } catch (\Exception $e) {
                        Log::error('Error accessing storage files: ' . $e->getMessage());
                        $faviconFiles = [];
                    }
                    
                    if (!empty($faviconFiles)) {
                        // Ordenar por fecha en el nombre del archivo (más reciente primero)
                        usort($faviconFiles, function($a, $b) {
                            $timeA = preg_match('/favicon_(\d+)\./', basename($a), $matchesA) ? (int)$matchesA[1] : 0;
                            $timeB = preg_match('/favicon_(\d+)\./', basename($b), $matchesB) ? (int)$matchesB[1] : 0;
                            return $timeB - $timeA; // Más reciente primero
                        });
                        
                        return $faviconFiles[0]; // Retornar el más reciente
                    }
                }
                */
                
                return null;
            } catch (\Exception $e) {
                Log::error('Error searching for app favicon: ' . $e->getMessage());
                return null;
            }
        };
        
        $appFavicon = $getLatestAppFavicon();
        $faviconSrc = asset('favicon.ico'); // Default fallback
        
        if ($appFavicon) {
            try {
                // Temporalmente simplificado para evitar problemas con fileinfo
                $faviconSrc = asset('storage/' . $appFavicon);
                /*
                if (config('filesystems.disks.s3.bucket')) {
                    $faviconSrc = \Storage::disk('public')->url($appFavicon);
                } else {
                    $faviconSrc = asset('storage/' . $appFavicon);
                }
                */
            } catch (\Exception $e) {
                Log::error('Error generating favicon URL: ' . $e->getMessage());
                $faviconSrc = asset('storage/' . $appFavicon);
            }
        }
    @endphp
    <link rel="icon" type="image/x-icon" href="{{ $store->design && $store->design->is_published && $store->design->favicon_url ? $store->design->favicon_url : $faviconSrc }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Additional Head Content -->
    @stack('styles')
    
    <!-- 🔔 SISTEMA DE NOTIFICACIONES DE ESCRITORIO - RECREADO -->
    <script>
        // 📱 Variables globales para notificaciones
        let lastOrderCount = 0;
        let notificationInterval = null;
        const storeSlug = '{{ $store->slug ?? "" }}';
        
        // 🚀 Inicializar sistema de notificaciones
        function initDesktopNotifications() {
            // Solicitar permisos inmediatamente
            if (Notification.permission === 'default') {
                Notification.requestPermission().then(permission => {
                    if (permission === 'granted') {
                        showWelcomeNotification();
                        startOrderPolling();
                    }
                });
            } else if (Notification.permission === 'granted') {
                showWelcomeNotification();
                startOrderPolling();
            }
        }
        
        // 👋 Notificación de bienvenida
        function showWelcomeNotification() {
            const notification = new Notification('🔔 Sistema de pedidos activado', {
                body: 'Te notificaremos cuando lleguen nuevos pedidos',
                icon: '/favicon.ico',
                tag: 'welcome',
                silent: true
            });
            
            setTimeout(() => notification.close(), 3000);
        }
        
        // ⏰ Iniciar polling cada 15 segundos (AGRESIVO)
        function startOrderPolling() {
            // Cargar conteo inicial
            loadInitialCount();
            
            // Verificar cada 15 segundos - MÁS AGRESIVO
            notificationInterval = setInterval(() => {
                checkForNewOrders();
            }, 15000);
            
            // También verificar cuando la pestaña vuelve a tener focus
            window.addEventListener('focus', () => {
                checkForNewOrders();
            });
            
            // Verificar cuando la pestaña se vuelve visible
            document.addEventListener('visibilitychange', () => {
                if (!document.hidden) {
                    checkForNewOrders();
                }
            });
        }
        
        // 📊 Cargar conteo inicial
        async function loadInitialCount() {
            if (!storeSlug) return;
            
            try {
                const response = await fetch(`/${storeSlug}/admin/orders/api/count`);
                if (response.ok) {
                    const data = await response.json();
                    if (data.success) {
                        lastOrderCount = data.count;
                    }
                }
            } catch (error) {
                // Error silencioso
            }
        }
        
        // 🔍 Verificar nuevos pedidos
        async function checkForNewOrders() {
            if (!storeSlug) return;
            
            try {
                const response = await fetch(`/${storeSlug}/admin/orders/api/count`);
                if (response.ok) {
                    const data = await response.json();
                    if (data.success) {
                        const currentCount = data.count;
                        
                        // Si hay nuevos pedidos
                        if (currentCount > lastOrderCount && lastOrderCount > 0) {
                            const newOrdersCount = currentCount - lastOrderCount;
                            showNewOrderNotification(newOrdersCount, data.latest_order);
                        }
                        
                        lastOrderCount = currentCount;
                    }
                }
            } catch (error) {
                console.error(`❌ ${timestamp} - Error verificando pedidos:`, error);
            }
        }
        
        // 🔔 Mostrar notificación de nuevo pedido
        function showNewOrderNotification(count, latestOrder) {
            if (Notification.permission !== 'granted') return;
            
            const title = count === 1 ? '🔔 ¡Nuevo pedido!' : `🔔 ¡${count} nuevos pedidos!`;
            let body = 'Revisa el panel de pedidos';
            
            if (latestOrder) {
                const total = new Intl.NumberFormat('es-CO').format(latestOrder.total);
                body = `Pedido #${latestOrder.order_number}\n💰 $${total}\n👤 ${latestOrder.customer_name}\n\n👆 Click para ver detalles`;
            }
            
            const notification = new Notification(title, {
                body: body,
                icon: '/favicon.ico',
                tag: 'new-order',
                requireInteraction: true,
                silent: false,
                renotify: true,
                vibrate: [200, 100, 200]
            });
            
            // 🎵 Sonido de notificación
            try {
                const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmIePjuVvDY=');
                audio.volume = 0.5;
                audio.play().catch(() => {});
            } catch (e) {
                console.log('🔇 Sin sonido disponible');
            }
            
            // 👆 Click para ir al pedido
            notification.onclick = () => {
                window.focus();
                notification.close();
                
                if (latestOrder && latestOrder.id) {
                    window.location.href = `/${storeSlug}/admin/orders/${latestOrder.id}`;
                } else {
                    window.location.href = `/${storeSlug}/admin/orders`;
                }
            };
        }
        
        // 🚀 Inicializar cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', () => {
            initDesktopNotifications();
        });
        
        // 🧹 Limpiar al salir
        window.addEventListener('beforeunload', () => {
            if (notificationInterval) {
                clearInterval(notificationInterval);
            }
        });
    </script>
</head>
<body class="bg-secondary-50 font-body tenant-admin" data-store-id="{{ $store->id }}">
    <!-- Banner de Modo Preview (SuperAdmin) -->
    @if(session('preview_mode'))
    <div class="bg-warning-300 border-b-2 border-warning-400 px-6 py-3 sticky top-0 z-[9999]">
        <div class="flex items-center justify-between max-w-7xl mx-auto">
            <div class="flex items-center gap-3">
                <x-solar-eye-outline class="w-5 h-5 text-black-500 flex-shrink-0" />
                <div class="flex flex-col sm:flex-row sm:items-center sm:gap-2">
                    <p class="text-sm font-semibold text-black-500">
                        Modo Vista Previa - SuperAdmin
                    </p>
                    <span class="text-xs text-black-400">
                        Viendo como: <span class="font-semibold">{{ session('preview_mode.store_name') }}</span>
                    </span>
                    <span class="text-xs text-black-400 hidden sm:inline">
                        • Desde: {{ session('preview_mode.started_at')->format('H:i') }}
                    </span>
                </div>
            </div>
            
            <form action="{{ route('linkiu.admin-preview.exit') }}" method="POST" class="flex-shrink-0">
                @csrf
                <button type="submit" 
                    class="bg-error-200 hover:bg-error-300 text-accent-50 px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition-colors">
                    <x-solar-logout-3-outline class="w-4 h-4" />
                    <span class="hidden sm:inline">Salir del Preview</span>
                    <span class="sm:hidden">Salir</span>
                </button>
            </form>
        </div>
    </div>
    @endif
    
    <!-- Sidebar del Admin de Tienda -->
    @include('shared::admin.tenant-sidebar', ['store' => $store])
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar del Admin de Tienda -->
        @include('shared::admin.tenant-navbar', ['store' => $store])
        
        <!-- Page Content -->
        <main class="main-content-inner">
            <!-- Page Header -->
            @hasSection('header')
                <div class="page-header">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="heading-2 text-black-500 mb-1">@yield('title')</h1>
                            @hasSection('subtitle')
                                <p class="body-base text-black-300">@yield('subtitle')</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-3">
                            @yield('actions')
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success mb-6" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                    <div class="flex items-center gap-3">
                        <x-solar-check-circle-outline class="w-5 h-5 text-success-300" />
                        <span>{{ session('success') }}</span>
                        <button @click="show = false" class="ml-auto">
                            <x-solar-close-circle-outline class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-error mb-6" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                    <div class="flex items-center gap-3">
                        <x-solar-close-circle-outline class="w-5 h-5 text-error-300" />
                        <span>{{ session('error') }}</span>
                        <button @click="show = false" class="ml-auto">
                            <x-solar-close-circle-outline class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-error mb-6" x-data="{ show: true }" x-show="show">
                    <div class="flex items-start gap-3">
                        <x-solar-close-circle-outline class="w-5 h-5 text-error-300 mt-0.5" />
                        <div class="flex-1">
                            <p class="font-medium mb-2">Por favor corrige los siguientes errores:</p>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li class="body-small">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button @click="show = false" class="ml-auto">
                            <x-solar-close-circle-outline class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            @endif
            
            <!-- Main Content -->
            <div class="content-area">
                @yield('content')
            </div>
        </main>
        
        <!-- Footer -->
        @include('shared::admin.footer')
    </div>
    
    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-black-500 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-accent-50 rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-primary-300"></div>
            <span class="body-base text-black-400">Cargando...</span>
        </div>
    </div>

    <!-- 🚨 POPUP MODAL DE ANUNCIOS CRÍTICOS -->
    <div x-data="announcementPopups" 
         x-init="init()"
         @show-announcement-popup.window="showPopupFromPusher($event.detail)"
         x-show="popups.length > 0 && currentPopupIndex < popups.length"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center px-4"
         style="display: none;">
        
        <!-- Backdrop con blur épico 🎨 -->
        <div class="absolute inset-0 bg-black-400/60 backdrop-blur-md" @click="closePopup()"></div>
        
        <!-- Modal Container -->
        <div x-show="popups.length > 0 && currentPopupIndex < popups.length"
             x-transition:enter="transition ease-out duration-300 delay-100"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="relative bg-accent-50 rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden">
            
            <!-- Header con gradiente dinámico -->
            <div :class="`bg-gradient-to-r from-${currentPopup.type_color}-100 to-${currentPopup.type_color}-75 border-b-4 border-${currentPopup.type_color}-200`"
                 class="py-5 px-6">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-center gap-3 flex-1">
                        <div :class="`bg-${currentPopup.type_color}-200 rounded-full p-3`">
                            <span class="text-4xl" x-text="currentPopup.type_icon"></span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-h4 font-bold text-black-400 mb-1" x-text="currentPopup.title"></h3>
                            <div class="flex items-center gap-3 text-sm text-black-300">
                                <span :class="`inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-${currentPopup.type_color}-200 text-accent-50`">
                                    🚨 Crítico
                                </span>
                                <span class="flex items-center gap-1">
                                    <x-solar-calendar-outline class="w-4 h-4" />
                                    <span x-text="currentPopup.published_at"></span>
                                </span>
                                <span :class="`flex items-center gap-1 px-2 py-1 rounded-full bg-${currentPopup.type_color}-100`">
                                    <x-solar-star-outline class="w-4 h-4" />
                                    <span x-text="`Prioridad ${currentPopup.priority}`"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <button @click="closePopup()" 
                            class="text-black-300 hover:text-black-400 transition-colors p-2 hover:bg-black-50 rounded-lg">
                        <x-solar-close-circle-outline class="w-6 h-6" />
                    </button>
                </div>
            </div>
            
            <!-- Content con scroll -->
            <div class="overflow-y-auto max-h-[calc(90vh-280px)] p-6">
                <div class="prose prose-sm max-w-none">
                    <div class="text-black-400 leading-relaxed whitespace-pre-wrap text-base" 
                         x-html="currentPopup.content"></div>
                </div>
                
                <!-- Banner si existe -->
                <div x-show="currentPopup.banner_image_url" class="mt-6">
                    <a :href="currentPopup.banner_link || '#'" 
                       :target="currentPopup.banner_link ? '_blank' : '_self'"
                       class="block rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                        <img :src="currentPopup.banner_image_url" 
                             alt="Banner" 
                             class="w-full h-auto object-cover">
                    </a>
                </div>

                <!-- Info adicional -->
                <div class="mt-6 p-4 bg-info-50 border border-info-100 rounded-lg">
                    <div class="flex items-start gap-3">
                        <x-solar-info-circle-outline class="w-5 h-5 text-info-300 flex-shrink-0 mt-0.5" />
                        <div class="text-sm text-info-300">
                            <strong>Importante:</strong> Este es un anuncio crítico que requiere tu atención inmediata. 
                            Por favor, léelo completamente antes de continuar.
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer con acciones -->
            <div class="bg-accent-100 border-t border-accent-200 py-4 px-6">
                <div class="flex items-center justify-between gap-4">
                    <!-- Indicador de progreso -->
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-black-300 font-medium" 
                              x-text="`Anuncio ${currentPopupIndex + 1} de ${popups.length}`"></span>
                        <div class="flex gap-1">
                            <template x-for="(popup, index) in popups" :key="popup.id">
                                <div :class="index === currentPopupIndex ? 'bg-primary-300 w-8' : 'bg-black-200 w-2'" 
                                     class="h-2 rounded-full transition-all duration-300"></div>
                            </template>
                        </div>
                    </div>
                    
                    <!-- Botones de acción -->
                    <div class="flex gap-3">
                        <a :href="currentPopup.show_url" 
                           class="btn-outline-info px-5 py-2.5 rounded-lg flex items-center gap-2 text-sm font-medium hover:scale-105 transition-transform">
                            <x-solar-eye-outline class="w-4 h-4" />
                            Ver Detalle Completo
                        </a>
                        <button @click="markAsReadAndNext()" 
                                :class="currentPopupIndex < popups.length - 1 ? 'btn-primary' : 'btn-success'"
                                class="px-6 py-2.5 rounded-lg flex items-center gap-2 text-sm font-medium hover:scale-105 transition-transform shadow-md">
                            <x-solar-check-circle-outline class="w-5 h-5" />
                            <span x-show="currentPopupIndex < popups.length - 1">Siguiente Anuncio</span>
                            <span x-show="currentPopupIndex >= popups.length - 1">¡Entendido!</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    @stack('scripts')
    
    <!-- Store Data for JavaScript -->
    <script>
        window.store = {
            id: {{ $store->id }},
            name: '{{ $store->name }}',
            slug: '{{ $store->slug }}',
            status: '{{ $store->status }}',
            plan: {
                name: '{{ $store->plan->name ?? 'Basic' }}',
                limits: {
                    products: {{ $store->plan->max_products ?? 20 }},
                    categories: {{ $store->plan->max_categories ?? 3 }},
                    variables: {{ $store->plan->max_variables ?? 5 }},
                    coupons: {{ $store->plan->max_active_coupons ?? 1 }},
                    sliders: {{ $store->plan->max_slider ?? 1 }},
                    locations: {{ $store->plan->max_sedes ?? 1 }}
                }
            }
        };

        // 🚨 SISTEMA DE POPUPS CRÍTICOS
        function announcementPopups() {
            return {
                popups: [],
                currentPopupIndex: 0,
                loading: false,
                
                get currentPopup() {
                    return this.popups[this.currentPopupIndex] || {};
                },
                
                async init() {
                    await this.loadPopups();
                },
                
                async loadPopups() {
                    if (this.loading) return;
                    this.loading = true;
                    
                    try {
                        const response = await fetch('{{ route("tenant.admin.announcements.api.popups", $store->slug) }}');
                        const data = await response.json();
                        this.popups = data;
                        
                        if (this.popups.length > 0) {
                            // Pequeño delay para mejor UX
                            setTimeout(() => {
                                this.currentPopupIndex = 0;
                            }, 500);
                        }
                    } catch (error) {
                        // Error silencioso
                    } finally {
                        this.loading = false;
                    }
                },
                
                async markAsReadAndNext() {
                    // Marcar actual como leído
                    try {
                        await fetch(`{{ route('tenant.admin.announcements.mark-as-read', ['store' => $store->slug, 'announcement' => ':id']) }}`.replace(':id', this.currentPopup.id), {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });
                    } catch (error) {
                        // Error silencioso
                    }
                    
                    // Ir al siguiente o cerrar
                    if (this.currentPopupIndex < this.popups.length - 1) {
                        this.currentPopupIndex++;
                    } else {
                        this.closePopup();
                    }
                },
                
                closePopup() {
                    this.popups = [];
                    this.currentPopupIndex = 0;
                },
                
                // 🔔 Mostrar popup desde Pusher (tiempo real)
                showPopupFromPusher(announcementData) {
                    // Agregar al final de la cola si no existe
                    if (!this.popups.find(p => p.id === announcementData.id)) {
                        this.popups.push(announcementData);
                        
                        // Si no hay popup activo, mostrar inmediatamente
                        if (this.currentPopupIndex >= this.popups.length - 1) {
                            this.currentPopupIndex = this.popups.length - 1;
                        }
                    }
                }
            }
        }
    </script>
</body>
</html> 