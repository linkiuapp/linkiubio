<x-tenant-admin-layout :store="$store">
@section('title', 'Editar Pedido #' . $order->order_number)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('tenant.admin.orders.show', [$store->slug, $order->id]) }}" 
               class="text-gray-600 hover:text-gray-700">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            <h1 class="text-lg font-semibold text-gray-900">Editar Pedido #{{ $order->order_number }}</h1>
            <span class="text-xs {{ $order->status_color }} px-2 py-1 rounded">
                {{ $order->status_label }}
            </span>
        </div>
    </div>

    @if(!$order->canBeEdited())
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <div class="flex items-center gap-3">
                <i data-lucide="alert-triangle" class="w-5 h-5 text-yellow-600 flex-shrink-0"></i>
                <div>
                    <h3 class="text-sm font-medium text-yellow-800">Edición Limitada</h3>
                    <div class="text-xs text-yellow-700 mt-1">
                        Este pedido está en estado "{{ $order->status_label }}" y solo se pueden editar algunos campos básicos.
                    </div>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('tenant.admin.orders.update', [$store->slug, $order->id]) }}" method="POST" enctype="multipart/form-data" x-data="orderEdit" x-init="init()" @submit="validateForm" class="space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Inputs hidden para asegurar que siempre se envíen valores -->
        <input type="hidden" name="customer_address" :value="deliveryType === 'pickup' ? '' : (document.getElementById('customer_address')?.value || '{{ $order->customer_address ?? '' }}')">
        <input type="hidden" name="department" :value="deliveryType === 'national' ? selectedDepartment : ''">
        <input type="hidden" name="city" :value="deliveryType === 'national' ? selectedCity : ''">

        <!-- Información del Cliente -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-sm font-medium text-gray-700 mb-4">Información del Cliente</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="lg:col-span-2">
                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre Completo *
                    </label>
                    <input type="text" 
                           id="customer_name" 
                           name="customer_name" 
                           value="{{ old('customer_name', $order->customer_name) }}" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-gray-900 placeholder-gray-400"
                           placeholder="Nombre completo del cliente">
                    @error('customer_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Teléfono / WhatsApp *
                    </label>
                    <input type="tel" 
                           id="customer_phone" 
                           name="customer_phone" 
                           value="{{ old('customer_phone', $order->customer_phone) }}" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-gray-900 placeholder-gray-400"
                           placeholder="3001234567">
                    @error('customer_phone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campos condicionales según tipo de entrega -->
                <!-- Para envío nacional: Departamento y Ciudad -->
                <template x-if="deliveryType === 'national'">
                    <div class="lg:col-span-2 grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-700 mb-2">
                                Departamento *
                            </label>
                            <select id="department" 
                                    name="department" 
                                    x-model="selectedDepartment"
                                    @change="onDepartmentChange()"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-gray-900"
                                    :required="deliveryType === 'national'">
                                <option value="">Seleccionar departamento</option>
                                <template x-for="dept in availableDepartments" :key="dept">
                                    <option :value="dept" x-text="dept" :selected="selectedDepartment === dept"></option>
                                </template>
                            </select>
                            @error('department')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                                Ciudad *
                            </label>
                            <select id="city" 
                                    name="city" 
                                    x-model="selectedCity"
                                    @change="onCityChange()"
                                    :disabled="!selectedDepartment"
                                    :required="deliveryType === 'national'"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-gray-900 disabled:opacity-50 disabled:cursor-not-allowed">
                                <option value="">Seleccionar ciudad</option>
                                <template x-for="city in availableCities" :key="city">
                                    <option :value="city" x-text="city" :selected="selectedCity === city"></option>
                                </template>
                            </select>
                            @error('city')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </template>

                <!-- Para envío local o nacional: Dirección -->
                <template x-if="deliveryType === 'local' || deliveryType === 'national'">
                    <div class="lg:col-span-2">
                        <label for="customer_address" class="block text-sm font-medium text-gray-700 mb-2">
                            Dirección Completa *
                        </label>
                        @php
                            $addressValue = old('customer_address', $order->customer_address ?? '');
                        @endphp
                        <textarea id="customer_address" 
                                  name="customer_address" 
                                  :required="deliveryType === 'local' || deliveryType === 'national'"
                                  rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-gray-900 placeholder-gray-400"
                                  placeholder="Dirección completa, barrio, referencias">{{ $addressValue }}</textarea>
                        @error('customer_address')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </template>
            </div>
        </div>

        <!-- Tipo de Entrega y Pago -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-sm font-medium text-gray-700 mb-4">Entrega y Pago</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Entrega *</label>
                    <div class="space-y-3">
                        @if($simpleShipping && $simpleShipping->pickup_enabled)
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-100 cursor-pointer transition-colors">
                            <input type="radio" 
                                   name="delivery_type" 
                                   value="pickup" 
                                   {{ in_array(old('delivery_type', $order->delivery_type), ['pickup']) ? 'checked' : '' }}
                                   x-model="deliveryType"
                                   @change="updateShippingOptions()"
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="ml-3 text-sm text-gray-700 flex items-center gap-2">
                                <i data-lucide="store" class="w-4 h-4"></i>
                                Recogida en Tienda (Gratis)
                            </span>
                        </label>
                        @endif
                        
                        @if($simpleShipping && $simpleShipping->local_enabled)
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-100 cursor-pointer transition-colors">
                            <input type="radio" 
                                   name="delivery_type" 
                                   value="local" 
                                   {{ in_array(old('delivery_type', $order->delivery_type), ['local', 'domicilio']) ? 'checked' : '' }}
                                   x-model="deliveryType"
                                   @change="updateShippingOptions()"
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="ml-3 text-sm text-gray-700 flex items-center gap-2">
                                <i data-lucide="truck" class="w-4 h-4"></i>
                                Envío Local
                            </span>
                        </label>
                        @endif
                        
                        @if($simpleShipping && $simpleShipping->national_enabled)
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-100 cursor-pointer transition-colors">
                            <input type="radio" 
                                   name="delivery_type" 
                                   value="national" 
                                   {{ in_array(old('delivery_type', $order->delivery_type), ['national']) ? 'checked' : '' }}
                                   x-model="deliveryType"
                                   @change="updateShippingOptions()"
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="ml-3 text-sm text-gray-700 flex items-center gap-2">
                                <i data-lucide="package" class="w-4 h-4"></i>
                                Envío Nacional
                            </span>
                        </label>
                        @endif
                    </div>
                    @error('delivery_type')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Método de Pago *</label>
                    <div class="space-y-3">
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-100 cursor-pointer transition-colors">
                            <input type="radio" 
                                   name="payment_method" 
                                   value="transferencia" 
                                   {{ old('payment_method', $order->payment_method) === 'transferencia' ? 'checked' : '' }}
                                   x-model="paymentMethod"
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="ml-3 text-sm text-gray-700">Transferencia Bancaria</span>
                        </label>
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-100 cursor-pointer transition-colors">
                            <input type="radio" 
                                   name="payment_method" 
                                   value="contra_entrega" 
                                   {{ old('payment_method', $order->payment_method) === 'contra_entrega' ? 'checked' : '' }}
                                   x-model="paymentMethod"
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="ml-3 text-sm text-gray-700">Pago Contra Entrega</span>
                        </label>
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-100 cursor-pointer transition-colors" x-show="deliveryType === 'pickup'">
                            <input type="radio" 
                                   name="payment_method" 
                                   value="efectivo" 
                                   {{ old('payment_method', $order->payment_method) === 'efectivo' ? 'checked' : '' }}
                                   x-model="paymentMethod"
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="ml-3 text-sm text-gray-700">Efectivo</span>
                        </label>
                    </div>
                    @error('payment_method')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Comprobante de Pago (solo para transferencia) -->
            <div x-show="paymentMethod === 'transferencia'" class="mt-6">
                @if($order->payment_proof_path)
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i data-lucide="file-text" class="w-5 h-5 text-green-600 mr-2"></i>
                                <span class="text-sm text-green-700">Comprobante actual subido</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('tenant.admin.orders.download-payment-proof', [$store->slug, $order->id]) }}" 
                                   class="text-xs text-blue-600 hover:text-blue-700">
                                    Descargar
                                </a>
                                <label class="flex items-center">
                                    <input type="checkbox" name="remove_payment_proof" value="1" 
                                           class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                    <span class="ml-2 text-xs text-red-600">Eliminar</span>
                                </label>
                            </div>
                        </div>
                    </div>
                @endif

                <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $order->payment_proof_path ? 'Reemplazar Comprobante' : 'Comprobante de Pago' }} (Opcional)
                </label>
                <div class="w-full">
                    <label class="block">
                        <span class="sr-only">Seleccionar archivo</span>
                        <input type="file" 
                               id="payment_proof" 
                               name="payment_proof" 
                               accept="image/*,application/pdf" 
                               class="block p-4 w-full text-sm text-gray-500 border border-gray-400 rounded-lg file:me-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:disabled:opacity-50 file:disabled:pointer-events-none" />
                    </label>
                </div>
                <div class="text-xs text-gray-500 mt-1">JPG, PNG, PDF - Máximo 5MB</div>
                @error('payment_proof')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Productos del Pedido (Solo lectura si no es editable) -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-sm font-medium text-gray-700 mb-4">Productos del Pedido</h3>
            @if($order->canBeEdited())
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center gap-3">
                        <i data-lucide="info" class="w-5 h-5 text-blue-600 flex-shrink-0"></i>
                        <div>
                            <h4 class="text-sm font-medium text-blue-800">Edición de Productos</h4>
                            <div class="text-xs text-blue-700 mt-1">
                                Para modificar los productos, elimina este pedido y crea uno nuevo con los productos correctos.
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center p-4 bg-white rounded-lg border border-gray-200">
                        <div class="w-12 h-12 rounded-lg flex-shrink-0 border border-gray-200 overflow-hidden bg-gray-100 relative mr-4">
                            @if($item->product && $item->product->main_image_url)
                                <img src="{{ $item->product->main_image_url }}" 
                                     alt="{{ $item->product_name }}" 
                                     class="w-full h-full object-cover"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            @endif
                            <div class="w-full h-full {{ $item->product && $item->product->main_image_url ? 'hidden' : 'flex' }} items-center justify-center absolute inset-0">
                                <i data-lucide="package" class="w-6 h-6 text-gray-500"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-semibold text-gray-900">{{ $item->product_name }}</div>
                            @if($item->variant_details)
                                <div class="text-xs text-gray-600">{{ $item->formatted_variants }}</div>
                            @endif
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-900">Cant: {{ $item->quantity }}</div>
                            <div class="text-sm text-gray-600">${{ number_format($item->unit_price, 0, ',', '.') }} c/u</div>
                            <div class="text-sm font-semibold text-gray-900">${{ number_format($item->item_total, 0, ',', '.') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Resumen de Totales -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="flex justify-end">
                    <div class="w-full max-w-sm space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="text-gray-900">${{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @if($order->shipping_cost > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Envío:</span>
                                <span class="text-gray-900">${{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        @if($order->coupon_discount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Descuento:</span>
                                <span class="text-green-600">-${{ number_format($order->coupon_discount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between">
                                <span class="text-lg font-semibold text-gray-900">Total:</span>
                                <span class="text-lg font-semibold text-blue-600">${{ number_format($order->total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notas Adicionales -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-sm font-medium text-gray-700 mb-4">Notas Adicionales</h3>
            <textarea name="notes" 
                      rows="3"
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-gray-900 placeholder-gray-400"
                      placeholder="Instrucciones especiales, observaciones, etc.">{{ old('notes', $order->notes) }}</textarea>
            @error('notes')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Acciones -->
        <div class="flex gap-3 justify-end">
            <a href="{{ route('tenant.admin.orders.show', [$store->slug, $order->id]) }}" class="px-4 py-2 border-2 border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors flex items-center gap-2">
                <i data-lucide="x-circle" class="w-5 h-5"></i>
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors flex items-center gap-2 shadow-sm">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                Actualizar Pedido
            </button>
        </div>
    </form>
</div>

<!-- Alerta de validación -->
<div x-show="showValidationAlert" 
     x-cloak
     class="fixed bottom-4 right-4 z-50 max-w-md"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-2"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-2">
    <x-alert-bordered 
        type="warning" 
        title="Validación requerida"
        x-message="validationMessage" />
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('orderEdit', () => ({
        // Datos iniciales del pedido
        deliveryType: '{{ old("delivery_type", $order->delivery_type === "domicilio" ? "local" : $order->delivery_type) }}',
        paymentMethod: '{{ old("payment_method", $order->payment_method) }}',
        selectedDepartment: '{{ old("department", $order->department ?? "") }}',
        selectedCity: '{{ old("city", $order->city ?? "") }}',
        selectedShippingZone: '',
        shippingCost: 0,
        availableDepartments: [],
        citiesByDepartment: {},
        zonesByCity: {},
        availableCities: [],

        init() {
            // Normalizar delivery_type si es "domicilio" a "local"
            if (this.deliveryType === 'domicilio') {
                this.deliveryType = 'local';
            }
            
            // Cargar departamentos y ciudades para envío nacional
            this.loadDepartmentsAndCities();
            
            // Inicializar iconos Lucide después de que Alpine esté listo
            Alpine.nextTick(() => {
                if (typeof lucide !== 'undefined' && lucide.createIcons) {
                    lucide.createIcons();
                }
            });
        },
        
        updateShippingOptions() {
            // Resetear campos relacionados con envío si cambia el tipo
            if (this.deliveryType === 'pickup') {
                this.selectedDepartment = '';
                this.selectedCity = '';
                this.selectedShippingZone = '';
                this.shippingCost = 0;
            }
        },
        
        showValidationAlert: false,
        validationMessage: '',
        
        validateForm(event) {
            // Validar campos según tipo de entrega
            if (this.deliveryType === 'national') {
                if (!this.selectedDepartment) {
                    event.preventDefault();
                    this.validationMessage = 'Debes seleccionar un departamento para envío nacional';
                    this.showValidationAlert = true;
                    setTimeout(() => { this.showValidationAlert = false; }, 5000);
                    return false;
                }
                if (!this.selectedCity) {
                    event.preventDefault();
                    this.validationMessage = 'Debes seleccionar una ciudad para envío nacional';
                    this.showValidationAlert = true;
                    setTimeout(() => { this.showValidationAlert = false; }, 5000);
                    return false;
                }
            }
            
            if (this.deliveryType === 'local' || this.deliveryType === 'national') {
                const addressField = document.getElementById('customer_address');
                if (!addressField || !addressField.value.trim()) {
                    event.preventDefault();
                    this.validationMessage = 'Debes ingresar una dirección para este tipo de entrega';
                    this.showValidationAlert = true;
                    setTimeout(() => { this.showValidationAlert = false; }, 5000);
                    return false;
                }
            }
            
            return true;
        },

        loadDepartmentsAndCities() {
            fetch('{{ route("tenant.admin.orders.shipping-departments", $store->slug) }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.availableDepartments = data.departments;
                        this.citiesByDepartment = data.cities_by_department;
                        this.zonesByCity = data.zones_by_city;
                        
                        // Si ya hay un departamento seleccionado, cargar sus ciudades
                        if (this.selectedDepartment) {
                            this.onDepartmentChange();
                        }
                    }
                })
                .catch(error => {
                    // Error cargando departamentos
                });
        },

        onDepartmentChange() {
            // Cargar ciudades del departamento seleccionado
            if (this.selectedDepartment && this.citiesByDepartment[this.selectedDepartment]) {
                this.availableCities = this.citiesByDepartment[this.selectedDepartment];
            } else {
                this.availableCities = [];
            }
            
            // Si la ciudad actual no pertenece al nuevo departamento, resetearla
            if (this.selectedCity && !this.availableCities.includes(this.selectedCity)) {
                this.selectedCity = '';
            }
        },

        onCityChange() {
            // Auto-calcular zona basándose en la ciudad
            if (this.selectedCity) {
                const cityKey = this.selectedCity.toLowerCase();
                const zoneInfo = this.zonesByCity[cityKey];
                
                if (zoneInfo) {
                    this.selectedShippingZone = zoneInfo.zone_id;
                    this.shippingCost = parseFloat(zoneInfo.cost) || 0;
                }
            } else {
                this.selectedShippingZone = '';
                this.shippingCost = 0;
            }
        }
    }));
});
</script>
@endpush
@endsection
</x-tenant-admin-layout> 