@extends('frontend.layouts.app')

@push('meta')
    <meta name="description" content="Finaliza tu pedido para {{ $type === 'mesa' ? 'Mesa' : 'Habitación' }} #{{ $table->table_number }} - {{ $store->name }}">
    <meta name="robots" content="noindex, nofollow">
@endpush

@section('content')
<div class="px-4 py-4 sm:py-6">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-brandPrimary-50 rounded-full mb-4">
                @if($type === 'mesa')
                    <i data-lucide="utensils" class="w-8 h-8 text-brandPrimary-300"></i>
                @else
                    <i data-lucide="bed" class="w-8 h-8 text-brandPrimary-300"></i>
                @endif
            </div>
            <h1 class="h1 text-brandNeutral-400 mb-2">
                Pedido - {{ $type === 'mesa' ? 'Mesa' : 'Habitación' }} #{{ $table->table_number }}
            </h1>
            <p class="caption text-brandNeutral-400">Revisa tu pedido y completa la información</p>
        </div>

        <!-- Resumen del Pedido -->
        <div class="bg-brandWhite-50 rounded-lg p-4 border border-brandWhite-300 mb-4">
            <h3 class="caption-strong text-brandNeutral-400 mb-4">Resumen del Pedido</h3>
            
            <div class="space-y-3 mb-4">
                @forelse($cart as $item)
                    <div class="flex items-center justify-between pb-3 border-b border-brandWhite-300 last:border-0">
                        <div class="flex-1">
                            <p class="caption text-brandNeutral-400">{{ $item['name'] ?? ($item['product_name'] ?? 'Producto') }}</p>
                            <p class="caption text-brandNeutral-300">Cantidad: {{ $item['quantity'] ?? 1 }}</p>
                            @if(!empty($item['variants']))
                                <p class="caption text-brandNeutral-300 text-xs">
                                    Variantes: {{ is_array($item['variants']) ? implode(', ', array_column($item['variants'], 'value')) : $item['variants'] }}
                                </p>
                            @endif
                        </div>
                        <p class="caption-strong text-brandNeutral-400">
                            ${{ number_format($item['item_total'] ?? (($item['price'] ?? 0) * ($item['quantity'] ?? 1)), 0, ',', '.') }}
                        </p>
                    </div>
                @empty
                    <p class="caption text-brandNeutral-300 text-center py-4">No hay productos en el carrito</p>
                @endforelse
            </div>

            <div class="space-y-2 pt-4 border-t border-brandWhite-300">
                <div class="flex items-center justify-between">
                    <span class="caption text-brandNeutral-400">Subtotal:</span>
                    <span class="caption-strong text-brandNeutral-400">${{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                
                @if($serviceCharge > 0)
                    <div class="flex items-center justify-between">
                        <span class="caption text-brandNeutral-400">Cargo de servicio:</span>
                        <span class="caption-strong text-brandNeutral-400">${{ number_format($serviceCharge, 0, ',', '.') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Propina Sugerida -->
        @if($dineInSettings->suggest_tip)
            <div class="bg-brandWhite-50 rounded-lg p-4 border border-brandWhite-300 mb-4">
                <h3 class="caption-strong text-brandNeutral-400 mb-4">Propina Sugerida</h3>
                
                <div class="space-y-3" id="tip-options">
                    @foreach($tipOptions as $tipPercent)
                        @php
                            $tipAmount = $subtotal * ($tipPercent / 100);
                        @endphp
                        <label class="flex items-center p-3 border border-brandWhite-300 rounded-lg cursor-pointer hover:bg-brandWhite-100 transition-colors tip-option">
                            <input 
                                type="radio" 
                                name="tip_percentage" 
                                value="{{ $tipPercent }}" 
                                class="mr-3"
                                {{ $tipPercent === 15 ? 'checked' : '' }}
                            >
                            <div class="flex-1">
                                <p class="caption text-brandNeutral-400">
                                    {{ $tipPercent === 0 ? 'Sin propina' : $tipPercent . '%' }}
                                    @if($tipPercent > 0)
                                        <span class="text-brandNeutral-300">(${{ number_format($tipAmount, 0, ',', '.') }})</span>
                                    @endif
                                </p>
                            </div>
                        </label>
                    @endforeach
                    
                    @if($dineInSettings->allow_custom_tip)
                        <label class="flex items-center p-3 border border-brandWhite-300 rounded-lg cursor-pointer hover:bg-brandWhite-100 transition-colors">
                            <input 
                                type="radio" 
                                name="tip_percentage" 
                                value="custom" 
                                class="mr-3"
                                id="tip-custom"
                            >
                            <div class="flex-1">
                                <p class="caption text-brandNeutral-400 mb-2">Propina personalizada:</p>
                                <input 
                                    type="number" 
                                    id="tip-custom-amount" 
                                    placeholder="$0" 
                                    min="0"
                                    class="w-full px-3 py-2 border border-brandWhite-300 rounded-lg caption"
                                    disabled
                                >
                            </div>
                        </label>
                    @endif
                </div>
            </div>
        @endif

        <!-- Formulario de Pedido -->
        <form id="dine-in-order-form" method="POST" action="{{ route('tenant.checkout.store', $store->slug) }}">
            @csrf
            <!-- Campos ocultos para dine_in/room_service -->
            <input type="hidden" name="order_type" value="{{ $type === 'mesa' ? 'dine_in' : 'room_service' }}">
            <input type="hidden" name="table_number" value="{{ $table->table_number }}">
            <input type="hidden" name="service_charge" id="service_charge" value="{{ $serviceCharge }}">
            <input type="hidden" name="tip_amount" id="tip_amount" value="0">
            <input type="hidden" name="tip_percentage" id="tip_percentage" value="0">
            
            <!-- Mensajes de error -->
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                    <p class="caption text-red-600">{{ session('error') }}</p>
                </div>
            @endif
            
            @if($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                    <p class="caption text-red-600 mb-2">Por favor corrige los siguientes errores:</p>
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div id="form-errors" class="hidden mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                <p class="caption text-red-600" id="error-message"></p>
            </div>

            <!-- Método de Pago -->
            <div class="bg-brandWhite-50 rounded-lg p-4 border border-brandWhite-300 mb-4">
                <h3 class="caption-strong text-brandNeutral-400 mb-4">Método de Pago</h3>
                
                <div class="space-y-3">
                    <label class="flex items-center p-3 border border-brandWhite-300 rounded-lg cursor-pointer hover:bg-brandWhite-100 transition-colors">
                        <input 
                            type="radio" 
                            name="payment_method" 
                            value="efectivo" 
                            class="mr-3"
                            checked
                            required
                        >
                        <div class="flex-1">
                            <p class="caption text-brandNeutral-400">Efectivo al {{ $type === 'mesa' ? 'mesero' : 'encargado' }}</p>
                        </div>
                    </label>
                    
                    <label class="flex items-center p-3 border border-brandWhite-300 rounded-lg cursor-pointer hover:bg-brandWhite-100 transition-colors">
                        <input 
                            type="radio" 
                            name="payment_method" 
                            value="card" 
                            class="mr-3"
                        >
                        <div class="flex-1">
                            <p class="caption text-brandNeutral-400">Tarjeta (datáfono)</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="bg-brandWhite-50 rounded-lg p-4 border border-brandWhite-300 mb-4">
                <h3 class="caption-strong text-brandNeutral-400 mb-4">Información de Contacto</h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="customer_name" class="block caption text-brandNeutral-400 mb-2">Nombre *</label>
                        <input 
                            type="text" 
                            id="customer_name" 
                            name="customer_name" 
                            class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption"
                            placeholder="Tu nombre"
                            value="{{ old('customer_name') }}"
                            required
                        >
                        @error('customer_name')
                            <p class="caption text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="customer_phone" class="block caption text-brandNeutral-400 mb-2">Celular (opcional)</label>
                        <input 
                            type="tel" 
                            id="customer_phone" 
                            name="customer_phone" 
                            class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption"
                            placeholder="3001234567"
                            value="{{ old('customer_phone') }}"
                        >
                        @error('customer_phone')
                            <p class="caption text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Total -->
            <div class="bg-brandPrimary-50 rounded-lg p-4 border border-brandPrimary-300 mb-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="caption-strong text-brandNeutral-400">Total a Pagar:</span>
                    <span class="h3 text-brandPrimary-300" id="total-display">
                        ${{ number_format($subtotal + $serviceCharge, 0, ',', '.') }}
                    </span>
                </div>
                @if($dineInSettings->suggest_tip)
                    <p class="caption text-brandNeutral-300 text-right" id="tip-display">
                        (Incluye propina: $0)
                    </p>
                @endif
            </div>
            
            <button 
                type="submit" 
                class="w-full bg-brandPrimary-300 hover:bg-brandPrimary-200 text-brandWhite-100 py-3 rounded-full caption-strong transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                id="submit-order-btn"
            >
                Enviar Pedido
            </button>
        </form>

        <p class="text-center caption text-brandNeutral-300 mt-4">
            ⚠️ No se requiere dirección ni envío
        </p>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const subtotal = {{ $subtotal }};
    const serviceCharge = {{ $serviceCharge }};
    let tipAmount = 0;
    let tipPercentage = 0;

    // Calcular total inicial
    function updateTotal() {
        const total = subtotal + serviceCharge + tipAmount;
        document.getElementById('total-display').textContent = '$' + total.toLocaleString('es-CO');
        
        // Actualizar inputs ocultos
        document.getElementById('tip_amount').value = tipAmount;
        document.getElementById('tip_percentage').value = tipPercentage;
        
        // Actualizar display de propina
        const tipDisplay = document.getElementById('tip-display');
        if (tipDisplay) {
            tipDisplay.textContent = tipAmount > 0 
                ? `(Incluye propina: $${tipAmount.toLocaleString('es-CO')})` 
                : '(Sin propina)';
        }
    }

    // Manejar selección de propina
    const tipOptions = document.querySelectorAll('input[name="tip_percentage"]');
    tipOptions.forEach(option => {
        option.addEventListener('change', function() {
            if (this.value === 'custom') {
                const customInput = document.getElementById('tip-custom-amount');
                if (customInput) {
                    customInput.disabled = false;
                    customInput.focus();
                }
            } else {
                const customInput = document.getElementById('tip-custom-amount');
                if (customInput) {
                    customInput.disabled = true;
                }
                tipPercentage = parseInt(this.value);
                tipAmount = subtotal * (tipPercentage / 100);
                updateTotal();
            }
        });
    });

    // Manejar propina personalizada
    const customTipInput = document.getElementById('tip-custom-amount');
    if (customTipInput) {
        customTipInput.addEventListener('input', function() {
            if (document.getElementById('tip-custom') && document.getElementById('tip-custom').checked) {
                tipAmount = parseFloat(this.value) || 0;
                tipPercentage = subtotal > 0 ? Math.round((tipAmount / subtotal) * 100) : 0;
                updateTotal();
            }
        });
    }

    // Calcular propina inicial (15% seleccionado por defecto)
    const defaultTip = document.querySelector('input[name="tip_percentage"][value="15"]');
    if (defaultTip && defaultTip.checked) {
        tipPercentage = 15;
        tipAmount = subtotal * (tipPercentage / 100);
        updateTotal();
    }

    // Manejar envío del formulario
    const form = document.getElementById('dine-in-order-form');
    const errorDiv = document.getElementById('form-errors');
    const errorMessage = document.getElementById('error-message');
    
    form.addEventListener('submit', function(e) {
        // Validar campos requeridos antes de enviar
        const customerName = document.getElementById('customer_name').value.trim();
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked')?.value;
        
        // Validar campos requeridos
        if (!customerName) {
            e.preventDefault();
            showError('Por favor ingresa tu nombre');
            document.getElementById('customer_name').focus();
            return false;
        }
        
        if (!paymentMethod) {
            e.preventDefault();
            showError('Por favor selecciona un método de pago');
            return false;
        }
        
        // Ocultar errores previos
        hideError();
        
        // Deshabilitar botón mientras se procesa
        const submitBtn = document.getElementById('submit-order-btn');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Enviando...';
        }
        
        // Log para debugging
        console.log('Submitting form:', {
            customer_name: customerName,
            payment_method: paymentMethod,
            order_type: document.querySelector('input[name="order_type"]')?.value,
            table_number: document.querySelector('input[name="table_number"]')?.value
        });
        
        // Permitir que el formulario se envíe normalmente
        return true;
    });
    
    function showError(message) {
        if (errorDiv && errorMessage) {
            errorMessage.textContent = message;
            errorDiv.classList.remove('hidden');
            errorDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else {
            alert(message);
        }
    }
    
    function hideError() {
        if (errorDiv) {
            errorDiv.classList.add('hidden');
        }
    }
});
</script>
@endpush
@endsection

