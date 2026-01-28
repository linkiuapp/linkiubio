@extends('shared::layouts.admin')

@section('title', 'Detalle de Cuenta')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">{{ $account->name }}</h1>
            <p class="text-sm text-gray-600 mt-1">{{ $account->type_label }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('superlinkiu.personal-finance.accounts.edit', $account) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                Editar
            </a>
            <a href="{{ route('superlinkiu.personal-finance.accounts.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition-colors">
                Volver
            </a>
        </div>
    </div>

    {{-- Información General --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <p class="text-sm text-gray-600">Saldo Actual</p>
            <p class="text-2xl font-bold text-gray-900">${{ number_format($account->current_balance, 0, ',', '.') }}</p>
        </div>
        @if($account->credit_limit)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <p class="text-sm text-gray-600">Límite de Crédito</p>
                <p class="text-2xl font-bold text-gray-900">${{ number_format($account->credit_limit, 0, ',', '.') }}</p>
            </div>
        @endif
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <p class="text-sm text-gray-600">Deudas Activas</p>
            <p class="text-2xl font-bold text-gray-900">{{ $account->debts()->where('status', 'active')->count() }}</p>
        </div>
    </div>

    {{-- Deudas Asociadas --}}
    @if($account->debts->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Deudas Asociadas</h2>
            </div>
            <div class="p-4">
                <div class="space-y-3">
                    @foreach($account->debts as $debt)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ $debt->name }}</p>
                                <p class="text-sm text-gray-600">Total: ${{ number_format($debt->total_amount, 0, ',', '.') }}</p>
                            </div>
                            <a href="{{ route('superlinkiu.personal-finance.debts.show', $debt) }}" class="px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm rounded transition-colors">
                                Ver
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
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
