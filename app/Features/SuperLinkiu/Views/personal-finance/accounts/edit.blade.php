@extends('shared::layouts.admin')

@section('title', 'Editar Cuenta')

@section('content')
<div class="max-w-2xl mx-auto mt-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h1 class="text-lg font-semibold text-gray-800 mb-6">Editar Cuenta</h1>

        <form action="{{ route('superlinkiu.personal-finance.accounts.update', $account) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                    <input type="text" name="name" value="{{ old('name', $account->name) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo *</label>
                    <select name="type" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="checking" {{ old('type', $account->type) === 'checking' ? 'selected' : '' }}>Cuenta Corriente</option>
                        <option value="savings" {{ old('type', $account->type) === 'savings' ? 'selected' : '' }}>Cuenta de Ahorros</option>
                        <option value="credit_card" {{ old('type', $account->type) === 'credit_card' ? 'selected' : '' }}>Tarjeta de Crédito</option>
                        <option value="loan" {{ old('type', $account->type) === 'loan' ? 'selected' : '' }}>Préstamo</option>
                        <option value="other" {{ old('type', $account->type) === 'other' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Banco</label>
                    <input type="text" name="bank_name" value="{{ old('bank_name', $account->bank_name) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Número de Cuenta</label>
                    <input type="text" name="account_number" value="{{ old('account_number', $account->account_number) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Saldo Actual</label>
                        <input type="number" name="current_balance" value="{{ old('current_balance', $account->current_balance) }}" step="0.01"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Límite de Crédito</label>
                        <input type="number" name="credit_limit" value="{{ old('credit_limit', $account->credit_limit) }}" step="0.01" min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                    <input type="color" name="color" value="{{ old('color', $account->color) }}"
                        class="w-full h-10 border border-gray-300 rounded-lg cursor-pointer">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $account->is_active) ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label class="ml-2 text-sm text-gray-700">Cuenta activa</label>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
                    <textarea name="notes" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('notes', $account->notes) }}</textarea>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    Guardar Cambios
                </button>
                <a href="{{ route('superlinkiu.personal-finance.accounts.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition-colors">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
