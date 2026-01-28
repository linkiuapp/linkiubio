@extends('shared::layouts.admin')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Editar Transacción')

@section('content')
<div class="max-w-2xl mx-auto mt-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h1 class="text-lg font-semibold text-gray-800 mb-6">Editar Transacción</h1>

        <form action="{{ route('superlinkiu.personal-finance.transactions.update', $transaction) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo *</label>
                    <select name="type" required id="transaction_type"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="income" {{ old('type', $transaction->type) === 'income' ? 'selected' : '' }}>Ingreso</option>
                        <option value="expense" {{ old('type', $transaction->type) === 'expense' ? 'selected' : '' }}>Gasto</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cuenta *</label>
                    <select name="account_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" {{ old('account_id', $transaction->account_id) == $account->id ? 'selected' : '' }}>{{ $account->name }} - Saldo: ${{ number_format($account->current_balance, 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Categoría *</label>
                    <input type="text" name="category" value="{{ old('category', $transaction->category) }}" required list="categories"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <datalist id="categories">
                        <option value="Salario">
                        <option value="Freelance">
                        <option value="Alimentación">
                        <option value="Transporte">
                        <option value="Servicios">
                        <option value="Entretenimiento">
                        <option value="Salud">
                        <option value="Educación">
                        <option value="Ropa">
                        <option value="Otros">
                    </datalist>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Monto *</label>
                    <input type="number" name="amount" value="{{ old('amount', $transaction->amount) }}" required step="0.01" min="0"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="description" rows="2"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description', $transaction->description) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha *</label>
                    <input type="date" name="transaction_date" value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Método de Pago *</label>
                    <select name="payment_method" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="transfer" {{ old('payment_method', $transaction->payment_method) === 'transfer' ? 'selected' : '' }}>Transferencia</option>
                        <option value="cash" {{ old('payment_method', $transaction->payment_method) === 'cash' ? 'selected' : '' }}>Efectivo</option>
                        <option value="account_bank" {{ old('payment_method', $transaction->payment_method) === 'account_bank' ? 'selected' : '' }}>Cuenta Bancaria</option>
                        <option value="card" {{ old('payment_method', $transaction->payment_method) === 'card' ? 'selected' : '' }}>Tarjeta</option>
                        <option value="nequi" {{ old('payment_method', $transaction->payment_method) === 'nequi' ? 'selected' : '' }}>Nequi</option>
                        <option value="daviplata" {{ old('payment_method', $transaction->payment_method) === 'daviplata' ? 'selected' : '' }}>Daviplata</option>
                        <option value="other" {{ old('payment_method', $transaction->payment_method) === 'other' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Soporte (Opcional)</label>
                    @if($transaction->receipt_file)
                        <div class="mb-2">
                            <a href="{{ Storage::url($transaction->receipt_file) }}" target="_blank" 
                                class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 text-sm">
                                <i data-lucide="file-text" class="w-4 h-4"></i>
                                Ver soporte actual
                            </a>
                        </div>
                    @endif
                    <input type="file" name="receipt_file" accept="image/*,.pdf"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Formatos permitidos: JPG, PNG, PDF (máx. 5MB). Dejar vacío para mantener el actual.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tags (separados por comas)</label>
                    <input type="text" name="tags" value="{{ old('tags', is_array($transaction->tags) ? implode(', ', $transaction->tags) : '') }}"
                        placeholder="Ej: trabajo, urgente, mensual"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    Guardar Cambios
                </button>
                <a href="{{ route('superlinkiu.personal-finance.transactions.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition-colors">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
