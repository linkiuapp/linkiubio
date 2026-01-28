@extends('shared::layouts.admin')

@section('title', 'Finanzas Personales - Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Finanzas Personales</h1>
            <p class="text-sm text-gray-600 mt-1">Gestiona tus deudas, pagos y cuentas bancarias</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('superlinkiu.personal-finance.accounts.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Nueva Cuenta
            </a>
            <a href="{{ route('superlinkiu.personal-finance.debts.create') }}" class="px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Nueva Deuda
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Adeudado</p>
                    <p class="text-2xl font-bold text-red-600">${{ number_format($totalOwed, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-1">Suma de todas las cuotas pendientes</p>
                    @if(isset($totalOwedBreakdown) && $totalOwedBreakdown->count() > 0)
                        <details class="mt-2">
                            <summary class="text-xs text-blue-600 cursor-pointer hover:underline">Ver desglose</summary>
                            <div class="mt-2 text-xs space-y-1 bg-gray-50 p-2 rounded">
                                @foreach($totalOwedBreakdown as $breakdown)
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700">{{ $breakdown['debt_name'] }}:</span>
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold text-gray-900">${{ number_format($breakdown['pending_amount'], 0, ',', '.') }}</span>
                                            <span class="text-gray-500">({{ $breakdown['pending_installments'] }} cuota(s))</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </details>
                    @endif
                </div>
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="trending-down" class="w-5 h-5 text-red-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pagado este Mes</p>
                    <p class="text-2xl font-bold text-green-600">${{ number_format($totalPaidThisMonth, 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Próximos Vencimientos</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $upcomingDue }}</p>
                    <p class="text-xs text-gray-500 mt-1">Próximos 7 días</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="calendar" class="w-5 h-5 text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Cuotas Vencidas</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $overdueCount }}</p>
                </div>
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-orange-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Próximos Pagos --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Próximos Pagos</h2>
            <p class="text-sm text-gray-600">Cuotas que vencen en los próximos 7 días</p>
        </div>
        <div class="p-4">
            @if($upcomingPayments->count() > 0)
                <div class="space-y-3">
                    @foreach($upcomingPayments as $installment)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $installment->debt->name }}</p>
                                <p class="text-sm text-gray-600">Cuota #{{ $installment->installment_number }} - Vence: {{ $installment->due_date->format('d/m/Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900">${{ number_format($installment->amount, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">{{ $installment->due_date->diffForHumans() }}</p>
                            </div>
                            <a href="{{ route('superlinkiu.personal-finance.installments.index') }}" class="ml-4 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition-colors">
                                Pagar
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No hay pagos próximos</p>
            @endif
        </div>
    </div>

    {{-- Resumen por Cuenta --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Resumen por Cuenta</h2>
            <p class="text-sm text-gray-600 mt-1">Saldo disponible en cada cuenta</p>
        </div>
        <div class="p-4">
            @if($accountsSummary->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($accountsSummary as $account)
                        <div class="p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full" style="background-color: {{ $account->color }}"></div>
                                    <h3 class="font-semibold text-gray-900">{{ $account->name }}</h3>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">{{ $account->type_label }}</p>
                            
                            {{-- Saldo Disponible --}}
                            <div class="mb-3">
                                <p class="text-xs text-gray-500 mb-1">Saldo Disponible</p>
                                <p class="text-2xl font-bold {{ $account->current_balance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    ${{ number_format($account->current_balance, 0, ',', '.') }}
                                </p>
                            </div>
                            
                            {{-- Deudas Vinculadas (si tiene) --}}
                            @if($account->linked_debts_count > 0)
                                <div class="pt-3 border-t border-gray-200">
                                    <p class="text-xs text-gray-500 mb-1">Deudas Vinculadas</p>
                                    <p class="text-sm font-semibold text-orange-600">
                                        ${{ number_format($account->linked_debts_total, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $account->linked_debts_count }} deuda(s) activa(s)</p>
                                </div>
                            @else
                                <div class="pt-3 border-t border-gray-200">
                                    <p class="text-xs text-gray-400">Sin deudas vinculadas</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No tienes cuentas registradas. <a href="{{ route('superlinkiu.personal-finance.accounts.create') }}" class="text-blue-600 hover:underline">Crear una cuenta</a></p>
            @endif
        </div>
    </div>

    {{-- Ingresos y Gastos del Mes --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Ingresos y Gastos del Mes</h2>
                <p class="text-sm text-gray-600">Resumen financiero de {{ now()->format('F Y') }}</p>
            </div>
            <a href="{{ route('superlinkiu.personal-finance.transactions.index') }}" class="text-sm text-blue-600 hover:underline">Ver todas</a>
        </div>
        <div class="p-4">
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <p class="text-sm text-gray-600">Ingresos</p>
                    <p class="text-2xl font-bold text-green-600">${{ number_format($monthlyIncome ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="text-center p-4 bg-red-50 rounded-lg">
                    <p class="text-sm text-gray-600">Gastos</p>
                    <p class="text-2xl font-bold text-red-600">${{ number_format($monthlyExpenses ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm text-gray-600">Balance</p>
                    <p class="text-2xl font-bold {{ ($monthlyIncome ?? 0) - ($monthlyExpenses ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        ${{ number_format(($monthlyIncome ?? 0) - ($monthlyExpenses ?? 0), 0, ',', '.') }}
                    </p>
                </div>
            </div>
            @if(isset($recentTransactions) && $recentTransactions->count() > 0)
                <div class="space-y-2">
                    <p class="text-sm font-medium text-gray-700 mb-2">Transacciones Recientes</p>
                    @foreach($recentTransactions as $transaction)
                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                            <div class="flex items-center gap-3">
                                <span class="w-2 h-2 rounded-full {{ $transaction->type === 'income' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $transaction->category }}</p>
                                    <p class="text-xs text-gray-500">{{ $transaction->account->name }} - {{ $transaction->transaction_date->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <p class="text-sm font-semibold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $transaction->type === 'income' ? '+' : '-' }}${{ number_format($transaction->amount, 0, ',', '.') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Deudas Activas --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Deudas Activas</h2>
                <p class="text-sm text-gray-600">Últimas 5 deudas</p>
            </div>
            <a href="{{ route('superlinkiu.personal-finance.debts.index') }}" class="text-sm text-blue-600 hover:underline">Ver todas</a>
        </div>
        <div class="p-4">
            @if($activeDebts->count() > 0)
                <div class="space-y-3">
                    @foreach($activeDebts as $debt)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $debt->name }}</p>
                                <div class="flex items-center gap-4 mt-1">
                                    <p class="text-sm text-gray-600">Total: ${{ number_format($debt->total_amount, 0, ',', '.') }}</p>
                                    <p class="text-sm text-gray-600">{{ $debt->paid_installments }}/{{ $debt->total_installments }} cuotas</p>
                                </div>
                                <div class="mt-2">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $debt->progress_percentage }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('superlinkiu.personal-finance.debts.show', $debt) }}" class="ml-4 px-3 py-1.5 bg-gray-600 hover:bg-gray-700 text-white text-sm rounded-lg transition-colors">
                                Ver
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No tienes deudas activas. <a href="{{ route('superlinkiu.personal-finance.debts.create') }}" class="text-blue-600 hover:underline">Crear una deuda</a></p>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush
@endsection
