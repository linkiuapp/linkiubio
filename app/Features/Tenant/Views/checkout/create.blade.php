@extends('frontend.layouts.app')

@push('meta')
    <meta name="description" content="Finaliza tu compra en {{ $store->name }} - Proceso de checkout seguro y rápido">
    <meta name="robots" content="noindex, nofollow">
@endpush

@section('content')
<div class="px-4 py-4 sm:py-6">
    <!-- Checkout Container -->
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="h1 text-brandNeutral-400 mb-2">Finalizar compra</h1>
            <p class="caption text-brandNeutral-400">Completa tu información para procesar tu pedido</p>
        </div>

        <!-- Main Checkout Layout - Single Column -->
        <div class="mx-auto">

            <!-- CARD 1: DATOS PERSONALES -->
            <div id="card-step1" class="bg-brandWhite-50 rounded-lg p-4 border border-brandWhite-300 mb-4">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-brandPrimary-50 text-brandPrimary-300 rounded-full flex items-center justify-center caption-strong mr-3">1</div>
                    <h3 class="caption-strong text-brandNeutral-400">Datos Personales</h3>
                </div>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="customer_name" class="block caption text-brandNeutral-400 mb-2">Nombre Completo *</label>
                        <input 
                            type="text" 
                            id="customer_name" 
                            name="customer_name" 
                            class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption"
                            placeholder="Nombre completo"
                        >
                        <div id="name_error" class="hidden mt-1 caption text-brandError-400"></div>
                    </div>
                    
                    <div>
                        <label for="customer_phone" class="block caption text-brandNeutral-400 mb-2">Número de Celular *</label>
                        <input 
                            type="tel" 
                            id="customer_phone" 
                            name="customer_phone" 
                            class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption"
                            placeholder="3001234567"
                        >
                        <div id="phone_error" class="hidden mt-1 caption text-brandError-400"></div>
                    </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button 
                            type="button" 
                            id="btn-continue-step1" 
                            class="bg-brandPrimary-300 hover:bg-brandPrimary-200 text-brandWhite-100 py-3 px-6 rounded-full caption transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled
                        >
                            Continuar al Paso 2
                        </button>
                    </div>
                </div>
            </div>

            <!-- CARD 2: MÉTODO DE ENVÍO -->
            <div id="card-step2" class="bg-brandWhite-50 rounded-lg p-4 border border-brandWhite-300 mb-4 hidden">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-brandPrimary-50 text-brandPrimary-300 rounded-full flex items-center justify-center caption-strong mr-3">2</div>
                    <h3 class="caption-strong text-brandNeutral-400">Método de Envío</h3>
                </div>
                
                <div class="space-y-4">
                    <div id="shipping-methods-container" class="space-y-3">
                        <!-- Los métodos de envío se cargan dinámicamente aquí -->
                        <div class="text-center py-4">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-brandPrimary-300 mx-auto"></div>
                            <p class="caption text-brandNeutral-400 mt-2">Cargando métodos de envío...</p>
                        </div>
                    </div>
                    
                    <!-- Selector de Mesa (para Consumo en Local) -->
                    <div id="table-selector-container" class="hidden space-y-4 mb-4">
                        <div>
                            <label for="selected_table_number" class="block caption text-brandNeutral-400 mb-2">
                                Selecciona tu Mesa *
                            </label>
                            <select 
                                id="selected_table_number" 
                                name="selected_table_number"
                                class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption focus:border-brandPrimary-300 focus:ring-1 focus:ring-brandPrimary-300"
                                required
                            >
                                <option value="">-- Selecciona una mesa --</option>
                                <!-- Se cargarán dinámicamente -->
                            </select>
                            <p class="caption text-brandNeutral-300 mt-1">
                                Elige la mesa donde deseas consumir
                            </p>
                        </div>
                    </div>

                    <!-- Selector de Habitación (para Servicio a Habitación) -->
                    <div id="room-selector-container" class="hidden space-y-4 mb-4">
                        <div>
                            <label for="selected_room_number" class="block caption text-brandNeutral-400 mb-2">
                                Selecciona tu Habitación *
                            </label>
                            <select 
                                id="selected_room_number" 
                                name="selected_room_number"
                                class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption focus:border-brandPrimary-300 focus:ring-1 focus:ring-brandPrimary-300"
                                required
                            >
                                <option value="">-- Selecciona una habitación --</option>
                                <!-- Se cargarán dinámicamente -->
                            </select>
                            <p class="caption text-brandNeutral-300 mt-1">
                                Elige la habitación a la que deseas que se envíe el servicio
                            </p>
                        </div>
                    </div>
                    
                    <!-- Address Fields for Local Shipping (only address) -->
                    <div id="address-fields-local" class="hidden space-y-4">
                    <div>
                        <label for="customer_address" class="block caption text-brandNeutral-400 mb-2">Dirección Completa *</label>
                        <textarea 
                            id="customer_address" 
                            name="customer_address" 
                            rows="2"
                            class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption resize-none"
                            placeholder="Calle, carrera, número, apartamento, referencias..."
                        ></textarea>
                    </div>
                    </div>

                    <!-- Address Fields for National Shipping (department + city + address) -->
                    <div id="address-fields-national" class="hidden space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="department" class="block caption text-brandNeutral-400 mb-2">Departamento *</label>
                            <select 
                                id="department" 
                                name="department" 
                                class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption"
                            >
                                <option value="">Selecciona tu departamento</option>
                                <!-- Se cargarán dinámicamente desde las zonas configuradas -->
                            </select>
                        </div>
                        
                        <div>
                            <label for="city" class="block caption text-brandNeutral-400 mb-2">Ciudad *</label>
                            <select 
                                id="city" 
                                name="city" 
                                class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption"
                                disabled
                            >
                                <option value="">Primero selecciona un departamento</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label for="customer_address_national" class="block caption text-brandNeutral-400 mb-2">Dirección Completa *</label>
                        <textarea 
                            id="customer_address_national" 
                            name="customer_address" 
                            rows="2"
                            class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg resize-none caption"
                            placeholder="Calle, carrera, número, apartamento, referencias..."
                        ></textarea>
                    </div>
                    </div>
                    
                    <div class="flex gap-3">
                        <button 
                            type="button" 
                            id="btn-back-step2" 
                            class="px-4 py-2 bg-brandWhite-50 hover:bg-brandWhite-100 text-brandNeutral-400 rounded-full caption transition-colors border border-brandWhite-300 text-center"
                        >
                            Volver
                        </button>
                        <button 
                            type="button" 
                            id="btn-continue-step2" 
                            class="flex-1 bg-brandPrimary-300 hover:bg-brandPrimary-200 text-brandWhite-100 py-3 rounded-full caption transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled
                        >
                            Continuar al Paso 3
                        </button>
                    </div>
                </div>
            </div>

            <!-- CARD 3: MÉTODO DE PAGO -->
            <div id="card-step3" class="bg-brandWhite-50 rounded-lg p-4 border border-brandWhite-300 mb-4 hidden">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-brandPrimary-50 text-brandPrimary-300 rounded-full flex items-center justify-center caption-strong mr-3">3</div>
                    <h3 class="caption-strong text-brandNeutral-400">Método de Pago</h3>
                </div>
                
                <div class="space-y-4">
                    <div id="payment-methods-container" class="space-y-3">
                        <!-- Los métodos de pago se cargan dinámicamente aquí -->
                        <div class="text-center py-4">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-brandPrimary-300 mx-auto"></div>
                            <p class="caption text-brandNeutral-400 mt-2">Cargando métodos de pago...</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-3">
                        <button 
                            type="button" 
                            id="btn-back-step3" 
                            class="px-4 py-2 bg-brandWhite-50 hover:bg-brandWhite-100 text-brandNeutral-400 rounded-full caption transition-colors border border-brandWhite-300 text-center"
                        >
                            Volver
                        </button>
                        <button 
                            type="button" 
                            id="btn-submit-order" 
                            class="flex-1 bg-brandPrimary-300 hover:bg-brandPrimary-200 text-brandWhite-100 py-3 rounded-full caption transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled
                        >
                            Finalizar compra
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Resumen integrado al final -->
            <div class="border-t border-accent-200 pt-6 mt-6 px-4">
                <h3 class="caption-strong text-brandNeutral-400 mb-4">Resumen del Pedido</h3>
                
                <!-- Products List -->
                <div id="order-products" class="space-y-3 mb-4">
                    <div class="text-center py-4">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-300 mx-auto"></div>
                        <p class="caption text-brandNeutral-400 mt-2">Cargando productos...</p>
                    </div>
                </div>
                
                <!-- Coupon Section -->
                <div class="border-t border-accent-200 pt-4 mb-4">
                    <div class="flex items-center gap-2 mb-3">
                        <i data-lucide="ticket" class="w-5 h-5 text-brandPrimary-300"></i>
                        <h4 class="caption text-brandNeutral-400">Cupón de Descuento</h4>
                    </div>
                    
                    <div class="flex gap-2">
                        <input 
                            type="text" 
                            id="coupon_code" 
                            name="coupon_code" 
                            class="flex-1 px-3 py-2 border border-brandWhite-300 rounded-lg caption"
                            placeholder="Código de cupón"
                            maxlength="50"
                        >
                        <button 
                            type="button" 
                            id="apply-coupon-btn" 
                            class="px-4 py-2 bg-brandPrimary-300 hover:bg-brandPrimary-200 text-brandWhite-100 rounded-full caption transition-colors text-center"
                        >
                            Aplicar
                        </button>
                    </div>
                    
                    <div id="coupon_error" class="hidden mt-1 caption text-brandError-400"></div>
                </div>
                
                <!-- Sección de productos eliminada - ya está en "Resumen del Pedido" -->

                <!-- Totals -->
                <div class="border-t border-brandWhite-300 pt-4 space-y-3 mb-4">
                    <!-- Subtotal productos -->
                    <div class="flex justify-between items-center">
                        <span class="caption text-brandNeutral-400">Subtotal productos:</span>
                        <span class="caption text-brandNeutral-400" id="summary-subtotal">$0</span>
                    </div>
                    
                    <!-- Envío -->
                    <div class="flex justify-between items-center">
                        <span class="caption text-brandNeutral-400">Costo de envío:</span>
                        <span class="caption text-brandNeutral-400" id="summary-shipping">Calculando...</span>
                    </div>
                    
                    <!-- Descuento cupón (oculto por defecto) -->
                    <div id="coupon-discount-row" class="hidden flex justify-between items-center">
                        <span class="caption text-brandNeutral-400">Descuento cupón:</span>
                        <span class="caption text-brandNeutral-400" id="summary-discount">-$0</span>
                    </div>
                    
                    <!-- Línea separadora -->
                    <div class="border-t border-brandWhite-300 pt-3">
                        <div class="flex justify-between items-center">
                            <span class="caption-strong text-brandNeutral-400">Total a pagar:</span>
                            <span class="caption-strong text-brandNeutral-400" id="summary-total">$0</span>
                        </div>
                    </div>
                    
                    <!-- Desglose productos -->
                    <div id="product-breakdown" class="hidden border-t border-brandWhite-300 pt-3">
                        <div class="caption text-brandNeutral-400 mb-2">
                            <span class="caption-strong">Cantidad total de productos:</span>
                            <span id="total-quantity">0</span>
                        </div>
                        <div class="caption text-brandNeutral-400">
                            <span class="caption-strong">Productos únicos:</span>
                            <span id="unique-products">0</span>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Variables globales MUY simples
