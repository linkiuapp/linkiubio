@extends('shared::layouts.admin')

@section('title', 'Herramientas de Linkiu')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Herramientas de Linkiu</h1>
            <p class="text-sm text-gray-600 mt-1">Administra todas las herramientas y servicios utilizados en Linkiu</p>
        </div>
        <a href="{{ route('superlinkiu.linkiu-tools.create') }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Nueva Herramienta
        </a>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-6">
        <form method="GET" action="{{ route('superlinkiu.linkiu-tools.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Búsqueda</label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Nombre, descripción..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Todas</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activa</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactiva</option>
                    <option value="deprecated" {{ request('status') === 'deprecated' ? 'selected' : '' }}>Deprecada</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Facturación</label>
                <select name="billing_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Todas</option>
                    <option value="free" {{ request('billing_type') === 'free' ? 'selected' : '' }}>Gratis</option>
                    <option value="monthly" {{ request('billing_type') === 'monthly' ? 'selected' : '' }}>Mensual</option>
                    <option value="yearly" {{ request('billing_type') === 'yearly' ? 'selected' : '' }}>Anual</option>
                    <option value="pay_per_use" {{ request('billing_type') === 'pay_per_use' ? 'selected' : '' }}>Por uso</option>
                </select>
            </div>
            
            <div class="md:col-span-4 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800">
                    Filtrar
                </button>
                <a href="{{ route('superlinkiu.linkiu-tools.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    {{-- Tabla --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Herramienta</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Facturación</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Costo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Próxima Renovación</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tools as $tool)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($tool->is_critical)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 mr-2">
                                            Crítica
                                        </span>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $tool->name }}</div>
                                        @if($tool->description)
                                            <div class="text-xs text-gray-500 mt-1">{{ Str::limit($tool->description, 50) }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">{{ $tool->category ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">
                                    @if($tool->billing_type === 'free')
                                        Gratis
                                    @elseif($tool->billing_type === 'monthly')
                                        Mensual
                                    @elseif($tool->billing_type === 'yearly')
                                        Anual
                                    @else
                                        Por uso
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($tool->isPayPerUse())
                                    <div class="flex flex-col gap-1">
                                        @if($tool->current_balance !== null)
                                            <span class="text-sm font-semibold {{ $tool->isBalanceLow() ? 'text-red-600' : 'text-gray-900' }}">
                                                Saldo: {{ $tool->getFormattedBalance() }}
                                            </span>
                                        @endif
                                        @if($tool->minimum_recharge)
                                            <span class="text-xs text-gray-600">
                                                Recarga mín: {{ $tool->getBalanceCurrency() }} {{ number_format($tool->minimum_recharge, 2) }}
                                            </span>
                                        @endif
                                    </div>
                                @elseif($tool->billing_type !== 'free')
                                    <span class="text-sm text-gray-900">
                                        {{ $tool->getFormattedCost() }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($tool->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Activa
                                    </span>
                                @elseif($tool->status === 'inactive')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Inactiva
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Deprecada
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($tool->next_renewal_date && $tool->billing_type !== 'free')
                                    <div class="flex flex-col gap-1">
                                        <span class="text-sm text-gray-900">
                                            {{ $tool->next_renewal_date->format('d/m/Y') }}
                                        </span>
                                        @if($tool->getPaymentStatus())
                                            @php
                                                $status = $tool->getPaymentStatus();
                                                $label = $tool->getPaymentStatusLabel();
                                                $daysOverdue = $tool->getDaysOverdue();
                                            @endphp
                                            @if($status === 'active')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $label }}
                                                </span>
                                            @elseif($status === 'upcoming')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    {{ $label }}
                                                </span>
                                            @elseif($status === 'due')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                    {{ $label }}
                                                </span>
                                            @elseif($status === 'overdue')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                    {{ $label }} ({{ $daysOverdue }} días)
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    @if($tool->billing_type !== 'free')
                                        <button onclick="openPaymentModal({{ $tool->id }}, '{{ $tool->name }}', '{{ $tool->getFormattedCost() }}', '{{ $tool->billing_type }}', '{{ $tool->currency }}', {{ $tool->minimum_recharge ?? 'null' }}, {{ $tool->current_balance ?? 'null' }})" 
                                                class="px-3 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-xs">
                                            {{ $tool->isPayPerUse() ? 'Recargar' : 'Pagar' }}
                                        </button>
                                    @endif
                                    <a href="{{ route('superlinkiu.linkiu-tools.show', $tool) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        Ver
                                    </a>
                                    <a href="{{ route('superlinkiu.linkiu-tools.edit', $tool) }}" 
                                       class="text-gray-600 hover:text-gray-900">
                                        Editar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                No se encontraron herramientas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginación --}}
    @if($tools->hasPages())
        <div class="mt-6">
            {{ $tools->links() }}
        </div>
    @endif
