@extends('shared::layouts.admin')

@section('title', 'Estadísticas de Tiendas')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-lg font-bold text-gray-900">📊 Estadísticas de Tiendas</h1>
            <p class="text-sm text-gray-600 mt-1">Métricas de ventas, productos e ingresos por tienda</p>
        </div>
    </div>

    {{-- Resumen General --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Productos Creados</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($summaryStats['total_products_created']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i data-lucide="package" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Ventas Totales</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($summaryStats['total_sales']) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i data-lucide="shopping-cart" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Ingresos por Domicilios</p>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($summaryStats['total_delivery_revenue'], 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ number_format($summaryStats['total_delivery_orders']) }} pedidos</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                    <i data-lucide="truck" class="w-6 h-6 text-orange-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Ingresos Totales</p>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($summaryStats['total_revenue'], 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i data-lucide="dollar-sign" class="w-6 h-6 text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm mb-6">
        <form method="GET" action="{{ route('superlinkiu.store-statistics.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Nombre, slug o email..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activas</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivas</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspendidas</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Plan</label>
                <select name="plan_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" {{ request('plan_id') == $plan->id ? 'selected' : '' }}>
                            {{ $plan->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                <input type="date" 
                       name="date_from" 
                       value="{{ request('date_from', $dateFrom->format('Y-m-d')) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                <input type="date" 
                       name="date_to" 
                       value="{{ request('date_to', $dateTo->format('Y-m-d')) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="md:col-span-5 flex gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    Filtrar
                </button>
                <a href="{{ route('superlinkiu.store-statistics.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    {{-- Lista de Tiendas --}}
    <div class="space-y-4">
        @forelse($stores as $store)
            @php
                $stats = $storeStats[$store->id] ?? [];
            @endphp
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-6">
                    {{-- Header de la tienda --}}
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $store->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $store->slug }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    @if($store->plan)
                                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                            {{ $store->plan->name }}
                                        </span>
                                    @endif
                                    <span class="px-2 py-1 text-xs font-medium {{ $store->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} rounded-full">
                                        {{ ucfirst($store->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('superlinkiu.store-statistics.show', $store) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                            <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
                            Ver Detalle
                        </a>
                    </div>

                    {{-- Métricas --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs font-medium text-gray-600 mb-1">Productos Creados</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['products_created'] ?? 0) }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs font-medium text-gray-600 mb-1">Productos Vendidos</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['products_sold'] ?? 0) }}</p>
                            @if(isset($stats['conversion_rate']) && $stats['conversion_rate'] > 0)
                                <p class="text-xs text-gray-500 mt-1">{{ $stats['conversion_rate'] }}% conversión</p>
                            @endif
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs font-medium text-gray-600 mb-1">Ventas Totales</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_sales'] ?? 0) }}</p>
                            @if(isset($stats['average_ticket']) && $stats['average_ticket'] > 0)
                                <p class="text-xs text-gray-500 mt-1">Ticket: ${{ number_format($stats['average_ticket'], 0, ',', '.') }}</p>
                            @endif
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs font-medium text-gray-600 mb-1">Ingresos por Domicilios</p>
                            <p class="text-2xl font-bold text-gray-900">${{ number_format($stats['delivery_revenue'] ?? 0, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ number_format($stats['delivery_orders'] ?? 0) }} pedidos</p>
                        </div>
                    </div>

                    {{-- Ingresos Totales --}}
                    <div class="mt-4 bg-purple-50 rounded-lg p-4 border border-purple-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-purple-900 mb-1">
                                    💰 Ingresos Totales
                                </p>
                                <p class="text-lg font-bold text-purple-900">
                                    ${{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-purple-200 rounded-full flex items-center justify-center">
                                <i data-lucide="dollar-sign" class="w-6 h-6 text-purple-700"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-12 text-center">
                <i data-lucide="store" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                <p class="text-lg font-medium text-gray-900 mb-2">No se encontraron tiendas</p>
                <p class="text-sm text-gray-600">Intenta ajustar los filtros de búsqueda</p>
            </div>
        @endforelse
    </div>

    {{-- Paginación --}}
    <div class="mt-6">
        {{ $stores->links() }}
    </div>
</div>
@endsection