let currentStep = 1;

// Variables globales para métodos
let shippingMethods = [];
let paymentMethods = [];

// DOM ready
document.addEventListener('DOMContentLoaded', function() {
    initCheckout();
    loadOrderSummary(); // Esta es la función de la línea 1425+
    loadShippingMethods();
    loadPaymentMethods();
    loadDepartmentsAndCities(); // Cargar departamentos/ciudades para envío nacional
});

// Variables globales para totales
let cartSubtotal = 0;
let shippingCost = 0;
let discountAmount = 0;
let cartItems = [];

// Inicializar todo
function initCheckout() {
    // Mostrar solo paso 1
    showStep(1);
    
    // Event listeners básicos
    setupEvents();
}

// Configurar eventos básicos
function setupEvents() {
    // Paso 1 - validación nombre/teléfono
    const nameInput = document.getElementById('customer_name');
    const phoneInput = document.getElementById('customer_phone');
    
    nameInput.addEventListener('input', checkStep1);
    phoneInput.addEventListener('input', checkStep1);
    
    // Botones navegación
    document.getElementById('btn-continue-step1').addEventListener('click', () => {
        showStep(2);
    });
    
    document.getElementById('btn-back-step2').addEventListener('click', () => {
        showStep(1);
    });
    
    document.getElementById('btn-continue-step2').addEventListener('click', () => {
        showStep(3);
    });
    
    document.getElementById('btn-back-step3').addEventListener('click', () => {
        showStep(2);
    });
    
    // Address fields validation (los delivery type listeners se configuran en renderShippingMethods)
    document.getElementById('department').addEventListener('change', () => {
        onDepartmentChange();
        enableStep2Button();
    });
    document.getElementById('city').addEventListener('change', enableStep2Button); // Cambio de 'input' a 'change' porque ahora es select
    document.getElementById('customer_address').addEventListener('input', enableStep2Button);
    document.getElementById('customer_address_national').addEventListener('input', enableStep2Button);
    
    // Payment method listeners se configuran en renderPaymentMethods()
    // Cash amount listeners se configuran en renderPaymentMethods()
    
    // Coupon listeners
    const applyCouponBtn = document.getElementById('apply-coupon-btn');
    const couponCodeInput = document.getElementById('coupon_code');
    
    if (applyCouponBtn) {
        applyCouponBtn.addEventListener('click', applyCoupon);
    }
    
    if (couponCodeInput) {
        couponCodeInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                applyCoupon();
            }
        });
    }
    
    // Submit order button
    document.getElementById('btn-submit-order').addEventListener('click', submitOrder);
}

// Mostrar paso específico
function showStep(step) {
    // Ocultar todos
    document.getElementById('card-step1').classList.add('hidden');
    document.getElementById('card-step2').classList.add('hidden');
    document.getElementById('card-step3').classList.add('hidden');
    
    // Mostrar actual
    const currentCard = document.getElementById(`card-step${step}`);
    if (currentCard) {
        currentCard.classList.remove('hidden');
        
        // Si se muestra el paso 3, intentar habilitar el botón si ya hay métodos de pago cargados
        if (step === 3) {
            // Pequeño delay para asegurar que el DOM esté actualizado
            setTimeout(() => {
                enableStep3Button();
            }, 100);
        }
    }
    
    currentStep = step;
}

// Validar paso 1 (nombre + teléfono)
function checkStep1() {
    const name = document.getElementById('customer_name').value.trim();
    const phone = document.getElementById('customer_phone').value.trim();
    
    const nameOk = name.length >= 2;
    const phoneOk = /^3[0-9]{9}$/.test(phone);
    const valid = nameOk && phoneOk;
    
    const btn = document.getElementById('btn-continue-step1');
    btn.disabled = !valid;
}

