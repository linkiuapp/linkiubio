@extends('shared::layouts.tenant-admin')

@section('title', 'Pagar Suscripción')

@section('content')
    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('tenant.admin.billing.index', $store->slug) }}" 
               class="inline-flex items-center gap-2 text-xs text-gray-600 hover:text-gray-900 mb-4">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Volver a Facturación
            </a>
            <h1 class="text-lg font-semibold text-gray-900">Pagar Suscripción</h1>
            <p class="text-xs text-gray-600 mt-1">Renueva tu plan para seguir disfrutando de todos los beneficios</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Columna principal - Métodos de pago --}}
            <div class="lg:col-span-2">
                <form id="payment-form" 
                      method="POST" 
                      action="{{ route('tenant.admin.billing.process-payment', $store->slug) }}"
                      enctype="multipart/form-data"
                      x-data="checkoutForm()"
                      @submit.prevent="handleSubmit">
                    @csrf
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        {{-- Sección: Método de Pago --}}
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-base font-semibold text-gray-900 mb-6 flex items-center gap-2">
                                <i data-lucide="credit-card" class="w-5 h-5 text-blue-600"></i>
                                Método de Pago
                            </h2>
                            
                            {{-- Selección de Método de Pago --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                {{-- Opción: Transferencia Bancaria --}}
                                <label class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all"
                                       :class="paymentMethod === 'transfer' ? 'border-blue-600 bg-blue-50' : 'border-gray-200 hover:border-gray-300'">
                                    <input type="radio" 
                                           name="payment_method" 
                                           value="transfer"
                                           x-model="paymentMethod"
                                           class="sr-only">
                                    <div class="flex items-center gap-3 w-full">
                                        <div class="flex-shrink-0">
                                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center"
                                                 :class="paymentMethod === 'transfer' ? 'border-blue-600' : 'border-gray-300'">
                                                <div x-show="paymentMethod === 'transfer'" 
                                                     class="w-3 h-3 rounded-full bg-blue-600"></div>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <i data-lucide="landmark" class="w-5 h-5 text-blue-600"></i>
                                                <span class="font-semibold text-gray-900">Transferencia Bancaria</span>
                                            </div>
                                            <p class="text-xs text-gray-600">Paga mediante transferencia y sube tu comprobante</p>
                                        </div>
                                    </div>
                                </label>

                                @if($epaycoGateway)
                                {{-- Opción: Pago en Línea con Epayco --}}
                                <label class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all"
                                       :class="paymentMethod === 'epayco' ? 'border-green-600 bg-green-50' : 'border-gray-200 hover:border-gray-300'">
                                    <input type="radio" 
                                           name="payment_method" 
                                           value="epayco"
                                           x-model="paymentMethod"
                                           class="sr-only">
                                    <div class="flex items-center gap-3 w-full">
                                        <div class="flex-shrink-0">
                                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center"
                                                 :class="paymentMethod === 'epayco' ? 'border-green-600' : 'border-gray-300'">
                                                <div x-show="paymentMethod === 'epayco'" 
                                                     class="w-3 h-3 rounded-full bg-green-600"></div>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <i data-lucide="credit-card" class="w-5 h-5 text-green-600"></i>
                                                <span class="font-semibold text-gray-900">Pagar con ePayco</span>
                                            </div>
                                            <p class="text-xs text-gray-600">Tarjeta de crédito, débito o PSE</p>
                                        </div>
                                    </div>
                                </label>
                                @endif
                            </div>
                        </div>

                        {{-- Sección: Transferencia Bancaria --}}
                        <div x-show="paymentMethod === 'transfer'" x-transition class="p-6 border-b border-gray-200">
                            @if($paymentSetting)
                            {{-- Info de Transferencia --}}
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-6 mb-6">
                                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                    <i data-lucide="landmark" class="w-5 h-5 text-blue-600"></i>
                                    Datos para Transferencia
                                </h3>
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                    {{-- Datos bancarios --}}
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
                                            <p class="font-bold text-lg text-blue-600">${{ number_format($amount, 0, ',', '.') }} COP</p>
                                        </div>
                                    </div>

                                    {{-- QR Code --}}
                                    @if($paymentSetting->qr_code_image && $paymentSetting->qr_code_url)
                                    <div class="flex items-center justify-center">
                                        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-lg">
                                            <img src="{{ $paymentSetting->qr_code_url }}" 
                                                 alt="QR Code de Pago" 
                                                 class="w-32 h-32 object-contain">
                                            <p class="text-xs text-center text-gray-600 mt-2">Escanea para pagar</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            {{-- Upload Comprobante --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Subir Comprobante de Pago <span class="text-red-500">*</span>
                                </label>
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-500 transition-colors"
                                     :class="fileName ? 'border-green-500 bg-green-50' : ''">
                                    <input type="file" 
                                           name="payment_proof" 
                                           id="payment_proof"
                                           accept="image/*,.pdf"
                                           class="hidden"
                                           @change="handleFileSelect($event)"
                                           :required="paymentMethod === 'transfer'">
                                    <label for="payment_proof" class="cursor-pointer">
                                        <template x-if="!fileName">
                                            <div>
                                                <i data-lucide="upload-cloud" class="w-12 h-12 text-gray-400 mx-auto mb-3"></i>
                                                <p class="text-gray-700 font-medium mb-1">Click para seleccionar archivo</p>
                                                <p class="text-sm text-gray-500">JPG, PNG o PDF - Máximo 5MB</p>
                                            </div>
                                        </template>
                                        <template x-if="fileName">
                                            <div class="flex items-center justify-center gap-2 text-green-700">
                                                <i data-lucide="file-check" class="w-6 h-6"></i>
                                                <span class="font-medium" x-text="fileName"></span>
                                            </div>
                                        </template>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Sección: ePayco --}}
                        @if($epaycoGateway)
                        <div x-show="paymentMethod === 'epayco'" x-transition class="p-6 border-b border-gray-200">
                            <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
                                <i data-lucide="shield-check" class="w-12 h-12 text-green-600 mx-auto mb-3"></i>
                                <h3 class="font-bold text-gray-900 mb-2">Pago Seguro con ePayco</h3>
                                <p class="text-sm text-gray-600 mb-4">
                                    Serás redirigido a la pasarela de pago segura de ePayco para completar tu transacción.
                                </p>
                                <div class="flex items-center justify-center gap-4 text-xs text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="credit-card" class="w-4 h-4"></i>
                                        Tarjetas
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="building" class="w-4 h-4"></i>
                                        PSE
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="wallet" class="w-4 h-4"></i>
                                        Efecty
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- Botón de pago --}}
                        <div class="p-6 bg-gray-50">
                            <button type="submit"
                                    :disabled="isSubmitting || (paymentMethod === 'transfer' && !fileName)"
                                    class="w-full py-4 px-6 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white font-bold rounded-xl transition-colors flex items-center justify-center gap-2">
                                <template x-if="!isSubmitting">
                                    <span class="flex items-center gap-2">
                                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                                        <span x-text="paymentMethod === 'transfer' ? 'Enviar Comprobante' : 'Pagar ${{ number_format($amount, 0, ',', '.') }} COP'"></span>
                                    </span>
                                </template>
                                <template x-if="isSubmitting">
                                    <span class="flex items-center gap-2">
                                        <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Procesando...
                                    </span>
                                </template>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Columna lateral - Resumen --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-4">
                    <h3 class="font-bold text-gray-900 mb-4">Resumen de Pago</h3>
                    
                    {{-- Plan info --}}
                    <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="crown" class="w-6 h-6 text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">{{ $plan->name }}</p>
                            <p class="text-sm text-gray-600">{{ $subscription->billing_cycle_label }}</p>
                        </div>
                    </div>

                    {{-- Estado actual --}}
                    @if($isInTrial)
                    <div class="p-3 bg-amber-50 border border-amber-200 rounded-lg mb-4">
                        <p class="text-sm text-amber-800 flex items-center gap-2">
                            <i data-lucide="clock" class="w-4 h-4"></i>
                            <span>Período de prueba: <strong>{{ $daysRemaining }} días</strong> restantes</span>
                        </p>
                    </div>
                    @elseif($daysRemaining <= 0)
                    <div class="p-3 bg-red-50 border border-red-200 rounded-lg mb-4">
                        <p class="text-sm text-red-800 flex items-center gap-2">
                            <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                            <span>Tu suscripción ha vencido</span>
                        </p>
                    </div>
                    @elseif($daysRemaining <= 7)
                    <div class="p-3 bg-amber-50 border border-amber-200 rounded-lg mb-4">
                        <p class="text-sm text-amber-800 flex items-center gap-2">
                            <i data-lucide="clock" class="w-4 h-4"></i>
                            <span>Vence en <strong>{{ $daysRemaining }} días</strong></span>
                        </p>
                    </div>
                    @endif

                    {{-- Desglose --}}
                    <div class="space-y-3 py-4 border-t border-gray-200">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Plan {{ $plan->name }}</span>
                            <span class="text-gray-900">${{ number_format($plan->price, 0, ',', '.') }}/mes</span>
                        </div>
                        @if($subscription->billing_cycle !== 'monthly')
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Período {{ $subscription->billing_cycle_label }}</span>
                            <span class="text-green-600">Descuento aplicado</span>
                        </div>
                        @endif
                    </div>

                    {{-- Total --}}
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900">Total a pagar</span>
                            <span class="text-2xl font-bold text-blue-600">${{ number_format($amount, 0, ',', '.') }}</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">COP - Impuestos incluidos</p>
                    </div>

                    {{-- Garantías --}}
                    <div class="mt-6 pt-4 border-t border-gray-200 space-y-2">
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <i data-lucide="shield-check" class="w-4 h-4 text-green-600"></i>
                            Pago 100% seguro
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <i data-lucide="headphones" class="w-4 h-4 text-blue-600"></i>
                            Soporte 24/7
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <i data-lucide="refresh-cw" class="w-4 h-4 text-purple-600"></i>
                            Activación inmediata
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    function checkoutForm() {
        return {
            paymentMethod: 'transfer',
            fileName: '',
            isSubmitting: false,

            handleFileSelect(event) {
                const file = event.target.files[0];
                if (file) {
                    // Validar tamaño (5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('El archivo es muy grande. Máximo 5MB.');
                        event.target.value = '';
                        this.fileName = '';
                        return;
                    }
                    this.fileName = file.name;
                }
            },

            async handleSubmit() {
                if (this.isSubmitting) return;

                // Validar según método de pago
                if (this.paymentMethod === 'transfer' && !this.fileName) {
                    alert('Por favor sube el comprobante de pago');
                    return;
                }

                this.isSubmitting = true;

                try {
                    const form = document.getElementById('payment-form');
                    const formData = new FormData(form);

                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        if (data.redirect) {
                            // Mostrar mensaje y redirigir
                            alert(data.message);
                            window.location.href = data.redirect;
                        } else if (data.epayco_data) {
                            // Iniciar pago con ePayco
                            // TODO: Implementar integración con ePayco
                            alert('Redirigiendo a ePayco...');
                        }
                    } else {
                        alert(data.message || 'Error al procesar el pago');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error de conexión. Intenta de nuevo.');
                } finally {
                    this.isSubmitting = false;
                }
            }
        }
    }
    </script>
    @endpush
@endsection
