<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Código - {{ $store->name }}</title>
    
    <meta name="description" content="Verificar código de recuperación para {{ $store->name }}">
    <meta name="robots" content="noindex, nofollow">
    
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased">
    <div class="min-h-screen flex">
        <!-- Lado izquierdo: Background con imagen SVG -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-slate-200">
            <div class="absolute inset-0">
                @php
                    $loginBanner = ui_image_single('tenant_admin', 'login_banner', asset('images-ui/banner_navidad_logens.webp'));
                @endphp
                <img src="{{ $loginBanner }}" 
                     alt="Banner de información" 
                     class="w-full h-full object-contain items-center justify-center">
            </div>
        </div>
        
        <!-- Lado derecho: Formulario -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md">
                <!-- Logo móvil -->
                <div class="mb-8 text-start">
                    @php
                        $loginLogo = ui_image_single('tenant_admin', 'login_logo', asset('images-ui/base_ui_login_logo.svg'));
                    @endphp
                    <img src="{{ $loginLogo }}" 
                    alt="Logo de Linkiu" 
                    class="h-12 w-auto mb-4">
                </div>
                
                <!-- Header -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-2">
                        Verificar Código
                    </h2>
                    <p class="text-gray-600">
                        Ingresa el código de 6 dígitos que recibiste por SMS
                    </p>
                </div>
                
                <!-- Alertas -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5"></i>
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5"></i>
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-start gap-3">
                            <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5"></i>
                            <div class="flex-1">
                                <ul class="text-sm text-red-700 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Formulario -->
                <form method="POST" action="{{ route('tenant.admin.password.verify-code', $store->slug) }}" class="space-y-6" x-data="otpInput()" @submit.prevent="submitForm()">
                    @csrf
                    
                    <!-- Código OTP -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-4 text-center">
                            Código de Verificación
                        </label>
                        
                        <!-- Inputs OTP -->
                        <div class="flex justify-center gap-3 mb-3" x-ref="otpContainer">
                            <template x-for="(digit, index) in digits" :key="index">
                                <input 
                                    type="text"
                                    :name="index === 0 ? 'code' : ''"
                                    :id="`otp-${index}`"
                                    x-model="digits[index]"
                                    @input="handleInput(index, $event)"
                                    @keydown="handleKeyDown(index, $event)"
                                    @paste="handlePaste($event)"
                                    maxlength="1"
                                    pattern="[0-9]"
                                    class="w-12 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('code') border-red-500 @enderror"
                                    :class="{ 'border-indigo-500 ring-2 ring-indigo-200': focusedIndex === index }"
                                    required
                                    autocomplete="off"
                                    inputmode="numeric"
                                >
                            </template>
                        </div>
                        
                        <!-- Input oculto para el valor completo (para validación del servidor) -->
                        <input type="hidden" name="code" :value="digits.join('')">
                        
                        <p class="mt-2 text-xs text-gray-500 text-center">
                            El código expira en 5 minutos
                        </p>
                    </div>
                    
                    <!-- Submit button -->
                    <button type="submit" 
                            :disabled="digits.join('').length !== 6"
                            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 disabled:transform-none">
                        <i data-lucide="check" class="w-5 h-5"></i>
                        Verificar Código
                    </button>
                </form>
                
                <!-- Reenviar código -->
                <form method="POST" action="{{ route('tenant.admin.password.resend-code', $store->slug) }}" class="mt-4">
                    @csrf
                    <button type="submit" 
                            class="w-full text-sm text-indigo-600 hover:text-indigo-700 font-medium py-2">
                        <i data-lucide="refresh-cw" class="w-4 h-4 inline mr-1"></i>
                        Reenviar código
                    </button>
                </form>
                
                <!-- Volver -->
                <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                    <a href="{{ route('tenant.admin.password.forgot', $store->slug) }}" 
                       class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-indigo-600 transition-colors">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });

        function otpInput() {
            return {
                digits: ['', '', '', '', '', ''],
                focusedIndex: 0,
                
                init() {
                    // Focus en el primer input al cargar
                    this.$nextTick(() => {
                        const firstInput = document.getElementById('otp-0');
                        if (firstInput) {
                            firstInput.focus();
                        }
                    });
                },
                
                handleInput(index, event) {
                    const value = event.target.value.replace(/[^0-9]/g, '');
                    
                    if (value) {
                        this.digits[index] = value;
                        
                        // Mover al siguiente input si hay valor
                        if (index < 5) {
                            this.$nextTick(() => {
                                const nextInput = document.getElementById(`otp-${index + 1}`);
                                if (nextInput) {
                                    nextInput.focus();
                                }
                            });
                        } else {
                            // Si es el último dígito, hacer blur
                            event.target.blur();
                        }
                    } else {
                        this.digits[index] = '';
                    }
                },
                
                handleKeyDown(index, event) {
                    // Si presiona Backspace y el campo está vacío, ir al anterior
                    if (event.key === 'Backspace' && !this.digits[index] && index > 0) {
                        this.$nextTick(() => {
                            const prevInput = document.getElementById(`otp-${index - 1}`);
                            if (prevInput) {
                                prevInput.focus();
                                prevInput.select();
                            }
                        });
                    }
                    
                    // Si presiona ArrowLeft, ir al anterior
                    if (event.key === 'ArrowLeft' && index > 0) {
                        event.preventDefault();
                        const prevInput = document.getElementById(`otp-${index - 1}`);
                        if (prevInput) {
                            prevInput.focus();
                        }
                    }
                    
                    // Si presiona ArrowRight, ir al siguiente
                    if (event.key === 'ArrowRight' && index < 5) {
                        event.preventDefault();
                        const nextInput = document.getElementById(`otp-${index + 1}`);
                        if (nextInput) {
                            nextInput.focus();
                        }
                    }
                },
                
                handlePaste(event) {
                    event.preventDefault();
                    const pastedData = event.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, 6);
                    
                    // Llenar los dígitos con los datos pegados
                    for (let i = 0; i < 6; i++) {
                        this.digits[i] = pastedData[i] || '';
                    }
                    
                    // Focus en el siguiente campo vacío o el último
                    const nextEmptyIndex = this.digits.findIndex(d => !d);
                    const focusIndex = nextEmptyIndex === -1 ? 5 : Math.min(nextEmptyIndex, 5);
                    
                    this.$nextTick(() => {
                        const input = document.getElementById(`otp-${focusIndex}`);
                        if (input) {
                            input.focus();
                        }
                    });
                },
                
                submitForm() {
                    const code = this.digits.join('');
                    if (code.length === 6) {
                        // Crear un input temporal con el código completo
                        const form = this.$el;
                        const hiddenInput = form.querySelector('input[name="code"]');
                        if (hiddenInput) {
                            hiddenInput.value = code;
                        }
                        
                        // Enviar el formulario
                        form.submit();
                    }
                }
            }
        }
    </script>
</body>
</html>