// Habilitar botón paso 2
function enableStep2Button() {
    const deliveryType = document.querySelector('input[name="delivery_type"]:checked');
    const btn = document.getElementById('btn-continue-step2');
    
    if (!deliveryType) {
        btn.disabled = true;
        return;
    }
    
    // Verificar si es dine_in o room_service (requieren mesa/habitación, no dirección)
    const orderType = deliveryType.dataset.orderType;
    if (orderType === 'dine_in') {
        // Para dine_in: validar que se haya seleccionado una mesa
        const tableSelect = document.getElementById('selected_table_number');
        if (tableSelect && tableSelect.value) {
            btn.disabled = false;
        } else {
            btn.disabled = true;
        }
        return;
    }
    
    if (orderType === 'room_service') {
        // Para room_service: validar que se haya seleccionado una habitación
        const roomSelect = document.getElementById('selected_room_number');
        if (roomSelect && roomSelect.value) {
            btn.disabled = false;
        } else {
            btn.disabled = true;
        }
        return;
    }
    
    if (deliveryType.value === 'pickup') {
        btn.disabled = false;
        return;
    }
    
    // Para domicilio, validar campos según el tipo de envío
    const shippingType = deliveryType.dataset.shippingType;
    let isValid = false;
    
    if (shippingType === 'local') {
        // Para envío local: solo validar dirección
        const address = document.getElementById('customer_address').value.trim();
        isValid = address.length >= 10;
        
        // Para local, calcular envío con ciudad de la tienda
        if (isValid) {
            calculateShippingCost(null, '{{ $store->city ?? "" }}');
        }
    } else if (shippingType === 'nacional') {
        // Para envío nacional: validar departamento + ciudad + dirección
        const department = document.getElementById('department').value.trim();
        const city = document.getElementById('city').value.trim();
        const address = document.getElementById('customer_address_national').value.trim();
        isValid = department && city.length >= 2 && address.length >= 10;
        
        // Para nacional, calcular envío con departamento y ciudad
        if (isValid) {
            calculateShippingCost(department, city);
        }
    }
    
    btn.disabled = !isValid;
}

// Manejar cambio de método de pago
function handlePaymentMethodChange(paymentMethod, methodId) {
    // Ocultar todos los campos de métodos
    document.querySelectorAll('[id^="cash-fields-"], [id^="transfer-fields-"]').forEach(field => {
        field.classList.add('hidden');
    });
    
    // Mostrar campos relevantes
    if (paymentMethod === 'efectivo') {
        const cashFields = document.getElementById(`cash-fields-${methodId}`);
        if (cashFields) {
            cashFields.classList.remove('hidden');
        }
    } else if (paymentMethod === 'transferencia') {
        const transferFields = document.getElementById(`transfer-fields-${methodId}`);
        if (transferFields) {
            transferFields.classList.remove('hidden');
        }
    }
}

// Manejar cambio de monto en efectivo
function handleCashAmountChange(e) {
    const cashAmount = parseFloat(e.target.value) || 0;
    const changeDisplay = document.getElementById('change-display');
    const changeAmount = document.getElementById('change-amount');
    const currentTotal = getCurrentSubtotal() + getCurrentShipping() - getCurrentDiscount();
    
    // Validar que los elementos existan
    if (!changeDisplay || !changeAmount) {
        return;
    }
    
    if (cashAmount >= currentTotal && cashAmount > 0) {
        const change = cashAmount - currentTotal;
        changeAmount.textContent = `$${formatPrice(change)}`;
        changeDisplay.classList.remove('hidden');
    } else {
        changeDisplay.classList.add('hidden');
    }
    
    enableStep3Button();
}

// Habilitar botón paso 3
function enableStep3Button() {
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
    const btn = document.getElementById('btn-submit-order');
    
    if (!btn) {
        return; // El botón aún no existe en el DOM
    }
    
    if (!paymentMethod) {
        btn.disabled = true;
        return;
    }
    
    if (paymentMethod.value === 'efectivo') {
        const cashAmount = parseFloat(document.getElementById('cash_amount').value) || 0;
        const currentTotal = getCurrentSubtotal() + getCurrentShipping() - getCurrentDiscount();
        const isValid = cashAmount >= currentTotal && cashAmount > 0;
        
        btn.disabled = !isValid;
    } else {
        // Transferencia siempre es válida
        btn.disabled = false;
    }
    
    // Actualizar texto del botón con el total
    updateSubmitButtonText();
}

// Actualizar texto del botón de finalizar con el total
function updateSubmitButtonText() {
    const btn = document.getElementById('btn-submit-order');
    if (!btn) {
        return; // El botón aún no existe en el DOM
    }
    
    const currentTotal = getCurrentSubtotal() + getCurrentShipping() - getCurrentDiscount();
    
    if (currentTotal > 0) {
        btn.innerHTML = `Valor a pagar $${formatPrice(currentTotal)}`;
    } else {
        btn.innerHTML = 'Finalizar compra';
    }
}

// Copiar al portapapeles
function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    const text = element.textContent;
    
    navigator.clipboard.writeText(text).then(() => {
        // Cambiar temporalmente el texto del botón
        const button = element.nextElementSibling;
        const originalText = button.textContent;
        button.textContent = '¡Copiado!';
        button.classList.add('bg-brandSuccess-300', 'text-brandWhite-100');
        
        setTimeout(() => {
            button.textContent = originalText;
            button.classList.remove('bg-brandSuccess-300', 'text-brandWhite-100');
        }, 2000);
    }).catch(err => {
        alert('No se pudo copiar. Copia manualmente: ' + text);
    });
}

// REMOVED - Función duplicada eliminada

