@extends('shared::layouts.admin')

@section('title', 'Solicitudes de Tiendas')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Solicitudes de Tiendas</h1>
        <p class="text-sm text-gray-600 mt-1">Gestiona las solicitudes de creación de tiendas pendientes, aprobadas y rechazadas</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-warning-50 border border-warning-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-warning-600 uppercase">Pendientes</p>
                    <p class="text-2xl font-bold text-warning-700">{{ $pendingCount }}</p>
                </div>
                <x-solar-clock-circle-outline class="w-10 h-10 text-warning-400" />
            </div>
        </div>
        <div class="bg-success-50 border border-success-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-success-600 uppercase">Aprobadas</p>
                    <p class="text-2xl font-bold text-success-700">{{ $approvedCount }}</p>
                </div>
                <x-solar-check-circle-outline class="w-10 h-10 text-success-400" />
            </div>
        </div>
        <div class="bg-danger-50 border border-danger-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-danger-600 uppercase">Rechazadas</p>
                    <p class="text-2xl font-bold text-danger-700">{{ $rejectedCount }}</p>
                </div>
                <x-solar-close-circle-outline class="w-10 h-10 text-danger-400" />
            </div>
        </div>
    </div>

    {{-- Filtros y Búsqueda --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <form method="GET" action="{{ route('superlinkiu.store-requests.index') }}" class="space-y-4">
            <input type="hidden" name="tab" value="{{ $tab }}">
            
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Filtros y Búsqueda</h3>
                @if(request()->has('search') || request()->has('category') || request()->has('urgency') || request()->has('date_from') || request()->has('date_to'))
                <a href="{{ route('superlinkiu.store-requests.index', ['tab' => $tab]) }}" 
                   class="text-sm text-primary-200 hover:text-primary-300 flex items-center gap-1">
                    <x-solar-refresh-outline class="w-4 h-4" />
                    Limpiar Filtros
                </a>
                @endif
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Búsqueda --}}
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Buscar
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Nombre, documento, email..."
                               class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-200">
                        <x-solar-magnifer-outline class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" />
                    </div>
                </div>
                
                {{-- Filtro por Categoría --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Categoría
                    </label>
                    <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-200">
                        <option value="">Todas</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Filtro por Urgencia (solo para pending) --}}
                @if($tab === 'pending')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Urgencia
                    </label>
                    <select name="urgency" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-200">
                        <option value="">Todas</option>
                        <option value="critical" {{ request('urgency') === 'critical' ? 'selected' : '' }}>
                            Críticas (>24h)
                        </option>
                        <option value="urgent" {{ request('urgency') === 'urgent' ? 'selected' : '' }}>
                            Urgentes (6-24h)
                        </option>
                        <option value="normal" {{ request('urgency') === 'normal' ? 'selected' : '' }}>
                            Normales (<6h)
                        </option>
                    </select>
                </div>
                @endif
            </div>
            
            {{-- Filtros de Fecha --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Desde
                    </label>
                    <input type="date" 
                           name="date_from" 
                           value="{{ request('date_from') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-200">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Hasta
                    </label>
                    <input type="date" 
                           name="date_to" 
                           value="{{ request('date_to') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-200">
                </div>
            </div>
            
            {{-- Botón de aplicar filtros --}}
            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="btn-primary px-6 py-2 rounded-lg flex items-center gap-2">
                    <x-solar-filter-outline class="w-4 h-4" />
                    Aplicar Filtros
                </button>
                
                @if(request()->has('search') || request()->has('category') || request()->has('urgency') || request()->has('date_from') || request()->has('date_to'))
                <span class="text-sm text-gray-600">
                    {{ $stores->total() }} resultado(s) encontrado(s)
                </span>
                @endif
            </div>
        </form>
    </div>

    {{-- Tabs --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-4 px-6" aria-label="Tabs">
                <a href="{{ route('superlinkiu.store-requests.index', ['tab' => 'pending']) }}" 
                   class="py-4 px-1 border-b-2 font-medium text-sm {{ $tab === 'pending' ? 'border-primary-200 text-primary-200' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Pendientes @if($pendingCount > 0)<span class="ml-2 bg-warning-300 text-white text-xs px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>@endif
                </a>
                <a href="{{ route('superlinkiu.store-requests.index', ['tab' => 'approved']) }}" 
                   class="py-4 px-1 border-b-2 font-medium text-sm {{ $tab === 'approved' ? 'border-primary-200 text-primary-200' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Aprobadas
                </a>
                <a href="{{ route('superlinkiu.store-requests.index', ['tab' => 'rejected']) }}" 
                   class="py-4 px-1 border-b-2 font-medium text-sm {{ $tab === 'rejected' ? 'border-primary-200 text-primary-200' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Rechazadas
                </a>
            </nav>
        </div>

        {{-- Content --}}
        <div class="p-6">
            @if($stores->isEmpty())
                <div class="text-center py-12">
                    <x-solar-document-outline class="w-16 h-16 text-gray-300 mx-auto mb-4" />
                    <p class="text-gray-500 text-lg">No hay solicitudes {{ $tab === 'pending' ? 'pendientes' : ($tab === 'approved' ? 'aprobadas' : 'rechazadas') }}</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($stores as $store)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $store->name }}</h3>
                                        @if($tab === 'pending')
                                            @php
                                                $hoursElapsed = $store->created_at->diffInHours(now());
                                                $urgencyClass = $hoursElapsed > 24 ? 'bg-danger-100 text-danger-700' : ($hoursElapsed > 6 ? 'bg-warning-100 text-warning-700' : 'bg-info-100 text-info-700');
                                            @endphp
                                            <span class="{{ $urgencyClass }} text-xs font-medium px-2 py-1 rounded">
                                                {{ $store->created_at->diffForHumans() }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-500">Categoría</p>
                                            <p class="font-medium">{{ $store->businessCategory->name ?? $store->business_type ?? 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Documento</p>
                                            <p class="font-medium">{{ $store->business_document_type }} {{ $store->business_document_number }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Admin</p>
                                            <p class="font-medium">{{ $store->admins->first()->name ?? 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Email</p>
                                            <p class="font-medium text-xs">{{ $store->admins->first()->email ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-4 flex flex-col gap-2">
                                    <a href="{{ route('superlinkiu.store-requests.show', $store->id) }}" 
                                       class="px-4 py-2 bg-primary-200 text-white rounded-lg hover:bg-primary-300 transition-colors text-center text-sm font-medium">
                                        Ver Detalle
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $stores->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

