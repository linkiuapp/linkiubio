@php
use Illuminate\Support\Facades\Storage;
use App\Shared\Models\BillingSetting;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{config('app.name', 'Linkiu.bio')}} - @yield('title', 'Super Linkiu')</title>
    
    <!-- Favicon -->
    @php
        // ✅ LEER DESDE BASE DE DATOS (persistente)
        $settings = BillingSetting::getInstance();
        $appFavicon = $settings->app_favicon;
        
        $faviconSrc = asset('favicon.ico'); // Default
        
        if ($appFavicon) {
            try {
                // ✅ Usar Storage::url() siempre - funciona en local Y en S3/Laravel Cloud
                $faviconSrc = Storage::disk('public')->url($appFavicon);
            } catch (\Exception $e) {
                \Log::error('Error generando URL de favicon en layout', [
                    'favicon_path' => $appFavicon,
                    'error' => $e->getMessage()
                ]);
            }
        }
    @endphp
    <link rel="icon" type="image/x-icon" href="{{ $faviconSrc }}">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    {{-- SECTION: Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link 
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    {{-- End SECTION: Fonts --}}
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- SECTION: Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- End SECTION: Alpine.js --}}
    
    {{-- SECTION: Additional Head Content --}}
    @stack('styles')
    {{-- End SECTION: Additional Head Content --}}
</head>
<body class="bg-secondary-50 font-body super-admin">

    {{-- SECTION: Sidebar --}}
    <x-admin-sidebar />
    {{-- End SECTION: Sidebar --}}

    {{-- SECTION: Navbar --}}
    <x-admin-navbar />
    {{-- End SECTION: Navbar --}}

    {{-- SECTION: Main Content --}}
    <div 
        x-data="{
            marginLeft: '0px',
            paddingTop: '80px',
            initInterval: null,
            
            updatePosition() {
                const savedMinified = localStorage.getItem('sidebar_super-admin-sidebar_minified');
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
                    class="alert alert-success mb-6" 
                    x-data="{ show: true }" 
                    x-show="show"
                    x-init="setTimeout(() => show = false, 5000)"
                >
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
                    const savedMinified = localStorage.getItem('sidebar_super-admin-sidebar_minified');
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
            <x-admin-footer />
        </footer>
        {{-- End SECTION: Footer --}}
    </div>
    {{-- End SECTION: Main Content --}}

    {{-- SECTION: Loading Overlay --}}
    <div 
        id="loading-overlay"
        class="fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center"
        style="display: none;"
    >
        <div class="bg-white rounded-lg p-6 flex flex-col items-center gap-4">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-300"></div>
            <p class="text-gray-700">Cargando...</p>
        </div>
    </div>
    {{-- End SECTION: Loading Overlay --}}

    @stack('scripts')
</body>
</html>
