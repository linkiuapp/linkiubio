@extends('shared::layouts.admin')

@section('title', 'Registros Pendientes')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Registros Pendientes de Aprobación</h1>
            <p class="text-sm text-gray-600 mt-1">Valida y aprueba nuevos registros de tiendas</p>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase">Pendientes</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i data-lucide="clock" class="w-6 h-6 text-yellow-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase">Aprobados</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase">Rechazados</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
                </div>
                <div class="p-3 bg-red-100 rounded-lg">
                    <i data-lucide="x-circle" class="w-6 h-6 text-red-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Lista de Registros --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($registrations as $registration)
            <div class="bg-white rounded-xl shadow-sm border-2 {{ $registration->isPending() ? 'border-yellow-300' : ($registration->isApproved() ? 'border-green-300' : 'border-red-300') }} overflow-hidden">
                {{-- Header de la Card --}}
                <div class="p-5 {{ $registration->isPending() ? 'bg-yellow-50' : ($registration->isApproved() ? 'bg-green-50' : 'bg-red-50') }}">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900">{{ $registration->store_name }}</h3>
                            <p class="text-sm text-gray-600">linkiu.bio/{{ $registration->slug }}</p>
                        </div>
                        @if($registration->isPending())
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">PENDIENTE</span>
                        @elseif($registration->isApproved())
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">APROBADO</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">RECHAZADO</span>
                        @endif
                    </div>
                </div>

                {{-- Contenido --}}
                <div class="p-5 space-y-4">
                    {{-- Propietario --}}
                    <div class="flex items-start gap-3">
                        <i data-lucide="user" class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5"></i>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-900">{{ $registration->owner_name }}</p>
                            <p class="text-xs text-gray-600">{{ $registration->owner_email }}</p>
                        </div>
                    </div>

                    {{-- Negocio --}}
                    <div class="flex items-start gap-3">
                        <i data-lucide="briefcase" class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5"></i>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-900">{{ $registration->business_name }}</p>
                            <p class="text-xs text-gray-600">{{ $registration->category->name }}</p>
                        </div>
                    </div>

                    {{-- Plan y Monto --}}
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <div class="flex items-center gap-2">
                            <i data-lucide="crown" class="w-5 h-5 text-blue-600"></i>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $registration->plan->name }}</p>
                                <p class="text-xs text-gray-600">{{ $registration->getBillingPeriodLabel() }}</p>
                            </div>
                        </div>
                        <p class="text-lg font-bold text-blue-600">{{ $registration->getFormattedAmount() }}</p>
                    </div>

                    {{-- Ubicación --}}
                    <div class="flex items-start gap-3">
                        <i data-lucide="map-pin" class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5"></i>
                        <p class="text-sm text-gray-600">{{ $registration->city }}, {{ $registration->department }}</p>
                    </div>

                    {{-- Tiempo --}}
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                        <span>{{ $registration->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                {{-- Acciones --}}
                <div class="p-5 bg-gray-50 border-t border-gray-200 flex gap-3">
                    <a href="{{ route('superlinkiu.pending-registrations.show', $registration) }}" 
                       class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-center transition-colors flex items-center justify-center gap-2">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                        Ver Detalles
                    </a>
                    @if($registration->isPending())
                        <button onclick="quickApprove({{ $registration->id }})" 
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </button>
                        <button onclick="quickReject({{ $registration->id }})" 
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <i data-lucide="inbox" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                <p class="text-lg text-gray-600">No hay registros pendientes</p>
            </div>
        @endforelse
    </div>

    {{-- Paginación --}}
    @if($registrations->hasPages())
    <div class="flex justify-center mt-6">
        {{ $registrations->links() }}
    </div>
    @endif
</div>

{{-- Toast de éxito --}}
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.toast) {
        window.toast.success(
            '¡Hey! felicidades',
            '{{ session('success') }}',
            5000,
            'bottom-center'
        );
    }
});
</script>
@endif

<script>
async function quickApprove(id) {
    if (!confirm('¿Aprobar este registro y crear la tienda?')) return;
    
    try {
        const response = await fetch(`/superlinkiu/pending-registrations/${id}/approve`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            if (window.toast) {
                window.toast.success('¡Hey! felicidades', data.message, 5000, 'bottom-center');
            }
            setTimeout(() => window.location.reload(), 1500);
        } else {
            if (window.toast) {
                window.toast.error('¡Ups! algo salió mal', data.message, 5000, 'bottom-center');
            }
        }
    } catch (error) {
        if (window.toast) {
            window.toast.error('¡Ups! algo salió mal', 'Error al procesar la solicitud', 5000, 'bottom-center');
        }
    }
}

async function quickReject(id) {
    const reason = prompt('¿Por qué rechazas este registro?');
    if (!reason) return;
    
    try {
        const response = await fetch(`/superlinkiu/pending-registrations/${id}/reject`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ reason })
        });
        
        const data = await response.json();
        
        if (data.success) {
            if (window.toast) {
                window.toast.success('Registro rechazado', data.message, 5000, 'bottom-center');
            }
            setTimeout(() => window.location.reload(), 1500);
        } else {
            if (window.toast) {
                window.toast.error('¡Ups! algo salió mal', data.message, 5000, 'bottom-center');
            }
        }
    } catch (error) {
        if (window.toast) {
            window.toast.error('¡Ups! algo salió mal', 'Error al procesar la solicitud', 5000, 'bottom-center');
        }
    }
}

// Inicializar iconos Lucide
document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endsection