// Mostrar productos en el resumen
function displayOrderProducts(items) {
    const container = document.getElementById('order-products');
    
    let html = '';
    let totalQuantity = 0;
    
    items.forEach((item, index) => {
        // Asegurar que los precios sean números válidos
        const basePrice = parseFloat(item.product_price || item.price) || 0;
        const variantModifier = parseFloat(item.variant_details?.precio_modificador) || 0;
        const quantity = parseInt(item.quantity) || 0;
        
        const unitPrice = basePrice + variantModifier;
        const totalPrice = unitPrice * quantity;
        totalQuantity += quantity;
        
        html += `
            <div class="flex items-center gap-3 py-2 border-b border-brandWhite-300 last:border-b-0">
                <img src="${item.image_url || (item.product && item.product.main_image_url) || '{{ asset("assets/images/placeholder-product.svg") }}'}" 
                     alt="${item.product_name || item.product?.name || 'Producto'}" 
                     class="w-12 h-12 object-cover rounded-lg">
                <div class="flex-1 min-w-0">
                    <h4 class="caption text-brandNeutral-400 truncate">${item.product_name || item.product?.name || 'Producto'}</h4>
                    ${item.variant_display ? `<p class="caption text-brandNeutral-400">${item.variant_display}</p>` : ''}
                    <div class="flex items-center justify-between mt-1">
                        <span class="caption text-brandNeutral-400">Cantidad: ${item.quantity}</span>
                        <span class="caption-strong text-brandNeutral-400">$${formatPrice(totalPrice)}</span>
                    </div>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
    
    // Actualizar desglose de productos
    document.getElementById('total-quantity').textContent = totalQuantity;
    document.getElementById('unique-products').textContent = items.length;
    document.getElementById('product-breakdown').classList.remove('hidden');
}

// Actualizar totales
function updateOrderTotals(subtotal, shipping, discount) {
    document.getElementById('summary-subtotal').textContent = `$${formatPrice(subtotal)}`;
    document.getElementById('summary-shipping').textContent = shipping > 0 ? `$${formatPrice(shipping)}` : 'GRATIS';
    
    // Mostrar/ocultar descuento de cupón
    const discountRow = document.getElementById('coupon-discount-row');
    if (discount > 0) {
        discountRow.classList.remove('hidden');
        document.getElementById('summary-discount').textContent = `-$${formatPrice(discount)}`;
    } else {
        discountRow.classList.add('hidden');
    }
    
    const total = subtotal + shipping - discount;
    document.getElementById('summary-total').textContent = `$${formatPrice(total)}`;
    
    // Actualizar validación del paso 3 si está en efectivo
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
    if (paymentMethod && paymentMethod.value === 'efectivo') {
        handleCashAmountChange({ target: document.getElementById('cash_amount') });
    }
    
    // Actualizar texto del botón
    updateSubmitButtonText();
}

// FUNCIÓN PROBLEMÁTICA ELIMINADA COMPLETAMENTE - Solo usar la de línea 1583+

// Obtener subtotal actual (helper)
function getCurrentSubtotal() {
    const subtotalText = document.getElementById('summary-subtotal').textContent;
    return parseInt(subtotalText.replace(/\D/g, '')) || 0;
}

// Obtener descuento actual (helper)
function getCurrentDiscount() {
    const discountElement = document.getElementById('summary-discount');
    if (!discountElement || discountElement.closest('.hidden')) return 0;
    const discountText = discountElement.textContent;
    return parseInt(discountText.replace(/\D/g, '')) || 0;
}

// Obtener envío actual (helper)
function getCurrentShipping() {
    const shippingText = document.getElementById('summary-shipping').textContent;
    if (shippingText.includes('GRATIS')) return 0;
    return parseInt(shippingText.replace(/\D/g, '')) || 0;
}

// Cargar métodos de envío disponibles
async function loadShippingMethods() {
    try {
        const response = await fetch('{{ route("tenant.checkout.shipping-methods", $store->slug) }}');
        const data = await response.json();
        
        if (data.success) {
            shippingMethods = data.methods;
            renderShippingMethods();
        }
    } catch (error) {
        // Error silencioso - métodos de envío no disponibles
    }
}

// Renderizar métodos de envío en el HTML
function renderShippingMethods() {
    const container = document.querySelector('#card-step2 .space-y-3');
    
    let html = '';
    
    shippingMethods.forEach(method => {
        if (method.type === 'pickup') {
            html += `
                <div class="border border-brandWhite-300 rounded-lg p-4 hover:border-brandPrimary-300 transition-colors">
                    <label class="flex items-center cursor-pointer">
                        <input 
                            type="radio" 
                            name="delivery_type" 
                            value="pickup"
                            data-method-id="${method.id}"
                            class="mr-3 text-brandPrimary-300 focus:ring-brandPrimary-300 w-4 h-4"
                        >
                        <div class="flex items-center justify-center w-12 h-12 bg-brandPrimary-50 rounded-lg mr-3">
                            <span class="caption-strong text-brandNeutral-400">${method.icon}</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="caption-strong text-brandNeutral-400">${method.name}</h4>
                                    <p class="caption text-brandNeutral-400">${method.instructions || 'Recoge tu pedido en nuestra tienda física'}</p>
                                    ${method.pickup_address ? `<p class="caption text-brandNeutral-400 mt-1">📍 ${method.pickup_address}</p>` : ''}
                                </div>
                                <span class="bg-brandSuccess-100 text-brandSuccess-400 caption px-3 py-1 rounded-full caption-strong">GRATIS</span>
                            </div>
                        </div>
                    </label>
                </div>
            `;
        } else if (method.type === 'domicilio') {
            const zoneInfo = method.zones?.length > 0 ? 
                `Desde ${method.zones[0].formatted_cost} - ${method.zones.map(z => z.name).join(', ')}` : 
                'Zonas disponibles';
                
            html += `
                <div class="border border-brandWhite-300 rounded-lg p-4 hover:border-brandPrimary-300 transition-colors">
                    <label class="flex items-center cursor-pointer">
                        <input 
                            type="radio" 
                            name="delivery_type" 
                            value="domicilio"
                            data-method-id="${method.id}"
                            class="mr-3 text-brandPrimary-300 focus:ring-brandPrimary-300 w-4 h-4"
                        >
                        <div class="flex items-center justify-center w-12 h-12 bg-brandPrimary-50 rounded-lg mr-3">
                            <span class="caption-strong text-brandNeutral-400">${method.icon}</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="caption-strong text-brandNeutral-400">${method.name}</h4>
                                    <p class="caption text-brandNeutral-400">${method.instructions || 'Entregamos en tu dirección'}</p>
                                    <p class="caption text-brandNeutral-400 mt-1">${zoneInfo}</p>
                                </div>
                                <div id="shipping-cost-display" class="hidden caption text-brandNeutral-400"></div>
                            </div>
                        </div>
                    </label>
                </div>
            `;
        }
    });
    
    container.innerHTML = html;
    
    // Re-configurar event listeners
    document.querySelectorAll('input[name="delivery_type"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            const addressFieldsLocal = document.getElementById('address-fields-local');
            const addressFieldsNational = document.getElementById('address-fields-national');
            
            // Ocultar ambos campos primero
            addressFieldsLocal.classList.add('hidden');
            addressFieldsNational.classList.add('hidden');
            
            if (e.target.value === 'domicilio') {
                const shippingType = e.target.dataset.shippingType;
                
                if (shippingType === 'local') {
                    // Solo mostrar campo de dirección para local
                    addressFieldsLocal.classList.remove('hidden');
                    // Limpiar campos nacionales
                    document.getElementById('department').value = '';
                    document.getElementById('city').value = '';
                    document.getElementById('customer_address_national').value = '';
                } else if (shippingType === 'nacional') {
                    // Mostrar departamento + ciudad + dirección para nacional
                    addressFieldsNational.classList.remove('hidden');
                    // Limpiar campo local
                    document.getElementById('customer_address').value = '';
                }
            }
            enableStep2Button();
        });
    });
}

// Cargar métodos de envío disponibles
async function loadShippingMethods() {
    try {
        // Usar los métodos pasados desde el controlador por ahora
        const shippingData = @json($shippingMethods ?? []);
        
        shippingMethods = shippingData;
        renderShippingMethods();
    } catch (error) {
        // Error silencioso - métodos de envío no disponibles
    }
}

// Renderizar métodos de envío en el HTML
function renderShippingMethods() {
    const container = document.querySelector('#shipping-methods-container');
    if (!container) {
        return;
    }
    
    let html = '';
    
    // Siempre mostrar opción de pickup si está habilitado
    let hasPickup = false;
    let hasLocal = false;
    let hasNational = false;
    
    shippingMethods.forEach(method => {
        
        if (method.type === 'pickup') {
            hasPickup = true;
            html += `
                <label class="flex items-center p-4 border border-brandWhite-300 rounded-lg cursor-pointer hover:bg-brandWhite-50 transition-colors">
                    <input 
                        type="radio" 
                        name="delivery_type" 
                        value="pickup"
                        data-shipping-type="pickup"
                        class="mr-3 w-4 h-4 text-brandPrimary-500 border-brandWhite-300 focus:ring-brandPrimary-300"
                    >
                    <div class="flex-1">
                        <div class="flex flex-col gap-1">
                            <span class="caption text-brandNeutral-400">${method.icon || '🏪'} ${method.name || 'Recogida en Tienda'}</span>
                            <span class="caption-strong text-brandNeutral-400">${method.formatted_cost || 'GRATIS'}</span>
                        </div>
                        <p class="caption text-brandNeutral-400 mt-1">${method.instructions || 'Recoge tu pedido en nuestra tienda'}</p>
                        <p class="caption text-brandNeutral-400 mt-1">⏱️ Listo en: ${method.preparation_label || method.preparation_time || '1 hora'}</p>
                    </div>
                </label>
            `;
        }
        
        if (method.id === 'local' && method.type === 'domicilio') {
            hasLocal = true;
            html += `
                <label class="flex items-center p-4 border border-brandWhite-300 rounded-lg cursor-pointer hover:bg-brandWhite-50 transition-colors">
                    <input 
                        type="radio" 
                        name="delivery_type" 
                        value="domicilio"
                        data-shipping-type="local"
                        data-cost="${method.cost}"
                        class="mr-3 w-4 h-4 text-brandPrimary-500 border-brandWhite-300 focus:ring-brandPrimary-300"
                    >
                    <div class="flex-1">
                        <div class="flex flex-col gap-1">
                            <span class="caption text-brandNeutral-400">${method.icon || '🚚'} ${method.name || 'Envío Local'}</span>
                            <span class="caption-strong text-brandNeutral-400">${method.formatted_cost}</span>
                        </div>
                        <p class="caption text-brandNeutral-400 mt-1">${method.instructions || 'Entrega en tu ciudad'}</p>
                        <p class="caption text-brandNeutral-400 mt-1">⏱️ Tiempo: ${method.preparation_label || method.preparation_time || '2-4 horas'}</p>
                    </div>
                </label>
            `;
        }
        
        if (method.id === 'national' && method.type === 'domicilio') {
            hasNational = true;
            html += `
                <label class="flex items-center p-4 border border-brandWhite-300 rounded-lg cursor-pointer hover:bg-brandWhite-50 transition-colors">
                    <input 
                        type="radio" 
                        name="delivery_type" 
                        value="domicilio"
                        data-shipping-type="nacional"
                        class="mr-3 w-4 h-4 text-brandPrimary-500 border-brandWhite-300 focus:ring-brandPrimary-300"
                    >
                    <div class="flex-1">
                        <div class="flex flex-col gap-1">
                            <span class="caption text-brandNeutral-400">${method.icon || '🌍'} ${method.name || 'Envío Nacional'}</span>
                            <span class="caption-strong text-brandNeutral-400">${method.formatted_cost || 'Según destino'}</span>
                        </div>
                        <p class="caption text-brandNeutral-400 mt-1">${method.instructions || 'Envío a todo el país'}</p>
                        <p class="caption text-brandNeutral-400 mt-1">⏱️ Tiempo: ${method.preparation_label || '3-7 días hábiles'}</p>
                    </div>
                </label>
            `;
        }
        
        // Consumo en Local
        if (method.type === 'dine_in' || method.id === 'dine_in') {
            html += `
                <label class="flex items-center p-4 border border-brandWhite-300 rounded-lg cursor-pointer hover:bg-brandWhite-50 transition-colors">
                    <input 
                        type="radio" 
                        name="delivery_type" 
                        value="pickup"
                        data-shipping-type="pickup"
                        data-order-type="dine_in"
                        class="mr-3 w-4 h-4 text-brandPrimary-500 border-brandWhite-300 focus:ring-brandPrimary-300"
                    >
                    <div class="flex-1">
                        <div class="flex flex-col gap-1">
                            <span class="caption text-brandNeutral-400">${method.icon || '🍽️'} ${method.name || 'Consumo en Local'}</span>
                            <span class="caption-strong text-brandNeutral-400">${method.formatted_cost || 'GRATIS'}</span>
                        </div>
                        <p class="caption text-brandNeutral-400 mt-1">${method.instructions || 'Consume en el local (mesa)'}</p>
                        <p class="caption text-brandNeutral-400 mt-1">⏱️ Tiempo: ${method.preparation_label || 'Inmediato'}</p>
                    </div>
                </label>
            `;
        }
        
        // Servicio a Habitación
        if (method.type === 'room_service' || method.id === 'room_service') {
            html += `
                <label class="flex items-center p-4 border border-brandWhite-300 rounded-lg cursor-pointer hover:bg-brandWhite-50 transition-colors">
                    <input 
                        type="radio" 
                        name="delivery_type" 
                        value="pickup"
                        data-shipping-type="pickup"
                        data-order-type="room_service"
                        class="mr-3 w-4 h-4 text-brandPrimary-500 border-brandWhite-300 focus:ring-brandPrimary-300"
                    >
                    <div class="flex-1">
                        <div class="flex flex-col gap-1">
                            <span class="caption text-brandNeutral-400">${method.icon || '🏨'} ${method.name || 'Servicio a Habitación'}</span>
                            <span class="caption-strong text-brandNeutral-400">${method.formatted_cost || 'GRATIS'}</span>
                        </div>
                        <p class="caption text-brandNeutral-400 mt-1">${method.instructions || 'Servicio directo a tu habitación'}</p>
                        <p class="caption text-brandNeutral-400 mt-1">⏱️ Tiempo: ${method.preparation_label || '30 minutos'}</p>
                    </div>
                </label>
            `;
        }
    });
    
    if (!html) {
        html = '<p class="caption text-brandNeutral-400 py-8">No hay métodos de envío disponibles</p>';
    }
    
    container.innerHTML = html;
    
    // Re-configurar event listeners
    document.querySelectorAll('input[name="delivery_type"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            const addressFieldsLocal = document.getElementById('address-fields-local');
            const addressFieldsNational = document.getElementById('address-fields-national');
            const tableContainer = document.getElementById('table-selector-container');
            const roomContainer = document.getElementById('room-selector-container');
            
            // Ocultar todos los campos primero
            addressFieldsLocal.classList.add('hidden');
            addressFieldsNational.classList.add('hidden');
            if (tableContainer) tableContainer.classList.add('hidden');
            if (roomContainer) roomContainer.classList.add('hidden');
            
            // Si es dine_in o room_service, mostrar selector correspondiente
            const orderType = e.target.dataset.orderType;
            if (orderType === 'dine_in') {
                // Mostrar selector de mesas
                if (tableContainer) {
                    tableContainer.classList.remove('hidden');
                    loadAvailableTables(); // Cargar mesas disponibles
                }
                enableStep2Button(); // Validará cuando se seleccione una mesa
            } else if (orderType === 'room_service') {
                // Mostrar selector de habitaciones
                if (roomContainer) {
                    roomContainer.classList.remove('hidden');
                    loadAvailableRooms(); // Cargar habitaciones disponibles
                }
                enableStep2Button(); // Validará cuando se seleccione una habitación
            } else if (e.target.value === 'domicilio') {
                const shippingType = e.target.dataset.shippingType;
                
                if (shippingType === 'local') {
                    // Solo mostrar campo de dirección para local
                    addressFieldsLocal.classList.remove('hidden');
                    // Limpiar campos nacionales
                    document.getElementById('department').value = '';
                    document.getElementById('city').value = '';
                    document.getElementById('customer_address_national').value = '';
                } else if (shippingType === 'nacional') {
                    // Mostrar departamento + ciudad + dirección para nacional
                    addressFieldsNational.classList.remove('hidden');
                    // Limpiar campo local
                    document.getElementById('customer_address').value = '';
                }
                enableStep2Button();
            } else if (e.target.value === 'pickup') {
                // Para pickup, no se necesitan campos de dirección
                enableStep2Button();
            }
        });
    });
}

// Cargar métodos de pago disponibles
async function loadPaymentMethods() {
    const url = '{{ route("tenant.checkout.payment-methods", $store->slug) }}';
    
    try {
        const response = await fetch(url);
        const data = await response.json();
        
        if (data.success) {
            paymentMethods = data.methods;
            renderPaymentMethods();
        }
    } catch (error) {
        // Error silencioso - métodos de pago no disponibles
    }
}

// Cargar mesas disponibles para consumo en local
async function loadAvailableTables() {
    const url = '{{ route("tenant.checkout.available-tables", $store->slug) }}';
    const select = document.getElementById('selected_table_number');
    
    if (!select) return;
    
    try {
        // Mostrar loading
        select.innerHTML = '<option value="">Cargando mesas...</option>';
        select.disabled = true;
        
        const response = await fetch(url);
        const data = await response.json();
        
        if (data.success && data.tables) {
            select.innerHTML = '<option value="">-- Selecciona una mesa --</option>';
            
            data.tables.forEach(table => {
                const option = document.createElement('option');
                option.value = table.table_number;
                option.textContent = `Mesa ${table.table_number} - Capacidad: ${table.capacity} personas (${table.status_label})`;
                select.appendChild(option);
            });
            
            if (data.tables.length === 0) {
                select.innerHTML = '<option value="">No hay mesas disponibles</option>';
            }
            
            select.disabled = false;
            
            // Agregar listener para validar cuando se seleccione
            select.addEventListener('change', enableStep2Button);
        } else {
            select.innerHTML = '<option value="">Error al cargar mesas</option>';
            select.disabled = false;
        }
    } catch (error) {
        console.error('Error cargando mesas:', error);
        select.innerHTML = '<option value="">Error al cargar mesas</option>';
        select.disabled = false;
    }
}

// Cargar habitaciones disponibles para servicio a habitación
async function loadAvailableRooms() {
    const url = '{{ route("tenant.checkout.available-rooms", $store->slug) }}';
    const select = document.getElementById('selected_room_number');
    
    if (!select) return;
    
    try {
        // Mostrar loading
        select.innerHTML = '<option value="">Cargando habitaciones...</option>';
        select.disabled = true;
        
        const response = await fetch(url);
        const data = await response.json();
        
        if (data.success && data.rooms) {
            select.innerHTML = '<option value="">-- Selecciona una habitación --</option>';
            
            data.rooms.forEach(room => {
                const option = document.createElement('option');
                option.value = room.room_number;
                option.textContent = `Habitación ${room.room_number} - ${room.room_type_name} - Capacidad: ${room.capacity} personas (${room.status_label})`;
                select.appendChild(option);
            });
            
            if (data.rooms.length === 0) {
                select.innerHTML = '<option value="">No hay habitaciones disponibles</option>';
            }
            
            select.disabled = false;
            
            // Agregar listener para validar cuando se seleccione
            select.addEventListener('change', enableStep2Button);
        } else {
            select.innerHTML = '<option value="">Error al cargar habitaciones</option>';
            select.disabled = false;
        }
    } catch (error) {
        console.error('Error cargando habitaciones:', error);
        select.innerHTML = '<option value="">Error al cargar habitaciones</option>';
        select.disabled = false;
    }
}

// Renderizar métodos de pago en el HTML
function renderPaymentMethods() {
    const container = document.getElementById('payment-methods-container');
    
    if (!container) {
        console.warn('Contenedor de métodos de pago no encontrado');
        return;
    }
    
    let html = '';
    
    paymentMethods.forEach(method => {
        if (method.type === 'cash') {
            html += `
                <div class="border border-brandWhite-300 rounded-lg transition-colors">
                    <label class="flex items-center cursor-pointer gap-3 p-4">
                        <input 
                            type="radio" 
                            name="payment_method" 
                            value="efectivo"
                            data-method-id="${method.id}"
                            class="mr-3 text-brandPrimary-300 focus:ring-brandPrimary-300 w-4 h-4"
                        >
                        <div class="flex items-center justify-center w-12 h-12 bg-brandWhite-50 rounded-lg p-2">
                            <span class="h1 text-brandPrimary-300">${method.icon}</span>
                        </div>
                        <div class="flex-1">
                            <h4 class="body-small-medium text-brandNeutral-400">${method.name}</h4>
                            <p class="caption text-brandNeutral-400">${method.instructions || 'Paga en efectivo al recibir tu pedido'}</p>
                        </div>
                    </label>
                    
                    <!-- Efectivo Fields -->
                    <div id="cash-fields-${method.id}" class="hidden mt-4">
                        <div class="bg-brandWhite-50 border border-brandWhite-300 rounded-lg p-4">
                            <label for="cash_amount" class="block caption text-brandNeutral-400 mb-2">
                                ¿Con cuánto vas a pagar? *
                            </label>
                            <input 
                                type="number" 
                                id="cash_amount" 
                                name="cash_amount" 
                                class="w-full px-3 py-2 border border-brandWhite-300 rounded-lg focus:ring-1 focus:ring-brandWhite-300 focus:border-transparent transition-colors caption"
                                placeholder="Ejemplo: 50000"
                                min="0"
                            >
                            <div id="change-display" class="hidden mt-3 p-3 bg-brandSuccess-50 rounded-lg">
                                <p class="caption text-brandSuccess-400">
                                    <span class="caption-strong">Tu cambio será:</span> 
                                    <span id="change-amount" class="caption-strong"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } else if (method.type === 'bank_transfer') {
            const accounts = method.bank_accounts || [];
            
            html += `
                <div class="border border-brandWhite-300 rounded-lg p-2 transition-colors">
                    <label class="flex items-center cursor-pointer">
                        <input 
                            type="radio" 
                            name="payment_method" 
                            value="transferencia"
                            data-method-id="${method.id}"
                            class="mr-3 text-brandPrimary-300 focus:ring-brandPrimary-300 w-4 h-4"
                        >
                        <div class="flex items-center justify-center w-12 h-12 bg-brandPrimary-50 rounded-lg mr-3">
                            <span class="h1 text-brandNeutral-400">${method.icon}</span>
                        </div>
                        <div class="flex-1">
                            <h4 class="caption text-brandNeutral-400">${method.name}</h4>
                            <p class="caption text-brandNeutral-400">${method.instructions || 'Transfiere a nuestras cuentas bancarias'}</p>
                        </div>
                    </label>
                    
                    <!-- Transferencia Fields -->
                    <div id="transfer-fields-${method.id}" class="hidden mt-4">
                        ${accounts.map(account => `
                            <div class="bg-gradient-to-r from-brandPrimary-100 to-brandSecondary-100 border border-brandWhite-300 rounded-lg p-4 sm:p-4 shadow-sm mb-3">
                                <h4 class="gap-2 body-small-medium text-brandNeutral-400 mb-3 flex items-center caption">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-landmark-icon lucide-landmark"><path d="M10 18v-7"/><path d="M11.12 2.198a2 2 0 0 1 1.76.006l7.866 3.847c.476.233.31.949-.22.949H3.474c-.53 0-.695-.716-.22-.949z"/><path d="M14 18v-7"/><path d="M18 18v-7"/><path d="M3 22h18"/><path d="M6 18v-7"/></svg>
                                    ${account.bank_name}
                                </h4>
                                <div class="space-y-2">
                                    <!-- Tipo de Cuenta -->
                                    <div class="bg-brandWhite-50 rounded-lg p-2 border border-brandWhite-300">
                                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1">
                                            <span class="caption text-brandNeutral-400 font-medium">Tipo:</span>
                                            <span class="caption sm:caption font-bold text-brandNeutral-400 px-2 py-0.5 rounded-full inline-block">${account.account_type || 'Cuenta Corriente'}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Número de Cuenta -->
                                        <div class="bg-brandWhite-50 rounded-lg p-2 border border-brandWhite-300">
                                        <div class="space-y-2">
                                            <span class="caption text-brandNeutral-400 font-medium block">Número de Cuenta:</span>
                                            <div class="flex sm:flex-row items-start sm:items-center justify-between gap-2">
                                                <span class="caption sm:caption font-bold text-brandNeutral-400 bg-brandPrimary-50 px-3 py-2 rounded-full tracking-wider break-all" id="account-${account.id}">${account.account_number}</span>
                                                <button type="button" onclick="copyToClipboard('account-${account.id}')" class="caption bg-brandPrimary-300 hover:bg-brandSuccess-300 hover:text-brandWhite-50 text-brandWhite-50 px-3 py-2 rounded-full font-semibold transition-colors whitespace-nowrap">
                                                    Copiar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Titular -->
                                    <div class="bg-brandWhite-50 rounded-lg p-2 border border-brandWhite-300">
                                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1">
                                            <span class="caption text-brandNeutral-400 font-medium">Titular:</span>
                                            <span class="caption sm:caption font-bold text-brandNeutral-400">${account.account_holder}</span>
                                        </div>
                                    </div>
                                    
                                    ${account.document_number ? `
                                        <!-- Documento -->
                                            <div class="bg-brandWhite-50 rounded-lg p-2 border border-brandWhite-300">
                                            <div class="space-y-2">
                                                <span class="caption text-brandNeutral-400 font-medium block">Documento:</span>
                                                <div class="flex sm:flex-row items-start sm:items-center justify-between gap-2">
                                                    <span class="caption sm:caption font-bold text-brandNeutral-400 bg-brandPrimary-50 px-3 py-2 rounded-full break-all" id="document-${account.id}">${account.document_number}</span>
                                                    <button type="button" onclick="copyToClipboard('document-${account.id}')" class="caption bg-brandPrimary-300 hover:bg-brandSuccess-300 hover:text-brandWhite-50 text-brandWhite-50 px-3 py-2 rounded-full font-semibold transition-colors whitespace-nowrap">
                                                        Copiar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    ` : ''}
                                </div>
                            </div>
                        `).join('')}
                        
                        <div class="bg-brandPrimary-50 border border-brandWhite-300 rounded-lg p-3 mt-2">
                            <label for="payment_proof" class="block caption text-brandNeutral-400 mb-2">
                                Comprobante de Pago ${method.require_proof ? '*' : '(Opcional)'}
                            </label>
                            <div class="border-2 border-dashed border-brandWhite-300 rounded-lg p-6 text-center hover:border-brandPrimary-300 transition-colors">
                                <input 
                                    type="file" 
                                    id="payment_proof" 
                                    name="payment_proof" 
                                    accept=".jpg,.jpeg,.png,.pdf"
                                    ${method.require_proof ? 'required' : ''}
                                    class="hidden"
                                >
                                <label for="payment_proof" class="cursor-pointer">
                                    <div class="text-4xl mb-2">📎</div>
                                    <p class="caption text-brandNeutral-400 font-medium mb-1">Subir comprobante</p>
                                    <p class="caption text-brandNeutral-300">JPG, PNG o PDF (máx. 5MB)</p>
                                </label>
                            </div>
                            <div id="payment_proof_preview" class="hidden mt-3"></div>
                            <div id="payment_proof_error" class="hidden mt-1 caption text-brandError-400"></div>
                        </div>
                    </div>
                </div>
            `;
        }
    });
    
    container.innerHTML = html;
    
    // Re-configurar event listeners
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            handlePaymentMethodChange(e.target.value, e.target.dataset.methodId);
            enableStep3Button();
        });
    });
    
    // Re-configurar cash amount listener
    const cashAmountInput = document.getElementById('cash_amount');
    if (cashAmountInput) {
        cashAmountInput.addEventListener('input', handleCashAmountChange);
    }
    
    // Re-configurar payment proof upload listener
    const paymentProofInput = document.getElementById('payment_proof');
    if (paymentProofInput) {
        paymentProofInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                handlePaymentProofUpload(e.target.files[0]);
            }
        });
    }
}