</div>

{{-- Modal de Pago --}}
<div x-data="paymentModal()" 
     x-show="open" 
     x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 flex items-center justify-center"
     style="display: none;"
     x-init="init()">
    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="closeModal()"></div>
    
    {{-- Modal Container --}}
    <div class="relative bg-white rounded-xl shadow-xl max-w-md w-full mx-4 z-10" @click.stop>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900" x-text="billingType === 'pay_per_use' ? 'Registrar Recarga' : 'Registrar Pago'"></h3>
                <button @click="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form :id="'paymentForm-' + toolId" method="POST" enctype="multipart/form-data" @submit.prevent="submitPayment">
                @csrf
                <input type="hidden" name="tool_id" :value="toolId">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Herramienta</label>
                        <input type="text" :value="toolName" readonly class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <span x-text="billingType === 'pay_per_use' ? 'Fecha de Recarga' : 'Fecha de Pago'"></span> <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="payment_date" required :value="today" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- Información de recarga (solo para pay_per_use) --}}
                    <div x-show="billingType === 'pay_per_use'" class="bg-blue-50 border border-blue-200 rounded-lg p-3 space-y-2">
                        <div class="flex items-center gap-2 text-sm">
                            <i data-lucide="info" class="w-4 h-4 text-blue-600"></i>
                            <span class="font-medium text-blue-900">Información de Recarga</span>
                        </div>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div x-show="currentBalance !== null">
                                <span class="text-gray-600">Saldo Actual:</span>
                                <span class="font-semibold text-gray-900 ml-1" x-text="currency + ' ' + (currentBalance ? parseFloat(currentBalance).toFixed(2) : '0.00')"></span>
                            </div>
                            <div x-show="minimumRecharge !== null">
                                <span class="text-gray-600">Recarga Mínima:</span>
                                <span class="font-semibold text-blue-700 ml-1" x-text="currency + ' ' + (minimumRecharge ? parseFloat(minimumRecharge).toFixed(2) : '0.00')"></span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <span x-text="billingType === 'pay_per_use' ? 'Monto de Recarga' : 'Monto'"></span> <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="text" name="currency" :value="currency" readonly class="w-20 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 text-sm">
                            <input type="number" 
                                   name="amount" 
                                   step="0.01" 
                                   :value="amountValue" 
                                   x-model="rechargeAmount"
                                   @input="validateRechargeAmount()"
                                   required 
                                   class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                                   :class="billingType === 'pay_per_use' && minimumRecharge && parseFloat(rechargeAmount || 0) < parseFloat(minimumRecharge) ? 'border-red-500 bg-red-50' : 'border-gray-300'">
                        </div>
                        <div x-show="billingType === 'pay_per_use' && minimumRecharge && parseFloat(rechargeAmount || 0) < parseFloat(minimumRecharge)" 
                             class="mt-1 text-xs text-red-600 flex items-center gap-1">
                            <i data-lucide="alert-circle" class="w-3 h-3"></i>
                            <span>La recarga mínima es <strong x-text="currency + ' ' + parseFloat(minimumRecharge).toFixed(2)"></strong></span>
                        </div>
                    </div>

                    <div x-show="billingType !== 'pay_per_use'">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Pago <span class="text-red-500">*</span></label>
                        <select name="payment_type" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="monthly" :selected="billingType === 'monthly'">Mensual</option>
                            <option value="yearly" :selected="billingType === 'yearly'">Anual</option>
                            <option value="renewal">Renovación</option>
                            <option value="one_time">Pago único</option>
                            <option value="other">Otro</option>
                        </select>
                    </div>
                    <input type="hidden" name="payment_type" value="recharge" x-show="billingType === 'pay_per_use'">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Comprobante</label>
                        <input type="file" name="receipt" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Formatos: PDF, JPG, PNG (máx. 5MB)</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
                        <textarea name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" 
                                  :placeholder="billingType === 'pay_per_use' ? 'Notas adicionales sobre la recarga...' : 'Notas adicionales sobre el pago...'"></textarea>
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="button" @click="closeModal()" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <span x-text="billingType === 'pay_per_use' ? 'Registrar Recarga' : 'Registrar Pago'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

