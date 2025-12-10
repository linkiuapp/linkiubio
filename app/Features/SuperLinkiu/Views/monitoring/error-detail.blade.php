@extends('shared::layouts.admin')

@section('title', 'Detalle de Error')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    {{-- SECTION: Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.monitoring.errors') }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Detalle de Error</h1>
                <p class="text-sm text-gray-600 mt-1">Información completa del error</p>
            </div>
        </div>
    </div>
    {{-- End SECTION: Header --}}

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- SECTION: Contenido Principal --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- SECTION: Información del Error --}}
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900 mb-0">Información del Error</h2>
                        @php
                            $levelColors = [
                                'ERROR' => 'bg-red-100 text-red-800',
                                'WARNING' => 'bg-yellow-100 text-yellow-800',
                                'INFO' => 'bg-blue-100 text-blue-800',
                            ];
                            $color = $levelColors[$error->level] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $color }}">
                            {{ $error->level }}
                        </span>
                    </div>
                </div>
                
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Mensaje</label>
                        <p class="text-sm text-gray-900 font-medium">{{ $error->message }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Ruta</label>
                            <p class="text-sm text-gray-900">{{ $error->route ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Método</label>
                            <p class="text-sm text-gray-900">{{ $error->method ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Archivo</label>
                            <p class="text-sm text-gray-900">{{ $error->file ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Línea</label>
                            <p class="text-sm text-gray-900">{{ $error->line ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">IP Address</label>
                            <p class="text-sm text-gray-900">{{ $error->ip_address ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">User Agent</label>
                            <p class="text-sm text-gray-900 truncate">{{ $error->user_agent ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Ocurrencias</label>
                        <p class="text-sm text-gray-900">{{ $error->occurrence_count }} veces</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Primera Ocurrencia</label>
                            <p class="text-sm text-gray-900">
                                {{ $error->first_occurred_at ? $error->first_occurred_at->format('d/m/Y H:i:s') : 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Última Ocurrencia</label>
                            <p class="text-sm text-gray-900">
                                {{ $error->last_occurred_at ? $error->last_occurred_at->format('d/m/Y H:i:s') : 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End SECTION: Información del Error --}}

            {{-- SECTION: Stack Trace --}}
            @if($error->stack_trace)
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-0">Stack Trace</h2>
                </div>
                <div class="p-6">
                    <pre class="text-xs bg-gray-50 p-4 rounded-lg overflow-x-auto text-gray-700 whitespace-pre-wrap">{{ $error->stack_trace }}</pre>
                </div>
            </div>
            @endif
            {{-- End SECTION: Stack Trace --}}

            {{-- SECTION: Context --}}
            @if($error->context)
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-0">Contexto</h2>
                </div>
                <div class="p-6">
                    <pre class="text-xs bg-gray-50 p-4 rounded-lg overflow-x-auto text-gray-700">{{ json_encode($error->context, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
            @endif
            {{-- End SECTION: Context --}}

            {{-- SECTION: Request Data --}}
            @if($error->request_data)
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-0">Datos del Request</h2>
                </div>
                <div class="p-6">
                    <pre class="text-xs bg-gray-50 p-4 rounded-lg overflow-x-auto text-gray-700">{{ json_encode($error->request_data, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
            @endif
            {{-- End SECTION: Request Data --}}
        </div>
        {{-- End SECTION: Contenido Principal --}}

        {{-- SECTION: Sidebar --}}
        <div class="space-y-6">
            {{-- SECTION: Usuario y Tienda --}}
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-0">Relaciones</h2>
                </div>
                <div class="p-6 space-y-4">
                    @if($error->user)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Usuario</label>
                            <p class="text-sm text-gray-900">{{ $error->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $error->user->email }}</p>
                        </div>
                    @endif

                    @if($error->store)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Tienda</label>
                            <p class="text-sm text-gray-900">{{ $error->store->name }}</p>
                        </div>
                    @endif

                    @if(!$error->user && !$error->store)
                        <p class="text-sm text-gray-500">No hay relaciones asociadas</p>
                    @endif
                </div>
            </div>
            {{-- End SECTION: Usuario y Tienda --}}
        </div>
        {{-- End SECTION: Sidebar --}}
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});
</script>
@endpush

