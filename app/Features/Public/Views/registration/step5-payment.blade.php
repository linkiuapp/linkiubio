<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Construyendo tu Tienda - Linkiu</title>
    
    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('images-ui/favico_linkiu.svg') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    
    <div class="min-h-screen flex flex-col items-center justify-center p-4" x-data="storeBuilder()">
        <div class="max-w-4xl w-full">
            
            {{-- Icono --}}
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-lg">
                    <i data-lucide="sparkles" class="w-10 h-10 text-accent-300 animate-pulse"></i>
                </div>
            </div>

            {{-- Título Principal --}}
            <div class="text-center mb-3">
                <h1 class="text-xl md:text-2xl font-bold text-slate-900">Construyendo tu Tienda</h1>
            </div>

            {{-- Subtítulo --}}
            <div class="text-center mb-4">
                <p class="text-base md:text-lg text-slate-600">Estamos preparando todo para ti</p>
            </div>

            {{-- SVG Container - Solo SVG sin card --}}
            <div class="relative flex items-center justify-center" style="min-height: 300px;">
                @php
                    $svgFiles = ['img_create_01.svg', 'img_create_02.svg', 'img_create_03.svg', 'img_create_04.svg', 
                                 'img_create_05.svg', 'img_create_06.svg', 'img_create_07.svg', 'img_create_08.svg', 
                                 'img_create_09.svg', 'img_create_10.svg', 'img_create_11.svg', 'img_create_12.svg', 
                                 'img_create_13.svg', 'img_create_14.svg'];
                @endphp
                
                @foreach($svgFiles as $index => $svgFile)
                    <div x-show="currentImage === {{ $index + 1 }}" 
                         x-cloak
                         x-transition:enter="transition ease-in-out duration-300"
                         x-transition:enter-start="opacity-0 translate-x-8"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in-out duration-300"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 -translate-x-8"
                         class="absolute inset-0 flex items-center justify-center p-8"
                         style="will-change: transform, opacity;">
                        <img src="{{ url('images-ui/' . $svgFile) }}" 
                             alt="Construyendo paso {{ $index + 1 }}"
                             class="max-w-full max-h-72 w-auto h-auto object-contain">
                    </div>
                @endforeach
            </div>

            {{-- Título del Paso (carrusel vertical) --}}
            <div class="text-center relative overflow-hidden w-full" style="min-height: 80px;">
                @php
                    $stepTitles = [
                        'Configurando tu Plan',
                        'Procesando Información del Negocio',
                        'Construyendo tu Tienda',
                        'Configurando Cuenta de Administrador',
                        'Creando Base de Datos',
                        'Configurando Sistema de Pago',
                        'Preparando Dashboard',
                        'Configurando Permisos',
                        'Instalando Plantilla',
                        'Configurando slug',
                        'Optimizando Rendimiento',
                        'Configurando Seguridad',
                        'Realizando Pruebas Finales',
                        '¡Casi Listo!'
                    ];
                @endphp
                
                @foreach($stepTitles as $index => $title)
                    <template x-if="currentImage === {{ $index + 1 }}">
                        <div x-cloak
                             x-transition:enter="transition ease-in-out duration-300"
                             x-transition:enter-start="opacity-0 -translate-y-8"
                             x-transition:enter-end="opacity-100 -translate-y-0"
                             x-transition:leave="transition ease-in duration-300"
                             x-transition:leave-start="opacity-100 -translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-8"
                             class="absolute inset-0 flex items-center justify-center">
                            <h2 class="text-base md:text-lg font-medium text-slate-400">
                                {{ $title }}
                            </h2>
                        </div>
                    </template>
                @endforeach
            </div>

            {{-- Barra de Progreso Animada --}}
            <div class="mb-8">
                <div class="w-full h-1 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-accent-300 transition-all duration-1000 ease-out rounded-full"
                         :style="`width: ${progress}%`"></div>
                </div>
            </div>

            {{-- Estado de Aprobación --}}
            <!-- <div x-show="status === 'approved'" x-cloak class="mt-6">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-500 rounded-2xl p-8 text-center shadow-xl">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                        <i data-lucide="check" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-green-900 mb-2">¡Tienda Lista!</h3>
                    <p class="text-slate-600 mb-4">Redirigiendo a tu tienda...</p>
                </div>
            </div> -->

            <div x-show="status === 'rejected'" x-cloak class="mt-6">
                <div class="bg-gradient-to-r from-red-50 to-rose-50 border-2 border-red-500 rounded-2xl p-8 text-center shadow-xl">
                    <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="x-circle" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-red-900 mb-2">Validación No Aprobada</h3>
                    <p class="text-slate-600" x-text="rejectionReason">Hubo un problema con el comprobante</p>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('storeBuilder', () => ({
            currentImage: 1,
            progress: 0,
            status: 'pending',
            rejectionReason: '',
            pollingInterval: null,
            rotationInterval: null,
            registrationId: {{ $registration->id }},
            
            init() {
                // Iniciar rotación infinita de imágenes
                this.startRotation();
                
                // Iniciar animación de progreso
                this.startProgress();
                
                // Polling cada 10 segundos
                this.startPolling();
                
                // Inicializar iconos
                this.$nextTick(() => {
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                });
            },
            
            startRotation() {
                // Rotar imágenes cada 2 segundos infinitamente (1-14)
                this.rotationInterval = setInterval(() => {
                    this.currentImage = (this.currentImage % 14) + 1;
                }, 2000);
            },
            
            startProgress() {
                // Animar progreso de 0 a 95% (dejar espacio para cuando se apruebe)
                let targetProgress = 95;
                let increment = 0.3;
                
                const progressInterval = setInterval(() => {
                    if (this.progress < targetProgress) {
                        this.progress += increment;
                    } else {
                        clearInterval(progressInterval);
                    }
                }, 100);
            },
            
            startPolling() {
                this.pollingInterval = setInterval(async () => {
                    await this.checkStatus();
                }, 10000);
            },
            
            async checkStatus() {
                if (!this.registrationId) return;
                
                try {
                    const response = await fetch(`/api/check-registration-status/${this.registrationId}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (data.status === 'approved') {
                        this.progress = 100;
                        this.status = 'approved';
                        clearInterval(this.pollingInterval);
                        clearInterval(this.rotationInterval);
                        this.refreshIcons();
                        
                        setTimeout(() => {
                            window.location.href = '{{ route('register.success', $registration->id) }}';
                        }, 2000);
                    } else if (data.status === 'rejected') {
                        this.status = 'rejected';
                        this.rejectionReason = data.reason || 'El comprobante no pudo ser validado';
                        clearInterval(this.pollingInterval);
                        clearInterval(this.rotationInterval);
                        this.refreshIcons();
                        
                        setTimeout(() => {
                            window.location.href = '{{ route('register.rejected', $registration->id) }}';
                        }, 3000);
                    }
                } catch (error) {
                    console.error('Error checking status:', error);
                }
            },
            
            refreshIcons() {
                this.$nextTick(() => {
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                });
            },
            
            destroy() {
                if (this.pollingInterval) {
                    clearInterval(this.pollingInterval);
                }
                if (this.rotationInterval) {
                    clearInterval(this.rotationInterval);
                }
            }
        }));
    });

    // Inicializar iconos Lucide
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
    </script>
    
    <style>
    [x-cloak] { display: none !important; }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    /* Evitar que los SVG se superpongan durante las transiciones */
    .relative > div[x-cloak] {
        pointer-events: none;
    }
    
    .relative > div:not([x-cloak]) {
        pointer-events: auto;
        z-index: 1;
    }
    </style>
</body>
</html>
