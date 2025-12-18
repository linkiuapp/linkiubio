<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Información del Propietario - Linkiu</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    
    <div class="min-h-screen">
        {{-- Wizard Progress --}}
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white font-semibold">
                            4
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Paso 4 de 4</p>
                            <p class="text-xs text-gray-600">Información del Propietario</p>
                        </div>
                    </div>
                    <a href="{{ route('register.step3') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
                        ← Volver
                    </a>
                </div>
                <div class="flex gap-2">
                    <div class="flex-1 h-2 bg-blue-600 rounded-full"></div>
                    <div class="flex-1 h-2 bg-blue-600 rounded-full"></div>
                    <div class="flex-1 h-2 bg-blue-600 rounded-full"></div>
                    <div class="flex-1 h-2 bg-blue-600 rounded-full"></div>
                </div>
            </div>
        </div>

        {{-- Content Area --}}
        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center mb-8">
                <h2 class="text-xl font-bold text-slate-900 mb-3">¡Último Paso!</h2>
                <p class="text-base font-normal text-gray-600">Crea tu cuenta de administrador</p>
            </div>

            <form method="POST" :action="paymentMethod === 'epayco' ? '{{ route('register.payment.initiate') }}' : '{{ route('register.complete') }}'" 
                  enctype="multipart/form-data" 
                  x-data="ownerForm()"
                  @submit.prevent="handleSubmit"
                  novalidate>
                @csrf
                
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    
                    {{-- Sección: Datos Personales --}}
                    <div class="p-6 lg:p-8 border-b border-gray-200">
                        <h3 class="text-base md:text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                            <i data-lucide="user" class="w-5 h-5 text-blue-600"></i>
                            Datos Personales
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Nombre Completo <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       name="owner_name"
                                       value="{{ old('owner_name') }}"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('owner_name') border-red-300 @enderror text-base"
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
                                <input type="email"
                                       name="owner_email"
                                       value="{{ old('owner_email') }}"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('owner_email') border-red-300 @enderror text-base"
                                       placeholder="tu@email.com"
                                       required>
                                <p class="text-xs font-normal text-slate-600 mt-1">Usarás este correo para iniciar sesión</p>
                                @error('owner_email')
                                    <p class="text-xs font-normal text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Tipo de Documento <span class="text-red-500">*</span>
                                </label>
                                <select name="owner_document_type"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('owner_document_type') border-red-300 @enderror text-base"
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
                                       value="{{ old('owner_document_number') }}"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('owner_document_number') border-red-300 @enderror text-base"
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
                        <h3 class="text-base md:text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                            <i data-lucide="key" class="w-5 h-5 text-blue-600"></i>
                            Credenciales de Acceso
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Contraseña <span class="text-red-500">*</span>
                                </label>
                                <input type="password"
                                       name="password"
                                       x-model="password"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('password') border-red-300 @enderror text-base"
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
                                <input type="password"
                                       name="password_confirmation"
                                       x-model="passwordConfirmation"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none text-base"
                                       placeholder="••••••••"
                                       minlength="8"
                                       required>
                                <p class="text-xs font-normal" :class="passwordsMatch() ? 'text-green-600' : 'text-slate-600'">
                                    <template x-if="password && passwordConfirmation">
                                        <span x-show="passwordsMatch()">✓ Las contraseñas coinciden</span>
                                    </template>
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Sección: Método de Pago --}}
                    <div class="p-6 lg:p-8 border-b border-gray-200">
                        <h3 class="text-base md:text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                            <i data-lucide="credit-card" class="w-5 h-5 text-blue-600"></i>
                            Método de Pago
                        </h3>
                        
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

                                {{-- Opción: Click to Pay --}}
                                <label class="relative flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer transition-all"
                                       :class="epaycoMethod === 'clicktopay' ? 'border-green-600 bg-green-50' : 'border-gray-300 hover:border-gray-400'">
                                    <input type="radio" 
                                           name="epayco_method" 
                                           value="clicktopay"
                                           x-model="epaycoMethod"
                                           class="sr-only">
                                    <div class="flex items-center gap-3 w-full">
                                        <div class="flex-shrink-0">
                                            <div class="w-5 h-5 rounded-full border border-gray-200 flex items-center justify-center"
                                                 :class="epaycoMethod === 'clicktopay' ? 'border-green-600' : 'border-gray-300'">
                                                <div x-show="epaycoMethod === 'clicktopay'" 
                                                     class="w-3 h-3 rounded-full bg-green-600"></div>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <i data-lucide="smartphone" class="w-5 h-5 text-green-600"></i>
                                                <span class="font-semibold text-slate-900">Click to Pay</span>
                                            </div>
                                            <p class="text-xs font-normal text-slate-600">Pago rápido con tarjeta guardada</p>
                                        </div>
                                    </div>
                                </label>

                                {{-- Opción: Daviplata --}}
                                <label class="relative flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer transition-all"
                                       :class="epaycoMethod === 'daviplata' ? 'border-green-600 bg-green-50' : 'border-gray-300 hover:border-gray-400'">
                                    <input type="radio" 
                                           name="epayco_method" 
                                           value="daviplata"
                                           x-model="epaycoMethod"
                                           class="sr-only">
                                    <div class="flex items-center gap-3 w-full">
                                        <div class="flex-shrink-0">
                                            <div class="w-5 h-5 rounded-full border border-gray-200 flex items-center justify-center"
                                                 :class="epaycoMethod === 'daviplata' ? 'border-green-600' : 'border-gray-300'">
                                                <div x-show="epaycoMethod === 'daviplata'" 
                                                     class="w-3 h-3 rounded-full bg-green-600"></div>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <i data-lucide="wallet" class="w-5 h-5 text-green-600"></i>
                                                <span class="font-semibold text-slate-900">Daviplata</span>
                                            </div>
                                            <p class="text-xs font-normal text-slate-600">Pago desde tu cuenta Daviplata</p>
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
                                class="px-8 py-2.5 bg-slate-900 hover:bg-slate-900 text-white rounded-lg font-semibold transition-colors flex items-center justify-center gap-2"
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

    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('ownerForm', () => ({
            password: '',
            passwordConfirmation: '',
            fileName: '',
            paymentMethod: '{{ old('payment_method', $epaycoGateway ? 'transfer' : 'transfer') }}',
            epaycoMethod: '{{ old('epayco_method', 'pse') }}',
            pseBankCode: '{{ old('pse_bank_code', '') }}',
            cashType: '{{ old('cash_type', '') }}',
            submitting: false,
            
            passwordsMatch() {
                if (!this.password || !this.passwordConfirmation) return false;
                return this.password === this.passwordConfirmation;
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
                        alert('Por favor selecciona un método de pago de Epayco (PSE, Efectivo, Click to Pay o Daviplata)');
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
        if (window.createIcons && window.lucideIcons) {
            window.createIcons({ icons: window.lucideIcons });
        }
    });
    </script>
    
    <style>
    [x-cloak] { display: none !important; }
    </style>
</body>
</html>

