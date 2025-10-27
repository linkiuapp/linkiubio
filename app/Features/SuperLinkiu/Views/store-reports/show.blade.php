@extends('shared::layouts.admin')

@section('title', 'Detalle del Reporte #' . $report->id)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('superlinkiu.store-reports.index') }}" 
                   class="text-info-300 hover:text-info-200 flex items-center gap-1">
                    <x-solar-arrow-left-outline class="w-4 h-4" />
                    Volver a reportes
                </a>
            </div>
            <h1 class="text-h5 font-bold text-black-400">Reporte #{{ $report->id }}</h1>
            <p class="text-body-small text-black-300 mt-1">Detalle del reporte enviado</p>
        </div>

        <!-- Acciones rápidas -->
        <div class="flex items-center gap-3">
            @if($report->status === 'pending')
                <form action="{{ route('superlinkiu.store-reports.mark-reviewed', $report) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn-info px-4 py-2 rounded-lg flex items-center gap-2">
                        <x-solar-eye-outline class="w-4 h-4" />
                        Marcar como Revisado
                    </button>
                </form>
            @endif

            @if($report->status !== 'resolved')
                <form action="{{ route('superlinkiu.store-reports.mark-resolved', $report) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn-success px-4 py-2 rounded-lg flex items-center gap-2">
                        <x-solar-check-circle-outline class="w-4 h-4" />
                        Marcar como Resuelto
                    </button>
                </form>
            @endif

            <form action="{{ route('superlinkiu.store-reports.destroy', $report) }}" 
                  method="POST" 
                  onsubmit="return confirm('¿Estás seguro de eliminar este reporte?')"
                  class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-error px-4 py-2 rounded-lg flex items-center gap-2">
                    <x-solar-trash-bin-trash-outline class="w-4 h-4" />
                    Eliminar
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información del Reporte -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Detalles principales -->
            <div class="bg-accent-50 rounded-xl p-6 border border-accent-200">
                <h2 class="text-body-large font-bold text-black-400 mb-4">Información del Reporte</h2>
                
                <div class="space-y-4">
                    <!-- Motivo -->
                    <div>
                        <label class="block text-sm font-medium text-black-300 mb-1">Motivo</label>
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium
                            @if($report->reason === 'fraude') bg-error-100 text-error-300
                            @elseif($report->reason === 'producto_defectuoso') bg-warning-100 text-warning-300
                            @elseif($report->reason === 'envio_tardio') bg-info-100 text-info-300
                            @else bg-accent-200 text-black-400
                            @endif">
                            {{ $report->reason_name }}
                        </span>
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label class="block text-sm font-medium text-black-300 mb-2">Descripción del Problema</label>
                        <div class="bg-accent-100 rounded-lg p-4 text-sm text-black-400 whitespace-pre-wrap">{{ $report->description }}</div>
                    </div>

                    <!-- Email del reportante -->
                    @if($report->reporter_email)
                        <div>
                            <label class="block text-sm font-medium text-black-300 mb-1">Email de Contacto</label>
                            <a href="mailto:{{ $report->reporter_email }}" 
                               class="text-info-300 hover:text-info-200 text-sm">
                                {{ $report->reporter_email }}
                            </a>
                        </div>
                    @else
                        <div>
                            <label class="block text-sm font-medium text-black-300 mb-1">Email de Contacto</label>
                            <p class="text-sm text-black-300 italic">Reporte anónimo</p>
                        </div>
                    @endif

                    <!-- Información técnica -->
                    <div class="border-t border-accent-200 pt-4 mt-4">
                        <label class="block text-sm font-medium text-black-300 mb-2">Información Técnica</label>
                        <div class="space-y-2 text-xs text-black-300">
                            <p><span class="font-medium">IP:</span> {{ $report->reporter_ip }}</p>
                            <p><span class="font-medium">User Agent:</span> {{ $report->user_agent }}</p>
                            <p><span class="font-medium">Fecha:</span> {{ $report->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notas Administrativas -->
            <div class="bg-accent-50 rounded-xl p-6 border border-accent-200">
                <h2 class="text-body-large font-bold text-black-400 mb-4">Notas Administrativas</h2>
                
                <form action="{{ route('superlinkiu.store-reports.update-notes', $report) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <textarea name="admin_notes" 
                              rows="5"
                              class="w-full px-4 py-3 rounded-lg bg-accent-100 border border-accent-200 
                                     focus:ring-2 focus:ring-primary-200 focus:border-primary-200 transition-colors
                                     text-black-400 resize-none"
                              placeholder="Agregar notas internas sobre este reporte...">{{ old('admin_notes', $report->admin_notes) }}</textarea>
                    
                    @error('admin_notes')
                        <p class="text-caption text-error-300 mt-1">{{ $message }}</p>
                    @enderror

                    <div class="flex justify-end mt-4">
                        <button type="submit" class="btn-primary px-6 py-2 rounded-lg">
                            <x-solar-diskette-outline class="w-4 h-4 inline mr-2" />
                            Guardar Notas
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar - Información de la Tienda y Estado -->
        <div class="space-y-6">
            <!-- Estado del Reporte -->
            <div class="bg-accent-50 rounded-xl p-6 border border-accent-200">
                <h3 class="text-body-regular font-bold text-black-400 mb-4">Estado del Reporte</h3>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 rounded-lg
                        @if($report->status === 'pending') bg-warning-50 border border-warning-200
                        @elseif($report->status === 'reviewed') bg-info-50 border border-info-200
                        @else bg-success-50 border border-success-200
                        @endif">
                        <span class="text-sm font-medium
                            @if($report->status === 'pending') text-warning-300
                            @elseif($report->status === 'reviewed') text-info-300
                            @else text-success-300
                            @endif">
                            @if($report->status === 'pending')
                                <x-solar-clock-circle-outline class="w-4 h-4 inline mr-1" />
                                Pendiente
                            @elseif($report->status === 'reviewed')
                                <x-solar-eye-outline class="w-4 h-4 inline mr-1" />
                                Revisado
                            @else
                                <x-solar-check-circle-outline class="w-4 h-4 inline mr-1" />
                                Resuelto
                            @endif
                        </span>
                    </div>

                    @if($report->reviewed_at)
                        <div class="text-xs text-black-300">
                            <p><span class="font-medium">Revisado:</span> {{ $report->reviewed_at->format('d/m/Y H:i') }}</p>
                            @if($report->reviewer)
                                <p><span class="font-medium">Por:</span> {{ $report->reviewer->name }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Información de la Tienda -->
            <div class="bg-accent-50 rounded-xl p-6 border border-accent-200">
                <h3 class="text-body-regular font-bold text-black-400 mb-4">Tienda Reportada</h3>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-black-300 mb-1">Nombre</label>
                        <a href="{{ route('superlinkiu.stores.show', $report->store_id) }}" 
                           class="text-sm font-medium text-info-300 hover:text-info-200">
                            {{ $report->store->name }}
                        </a>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-black-300 mb-1">Plan</label>
                        <p class="text-sm text-black-400">{{ $report->store->plan->name ?? 'Sin plan' }}</p>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-black-300 mb-1">Estado</label>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                            @if($report->store->status === 'active') bg-success-100 text-success-300
                            @elseif($report->store->status === 'suspended') bg-error-100 text-error-300
                            @else bg-warning-100 text-warning-300
                            @endif">
                            {{ ucfirst($report->store->status) }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-black-300 mb-1">Verificada</label>
                        <span class="text-sm">
                            @if($report->store->verified)
                                <span class="text-success-300">✓ Sí</span>
                            @else
                                <span class="text-error-300">✗ No</span>
                            @endif
                        </span>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-accent-200">
                    <a href="{{ route('superlinkiu.stores.show', $report->store_id) }}" 
                       class="btn-secondary w-full flex items-center justify-center gap-2 py-2 rounded-lg text-sm">
                        <x-solar-eye-outline class="w-4 h-4" />
                        Ver Tienda Completa
                    </a>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="bg-error-50 rounded-xl p-6 border border-error-200">
                <h3 class="text-body-regular font-bold text-error-300 mb-4">Acciones de Moderación</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('superlinkiu.stores.edit', $report->store_id) }}" 
                       class="btn-warning w-full flex items-center justify-center gap-2 py-2 rounded-lg text-sm">
                        <x-solar-pen-outline class="w-4 h-4" />
                        Editar Tienda
                    </a>

                    @if($report->store->status !== 'suspended')
                        <button onclick="alert('Función de suspender tienda en desarrollo')"
                                class="btn-error w-full flex items-center justify-center gap-2 py-2 rounded-lg text-sm">
                            <x-solar-shield-warning-outline class="w-4 h-4" />
                            Suspender Tienda
                        </button>
                    @endif
                </div>
            </div>
        </div>
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

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonColor: '#ed2e45'
            });
        @endif
    });
</script>
@endpush
@endsection

