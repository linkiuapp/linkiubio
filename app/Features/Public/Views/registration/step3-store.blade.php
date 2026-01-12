<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Configuración de Tienda - Linkiu</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images-ui/favico_linkiu.svg') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Calendly Script -->
    <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50" x-data="storeConfig()">
    
    <div class="min-h-screen">
        {{-- Wizard Progress --}}
        <x-registration-wizard-navbar 
            :currentStep="3"
            :totalSteps="4"
            :showBackButton="true"
            :backRoute="route('register.step2')"
        />

        {{-- Content Area --}}
        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-slate-900 mb-3">Configura tu Tienda Online</h2>
                <p class="text-base font-normal text-slate-600">Personaliza la identidad de tu tienda</p>
            </div>

            <form method="POST" action="{{ route('register.step3.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    
                    {{-- Sección: Identidad de la Tienda --}}
                    <div class="p-3 lg:p-8 border-b border-gray-200">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-accent-300/10 rounded-xl flex items-center justify-center">
                                <i data-lucide="store" class="w-6 h-6 text-accent-300"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">Identidad de tu Tienda</h3>
                                <p class="text-sm text-slate-600">Define el nombre y la URL de tu tienda</p>
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">
                                    Nombre de la Tienda <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text"
                                           name="store_name"
                                           x-model="storeName"
                                           @input="generateSlug(); debouncedSave(); validateStoreName()"
                                           @blur="saveToLocalStorage()"
                                           value="{{ old('store_name') }}"
                                           class="w-full px-4 py-3 pr-12 border rounded-lg focus-none transition-colors @error('store_name') border-red-300 @enderror"
                                           :class="fieldErrors.store_name ? 'border-red-300' : (storeName && !fieldErrors.store_name && storeNameAvailable === true ? 'border-green-300' : (storeName && !fieldErrors.store_name && storeNameAvailable === false ? 'border-red-300' : 'border-gray-200'))"
                                           placeholder="Ej: Mi Tienda Online"
                                           required>
                                    
                                    {{-- Icono de validación dentro del input --}}
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                        {{-- Spinner: Validando --}}
                                        <div x-show="validatingStoreName && storeName" x-cloak>
                                            <i data-lucide="loader-2" class="w-5 h-5 text-blue-500 animate-spin"></i>
                                        </div>
                                        
                                        {{-- Check: Disponible --}}
                                        <div x-show="storeName && !validatingStoreName && storeNameAvailable === true && !fieldErrors.store_name" x-cloak>
                                            <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i>
                                        </div>
                                        
                                        {{-- X: En uso --}}
                                        <div x-show="storeName && !validatingStoreName && storeNameAvailable === false && !fieldErrors.store_name" x-cloak>
                                            <i data-lucide="x-circle" class="w-5 h-5 text-red-500"></i>
                                        </div>
                                        
                                        {{-- Error de formato --}}
                                        <div x-show="fieldErrors.store_name && !validatingStoreName" x-cloak>
                                            <i data-lucide="alert-circle" class="w-5 h-5 text-red-500"></i>
                                        </div>
                                    </div>
                                </div>
                                {{-- Mensajes de validación debajo del input --}}
                                {{-- Error de formato --}}
                                <div x-show="fieldErrors.store_name && !validatingStoreName" x-cloak class="mt-2 flex items-center gap-2 text-sm text-red-600">
                                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                    <span x-text="fieldErrors.store_name"></span>
                                </div>
                                
                                {{-- Nombre en uso (no disponible) --}}
                                <div x-show="storeName && !validatingStoreName && storeNameAvailable === false && !fieldErrors.store_name" x-cloak class="mt-2 flex items-center gap-2 text-sm text-red-600">
                                    <i data-lucide="x-circle" class="w-4 h-4"></i>
                                    <span>Este nombre ya está en uso</span>
                                </div>
                                
                                {{-- Nombre disponible --}}
                                <div x-show="storeName && !validatingStoreName && storeNameAvailable === true && !fieldErrors.store_name" x-cloak class="mt-2 flex items-center gap-2 text-sm text-green-600">
                                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                                    <span>Nombre disponible</span>
                                </div>
                                @error('store_name')
                                    <p class="text-sm text-red-600 mt-2 flex items-center gap-2">
                                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">
                                    URL de tu Tienda <span class="text-red-500">*</span>
                                </label>
                                
                                {{-- Preview del navegador con input editable --}}
                                <div class="mb-4">
                                    <div class="bg-white rounded-lg border-2 border-gray-200 overflow-hidden shadow-lg"
                                         :class="fieldErrors.slug ? 'border-red-300' : (slug && !fieldErrors.slug && slugAvailable === true ? 'border-green-300' : (slug && !fieldErrors.slug && slugAvailable === false ? 'border-red-300' : 'border-gray-200'))">
                                        {{-- Barra superior del navegador --}}
                                        <div class="bg-gray-50 px-3 sm:px-4 py-2 sm:py-3 flex items-center gap-2 sm:gap-3 border-b border-gray-200">
                                            {{-- Botones del navegador (macOS style) --}}
                                            <div class="flex gap-1.5 sm:gap-2 flex-shrink-0">
                                                <div class="w-2.5 h-2.5 sm:w-3 sm:h-3 bg-red-500 rounded-full"></div>
                                                <div class="w-2.5 h-2.5 sm:w-3 sm:h-3 bg-yellow-500 rounded-full"></div>
                                                <div class="w-2.5 h-2.5 sm:w-3 sm:h-3 bg-green-500 rounded-full"></div>
                                            </div>
                                            {{-- Barra de direcciones editable --}}
                                            <div class="flex-1 relative min-w-0">
                                                <div class="flex items-center gap-1 sm:gap-2 bg-white rounded-md px-2 sm:px-3 lg:px-4 py-1.5 sm:py-2 border border-gray-300 shadow-sm focus-within:border-blue-300 transition-colors"
                                                     :class="fieldErrors.slug ? 'border-red-300' : (slug && !fieldErrors.slug && slugAvailable === true ? 'border-green-300' : (slug && !fieldErrors.slug && slugAvailable === false ? 'border-red-300' : 'border-gray-300'))">
                                                    <i data-lucide="lock" class="w-3 h-3 sm:w-4 sm:h-4 text-gray-600 flex-shrink-0"></i>
                                                    <span class="text-sm sm:text-sm text-gray-600 font-mono whitespace-nowrap hidden sm:inline">https://linkiu.bio/</span>
                                                    <span class="text-sm sm:text-sm text-gray-600 font-mono whitespace-nowrap sm:hidden">linkiu.bio/</span>
                                                    <input type="text"
                                                           name="slug"
                                                           x-model="slug"
                                                           @input="onSlugInput(); debouncedSave(); validateSlug()"
                                                           @blur="saveToLocalStorage()"
                                                           value="{{ old('slug') }}"
                                                           class="flex-1 min-w-0 pl-0 text-sm sm:text-sm lg:text-base text-gray-800 font-mono font-semibold bg-transparent border-0 outline-none focus:outline-none"
                                                           placeholder="tu-tienda"
                                                           pattern="[a-z0-9-]+"
                                                           required>
                                                    
                                                    {{-- Icono de validación dentro de la barra de direcciones --}}
                                                    <div class="flex-shrink-0 ml-1 sm:ml-2">
                                                        {{-- Spinner: Validando --}}
                                                        <div x-show="validatingSlug && slug" x-cloak>
                                                            <i data-lucide="loader-2" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-blue-500 animate-spin"></i>
                                                        </div>
                                                        
                                                        {{-- Check: Disponible --}}
                                                        <div x-show="slug && !validatingSlug && slugAvailable === true && !fieldErrors.slug" x-cloak>
                                                            <i data-lucide="check-circle" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-green-500"></i>
                                                        </div>
                                                        
                                                        {{-- X: En uso --}}
                                                        <div x-show="slug && !validatingSlug && slugAvailable === false && !fieldErrors.slug" x-cloak>
                                                            <i data-lucide="x-circle" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-red-500"></i>
                                                        </div>
                                                        
                                                        {{-- Error de formato --}}
                                                        <div x-show="fieldErrors.slug && !validatingSlug" x-cloak>
                                                            <i data-lucide="alert-circle" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-red-500"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Contenido del preview --}}
                                        <div class="p-3 sm:p-4 lg:p-6 bg-white">
                                            <div class="flex items-center gap-2 sm:gap-3 lg:gap-4 mb-3 sm:mb-4">
                                                <div class="w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16 bg-gray-200 rounded-xl flex-shrink-0"></div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="h-4 sm:h-5 bg-gray-300 rounded w-3/4 mb-1.5 sm:mb-2"></div>
                                                    <div class="h-3 sm:h-4 bg-gray-200 rounded w-1/2"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <p class="text-xs text-slate-600 mt-2 flex items-center gap-2">
                                    <i data-lucide="info" class="w-4 h-4"></i>
                                    Solo letras minúsculas, números y guiones. Sin espacios ni caracteres especiales.
                                </p>
                                
                                {{-- Mensajes de validación debajo del wireframe --}}
                                {{-- Error de formato --}}
                                <div x-show="fieldErrors.slug && !validatingSlug" x-cloak class="mt-2 flex items-center gap-2 text-sm text-red-600">
                                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                    <span x-text="fieldErrors.slug"></span>
                                </div>
                                
                                {{-- Slug en uso (no disponible) --}}
                                <div x-show="slug && !validatingSlug && slugAvailable === false && !fieldErrors.slug" x-cloak class="mt-2 flex items-center gap-2 text-sm text-red-600">
                                    <i data-lucide="x-circle" class="w-4 h-4"></i>
                                    <span>Esta URL ya está en uso</span>
                                </div>
                                
                                {{-- Slug disponible --}}
                                <div x-show="slug && !validatingSlug && slugAvailable === true && !fieldErrors.slug" x-cloak class="mt-2 flex items-center gap-2 text-sm text-green-600">
                                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                                    <span>URL disponible</span>
                                </div>
                                
                                @error('slug')
                                    <p class="text-sm text-red-600 mt-2 flex items-center gap-2">
                                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Botones de Navegación --}}
                    <div class="p-6 lg:p-8 bg-slate-50 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('register.step2') }}" 
                           class="px-6 py-2.5 bg-white border border-gray-200 text-slate-600 rounded-lg font-medium hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            Paso Anterior
                        </a>
                        <button type="submit" 
                                onclick="fbq('track', 'Lead');"
                                class="px-8 py-2.5 bg-accent-300 hover:bg-accent-400 text-white rounded-lg font-semibold transition-colors flex items-center justify-center gap-2">
                            <span>Continuar al Paso 4</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </form>
        </main>
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
    document.addEventListener('alpine:init', () => {
        Alpine.data('storeConfig', () => ({
            calendlyOpen: false,
            storeName: '{{ old('store_name') }}',
            slug: '{{ old('slug') }}',
            storeDescription: '{{ old('store_description') }}',
            slugManuallyEdited: {{ old('slug') ? 'true' : 'false' }},
            slugAvailable: null,
            validatingSlug: false,
            storeNameAvailable: null,
            validatingStoreName: false,
            fieldErrors: {},
            saveTimeout: null,
            slugValidationTimeout: null,
            storeNameValidationTimeout: null,

            init() {
                // Cargar datos guardados
                this.loadFromLocalStorage();
                
                // Restaurar valores de old() si existen
                @if(old('store_name'))
                    this.storeName = '{{ old('store_name') }}';
                @endif
                @if(old('slug'))
                    this.slug = '{{ old('slug') }}';
                @endif
                @if(old('store_description'))
                    this.storeDescription = '{{ old('store_description') }}';
                @endif

                // Inicializar iconos
                this.$nextTick(() => {
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                });
            },

            saveToLocalStorage() {
                try {
                    const data = {
                        step: 3,
                        formData: {
                            store_name: this.storeName,
                            slug: this.slug,
                            store_description: this.storeDescription
                        },
                        timestamp: new Date().toISOString()
                    };
                    localStorage.setItem('registration_step3', JSON.stringify(data));
                } catch (error) {
                    console.error('Error guardando datos:', error);
                }
            },

            loadFromLocalStorage() {
                try {
                    const saved = localStorage.getItem('registration_step3');
                    if (saved) {
                        const data = JSON.parse(saved);
                        if (data.formData) {
                            if (!this.storeName && data.formData.store_name) {
                                this.storeName = data.formData.store_name;
                            }
                            if (!this.slug && data.formData.slug) {
                                this.slug = data.formData.slug;
                            }
                            if (!this.storeDescription && data.formData.store_description) {
                                this.storeDescription = data.formData.store_description;
                            }
                        }
                    }
                } catch (error) {
                    console.error('Error cargando datos:', error);
                }
            },

            debouncedSave() {
                if (this.saveTimeout) {
                    clearTimeout(this.saveTimeout);
                }
                this.saveTimeout = setTimeout(() => {
                    this.saveToLocalStorage();
                }, 1500);
            },
            
            generateSlug() {
                // Solo auto-generar si el usuario no ha editado manualmente el slug
                if (!this.storeName || this.slugManuallyEdited) return;
                
                this.slug = this.storeName
                    .toLowerCase()
                    .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // Eliminar acentos
                    .replace(/[^a-z0-9\s-]/g, '') // Solo letras, números, espacios y guiones
                    .trim()
                    .replace(/\s+/g, '-') // Espacios a guiones
                    .replace(/-+/g, '-') // Múltiples guiones a uno
                    .slice(0, 50); // Limitar longitud
                
                // Validar slug después de generarlo
                if (this.slug) {
                    this.validateSlug();
                }
            },
            
            onSlugInput() {
                // Marcar que el usuario editó manualmente el slug
                this.slugManuallyEdited = true;
            },

            async validateSlug() {
                if (!this.slug) {
                    this.fieldErrors.slug = '';
                    this.slugAvailable = null;
                    this.validatingSlug = false;
                    return;
                }

                // Validar formato primero
                if (!/^[a-z0-9-]+$/.test(this.slug)) {
                    this.fieldErrors.slug = 'Solo se permiten letras minúsculas, números y guiones';
                    this.slugAvailable = null;
                    this.validatingSlug = false;
                    return;
                }

                if (this.slug.startsWith('-') || this.slug.endsWith('-')) {
                    this.fieldErrors.slug = 'La URL no puede comenzar o terminar con guión';
                    this.slugAvailable = null;
                    this.validatingSlug = false;
                    return;
                }

                // Limpiar timeout anterior
                if (this.slugValidationTimeout) {
                    clearTimeout(this.slugValidationTimeout);
                }

                // Limpiar estados anteriores
                this.fieldErrors.slug = '';
                this.slugAvailable = null;

                // Esperar 500ms después de que el usuario deje de escribir
                this.slugValidationTimeout = setTimeout(async () => {
                    this.validatingSlug = true;
                    
                    try {
                        const response = await fetch('{{ route('api.validate-registration-slug') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                slug: this.slug
                            })
                        });

                        const data = await response.json();

                        if (!data.available) {
                            // URL no disponible
                            this.slugAvailable = false;
                            this.fieldErrors.slug = '';
                        } else {
                            // URL disponible
                            this.slugAvailable = true;
                            this.fieldErrors.slug = '';
                        }
                    } catch (error) {
                        console.error('Error validando slug:', error);
                        this.slugAvailable = false;
                        this.fieldErrors.slug = 'Error al verificar la disponibilidad';
                    } finally {
                        this.validatingSlug = false;
                    }
                }, 500);
            },

            async validateStoreName() {
                if (!this.storeName) {
                    this.fieldErrors.store_name = '';
                    this.storeNameAvailable = null;
                    this.validatingStoreName = false;
                    return;
                }

                // Validar formato primero
                if (this.storeName.trim().length < 3) {
                    this.fieldErrors.store_name = 'El nombre debe tener al menos 3 caracteres';
                    this.storeNameAvailable = null;
                    this.validatingStoreName = false;
                    return;
                }

                // Limpiar timeout anterior
                if (this.storeNameValidationTimeout) {
                    clearTimeout(this.storeNameValidationTimeout);
                }

                // Limpiar estados anteriores
                this.fieldErrors.store_name = '';
                this.storeNameAvailable = null;

                // Esperar 500ms después de que el usuario deje de escribir
                this.storeNameValidationTimeout = setTimeout(async () => {
                    this.validatingStoreName = true;
                    
                    try {
                        const response = await fetch('{{ route('api.validate-registration-store-name') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                store_name: this.storeName
                            })
                        });

                        const data = await response.json();

                        if (!data.available) {
                            // Nombre no disponible
                            this.storeNameAvailable = false;
                            this.fieldErrors.store_name = data.message;
                        } else {
                            // Nombre disponible
                            this.storeNameAvailable = true;
                            this.fieldErrors.store_name = '';
                        }
                    } catch (error) {
                        console.error('Error validando nombre de tienda:', error);
                        this.storeNameAvailable = false;
                        this.fieldErrors.store_name = 'Error al verificar la disponibilidad';
                    } finally {
                        this.validatingStoreName = false;
                    }
                }, 500);
            },

            validateField(fieldName) {
                this.fieldErrors[fieldName] = '';
                
                switch(fieldName) {
                    case 'store_name':
                        if (!this.storeName || this.storeName.length < 3) {
                            this.fieldErrors.store_name = 'El nombre debe tener al menos 3 caracteres';
                        }
                        break;
                }
            },

            destroy() {
                if (this.saveTimeout) {
                    clearTimeout(this.saveTimeout);
                }
                if (this.slugValidationTimeout) {
                    clearTimeout(this.slugValidationTimeout);
                }
                if (this.storeNameValidationTimeout) {
                    clearTimeout(this.storeNameValidationTimeout);
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
    </style>
</body>
</html>
