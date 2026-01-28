@extends('shared::layouts.admin')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Nueva Transacción')

@section('content')
<div class="max-w-2xl mx-auto mt-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h1 class="text-lg font-semibold text-gray-800 mb-6">Nueva Transacción</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-start">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 mt-0.5 mr-2"></i>
                    <div>
                        <h3 class="text-sm font-medium text-red-800 mb-2">Por favor corrige los siguientes errores:</h3>
                        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('superlinkiu.personal-finance.transactions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo *</label>
                    <select name="type" required id="transaction_type"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Selecciona un tipo</option>
                        <option value="income" {{ old('type') === 'income' ? 'selected' : '' }}>Ingreso</option>
                        <option value="expense" {{ old('type') === 'expense' ? 'selected' : '' }}>Gasto</option>
                    </select>
                    @error('type')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cuenta *</label>
                    <select name="account_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Selecciona una cuenta</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>{{ $account->name }} - Saldo: ${{ number_format($account->current_balance, 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                    @error('account_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Categoría *</label>
                    <input type="text" name="category" value="{{ old('category') }}" required list="categories"
                        placeholder="Ej: Salario, Alimentación, Transporte, etc."
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
                    @error('category')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Monto *</label>
                    <input type="number" name="amount" value="{{ old('amount') }}" required step="0.01" min="0"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('amount')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="description" rows="2" placeholder="Descripción opcional..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha *</label>
                    <input type="date" name="transaction_date" value="{{ old('transaction_date', now()->format('Y-m-d')) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('transaction_date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Método de Pago *</label>
                    <select name="payment_method" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="transfer" {{ old('payment_method') === 'transfer' ? 'selected' : '' }}>Transferencia</option>
                        <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Efectivo</option>
                        <option value="account_bank" {{ old('payment_method') === 'account_bank' ? 'selected' : '' }}>Cuenta Bancaria</option>
                        <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>Tarjeta</option>
                        <option value="nequi" {{ old('payment_method') === 'nequi' ? 'selected' : '' }}>Nequi</option>
                        <option value="daviplata" {{ old('payment_method') === 'daviplata' ? 'selected' : '' }}>Daviplata</option>
                        <option value="other" {{ old('payment_method') === 'other' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Soporte (Opcional)</label>
                    <input type="file" name="receipt_file" accept="image/*,.pdf"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Formatos permitidos: JPG, PNG, PDF (máx. 5MB)</p>
                    @error('receipt_file')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tags (separados por comas)</label>
                    <input type="text" name="tags" value="{{ old('tags') }}"
                        placeholder="Ej: trabajo, urgente, mensual"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Opcional: Etiquetas para organizar tus transacciones</p>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    Guardar Transacción
                </button>
                <a href="{{ route('superlinkiu.personal-finance.transactions.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition-colors">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
