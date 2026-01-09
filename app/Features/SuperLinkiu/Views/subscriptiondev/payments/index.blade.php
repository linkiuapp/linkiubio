@extends('shared::layouts.admin')

@section('title', 'Pagos')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Historial de Pagos</h1>
            <p class="text-sm text-gray-600 mt-1">Todos los pagos de suscripciones</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
            <p class="text-sm text-gray-500">Total</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-2xl font-bold text-green-600">{{ $stats['paid'] }}</p>
            <p class="text-sm text-gray-500">Pagados</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
            <p class="text-sm text-gray-500">Pendientes</p>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-sm p-4 text-center text-white">
            <p class="text-2xl font-bold">${{ number_format($stats['total_collected'], 0, ',', '.') }}</p>
            <p class="text-sm opacity-90">Recaudado</p>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <form action="{{ route('superlinkiu.subscriptiondev.payments.index') }}" method="GET" class="flex flex-wrap gap-3">
            <select name="status" class="w-auto min-w-[130px] px-3 py-2.5 border border-gray-300 rounded-lg bg-white">
                <option value="">Todos los estados</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Pagado</option>
                <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Fallido</option>
            </select>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-3 py-2.5 border border-gray-300 rounded-lg" placeholder="Desde">
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-3 py-2.5 border border-gray-300 rounded-lg" placeholder="Hasta">
            <button type="submit" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg flex items-center gap-2">
                <i data-lucide="filter" class="w-4 h-4"></i>
                Filtrar
            </button>
        </form>
    </div>

    {{-- Lista --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        @if($payments->isEmpty())
            <div class="text-center py-12">
                <i data-lucide="wallet" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay pagos</h3>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Servicio</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Período</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monto</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($payments as $payment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $payment->subscription->client->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $payment->subscription->service_name }}</td>
                                <td class="px-4 py-3 text-xs text-gray-500">{{ $payment->period_range }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $payment->formatted_amount }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-full bg-{{ $payment->status_color }}-100 text-{{ $payment->status_color }}-800">
                                        {{ $payment->status_label }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">
                                    {{ $payment->paid_at?->format('d/m/Y H:i') ?? $payment->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('superlinkiu.subscriptiondev.payments.show', $payment) }}" class="text-gray-400 hover:text-gray-600" title="Ver detalles">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
                                        @if($payment->status === 'pending')
                                            <form action="{{ route('superlinkiu.subscriptiondev.payments.mark-paid', $payment) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-gray-400 hover:text-green-600" title="Marcar como pagado" onclick="return confirm('¿Marcar este pago como pagado?')">
                                                    <i data-lucide="check" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($payments->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $payments->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.toast) {
        window.toast.success('¡Listo!', '{{ session('success') }}', 5000, 'bottom-center');
    }
});
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endsection
