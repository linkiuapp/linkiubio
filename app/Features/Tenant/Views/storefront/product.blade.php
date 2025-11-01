@extends('frontend.layouts.app')

@section('content')
<div class="p-4 space-y-4">
    <!-- Breadcrumb -->
    <nav class="flex caption text-brandInfo-300">
        <a href="{{ route('tenant.home', $store->slug) }}" class="hover:text-brandInfo-400 transition-colors">Inicio</a>
        <span class="mx-1">/</span>
        <a href="{{ route('tenant.catalog', $store->slug) }}" class="hover:text-brandInfo-400 transition-colors">Catálogo</a>
        <span class="mx-1">/</span>
        <span class="text-brandNeutral-400 caption-strong">{{ $product->name }}</span>
    </nav>

    <!-- Producto Principal -->
    <div class="bg-brandWhite-100 rounded-lg p-4 space-y-4">
        <!-- Imagen Principal -->
        <div class="w-full aspect-square sm:h-72 bg-brandWhite-100 rounded-xl overflow-hidden mb-3" id="main-image-container">
            @if($product->images->count() > 0)
                <img src="{{ $product->images->first()->image_url }}" 
                     alt="{{ $product->name }}" 
                     id="main-image"
                     class="w-full h-full object-cover transition-all duration-300">
            @elseif($product->main_image_url)
                <img src="{{ $product->main_image_url }}" 
                     alt="{{ $product->name }}" 
                     id="main-image"
                     class="w-full h-full object-cover transition-all duration-300">
            @else
                <div class="w-full h-full flex items-center justify-center text-brandNeutral-200">
                    <i data-lucide="gallery" class="w-16 h-16 text-brandNeutral-200"></i>
                </div>
            @endif
        </div>

        <!-- Galería de miniaturas (solo si hay más de 1 imagen) -->
        @if($product->images->count() > 1)
            <div class="space-y-2">
                <p class="caption text-brandNeutral-400">Imágenes ({{ $product->images->count() }})</p>
                <div class="flex gap-2 overflow-x-auto pb-2 -mx-4 px-4">
                    @foreach($product->images as $index => $image)
                        <div class="w-20 h-20 sm:w-16 sm:h-16 bg-brandPrimary-50 rounded-lg overflow-hidden flex-shrink-0 cursor-pointer border-2 transition-all duration-200 image-thumb {{ $index === 0 ? 'border-brandPrimary-300' : 'border-transparent hover:border-brandPrimary-200' }}" 
                             onclick="changeMainImage('{{ $image->image_url }}', {{ $index }})">
                            <img src="{{ $image->image_url }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Información del Producto -->
        <div class="space-y-3">
            <!-- Título, precio y compartir -->
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1">
                    <h1 class="body-lg-bold text-brandNeutral-400 mb-1">{{ $product->name }}</h1>
                    <div class="body-lg-bold text-brandNeutral-400">
                        ${{ number_format($product->price, 0, ',', '.') }}
                    </div>
                </div>
                
                <!-- Botón Compartir (solo si está permitido) -->
                @if($product->allow_sharing)
                <button onclick="shareProduct()" 
                        class="flex-shrink-0 flex items-center gap-2 bg-brandSuccess-300 hover:bg-brandSuccess-200 text-brandWhite-50 px-3 py-2 rounded-lg caption transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    <span class="hidden sm:inline">Compartir producto</span>
                </button>
                @endif
            </div>

            <!-- Categorías -->
            @if($product->categories->count() > 0)
                <div class="flex flex-wrap gap-2">
                    @foreach($product->categories as $category)
                        <a href="{{ route('tenant.category', [$store->slug, $category->slug]) }}" 
                           class="px-3 py-1 bg-brandSuccess-50 border border-brandSuccess-400 text-brandSuccess-400 rounded-full caption hover:bg-brandSuccess-200 transition-colors">
                            <span class="caption text-brandSuccess-400">
                                {{ $category->name }}
                            </span>
                        </a>
                    @endforeach
                </div>
            @endif

            <!-- Descripción -->
            @if($product->description)
                <div class="space-y-2">
                    <h3 class="caption text-brandNeutral-400">Descripción</h3>
                    <p class="caption text-brandNeutral-400 leading-relaxed">{{ $product->description }}</p>
                </div>
            @endif

            <!-- SKU -->
            @if($product->sku)
                <div class="caption text-brandNeutral-400">
                    SKU: {{ $product->sku }}
                </div>
            @endif
        </div>

        <!-- Variables del Producto (si aplica) -->
        @if($product->type === 'variable' && $product->variableAssignments->count() > 0)
            <div class="border-t border-brandNeutral-50 pt-4 space-y-4" id="product-variables">
                <h3 class="body-lg-bold text-brandNeutral-400">Personaliza tu producto</h3>
                
                @foreach($product->variableAssignments as $assignment)
                    @php
                        $variable = $assignment->variable;
                        $label = $assignment->custom_label ?: $variable->name;
                        $isRequired = $assignment->is_required;
                        
                        // Obtener solo las opciones seleccionadas para este producto
                        $selectedOptionIds = $assignment->selected_options ?? [];
                        $availableOptions = $variable->activeOptions->whereIn('id', $selectedOptionIds);
                    @endphp
                    
                    <div class="space-y-2" 
                         data-variable-id="{{ $variable->id }}"
                         data-variable-name="{{ $label }}"
                         data-variable-required="{{ $isRequired ? 'true' : 'false' }}">
                        <label class="caption text-brandNeutral-400">
                            {{ $label }}
                            @if($isRequired)
                                <span class="text-brandError-300">*</span>
                            @else
                                <span class="caption text-brandNeutral-400">(opcional)</span>
                            @endif
                        </label>

                        @if($variable->type === 'radio')
                            {{-- Selección única (radio) --}}
                            <div class="space-y-2">
                                @foreach($availableOptions as $option)
                                    <label class="flex items-center gap-3 p-3 border border-brandPrimary-300 rounded-lg cursor-pointer hover:bg-brandPrimary-50 transition-all"
                                           onclick="selectOption(this, {{ $variable->id }}, {{ $option->id }}, '{{ $option->name }}', {{ $option->price_modifier }}, 'radio')">
                                        <input type="radio" 
                                               name="variable_{{ $variable->id }}" 
                                               value="{{ $option->id }}"
                                               class="w-4 h-4 text-brandPrimary-300"
                                               {{ $isRequired && $loop->first ? 'checked' : '' }}
                                               data-variable-id="{{ $variable->id }}"
                                               data-option-id="{{ $option->id }}"
                                               data-price-modifier="{{ $option->price_modifier }}">
                                        <div class="flex-1 flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                @if($option->color_hex)
                                                    <div class="w-5 h-5 rounded-full border border-brandNeutral-50" 
                                                         style="background-color: {{ $option->color_hex }};"></div>
                                                @endif
                                                <span class="caption text-brandNeutral-400">{{ $option->name }}</span>
                                            </div>
                                            @if($option->price_modifier != 0)
                                                <span class="caption text-brandNeutral-400 {{ $option->price_modifier > 0 ? 'text-brandSuccess-300' : 'text-brandError-300' }}">
                                                    {{ $option->formatted_price_modifier }}
                                                </span>
                                            @endif
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                        @elseif($variable->type === 'checkbox')
                            {{-- Selección múltiple (checkbox) --}}
                            <div class="space-y-2">
                                @foreach($availableOptions as $option)
                                    <label class="flex items-center gap-3 p-3 border border-brandPrimary-300 rounded-lg cursor-pointer hover:bg-brandPrimary-50 transition-all"
                                           onclick="toggleCheckbox(this, {{ $variable->id }}, {{ $option->id }}, '{{ $option->name }}', {{ $option->price_modifier }})">
                                        <input type="checkbox" 
                                               name="variable_{{ $variable->id }}[]" 
                                               value="{{ $option->id }}"
                                               class="w-4 h-4 text-brandPrimary-300 rounded"
                                               data-variable-id="{{ $variable->id }}"
                                               data-option-id="{{ $option->id }}"
                                               data-price-modifier="{{ $option->price_modifier }}">
                                        <div class="flex-1 flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                @if($option->color_hex)
                                                    <div class="w-5 h-5 rounded-full border border-brandPrimary-300" 
                                                         style="background-color: {{ $option->color_hex }};"></div>
                                                @endif
                                                <span class="caption text-brandNeutral-400">{{ $option->name }}</span>
                                            </div>
                                            @if($option->price_modifier != 0)
                                                <span class="caption text-brandNeutral-400 {{ $option->price_modifier > 0 ? 'text-brandSuccess-300' : 'text-brandError-300' }}">
                                                    {{ $option->formatted_price_modifier }}
                                                </span>
                                            @endif
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                        @elseif($variable->type === 'text')
                            {{-- Texto libre --}}
                            <input type="text" 
                                   name="variable_{{ $variable->id }}"
                                   placeholder="Escribe aquí..."
                                   class="w-full p-3 border border-brandPrimary-300 rounded-lg outline-none caption"
                                   data-variable-id="{{ $variable->id }}"
                                   {{ $isRequired ? 'required' : '' }}>

                        @elseif($variable->type === 'numeric')
                            {{-- Numérico --}}
                            <input type="number" 
                                   name="variable_{{ $variable->id }}"
                                   placeholder="Ingresa un número"
                                   class="w-full p-3 border border-brandPrimary-300 rounded-lg outline-none caption"
                                   data-variable-id="{{ $variable->id }}"
                                   min="{{ $variable->min_value }}"
                                   max="{{ $variable->max_value }}"
                                   {{ $isRequired ? 'required' : '' }}>
                        @endif
                    </div>
                @endforeach

                <!-- Precio total actualizado -->
                <div class="flex items-center justify-between p-4 bg-brandWhite-100 rounded-lg">
                    <span class="body-lg-bold text-brandNeutral-400">Precio Total:</span>
                    <span id="total-price" class="body-lg-bold text-brandNeutral-400">
                        ${{ number_format($product->price, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        @endif

        <!-- Botón Agregar al Carrito -->
        <div class="pt-2">
            @if($product->type === 'simple')
                <button class="w-full bg-brandPrimary-300 hover:bg-brandPrimary-400 text-brandWhite-50 py-3 rounded-lg caption transition-colors flex items-center justify-center gap-2 add-to-cart-btn"
                        data-product-id="{{ $product->id }}"
                        data-product-name="{{ $product->name }}"
                        data-product-price="{{ $product->price }}"
                        data-product-image="{{ $product->main_image_url }}">
                    <i data-lucide="shopping-cart" class="w-5 h-5 text-brandWhite-50"></i>
                    Agregar al Carrito
                </button>
            @else
                <button id="add-variable-product-btn" 
                        class="w-full bg-brandPrimary-300 hover:bg-brandPrimary-400 disabled:bg-brandNeutral-50 disabled:cursor-not-allowed text-brandWhite-50 py-3 rounded-lg transition-colors flex items-center justify-center gap-2"
                        onclick="addVariableProductToCart()">
                    <i data-lucide="shopping-cart" class="w-5 h-5 text-brandWhite-50"></i>
                    Agregar al Carrito
                </button>
            @endif
        </div>
    </div>

    <!-- Productos Relacionados -->
    @if($relatedProducts->count() > 0)
        <div class="space-y-3">
            <h2 class="caption text-brandNeutral-400">Productos Relacionados</h2>
            
            <div class="grid grid-cols-2 gap-3">
                @foreach($relatedProducts as $relatedProduct)
                    <a href="{{ route('tenant.product', [$store->slug, $relatedProduct->slug]) }}" 
                       class="bg-brandWhite-100 rounded-lg p-3 border border-brandNeutral-50 hover:border-brandPrimary-200 transition-colors">
                        <!-- Imagen -->
                        <div class="w-full h-24 bg-brandWhite-100 rounded-lg overflow-hidden mb-2">
                            @if($relatedProduct->main_image_url)
                                <img src="{{ $relatedProduct->main_image_url }}" 
                                     alt="{{ $relatedProduct->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-brandNeutral-400">
                                    <x-solar-gallery-outline class="w-6 h-6" />
                                </div>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="space-y-1">
                            <h3 class="caption text-brandNeutral-400 line-clamp-1">{{ $relatedProduct->name }}</h3>
                            <div class="body-lg-bold text-brandNeutral-400">
                                ${{ number_format($relatedProduct->price, 0, ',', '.') }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    // Precio base del producto
    const basePrice = {{ $product->price }};
    let selectedVariables = {};

    function changeMainImage(imageUrl, index) {
        // Cambiar imagen principal
        const mainImage = document.getElementById('main-image');
        if (mainImage) {
            mainImage.style.opacity = '0.7';
            setTimeout(() => {
                mainImage.src = imageUrl;
                mainImage.style.opacity = '1';
            }, 150);
        }

        // Actualizar thumbnails activos
        document.querySelectorAll('.image-thumb').forEach((thumb, i) => {
            if (i === index) {
                thumb.classList.remove('border-transparent', 'hover:border-brandPrimary-200');
                thumb.classList.add('border-brandPrimary-300');
            } else {
                thumb.classList.remove('border-brandPrimary-300');
                thumb.classList.add('border-transparent', 'hover:border-brandPrimary-200');
            }
        });
    }

    // Navegación con teclado (opcional)
    document.addEventListener('keydown', function(e) {
        const thumbs = document.querySelectorAll('.image-thumb');
        if (thumbs.length <= 1) return;

        const currentActive = Array.from(thumbs).findIndex(thumb => 
            thumb.classList.contains('border-brandPrimary-300'));
        
        if (e.key === 'ArrowRight' && currentActive < thumbs.length - 1) {
            thumbs[currentActive + 1].click();
        } else if (e.key === 'ArrowLeft' && currentActive > 0) {
            thumbs[currentActive - 1].click();
        }
    });

    // Función para compartir producto por WhatsApp
    function shareProduct() {
        const productName = {!! json_encode($product->name) !!};
        const productPrice = "${{ number_format($product->price, 0, ',', '.') }}";
        const productUrl = {!! json_encode(url()->current()) !!};
        const storeName = {!! json_encode($store->name) !!};
        const productDescription = {!! json_encode($product->description ?? '') !!};
        // Usar códigos Unicode para emojis que funcionan bien en WhatsApp
        const message = `¡Hey! Te comparto este pedido que estoy pensando hacer:\n\n` +
                `🍴 ${productName}\n` +
                `💰 ${productPrice}\n` +
                `🗨️ ${productDescription}\n\n` +
                `👉 Ver producto: ${productUrl}\n` +
                `Lo encontré en ${storeName}, ¿qué opinas?`;

        const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(message)}`;
        window.open(whatsappUrl, '_blank');
    }

    // Funciones para manejar variables
    function selectOption(labelElement, variableId, optionId, optionName, priceModifier, type) {
        // Actualizar el objeto de variables seleccionadas
        if (type === 'radio') {
            selectedVariables[variableId] = [{
                option_id: optionId,
                option_name: optionName,
                price_modifier: parseFloat(priceModifier)
            }];
        }
        
        // Actualizar borde del seleccionado
        const container = labelElement.parentElement;
        container.querySelectorAll('label').forEach(label => {
            label.classList.remove('border-brandPrimary-300', 'bg-brandPrimary-50');
            label.classList.add('border-brandNeutral-50');
        });
        labelElement.classList.remove('border-brandNeutral-50');
        labelElement.classList.add('border-brandPrimary-300', 'bg-brandPrimary-50');
        
        updateTotalPrice();
    }

    function toggleCheckbox(labelElement, variableId, optionId, optionName, priceModifier) {
        const checkbox = labelElement.querySelector('input[type="checkbox"]');
        
        // Inicializar array si no existe
        if (!selectedVariables[variableId]) {
            selectedVariables[variableId] = [];
        }
        
        if (checkbox.checked) {
            // Agregar opción
            selectedVariables[variableId].push({
                option_id: optionId,
                option_name: optionName,
                price_modifier: parseFloat(priceModifier)
            });
            labelElement.classList.remove('border-brandNeutral-50');
            labelElement.classList.add('border-brandPrimary-300', 'bg-brandPrimary-50');
        } else {
            // Remover opción
            selectedVariables[variableId] = selectedVariables[variableId].filter(
                opt => opt.option_id !== optionId
            );
            labelElement.classList.remove('border-brandPrimary-300', 'bg-brandPrimary-50');
            labelElement.classList.add('border-brandNeutral-50');
        }
        
        updateTotalPrice();
    }

    function updateTotalPrice() {
        let totalPrice = basePrice;
        
        // Sumar los modificadores de precio de todas las opciones seleccionadas
        Object.values(selectedVariables).forEach(options => {
            options.forEach(option => {
                totalPrice += option.price_modifier;
            });
        });
        
        // Actualizar el precio mostrado
        const totalPriceElement = document.getElementById('total-price');
        if (totalPriceElement) {
            totalPriceElement.textContent = '$' + new Intl.NumberFormat('es-CO', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(totalPrice);
        }
    }

    function addVariableProductToCart() {
        // Validar que se hayan seleccionado todas las variables requeridas
        const requiredVariables = document.querySelectorAll('#product-variables input[required]:not([type="radio"]):not([type="checkbox"])');
        let allValid = true;
        let missingFieldsMessage = '';
        
        requiredVariables.forEach(input => {
            if (!input.value) {
                allValid = false;
                input.classList.add('border-brandError-300');
            } else {
                input.classList.remove('border-brandError-300');
            }
        });
        
        // Validar radio buttons requeridos (variables de tipo selection)
        const requiredRadios = document.querySelectorAll('#product-variables input[type="radio"][required]');
        const radioGroups = {};
        requiredRadios.forEach(radio => {
            const name = radio.name;
            if (!radioGroups[name]) {
                radioGroups[name] = [];
            }
            radioGroups[name].push(radio);
        });
        
        Object.values(radioGroups).forEach(group => {
            const isChecked = group.some(radio => radio.checked);
            if (!isChecked) {
                allValid = false;
            }
        });
        
        // Validar que haya al menos una opción seleccionada si la variable es requerida
        const variableContainers = document.querySelectorAll('#product-variables [data-variable-required="true"]');
        variableContainers.forEach(container => {
            const variableId = container.dataset.variableId;
            const hasSelection = selectedVariables[variableId] && selectedVariables[variableId].length > 0;
            
            if (!hasSelection) {
                allValid = false;
                const variableName = container.dataset.variableName || 'Variable';
                missingFieldsMessage = `Debes escoger al menos una opción para: ${variableName}`;
            }
        });
        
        if (!allValid) {
            // Mostrar alerta bonita estilo carrito
            showVariableAlert(missingFieldsMessage || 'Debes escoger una opción');
            return;
        }
        
        // Recopilar datos de variables seleccionadas
        const variants = selectedVariables;
        
        // Recopilar valores de text y numeric
        const textInputs = document.querySelectorAll('#product-variables input[type="text"], #product-variables input[type="number"]');
        textInputs.forEach(input => {
            const variableId = input.dataset.variableId;
            if (input.value) {
                variants[variableId] = [{
                    value: input.value,
                    type: input.type
                }];
            }
        });
        
        // Calcular precio total
        let totalPrice = basePrice;
        Object.values(selectedVariables).forEach(options => {
            options.forEach(option => {
                if (option.price_modifier) {
                    totalPrice += option.price_modifier;
                }
            });
        });
        
        // Agregar al carrito
        if (window.cart) {
            window.cart.addProduct({
                id: {{ $product->id }},
                name: {!! json_encode($product->name) !!},
                price: totalPrice,
                image: {!! json_encode($product->main_image_url) !!},
                variants: variants
            });
        } else {
            console.error('Cart not initialized');
        }
    }

    // Función para mostrar alerta bonita (mismo estilo que "producto agregado")
    function showVariableAlert(message) {
        const notification = document.createElement('div');
        notification.className = 'fixed top-6 left-1/2 transform -translate-x-1/2 bg-brandWarning-50 px-6 py-4 rounded-2xl shadow-2xl z-[9999] transition-all duration-500 -translate-y-32 opacity-0 min-w-[340px]';
        notification.innerHTML = `
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-10 h-10 text-brandNeutral-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"></path>
                    </svg>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="body-lg-bold text-brandNeutral-400">${message}</span>
                </div>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animar entrada
        setTimeout(() => {
            notification.classList.remove('-translate-y-32', 'opacity-0');
        }, 100);
        
        // Animar salida y eliminar
        setTimeout(() => {
            notification.classList.add('-translate-y-32', 'opacity-0');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 2500);
    }

    // Calcular precio inicial si hay opciones preseleccionadas
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar variables seleccionadas con las opciones marcadas por defecto
        const checkedRadios = document.querySelectorAll('#product-variables input[type="radio"]:checked');
        checkedRadios.forEach(radio => {
            const variableId = radio.dataset.variableId;
            const optionId = parseInt(radio.dataset.optionId);
            const priceModifier = parseFloat(radio.dataset.priceModifier);
            const optionName = radio.value;
            
            selectedVariables[variableId] = [{
                option_id: optionId,
                option_name: optionName,
                price_modifier: priceModifier
            }];
            
            // Marcar visualmente como seleccionado
            radio.closest('label').classList.add('border-brandPrimary-300', 'bg-brandPrimary-50');
        });
        
        updateTotalPrice();
    });
</script>
@endpush
@endsection
