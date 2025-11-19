<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - {{ $store->name }}</title>

    {{-- SECTION: Favicon --}}
    @php
        $getLatestAppFavicon = function() {
            try {
                $tempFavicon = session('temp_app_favicon');
                if ($tempFavicon) {
                    return $tempFavicon;
                }

                $envFavicon = env('APP_FAVICON');
                if ($envFavicon) {
                    return $envFavicon;
                }

                return null;
            } catch (\Exception $e) {
                Log::error('Error searching for app favicon: ' . $e->getMessage());
                return null;
            }
        };

        $faviconSrc = asset('favicon.ico');

        if ($store->design && $store->design->favicon_url) {
            $faviconSrc = $store->design->favicon_url;
        } else {
            $appFavicon = $getLatestAppFavicon();
            if ($appFavicon) {
                try {
                    $faviconSrc = asset('storage/' . $appFavicon);
                } catch (\Exception $e) {
                    Log::error('Error generating favicon URL: ' . $e->getMessage());
                    $faviconSrc = asset('storage/' . $appFavicon);
                }
            }
        }
    @endphp
    <link rel="icon" type="image/x-icon" href="{{ $faviconSrc }}">
    {{-- End SECTION: Favicon --}}

    {{-- SECTION: Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link 
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    {{-- End SECTION: Fonts --}}

    {{-- SECTION: Styles --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- End SECTION: Styles --}}

    {{-- SECTION: Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- End SECTION: Alpine.js --}}

    {{-- SECTION: Additional Head Content --}}
    @stack('styles')
    {{-- End SECTION: Additional Head Content --}}

    {{-- SECTION: Desktop Notifications Script --}}
    <script>
        (function() {
            'use strict';

            let lastOrderCount = 0;
            let notificationInterval = null;
            const storeSlug = '{{ $store->slug ?? "" }}';

            function initDesktopNotifications() {
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

            function showWelcomeNotification() {
                const notification = new Notification('Sistema de pedidos activado', {
                    body: 'Te notificaremos cuando lleguen nuevos pedidos',
                    icon: '/favicon.ico',
                    tag: 'welcome',
                    silent: true
                });

                setTimeout(() => notification.close(), 3000);
            }

            function startOrderPolling() {
                loadInitialCount();

                notificationInterval = setInterval(() => {
                    checkForNewOrders();
                }, 15000);

                window.addEventListener('focus', () => {
                    checkForNewOrders();
                });

                document.addEventListener('visibilitychange', () => {
                    if (!document.hidden) {
                        checkForNewOrders();
                    }
                });
            }

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

            async function checkForNewOrders() {
                if (!storeSlug) return;

                try {
                    const response = await fetch(`/${storeSlug}/admin/orders/api/count`);
                    if (response.ok) {
                        const data = await response.json();
                        if (data.success) {
                            const currentCount = data.count;

                            if (currentCount > lastOrderCount && lastOrderCount > 0) {
                                const newOrdersCount = currentCount - lastOrderCount;
                                showNewOrderNotification(newOrdersCount, data.latest_order);
                            }

                            lastOrderCount = currentCount;
                        }
                    }
                } catch (error) {
                    // Error silencioso
                }
            }

            function showNewOrderNotification(count, latestOrder) {
                if (Notification.permission !== 'granted') return;

                const title = count === 1 ? 'Nuevo pedido' : `${count} nuevos pedidos`;
                let body = 'Revisa el panel de pedidos';

                if (latestOrder) {
                    const total = new Intl.NumberFormat('es-CO').format(latestOrder.total);
                    body = `Pedido #${latestOrder.order_number}\n$${total}\n${latestOrder.customer_name}\n\nClick para ver detalles`;
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

                try {
                    const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmIePjuVvDY=');
                    audio.volume = 0.5;
                    audio.play().catch(() => { });
                } catch (e) {
                    // Sin sonido disponible
                }

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

            document.addEventListener('DOMContentLoaded', () => {
                initDesktopNotifications();
            });

            window.addEventListener('beforeunload', () => {
                if (notificationInterval) {
                    clearInterval(notificationInterval);
                }
            });
        })();
    </script>
    {{-- End SECTION: Desktop Notifications Script --}}

    {{-- SECTION: SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- End SECTION: SweetAlert2 --}}

    {{-- SECTION: Session Messages Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            {{-- Los mensajes de éxito ahora se muestran con AlertBordered en lugar de SweetAlert --}}
            @if(session('swal_success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: '{{ session('swal_success') }}',
                    confirmButtonColor: '#00c76f',
                    confirmButtonText: 'OK',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            @if(session('onboarding_step_completed'))
                if (typeof window.confetti === 'function') {
                    const stepKey = 'confetti_step_shown_{{ now()->timestamp }}';
                    if (!sessionStorage.getItem(stepKey)) {
                        setTimeout(() => {
                            window.confetti({
                                particleCount: 50,
                                spread: 60,
                                origin: { y: 0.6 },
                                colors: ['#da27a7', '#0000fe', '#00c76f'],
                                startVelocity: 20,
                                ticks: 40
                            });
                            sessionStorage.setItem(stepKey, 'true');
                        }, 400);
                    }
                }
                @php
                    session()->forget('onboarding_step_completed');
                @endphp
            @endif

            @if(session('onboarding_just_completed'))
                if (typeof window.confetti === 'function') {
                    const finalKey = 'confetti_final_shown_{{ auth()->id() ?? 0 }}';
                    if (!sessionStorage.getItem(finalKey)) {
                        setTimeout(() => {
                            const duration = 3000;
                            const animationEnd = Date.now() + duration;
                            const defaults = {
                                startVelocity: 30,
                                spread: 360,
                                ticks: 60,
                                zIndex: 9999,
                                colors: ['#da27a7', '#001b48', '#ed2e45', '#0000fe', '#00c76f', '#e8e6fb']
                            };

                            function randomInRange(min, max) {
                                return Math.random() * (max - min) + min;
                            }

                            const interval = setInterval(function() {
                                const timeLeft = animationEnd - Date.now();

                                if (timeLeft <= 0) {
                                    return clearInterval(interval);
                                }

                                const particleCount = 50 * (timeLeft / duration);

                                window.confetti({
                                    ...defaults,
                                    particleCount,
                                    origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 }
                                });
                                window.confetti({
                                    ...defaults,
                                    particleCount,
                                    origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 }
                                });
                            }, 250);

                            sessionStorage.setItem(finalKey, 'true');
                        }, 500);
                    }
                }
                @php
                    session()->forget('onboarding_just_completed');
                @endphp
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#ed2e45',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>
    {{-- End SECTION: Session Messages Script --}}

    {{-- SECTION: Alpine.js Initialization --}}
    <script>
        document.addEventListener('alpine:init', () => {
            window.dispatchEvent(new CustomEvent('alpine-ready'));
        });
    </script>
    {{-- End SECTION: Alpine.js Initialization --}}
</head>
<body class="bg-secondary-50 font-body tenant-admin" data-store-id="{{ $store->id }}">

    {{-- SECTION: Preview Mode Banner --}}
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
                    <button 
                        type="submit"
                        class="bg-error-200 hover:bg-error-300 text-accent-50 px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition-colors"
                    >
                        <x-solar-logout-3-outline class="w-4 h-4" />
                        <span class="hidden sm:inline">Salir del Preview</span>
                        <span class="sm:hidden">Salir</span>
                    </button>
                </form>
            </div>
        </div>
    @endif
    {{-- End SECTION: Preview Mode Banner --}}

    {{-- SECTION: Sidebar --}}
    @include('shared::admin.tenant-sidebar', ['store' => $store])
    {{-- End SECTION: Sidebar --}}

    {{-- SECTION: Navbar --}}
    @include('shared::admin.tenant-navbar', ['store' => $store])
    {{-- End SECTION: Navbar --}}

    {{-- SECTION: Main Content --}}
    <div 
        x-data="{
            marginLeft: '0px',
            paddingTop: '80px',
            initInterval: null,
            
            updatePosition() {
                const savedMinified = localStorage.getItem('sidebar_tenant-admin-sidebar_minified');
                const isMinified = savedMinified === 'true';
                const isDesktop = window.innerWidth >= 1024;
                
                if (typeof Alpine !== 'undefined' && Alpine.store) {
                    const store = Alpine.store('sidebar');
                    if (store) {
                        if (!store.isDesktop) {
                            this.marginLeft = '0px';
                        } else if (store.isMinified) {
                            this.marginLeft = '65px';
                        } else {
                            this.marginLeft = '288px';
                        }
                        return;
                    }
                }
                
                if (!isDesktop) {
                    this.marginLeft = '0px';
                } else if (isMinified) {
                    this.marginLeft = '65px';
                } else {
                    this.marginLeft = '288px';
                }
            },
            
            init() {
                this.updatePosition();
                
                const trySync = () => {
                    if (typeof Alpine !== 'undefined' && Alpine.store && Alpine.store('sidebar')) {
                        this.updatePosition();
                        if (this.initInterval) {
                            clearInterval(this.initInterval);
                            this.initInterval = null;
                        }
                    }
                };
                
                let attempts = 0;
                this.initInterval = setInterval(() => {
                    attempts++;
                    if (attempts > 40) {
                        clearInterval(this.initInterval);
                        this.initInterval = null;
                    }
                    trySync();
                }, 50);
                
                window.addEventListener('sidebar-state-changed', () => {
                    this.updatePosition();
                });
                
                document.addEventListener('alpine:initialized', () => {
                    this.$nextTick(() => {
                        this.updatePosition();
                    });
                });
                
                window.addEventListener('resize', () => {
                    this.updatePosition();
                });
            }
        }"
        class="main-content transition-all duration-300"
        :style="`margin-left: ${marginLeft}; padding-top: ${paddingTop};`"
    >
        {{-- SECTION: Page Content --}}
        <main class="main-content-inner pb-24">
            {{-- SECTION: Page Header --}}
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
            {{-- End SECTION: Page Header --}}

            {{-- SECTION: Flash Messages --}}
            @if(session('success'))
                <div 
                    x-data="{ show: true }" 
                    x-show="show"
                    x-cloak
                    x-init="setTimeout(() => show = false, 5000)"
                    class="mb-6"
                >
                    <x-alert-bordered 
                        type="success" 
                        title="Operación exitosa"
                        :message="session('success')" />
                </div>
            @endif

            @if(session('error'))
                <div 
                    class="alert alert-error mb-6" 
                    x-data="{ show: true }" 
                    x-show="show"
                    x-init="setTimeout(() => show = false, 5000)"
                >
                    <div class="flex items-center gap-3">
                        <x-solar-close-circle-outline class="w-5 h-5 text-error-300" />
                        <span>{{ session('error') }}</span>
                        <button @click="show = false" class="ml-auto">
                            <x-solar-close-circle-outline class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            @endif

            {{-- Las alertas de validación ahora se manejan en las vistas individuales con el componente AlertBordered --}}
            {{-- End SECTION: Flash Messages --}}

            {{-- SECTION: Content Area --}}
            <div class="content-area">
                @yield('content')
            </div>
            {{-- End SECTION: Content Area --}}
        </main>
        {{-- End SECTION: Page Content --}}

        {{-- SECTION: Footer --}}
        <footer 
            x-data="{
                left: '0px',
                width: '100%',
                initInterval: null,
                
                updatePosition() {
                    const savedMinified = localStorage.getItem('sidebar_tenant-admin-sidebar_minified');
                    const isMinified = savedMinified === 'true';
                    const isDesktop = window.innerWidth >= 1024;
                    
                    if (typeof Alpine !== 'undefined' && Alpine.store) {
                        const store = Alpine.store('sidebar');
                        if (store) {
                            if (!store.isDesktop) {
                                this.left = '0px';
                                this.width = '100%';
                            } else if (store.isMinified) {
                                this.left = '65px';
                                this.width = 'calc(100% - 65px)';
                            } else {
                                this.left = '288px';
                                this.width = 'calc(100% - 288px)';
                            }
                            return;
                        }
                    }
                    
                    if (!isDesktop) {
                        this.left = '0px';
                        this.width = '100%';
                    } else if (isMinified) {
                        this.left = '65px';
                        this.width = 'calc(100% - 65px)';
                    } else {
                        this.left = '288px';
                        this.width = 'calc(100% - 288px)';
                    }
                },
                
                init() {
                    this.updatePosition();
                    
                    const trySync = () => {
                        if (typeof Alpine !== 'undefined' && Alpine.store && Alpine.store('sidebar')) {
                            this.updatePosition();
                            if (this.initInterval) {
                                clearInterval(this.initInterval);
                                this.initInterval = null;
                            }
                        }
                    };
                    
                    let attempts = 0;
                    this.initInterval = setInterval(() => {
                        attempts++;
                        if (attempts > 40) {
                            clearInterval(this.initInterval);
                            this.initInterval = null;
                        }
                        trySync();
                    }, 50);
                    
                    window.addEventListener('sidebar-state-changed', () => {
                        this.updatePosition();
                    });
                    
                    document.addEventListener('alpine:initialized', () => {
                        this.$nextTick(() => {
                            this.updatePosition();
                        });
                    });
                    
                    window.addEventListener('resize', () => {
                        this.updatePosition();
                    });
                }
            }"
            class="fixed bottom-0 right-0 bg-white border-t border-gray-200 z-40 transition-all duration-300"
            :style="`left: ${left}; width: ${width};`"
        >
            @include('shared::admin.footer')
        </footer>
        {{-- End SECTION: Footer --}}
    </div>
    {{-- End SECTION: Main Content --}}

    {{-- SECTION: Loading Overlay --}}
    <div 
        id="loading-overlay"
        class="fixed inset-0 bg-black-500 bg-opacity-50 flex items-center justify-center z-50 hidden"
    >
        <div class="bg-accent-50 rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-primary-300"></div>
            <span class="body-base text-black-400">Cargando...</span>
        </div>
    </div>
    {{-- End SECTION: Loading Overlay --}}

    {{-- SECTION: Critical Announcements Popup --}}
    <div 
        x-data="announcementPopups"
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
        style="display: none;"
    >
        <div 
            class="absolute inset-0 bg-black-400/60 backdrop-blur-md" 
            @click="closePopup()"
        ></div>

        <div 
            x-show="popups.length > 0 && currentPopupIndex < popups.length"
            x-transition:enter="transition ease-out duration-300 delay-100"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="relative bg-accent-50 rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden"
        >
            <div 
                :class="`bg-gradient-to-r from-${currentPopup.type_color}-100 to-${currentPopup.type_color}-75 border-b-4 border-${currentPopup.type_color}-200`"
                class="py-5 px-6"
            >
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-center gap-3 flex-1">
                        <div :class="`bg-${currentPopup.type_color}-200 rounded-full p-3`">
                            <span class="text-4xl" x-text="currentPopup.type_icon"></span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-h4 font-bold text-black-400 mb-1" x-text="currentPopup.title"></h3>
                            <div class="flex items-center gap-3 text-sm text-black-300">
                                <span 
                                    :class="`inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-${currentPopup.type_color}-200 text-accent-50`"
                                >
                                    Crítico
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
                    <button 
                        @click="closePopup()"
                        class="text-black-300 hover:text-black-400 transition-colors p-2 hover:bg-black-50 rounded-lg"
                    >
                        <x-solar-close-circle-outline class="w-6 h-6" />
                    </button>
                </div>
            </div>

            <div class="overflow-y-auto max-h-[calc(90vh-280px)] p-6">
                <div class="prose prose-sm max-w-none">
                    <div 
                        class="text-black-400 leading-relaxed whitespace-pre-wrap text-base"
                        x-html="currentPopup.content"
                    ></div>
                </div>

                <div x-show="currentPopup.banner_image_url" class="mt-6">
                    <a 
                        :href="currentPopup.banner_link || '#'"
                        :target="currentPopup.banner_link ? '_blank' : '_self'"
                        class="block rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow"
                    >
                        <img 
                            :src="currentPopup.banner_image_url"
                            alt="Banner"
                            class="w-full h-auto object-cover"
                        >
                    </a>
                </div>

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

            <div class="bg-accent-100 border-t border-accent-200 py-4 px-6">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <span 
                            class="text-sm text-black-300 font-medium"
                            x-text="`Anuncio ${currentPopupIndex + 1} de ${popups.length}`"
                        ></span>
                        <div class="flex gap-1">
                            <template x-for="(popup, index) in popups" :key="popup.id">
                                <div 
                                    :class="index === currentPopupIndex ? 'bg-primary-300 w-8' : 'bg-black-200 w-2'"
                                    class="h-2 rounded-full transition-all duration-300"
                                ></div>
                            </template>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <a 
                            :href="currentPopup.show_url"
                            class="btn-outline-info px-5 py-2.5 rounded-lg flex items-center gap-2 text-sm font-medium hover:scale-105 transition-transform"
                        >
                            <x-solar-eye-outline class="w-4 h-4" />
                            Ver Detalle Completo
                        </a>
                        <button 
                            @click="markAsReadAndNext()"
                            :class="currentPopupIndex < popups.length - 1 ? 'btn-primary' : 'btn-success'"
                            class="px-6 py-2.5 rounded-lg flex items-center gap-2 text-sm font-medium hover:scale-105 transition-transform shadow-md"
                        >
                            <x-solar-check-circle-outline class="w-5 h-5" />
                            <span x-show="currentPopupIndex < popups.length - 1">Siguiente Anuncio</span>
                            <span x-show="currentPopupIndex >= popups.length - 1">Entendido</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End SECTION: Critical Announcements Popup --}}

    {{-- SECTION: Scripts Stack --}}
    @stack('scripts')
    {{-- End SECTION: Scripts Stack --}}

    {{-- SECTION: Store Data and Announcement Popups --}}
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

                showPopupFromPusher(announcementData) {
                    if (!this.popups.find(p => p.id === announcementData.id)) {
                        this.popups.push(announcementData);

                        if (this.currentPopupIndex >= this.popups.length - 1) {
                            this.currentPopupIndex = this.popups.length - 1;
                        }
                    }
                }
            }
        }
    </script>
    {{-- End SECTION: Store Data and Announcement Popups --}}
</body>
</html>
