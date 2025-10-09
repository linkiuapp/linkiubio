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

    {{-- Tabs --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-4 px-6" aria-label="Tabs">
                <a href="{{ route('superlinkiu.store-requests.index', ['tab' => 'pending']) }}" 
                   class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'pending' ? 'border-primary-200 text-primary-200' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Pendientes @if($pendingCount > 0)<span class="ml-2 bg-warning-300 text-white text-xs px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>@endif
                </a>
                <a href="{{ route('superlinkiu.store-requests.index', ['tab' => 'approved']) }}" 
                   class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'approved' ? 'border-primary-200 text-primary-200' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Aprobadas
                </a>
                <a href="{{ route('superlinkiu.store-requests.index', ['tab' => 'rejected']) }}" 
                   class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'rejected' ? 'border-primary-200 text-primary-200' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Rechazadas
                </a>
            </nav>
        </div>

        {{-- Content --}}
        <div class="p-6">
            @if($stores->isEmpty())
                <div class="text-center py-12">
                    <x-solar-document-outline class="w-16 h-16 text-gray-300 mx-auto mb-4" />
                    <p class="text-gray-500 text-lg">No hay solicitudes {{ $activeTab === 'pending' ? 'pendientes' : ($activeTab === 'approved' ? 'aprobadas' : 'rechazadas') }}</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($stores as $store)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $store->name }}</h3>
                                        @if($activeTab === 'pending')
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
                                       class="btn-primary-sm">
                                        Ver Detalle
                                    </a>
                                    @if($activeTab === 'pending')
                                        <form action="{{ route('superlinkiu.store-requests.approve', $store->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn-success-sm w-full">
                                                Aprobar
                                            </button>
                                        </form>
                                        <form action="{{ route('superlinkiu.store-requests.reject', $store->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn-danger-sm w-full">
                                                Rechazar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $stores->appends(['tab' => $activeTab])->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