@push('scripts')
<script>
function paymentModal() {
    return {
        open: false,
        toolId: null,
        toolName: '',
        amount: '',
        amountValue: '',
        billingType: '',
        currency: '',
        minimumRecharge: null,
        currentBalance: null,
        rechargeAmount: '',
        today: new Date().toISOString().split('T')[0],
        
        init() {
            // Escuchar evento para abrir modal
            const self = this;
            window.addEventListener('openPaymentModal', function(e) {
                self.toolId = e.detail.toolId;
                self.toolName = e.detail.toolName;
                self.amount = e.detail.amount;
                self.amountValue = e.detail.amount.replace(/[^\d.]/g, '');
                self.billingType = e.detail.billingType;
                self.currency = e.detail.currency;
                self.open = true;
                // Forzar actualización de Alpine
                self.$nextTick(() => {
                    if (window.createIcons && window.lucideIcons) {
                        window.createIcons({ icons: window.lucideIcons });
                    }
                });
            });
        },
        
        closeModal() {
            this.open = false;
            this.rechargeAmount = '';
        },
        
        validateRechargeAmount() {
            // Validación se hace visualmente con Alpine
            return true;
        },
        
        submitPayment() {
            // Validar recarga mínima antes de enviar
            if (this.billingType === 'pay_per_use' && this.minimumRecharge) {
                const amount = parseFloat(this.rechargeAmount || this.amountValue || 0);
                const minimum = parseFloat(this.minimumRecharge);
                if (amount < minimum) {
                    alert(`La recarga mínima es ${this.currency} ${minimum.toFixed(2)}. Por favor ingresa un monto igual o mayor.`);
                    return false;
                }
            }
            const formId = 'paymentForm-' + this.toolId;
            const form = document.getElementById(formId);
            if (!form) {
                alert('Error: No se encontró el formulario');
                return;
            }
            
            const formData = new FormData(form);
            
            fetch(`/superlinkiu/linkiu-tools/${this.toolId}/payment`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                    return;
                } else if (response.ok) {
                    return response.json();
                } else {
                    return response.text().then(text => {
                        throw new Error(text || 'Error en la respuesta del servidor');
                    });
                }
            })
            .then(data => {
                if (data && data.success) {
                    window.location.reload();
                } else if (data) {
                    alert(data?.message || 'Error al registrar el pago');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al registrar el pago. Por favor, intenta nuevamente.');
            });
        }
    }
}

function openPaymentModal(toolId, toolName, amount, billingType, currency, minimumRecharge = null, currentBalance = null) {
    // Buscar el modal en la página
    const modal = document.querySelector('[x-data*="paymentModal"]');
    if (modal && modal.__x && modal.__x.$data) {
        // Usar Alpine directamente si está disponible
        modal.__x.$data.toolId = toolId;
        modal.__x.$data.toolName = toolName;
        modal.__x.$data.amount = amount;
        modal.__x.$data.amountValue = amount.replace(/[^\d.]/g, '');
        modal.__x.$data.billingType = billingType;
        modal.__x.$data.currency = currency;
        modal.__x.$data.minimumRecharge = minimumRecharge;
        modal.__x.$data.currentBalance = currentBalance;
        modal.__x.$data.open = true;
    } else {
        // Si Alpine no está disponible, usar evento
        window.dispatchEvent(new CustomEvent('openPaymentModal', {
            detail: {
                toolId: toolId,
                toolName: toolName,
                amount: amount,
                billingType: billingType,
                currency: currency,
                minimumRecharge: minimumRecharge,
                currentBalance: currentBalance
            }
        }));
    }
}

document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endpush
@endsection
