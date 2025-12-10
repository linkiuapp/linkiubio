@extends('shared::layouts.admin')

@section('title', 'Alertas de Monitoreo')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6" x-data="alertsIndex">
    {{-- SECTION: Header Card --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Alertas de Monitoreo</h2>
                    <p class="text-sm text-gray-600">Configura alertas para recibir notificaciones sobre eventos del sistema</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('superlinkiu.monitoring.alerts.create') }}" 
                       class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                        Crear Alerta
                    </a>
                </div>
            </div>
        </div>

        {{-- SECTION: Statistics --}}
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="bell" class="w-5 h-5 text-blue-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Activas</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['active'] }}</p>
                        </div>
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Inactivas</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['inactive'] }}</p>
                        </div>
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="bell-off" class="w-5 h-5 text-gray-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Disparadas (24h)</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['recently_triggered'] }}</p>
                        </div>
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="zap" class="w-5 h-5 text-yellow-600"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End SECTION: Statistics --}}

        {{-- SECTION: Filters --}}
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <form method="GET" action="{{ route('superlinkiu.monitoring.alerts.index') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Buscar por nombre..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <div>
                    <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        <option value="">Todos los tipos</option>
                        <option value="error_rate" {{ request('type') === 'error_rate' ? 'selected' : '' }}>Tasa de Errores</option>
                        <option value="traffic_spike" {{ request('type') === 'traffic_spike' ? 'selected' : '' }}>Pico de Tráfico</option>
                        <option value="slow_response" {{ request('type') === 'slow_response' ? 'selected' : '' }}>Respuesta Lenta</option>
                        <option value="high_memory" {{ request('type') === 'high_memory' ? 'selected' : '' }}>Alto Uso de Memoria</option>
                        <option value="custom" {{ request('type') === 'custom' ? 'selected' : '' }}>Personalizado</option>
                    </select>
                </div>
                <div>
                    <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        <option value="">Todos los estados</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activas</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivas</option>
                    </select>
                </div>
                <div>
                    <select name="channel" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        <option value="">Todos los canales</option>
                        <option value="email" {{ request('channel') === 'email' ? 'selected' : '' }}>Email</option>
                        <option value="whatsapp" {{ request('channel') === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                        <option value="in_app" {{ request('channel') === 'in_app' ? 'selected' : '' }}>In-App</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Filtrar
                    </button>
                    <a href="{{ route('superlinkiu.monitoring.alerts.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>
        {{-- End SECTION: Filters --}}

        {{-- SECTION: Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Canal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Última Disparada</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($alerts as $alert)
                        <tr data-id="{{ $alert->id }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $alert->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $typeLabels = [
                                        'error_rate' => 'Tasa de Errores',
                                        'traffic_spike' => 'Pico de Tráfico',
                                        'slow_response' => 'Respuesta Lenta',
                                        'high_memory' => 'Alto Uso de Memoria',
                                        'custom' => 'Personalizado',
                                    ];
                                @endphp
                                <span class="text-sm text-gray-900">{{ $typeLabels[$alert->type] ?? $alert->type }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $channelIcons = [
                                        'email' => 'mail',
                                        'whatsapp' => 'message-circle',
                                        'in_app' => 'bell',
                                    ];
                                    $channelColors = [
                                        'email' => 'text-blue-600',
                                        'whatsapp' => 'text-green-600',
                                        'in_app' => 'text-purple-600',
                                    ];
                                @endphp
                                <div class="flex items-center gap-2">
                                    <i data-lucide="{{ $channelIcons[$alert->channel] ?? 'bell' }}" class="w-4 h-4 {{ $channelColors[$alert->channel] ?? 'text-gray-600' }}"></i>
                                    <span class="text-sm text-gray-900 capitalize">{{ $alert->channel }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($alert->is_active)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Activa
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Inactiva
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($alert->last_triggered_at)
                                    {{ \Carbon\Carbon::parse($alert->last_triggered_at)->diffForHumans() }}
                                @else
                                    <span class="text-gray-400">Nunca</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center justify-center gap-2">
                                    <x-tooltip-top text="Ver detalles">
                                        <a 
                                            href="{{ route('superlinkiu.monitoring.alerts.show', $alert->id) }}"
                                            class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                            aria-label="Ver detalles"
                                        >
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
                                    </x-tooltip-top>

                                    <x-tooltip-top text="Editar">
                                        <a 
                                            href="{{ route('superlinkiu.monitoring.alerts.edit', $alert->id) }}"
                                            class="inline-flex items-center justify-center w-8 h-8 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors"
                                            aria-label="Editar"
                                        >
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                    </x-tooltip-top>

                                    <x-tooltip-top text="{{ $alert->is_active ? 'Desactivar' : 'Activar' }}">
                                        <form method="POST" action="{{ route('superlinkiu.monitoring.alerts.toggle-status', $alert->id) }}" class="inline m-0">
                                            @csrf
                                            <button 
                                                type="submit" 
                                                class="inline-flex items-center justify-center w-8 h-8 text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors"
                                                aria-label="{{ $alert->is_active ? 'Desactivar' : 'Activar' }}"
                                            >
                                                <i data-lucide="{{ $alert->is_active ? 'bell-off' : 'bell' }}" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </x-tooltip-top>

                                    <x-tooltip-top text="Eliminar">
                                        <button 
                                            type="button"
                                            @click="deleteAlert({{ $alert->id }}, '{{ addslashes($alert->name) }}')"
                                            class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                            aria-label="Eliminar"
                                        >
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </x-tooltip-top>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                No hay alertas configuradas. <a href="{{ route('superlinkiu.monitoring.alerts.create') }}" class="text-primary-600 hover:underline">Crear una alerta</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- End SECTION: Table --}}

        {{-- SECTION: Pagination --}}
        @if($alerts->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $alerts->links() }}
            </div>
        @endif
        {{-- End SECTION: Pagination --}}
    </div>
    {{-- End SECTION: Header Card --}}

    {{-- SECTION: Delete Confirmation Modal --}}
    <div 
        x-data="deleteModalData()"
        x-on:keydown.escape.window="closeModal()"
        @delete-alert.window="openModal($event.detail.id, $event.detail.name, $event.detail.rowElement)"
    >
        <div 
            x-show="open"
            x-transition:enter="transition-opacity duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
            @click="closeModal()"
            style="display: none;"
            x-cloak
        ></div>

        <div 
            x-show="open"
            x-transition:enter="transition-opacity duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
            role="dialog"
            tabindex="-1"
            aria-labelledby="delete-modal-label"
            style="display: none;"
            x-cloak
        >
            <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                <div 
                    @click.stop
                    class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
                >
                    <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                        <h3 id="delete-modal-label" class="font-bold text-gray-800">
                            ¿Eliminar alerta?
                        </h3>
                        <button 
                            type="button" 
                            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none" 
                            aria-label="Cerrar"
                            @click="closeModal()"
                            :disabled="loading"
                        >
                            <span class="sr-only">Cerrar</span>
                            <i data-lucide="x" class="shrink-0 size-4"></i>
                        </button>
                    </div>

                    <div class="p-4 overflow-y-auto">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0">
                                <div class="size-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <i data-lucide="alert-triangle" class="size-5 text-red-600"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-800">
                                    Se eliminará la alerta <strong>"<span x-text="alertName"></span>"</strong> de forma permanente.
                                </p>
                                <p class="text-sm text-gray-600 mt-2">
                                    Esta acción no se puede deshacer.
                                </p>
                                
                                <div x-show="error" class="mt-3" x-cloak>
                                    <div class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg p-4" role="alert">
                                        <div class="flex">
                                            <div class="shrink-0">
                                                <i data-lucide="x-circle" class="shrink-0 size-4 mt-0.5"></i>
                                            </div>
                                            <div class="ms-2">
                                                <h3 class="text-sm font-medium">
                                                    Error: <span x-text="error"></span>
                                                </h3>
                                            </div>
                                            <div class="ps-3 ms-auto">
                                                <div class="-mx-1.5 -my-1.5">
                                                    <button 
                                                        type="button" 
                                                        class="inline-flex bg-red-50 rounded-lg p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:bg-red-100" 
                                                        @click="error = null"
                                                    >
                                                        <span class="sr-only">Descartar</span>
                                                        <i data-lucide="x" class="shrink-0 size-4"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200">
                        <button 
                            type="button" 
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" 
                            @click="closeModal()"
                            :disabled="loading"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="button" 
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none"
                            @click="confirmDelete()"
                            :disabled="loading"
                        >
                            <span x-show="!loading">Sí, eliminar</span>
                            <span x-show="loading" class="flex items-center gap-2">
                                <i data-lucide="loader" class="size-4 animate-spin"></i>
                                Eliminando...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End SECTION: Delete Confirmation Modal --}}
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('alertsIndex', () => ({
        deleteAlert(id, name) {
            const rowElement = document.querySelector(`tr[data-id="${id}"]`);
            window.dispatchEvent(new CustomEvent('delete-alert', {
                detail: { id, name, rowElement }
            }));
        }
    }));
});

