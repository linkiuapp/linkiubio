<x-tenant-admin-layout :store="$store">
@section('title', 'Nuevo Pedido')

@section('content')
<div class="max-w-4xl mx-auto" x-data="orderCreate" x-init="init()">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('tenant.admin.orders.index', $store->slug) }}" 
               class="text-black-300 hover:text-black-400">
                <x-solar-arrow-left-outline class="w-6 h-6" />
            </a>
            <h1 class="text-lg font-semibold text-black-500">Nuevo Pedido</h1>
        </div>
    </div>

    <!-- Alerta de validación -->
    <div x-show="showValidationAlert" 
         x-cloak
         class="fixed bottom-4 right-4 z-50 max-w-md mb-4"
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

    <form action="{{ route('tenant.admin.orders.store', $store->slug) }}" method="POST" enctype="multipart/form-data" @submit="validateForm" class="space-y-6">
        @csrf

        <!-- Información del Cliente -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-sm font-medium text-gray-700 mb-4">Información del Cliente</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre Completo *
                    </label>
                    <input type="text" 
                           id="customer_name" 
                           name="customer_name" 
                           value="{{ old('customer_name') }}" 
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
                           value="{{ old('customer_phone') }}" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-gray-900 placeholder-gray-400"
                           placeholder="3001234567">
                    @error('customer_phone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Tipo de Entrega y Pago - Tailwind Puro -->
        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
            <h3 class="text-base font-semibold text-gray-900 mb-6">Entrega y Pago</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Tipo de Entrega -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Tipo de Entrega *</label>
                    <div class="space-y-3">
                        @if($simpleShipping && $simpleShipping->pickup_enabled)
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-100 cursor-pointer transition-colors">
                            <input type="radio" 
                                   name="delivery_type" 
                                   value="pickup" 
                                   {{ old('delivery_type') === 'pickup' ? 'checked' : '' }}
                                   x-model="deliveryType" 
                                   @change="updateShippingOptions()"
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="ml-3 text-sm text-gray-900 flex items-center gap-2">
                                <i data-lucide="store" class="w-4 h-4"></i>
                                Recogida en Tienda (Gratis)
                            </span>
                        </label>
                        @endif
                        
                        @if($simpleShipping && $simpleShipping->local_enabled)
                        <div>
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-100 cursor-pointer transition-colors">
                                <input type="radio" 
                                       name="delivery_type" 
                                       value="local" 
                                       {{ old('delivery_type') === 'local' ? 'checked' : '' }}
                                       x-model="deliveryType" 
                                       @change="updateShippingOptions()"
                                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-3 text-sm text-gray-900 flex items-center gap-2">
                                    <i data-lucide="truck" class="w-4 h-4"></i>
                                    Envío Local
                                </span>
                            </label>
                            
                            <!-- Campos para envío local -->
                            <template x-if="deliveryType === 'local'">
                                <div class="mt-3 ml-7 space-y-3">
                                    <div>
                                        <label for="customer_address_local" class="block text-xs font-medium text-gray-700 mb-2">
                                            Dirección *
                                        </label>
                                        <textarea id="customer_address_local" 
                                                  name="customer_address" 
                                                  required
                                                  rows="2"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                  placeholder="Dirección completa, barrio, referencias">{{ old('customer_address') }}</textarea>
                                    </div>
                                </div>
                            </template>
                        </div>
                        @endif
                        
                        @if($simpleShipping && $simpleShipping->national_enabled)
                        <div>
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-100 cursor-pointer transition-colors">
                                <input type="radio" 
                                       name="delivery_type" 
                                       value="national" 
                                       {{ old('delivery_type') === 'national' ? 'checked' : '' }}
                                       x-model="deliveryType" 
                                       @change="updateShippingOptions()"
                                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-3 text-sm text-gray-900 flex items-center gap-2">
                                    <i data-lucide="package" class="w-4 h-4"></i>
                                    Envío Nacional
                                </span>
                            </label>
                            
                            <!-- Campos para envío nacional -->
                            <template x-if="deliveryType === 'national'">
                                <div class="mt-3 ml-7 space-y-3">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label for="department_national" class="block text-xs font-medium text-gray-700 mb-2">
                                                Departamento *
                                            </label>
                                            <select id="department_national" 
                                                    name="department" 
                                                    x-model="selectedDepartment"
                                                    @change="onDepartmentChange()"
                                                    required
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="">Seleccionar...</option>
                                                <template x-for="dept in availableDepartments" :key="dept">
                                                    <option :value="dept" x-text="dept"></option>
                                                </template>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label for="city_national" class="block text-xs font-medium text-gray-700 mb-2">
                                                Ciudad *
                                            </label>
                                            <select id="city_national" 
                                                    name="city" 
                                                    x-model="selectedCity"
                                                    @change="onCityChange()"
                                                    required
                                                    :disabled="!selectedDepartment"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                                <option value="">Seleccionar...</option>
                                                <template x-for="city in availableCities" :key="city">
                                                    <option :value="city" x-text="city"></option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label for="customer_address_national" class="block text-xs font-medium text-gray-700 mb-2">
                                            Dirección *
                                        </label>
                                        <textarea id="customer_address_national" 
                                                  name="customer_address" 
                                                  required
                                                  rows="2"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                  placeholder="Dirección completa, barrio, referencias">{{ old('customer_address') }}</textarea>
                                    </div>
                                    
                                    <!-- Input hidden para shipping_zone_id (auto-calculado) -->
                                    <input type="hidden" name="shipping_zone_id" :value="selectedShippingZone">
                                    
                                    <!-- Mostrar zona y costo calculado -->
                                    <div x-show="selectedCity && shippingCost > 0" class="p-3 bg-blue-50 rounded-lg border border-blue-200">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-700">Costo de envío:</span>
                                            <span class="font-semibold text-blue-600" x-text="`$${shippingCost.toLocaleString()}`"></span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        @endif
                        
                        @if(!$simpleShipping || (!$simpleShipping->pickup_enabled && !$simpleShipping->local_enabled && !$simpleShipping->national_enabled))
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex items-center gap-3">
                                <i data-lucide="alert-triangle" class="w-5 h-5 text-yellow-600 flex-shrink-0"></i>
                                <div>
                                    <h4 class="text-sm font-medium text-yellow-800">Sin Métodos de Entrega</h4>
                                    <div class="text-xs text-yellow-700 mt-1">
                                        No hay métodos de entrega configurados. 
                                        <a href="{{ route('tenant.admin.simple-shipping.index', $store->slug) }}" class="underline text-blue-600 hover:text-blue-700">
                                            Configurar ahora
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @error('delivery_type')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Método de Pago -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Método de Pago *</label>
                    <div class="space-y-3">
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-100 cursor-pointer transition-colors">
                            <input type="radio" 
                                   name="payment_method" 
                                   value="transferencia" 
                                   {{ old('payment_method') === 'transferencia' ? 'checked' : '' }}
                                   x-model="paymentMethod"
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="ml-3 text-sm text-gray-900">Transferencia Bancaria</span>
                        </label>
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-100 cursor-pointer transition-colors">
                            <input type="radio" 
                                   name="payment_method" 
                                   value="contra_entrega" 
                                   {{ old('payment_method') === 'contra_entrega' ? 'checked' : '' }}
                                   x-model="paymentMethod"
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="ml-3 text-sm text-gray-900">Pago Contra Entrega</span>
                        </label>
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-100 cursor-pointer transition-colors" x-show="deliveryType === 'pickup'">
                            <input type="radio" 
                                   name="payment_method" 
                                   value="efectivo" 
                                   {{ old('payment_method') === 'efectivo' ? 'checked' : '' }}
                                   x-model="paymentMethod"
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="ml-3 text-sm text-gray-900">Efectivo</span>
                        </label>
                    </div>
                    @error('payment_method')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Comprobante de Pago (solo para transferencia) -->
            <div x-show="paymentMethod === 'transferencia'" class="mt-6">
                <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-2">Comprobante de Pago (Opcional)</label>
                <div class="w-full">
                    <label class="block">
                        <span class="sr-only">Seleccionar archivo</span>
                        <input 
                            type="file" 
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

        <!-- Productos - Tailwind Puro -->
        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
            <h3 class="text-base font-semibold text-gray-900 mb-6">Productos del Pedido</h3>
            
            <!-- Formulario para agregar producto -->
            <div class="bg-white rounded-lg p-4 mb-4 border-2 border-blue-200 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-end">
                    <!-- Búsqueda de producto -->
                    <div class="lg:col-span-4 relative">
                        <label class="block text-xs font-medium text-gray-700 mb-2">Buscar Producto *</label>
                        <input type="text"
                               x-model="newItem.productSearch"
                               @input="searchNewProduct()"
                               @focus="newItem.showResults = true"
                               placeholder="Escribe para buscar..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        
                        <!-- Resultados de búsqueda -->
                        <div x-show="newItem.showResults && newItem.searchResults.length > 0"
                             @click.away="newItem.showResults = false"
                             class="absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                            <template x-for="product in newItem.searchResults" :key="product.id">
                                <button type="button"
                                        @click="selectNewProduct(product)"
                                        class="w-full flex items-center gap-3 p-3 hover:bg-gray-50 transition-colors text-left border-b border-gray-100 last:border-0">
                                    <div class="w-10 h-10 rounded flex-shrink-0 border border-gray-200 overflow-hidden bg-gray-100 relative">
                                        <img :src="product.main_image_url || ''" 
                                             :alt="product.name"
                                             class="w-full h-full object-cover"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="w-full h-full hidden items-center justify-center absolute inset-0">
                                            <i data-lucide="package" class="w-6 h-6 text-gray-500"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm font-medium text-gray-900 truncate" x-text="product.name"></div>
                                        <div class="text-xs text-gray-600">
                                            <span x-text="`$${product.price.toLocaleString()}`"></span>
                                            <span x-show="product.variants && product.variants.length > 0"
                                                  class="ml-2 text-blue-600">• Variantes</span>
                                        </div>
                                    </div>
                                </button>
                            </template>
                        </div>
                        
                        <!-- Producto seleccionado -->
                        <div x-show="newItem.product_id"
                             class="mt-2 p-2 bg-blue-50 rounded-lg flex items-center gap-2 border border-blue-200">
                            <div class="w-8 h-8 rounded flex-shrink-0 border border-blue-200 overflow-hidden bg-white relative">
                                <img :src="newItem.selectedProduct?.main_image_url || ''" 
                                     :alt="newItem.selectedProduct?.name"
                                     class="w-full h-full object-cover"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-full h-full hidden items-center justify-center absolute inset-0">
                                    <i data-lucide="package" class="w-5 h-5 text-blue-600"></i>
                                </div>
                            </div>
                            <span class="text-sm text-gray-900 truncate flex-1" x-text="newItem.selectedProduct?.name"></span>
                            <button type="button" 
                                    @click="clearNewProduct()"
                                    class="text-red-600 hover:text-red-700 transition-colors">
                                <i data-lucide="x-circle" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Variante (si aplica) -->
                    <div x-show="newItem.hasVariants" class="lg:col-span-3">
                        <label class="block text-xs font-medium text-gray-700 mb-2">Variante *</label>
                        <select x-model="newItem.selectedVariantId"
                                @change="updateNewItemPrice()"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccionar...</option>
                            <template x-for="variant in newItem.variants" :key="variant.id">
                                <option :value="variant.id" x-text="`${variant.variant_options_text} ${variant.price_modifier >= 0 ? '(+$' + variant.price_modifier.toLocaleString() + ')' : '(-$' + Math.abs(variant.price_modifier).toLocaleString() + ')'}`"></option>
                            </template>
                        </select>
                    </div>
                    
                    <!-- Cantidad -->
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-medium text-gray-700 mb-2">Cantidad *</label>
                        <input type="number"
                               x-model="newItem.quantity"
                               @input="updateNewItemPrice()"
                               min="1"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <!-- Total -->
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-medium text-gray-700 mb-2">Total</label>
                        <div class="px-3 py-2 bg-blue-50 rounded-lg text-sm font-semibold text-blue-600 text-center border border-blue-200"
                             x-text="`$${newItem.total.toLocaleString()}`"></div>
                    </div>
                    
                    <!-- Botón Agregar -->
                    <div class="lg:col-span-1 flex items-end">
                        <button type="button"
                                @click="addProductToOrder()"
                                :disabled="!newItem.product_id || (newItem.hasVariants && !newItem.selectedVariantId)"
                                class="px-8 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center justify-center gap-2 whitespace-nowrap">
                            <i data-lucide="plus-circle" class="w-5 h-5 flex-shrink-0"></i>
                            <span class="hidden xl:inline">Agregar</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Lista de productos agregados -->
            <div x-show="orderItems.length > 0" class="space-y-3">
                <h4 class="text-xs font-medium text-gray-700 uppercase tracking-wide">Productos Agregados (<span x-text="orderItems.length"></span>)</h4>
                <template x-for="(item, index) in orderItems" :key="index">
                    <div class="bg-white rounded-lg p-4 border border-gray-300 flex items-center gap-4">
                        <!-- Inputs hidden para el form -->
                        <input type="hidden" :name="`items[${index}][product_id]`" :value="item.product_id">
                        <input type="hidden" :name="`items[${index}][variant_id]`" :value="item.selectedVariantId || ''">
                        <input type="hidden" :name="`items[${index}][quantity]`" :value="item.quantity">
                        
                        <!-- Imagen -->
                        <div class="w-16 h-16 rounded-lg flex-shrink-0 border border-gray-200 overflow-hidden bg-gray-100 relative">
                            <img :src="item.selectedProduct?.main_image_url || ''" 
                                 :alt="item.selectedProduct?.name"
                                 class="w-full h-full object-cover"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-full h-full hidden items-center justify-center absolute inset-0">
                                <i data-lucide="package" class="w-8 h-8 text-gray-500"></i>
                            </div>
                        </div>
                        
                        <!-- Info -->
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-gray-900" x-text="item.selectedProduct?.name"></div>
                            <div class="text-xs text-gray-600 mt-1">
                                <span x-show="item.selectedVariantId" x-text="item.variants.find(v => v.id == item.selectedVariantId)?.variant_options_text"></span>
                                <span class="mx-2" x-show="item.selectedVariantId">•</span>
                                <span>Cantidad: <strong x-text="item.quantity"></strong></span>
                                <span class="mx-2">•</span>
                                <span>Precio unit.: <strong x-text="`$${item.unitPrice.toLocaleString()}`"></strong></span>
                            </div>
                        </div>
                        
                        <!-- Total -->
                        <div class="text-right flex-shrink-0">
                            <div class="text-xs text-gray-500">Total</div>
                            <div class="text-lg font-semibold text-blue-600" x-text="`$${item.total.toLocaleString()}`"></div>
                        </div>
                        
                        <!-- Botón eliminar -->
                        <button type="button"
                                @click="removeProduct(index)"
                                class="flex-shrink-0 p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </button>
                    </div>
                </template>
            </div>
            
            <!-- Estado vacío -->
            <div x-show="orderItems.length === 0" class="text-center py-8 bg-white rounded-lg border-2 border-dashed border-gray-300">
                <i data-lucide="shopping-bag" class="w-12 h-12 text-gray-400 mx-auto mb-3"></i>
                <p class="text-gray-600 text-sm">Usa el formulario de arriba para agregar productos</p>
            </div>
        </div>

        <!-- Resumen del Pedido -->
        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200" x-show="orderItems.length > 0">
            <h3 class="text-base font-semibold text-gray-900 mb-4">Resumen del Pedido</h3>
            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-700">Subtotal:</span>
                    <span class="text-gray-900 font-medium" x-text="`$${subtotal.toLocaleString()}`"></span>
                </div>
                <div class="flex justify-between text-sm" x-show="shippingCost > 0">
                    <span class="text-gray-700">Envío:</span>
                    <span class="text-gray-900 font-medium" x-text="`$${shippingCost.toLocaleString()}`"></span>
                </div>
                
                <!-- Badge de envío gratis -->
                <div x-show="showFreeShippingMessage" 
                     class="p-3 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center gap-2 text-green-700 text-sm">
                        <i data-lucide="check-circle" class="w-4 h-4 flex-shrink-0"></i>
                        <span x-text="showFreeShippingMessage"></span>
                    </div>
                </div>
                <div class="flex justify-between border-t border-gray-300 pt-3">
                    <span class="text-lg font-semibold text-gray-900">Total:</span>
                    <span class="text-lg font-semibold text-blue-600" x-text="`$${total.toLocaleString()}`"></span>
                </div>
            </div>
        </div>

        <!-- Notas Adicionales -->
        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
            <h3 class="text-base font-semibold text-gray-900 mb-4">Notas Adicionales</h3>
            <textarea name="notes" 
                      rows="3"
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-gray-900 placeholder-gray-400"
                      placeholder="Instrucciones especiales, observaciones, etc.">{{ old('notes') }}</textarea>
            @error('notes')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Acciones -->
        <div class="flex gap-3 justify-end">
            <a href="{{ route('tenant.admin.orders.index', $store->slug) }}" class="px-4 py-2 border-2 border-error-300 text-error-300 rounded-lg hover:bg-error-100 transition-colors">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors flex items-center gap-2 shadow-sm" :disabled="orderItems.length === 0">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                Crear Pedido
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('orderCreate', () => ({
        // Datos
        deliveryType: '{{ old("delivery_type") }}',
        paymentMethod: '{{ old("payment_method") }}',
        selectedDepartment: '',
        selectedCity: '',
        selectedShippingZone: '',
        shippingCost: 0,
        products: @json($products),
        shippingMethods: @json($shippingZones ?? []),
        simpleShipping: @json($simpleShippingData ?? null),
        orderItems: [],
        subtotal: 0,
        total: 0,
        showFreeShippingMessage: null,
        showValidationAlert: false,
        validationMessage: '',
        availableDepartments: [],
        citiesByDepartment: {},
        zonesByCity: {},
        availableCities: [],
        newItem: {
            product_id: null,
            productSearch: '',
            selectedProduct: null,
            hasVariants: false,
            variants: [],
            selectedVariantId: null,
            quantity: 1,
            unitPrice: 0,
            total: 0,
            showResults: false,
            searchResults: []
        },

        init() {
            // Cargar departamentos y ciudades para envío nacional
            this.loadDepartmentsAndCities();
        },

        loadDepartmentsAndCities() {
            fetch('{{ route("tenant.admin.orders.shipping-departments", $store->slug) }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.availableDepartments = data.departments;
                        this.citiesByDepartment = data.cities_by_department;
                        this.zonesByCity = data.zones_by_city;
                    }
                })
                .catch(error => {
                    // Error cargando departamentos
                });
        },

        onDepartmentChange() {
            // Resetear ciudad y zona
            this.selectedCity = '';
            this.selectedShippingZone = '';
            this.shippingCost = 0;
            
            // Cargar ciudades del departamento seleccionado
            if (this.selectedDepartment && this.citiesByDepartment[this.selectedDepartment]) {
                this.availableCities = this.citiesByDepartment[this.selectedDepartment];
            } else {
                this.availableCities = [];
            }
            
            this.calculateTotals();
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
            
            this.calculateTotals();
        },

        searchNewProduct() {
            const search = this.newItem.productSearch?.toLowerCase() || '';
            
            if (search.length < 2) {
                this.newItem.searchResults = [];
                return;
            }
            
            this.newItem.searchResults = this.products.filter(p => 
                p.name.toLowerCase().includes(search) ||
                p.sku?.toLowerCase().includes(search)
            ).slice(0, 5);
        },

        selectNewProduct(product) {
            this.newItem.product_id = product.id;
            this.newItem.productSearch = product.name;
            this.newItem.selectedProduct = product;
            this.newItem.hasVariants = product.variants && product.variants.length > 0;
            this.newItem.variants = product.variants || [];
            this.newItem.selectedVariantId = null;
            this.newItem.unitPrice = parseFloat(product.price);
            this.newItem.showResults = false;
            this.updateNewItemPrice();
        },

        clearNewProduct() {
            this.newItem = {
                product_id: null,
                productSearch: '',
                selectedProduct: null,
                hasVariants: false,
                variants: [],
                selectedVariantId: null,
                quantity: 1,
                unitPrice: 0,
                total: 0,
                showResults: false,
                searchResults: []
            };
        },

        updateNewItemPrice() {
            if (!this.newItem.selectedProduct) return;
            
            let basePrice = parseFloat(this.newItem.selectedProduct.price);
            
            if (this.newItem.selectedVariantId) {
                const variant = this.newItem.variants.find(v => v.id == this.newItem.selectedVariantId);
                if (variant) {
                    basePrice += parseFloat(variant.price_modifier || 0);
                }
            }
            
            this.newItem.unitPrice = basePrice;
            this.newItem.total = basePrice * parseInt(this.newItem.quantity || 1);
        },

        addProductToOrder() {
            // Validar que haya producto seleccionado
            if (!this.newItem.product_id) {
                return;
            }
            
            // Validar variante si es necesario
            if (this.newItem.hasVariants && !this.newItem.selectedVariantId) {
                return;
            }
            
            // Agregar a la lista
            this.orderItems.push({
                product_id: this.newItem.product_id,
                selectedProduct: this.newItem.selectedProduct,
                hasVariants: this.newItem.hasVariants,
                variants: this.newItem.variants,
                selectedVariantId: this.newItem.selectedVariantId,
                quantity: parseInt(this.newItem.quantity),
                unitPrice: this.newItem.unitPrice,
                total: this.newItem.total
            });
            
            // Recalcular totales
            this.calculateTotals();
            this.calculateShipping();
            
            // Limpiar formulario
            this.clearNewProduct();
        },

        removeProduct(index) {
            this.orderItems.splice(index, 1);
            this.calculateTotals();
            this.calculateShipping();
        },

        calculateTotals() {
            this.subtotal = this.orderItems.reduce((sum, item) => sum + item.total, 0);
            this.total = this.subtotal + this.shippingCost;
        },

        updateShippingOptions() {
            this.selectedShippingZone = '';
            this.shippingCost = 0;
            this.showFreeShippingMessage = null;
            
            if (this.deliveryType === 'pickup') {
                // Pickup es gratis
                this.shippingCost = 0;
            } else if (this.deliveryType === 'local') {
                // Envío local: aplicar automáticamente el costo de la primera zona local
                this.applyLocalShipping();
            } else if (this.deliveryType === 'national') {
                // Nacional: esperar selección de zona
                this.shippingCost = 0;
            }
            
            this.calculateTotals();
        },

        applyLocalShipping() {
            // Para envío local, usar el costo configurado en SimpleShipping, no zonas
            if (this.simpleShipping && this.simpleShipping.local_enabled) {
                this.shippingCost = parseFloat(this.simpleShipping.local_cost) || 0;
                const freeFrom = parseFloat(this.simpleShipping.local_free_from) || null;
                
                // Verificar si califica para envío gratis
                if (freeFrom && this.subtotal >= freeFrom) {
                    this.shippingCost = 0;
                    this.showFreeShippingMessage = `¡Envío GRATIS! (mínimo: $${freeFrom.toLocaleString()})`;
                } else {
                    this.showFreeShippingMessage = null;
                }
            }
            this.calculateTotals();
        },

        calculateShipping() {
            // Si es envío local, recalcular con SimpleShipping (para envío gratis si aplica)
            if (this.deliveryType === 'local') {
                this.applyLocalShipping();
                return;
            }
            
            // Si es nacional, requiere zona seleccionada
            if (this.deliveryType === 'national') {
                if (!this.selectedShippingZone) {
                    this.shippingCost = 0;
                    this.showFreeShippingMessage = null;
                    this.calculateTotals();
                    return;
                }

                // Buscar la zona seleccionada
                let zone = null;
                for (const method of this.shippingMethods) {
                    const found = method.active_zones?.find(z => z.id == this.selectedShippingZone);
                    if (found) {
                        zone = found;
                        break;
                    }
                }
                
                if (!zone) {
                    this.shippingCost = 0;
                    this.showFreeShippingMessage = null;
                    this.calculateTotals();
                    return;
                }
                
                // Aplicar envío gratis si cumple monto mínimo
                if (zone.free_shipping_from && this.subtotal >= zone.free_shipping_from) {
                    this.shippingCost = 0;
                    this.showFreeShippingMessage = `¡Envío GRATIS! (mínimo: $${zone.free_shipping_from.toLocaleString()})`;
                } else {
                    this.shippingCost = parseFloat(zone.cost) || 0;
                    this.showFreeShippingMessage = null;
                }
                
                this.calculateTotals();
            }
        },

        validateForm(event) {
            // Validar que hay productos
            if (this.orderItems.length === 0) {
                event.preventDefault();
                this.validationMessage = 'Debes agregar al menos un producto al pedido';
                this.showValidationAlert = true;
                // Ocultar después de 5 segundos
                setTimeout(() => {
                    this.showValidationAlert = false;
                }, 5000);
                return false;
            }

            // Validar método de envío si es nacional
            if (this.deliveryType === 'national' && !this.selectedShippingZone) {
                event.preventDefault();
                this.validationMessage = 'Debes seleccionar una zona de envío para pedidos nacionales';
                this.showValidationAlert = true;
                // Ocultar después de 5 segundos
                setTimeout(() => {
                    this.showValidationAlert = false;
                }, 5000);
                return false;
            }

            return true;
        }
    }));
    
    // Inicializar iconos Lucide después de que Alpine esté listo
    Alpine.nextTick(() => {
        if (typeof lucide !== 'undefined' && lucide.createIcons) {
            lucide.createIcons();
        }
    });
});
</script>
@endpush
@endsection
</x-tenant-admin-layout> 