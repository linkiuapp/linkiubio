@extends('shared::layouts.admin')

@section('title', 'Cuentas Bancarias')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Cuentas Bancarias</h1>
            <p class="text-sm text-gray-600 mt-1">Gestiona tus cuentas personales, tarjetas y saldos disponibles</p>
            <p class="text-xs text-gray-500 mt-1">Estas son tus cuentas personales para conocer el saldo disponible en cada una</p>
        </div>
        <a href="{{ route('superlinkiu.personal-finance.accounts.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Nueva Cuenta
        </a>
    </div>

    @if($accounts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($accounts as $account)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: {{ $account->color }}20">
                                <i data-lucide="credit-card" class="w-5 h-5" style="color: {{ $account->color }}"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $account->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $account->type_label }}</p>
                            </div>
                        </div>
                        @if(!$account->is_active)
                            <span class="px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded">Inactiva</span>
                        @endif
                    </div>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Saldo:</span>
                            <span class="font-semibold text-gray-900">${{ number_format($account->current_balance, 0, ',', '.') }}</span>
                        </div>
                        @if($account->credit_limit)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Límite:</span>
                                <span class="font-semibold text-gray-900">${{ number_format($account->credit_limit, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        @if($account->bank_name)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Banco:</span>
                                <span class="font-medium text-gray-900">{{ $account->bank_name }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('superlinkiu.personal-finance.accounts.show', $account) }}" class="flex-1 px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-lg transition-colors text-center">
                            Ver
                        </a>
                        <a href="{{ route('superlinkiu.personal-finance.accounts.edit', $account) }}" class="flex-1 px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm rounded-lg transition-colors text-center">
                            Editar
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <i data-lucide="credit-card" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No tienes cuentas registradas</h3>
            <p class="text-gray-600 mb-6">Comienza agregando tu primera cuenta bancaria o tarjeta</p>
            <a href="{{ route('superlinkiu.personal-finance.accounts.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Crear Primera Cuenta
            </a>
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
