@extends('shared::layouts.admin')

@section('title', 'Detalles del Plan - ' . $plan->name)

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.plans.index') }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-lg font-semibold text-gray-800">{{ $plan->name }}</h1>
                    @if($plan->is_featured)
                        <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">DESTACADO</span>
                    @endif
                    @if($plan->is_active)
                        <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">ACTIVO</span>
                    @else
                        <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">INACTIVO</span>
                    @endif
                </div>
                <p class="text-sm text-gray-600 mt-1">Detalles completos del plan de suscripción</p>
            </div>
        </div>
        <a href="{{ route('superlinkiu.plans.edit', $plan) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-lucide="edit" class="w-4 h-4"></i>
            Editar Plan
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Columna Principal --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Información Básica --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="info" class="w-5 h-5 text-blue-600"></i>
                        Información Básica
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Nombre del Plan</label>
                            <p class="text-gray-900 font-semibold">{{ $plan->name }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Versión</label>
                            <p class="text-gray-900 font-semibold">{{ $plan->version }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Orden de Visualización</label>
                            <p class="text-gray-900 font-semibold">{{ $plan->sort_order ?? 0 }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Días de Prueba</label>
                            <p class="text-gray-900 font-semibold">
                                {{ $plan->trial_days ?? 0 }} 
                                @if($plan->trial_days > 0)
                                    <span class="text-green-600 text-xs">(Activo)</span>
                                @else
                                    <span class="text-gray-500 text-xs">(Sin prueba)</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    @if($plan->description)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <label class="block text-xs font-medium text-gray-600 mb-2">Descripción</label>
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $plan->description }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Precios por Período --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="dollar-sign" class="w-5 h-5 text-green-600"></i>
                        Precios y Facturación
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                        {{-- Mensual --}}
                        <div class="relative p-3 rounded-lg border-2 border-blue-200 bg-gradient-to-br from-blue-50 to-white">
                            <div class="text-center">
                                <p class="text-xs font-medium text-gray-600 mb-1">Mensual</p>
                                <p class="text-lg font-bold text-gray-900">${{ number_format($plan->price, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">COP/mes</p>
                            </div>
                        </div>

                        {{-- Trimestral --}}
                        @php
                            $prices = $plan->prices ?? [];
                            $quarterlyPrice = $prices['quarterly'] ?? 0;
                            $quarterlyDiscount = $quarterlyPrice > 0 && $plan->price > 0 
                                ? round(100 - (($quarterlyPrice / 3) / $plan->price * 100)) 
                                : 0;
                        @endphp
                        <div class="relative p-3 rounded-lg border-2 border-purple-200 bg-gradient-to-br from-purple-50 to-white">
                            @if($quarterlyDiscount > 0)
                                <div class="absolute -top-2 -right-2 bg-purple-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                                    -{{ $quarterlyDiscount }}%
                                </div>
                            @endif
                            <div class="text-center">
                                <p class="text-xs font-medium text-gray-600 mb-1">Trimestral</p>
                                <p class="text-lg font-bold text-gray-900">${{ number_format($quarterlyPrice, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">COP/3 meses</p>
                            </div>
                        </div>

                        {{-- Semestral --}}
                        @php
                            $semesterPrice = $prices['semester'] ?? 0;
                            $semesterDiscount = $semesterPrice > 0 && $plan->price > 0 
                                ? round(100 - (($semesterPrice / 6) / $plan->price * 100)) 
                                : 0;
                        @endphp
                        <div class="relative p-3 rounded-lg border-2 border-orange-200 bg-gradient-to-br from-orange-50 to-white">
                            @if($semesterDiscount > 0)
                                <div class="absolute -top-2 -right-2 bg-orange-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                                    -{{ $semesterDiscount }}%
                                </div>
                            @endif
                            <div class="text-center">
                                <p class="text-xs font-medium text-gray-600 mb-1">Semestral</p>
                                <p class="text-lg font-bold text-gray-900">${{ number_format($semesterPrice, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">COP/6 meses</p>
                            </div>
                        </div>

                        {{-- Anual --}}
                        @php
                            $annualPrice = $prices['annual'] ?? 0;
                            $annualDiscount = $annualPrice > 0 && $plan->price > 0 
                                ? round(100 - (($annualPrice / 12) / $plan->price * 100)) 
                                : 0;
                        @endphp
                        <div class="relative p-3 rounded-lg border-2 border-green-200 bg-gradient-to-br from-green-50 to-white">
                            @if($annualDiscount > 0)
                                <div class="absolute -top-2 -right-2 bg-green-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                                    -{{ $annualDiscount }}%
                                </div>
                            @endif
                            <div class="text-center">
                                <p class="text-xs font-medium text-gray-600 mb-1">Anual</p>
                                <p class="text-lg font-bold text-gray-900">${{ number_format($annualPrice, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">COP/año</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Límites del Plan --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="sliders" class="w-5 h-5 text-purple-600"></i>
                        Límites del Plan
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-1 text-sm">
                        {{-- Productos y Catálogo --}}
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-600">Productos</span>
                            <span class="font-semibold text-gray-900">{{ number_format($plan->max_products ?? 0) }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-600">Categorías</span>
                            <span class="font-semibold text-gray-900">{{ number_format($plan->max_categories ?? 0) }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-600">Variables de producto</span>
                            <span class="font-semibold text-gray-900">{{ number_format($plan->max_variables ?? 0) }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-600">Imágenes por producto</span>
                            <span class="font-semibold text-gray-900">{{ number_format($plan->max_product_images ?? 0) }}</span>
                        </div>
                        
                        {{-- Diseño y Marketing --}}
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-600">Banners/Sliders</span>
                            <span class="font-semibold text-gray-900">{{ number_format($plan->max_slider ?? 0) }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-600">Cupones activos</span>
                            <span class="font-semibold text-gray-900">{{ number_format($plan->max_active_coupons ?? 0) }}</span>
                        </div>
                        
                        {{-- Envíos --}}
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-600">Sedes/Ubicaciones</span>
                            <span class="font-semibold text-gray-900">{{ number_format($plan->max_sedes ?? 0) }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-600">Zonas de reparto</span>
                            <span class="font-semibold text-gray-900">{{ number_format($plan->max_delivery_zones ?? 0) }}</span>
                        </div>
                        
                        {{-- Pagos --}}
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-600">Métodos de pago</span>
                            <span class="font-semibold text-gray-900">{{ number_format($plan->max_payment_methods ?? 0) }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-600">Cuentas bancarias</span>
                            <span class="font-semibold text-gray-900">{{ number_format($plan->max_bank_accounts ?? 0) }}</span>
                        </div>
                        
                        {{-- Administración --}}
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-600">Administradores</span>
                            <span class="font-semibold text-gray-900">{{ number_format($plan->max_admins ?? 0) }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-600">Tickets mensuales</span>
                            <span class="font-semibold text-gray-900">{{ number_format($plan->max_tickets_per_month ?? 0) }}</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-600">Retención pedidos</span>
                            <span class="font-semibold text-gray-900">{{ number_format($plan->order_history_months ?? 0) }} meses</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-600">Retención analíticas</span>
                            <span class="font-semibold text-gray-900">{{ number_format($plan->analytics_retention_days ?? 0) }} días</span>
                        </div>
                        
                        {{-- Límites Verticales --}}
                        @if(($plan->max_tables ?? 0) > 0)
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-600">Mesas (Restaurant)</span>
                            <span class="font-semibold text-gray-900">{{ number_format($plan->max_tables) }}</span>
                        </div>
                        @endif
                        @if(($plan->max_daily_reservations ?? 0) > 0)
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-600">Reservas diarias (Restaurant)</span>
                            <span class="font-semibold text-gray-900">{{ number_format($plan->max_daily_reservations) }}</span>
                        </div>
                        @endif
                        @if(($plan->max_rooms ?? 0) > 0)
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-600">Habitaciones (Hotel)</span>
                            <span class="font-semibold text-gray-900">{{ number_format($plan->max_rooms) }}</span>
                        </div>
                        @endif
                        @if(($plan->max_room_types ?? 0) > 0)
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-600">Tipos de habitación</span>
                            <span class="font-semibold text-gray-900">{{ number_format($plan->max_room_types) }}</span>
                        </div>
                        @endif
                        @if(($plan->max_daily_hotel_reservations ?? 0) > 0)
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-gray-600">Reservas Hotel/Día</span>
                            <span class="font-semibold text-gray-900">{{ number_format($plan->max_daily_hotel_reservations) }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Características Incluidas --}}
            @php
                $features = $plan->features_list;
                if (is_string($features)) {
                    $features = json_decode($features, true) ?: [];
                }
                $features = is_array($features) ? $features : [];
            @endphp
            @if($features && count($features) > 0)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="sparkles" class="w-5 h-5 text-yellow-600"></i>
                        Características Incluidas
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        @foreach($features as $feature)
                            <div class="flex items-start gap-2 p-2 bg-green-50 rounded border border-green-100">
                                <i data-lucide="check-circle" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                                <span class="text-sm text-gray-700">{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            
            {{-- Estado del Plan --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-3 border-b border-gray-200">
                    <h2 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="toggle-right" class="w-4 h-4 text-blue-600"></i>
                        Estado
                    </h2>
                </div>
                <div class="p-4 space-y-3">
                    <div class="flex items-center justify-between py-1.5 border-b border-gray-100">
                        <span class="text-xs text-gray-600">Activo</span>
                        @if($plan->is_active)
                            <span class="px-2 py-0.5 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Sí</span>
                        @else
                            <span class="px-2 py-0.5 text-xs font-semibold bg-red-100 text-red-800 rounded-full">No</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-gray-100">
                        <span class="text-xs text-gray-600">Público</span>
                        @if($plan->is_public)
                            <span class="px-2 py-0.5 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Sí</span>
                        @else
                            <span class="px-2 py-0.5 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">No</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-gray-100">
                        <span class="text-xs text-gray-600">Destacado</span>
                        @if($plan->is_featured)
                            <span class="px-2 py-0.5 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">Sí</span>
                        @else
                            <span class="px-2 py-0.5 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">No</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-gray-100">
                        <span class="text-xs text-gray-600">Inventario</span>
                        @if($plan->inventory_tracking)
                            <span class="px-2 py-0.5 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">✓</span>
                        @else
                            <span class="px-2 py-0.5 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">-</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between py-1.5">
                        <span class="text-xs text-gray-600">WhatsApp</span>
                        @if($plan->whatsapp_integration)
                            <span class="px-2 py-0.5 text-xs font-semibold bg-green-100 text-green-800 rounded-full">✓</span>
                        @else
                            <span class="px-2 py-0.5 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">-</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Soporte --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-3 border-b border-gray-200">
                    <h2 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="headphones" class="w-4 h-4 text-green-600"></i>
                        Soporte
                    </h2>
                </div>
                <div class="p-4 space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Nivel</label>
                        @php
                            $levelColors = [
                                'basic' => 'bg-gray-100 text-gray-800',
                                'priority' => 'bg-blue-100 text-blue-800',
                                'premium' => 'bg-purple-100 text-purple-800',
                            ];
                            $levelLabels = [
                                'basic' => 'Básico',
                                'priority' => 'Prioritario',
                                'premium' => 'Premium',
                            ];
                        @endphp
                        <span class="px-2 py-1 text-xs font-semibold {{ $levelColors[$plan->support_level ?? 'basic'] }} rounded">
                            {{ $levelLabels[$plan->support_level ?? 'basic'] }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Tiempo de Respuesta</label>
                        <p class="text-gray-900 font-semibold text-sm">{{ $plan->support_response_time ?? 24 }} hrs</p>
                    </div>
                </div>
            </div>

            {{-- Ingresos del Plan --}}
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg shadow-sm border border-green-200">
                <div class="px-6 py-3 border-b border-green-200">
                    <h2 class="text-sm font-semibold text-green-800 flex items-center gap-2">
                        <i data-lucide="dollar-sign" class="w-4 h-4 text-green-600"></i>
                        Ingresos del Plan
                    </h2>
                </div>
                <div class="p-4 space-y-3">
                    <div class="bg-white rounded-lg p-3 border border-green-100">
                        <p class="text-xs text-gray-600">MRR (Mensual Recurrente)</p>
                        <p class="text-xl font-bold text-green-600">${{ number_format($planRevenue['mrr'] ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-green-100">
                        <span class="text-xs text-gray-600">ARR Proyectado</span>
                        <span class="text-sm font-semibold text-gray-900">${{ number_format($planRevenue['arr'] ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-green-100">
                        <span class="text-xs text-gray-600">Ingresos Históricos</span>
                        <span class="text-sm font-semibold text-gray-900">${{ number_format($planRevenue['historic_revenue'] ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-green-100">
                        <span class="text-xs text-gray-600">Últimos 30 días</span>
                        <span class="text-sm font-semibold text-gray-900">${{ number_format($planRevenue['last_30_days'] ?? 0, 0, ',', '.') }}</span>
                    </div>
                    @if(($planRevenue['stores_in_trial'] ?? 0) > 0)
                    <div class="flex items-center justify-between py-1.5">
                        <span class="text-xs text-gray-600">En período de prueba</span>
                        <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">{{ $planRevenue['stores_in_trial'] }} tiendas</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Estadísticas --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-3 border-b border-gray-200">
                    <h2 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="bar-chart-2" class="w-4 h-4 text-purple-600"></i>
                        Estadísticas
                    </h2>
                </div>
                <div class="p-4 space-y-3">
                    <div class="flex items-center justify-between py-1.5 border-b border-gray-100">
                        <span class="text-xs text-gray-600">Tiendas Activas</span>
                        <span class="text-base font-bold text-gray-900">{{ $plan->stores_count ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-gray-100">
                        <span class="text-xs text-gray-600">Creado</span>
                        <span class="text-xs text-gray-900">{{ $plan->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5">
                        <span class="text-xs text-gray-600">Actualizado</span>
                        <span class="text-xs text-gray-900">{{ $plan->updated_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Inicializar iconos Lucide
document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endpush
@endsection
