@extends('shared::layouts.admin')

@section('title', 'Solicitudes de Pago')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Solicitudes de Pago</h1>
            <p class="text-sm text-gray-600 mt-1">Gestiona los comprobantes de pago subidos por las tiendas</p>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase">Pendientes de Verificación</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['total_pending'] }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i data-lucide="upload" class="w-6 h-6 text-yellow-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Número de factura o tienda"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tienda</label>
                <select name="store_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todas</option>
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}" {{ request('store_id') == $store->id ? 'selected' : '' }}>
                            {{ $store->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </button>
                <a href="{{ route('superlinkiu.payment-requests.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                </a>
            </div>
        </form>
    </div>

    {{-- Tabla de Solicitudes --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-base font-semibold text-gray-900">Solicitudes Pendientes</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Factura</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tienda</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Subida</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($paymentRequests as $invoice)
                        @php
                            $metadata = $invoice->metadata ?? [];
                            $uploadedAt = isset($metadata['uploaded_at']) ? \Carbon\Carbon::parse($metadata['uploaded_at']) : $invoice->created_at;
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $invoice->invoice_number }}</div>
                                <div class="text-xs text-gray-500">{{ $invoice->issue_date->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($invoice->store)
                                    <div class="text-sm text-gray-900">{{ $invoice->store->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $invoice->store->email }}</div>
                                @else
                                    <div class="text-sm text-gray-400">Sin tienda</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ $invoice->getFormattedAmount() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $uploadedAt->format('d/m/Y H:i') }}</div>
                                <div class="text-xs text-gray-500">Hace {{ $uploadedAt->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('superlinkiu.payment-requests.show', $invoice) }}" 
                                       class="text-blue-600 hover:text-blue-800" title="Ver detalles">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('superlinkiu.payment-requests.download-proof', $invoice) }}" 
                                       class="text-green-600 hover:text-green-800" title="Descargar comprobante">
                                        <i data-lucide="download" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i data-lucide="upload" class="w-12 h-12 text-gray-400 mb-3"></i>
                                    <p class="text-sm font-medium text-gray-900">No hay solicitudes de pago pendientes</p>
                                    <p class="text-xs text-gray-500 mt-1">Las solicitudes aparecerán aquí cuando las tiendas suban comprobantes de pago</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if($paymentRequests->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $paymentRequests->links() }}
            </div>
        @endif
    </div>
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

{{-- Toast de error --}}
@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.toast) {
        window.toast.error(
            '¡Ups! algo salió mal',
            '{{ session('error') }}',
            5000,
            'bottom-center'
        );
    }
});
</script>
@endif

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
