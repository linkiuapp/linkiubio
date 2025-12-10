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
                <h2 class="text-2xl font-bold text-gray-900 mb-3">¡Último Paso!</h2>
                <p class="text-base text-gray-600">Crea tu cuenta de administrador</p>
            </div>

            <form method="POST" action="{{ route('register.complete') }}" enctype="multipart/form-data" x-data="ownerForm()">
                @csrf
                
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    
                    {{-- Sección: Datos Personales --}}
                    <div class="p-6 lg:p-8 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                            <i data-lucide="user" class="w-5 h-5 text-blue-600"></i>
                            Datos Personales
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nombre Completo <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       name="owner_name"
                                       value="{{ old('owner_name') }}"
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('owner_name') border-red-300 @enderror text-base"
                                       placeholder="Juan Pérez"
                                       required>
                                @error('owner_name')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Correo Electrónico <span class="text-red-500">*</span>
                                </label>
                                <input type="email"
                                       name="owner_email"
                                       value="{{ old('owner_email') }}"
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('owner_email') border-red-300 @enderror text-base"
                                       placeholder="tu@email.com"
                                       required>
                                <p class="text-xs text-gray-600 mt-1">Usarás este correo para iniciar sesión</p>
                                @error('owner_email')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tipo de Documento <span class="text-red-500">*</span>
                                </label>
                                <select name="owner_document_type"
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('owner_document_type') border-red-300 @enderror text-base"
                                        required>
                                    <option value="">Seleccionar tipo</option>
                                    <option value="cc" {{ old('owner_document_type') == 'cc' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                                    <option value="ce" {{ old('owner_document_type') == 'ce' ? 'selected' : '' }}>Cédula de Extranjería</option>
                                    <option value="passport" {{ old('owner_document_type') == 'passport' ? 'selected' : '' }}>Pasaporte</option>
                                </select>
                                @error('owner_document_type')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Número de Documento <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       name="owner_document_number"
                                       value="{{ old('owner_document_number') }}"
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('owner_document_number') border-red-300 @enderror text-base"
                                       placeholder="1234567890"
                                       required>
                                @error('owner_document_number')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Sección: Credenciales de Acceso --}}
                    <div class="p-6 lg:p-8 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                            <i data-lucide="key" class="w-5 h-5 text-blue-600"></i>
                            Credenciales de Acceso
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Contraseña <span class="text-red-500">*</span>
                                </label>
                                <input type="password"
                                       name="password"
                                       x-model="password"
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('password') border-red-300 @enderror text-base"
                                       placeholder="••••••••"
                                       minlength="8"
                                       required>
                                <p class="text-xs text-gray-600 mt-1">Mínimo 8 caracteres</p>
                                @error('password')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Confirmar Contraseña <span class="text-red-500">*</span>
                                </label>
                                <input type="password"
                                       name="password_confirmation"
                                       x-model="passwordConfirmation"
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none text-base"
                                       placeholder="••••••••"
                                       minlength="8"
                                       required>
                                <p class="text-xs" :class="passwordsMatch() ? 'text-green-600' : 'text-gray-600'">
                                    <template x-if="password && passwordConfirmation">
                                        <span x-show="passwordsMatch()">✓ Las contraseñas coinciden</span>
                                    </template>
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Sección: Comprobante de Pago --}}
                    <div class="p-6 lg:p-8 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                            <i data-lucide="receipt" class="w-5 h-5 text-blue-600"></i>
                            Comprobante de Pago
                        </h3>
                        
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
                            <h4 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <i data-lucide="landmark" class="w-5 h-5 text-blue-600"></i>
                                Datos para Transferencia
                            </h4>
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                {{-- Columna izquierda: Datos bancarios --}}
                                <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-600 mb-1">Banco:</p>
                                        <p class="font-bold text-gray-900">{{ $paymentSetting->bank_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 mb-1">Tipo de cuenta:</p>
                                        <p class="font-bold text-gray-900">{{ $paymentSetting->account_type }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 mb-1">Número de cuenta:</p>
                                        <p class="font-bold text-gray-900">{{ $paymentSetting->account_number }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 mb-1">Titular:</p>
                                        <p class="font-bold text-gray-900">{{ $paymentSetting->account_holder }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 mb-1">NIT:</p>
                                        <p class="font-bold text-gray-900">{{ $paymentSetting->nit }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 mb-1">Monto a pagar:</p>
                                        <p class="font-bold text-2xl text-blue-600">${{ number_format($amount, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                {{-- Columna derecha: QR Code --}}
                                @if($paymentSetting->qr_code_image && $paymentSetting->qr_code_url)
                                <div class="flex items-center justify-center">
                                    <div class="bg-white p-4 rounded-xl border-2 border-blue-300 shadow-lg">
                                        <img src="{{ $paymentSetting->qr_code_url }}" 
                                             alt="QR Code de Pago" 
                                             class="w-40 h-40 object-contain"
                                             onerror="console.error('Error cargando QR:', this.src); this.style.display='none'; this.nextElementSibling.style.display='block';">
                                        <div style="display:none;" class="text-center py-4">
                                            <i data-lucide="alert-circle" class="w-8 h-8 text-gray-400 mx-auto mb-2"></i>
                                            <p class="text-xs text-gray-500">Error cargando QR</p>
                                        </div>
                                        <p class="text-xs text-center text-gray-600 mt-2">Escanea para pagar</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Upload Comprobante --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Subir Comprobante de Pago <span class="text-red-500">*</span>
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-500 transition-colors">
                                <input type="file" 
                                       name="payment_proof" 
                                       id="payment_proof"
                                       accept="image/*,.pdf"
                                       class="hidden"
                                       @change="handleFileSelect($event)"
                                       required>
                                <label for="payment_proof" class="cursor-pointer">
                                    <i data-lucide="upload-cloud" class="w-12 h-12 text-gray-400 mx-auto mb-3"></i>
                                    <p class="text-gray-700 font-medium mb-1">Click para seleccionar archivo</p>
                                    <p class="text-sm text-gray-500">JPG, PNG o PDF - Máximo 5MB</p>
                                </label>
                                <div x-show="fileName" class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                                    <p class="text-sm text-green-800 flex items-center justify-center gap-2">
                                        <i data-lucide="file-check" class="w-4 h-4"></i>
                                        <span x-text="fileName"></span>
                                    </p>
                                </div>
                            </div>
                            @error('payment_proof')
                                <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                            @enderror
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
                            <div class="text-sm text-gray-700">
                                Acepto los <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Términos y Condiciones</a> 
                                y la <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Política de Privacidad</a> de Linkiu
                                <span class="text-red-500">*</span>
                            </div>
                        </label>
                        @error('accept_terms')
                            <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Botones de Navegación --}}
                    <div class="p-6 lg:p-8 bg-gray-50 flex items-center justify-between border-t border-gray-200">
                        <a href="{{ route('register.step3') }}" 
                           class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors flex items-center gap-2">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            Paso Anterior
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-bold text-base transition-all shadow-lg hover:shadow-xl flex items-center gap-2">
                            <i data-lucide="check-circle" class="w-5 h-5"></i>
                            <span>Completar Registro</span>
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