// Manejar subida de comprobante de pago
function handlePaymentProofUpload(file) {
    const preview = document.getElementById('payment_proof_preview');
    const errorElement = document.getElementById('payment_proof_error');
    
    if (!file) {
        if (preview) preview.classList.add('hidden');
        return;
    }
    
    const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
    const maxSize = 5 * 1024 * 1024; // 5MB
    
    if (!allowedTypes.includes(file.type)) {
        if (errorElement) {
            errorElement.textContent = 'Solo se permiten archivos JPG, PNG o PDF';
            errorElement.classList.remove('hidden');
        }
        return;
    }
    
    if (file.size > maxSize) {
        if (errorElement) {
            errorElement.textContent = 'El archivo no puede ser mayor a 5MB';
            errorElement.classList.remove('hidden');
        }
        return;
    }
    
    if (errorElement) errorElement.classList.add('hidden');
    if (preview) {
        preview.innerHTML = `
            <div class="flex items-center gap-3 p-3 bg-brandSuccess-50 border border-brandSuccess-200 rounded-lg">
                <span class="text-2xl">📎</span>
                <div class="flex-1">
                    <p class="caption-strong text-brandNeutral-400">${file.name}</p>
                    <p class="caption text-brandNeutral-300">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                </div>
            </div>
        `;
        preview.classList.remove('hidden');
    }
}

