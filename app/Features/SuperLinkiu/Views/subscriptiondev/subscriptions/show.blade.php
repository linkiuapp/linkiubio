@extends('shared::layouts.admin')

@section('title', 'Suscripción - ' . $subscription->service_name)

@section('content')
<div class="max-w-5xl mx-auto space-y-6 mt-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('superlinkiu.subscriptiondev.subscriptions.index') }}" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-800">{{ $subscription->service_name }}</h1>
                <p class="text-sm text-gray-600">{{ $subscription->client->name }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ $subscription->public_url }}" target="_blank" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                Link de Pago
            </a>
            <a href="{{ route('superlinkiu.subscriptiondev.subscriptions.edit', $subscription) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-lucide="pencil" class="w-4 h-4"></i>
                Editar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Info Principal --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Detalles --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Detalles de la Suscripción</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Servicio</p>
                        <p class="font-medium text-gray-900">{{ $subscription->service_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Estado</p>
                        <span class="px-2 py-1 text-sm rounded-full bg-{{ $subscription->status_color }}-100 text-{{ $subscription->status_color }}-800">
                            {{ $subscription->status_label }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Monto</p>
                        <p class="font-medium text-gray-900">{{ $subscription->formatted_amount }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Período</p>
                        <p class="font-medium text-gray-900">{{ $subscription->period_label }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Fecha de Inicio</p>
                        <p class="font-medium text-gray-900">{{ $subscription->start_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Próximo Cobro</p>
                        <p class="font-medium {{ $subscription->is_overdue ? 'text-red-600' : ($subscription->is_due_soon ? 'text-yellow-600' : 'text-gray-900') }}">
                            {{ $subscription->next_billing_date->format('d/m/Y') }}
                            @if($subscription->is_overdue)
                                <span class="text-sm">(Vencido)</span>
                            @elseif($subscription->days_until_due <= 7)
                                <span class="text-sm">(En {{ $subscription->days_until_due }} días)</span>
                            @endif
                        </p>
                    </div>
                </div>

                @if($subscription->description)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-500">Descripción</p>
                        <p class="text-gray-700">{{ $subscription->description }}</p>
                    </div>
                @endif
            </div>

            {{-- Historial de Pagos --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900">Historial de Pagos</h3>
                    <form action="{{ route('superlinkiu.subscriptiondev.subscriptions.generate-payment', $subscription) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-sm text-blue-600 hover:underline">+ Generar pago</button>
                    </form>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($subscription->payments as $payment)
                        <div class="p-4 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $payment->formatted_amount }}</p>
                                    <p class="text-sm text-gray-500">{{ $payment->period_range }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="px-2 py-1 text-xs rounded-full bg-{{ $payment->status_color }}-100 text-{{ $payment->status_color }}-800">
                                        {{ $payment->status_label }}
                                    </span>
                                    @if($payment->paid_at)
                                        <p class="text-xs text-gray-500 mt-1">{{ $payment->paid_at->format('d/m/Y H:i') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-gray-500">
                            No hay pagos registrados
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Cliente --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Cliente</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Nombre</p>
                        <a href="{{ route('superlinkiu.subscriptiondev.clients.show', $subscription->client) }}" class="font-medium text-blue-600 hover:underline">
                            {{ $subscription->client->name }}
                        </a>
                    </div>
                    @if($subscription->client->email)
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="text-gray-900">{{ $subscription->client->email }}</p>
                        </div>
                    @endif
                    @if($subscription->client->phone)
                        <div>
                            <p class="text-sm text-gray-500">Teléfono</p>
                            <p class="text-gray-900">{{ $subscription->client->country_code }} {{ $subscription->client->phone }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Acciones --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Acciones</h3>
                <div class="space-y-3">
                    <form action="{{ route('superlinkiu.subscriptiondev.subscriptions.send-reminder', $subscription) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                            <i data-lucide="send" class="w-4 h-4"></i>
                            Enviar Recordatorio
                        </button>
                    </form>

                    @if($subscription->status !== 'active')
                        <form action="{{ route('superlinkiu.subscriptiondev.subscriptions.renew', $subscription) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                Renovar Manualmente
                            </button>
                        </form>
                    @endif

                    <button type="button" onclick="copyToClipboard('{{ $subscription->public_url }}')" class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                        <i data-lucide="copy" class="w-4 h-4"></i>
                        Copiar Link de Pago
                    </button>
                </div>
            </div>

            {{-- Recordatorios --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Últimos Recordatorios</h3>
                <div class="space-y-2">
                    @forelse($subscription->reminders as $reminder)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">{{ $reminder->type_label }}</span>
                            <span class="px-2 py-0.5 rounded-full bg-{{ $reminder->status_color }}-100 text-{{ $reminder->status_color }}-800 text-xs">
                                {{ $reminder->status_label }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No hay recordatorios enviados</p>
                    @endforelse
                </div>
            </div>
        </div>
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
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        if (window.toast) {
            window.toast.success('¡Copiado!', 'Link copiado al portapapeles', 3000, 'bottom-center');
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endsection
