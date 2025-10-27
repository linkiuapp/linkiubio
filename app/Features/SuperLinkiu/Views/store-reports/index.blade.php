@extends('shared::layouts.admin')

@section('title', 'Reportes de Tiendas')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-h5 font-bold text-black-400">Reportes de Tiendas</h1>
            <p class="text-body-small text-black-300 mt-1">Gestiona los reportes enviados por los clientes</p>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-accent-50 rounded-xl p-6 border border-accent-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-body-small text-black-300 mb-1">Total</p>
                    <p class="text-h5 font-bold text-black-400">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-info-100 rounded-full flex items-center justify-center">
                    <x-solar-document-text-outline class="w-6 h-6 text-info-300" />
                </div>
            </div>
        </div>

        <div class="bg-warning-50 rounded-xl p-6 border border-warning-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-body-small text-black-300 mb-1">Pendientes</p>
                    <p class="text-h5 font-bold text-warning-300">{{ $stats['pending'] }}</p>
                </div>
                <div class="w-12 h-12 bg-warning-100 rounded-full flex items-center justify-center">
                    <x-solar-clock-circle-outline class="w-6 h-6 text-warning-300" />
                </div>
            </div>
        </div>

        <div class="bg-info-50 rounded-xl p-6 border border-info-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-body-small text-black-300 mb-1">Revisados</p>
                    <p class="text-h5 font-bold text-info-300">{{ $stats['reviewed'] }}</p>
                </div>
                <div class="w-12 h-12 bg-info-100 rounded-full flex items-center justify-center">
                    <x-solar-eye-outline class="w-6 h-6 text-info-300" />
                </div>
            </div>
        </div>

        <div class="bg-success-50 rounded-xl p-6 border border-success-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-body-small text-black-300 mb-1">Resueltos</p>
                    <p class="text-h5 font-bold text-success-300">{{ $stats['resolved'] }}</p>
                </div>
                <div class="w-12 h-12 bg-success-100 rounded-full flex items-center justify-center">
                    <x-solar-check-circle-outline class="w-6 h-6 text-success-300" />
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-accent-50 rounded-xl p-6 border border-accent-200 mb-6">
        <form method="GET" action="{{ route('superlinkiu.store-reports.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Búsqueda -->
                <div>
                    <label class="block text-sm font-medium text-black-400 mb-2">Buscar</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Tienda, email, descripción..."
                           class="w-full px-4 py-2 rounded-lg bg-accent-100 border border-accent-200 
                                  focus:ring-2 focus:ring-primary-200 focus:border-primary-200 transition-colors">
                </div>

                <!-- Estado -->
                <div>
                    <label class="block text-sm font-medium text-black-400 mb-2">Estado</label>
                    <select name="status"
                            class="w-full px-4 py-2 rounded-lg bg-accent-100 border border-accent-200 
                                   focus:ring-2 focus:ring-primary-200 focus:border-primary-200 transition-colors">
                        <option value="">Todos los estados</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="reviewed" {{ request('status') === 'reviewed' ? 'selected' : '' }}>Revisado</option>
                        <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resuelto</option>
                    </select>
                </div>

                <!-- Tienda -->
                <div>
                    <label class="block text-sm font-medium text-black-400 mb-2">Tienda</label>
                    <select name="store_id"
                            class="w-full px-4 py-2 rounded-lg bg-accent-100 border border-accent-200 
                                   focus:ring-2 focus:ring-primary-200 focus:border-primary-200 transition-colors">
                        <option value="">Todas las tiendas</option>
                        @foreach($stores as $store)
                            <option value="{{ $store->id }}" {{ request('store_id') == $store->id ? 'selected' : '' }}>
                                {{ $store->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Motivo -->
                <div>
                    <label class="block text-sm font-medium text-black-400 mb-2">Motivo</label>
                    <select name="reason"
                            class="w-full px-4 py-2 rounded-lg bg-accent-100 border border-accent-200 
                                   focus:ring-2 focus:ring-primary-200 focus:border-primary-200 transition-colors">
                        <option value="">Todos los motivos</option>
                        <option value="producto_defectuoso" {{ request('reason') === 'producto_defectuoso' ? 'selected' : '' }}>Producto defectuoso</option>
                        <option value="envio_tardio" {{ request('reason') === 'envio_tardio' ? 'selected' : '' }}>Envío tardío</option>
                        <option value="mal_servicio" {{ request('reason') === 'mal_servicio' ? 'selected' : '' }}>Mal servicio</option>
                        <option value="cobro_incorrecto" {{ request('reason') === 'cobro_incorrecto' ? 'selected' : '' }}>Cobro incorrecto</option>
                        <option value="fraude" {{ request('reason') === 'fraude' ? 'selected' : '' }}>Posible fraude</option>
                        <option value="contenido_inapropiado" {{ request('reason') === 'contenido_inapropiado' ? 'selected' : '' }}>Contenido inapropiado</option>
                        <option value="otro" {{ request('reason') === 'otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="btn-primary px-6 py-2 rounded-lg">
                    <x-solar-magnifer-outline class="w-4 h-4 inline mr-2" />
                    Filtrar
                </button>
                <a href="{{ route('superlinkiu.store-reports.index') }}" class="btn-secondary px-6 py-2 rounded-lg">
                    Limpiar filtros
                </a>
            </div>
        </form>
    </div>

    <!-- Tabla de Reportes -->
    <div class="bg-accent-50 rounded-xl border border-accent-200 overflow-hidden">
        @if($reports->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-accent-100 border-b border-accent-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-black-400 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-black-400 uppercase tracking-wider">Tienda</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-black-400 uppercase tracking-wider">Motivo</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-black-400 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-black-400 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-black-400 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-accent-200">
                        @foreach($reports as $report)
                            <tr class="hover:bg-accent-100 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-black-400">
                                    #{{ $report->id }}
                                </td>
                                <td class="px-6 py-4 text-sm text-black-400">
                                    <a href="{{ route('superlinkiu.stores.show', $report->store_id) }}" 
                                       class="text-info-300 hover:text-info-200 font-medium">
                                        {{ $report->store->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-black-400">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($report->reason === 'fraude') bg-error-100 text-error-300
                                        @elseif($report->reason === 'producto_defectuoso') bg-warning-100 text-warning-300
                                        @elseif($report->reason === 'envio_tardio') bg-info-100 text-info-300
                                        @else bg-accent-200 text-black-400
                                        @endif">
                                        {{ $report->reason_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($report->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-warning-100 text-warning-300">
                                            <x-solar-clock-circle-outline class="w-3 h-3 mr-1" />
                                            Pendiente
                                        </span>
                                    @elseif($report->status === 'reviewed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-info-100 text-info-300">
                                            <x-solar-eye-outline class="w-3 h-3 mr-1" />
                                            Revisado
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-300">
                                            <x-solar-check-circle-outline class="w-3 h-3 mr-1" />
                                            Resuelto
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-black-300">
                                    {{ $report->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('superlinkiu.store-reports.show', $report) }}" 
                                       class="text-info-300 hover:text-info-200 font-medium">
                                        Ver detalles →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="px-6 py-4 bg-accent-50 border-t border-accent-200">
                {{ $reports->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <x-solar-document-text-outline class="w-16 h-16 mx-auto text-black-200 mb-4" />
                <p class="text-body-regular text-black-300 mb-2">No hay reportes</p>
                <p class="text-body-small text-black-200">
                    @if(request()->hasAny(['search', 'status', 'store_id', 'reason']))
                        No se encontraron reportes con los filtros aplicados
                    @else
                        Aún no hay reportes de tiendas
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#00c76f',
                timer: 3000,
                timerProgressBar: true
            });
        @endif
    });
</script>
@endpush
@endsection

