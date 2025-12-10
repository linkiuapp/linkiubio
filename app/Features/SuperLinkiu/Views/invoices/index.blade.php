@extends('shared::layouts.admin')

@section('title', 'Gestión de Facturas')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6" x-data="invoiceManager">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Gestión de Facturas</h1>
            <p class="text-sm text-gray-600 mt-1">Control completo de facturación y pagos de suscripciones</p>
        </div>
        <a href="{{ route('superlinkiu.invoices.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Nueva Factura
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i data-lucide="file-text" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase">Pendientes</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i data-lucide="clock" class="w-6 h-6 text-yellow-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase">Pagadas</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['paid'] }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase">Vencidas</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['overdue'] }}</p>
                </div>
                <div class="p-3 bg-red-100 rounded-lg">
                    <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase">Ingresos</p>
                    <p class="text-lg font-bold text-blue-600">${{ number_format($stats['total_amount'], 0, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i data-lucide="dollar-sign" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Número o tienda"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tienda</label>
                <select name="store_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todas</option>
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}" {{ request('store_id') == $store->id ? 'selected' : '' }}>
                            {{ $store->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Plan</label>
                <select name="plan_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" {{ request('plan_id') == $plan->id ? 'selected' : '' }}>
                            {{ $plan->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Pagada</option>
                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Vencida</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Período</label>
                <select name="period" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos</option>
                    <option value="monthly" {{ request('period') == 'monthly' ? 'selected' : '' }}>Mensual</option>
                    <option value="quarterly" {{ request('period') == 'quarterly' ? 'selected' : '' }}>Trimestral</option>
                    <option value="semester" {{ request('period') == 'semester' ? 'selected' : '' }}>Semestral</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </button>
                <a href="{{ route('superlinkiu.invoices.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                </a>
            </div>
        </form>
    </div>

    {{-- Tabla de Facturas --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-base font-semibold text-gray-900">Lista de Facturas</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Número</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tienda</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Período</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vencimiento</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($invoices as $invoice)
                        <tr class="hover:bg-gray-50" data-id="{{ $invoice->id }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $invoice->invoice_number }}</div>
                                <div class="text-xs text-gray-500">{{ $invoice->issue_date->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($invoice->store)
                                    <div class="text-sm text-gray-900">{{ $invoice->store->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $invoice->store->email }}</div>
                                @else
                                    <div class="text-sm text-gray-400">Sin tienda</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $invoice->plan->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ $invoice->getFormattedAmount() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $invoice->getPeriodLabel() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'paid' => 'bg-green-100 text-green-800',
                                        'overdue' => 'bg-red-100 text-red-800',
                                        'cancelled' => 'bg-gray-100 text-gray-800',
                                    ];
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusColors[$invoice->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $invoice->getStatusLabel() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $invoice->due_date->format('d/m/Y') }}</div>
                                @if($invoice->isOverdue())
                                    <div class="text-xs text-red-600 font-medium">
                                        Vencida hace {{ $invoice->getDaysOverdue() }} días
                                    </div>
                                @elseif($invoice->isPending())
                                    <div class="text-xs text-yellow-600">
                                        Vence en {{ $invoice->getDaysUntilDue() }} días
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('superlinkiu.invoices.show', $invoice) }}" 
                                       class="text-blue-600 hover:text-blue-800" title="Ver detalles">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    @if(!$invoice->isPaid())
                                        <a href="{{ route('superlinkiu.invoices.edit', $invoice) }}" 
                                           class="text-blue-600 hover:text-blue-800" title="Editar">
                                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                                        </a>
                                    @endif
                                    @if($invoice->isPending())
                                        <button @click="openMarkAsPaidModal({{ $invoice->id }}, '{{ $invoice->invoice_number }}')" 
                                                class="text-green-600 hover:text-green-800" title="Marcar como pagada">
                                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        </button>
                                    @endif
                                    @if(!$invoice->isPaid())
                                        <button @click="$dispatch('delete-invoice', {id: {{ $invoice->id }}, number: '{{ $invoice->invoice_number }}'})"
                                                class="text-red-600 hover:text-red-800" title="Eliminar">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <i data-lucide="folder-open" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                                <p class="text-lg">No hay facturas registradas</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if($invoices->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $invoices->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Modal Marcar como Pagada --}}
    <div x-show="showMarkAsPaidModal" 
         x-cloak
         x-on:keydown.escape.window="closeMarkAsPaidModal()"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        
        <div x-show="showMarkAsPaidModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="closeMarkAsPaidModal()"
             class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity">
        </div>

        <div x-show="showMarkAsPaidModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="fixed inset-0 z-10 overflow-x-hidden overflow-y-auto pointer-events-none">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg pointer-events-auto">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i data-lucide="check-circle" class="h-6 w-6 text-green-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left flex-1">
                                <h3 class="text-base font-semibold leading-6 text-gray-900">
                                    Marcar como Pagada
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-4">
                                        ¿Confirmar pago de la factura <span class="font-semibold text-gray-900" x-text="markAsPaidNumber"></span>?
                                    </p>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Fecha de Pago
                                        </label>
                                        <input type="date" 
                                               x-model="paidDate"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                               :value="paidDate">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                        <button type="button" 
                                @click="confirmMarkAsPaid()"
                                :disabled="markAsPaidLoading"
                                class="inline-flex w-full justify-center rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700 disabled:opacity-50 sm:w-auto">
                            <span x-show="!markAsPaidLoading">Confirmar Pago</span>
                            <span x-show="markAsPaidLoading" class="flex items-center gap-2">
                                <i data-lucide="loader" class="size-4 animate-spin"></i>
                                Procesando...
                            </span>
                        </button>
                        <button type="button" 
                                @click="closeMarkAsPaidModal()"
                                :disabled="markAsPaidLoading"
                                class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 disabled:opacity-50 sm:mt-0 sm:w-auto">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de Eliminación --}}
    <div x-show="open" 
         x-cloak
         x-on:delete-invoice.window="openModal($event.detail.id, $event.detail.number)"
         x-on:keydown.escape.window="closeModal()"
         x-data="deleteModalData"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        
        {{-- Backdrop --}}
        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="closeModal()"
             class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity">
        </div>

        {{-- Modal --}}
        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="fixed inset-0 z-10 overflow-x-hidden overflow-y-auto pointer-events-none">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg pointer-events-auto">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i data-lucide="alert-triangle" class="h-6 w-6 text-red-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">
                                    Eliminar Factura
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        ¿Estás seguro de que deseas eliminar la factura <span class="font-semibold text-gray-900" x-text="invoiceNumber"></span>?
                                        Esta acción no se puede deshacer.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                        <button type="button" 
                                @click="confirmDelete()"
                                :disabled="loading"
                                class="inline-flex w-full justify-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 disabled:opacity-50 sm:w-auto">
                            <span x-show="!loading">Sí, eliminar</span>
                            <span x-show="loading" class="flex items-center gap-2">
                                <i data-lucide="loader" class="size-4 animate-spin"></i>
                                Eliminando...
                            </span>
                        </button>
                        <button type="button" 
                                @click="closeModal()"
                                :disabled="loading"
                                class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 disabled:opacity-50 sm:mt-0 sm:w-auto">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- Toast de éxito --}}
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.toast) {
        window.toast.success(
            '¡Hey! felicidades',
            '{{ session('success') }}',
            5000,
            'bottom-center'
        );
    }
});
</script>
@endif

{{-- Toast de error --}}
@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.toast) {
        window.toast.error(
            '¡Ups! algo salió mal',
            '{{ session('error') }}',
            5000,
            'bottom-center'
        );
    }
});
</script>
@endif

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('invoiceManager', () => ({
        // Modal Marcar como Pagada
        showMarkAsPaidModal: false,
        markAsPaidId: null,
        markAsPaidNumber: '',
        markAsPaidLoading: false,
        paidDate: new Date().toISOString().split('T')[0],

        openMarkAsPaidModal(id, number) {
            this.markAsPaidId = id;
            this.markAsPaidNumber = number;
            this.paidDate = new Date().toISOString().split('T')[0];
            this.showMarkAsPaidModal = true;
            this.markAsPaidLoading = false;
            
            this.$nextTick(() => {
                if (window.createIcons) window.createIcons({ icons: window.lucideIcons });
            });
        },

        closeMarkAsPaidModal() {
            if (this.markAsPaidLoading) return;
            this.showMarkAsPaidModal = false;
            this.markAsPaidId = null;
            this.markAsPaidNumber = '';
        },

        async confirmMarkAsPaid() {
            if (!this.markAsPaidId) return;
            
            this.markAsPaidLoading = true;
            
            try {
                const response = await fetch(`/superlinkiu/invoices/${this.markAsPaidId}/mark-as-paid`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        paid_date: this.paidDate
                    })
                });

                const data = await response.json();
                
                if (!response.ok) {
                    this.markAsPaidLoading = false;
                    this.closeMarkAsPaidModal();
                    
                    if (window.toast) {
                        window.toast.error(
                            '¡Ups! algo salió mal',
                            data.message || 'Error al marcar como pagada',
                            5000,
                            'bottom-center'
                        );
                    }
                    return;
                }
                
                this.markAsPaidLoading = false;
                this.closeMarkAsPaidModal();
                
                if (window.toast) {
                    window.toast.success(
                        '¡Hey! felicidades',
                        'Factura marcada como pagada exitosamente',
                        5000,
                        'bottom-center'
                    );
                }
                
                setTimeout(() => location.reload(), 1500);
            } catch (error) {
                this.markAsPaidLoading = false;
                this.closeMarkAsPaidModal();
                
                if (window.toast) {
                    window.toast.error(
                        '¡Ups! algo salió mal',
                        error.message || 'Error al procesar la solicitud',
                        5000,
                        'bottom-center'
                    );
                }
            }
        }
    }));

    // Modal de eliminación
    Alpine.data('deleteModalData', () => ({
        open: false,
        invoiceId: null,
        invoiceNumber: '',
        loading: false,

        openModal(id, number) {
            this.invoiceId = id;
            this.invoiceNumber = number;
            this.open = true;
            this.loading = false;
            
            this.$nextTick(() => {
                if (window.createIcons) window.createIcons({ icons: window.lucideIcons });
            });
        },

        closeModal() {
            if (this.loading) return;
            this.open = false;
            this.invoiceId = null;
            this.invoiceNumber = '';
        },

        async confirmDelete() {
            if (!this.invoiceId) return;
            
            this.loading = true;
            
            try {
                const response = await fetch(`/superlinkiu/invoices/${this.invoiceId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    }
                });

                const data = await response.json();
                
                if (!response.ok) {
                    this.loading = false;
                    this.closeModal();
                    
                    if (window.toast) {
                        window.toast.error(
                            '¡Ups! algo salió mal',
                            data.message || 'Error al eliminar la factura',
                            5000,
                            'bottom-center'
                        );
                    }
                    return;
                }
                
                this.loading = false;
                const invoiceNumber = this.invoiceNumber;
                this.closeModal();
                
                const row = document.querySelector(`tr[data-id="${this.invoiceId}"]`);
                if (row) {
                    row.style.transition = 'opacity 0.3s ease-out';
                    row.style.opacity = '0';
                    setTimeout(() => {
                        if (row.parentNode) {
                            row.remove();
                            
                            if (window.toast) {
                                window.toast.success(
                                    '¡Hey! felicidades',
                                    `Factura ${invoiceNumber} eliminada exitosamente`,
                                    5000,
                                    'bottom-center'
                                );
                            }
                        }
                    }, 300);
                } else {
                    window.location.reload();
                }
            } catch (error) {
                this.loading = false;
                this.closeModal();
                
                if (window.toast) {
                    window.toast.error(
                        '¡Ups! algo salió mal',
                        error.message || 'Error al eliminar la factura',
                        5000,
                        'bottom-center'
                    );
                }
            }
        }
    }));
});

// Inicializar iconos Lucide
document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endpush

<style>
[x-cloak] { display: none !important; }
</style>
@endsection
