@extends('shared::layouts.admin')

@section('title', 'Editar Deuda')

@section('content')
<div class="max-w-2xl mx-auto mt-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h1 class="text-lg font-semibold text-gray-800 mb-6">Editar Deuda</h1>

        <form action="{{ route('superlinkiu.personal-finance.debts.update', $debt) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Deuda *</label>
                    <input type="text" name="name" value="{{ old('name', $debt->name) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cuenta Asociada</label>
                    <select name="account_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Sin cuenta asociada</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" {{ old('account_id', $debt->account_id) == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="description" rows="2"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description', $debt->description) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Monto Total de la Deuda</label>
                        <input type="number" name="total_amount" id="total_amount" value="{{ old('total_amount', $debt->total_amount) }}" step="0.01" min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Se calculará automáticamente si especificas el monto de la cuota</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tasa de Interés (%)</label>
                        <input type="number" name="interest_rate" value="{{ old('interest_rate', $debt->interest_rate) }}" step="0.01" min="0" max="100"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Dejar en blanco si no aplica</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Monto de la Cuota</label>
                        <input type="number" name="installment_amount" id="installment_amount" value="{{ old('installment_amount', $debt->installment_amount) }}" step="0.01" min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Si especificas este valor, el monto total se calculará automáticamente</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Vas a Pagar en Total</label>
                        <input type="text" id="total_to_pay" readonly value="{{ number_format($debt->total_amount, 0, ',', '.') }}"
                            class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-lg font-semibold text-gray-800">
                        <p class="text-xs text-gray-500 mt-1">Se calcula automáticamente: Monto de Cuota × Número de Cuotas</p>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <input type="checkbox" name="interest_included" value="1" id="interest_included" {{ old('interest_included', $debt->interest_included) ? 'checked' : '' }}
                            class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="interest_included" class="ml-3 text-sm text-gray-700">
                            <span class="font-medium">El interés ya está incluido en el monto total</span>
                            <p class="text-xs text-gray-600 mt-1">Marca esta opción si el monto total ya incluye los intereses. El porcentaje de interés arriba es solo informativo para tu referencia. Al marcar esto, las cuotas se calcularán dividiendo el monto total sin agregar interés adicional. Si cambias esto, las cuotas pendientes se regenerarán automáticamente.</p>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado *</label>
                    <select name="status" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="active" {{ old('status', $debt->status) === 'active' ? 'selected' : '' }}>Activa</option>
                        <option value="paid" {{ old('status', $debt->status) === 'paid' ? 'selected' : '' }}>Pagada</option>
                        <option value="cancelled" {{ old('status', $debt->status) === 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                        <option value="overdue" {{ old('status', $debt->status) === 'overdue' ? 'selected' : '' }}>Vencida</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    Guardar Cambios
                </button>
                <a href="{{ route('superlinkiu.personal-finance.debts.show', $debt) }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition-colors">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const installmentAmountInput = document.getElementById('installment_amount');
        const totalInstallments = {{ $debt->total_installments }};
        const totalAmountInput = document.getElementById('total_amount');
        const totalToPayInput = document.getElementById('total_to_pay');

        function calculateTotal() {
            const installmentAmount = parseFloat(installmentAmountInput.value) || 0;
            
            if (installmentAmount > 0 && totalInstallments > 0) {
                const total = installmentAmount * totalInstallments;
                totalToPayInput.value = new Intl.NumberFormat('es-CO', {
                    style: 'currency',
                    currency: 'COP',
                    minimumFractionDigits: 0
                }).format(total);
                totalAmountInput.value = total.toFixed(2);
            } else {
                const currentTotal = parseFloat(totalAmountInput.value) || 0;
                totalToPayInput.value = new Intl.NumberFormat('es-CO', {
                    style: 'currency',
                    currency: 'COP',
                    minimumFractionDigits: 0
                }).format(currentTotal);
            }
        }

        installmentAmountInput.addEventListener('input', calculateTotal);
        totalAmountInput.addEventListener('input', function() {
            const total = parseFloat(this.value) || 0;
            totalToPayInput.value = new Intl.NumberFormat('es-CO', {
                style: 'currency',
                currency: 'COP',
                minimumFractionDigits: 0
            }).format(total);
        });
        
        // Calcular al cargar la página
        calculateTotal();
    });
</script>
@endpush
@endsection
