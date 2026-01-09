@extends('shared::layouts.admin')

@section('title', 'SubscriptionDev - Suscripciones')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Suscripciones</h1>
            <p class="text-sm text-gray-600 mt-1">Gestiona todas tus suscripciones activas</p>
        </div>
        <a href="{{ route('superlinkiu.subscriptiondev.subscriptions.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Nueva Suscripción
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
            <p class="text-sm text-gray-500">Total</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</p>
            <p class="text-sm text-gray-500">Activas</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
            <p class="text-sm text-gray-500">Pago Pendiente</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-2xl font-bold text-red-600">{{ $stats['expired'] }}</p>
            <p class="text-sm text-gray-500">Vencidas</p>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <form action="{{ route('superlinkiu.subscriptiondev.subscriptions.index') }}" method="GET" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por servicio o cliente..." class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">
            </div>
            <select name="status" class="w-auto min-w-[150px] px-3 py-2.5 border border-gray-300 rounded-lg bg-white">
                <option value="">Todos los estados</option>
                @foreach($statuses as $key => $label)
                    <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <select name="period" class="w-auto min-w-[130px] px-3 py-2.5 border border-gray-300 rounded-lg bg-white">
                <option value="">Período</option>
                @foreach($periods as $key => $label)
                    <option value="{{ $key }}" {{ request('period') === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors flex items-center gap-2">
                <i data-lucide="search" class="w-4 h-4"></i>
                Buscar
            </button>
            @if(request()->hasAny(['search', 'status', 'period']))
                <a href="{{ route('superlinkiu.subscriptiondev.subscriptions.index') }}" class="px-4 py-2.5 text-gray-600 hover:text-gray-800">Limpiar</a>
            @endif
        </form>
    </div>

    {{-- Lista --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        @if($subscriptions->isEmpty())
            <div class="text-center py-12">
                <i data-lucide="file-text" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay suscripciones</h3>
                <p class="text-sm text-gray-500 mb-4">Comienza agregando tu primera suscripción</p>
                <a href="{{ route('superlinkiu.subscriptiondev.subscriptions.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Nueva Suscripción
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Servicio</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Período</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monto</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vencimiento</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($subscriptions as $sub)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <a href="{{ route('superlinkiu.subscriptiondev.subscriptions.show', $sub) }}" class="font-medium text-gray-900 hover:text-blue-600">
                                        {{ $sub->service_name }}
                                    </a>
                                    @if($sub->serviceType)
                                        <p class="text-xs text-gray-500">{{ $sub->serviceType->name }}</p>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('superlinkiu.subscriptiondev.clients.show', $sub->client) }}" class="text-sm text-gray-900 hover:text-blue-600">
                                        {{ $sub->client->name }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $sub->period_label }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $sub->formatted_amount }}</td>
                                <td class="px-4 py-3">
                                    <span class="text-sm {{ $sub->is_overdue ? 'text-red-600 font-medium' : ($sub->is_due_soon ? 'text-yellow-600' : 'text-gray-600') }}">
                                        {{ $sub->next_billing_date->format('d/m/Y') }}
                                    </span>
                                    @if($sub->is_overdue)
                                        <p class="text-xs text-red-500">Vencido</p>
                                    @elseif($sub->days_until_due <= 7)
                                        <p class="text-xs text-yellow-500">En {{ $sub->days_until_due }} días</p>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-full bg-{{ $sub->status_color }}-100 text-{{ $sub->status_color }}-800">
                                        {{ $sub->status_label }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ $sub->public_url }}" target="_blank" class="text-gray-400 hover:text-blue-600" title="Ver link de pago">
                                            <i data-lucide="external-link" class="w-4 h-4"></i>
                                        </a>
                                        <a href="{{ route('superlinkiu.subscriptiondev.subscriptions.edit', $sub) }}" class="text-gray-400 hover:text-gray-600" title="Editar">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('superlinkiu.subscriptiondev.subscriptions.send-reminder', $sub) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-gray-400 hover:text-green-600" title="Enviar recordatorio">
                                                <i data-lucide="send" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($subscriptions->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $subscriptions->links() }}
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
