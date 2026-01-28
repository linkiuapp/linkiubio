@extends('shared::layouts.admin')

@section('title', 'Cuotas Pendientes')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Cuotas Pendientes</h1>
            <p class="text-sm text-gray-600 mt-1">Gestiona tus próximos pagos</p>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <form method="GET" class="flex gap-4">
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg">
                <option value="">Todas</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendientes</option>
                <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Vencidas</option>
            </select>
            <select name="account_id" class="px-3 py-2 border border-gray-300 rounded-lg">
                <option value="">Todas las cuentas</option>
                @foreach($accounts as $account)
                    <option value="{{ $account->id }}" {{ request('account_id') == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg">
                Filtrar
            </button>
        </form>
    </div>

    @if($installments->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deuda</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cuota</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monto</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vencimiento</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($installments as $installment)
                            <tr class="hover:bg-gray-50 {{ $installment->is_overdue ? 'bg-red-50' : '' }}">
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-900">{{ $installment->debt->name }}</p>
                                    @if($installment->debt->account)
                                        <p class="text-sm text-gray-600">{{ $installment->debt->account->name }}</p>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-900">#{{ $installment->installment_number }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-gray-900">${{ number_format($installment->amount, 0, ',', '.') }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-gray-900">{{ $installment->due_date->format('d/m/Y') }}</p>
                                    @if($installment->days_until_due !== null)
                                        <p class="text-xs {{ $installment->days_until_due < 0 ? 'text-red-600' : ($installment->days_until_due <= 3 ? 'text-orange-600' : 'text-gray-500') }}">
                                            @if($installment->days_until_due < 0)
                                                Vencida hace {{ abs($installment->days_until_due) }} día(s)
                                            @elseif($installment->days_until_due == 0)
                                                Vence hoy
                                            @else
                                                Vence en {{ $installment->days_until_due }} día(s)
                                            @endif
                                        </p>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded
                                        {{ $installment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $installment->status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $installment->status === 'overdue' ? 'bg-red-100 text-red-800' : '' }}
                                    ">
                                        {{ $installment->status_label }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if($installment->status === 'pending')
                                        <button onclick="openPaymentModal({{ $installment->id }}, {{ $installment->amount }}, '{{ $installment->debt->name }}')"
                                            class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded transition-colors">
                                            Marcar como Pagada
                                        </button>
                                    @else
                                        <span class="text-sm text-gray-500">Pagada</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $installments->links() }}
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <i data-lucide="check-circle" class="w-16 h-16 text-green-400 mx-auto mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">¡No tienes cuotas pendientes!</h3>
            <p class="text-gray-600">Todas tus cuotas están al día</p>
        </div>
    @endif
</div>

{{-- Modal para marcar como pagada --}}
<div id="paymentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center backdrop-blur-sm" onclick="closePaymentModal()">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Marcar Cuota como Pagada</h2>
                <button onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="paymentForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="installment_id" id="installment_id">
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deuda</label>
                        <input type="text" id="debt_name" readonly class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Monto Pagado *</label>
                        <input type="number" name="amount" id="amount" required step="0.01" min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Monto mínimo de la cuota: <span id="min_amount" class="font-semibold text-blue-600">$0</span></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Pago *</label>
                        <input type="date" name="payment_date" value="{{ now()->format('Y-m-d') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cuenta desde la que se pagó *</label>
                        <select name="account_id" required id="payment_account_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Selecciona una cuenta</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}" data-balance="{{ $account->current_balance }}">
                                    {{ $account->name }} - Saldo: ${{ number_format($account->current_balance, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Método de Pago *</label>
                        <select name="payment_method" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="transfer">Transferencia</option>
                            <option value="cash">Efectivo</option>
                            <option value="account_bank">Cuenta Bancaria</option>
                            <option value="nequi">Nequi</option>
                            <option value="daviplata">Daviplata</option>
                            <option value="other">Otro</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Número de Referencia</label>
                        <input type="text" name="reference_number"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Soporte de Pago (Opcional)</label>
                        <input type="file" name="receipt_file" accept="image/*,.pdf"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Formatos permitidos: JPG, PNG, PDF (máx. 5MB)</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
                        <textarea name="notes" rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>
                
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                        Guardar Pago
                    </button>
                    <button type="button" onclick="closePaymentModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition-colors">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let currentInstallmentAmount = 0;

    function openPaymentModal(installmentId, amount, debtName) {
        currentInstallmentAmount = amount;
        document.getElementById('installment_id').value = installmentId;
        document.getElementById('amount').value = amount;
        document.getElementById('amount').min = amount;
        document.getElementById('min_amount').textContent = '$' + new Intl.NumberFormat('es-CO').format(amount);
        document.getElementById('debt_name').value = debtName;
        document.getElementById('paymentForm').action = `/superlinkiu/personal-finance/installments/${installmentId}/mark-paid`;
        document.getElementById('paymentModal').classList.remove('hidden');
        
        // Reiniciar formulario
        document.getElementById('paymentForm').reset();
        document.getElementById('installment_id').value = installmentId;
        document.getElementById('amount').value = amount;
        document.getElementById('amount').min = amount;
        document.getElementById('debt_name').value = debtName;
        document.getElementById('payment_date').value = new Date().toISOString().split('T')[0];
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        
        // Cerrar modal con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePaymentModal();
            }
        });
    });
</script>
@endpush
@endsection
