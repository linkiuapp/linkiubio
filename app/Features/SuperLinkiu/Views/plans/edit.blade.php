@extends('shared::layouts.admin')

@section('title', 'Editar Plan - ' . $plan->name)

@section('content')
<div class="max-w-6xl mx-auto space-y-6 mt-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.plans.index') }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Editar Plan: {{ $plan->name }}</h1>
                <p class="text-sm text-gray-600 mt-1">Modifica la configuración del plan</p>
            </div>
        </div>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5"></i>
                <div>
                    <p class="font-medium text-red-800 mb-2">Por favor corrige los siguientes errores:</p>
                    <ul class="list-disc list-inside space-y-1 text-sm text-red-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('superlinkiu.plans.update', $plan) }}" enctype="multipart/form-data" 
          x-data="planForm()" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Sección 1: Información Básica --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                    Información Básica
                </h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nombre del Plan --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-800 mb-2">
                            Nombre del Plan <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $plan->name) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-300 @enderror"
                            placeholder="Ej: Plan Pro"
                            required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Orden de Visualización --}}
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-800 mb-2">
                            Orden de Visualización
                        </label>
                        <input 
                            type="number" 
                            id="sort_order" 
                            name="sort_order" 
                            value="{{ old('sort_order', $plan->sort_order ?? 0) }}"
                            min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="0">
                        <p class="mt-1 text-xs text-gray-600">Menor número = aparece primero</p>
                    </div>
                </div>

                {{-- Descripción --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-800 mb-2">
                        Descripción
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-300 @enderror"
                        placeholder="Describe las características principales del plan...">{{ old('description', $plan->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Sección 2: Precios y Períodos --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="dollar-sign" class="w-5 h-5 text-green-600"></i>
                    Precios y Facturación
                </h2>
            </div>
            <div class="p-6 space-y-6">
                {{-- Precio Mensual Base --}}
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-800 mb-2">
                        Precio Mensual Base <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-500">$</span>
                        <input 
                            type="number" 
                            id="price" 
                            name="price" 
                            value="{{ old('price', $plan->price) }}"
                            x-model.number="monthlyPrice"
                            min="0" 
                            step="100"
                            class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('price') border-red-300 @enderror"
                            placeholder="49900"
                            required>
                    </div>
                    <p class="mt-1 text-xs text-gray-600">Este es el precio base mensual en COP</p>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descuentos por Período --}}
                <div class="border border-blue-100 rounded-lg p-4 bg-blue-50/30">
                    <h3 class="text-sm font-semibold text-gray-800 mb-4">Descuentos por Período</h3>
                    <p class="text-xs text-gray-600 mb-4">Define el porcentaje de descuento para cada período. El precio final se calcula automáticamente.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        {{-- Trimestral --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">Trimestral (3 meses)</label>
                            <div class="flex items-center gap-2">
                                <input 
                                    type="number" 
                                    name="discounts[quarterly]"
                                    x-model.number="quarterlyDiscount"
                                    value="{{ old('discounts.quarterly', 5) }}"
                                    min="0" 
                                    max="100"
                                    step="1"
                                    class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-center"
                                    placeholder="5">
                                <span class="text-gray-600">% descuento</span>
                            </div>
                            <div class="mt-2 p-2 bg-white rounded border border-gray-200">
                                <p class="text-xs text-gray-600">Precio final:</p>
                                <p class="text-sm font-semibold text-gray-900">
                                    $<span x-text="quarterlyPrice.toLocaleString('es-CO')">0</span>
                                </p>
                                <input type="hidden" name="prices[quarterly]" :value="quarterlyPrice">
                            </div>
                        </div>

                        {{-- Semestral --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">Semestral (6 meses)</label>
                            <div class="flex items-center gap-2">
                                <input 
                                    type="number" 
                                    name="discounts[semester]"
                                    x-model.number="semesterDiscount"
                                    value="{{ old('discounts.semester', 10) }}"
                                    min="0" 
                                    max="100"
                                    step="1"
                                    class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-center"
                                    placeholder="10">
                                <span class="text-gray-600">% descuento</span>
                            </div>
                            <div class="mt-2 p-2 bg-white rounded border border-gray-200">
                                <p class="text-xs text-gray-600">Precio final:</p>
                                <p class="text-sm font-semibold text-gray-900">
                                    $<span x-text="semesterPrice.toLocaleString('es-CO')">0</span>
                                </p>
                                <input type="hidden" name="prices[semester]" :value="semesterPrice">
                            </div>
                        </div>

                        {{-- Anual --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">Anual (12 meses)</label>
                            <div class="flex items-center gap-2">
                                <input 
                                    type="number" 
                                    name="discounts[annual]"
                                    x-model.number="annualDiscount"
                                    value="{{ old('discounts.annual', 15) }}"
                                    min="0" 
                                    max="100"
                                    step="1"
                                    class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-center"
                                    placeholder="15">
                                <span class="text-gray-600">% descuento</span>
                            </div>
                            <div class="mt-2 p-2 bg-white rounded border border-gray-200">
                                <p class="text-xs text-gray-600">Precio final:</p>
                                <p class="text-sm font-semibold text-gray-900">
                                    $<span x-text="annualPrice.toLocaleString('es-CO')">0</span>
                                </p>
                                <input type="hidden" name="prices[annual]" :value="annualPrice">
                            </div>
                        </div>
                    </div>
                    
                    {{-- Hidden para precio mensual --}}
                    <input type="hidden" name="prices[monthly]" :value="monthlyPrice">
                </div>

                {{-- Días de Prueba --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="trial_days" class="block text-sm font-medium text-gray-800 mb-2">
                            Días de Prueba Gratis
                        </label>
                        <input 
                            type="number" 
                            id="trial_days" 
                            name="trial_days" 
                            value="{{ old('trial_days', $plan->trial_days ?? 0) }}"
                            min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="14">
                        <p class="mt-1 text-xs text-gray-600">0 = sin período de prueba</p>
                    </div>

                    {{-- Hidden fields --}}
                    <input type="hidden" name="currency" value="COP">
                    <input type="hidden" name="duration_in_days" value="30">
                </div>
            </div>
        </div>

        {{-- Sección 3: Límites del Plan --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="sliders" class="w-5 h-5 text-purple-600"></i>
                    Límites del Plan
                </h2>
            </div>
            <div class="p-6 space-y-8">
                
                {{-- PRODUCTOS Y CATÁLOGO --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <i data-lucide="package" class="w-4 h-4 text-gray-600"></i>
                        Productos y Catálogo
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Productos <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="max_products" value="{{ old('max_products', $plan->max_products) }}" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Categorías <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="max_categories" value="{{ old('max_categories', $plan->max_categories) }}" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Variables <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="max_variables" value="{{ old('max_variables', $plan->max_variables) }}" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <p class="mt-1 text-xs text-gray-600">Tallas, colores, etc.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Imágenes/Producto <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="max_product_images" value="{{ old('max_product_images', $plan->max_product_images) }}" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                    </div>
                </div>

                {{-- DISEÑO Y MARKETING --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <i data-lucide="palette" class="w-4 h-4 text-gray-600"></i>
                        Diseño y Mercadeo
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Banners/Sliders <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="max_slider" value="{{ old('max_slider', $plan->max_slider) }}" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Cupones Activos <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="max_active_coupons" value="{{ old('max_active_coupons', $plan->max_active_coupons) }}" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                    </div>
                </div>

                {{-- ENVÍOS Y LOGÍSTICA --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <i data-lucide="truck" class="w-4 h-4 text-gray-600"></i>
                        Envíos y Logística
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Sedes/Ubicaciones <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="max_sedes" value="{{ old('max_sedes', $plan->max_sedes) }}" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Zonas de Reparto <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="max_delivery_zones" value="{{ old('max_delivery_zones', $plan->max_delivery_zones) }}" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                    </div>
                </div>

                {{-- PAGOS --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <i data-lucide="credit-card" class="w-4 h-4 text-gray-600"></i>
                        Pagos
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Métodos de Pago <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="max_payment_methods" value="{{ old('max_payment_methods', $plan->max_payment_methods) }}" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Cuentas Bancarias <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="max_bank_accounts" value="{{ old('max_bank_accounts', $plan->max_bank_accounts) }}" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                    </div>
                </div>

                {{-- ADMINISTRACIÓN --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <i data-lucide="users" class="w-4 h-4 text-gray-600"></i>
                        Administración
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Administradores <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="max_admins" value="{{ old('max_admins', $plan->max_admins) }}" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Tickets/Mes <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="max_tickets_per_month" value="{{ old('max_tickets_per_month', $plan->max_tickets_per_month) }}" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Retención Pedidos <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="order_history_months" value="{{ old('order_history_months', $plan->order_history_months) }}" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <span class="text-sm text-gray-600">meses</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-2">
                                Retención Analíticas <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="analytics_retention_days" value="{{ old('analytics_retention_days', $plan->analytics_retention_days) }}" min="30" step="30" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <span class="text-sm text-gray-600">días</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- LÍMITES RESTAURANT (Colapsable) --}}
                <div x-data="{ open: false }" class="border border-orange-200 rounded-lg">
                    <button type="button" @click="open = !open" class="w-full px-4 py-3 bg-orange-50/50 flex items-center justify-between hover:bg-orange-50 transition-colors">
                        <div class="flex items-center gap-2">
                            <i data-lucide="utensils" class="w-4 h-4 text-orange-600"></i>
                            <h3 class="text-sm font-semibold text-gray-800">Límites Restaurant</h3>
                            <span class="text-xs text-gray-600">(Solo aplica para vertical Restaurant)</span>
                        </div>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-gray-600 transition-transform" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse class="p-4 space-y-4">
                        <p class="text-xs text-gray-600 mb-4">Límites para negocios tipo Restaurante. Usa 0 para ilimitado.</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2">
                                    Mesas del Restaurante
                                </label>
                                <input type="number" name="max_tables" value="{{ old('max_tables', $plan->max_tables ?? 0) }}" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="mt-1 text-xs text-gray-600">0 = ilimitado</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2">
                                    Reservas por Día
                                </label>
                                <input type="number" name="max_daily_reservations" value="{{ old('max_daily_reservations', $plan->max_daily_reservations ?? 0) }}" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="mt-1 text-xs text-gray-600">0 = ilimitado</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- LÍMITES HOTEL (Colapsable) --}}
                <div x-data="{ open: false }" class="border border-purple-200 rounded-lg">
                    <button type="button" @click="open = !open" class="w-full px-4 py-3 bg-purple-50/50 flex items-center justify-between hover:bg-purple-50 transition-colors">
                        <div class="flex items-center gap-2">
                            <i data-lucide="hotel" class="w-4 h-4 text-purple-600"></i>
                            <h3 class="text-sm font-semibold text-gray-800">Límites Hotel</h3>
                            <span class="text-xs text-gray-600">(Solo aplica para vertical Hotel)</span>
                        </div>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-gray-600 transition-transform" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse class="p-4 space-y-4">
                        <p class="text-xs text-gray-600 mb-4">Límites para negocios tipo Hotel. Usa 0 para ilimitado.</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2">
                                    Habitaciones
                                </label>
                                <input type="number" name="max_rooms" value="{{ old('max_rooms', $plan->max_rooms ?? 0) }}" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="mt-1 text-xs text-gray-600">0 = ilimitado</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2">
                                    Tipos de Habitación
                                </label>
                                <input type="number" name="max_room_types" value="{{ old('max_room_types', $plan->max_room_types ?? 0) }}" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="mt-1 text-xs text-gray-600">Suite, Estándar, etc.</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2">
                                    Mesas (Restaurant)
                                </label>
                                <input type="number" name="max_tables" value="{{ old('max_tables', $plan->max_tables ?? 0) }}" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" disabled x-bind:disabled="true">
                                <p class="mt-1 text-xs text-gray-600">Usa campo Restaurante</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2">
                                    Reservas Hotel/Día
                                </label>
                                <input type="number" name="max_daily_hotel_reservations" value="{{ old('max_daily_hotel_reservations', $plan->max_daily_hotel_reservations ?? 0) }}" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="mt-1 text-xs text-gray-600">0 = ilimitado</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección 4: Funcionalidades --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="toggle-right" class="w-5 h-5 text-blue-600"></i>
                    Funcionalidades
                </h2>
            </div>
            <div class="p-6 space-y-6">
                {{-- Seguimiento de Inventario --}}
                <div class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <input type="checkbox" name="inventory_tracking" value="1" {{ old('inventory_tracking', $plan->inventory_tracking) ? 'checked' : '' }} class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500" id="inventory_tracking">
                    <label for="inventory_tracking" class="flex-1 cursor-pointer">
                        <span class="block text-sm font-medium text-gray-800">Seguimiento de Inventario</span>
                        <span class="block text-xs text-gray-600">Permite usar control de stock y alertas de inventario</span>
                    </label>
                </div>

                {{-- Integración WhatsApp --}}
                <div class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <input type="checkbox" name="whatsapp_integration" value="1" {{ old('whatsapp_integration', $plan->whatsapp_integration) ? 'checked' : '' }} class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500" id="whatsapp_integration">
                    <label for="whatsapp_integration" class="flex-1 cursor-pointer">
                        <span class="block text-sm font-medium text-gray-800">Integración WhatsApp Business</span>
                        <span class="block text-xs text-gray-600">Habilita notificaciones de pedidos por WhatsApp</span>
                    </label>
                </div>

                {{-- KiuBot Asistente --}}
                <div class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <input type="checkbox" name="kiubot_enabled" value="1" {{ old('kiubot_enabled', $plan->kiubot_enabled) ? 'checked' : '' }} class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-2 focus:ring-purple-500" id="kiubot_enabled">
                    <label for="kiubot_enabled" class="flex-1 cursor-pointer">
                        <span class="block text-sm font-medium text-gray-800">KiuBot Asistente</span>
                        <span class="block text-xs text-gray-600">Habilita el asistente virtual con IA</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Sección 5: Soporte --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="headphones" class="w-5 h-5 text-green-600"></i>
                    Soporte al Cliente
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="support_level" class="block text-sm font-medium text-gray-800 mb-2">
                            Nivel de Soporte <span class="text-red-500">*</span>
                        </label>
                        <select name="support_level" id="support_level" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('support_level') border-red-300 @enderror" required>
                            <option value="basic" {{ old('support_level', $plan->support_level) == 'basic' ? 'selected' : '' }}>Básico - Correo, horario laboral</option>
                            <option value="priority" {{ old('support_level', $plan->support_level) == 'priority' ? 'selected' : '' }}>Prioritario - Correo + Chat, respuesta rápida</option>
                            <option value="premium" {{ old('support_level', $plan->support_level) == 'premium' ? 'selected' : '' }}>Premium - 24/7, atención personalizada</option>
                        </select>
                        @error('support_level')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="support_response_time" class="block text-sm font-medium text-gray-800 mb-2">
                            Tiempo de Respuesta <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <input 
                                type="number" 
                                id="support_response_time" 
                                name="support_response_time" 
                                value="{{ old('support_response_time', $plan->support_response_time) }}"
                                min="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('support_response_time') border-red-300 @enderror"
                                required>
                            <span class="text-sm text-gray-600">horas</span>
                        </div>
                        <p class="mt-1 text-xs text-gray-600">Tiempo máximo de respuesta inicial</p>
                        @error('support_response_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección 6: Características --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="sparkles" class="w-5 h-5 text-yellow-600"></i>
                    Características del Plan
                </h2>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 mb-4">Agrega las características que incluye este plan. Estas aparecerán al cliente al elegir el plan.</p>
                
                <div>
                    <div class="space-y-2 mb-4">
                        <template x-for="(feature, index) in features" :key="index">
                            <div class="flex items-center gap-2">
                                <input 
                                    type="text" 
                                    :name="`features_list[${index}]`"
                                    x-model="features[index]"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Ej: Soporte prioritario 24/7">
                                <button 
                                    type="button" 
                                    @click="features.splice(index, 1); $nextTick(() => { if (window.createIcons) window.createIcons({ icons: window.lucideIcons }); })"
                                    class="px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
                                </button>
                            </div>
                        </template>
                    </div>
                    
                    <button 
                        type="button" 
                        @click="features.push(''); $nextTick(() => { if (window.createIcons) window.createIcons({ icons: window.lucideIcons }); })"
                        class="px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg flex items-center gap-2 transition-colors text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>
                        Agregar Característica
                    </button>
                    
                    {{-- Sugerencias Rápidas --}}
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-xs text-gray-600 mb-2">Sugerencias rápidas:</p>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" @click="features.push('Mercadeo por correo electrónico')" class="text-xs px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-full transition-colors">+ Mercadeo por correo</button>
                            <button type="button" @click="features.push('Acceso completo a API')" class="text-xs px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-full transition-colors">+ Acceso a API</button>
                            <button type="button" @click="features.push('Multi-idioma')" class="text-xs px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-full transition-colors">+ Multi-idioma</button>
                            <button type="button" @click="features.push('Dominio propio')" class="text-xs px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-full transition-colors">+ Dominio propio</button>
                            <button type="button" @click="features.push('Diseño personalizado')" class="text-xs px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-full transition-colors">+ Diseño personalizado</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección 7: Opciones Avanzadas --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="settings" class="w-5 h-5 text-gray-600"></i>
                    Opciones del Plan
                </h2>
            </div>
            <div class="p-6 space-y-6">
                {{-- Permitir URL Personalizada --}}
                <div class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <input type="checkbox" name="allow_custom_slug" value="1" {{ old('allow_custom_slug', $plan->allow_custom_slug) ? 'checked' : '' }} class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500" id="allow_custom_slug">
                    <label for="allow_custom_slug" class="flex-1 cursor-pointer">
                        <span class="block text-sm font-medium text-gray-800">Permitir URL Personalizada</span>
                        <span class="block text-xs text-gray-600">El cliente puede elegir su propia URL (ej: linkiu.bio/mi-tienda)</span>
                    </label>
                </div>

                {{-- Plan Activo --}}
                <div class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }} class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500" id="is_active">
                    <label for="is_active" class="flex-1 cursor-pointer">
                        <span class="block text-sm font-medium text-gray-800">Plan Activo</span>
                        <span class="block text-xs text-gray-600">Disponible para asignación a tiendas</span>
                    </label>
                </div>

                {{-- Plan Público --}}
                <div class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <input type="checkbox" name="is_public" value="1" {{ old('is_public', $plan->is_public) ? 'checked' : '' }} class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500" id="is_public">
                    <label for="is_public" class="flex-1 cursor-pointer">
                        <span class="block text-sm font-medium text-gray-800">Visible en Página Pública</span>
                        <span class="block text-xs text-gray-600">Aparece en la página de precios para nuevos clientes</span>
                    </label>
                </div>

                {{-- Plan Destacado --}}
                <div class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $plan->is_featured) ? 'checked' : '' }} class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500" id="is_featured">
                    <label for="is_featured" class="flex-1 cursor-pointer">
                        <span class="block text-sm font-medium text-gray-800">Plan Destacado</span>
                        <span class="block text-xs text-gray-600">Aparecerá con badge "POPULAR" o "MÁS VENDIDO"</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Botones de Acción --}}
        <div class="flex items-center justify-end gap-3 py-4">
            <a href="{{ route('superlinkiu.plans.index') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i>
                Actualizar Plan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function planForm() {
    @php
        // Calcular descuentos desde precios existentes
        $prices = $plan->prices ?? [];
        $monthlyPrice = $plan->price ?? 0;
        
        $quarterlyDiscount = 5;
        if (isset($prices['quarterly']) && $monthlyPrice > 0) {
            $monthlyTotal = $monthlyPrice * 3;
            $quarterlyDiscount = $prices['quarterly'] < $monthlyTotal ? round((($monthlyTotal - $prices['quarterly']) / $monthlyTotal) * 100) : 5;
        }
        
        $semesterDiscount = 10;
        if (isset($prices['semester']) && $monthlyPrice > 0) {
            $monthlyTotal = $monthlyPrice * 6;
            $semesterDiscount = $prices['semester'] < $monthlyTotal ? round((($monthlyTotal - $prices['semester']) / $monthlyTotal) * 100) : 10;
        }
        
        $annualDiscount = 15;
        if (isset($prices['annual']) && $monthlyPrice > 0) {
            $monthlyTotal = $monthlyPrice * 12;
            $annualDiscount = $prices['annual'] < $monthlyTotal ? round((($monthlyTotal - $prices['annual']) / $monthlyTotal) * 100) : 15;
        }
    @endphp
    
    return {
        monthlyPrice: {{ old('price', $plan->price ?? 0) }},
        quarterlyDiscount: {{ old('discounts.quarterly', $quarterlyDiscount) }},
        semesterDiscount: {{ old('discounts.semester', $semesterDiscount) }},
        annualDiscount: {{ old('discounts.annual', $annualDiscount) }},
        features: @json(old('features_list', $plan->features_list ?? [])),
        
        get quarterlyPrice() {
            return Math.round(this.monthlyPrice * 3 * (1 - this.quarterlyDiscount / 100));
        },
        
        get semesterPrice() {
            return Math.round(this.monthlyPrice * 6 * (1 - this.semesterDiscount / 100));
        },
        
        get annualPrice() {
            return Math.round(this.monthlyPrice * 12 * (1 - this.annualDiscount / 100));
        }
    }
}

// Inicializar iconos al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endpush
