@extends('shared::layouts.admin')

@section('title', 'Detalle de Transacción Epayco')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 mt-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Detalle de Transacción</h1>
            <p class="text-sm text-gray-600 mt-1">Información completa de la transacción #{{ $transaction->id }}</p>
        </div>
        <a href="{{ route('superlinkiu.integrations.payment-gateways.epayco.transactions') }}" 
           class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors flex items-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Volver
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        {{-- Información General --}}
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-base font-semibold text-gray-900">Información General</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">ID de Transacción</label>
                    <p class="text-sm text-gray-900 font-mono">#{{ $transaction->id }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Referencia</label>
                    <p class="text-sm text-gray-900 font-mono">{{ $transaction->reference }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Monto</label>
                    <p class="text-sm text-gray-900 font-semibold">${{ number_format($transaction->amount, 0, ',', '.') }} {{ $transaction->currency }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Estado</label>
                    @php
                        $statusColors = [
                            'approved' => 'bg-green-100 text-green-800',
                            'rejected' => 'bg-red-100 text-red-800',
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'processing' => 'bg-blue-100 text-blue-800',
                            'cancelled' => 'bg-gray-100 text-gray-800',
                        ];
                        $statusLabels = [
                            'approved' => 'Aprobado',
                            'rejected' => 'Rechazado',
                            'pending' => 'Pendiente',
                            'processing' => 'Procesando',
                            'cancelled' => 'Cancelado',
                        ];
                    @endphp
                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$transaction->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $statusLabels[$transaction->status] ?? $transaction->status }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Fecha de Creación</label>
                    <p class="text-sm text-gray-900">{{ $transaction->created_at->format('d/m/Y H:i:s') }}</p>
                </div>
                @if($transaction->processed_at)
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Fecha de Procesamiento</label>
                    <p class="text-sm text-gray-900">{{ $transaction->processed_at->format('d/m/Y H:i:s') }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Datos de Request --}}
        @if($transaction->request_data)
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <h2 class="text-base font-semibold text-gray-900">Datos Enviados a Epayco</h2>
        </div>
        <div class="p-6">
            <pre class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-xs overflow-x-auto">{{ json_encode($transaction->request_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
        @endif

        {{-- Datos de Response --}}
        @if($transaction->response_data)
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <h2 class="text-base font-semibold text-gray-900">Respuesta de Epayco</h2>
        </div>
        <div class="p-6">
            <pre class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-xs overflow-x-auto">{{ json_encode($transaction->response_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
        @endif

        {{-- Mensaje de Error --}}
        @if($transaction->error_message)
        <div class="px-6 py-4 border-t border-gray-200 bg-red-50">
            <h2 class="text-base font-semibold text-red-900">Mensaje de Error</h2>
        </div>
        <div class="p-6">
            <p class="text-sm text-red-800">{{ $transaction->error_message }}</p>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.lucide) {
            lucide.createIcons();
        }
    });
</script>
@endpush
@endsection

