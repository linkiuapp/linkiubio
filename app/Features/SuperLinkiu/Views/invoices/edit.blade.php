@extends('shared::layouts.admin')

@section('title', 'Editar Factura #' . $invoice->invoice_number)

@section('content')
<div class="max-w-4xl mx-auto space-y-6 mt-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.invoices.show', $invoice) }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-lg font-semibold text-gray-800">Editar Factura #{{ $invoice->invoice_number }}</h1>
                    @php
                        $statusBadges = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'paid' => 'bg-green-100 text-green-800',
                            'overdue' => 'bg-red-100 text-red-800',
                            'cancelled' => 'bg-gray-100 text-gray-800',
                        ];
                    @endphp
                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusBadges[$invoice->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $invoice->getStatusLabel() }}
                    </span>
                </div>
                <p class="text-sm text-gray-600 mt-1">Modifica los datos de la factura</p>
            </div>
        </div>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5"></i>
                <div>
                    <p class="font-medium text-red-800 mb-2">Por favor corrige los siguientes errores:</p>
                    <ul class="list-disc list-inside space-y-1 text-sm text-red-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Alerta de factura pagada/cancelada --}}
    @if($invoice->isPaid() || $invoice->isCancelled())
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
            <div class="flex items-start gap-3">
                <i data-lucide="info" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5"></i>
                <div>
                    <h4 class="text-sm font-semibold text-blue-900">Información Importante</h4>
                    <p class="text-sm text-blue-700 mt-1">
                        @if($invoice->isPaid())
                            Esta factura ya está marcada como pagada. Los cambios son limitados por auditoría contable.
                        @else
                            Esta factura está cancelada. Los cambios son limitados.
                        @endif
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Formulario --}}
    <form action="{{ route('superlinkiu.invoices.update', $invoice) }}" method="POST" x-data="editInvoice()">
        @csrf
        @method('PUT')
        
        {{-- Sección: Tienda y Plan --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="building" class="w-5 h-5 text-blue-600"></i>
                    Tienda y Plan
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tienda <span class="text-red-500">*</span>
                        </label>
                        <select name="store_id" 
                                x-model="selectedStore"
                                @change="updatePlanFromStore()"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('store_id') border-red-300 @enderror">
                            <option value="">Seleccionar tienda</option>
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}" 
                                        data-plan-id="{{ $store->plan_id }}"
                                        {{ $invoice->store_id == $store->id ? 'selected' : '' }}>
                                    {{ $store->name }} - {{ $store->plan->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('store_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Plan <span class="text-red-500">*</span>
                        </label>
                        <select name="plan_id" 
                                x-model="selectedPlan"
                                @change="updateAmountFromPlan()"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('plan_id') border-red-300 @enderror">
                            <option value="">Seleccionar plan</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" 
                                        {{ $invoice->plan_id == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('plan_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección: Período y Monto --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="dollar-sign" class="w-5 h-5 text-green-600"></i>
                    Facturación
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Período <span class="text-red-500">*</span>
                        </label>
                        <select name="period" 
                                x-model="selectedPeriod"
                                @change="updateAmountFromPlan()"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('period') border-red-300 @enderror">
                            <option value="">Seleccionar</option>
                            <option value="monthly" {{ $invoice->period == 'monthly' ? 'selected' : '' }}>Mensual</option>
                            <option value="quarterly" {{ $invoice->period == 'quarterly' ? 'selected' : '' }}>Trimestral</option>
                            <option value="semester" {{ $invoice->period == 'semester' ? 'selected' : '' }}>Semestral</option>
                        </select>
                        @error('period')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Monto (COP) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-500">$</span>
                            <input type="number" 
                                   name="amount" 
                                   x-model="amount"
                                   value="{{ old('amount', $invoice->amount) }}"
                                   min="0"
                                   step="1000"
                                   required
                                   class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('amount') border-red-300 @enderror"
                                   placeholder="49900">
                        </div>
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección: Fechas --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="calendar" class="w-5 h-5 text-purple-600"></i>
                    Fechas
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Fecha de Emisión <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               name="issue_date" 
                               value="{{ old('issue_date', $invoice->issue_date->format('Y-m-d')) }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('issue_date') border-red-300 @enderror">
                        @error('issue_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Fecha de Vencimiento <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               name="due_date" 
                               value="{{ old('due_date', $invoice->due_date->format('Y-m-d')) }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('due_date') border-red-300 @enderror">
                        @error('due_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Sección: Notas --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="file-text" class="w-5 h-5 text-gray-600"></i>
                    Notas Adicionales
                </h2>
            </div>
            <div class="p-6">
                <textarea name="notes" 
                          rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-300 @enderror"
                          placeholder="Notas adicionales sobre la factura">{{ old('notes', $invoice->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Botones --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('superlinkiu.invoices.show', $invoice) }}" 
               class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i>
                Actualizar Factura
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function editInvoice() {
    return {
        selectedStore: '{{ $invoice->store_id }}',
        selectedPlan: '{{ $invoice->plan_id }}',
        selectedPeriod: '{{ $invoice->period }}',
        amount: {{ $invoice->amount }},
        stores: @json($stores),
        plans: @json($plans),
        
        updatePlanFromStore() {
            if (this.selectedStore) {
                const storeSelect = document.querySelector('select[name="store_id"]');
                const selectedOption = storeSelect.options[storeSelect.selectedIndex];
                const planId = selectedOption.dataset.planId;
                
                this.selectedPlan = planId;
                this.updateAmountFromPlan();
            }
        },
        
        updateAmountFromPlan() {
            if (this.selectedPlan && this.selectedPeriod) {
                const plan = this.plans.find(p => p.id == this.selectedPlan);
                if (plan && plan.prices && plan.prices[this.selectedPeriod]) {
                    this.amount = plan.prices[this.selectedPeriod];
                }
            }
        }
    };
}

// Inicializar iconos Lucide
document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endpush
@endsection