// Enviar pedido
async function submitOrder() {
    const btn = document.getElementById('btn-submit-order');
    const originalText = btn.innerHTML;
    
    // Deshabilitar botón y mostrar loading
    btn.disabled = true;
    btn.innerHTML = '⏳ Procesando...';
    
    try {
        // Recopilar todos los datos del formulario
        const formData = new FormData();
        
        // Datos personales
        formData.append('customer_name', document.getElementById('customer_name').value);
        formData.append('customer_phone', document.getElementById('customer_phone').value);
        
        // Datos de envío
        const deliveryType = document.querySelector('input[name="delivery_type"]:checked');
        if (deliveryType) {
            formData.append('delivery_type', deliveryType.value);
            
            // Verificar si es dine_in o room_service (desde data-order-type)
            const orderType = deliveryType.dataset.orderType;
            if (orderType === 'dine_in') {
                // Agregar order_type y table_number
                formData.append('order_type', orderType);
                const tableNumber = document.getElementById('selected_table_number')?.value;
                if (tableNumber) {
                    formData.append('table_number', tableNumber);
                }
            } else if (orderType === 'room_service') {
                // Agregar order_type y room_number (usando table_number en el backend)
                formData.append('order_type', orderType);
                const roomNumber = document.getElementById('selected_room_number')?.value;
                if (roomNumber) {
                    formData.append('table_number', roomNumber); // El backend espera table_number para room_service también
                }
            }
            
            if (deliveryType.value === 'domicilio') {
                const shippingType = deliveryType.dataset.shippingType;
                
                if (shippingType === 'local') {
                    // Para envío local: solo enviar dirección, usar datos de la tienda para dept/ciudad
                    formData.append('department', '{{ $store->department ?? "" }}');
                    formData.append('city', '{{ $store->city ?? "" }}');
                    formData.append('customer_address', document.getElementById('customer_address').value);
                } else if (shippingType === 'nacional') {
                    // Para envío nacional: enviar todos los datos
                    formData.append('department', document.getElementById('department').value);
                    formData.append('city', document.getElementById('city').value);
                    formData.append('customer_address', document.getElementById('customer_address_national').value);
                }
                
                // Agregar shipping_zone_id si está disponible
                if (window.selectedShippingZone && window.selectedShippingZone.zone_id) {
                    formData.append('shipping_zone_id', window.selectedShippingZone.zone_id);
                }
            }
        }
        
        // Datos de pago
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
        if (paymentMethod) {
            formData.append('payment_method', paymentMethod.value);
            formData.append('payment_method_id', paymentMethod.dataset.methodId);
            
            // Si es efectivo, agregar monto
            if (paymentMethod.value === 'efectivo') {
                const cashAmount = document.getElementById('cash_amount').value;
                if (cashAmount) {
                    formData.append('cash_amount', cashAmount);
                }
            }
            
            // Si hay comprobante de pago
            const paymentProof = document.getElementById('payment_proof');
            
            if (paymentProof && paymentProof.files.length > 0) {
                formData.append('payment_proof', paymentProof.files[0]);
            }
        }
        
        // Cupón si existe
        const couponCode = document.getElementById('coupon_code');
        if (couponCode && couponCode.value) {
            formData.append('coupon_code', couponCode.value);
        }
        
        // Enviar al servidor
        const checkoutUrl = '{{ route("tenant.checkout.store", $store->slug) }}';
        
        const response = await fetch(checkoutUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        const responseText = await response.text();
        
        let data;
        try {
            data = JSON.parse(responseText);
        } catch (e) {
            alert('Error: El servidor no devolvió una respuesta JSON válida');
            return;
        }
        
        if (data.success) {
            // Redirigir a página de éxito con el ID del pedido
            window.location.href = `{{ route("tenant.checkout.success", $store->slug) }}?order=${data.order.id}`;
        } else {
            // Manejar errores de validación específicos
            if (data.errors) {
                let errorMessage = 'Errores de validación:\n';
                for (const field in data.errors) {
                    errorMessage += `• ${field}: ${data.errors[field].join(', ')}\n`;
                }
                alert(errorMessage);
            } else {
                alert('Error al procesar el pedido: ' + (data.message || 'Error desconocido'));
            }
        }
        
    } catch (error) {
        alert('Error de conexión. Por favor intenta nuevamente.');
    } finally {
        // Restaurar botón
        btn.disabled = false;
        btn.innerHTML = originalText;
    }
}

// Formatear precio
function formatPrice(price) {
    // Validar que el precio sea un número válido
    const numPrice = parseFloat(price);
    if (isNaN(numPrice) || !isFinite(numPrice)) {
        return '0';
    }
    
    return new Intl.NumberFormat('es-CO', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(numPrice);
}

// Actualizar la visualización del resumen del pedido
function updateOrderSummaryDisplay() {
    // Validar que existan los elementos antes de actualizarlos
    const summarySubtotal = document.getElementById('summary-subtotal');
    const totalQuantityEl = document.getElementById('total-quantity');
    const uniqueProductsEl = document.getElementById('unique-products');
    const productBreakdown = document.getElementById('product-breakdown');
    
    if (summarySubtotal) {
        summarySubtotal.textContent = '$' + formatPrice(cartSubtotal);
    }
    
    if (cartItems.length > 0) {
        if (totalQuantityEl) {
            totalQuantityEl.textContent = cartItems.reduce((sum, item) => sum + item.quantity, 0);
        }
        if (uniqueProductsEl) {
            uniqueProductsEl.textContent = cartItems.length;
        }
        if (productBreakdown) {
            productBreakdown.classList.remove('hidden');
        }
    } else {
        if (productBreakdown) {
            productBreakdown.classList.add('hidden');
        }
    }
    
    // Actualizar total
    updateTotalDisplay();
}

// Cargar resumen del pedido desde el carrito
async function loadOrderSummary() {
    try {
        const response = await fetch('{{ route("tenant.cart.get", $store->slug) }}');
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        const data = await response.json();
        
        if (data.success) {
            cartItems = data.items || [];
            cartSubtotal = data.subtotal || 0;
            
            // Mostrar productos usando la función correcta
            if (cartItems.length > 0) {
                displayOrderProducts(cartItems);
                
                // Leer descuento del cupón si existe
                const summaryElement = document.getElementById('order-summary');
                const couponDiscount = summaryElement && summaryElement.dataset.couponDiscount 
                    ? parseFloat(summaryElement.dataset.couponDiscount) 
                    : 0;
                
                // Actualizar variable global
                discountAmount = couponDiscount;
                
                updateOrderTotals(cartSubtotal, shippingCost, couponDiscount);
            } else {
                // Redirigir si no hay productos
                window.location.href = '{{ route("tenant.cart.index", $store->slug) }}';
            }
        } else {
            // Redirigir si no hay productos
            window.location.href = '{{ route("tenant.cart.index", $store->slug) }}';
        }
    } catch (error) {
        cartItems = [];
        cartSubtotal = 0;
        updateOrderSummaryDisplay();
    }
}

// Obtener subtotal actual
function getCurrentSubtotal() {
    return cartSubtotal;
}

// Obtener costo de envío actual
function getCurrentShipping() {
    return shippingCost;
}

// Obtener descuento actual
function getCurrentDiscount() {
    return discountAmount;
}

// Actualizar display del total final
function updateTotalDisplay() {
    const total = getCurrentSubtotal() + getCurrentShipping() - getCurrentDiscount();
    const summaryTotal = document.getElementById('summary-total');
    
    if (summaryTotal) {
        summaryTotal.textContent = `$${formatPrice(total)}`;
    }
    
    // Actualizar botón de envío
    updateSubmitButtonText();
}

// Actualizar costo de envío
function updateShippingCost(cost, isCalculating = false) {
    shippingCost = parseFloat(cost) || 0;
    const shippingDisplay = document.getElementById('summary-shipping');
    
    if (isCalculating) {
        shippingDisplay.textContent = 'Calculando...';
    } else if (shippingCost === 0) {
        shippingDisplay.textContent = 'GRATIS';
    } else {
        shippingDisplay.textContent = `$${formatPrice(shippingCost)}`;
    }
    
    updateTotalDisplay();
}

// Actualizar descuento por cupón
function updateDiscountAmount(discount) {
    discountAmount = parseFloat(discount) || 0;
    const discountRow = document.getElementById('coupon-discount-row');
    const discountDisplay = document.getElementById('summary-discount');
    
    if (discountAmount > 0) {
        discountDisplay.textContent = `-$${formatPrice(discountAmount)}`;
        discountRow.classList.remove('hidden');
    } else {
        discountRow.classList.add('hidden');
    }
    
    updateTotalDisplay();
}

// Obtener subtotal actual del carrito
function getCurrentSubtotal() {
    return cartSubtotal || 0;
}

// Obtener costo de envío actual
function getCurrentShipping() {
    return shippingCost || 0;
}

// Obtener descuento actual
function getCurrentDiscount() {
    return discountAmount || 0;
}

// Actualizar el total final
function updateTotalDisplay() {
    const subtotal = getCurrentSubtotal();
    const shipping = getCurrentShipping();
    const discount = getCurrentDiscount();
    
    const total = subtotal + shipping - discount;
    
    document.getElementById('summary-total').textContent = '$' + formatPrice(Math.max(0, total));
}

// Calcular costo de envío
async function calculateShippingCost(department, city) {
    const currentSubtotal = getCurrentSubtotal();
    
    // Para envío local, puede que city venga en department y city sea vacío
    const finalCity = city || department || '';
    
    if (!finalCity) {
        updateShippingCost(0);
        return;
    }
    
    // Mostrar estado calculando
    updateShippingCost(0, true);
    
    try {
        const response = await fetch('{{ route("tenant.debug.shipping-cost", $store->slug) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                city: finalCity,
                department: department,
                subtotal: getCurrentSubtotal()
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            updateShippingCost(data.cost);
        } else {
            updateShippingCost(0);
        }
    } catch (error) {
        updateShippingCost(0);
    }
}

// Aplicar cupón
async function applyCoupon() {
    const couponCodeInput = document.getElementById('coupon_code');
    const couponCode = couponCodeInput.value.trim().toUpperCase();
    const applyBtn = document.getElementById('apply-coupon-btn');
    const couponError = document.getElementById('coupon_error');
    
    if (!couponCode) {
        showCouponError('Ingresa un código de cupón');
        return;
    }
    
    // Disable button
    const originalText = applyBtn.textContent;
    applyBtn.disabled = true;
    applyBtn.textContent = 'Validando...';
    
    // Hide previous errors
    couponError.classList.add('hidden');
    
    try {
        const response = await fetch('{{ route("tenant.cart.apply-coupon", $store->slug) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                coupon_code: couponCode,
                subtotal: getCurrentSubtotal()
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Guardar descuento en dataset
            const summaryElement = document.getElementById('order-summary');
            if (summaryElement) {
                summaryElement.dataset.couponDiscount = data.discount_amount;
                summaryElement.dataset.couponCode = couponCode;
            }
            
            // Actualizar variable global
            discountAmount = parseFloat(data.discount_amount) || 0;
            
            // Actualizar totales directamente
            updateOrderTotals(cartSubtotal, shippingCost, discountAmount);
            
            // Deshabilitar input y cambiar botón
            couponCodeInput.disabled = true;
            applyBtn.textContent = '✓ Aplicado';
            applyBtn.classList.remove('bg-primary-300', 'hover:bg-primary-200');
            applyBtn.classList.add('bg-success-300');
            
            console.log('🎉 Cupón aplicado con éxito - Descuento:', discountAmount);
        } else {
            showCouponError(data.message || 'Cupón no válido');
        }
    } catch (error) {
        showCouponError('Error de conexión. Intenta nuevamente.');
    } finally {
        if (!couponCodeInput.disabled) {
            applyBtn.disabled = false;
            applyBtn.textContent = originalText;
        }
    }
}

// Mostrar error de cupón
function showCouponError(message) {
    const couponError = document.getElementById('coupon_error');
    if (couponError) {
        couponError.textContent = message;
        couponError.classList.remove('hidden');
    }
}

// Cargar departamentos y ciudades para envío nacional
let nationalShippingData = {
    departments: [],
    cities_by_department: {}
};

async function loadDepartmentsAndCities() {
    try {
        const response = await fetch('{{ route("tenant.checkout.shipping-departments", $store->slug) }}');
        const data = await response.json();
        
        if (data.success) {
            nationalShippingData = {
                departments: data.departments || [],
                cities_by_department: data.cities_by_department || {}
            };
            
            // Poblar el select de departamentos
            populateDepartments();
        }
    } catch (error) {
        // Error silencioso - simplemente no habrá departamentos disponibles
    }
}

function populateDepartments() {
    const departmentSelect = document.getElementById('department');
    if (!departmentSelect) return;
    
    // Limpiar opciones existentes (excepto la primera)
    departmentSelect.innerHTML = '<option value="">Selecciona tu departamento</option>';
    
    // Agregar departamentos disponibles
    nationalShippingData.departments.forEach(dept => {
        const option = document.createElement('option');
        option.value = dept;
        option.textContent = dept;
        departmentSelect.appendChild(option);
    });
}

function onDepartmentChange() {
    const departmentSelect = document.getElementById('department');
    const citySelect = document.getElementById('city');
    
    if (!departmentSelect || !citySelect) return;
    
    const selectedDept = departmentSelect.value;
    
    // Limpiar y deshabilitar el select de ciudades
    citySelect.innerHTML = '<option value="">Selecciona tu ciudad</option>';
    citySelect.disabled = true;
    citySelect.value = '';
    
    if (selectedDept && nationalShippingData.cities_by_department[selectedDept]) {
        const cities = nationalShippingData.cities_by_department[selectedDept];
        
        // Agregar ciudades del departamento seleccionado
        cities.forEach(city => {
            const option = document.createElement('option');
            option.value = city;
            option.textContent = city;
            citySelect.appendChild(option);
        });
        
        // Habilitar el select
        citySelect.disabled = false;
    }
}
</script>
@endpush
