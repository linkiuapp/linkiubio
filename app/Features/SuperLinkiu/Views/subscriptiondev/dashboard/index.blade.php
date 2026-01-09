@extends('shared::layouts.admin')

@section('title', 'SubscriptionDev - Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Dashboard de Suscripciones</h1>
            <p class="text-sm text-gray-600 mt-1">Gestiona tus suscripciones de dominios, hosting y más</p>
        </div>
        <a href="{{ route('superlinkiu.subscriptiondev.subscriptions.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Nueva Suscripción
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Clientes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_clients']) }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="users" class="w-5 h-5 text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Activas</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($stats['active_subscriptions']) }}</p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pendientes</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ number_format($stats['pending_payments']) }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="clock" class="w-5 h-5 text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Vencidas</p>
                    <p class="text-2xl font-bold text-red-600">{{ number_format($stats['expired']) }}</p>
                </div>
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Revenue Card --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-sm p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100">Ingresos mensuales estimados</p>
                <p class="text-3xl font-bold mt-1">${{ number_format($stats['total_monthly_revenue'], 0, ',', '.') }} COP</p>
                <p class="text-sm text-blue-200 mt-2">
                    Recaudado este mes: ${{ number_format($stats['payments_this_month'], 0, ',', '.') }} COP
                </p>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center">
                <i data-lucide="trending-up" class="w-8 h-8"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Próximas a vencer --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="calendar-clock" class="w-4 h-4 text-yellow-500"></i>
                    Próximas a vencer (7 días)
                </h3>
                <a href="{{ route('superlinkiu.subscriptiondev.subscriptions.index', ['status' => 'active']) }}" class="text-sm text-blue-600 hover:underline">
                    Ver todas
                </a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($dueSoon as $sub)
                    <div class="p-4 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $sub->service_name }}</p>
                                <p class="text-sm text-gray-500">{{ $sub->client->name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-yellow-600">
                                    {{ $sub->days_until_due }} días
                                </p>
                                <p class="text-xs text-gray-500">{{ $sub->next_billing_date->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-gray-500">
                        <p>No hay suscripciones próximas a vencer</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Vencidas --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="alert-triangle" class="w-4 h-4 text-red-500"></i>
                    Suscripciones Vencidas
                </h3>
                <a href="{{ route('superlinkiu.subscriptiondev.subscriptions.index', ['status' => 'expired']) }}" class="text-sm text-blue-600 hover:underline">
                    Ver todas
                </a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($overdue as $sub)
                    <div class="p-4 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $sub->service_name }}</p>
                                <p class="text-sm text-gray-500">{{ $sub->client->name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-red-600">
                                    {{ $sub->formatted_amount }}
                                </p>
                                <p class="text-xs text-gray-500">Venció: {{ $sub->next_billing_date->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-gray-500">
                        <p>No hay suscripciones vencidas 🎉</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Últimos pagos --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
            <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                <i data-lucide="credit-card" class="w-4 h-4 text-green-500"></i>
                Últimos Pagos
            </h3>
            <a href="{{ route('superlinkiu.subscriptiondev.payments.index') }}" class="text-sm text-blue-600 hover:underline">
                Ver todos
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Servicio</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monto</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentPayments as $payment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $payment->subscription->client->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $payment->subscription->service_name }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-green-600">{{ $payment->formatted_amount }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $payment->paid_at?->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                No hay pagos recientes
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
