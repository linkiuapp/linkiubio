<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Información del Propietario - Linkiu</title>
    
    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('images-ui/favico_linkiu.svg') }}">
    
    {{-- Calendly Script --}}
    <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50" x-data="ownerForm()">
    
    <div class="min-h-screen">
        {{-- Nuevo Navbar de Registro --}}
        <x-registration-wizard-navbar :currentStep="4" :totalSteps="4" :showBackButton="true" :backRoute="route('register.step3')"/>

        {{-- Content Area --}}
        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center mb-8">
                <h2 class="text-xl font-bold text-slate-900 mb-3">¡Último Paso!</h2>
                <p class="text-base font-normal text-gray-600">Crea tu cuenta de administrador</p>
            </div>

            <form method="POST" :action="paymentMethod === 'epayco' ? '{{ route('register.payment.initiate') }}' : '{{ route('register.complete') }}'" 
                  enctype="multipart/form-data" 
                  @submit.prevent="handleSubmit"
                  novalidate>
                @csrf
                
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    
                    {{-- Sección: Datos Personales --}}
                    <div class="p-6 lg:p-8 border-b border-gray-200">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-accent-300/10 rounded-xl flex items-center justify-center">
                                <i data-lucide="user" class="w-6 h-6 text-accent-300"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">Datos Personales</h3>
                                <p class="text-sm text-slate-600">Información del propietario de la tienda</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Nombre Completo <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       name="owner_name"
                                       x-model="ownerName"
                                       @input="debouncedSave()"
                                       @blur="saveToLocalStorage()"
                                       value="{{ old('owner_name') }}"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-accent-300 focus:ring-2 focus:ring-accent-300/20 focus:outline-none @error('owner_name') border-red-300 @enderror text-base transition-colors"
                                       placeholder="Juan Pérez"
                                       required>
                                @error('owner_name')
                                    <p class="text-xs font-normal text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Correo Electrónico <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="email"
                                           name="owner_email"
                                           x-model="ownerEmail"
                                           @input="debouncedSave(); validateOwnerEmail()"
                                           @blur="saveToLocalStorage()"
                                           value="{{ old('owner_email') }}"
                                           class="w-full px-4 py-3 pr-12 border border-gray-200 rounded-lg focus:border-accent-300 focus:ring-2 focus:ring-accent-300/20 focus:outline-none @error('owner_email') border-red-300 @enderror text-base transition-colors"
                                           :class="ownerEmail && !validatingOwnerEmail && ownerEmailAvailable === true ? 'border-green-300' : (ownerEmail && !validatingOwnerEmail && ownerEmailAvailable === false ? 'border-red-300' : '')"
                                           placeholder="tu@email.com"
                                           required>
                                    
                                    {{-- Icono de validación dentro del input --}}
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                        {{-- Spinner: Validando --}}
                                        <div x-show="validatingOwnerEmail && ownerEmail" x-cloak>
                                            <i data-lucide="loader-2" class="w-5 h-5 text-blue-500 animate-spin"></i>
                                        </div>
                                        
                                        {{-- Check: Disponible --}}
                                        <div x-show="ownerEmail && !validatingOwnerEmail && ownerEmailAvailable === true" x-cloak>
                                            <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i>
                                        </div>
                                        
                                        {{-- X: En uso --}}
                                        <div x-show="ownerEmail && !validatingOwnerEmail && ownerEmailAvailable === false" x-cloak>
                                            <i data-lucide="x-circle" class="w-5 h-5 text-red-500"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-xs font-normal text-slate-600 mt-1">Usarás este correo para iniciar sesión</p>
                                
                                {{-- Mensajes de validación --}}
                                <div x-show="ownerEmail && !validatingOwnerEmail && ownerEmailAvailable === false" x-cloak class="mt-2 flex items-center gap-2 text-sm text-red-600">
                                    <i data-lucide="x-circle" class="w-4 h-4"></i>
                                    <span>Este correo ya está en uso</span>
                                </div>
                                
                                <div x-show="ownerEmail && !validatingOwnerEmail && ownerEmailAvailable === true" x-cloak class="mt-2 flex items-center gap-2 text-sm text-green-600">
                                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                                    <span>Correo disponible</span>
                                </div>
                                @error('owner_email')
                                    <p class="text-xs font-normal text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Tipo de Documento <span class="text-red-500">*</span>
                                </label>
                                <select name="owner_document_type"
                                        x-model="ownerDocumentType"
                                        @change="saveToLocalStorage()"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-accent-300 focus:ring-2 focus:ring-accent-300/20 focus:outline-none @error('owner_document_type') border-red-300 @enderror text-base transition-colors"
                                        required>
                                    <option value="">Seleccionar tipo</option>
                                    <option value="cc" {{ old('owner_document_type') == 'cc' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                                    <option value="ce" {{ old('owner_document_type') == 'ce' ? 'selected' : '' }}>Cédula de Extranjería</option>
                                    <option value="passport" {{ old('owner_document_type') == 'passport' ? 'selected' : '' }}>Pasaporte</option>
                                </select>
                                @error('owner_document_type')
                                    <p class="text-xs font-normal text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Número de Documento <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       name="owner_document_number"
                                       x-model="ownerDocumentNumber"
                                       @input="debouncedSave()"
                                       @blur="saveToLocalStorage()"
                                       value="{{ old('owner_document_number') }}"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-accent-300 focus:ring-2 focus:ring-accent-300/20 focus:outline-none @error('owner_document_number') border-red-300 @enderror text-base transition-colors"
                                       placeholder="1234567890"
                                       required>
                                @error('owner_document_number')
                                    <p class="text-xs font-normal text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Sección: Credenciales de Acceso --}}
                    <div class="p-6 lg:p-8 border-b border-gray-200">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-accent-300/10 rounded-xl flex items-center justify-center">
                                <i data-lucide="key" class="w-6 h-6 text-accent-300"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">Credenciales de Acceso</h3>
                                <p class="text-sm text-slate-600">Crea tu contraseña para acceder a tu tienda</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Contraseña <span class="text-red-500">*</span>
                                </label>
                                <input type="password"
                                       name="password"
                                       x-model="password"
                                       @input="debouncedSave()"
                                       @blur="saveToLocalStorage()"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-accent-300 focus:ring-2 focus:ring-accent-300/20 focus:outline-none @error('password') border-red-300 @enderror text-base transition-colors"
                                       :class="password && password.length >= 8 ? 'border-green-300' : ''"
                                       placeholder="••••••••"
                                       minlength="8"
                                       required>
                                <p class="text-xs font-normal text-slate-600 mt-1">Mínimo 8 caracteres</p>
                                @error('password')
                                    <p class="text-xs font-normal text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Confirmar Contraseña <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password"
                                           name="password_confirmation"
                                           x-model="passwordConfirmation"
                                           @input="debouncedSave()"
                                           @blur="saveToLocalStorage()"
                                           class="w-full px-4 py-3 pr-12 border border-gray-200 rounded-lg focus:border-accent-300 focus:ring-2 focus:ring-accent-300/20 focus:outline-none text-base transition-colors"
                                           :class="passwordConfirmation && passwordsMatch() ? 'border-green-300' : (passwordConfirmation && !passwordsMatch() ? 'border-red-300' : '')"
                                           placeholder="••••••••"
                                           minlength="8"
                                           required>
                                    
                                    {{-- Icono de validación --}}
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                        <div x-show="passwordConfirmation && passwordsMatch()" x-cloak>
                                            <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i>
                                        </div>
                                        <div x-show="passwordConfirmation && !passwordsMatch()" x-cloak>
                                            <i data-lucide="x-circle" class="w-5 h-5 text-red-500"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-xs font-normal mt-1" :class="passwordsMatch() ? 'text-green-600' : 'text-slate-600'">
                                    <template x-if="password && passwordConfirmation">
                                        <span x-show="passwordsMatch()" class="flex items-center gap-1">
                                            <i data-lucide="check-circle" class="w-3 h-3"></i>
                                            Las contraseñas coinciden
                                        </span>
                                        <span x-show="!passwordsMatch()" class="flex items-center gap-1 text-red-600">
                                            <i data-lucide="alert-circle" class="w-3 h-3"></i>
                                            Las contraseñas no coinciden
                                        </span>
                                    </template>
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Sección: Método de Pago --}}
                    {{-- Sección: Período de Prueba Gratuito (cuando skip_payment_on_trial es true) --}}
                    @if($skipPayment ?? false)
                    <div class="p-6 lg:p-8 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                        <div class="flex flex-col lg:flex-row items-start gap-4">
                            <div class="flex-shrink-0 order-1 lg:order-none">
                                <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center">
                                    <i data-lucide="gift" class="w-6 h-6 text-white"></i>
                                </div>
                            </div>
                            <div class="flex-1 order-2 lg:order-none">
                                <h3 class="text-lg font-bold text-green-800 mb-2">
                                    🎉 ¡Período de Prueba Gratuito!
                                </h3>
                                <p class="text-green-700 mb-3">
                                    Has seleccionado el plan <strong>{{ $plan->name }}</strong> que incluye 
                                    <strong>{{ $plan->trial_days }} días de prueba gratis</strong>.
                                </p>
                                <div class="bg-white rounded-lg p-4 border border-green-200">
                                    <ul class="space-y-2 text-sm text-green-700">
                                        <li class="flex items-center gap-2">
                                            <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
                                            No necesitas pagar ahora
                                        </li>
                                        <li class="flex items-center gap-2">
                                            <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
                                            Acceso completo a todas las funciones del plan
                                        </li>
                                        <li class="flex items-center gap-2">
                                            <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
                                            Tu tienda se activará de inmediato
                                        </li>
                                        <li class="flex items-center gap-2">
                                            <i data-lucide="bell" class="w-4 h-4 text-green-600"></i>
                                            Te notificaremos antes de que termine tu prueba
                                        </li>
                                    </ul>
                                </div>
                                <p class="text-xs text-green-600 mt-3">
                                    Después de los {{ $plan->trial_days }} días, podrás elegir continuar con el plan 
                                    pagando ${{ number_format($plan->price, 0, ',', '.') }} COP/mes o cancelar sin compromiso.
                                </p>
                            </div>
                        </div>
                        <input type="hidden" name="payment_method" value="trial">
                    </div>
                    @else
                    {{-- Sección: Método de Pago (cuando se requiere pago) --}}
                    <div class="p-6 lg:p-8 border-b border-gray-200">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-accent-300/10 rounded-xl flex items-center justify-center">
                                <i data-lucide="credit-card" class="w-6 h-6 text-accent-300"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">Método de Pago</h3>
                                <p class="text-sm text-slate-600">Elige cómo deseas realizar el pago</p>
                            </div>
                        </div>
                        
                        @if($epaycoGateway)
                        {{-- Selección de Método de Pago --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-slate-600 mb-3">
                                Elige tu método de pago <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Opción: Transferencia Bancaria --}}
                                <label class="relative flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer transition-all"
                                       :class="paymentMethod === 'transfer' ? 'border-blue-600 bg-blue-50' : 'border-gray-300 hover:border-gray-400'">
                                    <input type="radio" 
                                           name="payment_method" 
                                           value="transfer"
                                           x-model="paymentMethod"
                                           class="sr-only">
                                    <div class="flex items-center gap-3 w-full">
                                        <div class="flex-shrink-0">
                                            <div class="w-5 h-5 rounded-full border border-gray-200 flex items-center justify-center"
                                                 :class="paymentMethod === 'transfer' ? 'border-blue-600' : 'border-gray-300'">
                                                <div x-show="paymentMethod === 'transfer'" 
                                                     class="w-3 h-3 rounded-full bg-blue-600"></div>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <i data-lucide="landmark" class="w-5 h-5 text-slate-600"></i>
                                                <span class="font-semibold text-slate-900">Transferencia Bancaria</span>
                                            </div>
                                            <p class="text-xs font-normal text-slate-600">Paga mediante transferencia y sube tu comprobante</p>
                                        </div>
                                    </div>
                                </label>

                                {{-- Opción: Pago en Línea con Epayco --}}
                                <label class="relative flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer transition-all"
                                       :class="paymentMethod === 'epayco' ? 'border-green-600 bg-green-50' : 'border-gray-300 hover:border-gray-400'">
                                    <input type="radio" 
                                           name="payment_method" 
                                           value="epayco"
                                           x-model="paymentMethod"
                                           class="sr-only">
                                    <div class="flex items-center gap-3 w-full">
                                        <div class="flex-shrink-0">
                                            <div class="w-5 h-5 rounded-full border border-gray-200 flex items-center justify-center"
                                                 :class="paymentMethod === 'epayco' ? 'border-green-600' : 'border-gray-300'">
                                                <div x-show="paymentMethod === 'epayco'" 
                                                     class="w-3 h-3 rounded-full bg-green-600"></div>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <i data-lucide="credit-card" class="w-5 h-5 text-green-600"></i>
                                                <span class="font-semibold text-slate-900">Pagar en Línea con Epayco</span>
                                            </div>
                                            <p class="text-xs font-normal text-slate-600">Paga de forma segura con tarjeta de crédito o débito</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        @else
                            <input type="hidden" name="payment_method" value="transfer" x-model="paymentMethod">
                        @endif

                        {{-- Sección: Comprobante de Pago (solo para transferencia) --}}
                        <div x-show="paymentMethod === 'transfer'" x-transition>
                        
                        @php
                            $selectedPlan = \App\Shared\Models\Plan::find(Session::get('wizard.plan_id'));
                            $billingPeriod = Session::get('wizard.billing_period');
                            $prices = $selectedPlan->prices ?? [];
                            $amount = match($billingPeriod) {
                                'monthly' => $selectedPlan->price,
                                'quarterly' => $prices['quarterly'] ?? ($selectedPlan->price * 3),
                                'semester' => $prices['semester'] ?? ($selectedPlan->price * 6),
                                'annual' => $prices['annual'] ?? ($selectedPlan->price * 12),
                                default => $selectedPlan->price
                            };
                        @endphp
                        
                        {{-- Info de Transferencia --}}
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-6 mb-6">
                            <h4 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                                <i data-lucide="landmark" class="w-5 h-5 text-blue-600"></i>
                                Datos para Transferencia
                            </h4>
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                {{-- Columna izquierda: Datos bancarios --}}
                                <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-slate-600 mb-1">Banco:</p>
                                        <p class="font-bold text-slate-900">{{ $paymentSetting->bank_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 mb-1">Tipo de cuenta:</p>
                                        <p class="font-bold text-slate-900">{{ $paymentSetting->account_type }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 mb-1">Número de cuenta:</p>
                                        <p class="font-bold text-slate-900">{{ $paymentSetting->account_number }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 mb-1">Titular:</p>
                                        <p class="font-bold text-slate-900">{{ $paymentSetting->account_holder }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 mb-1">NIT:</p>
                                        <p class="font-bold text-slate-900">{{ $paymentSetting->nit }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 mb-1">Monto a pagar:</p>
                                        <p class="font-bold text-lg text-blue-600">${{ number_format($amount, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                {{-- Columna derecha: QR Code --}}
                                @if($paymentSetting->qr_code_image && $paymentSetting->qr_code_url)
                                <div class="flex items-center justify-center">
                                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-lg">
                                        <img src="{{ $paymentSetting->qr_code_url }}" 
                                             alt="QR Code de Pago" 
                                             class="w-40 h-40 object-contain"
                                             onerror="console.error('Error cargando QR:', this.src); this.style.display='none'; this.nextElementSibling.style.display='block';">
                                        <div style="display:none;" class="text-center py-4">
                                            <i data-lucide="alert-circle" class="w-8 h-8 text-slate-400 mx-auto mb-2"></i>
                                            <p class="text-xs text-slate-500">Error cargando QR</p>
                                        </div>
                                        <p class="text-xs text-center text-slate-600 mt-2">Escanea para pagar</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Upload Comprobante --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">
                                Subir Comprobante de Pago <span class="text-red-500" x-show="paymentMethod === 'transfer'">*</span>
                            </label>
                            <div class="border border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-blue-500 transition-colors">
                                <input type="file" 
                                       name="payment_proof" 
                                       id="payment_proof"
                                       accept="image/*,.pdf"
                                       class="hidden"
                                       @change="handleFileSelect($event)"
                                       :required="paymentMethod === 'transfer'"
                                       x-bind:required="paymentMethod === 'transfer'">
                                <label for="payment_proof" class="cursor-pointer">
                                    <i data-lucide="upload-cloud" class="w-12 h-12 text-slate-400 mx-auto mb-3"></i>
                                    <p class="text-slate-700 font-medium mb-1">Click para seleccionar archivo</p>
                                    <p class="text-sm text-slate-500">JPG, PNG o PDF - Máximo 5MB</p>
                                </label>
                                <div x-show="fileName" class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                                    <p class="text-sm text-slate-600 font-normal flex items-center justify-center gap-2">
                                        <i data-lucide="file-check" class="w-4 h-4"></i>
                                        <span x-text="fileName"></span>
                                    </p>
                                </div>
                            </div>
                            @error('payment_proof')
                                <p class="text-xs font-normal text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        </div>

                        {{-- Selección de Método Epayco (solo cuando se selecciona Epayco) --}}
                        <div x-show="paymentMethod === 'epayco'" x-transition class="mt-6">
                            <label class="block text-sm font-medium text-slate-600 mb-3">
                                Elige tu método de pago Epayco <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                {{-- Opción: PSE (Pagos Seguros en Línea) --}}
                                <label class="relative flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer transition-all"
                                       :class="epaycoMethod === 'pse' ? 'border-green-600 bg-green-50' : 'border-gray-300 hover:border-gray-400'">
                                    <input type="radio" 
                                           name="epayco_method" 
                                           value="pse"
                                           x-model="epaycoMethod"
                                           class="sr-only">
                                    <div class="flex items-center gap-3 w-full">
                                        <div class="flex-shrink-0">
                                            <div class="w-5 h-5 rounded-full border border-gray-200 flex items-center justify-center"
                                                 :class="epaycoMethod === 'pse' ? 'border-green-600' : 'border-gray-300'">
                                                <div x-show="epaycoMethod === 'pse'" 
                                                     class="w-3 h-3 rounded-full bg-green-600"></div>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <i data-lucide="building-2" class="w-5 h-5 text-green-600"></i>
                                                <span class="font-semibold text-slate-900">PSE</span>
                                            </div>
                                            <p class="text-xs font-normal text-slate-600">Pago desde tu cuenta bancaria</p>
                                        </div>
                                    </div>
                                </label>

                                {{-- Opción: Efectivo --}}
                                <label class="relative flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer transition-all"
                                       :class="epaycoMethod === 'cash' ? 'border-green-600 bg-green-50' : 'border-gray-300 hover:border-gray-400'">
                                    <input type="radio" 
                                           name="epayco_method" 
                                           value="cash"
                                           x-model="epaycoMethod"
                                           class="sr-only">
                                    <div class="flex items-center gap-3 w-full">
                                        <div class="flex-shrink-0">
                                            <div class="w-5 h-5 rounded-full border border-gray-200 flex items-center justify-center"
                                                 :class="epaycoMethod === 'cash' ? 'border-green-600' : 'border-gray-300'">
                                                <div x-show="epaycoMethod === 'cash'" 
                                                     class="w-3 h-3 rounded-full bg-green-600"></div>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <i data-lucide="wallet" class="w-5 h-5 text-green-600"></i>
                                                <span class="font-semibold text-slate-900">Efectivo</span>
                                            </div>
                                            <p class="text-xs font-normal text-slate-600">Pago en efectivo en puntos físicos</p>
                                        </div>
                                    </div>
                                </label>

                            </div>

                            {{-- Selector de Banco (solo cuando se selecciona PSE) --}}
                            <div x-show="epaycoMethod === 'pse'" x-transition class="mb-6">
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Selecciona tu banco <span class="text-red-500">*</span>
                                </label>
                                <select name="pse_bank_code" 
                                        x-model="pseBankCode"
                                        @change="updateWalletPhoneRequired()"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none text-base"
                                        :required="epaycoMethod === 'pse'"
                                        x-bind:required="epaycoMethod === 'pse'">
                                    <option value="">Selecciona tu banco</option>
                                    @if(isset($pseBanks) && is_array($pseBanks) && count($pseBanks) > 0)
                                        @foreach($pseBanks as $bank)
                                            @php
                                                // Acceder a propiedades según estructura de Epayco: bankCode (int) y bankName (string)
                                                if (is_array($bank)) {
                                                    $bankCode = $bank['bankCode'] ?? $bank['bank_code'] ?? $bank['code'] ?? '';
                                                    $bankName = $bank['bankName'] ?? $bank['bank_name'] ?? $bank['name'] ?? '';
                                                } else {
                                                    // Es un objeto
                                                    $bankCode = isset($bank->bankCode) ? (string)$bank->bankCode : ($bank->bank_code ?? $bank->code ?? '');
                                                    $bankName = $bank->bankName ?? $bank->bank_name ?? $bank->name ?? '';
                                                }
                                            @endphp
                                            @if(!empty($bankCode) && !empty($bankName))
                                                <option value="{{ $bankCode }}">
                                                    {{ $bankName }}
                                                </option>
                                            @endif
                                        @endforeach
                                    @else
                                        <option value="" disabled>No hay bancos disponibles</option>
                                    @endif
                                </select>
                                <p class="text-xs font-normal text-slate-600 mt-1">Selecciona el banco desde el cual realizarás el pago</p>
                            </div>

                            {{-- Selector de Método de Efectivo (solo cuando se selecciona Efectivo) --}}
                            <div x-show="epaycoMethod === 'cash'" x-transition class="mb-6">
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Selecciona el método de pago en efectivo <span class="text-red-500">*</span>
                                </label>
                                <select name="cash_type" 
                                        x-model="cashType"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none text-base"
                                        :required="epaycoMethod === 'cash'"
                                        x-bind:required="epaycoMethod === 'cash'">
                                    <option value="">Selecciona el método de pago</option>
                                    <option value="PR">Punto Red</option>
                                    <option value="RS">Red Servi</option>
                                    <option value="SR">SuRed</option>
                                    <option value="BA">Baloto</option>
                                    <option value="EF">Efecty</option>
                                    <option value="GA">Gana</option>
                                </select>
                                <p class="text-xs font-normal text-slate-600 mt-1">Selecciona la red donde realizarás el pago en efectivo</p>
                            </div>

                            {{-- Campo de Teléfono para Nequi o Daviplata (cuando se selecciona Nequi o Daviplata en PSE) --}}
                            <div x-show="epaycoMethod === 'pse' && (pseBankCode === '1507' || pseBankCode === '1551')" x-transition class="mb-6">
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Número de teléfono asociado a tu cuenta 
                                    <span x-text="pseBankCode === '1507' ? 'Nequi' : 'Daviplata'"></span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" 
                                       name="wallet_phone" 
                                       x-model="walletPhone"
                                       placeholder="Ejemplo: 3101234567"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none text-base"
                                       :required="epaycoMethod === 'pse' && (pseBankCode === '1507' || pseBankCode === '1551')"
                                       x-bind:required="epaycoMethod === 'pse' && (pseBankCode === '1507' || pseBankCode === '1551')"
                                       pattern="[0-9]{10}"
                                       maxlength="10">
                                <p class="text-xs font-normal text-slate-600 mt-1">
                                    <span class="font-semibold text-amber-600">⚠️ Importante:</span> 
                                    Debe ser el número de teléfono con el que tienes registrada tu cuenta 
                                    <span x-text="pseBankCode === '1507' ? 'Nequi' : 'Daviplata'"></span>. 
                                    Si usas un número diferente, el pago fallará.
                                </p>
                            </div>

                            {{-- Información de Pago en Línea --}}
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl p-6">
                                <h4 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                                    <i data-lucide="shield-check" class="w-5 h-5 text-green-600"></i>
                                    Pago Seguro con Epayco
                                </h4>
                                <div class="space-y-3 text-sm">
                                    <div class="flex items-center gap-2 text-slate-600">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
                                        <span>Pago seguro y encriptado</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-slate-600">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
                                        <span>Acepta tarjetas de crédito y débito</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-slate-600">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
                                        <span>Confirmación inmediata del pago</span>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-green-200">
                                        <p class="text-slate-600 mb-1">Monto a pagar:</p>
                                        <p class="font-bold text-xl text-green-600">${{ number_format($amount, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Sección: Términos y Condiciones --}}
                    <div class="p-6 lg:p-8 bg-blue-50">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" 
                                   name="accept_terms" 
                                   value="1"
                                   class="mt-1 w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                                   required>
                            <div class="text-sm text-slate-600">
                                Acepto los <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Términos y Condiciones</a> 
                                y la <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Política de Privacidad</a> de Linkiu
                                <span class="text-red-500">*</span>
                            </div>
                        </label>
                        @error('accept_terms')
                            <p class="text-xs font-normal text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Botones de Navegación --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center justify-center p-6 lg:p-8 bg-slate-50 flex items-center justify-between border-t border-gray-200">
                        <a href="{{ route('register.step3') }}" 
                           class="px-6 py-2.5 bg-white border border-gray-300 text-slate-600 rounded-lg font-medium hover:bg-gray-50 transition-colors flex items-center gap-2">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            Paso Anterior
                        </a>
                        <button type="submit" 
                                class="px-8 py-2.5 bg-accent-300 hover:bg-accent-400 text-white rounded-lg font-semibold transition-colors flex items-center justify-center gap-2"
                                :disabled="submitting">
                            <template x-if="!submitting">
                                <span class="flex items-center gap-2">
                                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                                    <span x-text="paymentMethod === 'epayco' ? 'Pagar con Epayco' : 'Completar Registro'"></span>
                                </span>
                            </template>
                            <template x-if="submitting">
                                <span class="flex items-center gap-2">
                                    <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></div>
                                    <span class="text-sm font-normal">Procesando...</span>
                                </span>
                            </template>
                        </button>
                    </div>
                </div>
            </form>
        </main>
    </div>

    {{-- Calendly Modal --}}
    <div x-show="calendlyOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         @click.self="calendlyOpen = false"
         @keydown.escape.window="calendlyOpen = false"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="calendlyOpen = false"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
            
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Agendar Reunión</h3>
                        <button @click="calendlyOpen = false" class="text-gray-400 hover:text-gray-500">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                    <div class="calendly-inline-widget" data-url="https://calendly.com/linkiu/reunion" style="min-width:320px;height:700px;"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('ownerForm', () => ({
            calendlyOpen: false,
            ownerName: '{{ old('owner_name') }}',
            ownerEmail: '{{ old('owner_email') }}',
            ownerDocumentType: '{{ old('owner_document_type', '') }}',
            ownerDocumentNumber: '{{ old('owner_document_number') }}',
            password: '',
            passwordConfirmation: '',
            fileName: '',
            paymentMethod: '{{ old('payment_method', ($skipPayment ?? false) ? 'trial' : ($epaycoGateway ? 'transfer' : 'transfer')) }}',
            epaycoMethod: '{{ old('epayco_method', 'pse') }}',
            pseBankCode: '{{ old('pse_bank_code', '') }}',
            cashType: '{{ old('cash_type', '') }}',
            walletPhone: '{{ old('wallet_phone', '') }}',
            submitting: false,
            saveTimeout: null,
            ownerEmailAvailable: null,
            validatingOwnerEmail: false,
            ownerEmailValidationTimeout: null,

            init() {
                // Cargar datos guardados
                this.loadFromLocalStorage();
                
                // Restaurar valores de old() si existen
                @if(old('owner_name'))
                    this.ownerName = '{{ old('owner_name') }}';
                @endif
                @if(old('owner_email'))
                    this.ownerEmail = '{{ old('owner_email') }}';
                @endif
                @if(old('owner_document_type'))
                    this.ownerDocumentType = '{{ old('owner_document_type') }}';
                @endif
                @if(old('owner_document_number'))
                    this.ownerDocumentNumber = '{{ old('owner_document_number') }}';
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
                        step: 4,
                        formData: {
                            owner_name: this.ownerName,
                            owner_email: this.ownerEmail,
                            owner_document_type: this.ownerDocumentType,
                            owner_document_number: this.ownerDocumentNumber,
                            payment_method: this.paymentMethod,
                            epayco_method: this.epaycoMethod,
                            pse_bank_code: this.pseBankCode,
                            cash_type: this.cashType,
                            wallet_phone: this.walletPhone
                        },
                        timestamp: new Date().toISOString()
                    };
                    localStorage.setItem('registration_step4', JSON.stringify(data));
                } catch (error) {
                    console.error('Error guardando datos:', error);
                }
            },

            loadFromLocalStorage() {
                try {
                    const saved = localStorage.getItem('registration_step4');
                    if (saved) {
                        const data = JSON.parse(saved);
                        if (data.formData) {
                            if (!this.ownerName && data.formData.owner_name) {
                                this.ownerName = data.formData.owner_name;
                            }
                            if (!this.ownerEmail && data.formData.owner_email) {
                                this.ownerEmail = data.formData.owner_email;
                            }
                            if (!this.ownerDocumentType && data.formData.owner_document_type) {
                                this.ownerDocumentType = data.formData.owner_document_type;
                            }
                            if (!this.ownerDocumentNumber && data.formData.owner_document_number) {
                                this.ownerDocumentNumber = data.formData.owner_document_number;
                            }
                            if (data.formData.payment_method) {
                                this.paymentMethod = data.formData.payment_method;
                            }
                            if (data.formData.epayco_method) {
                                this.epaycoMethod = data.formData.epayco_method;
                            }
                            if (data.formData.pse_bank_code) {
                                this.pseBankCode = data.formData.pse_bank_code;
                            }
                            if (data.formData.cash_type) {
                                this.cashType = data.formData.cash_type;
                            }
                            if (data.formData.wallet_phone) {
                                this.walletPhone = data.formData.wallet_phone;
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
            
            passwordsMatch() {
                if (!this.password || !this.passwordConfirmation) return false;
                return this.password === this.passwordConfirmation;
            },

            async validateOwnerEmail() {
                if (!this.ownerEmail) {
                    this.ownerEmailAvailable = null;
                    this.validatingOwnerEmail = false;
                    return;
                }

                // Validar formato de email
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(this.ownerEmail)) {
                    this.ownerEmailAvailable = null;
                    this.validatingOwnerEmail = false;
                    return;
                }

                // Limpiar timeout anterior
                if (this.ownerEmailValidationTimeout) {
                    clearTimeout(this.ownerEmailValidationTimeout);
                }

                this.ownerEmailAvailable = null;

                // Esperar 500ms después de que el usuario deje de escribir
                this.ownerEmailValidationTimeout = setTimeout(async () => {
                    this.validatingOwnerEmail = true;
                    
                    try {
                        const response = await fetch('{{ route('api.validate-registration-email') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                email: this.ownerEmail
                            })
                        });

                        const data = await response.json();

                        if (!data.available) {
                            this.ownerEmailAvailable = false;
                        } else {
                            this.ownerEmailAvailable = true;
                        }
                    } catch (error) {
                        console.error('Error validando email:', error);
                        this.ownerEmailAvailable = false;
                    } finally {
                        this.validatingOwnerEmail = false;
                    }
                }, 500);
            },

            destroy() {
                if (this.saveTimeout) {
                    clearTimeout(this.saveTimeout);
                }
                if (this.ownerEmailValidationTimeout) {
                    clearTimeout(this.ownerEmailValidationTimeout);
                }
            },

            updateWalletPhoneRequired() {
                // Limpiar el campo de teléfono si cambia el banco y ya no requiere wallet
                if (this.pseBankCode !== '1507' && this.pseBankCode !== '1551') {
                    this.walletPhone = '';
                }
            },
            
            handleFileSelect(event) {
                const file = event.target.files[0];
                if (file) {
                    this.fileName = file.name;
                    this.$nextTick(() => {
                        if (window.createIcons) window.createIcons({ icons: window.lucideIcons });
                    });
                }
            },
            
            handleSubmit(event) {
                event.preventDefault();
                
                // Validar que se haya seleccionado un método de pago
                if (!this.paymentMethod) {
                    alert('Por favor selecciona un método de pago');
                    return false;
                }
                
                // Si es trial (período de prueba sin pago), continuar directamente
                if (this.paymentMethod === 'trial') {
                    this.submitting = true;
                    this.$el.action = '{{ route('register.complete') }}';
                    this.$el.submit();
                    return;
                }
                
                // Si es transferencia, validar que se haya subido el comprobante
                if (this.paymentMethod === 'transfer') {
                    const fileInput = document.getElementById('payment_proof');
                    if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                        alert('Por favor sube el comprobante de pago');
                        // Hacer click en el label para abrir el selector de archivos
                        const label = fileInput.closest('div').querySelector('label[for="payment_proof"]');
                        if (label) {
                            label.click();
                        }
                        return false;
                    }
                } else {
                    // Si es Epayco, validar que se haya seleccionado un método
                    if (this.paymentMethod === 'epayco' && !this.epaycoMethod) {
                        alert('Por favor selecciona un método de pago de Epayco (PSE o Efectivo)');
                        return false;
                    }
                    
                    // Si es PSE, validar que se haya seleccionado un banco
                    if (this.paymentMethod === 'epayco' && this.epaycoMethod === 'pse' && !this.pseBankCode) {
                        alert('Por favor selecciona el banco desde el cual realizarás el pago PSE');
                        return false;
                    }

                    // Si es Efectivo, validar que se haya seleccionado un método
                    if (this.paymentMethod === 'epayco' && this.epaycoMethod === 'cash' && !this.cashType) {
                        alert('Por favor selecciona el método de pago en efectivo (Punto Red, Red Servi, Efecty, etc.)');
                        return false;
                    }

                    // Si es PSE con Nequi o Daviplata, validar número de teléfono
                    if (this.paymentMethod === 'epayco' && this.epaycoMethod === 'pse' && (this.pseBankCode === '1507' || this.pseBankCode === '1551') && !this.walletPhone) {
                        const walletName = this.pseBankCode === '1507' ? 'Nequi' : 'Daviplata';
                        alert(`Por favor ingresa el número de teléfono asociado a tu cuenta ${walletName}`);
                        return false;
                    }
                    
                    // Remover el required del campo de comprobante para evitar errores
                    const fileInput = document.getElementById('payment_proof');
                    if (fileInput) {
                        fileInput.removeAttribute('required');
                        // Limpiar el valor si tiene algo
                        fileInput.value = '';
                    }
                }
                
                // Validar otros campos requeridos
                const form = event.target;
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    // Si el campo está oculto (dentro de un div con x-show="false"), saltarlo
                    const isVisible = field.offsetParent !== null;
                    if (isVisible && !field.value && field.type !== 'file') {
                        isValid = false;
                        field.classList.add('border-red-500');
                    }
                });
                
                if (!isValid) {
                    alert('Por favor completa todos los campos requeridos');
                    return false;
                }
                
                // Si es Epayco, enviar el formulario al endpoint de iniciar pago
                if (this.paymentMethod === 'epayco') {
                    this.submitting = true;
                    form.submit();
                } else {
                    // Si es transferencia, enviar normalmente
                    this.submitting = true;
                    form.submit();
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

