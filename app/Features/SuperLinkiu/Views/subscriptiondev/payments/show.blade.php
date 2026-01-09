@extends('shared::layouts.admin')

@section('title', 'Detalle de Pago')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 mt-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('superlinkiu.subscriptiondev.payments.index') }}" class="text-gray-400 hover:text-gray-600">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Detalle de Pago</h1>
            <p class="text-sm text-gray-600">{{ $payment->payment_reference ?? 'Sin referencia' }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        {{-- Header con estado --}}
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <div>
                <span class="px-3 py-1 text-sm rounded-full bg-{{ $payment->status_color }}-100 text-{{ $payment->status_color }}-800 font-medium">
                    {{ $payment->status_label }}
                </span>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $payment->formatted_amount }}</p>
        </div>

        <div class="p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Cliente</p>
                    <p class="font-medium text-gray-900">{{ $payment->subscription->client->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Servicio</p>
                    <p class="font-medium text-gray-900">{{ $payment->subscription->service_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Período de Cobro</p>
                    <p class="text-gray-900">{{ $payment->period_range }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Método de Pago</p>
                    <p class="text-gray-900">{{ $payment->payment_method_label }}</p>
                </div>
                @if($payment->paid_at)
                    <div>
                        <p class="text-sm text-gray-500">Fecha de Pago</p>
                        <p class="text-gray-900">{{ $payment->paid_at->format('d/m/Y H:i') }}</p>
                    </div>
                @endif
                @if($payment->epayco_ref)
                    <div>
                        <p class="text-sm text-gray-500">Referencia ePayco</p>
                        <p class="text-gray-900">{{ $payment->epayco_ref }}</p>
                    </div>
                @endif
            </div>

            @if($payment->notes)
                <div class="pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-500">Notas</p>
                    <p class="text-gray-700">{{ $payment->notes }}</p>
                </div>
            @endif
        </div>

        @if($payment->status === 'pending')
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3 rounded-b-lg">
                <form action="{{ route('superlinkiu.subscriptiondev.payments.cancel', $payment) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-red-600 hover:text-red-700 font-medium" onclick="return confirm('¿Cancelar este pago?')">
                        Cancelar Pago
                    </button>
                </form>
                <form action="{{ route('superlinkiu.subscriptiondev.payments.mark-paid', $payment) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium" onclick="return confirm('¿Marcar como pagado?')">
                        Marcar como Pagado
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endsection