function deleteModalData() {
    return {
        open: false,
        alertId: null,
        alertName: '',
        alertRow: null,
        loading: false,
        error: null,
        
        openModal(id, name, rowElement) {
            this.alertId = id;
            this.alertName = name;
            this.alertRow = rowElement;
            this.error = null;
            this.open = true;
        },
        
        closeModal() {
            if (!this.loading) {
                this.open = false;
                this.alertId = null;
                this.alertName = '';
                this.alertRow = null;
                this.error = null;
            }
        },
        
        async confirmDelete() {
            if (!this.alertId) return;
            
            this.loading = true;
            this.error = null;
            
            try {
                const response = await fetch('{{ route('superlinkiu.monitoring.alerts.index') }}/' + this.alertId, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    }
                });

                let data;
                try {
                    data = await response.json();
                } catch (e) {
                    throw new Error('Error al procesar la respuesta del servidor');
                }

                if (!response.ok) {
                    throw new Error(data.error || 'Error al eliminar la alerta');
                }

                if (data.error) {
                    throw new Error(data.error);
                }

                this.loading = false;
                
                const rowToDelete = this.alertRow;
                const alertName = this.alertName;
                
                this.closeModal();
                
                if (rowToDelete && rowToDelete.parentNode) {
                    rowToDelete.style.transition = 'opacity 0.3s ease-out';
                    rowToDelete.style.opacity = '0';
                    setTimeout(() => {
                        if (rowToDelete.parentNode) {
                            rowToDelete.remove();
                            
                            if (window.toast) {
                                window.toast.success(
                                    '¡Éxito!',
                                    'Alerta eliminada exitosamente',
                                    5000,
                                    'bottom-center'
                                );
                            }
                        }
                    }, 300);
                } else {
                    window.location.reload();
                }
            } catch (error) {
                this.error = error.message || 'Error al eliminar la alerta';
                this.loading = false;
            }
        }
    };
}

document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        if (window.toast) {
            window.toast.success(
                '¡Éxito!',
                '{{ session('success') }}',
                5000,
                'bottom-center'
            );
        }
    @endif

    @if(session('error'))
        if (window.toast) {
            window.toast.error(
                'Error',
                '{{ session('error') }}',
                5000,
                'bottom-center'
            );
        }
    @endif

    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});
</script>
@endpush

