<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Información del Negocio - Linkiu</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images-ui/favico_linkiu.svg') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Calendly Script -->
    <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50" x-data="formManager()">
    
    <div class="min-h-screen">
        {{-- Wizard Progress --}}
        <x-registration-wizard-navbar 
            :currentStep="2"
            :totalSteps="4"
            :showBackButton="true"
            :backRoute="route('register.step1')"
        />

        {{-- Content Area --}}
        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-slate-900 mb-3">Cuéntanos sobre tu Negocio</h2>
                <p class="text-base font-normal text-slate-600">Necesitamos verificar que tu negocio es real y cumple con nuestras políticas</p>
            </div>

            <form method="POST" action="{{ route('register.step2.store') }}" @submit="saveToLocalStorage()" class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                @csrf
                
                {{-- Sección: Categoría de Negocio --}}
                <div class="p-6 lg:p-8 border-b border-gray-200">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-accent-300/10 rounded-xl flex items-center justify-center">
                            <i data-lucide="briefcase" class="w-6 h-6 text-accent-300"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Categoría del Negocio</h3>
                            <p class="text-sm text-slate-600">Selecciona el tipo de negocio que mejor te representa</p>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">
                            ¿Qué tipo de negocio tienes? <span class="text-red-500">*</span>
                        </label>
                        <select name="business_category_id"
                                x-model="formData.business_category_id"
                                @change="saveToLocalStorage(); validateField('business_category_id')"
                                @blur="saveToLocalStorage()"
                                class="w-full px-4 py-3 border rounded-lg focus:border-accent-300 focus:ring-2 focus:ring-accent-300/20 focus:outline-none transition-colors @error('business_category_id') border-red-300 @enderror"
                                :class="fieldErrors.business_category_id ? 'border-red-300' : (formData.business_category_id ? 'border-green-300' : 'border-gray-200')"
                                required>
                            <option value="">Selecciona una categoría...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('business_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="flex items-center gap-2 mt-2">
                            <i data-lucide="info" class="w-4 h-4 text-slate-400"></i>
                            <p class="text-xs text-slate-600">Esto nos ayuda a configurar las herramientas adecuadas para tu negocio</p>
                        </div>
                        <div x-show="fieldErrors.business_category_id" x-cloak class="mt-2 flex items-center gap-2 text-sm text-red-600">
                            <i data-lucide="alert-circle" class="w-4 h-4"></i>
                            <span x-text="fieldErrors.business_category_id"></span>
                        </div>
                        @error('business_category_id')
                            <p class="text-sm text-red-600 mt-2 flex items-center gap-2">
                                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- Sección: Información Básica --}}
                <div class="p-6 lg:p-8 border-b border-gray-200">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-brand-200/10 rounded-xl flex items-center justify-center">
                            <i data-lucide="building" class="w-6 h-6 text-brand-200"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Información Básica</h3>
                            <p class="text-sm text-slate-600">Datos principales de tu negocio</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">
                                Nombre del Negocio <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text"
                                       name="business_name"
                                       x-model="formData.business_name"
                                       @input="debouncedSave(); validateField('business_name')"
                                       @blur="saveToLocalStorage()"
                                       class="w-full px-4 py-2.5 border rounded-lg focus:border-accent-300 focus:ring-2 focus:ring-accent-300/20 focus:outline-none transition-colors @error('business_name') border-red-300 @enderror"
                                       :class="fieldErrors.business_name ? 'border-red-300' : (formData.business_name && !fieldErrors.business_name ? 'border-green-300' : 'border-gray-200')"
                                       placeholder="Ej: Mi Negocio S.A.S"
                                       required>
                                <div x-show="formData.business_name && !fieldErrors.business_name" x-cloak class="absolute right-3 top-1/2 -translate-y-1/2">
                                    <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i>
                                </div>
                            </div>
                            <div x-show="fieldErrors.business_name" x-cloak class="mt-2 flex items-center gap-2 text-sm text-red-600">
                                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                <span x-text="fieldErrors.business_name"></span>
                            </div>
                            @error('business_name')
                                <p class="text-sm text-red-600 mt-2 flex items-center gap-2">
                                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">
                                Tipo de Documento <span class="text-red-500">*</span>
                            </label>
                            <select name="document_type"
                                    x-model="formData.document_type"
                                    @change="saveToLocalStorage(); validateField('document_type')"
                                    @blur="saveToLocalStorage()"
                                    class="w-full px-4 py-2.5 border rounded-lg focus:border-accent-300 focus:ring-2 focus:ring-accent-300/20 focus:outline-none transition-colors @error('document_type') border-red-300 @enderror"
                                    :class="fieldErrors.document_type ? 'border-red-300' : (formData.document_type ? 'border-green-300' : 'border-gray-200')"
                                    required>
                                <option value="">Seleccionar tipo...</option>
                                <option value="nit" {{ old('document_type') == 'nit' ? 'selected' : '' }}>NIT (Empresa)</option>
                                <option value="cc" {{ old('document_type') == 'cc' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                                <option value="ce" {{ old('document_type') == 'ce' ? 'selected' : '' }}>Cédula de Extranjería</option>
                            </select>
                            <div x-show="fieldErrors.document_type" x-cloak class="mt-2 flex items-center gap-2 text-sm text-red-600">
                                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                <span x-text="fieldErrors.document_type"></span>
                            </div>
                            @error('document_type')
                                <p class="text-sm text-red-600 mt-2 flex items-center gap-2">
                                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">
                                Número de Documento <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text"
                                       name="document_number"
                                       x-model="formData.document_number"
                                       @input="formatDocumentNumber(); debouncedSave(); validateField('document_number')"
                                       @blur="saveToLocalStorage()"
                                       class="w-full px-4 py-2.5 border rounded-lg focus:border-accent-300 focus:ring-2 focus:ring-accent-300/20 focus:outline-none transition-colors @error('document_number') border-red-300 @enderror"
                                       :class="fieldErrors.document_number ? 'border-red-300' : (formData.document_number && !fieldErrors.document_number ? 'border-green-300' : 'border-gray-200')"
                                       placeholder="123456789-0"
                                       maxlength="20"
                                       required>
                                <div x-show="formData.document_number && !fieldErrors.document_number" x-cloak class="absolute right-3 top-1/2 -translate-y-1/2">
                                    <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i>
                                </div>
                            </div>
                            <div x-show="fieldErrors.document_number" x-cloak class="mt-2 flex items-center gap-2 text-sm text-red-600">
                                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                <span x-text="fieldErrors.document_number"></span>
                            </div>
                            @error('document_number')
                                <p class="text-sm text-red-600 mt-2 flex items-center gap-2">
                                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">
                                Teléfono de Contacto <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="tel"
                                       name="phone"
                                       x-model="formData.phone"
                                       @input="formatPhone(); debouncedSave(); validateField('phone')"
                                       @blur="saveToLocalStorage()"
                                       class="w-full px-4 py-2.5 border rounded-lg focus:border-accent-300 focus:ring-2 focus:ring-accent-300/20 focus:outline-none transition-colors @error('phone') border-red-300 @enderror"
                                       :class="fieldErrors.phone ? 'border-red-300' : (formData.phone && !fieldErrors.phone ? 'border-green-300' : 'border-gray-200')"
                                       placeholder="300 123 4567"
                                       maxlength="20"
                                       required>
                                <div x-show="formData.phone && !fieldErrors.phone" x-cloak class="absolute right-3 top-1/2 -translate-y-1/2">
                                    <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i>
                                </div>
                            </div>
                            <div x-show="fieldErrors.phone" x-cloak class="mt-2 flex items-center gap-2 text-sm text-red-600">
                                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                <span x-text="fieldErrors.phone"></span>
                            </div>
                            @error('phone')
                                <p class="text-sm text-red-600 mt-2 flex items-center gap-2">
                                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">
                                Email de Contacto <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="email"
                                       name="email"
                                       x-model="formData.email"
                                       @input="debouncedSave(); validateField('email'); validateEmailExists()"
                                       @blur="saveToLocalStorage()"
                                       class="w-full px-4 py-2.5 pr-12 border rounded-lg focus:border-accent-300 focus:ring-2 focus:ring-accent-300/20 focus:outline-none transition-colors @error('email') border-red-300 @enderror"
                                       :class="fieldErrors.email ? 'border-red-300' : (formData.email && !fieldErrors.email && emailAvailable === true ? 'border-green-300' : (formData.email && !fieldErrors.email && emailAvailable === false ? 'border-red-300' : 'border-gray-200'))"
                                       placeholder="contacto@minegocio.com"
                                       required>
                                <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                    {{-- Spinner: Validando --}}
                                    <div x-show="validatingEmail && formData.email" x-cloak>
                                        <i data-lucide="loader-2" class="w-5 h-5 text-blue-500 animate-spin"></i>
                                    </div>
                                    
                                    {{-- Check: Disponible --}}
                                    <div x-show="formData.email && !validatingEmail && emailAvailable === true && !fieldErrors.email" x-cloak>
                                        <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i>
                                    </div>
                                    
                                    {{-- X: En uso --}}
                                    <div x-show="formData.email && !validatingEmail && emailAvailable === false && !fieldErrors.email" x-cloak>
                                        <i data-lucide="x-circle" class="w-5 h-5 text-red-500"></i>
                                    </div>
                                </div>
                            </div>
                            {{-- Error de formato --}}
                            <div x-show="fieldErrors.email && !validatingEmail" x-cloak class="mt-2 flex items-center gap-2 text-sm text-red-600">
                                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                <span x-text="fieldErrors.email"></span>
                            </div>
                            
                            {{-- Email en uso (no disponible) --}}
                            <div x-show="formData.email && !validatingEmail && emailAvailable === false && !fieldErrors.email" x-cloak class="mt-2 flex items-center gap-2 text-sm text-red-600">
                                <i data-lucide="x-circle" class="w-4 h-4"></i>
                                <span>Este email ya está en uso</span>
                            </div>
                            
                            {{-- Email disponible --}}
                            <div x-show="formData.email && !validatingEmail && emailAvailable === true && !fieldErrors.email" x-cloak class="mt-2 flex items-center gap-2 text-sm text-green-600">
                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                                <span>Email disponible</span>
                            </div>
                            
                            @error('email')
                                <p class="text-sm text-red-600 mt-2 flex items-center gap-2">
                                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">
                                Ciudad <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text"
                                       name="city"
                                       x-model="formData.city"
                                       @input="debouncedSave(); validateField('city')"
                                       @blur="saveToLocalStorage()"
                                       class="w-full px-4 py-2.5 border rounded-lg focus:border-accent-300 focus:ring-2 focus:ring-accent-300/20 focus:outline-none transition-colors @error('city') border-red-300 @enderror"
                                       :class="fieldErrors.city ? 'border-red-300' : (formData.city && !fieldErrors.city ? 'border-green-300' : 'border-gray-200')"
                                       placeholder="Ej: Medellín"
                                       required>
                                <div x-show="formData.city && !fieldErrors.city" x-cloak class="absolute right-3 top-1/2 -translate-y-1/2">
                                    <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i>
                                </div>
                            </div>
                            <div x-show="fieldErrors.city" x-cloak class="mt-2 flex items-center gap-2 text-sm text-red-600">
                                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                <span x-text="fieldErrors.city"></span>
                            </div>
                            @error('city')
                                <p class="text-sm text-red-600 mt-2 flex items-center gap-2">
                                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">
                                Departamento <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text"
                                       name="department"
                                       x-model="formData.department"
                                       @input="debouncedSave(); validateField('department')"
                                       @blur="saveToLocalStorage()"
                                       class="w-full px-4 py-2.5 border rounded-lg focus:border-accent-300 focus:ring-2 focus:ring-accent-300/20 focus:outline-none transition-colors @error('department') border-red-300 @enderror"
                                       :class="fieldErrors.department ? 'border-red-300' : (formData.department && !fieldErrors.department ? 'border-green-300' : 'border-gray-200')"
                                       placeholder="Ej: Antioquia"
                                       required>
                                <div x-show="formData.department && !fieldErrors.department" x-cloak class="absolute right-3 top-1/2 -translate-y-1/2">
                                    <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i>
                                </div>
                            </div>
                            <div x-show="fieldErrors.department" x-cloak class="mt-2 flex items-center gap-2 text-sm text-red-600">
                                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                <span x-text="fieldErrors.department"></span>
                            </div>
                            @error('department')
                                <p class="text-sm text-red-600 mt-2 flex items-center gap-2">
                                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">
                                Dirección Física <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text"
                                       name="address"
                                       x-model="formData.address"
                                       @input="debouncedSave(); validateField('address')"
                                       @blur="saveToLocalStorage()"
                                       class="w-full px-4 py-2.5 border rounded-lg focus:border-accent-300 focus:ring-2 focus:ring-accent-300/20 focus:outline-none transition-colors @error('address') border-red-300 @enderror"
                                       :class="fieldErrors.address ? 'border-red-300' : (formData.address && !fieldErrors.address ? 'border-green-300' : 'border-gray-200')"
                                       placeholder="Ej: Calle 123 #45-67"
                                       required>
                                <div x-show="formData.address && !fieldErrors.address" x-cloak class="absolute right-3 top-1/2 -translate-y-1/2">
                                    <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i>
                                </div>
                            </div>
                            <div x-show="fieldErrors.address" x-cloak class="mt-2 flex items-center gap-2 text-sm text-red-600">
                                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                <span x-text="fieldErrors.address"></span>
                            </div>
                            @error('address')
                                <p class="text-sm text-red-600 mt-2 flex items-center gap-2">
                                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!--<div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-900 mb-2">
                                Descripción del Negocio <span class="text-xs font-normal text-slate-500">(Opcional)</span>
                            </label>
                            <div class="relative">
                                <textarea name="description"
                                          x-model="formData.description"
                                          @input="debouncedSave()"
                                          @blur="saveToLocalStorage()"
                                          rows="3"
                                          maxlength="500"
                                          class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-accent-300 focus:ring-2 focus:ring-accent-300/20 focus:outline-none transition-colors @error('description') border-red-300 @enderror"
                                          placeholder="Describe brevemente tu negocio, productos o servicios..."></textarea>
                                <div class="absolute bottom-2 right-2 text-xs text-slate-400">
                                    <span x-text="(formData.description || '').length"></span>/500
                                </div>
                            </div>
                            @error('description')
                                <p class="text-sm text-red-600 mt-2 flex items-center gap-2">
                                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>-->
                    </div>
                </div>

                {{-- Sección: Verificación de Documentos --}}
                <div class="p-6 lg:p-8 bg-accent-300/5 border-t border-accent-300/10">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-accent-300/10 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i data-lucide="shield-check" class="w-6 h-6 text-accent-300"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-base text-slate-900 mb-1">Verificación de Seguridad</h4>
                            <p class="text-sm text-slate-600">
                                La información proporcionada será verificada para garantizar la autenticidad de tu negocio. 
                                Este proceso ayuda a mantener nuestra plataforma segura para todos.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Botones de Navegación --}}
                <div class="p-6 lg:p-8 bg-slate-50 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('register.step1') }}" 
                       class="px-6 py-2.5 bg-white border border-gray-200 text-slate-600 rounded-lg font-medium hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Paso Anterior
                    </a>
                    <button type="submit" 
                            onclick="fbq('track', 'Lead');"
                            class="px-8 py-2.5 bg-accent-300 hover:bg-accent-400 text-white rounded-lg font-semibold transition-colors flex items-center justify-center gap-2">
                        <span>Continuar al Paso 3</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
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
        Alpine.data('formManager', () => ({
            calendlyOpen: false,
            saveStatus: 'idle', // idle, saving, saved, error
            formData: {
                business_category_id: '',
                business_name: '',
                document_type: '',
                document_number: '',
                phone: '',
                email: '',
                city: '',
                department: '',
                address: '',
                description: ''
            },
            fieldErrors: {},
            saveTimeout: null,
            emailValidationTimeout: null,
            validatingEmail: false,
            emailAvailable: null,

            init() {
                // Cargar datos guardados
                this.loadFromLocalStorage();
                
                // Restaurar valores de old() si existen
                @if(old('business_category_id'))
                    this.formData.business_category_id = '{{ old('business_category_id') }}';
                @endif
                @if(old('business_name'))
                    this.formData.business_name = '{{ old('business_name') }}';
                @endif
                @if(old('document_type'))
                    this.formData.document_type = '{{ old('document_type') }}';
                @endif
                @if(old('document_number'))
                    this.formData.document_number = '{{ old('document_number') }}';
                @endif
                @if(old('phone'))
                    this.formData.phone = '{{ old('phone') }}';
                @endif
                @if(old('email'))
                    this.formData.email = '{{ old('email') }}';
                @endif
                @if(old('city'))
                    this.formData.city = '{{ old('city') }}';
                @endif
                @if(old('department'))
                    this.formData.department = '{{ old('department') }}';
                @endif
                @if(old('address'))
                    this.formData.address = '{{ old('address') }}';
                @endif
                @if(old('description'))
                    this.formData.description = '{{ old('description') }}';
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
                        step: 2,
                        formData: this.formData,
                        timestamp: new Date().toISOString()
                    };
                    localStorage.setItem('registration_step2', JSON.stringify(data));
                } catch (error) {
                    console.error('Error guardando datos:', error);
                }
            },

            debouncedSave() {
                // Limpiar timeout anterior
                if (this.saveTimeout) {
                    clearTimeout(this.saveTimeout);
                }
                // Guardar después de 1.5 segundos de inactividad
                this.saveTimeout = setTimeout(() => {
                    this.saveToLocalStorage();
                }, 1500);
            },

            async validateEmailExists() {
                if (!this.formData.email) {
                    this.fieldErrors.email = '';
                    this.emailAvailable = null;
                    this.validatingEmail = false;
                    return;
                }

                // Validar formato primero
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(this.formData.email)) {
                    this.fieldErrors.email = 'Ingresa un email válido';
                    this.emailAvailable = null;
                    this.validatingEmail = false;
                    return;
                }

                // Limpiar timeout anterior para evitar múltiples peticiones
                if (this.emailValidationTimeout) {
                    clearTimeout(this.emailValidationTimeout);
                }

                // Limpiar estados anteriores
                this.fieldErrors.email = '';
                this.emailAvailable = null;

                // Esperar 1 segundo después de que el usuario deje de escribir
                this.emailValidationTimeout = setTimeout(async () => {
                    this.validatingEmail = true;
                    
                    try {
                        const response = await fetch('{{ route('api.validate-registration-email') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                email: this.formData.email
                            })
                        });

                        const data = await response.json();

                        if (!data.available) {
                            // Email no disponible
                            this.emailAvailable = false;
                            this.fieldErrors.email = '';
                        } else {
                            // Email disponible
                            this.emailAvailable = true;
                            this.fieldErrors.email = '';
                        }
                    } catch (error) {
                        console.error('Error validando email:', error);
                        this.emailAvailable = false;
                        this.fieldErrors.email = 'Error al verificar la disponibilidad';
                    } finally {
                        this.validatingEmail = false;
                    }
                }, 1000);
            },

            loadFromLocalStorage() {
                try {
                    const saved = localStorage.getItem('registration_step2');
                    if (saved) {
                        const data = JSON.parse(saved);
                        // Solo cargar si no hay valores de old()
                        if (data.formData) {
                            Object.keys(this.formData).forEach(key => {
                                if (!this.formData[key] && data.formData[key]) {
                                    this.formData[key] = data.formData[key];
                                }
                            });
                        }
                    }
                } catch (error) {
                    console.error('Error cargando datos:', error);
                }
            },

            formatPhone() {
                // Formatear teléfono sin indicativo (solo números y espacios)
                let phone = this.formData.phone.replace(/\D/g, '');
                // Remover el 57 si está al inicio (indicativo colombiano)
                if (phone.startsWith('57') && phone.length > 10) {
                    phone = phone.substring(2);
                }
                // Formatear con espacios cada 3 dígitos
                if (phone.length > 3) {
                    phone = phone.substring(0, 3) + ' ' + phone.substring(3);
                }
                if (phone.length > 7) {
                    phone = phone.substring(0, 7) + ' ' + phone.substring(7);
                }
                if (phone.length > 12) {
                    phone = phone.substring(0, 12);
                }
                this.formData.phone = phone;
            },

            formatDocumentNumber() {
                // Formatear NIT con guión
                if (this.formData.document_type === 'nit') {
                    let doc = this.formData.document_number.replace(/\D/g, '');
                    if (doc.length > 9) {
                        doc = doc.substring(0, 9) + '-' + doc.substring(9, 10);
                    }
                    this.formData.document_number = doc.substring(0, 11);
                } else {
                    // Solo números para CC y CE
                    this.formData.document_number = this.formData.document_number.replace(/\D/g, '');
                }
            },

            async validateField(fieldName) {
                this.fieldErrors[fieldName] = '';
                
                switch(fieldName) {
                    case 'business_name':
                        if (!this.formData.business_name || this.formData.business_name.length < 3) {
                            this.fieldErrors.business_name = 'El nombre debe tener al menos 3 caracteres';
                        }
                        break;
                    case 'email':
                        // Solo validar formato aquí, la validación de existencia se hace en validateEmailExists
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(this.formData.email)) {
                            this.fieldErrors.email = 'Ingresa un email válido';
                        } else {
                            // Validar contra la base de datos con debounce
                            this.validateEmailExists();
                        }
                        break;
                    case 'phone':
                        const phoneClean = this.formData.phone.replace(/\D/g, '');
                        if (phoneClean.length < 10) {
                            this.fieldErrors.phone = 'El teléfono debe tener al menos 10 dígitos';
                        }
                        break;
                    case 'document_number':
                        if (!this.formData.document_number || this.formData.document_number.length < 5) {
                            this.fieldErrors.document_number = 'El número de documento es requerido';
                        }
                        break;
                    case 'city':
                        if (!this.formData.city || this.formData.city.length < 2) {
                            this.fieldErrors.city = 'La ciudad es requerida';
                        }
                        break;
                    case 'department':
                        if (!this.formData.department || this.formData.department.length < 2) {
                            this.fieldErrors.department = 'El departamento es requerido';
                        }
                        break;
                    case 'address':
                        if (!this.formData.address || this.formData.address.length < 5) {
                            this.fieldErrors.address = 'La dirección debe tener al menos 5 caracteres';
                        }
                        break;
                }
            },

            destroy() {
                if (this.saveTimeout) {
                    clearTimeout(this.saveTimeout);
                }
                if (this.emailValidationTimeout) {
                    clearTimeout(this.emailValidationTimeout);
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
