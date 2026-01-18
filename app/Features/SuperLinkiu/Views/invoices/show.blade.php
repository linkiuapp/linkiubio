@extends('shared::layouts.admin')

@section('title', 'Factura #' . $invoice->invoice_number)

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6" x-data="invoiceShow()">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.invoices.index') }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-lg font-semibold text-gray-800">Factura #{{ $invoice->invoice_number }}</h1>
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
                <p class="text-sm text-gray-600 mt-1">Detalles completos de la factura</p>
            </div>
        </div>
        <div class="flex gap-2">
            @if(!$invoice->isPaid() && !$invoice->isCancelled())
                <button @click="openMarkAsPaidModal()" 
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    Marcar como Pagada
                </button>
            @endif
            @if(!$invoice->isPaid())
                <a href="{{ route('superlinkiu.invoices.edit', $invoice) }}" 
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                    <i data-lucide="edit" class="w-4 h-4"></i>
                    Editar
                </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Columna Principal --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Detalles de la Factura --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                        Detalles de la Factura
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Número de Factura</label>
                                <p class="text-gray-900 font-semibold">#{{ $invoice->invoice_number }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Monto Total</label>
                                <p class="text-2xl font-bold text-blue-600">{{ $invoice->getFormattedAmount() }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Período</label>
                                <p class="text-gray-900 font-semibold">{{ $invoice->getPeriodLabel() }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Fecha de Emisión</label>
                                <p class="text-gray-900 font-semibold">{{ $invoice->issue_date->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Fecha de Vencimiento</label>
                                <p class="text-gray-900 font-semibold">{{ $invoice->due_date->format('d/m/Y') }}</p>
                                @if($invoice->isOverdue())
                                    <p class="text-xs text-red-600 font-medium mt-1">
                                        Vencida hace {{ $invoice->getDaysOverdue() }} días
                                    </p>
                                @elseif($invoice->isPending())
                                    <p class="text-xs text-yellow-600 mt-1">
                                        Vence en {{ $invoice->getDaysUntilDue() }} días
                                    </p>
                                @endif
                            </div>
                            @if($invoice->paid_date)
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Fecha de Pago</label>
                                    <p class="text-green-600 font-semibold">{{ $invoice->paid_date->format('d/m/Y H:i') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @if($invoice->notes)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <label class="block text-xs font-medium text-gray-600 mb-2">Notas</label>
                            <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg">{{ $invoice->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Historial de Estados --}}
            @if($invoice->metadata && isset($invoice->metadata['status_history']))
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                            <i data-lucide="history" class="w-5 h-5 text-purple-600"></i>
                            Historial de Estados
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @foreach($invoice->metadata['status_history'] as $history)
                                @php
                                    $statusDots = [
                                        'paid' => 'bg-green-600',
                                        'cancelled' => 'bg-gray-600',
                                        'overdue' => 'bg-red-600',
                                        'pending' => 'bg-yellow-600',
                                    ];
                                @endphp
                                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                    <div class="w-2 h-2 rounded-full {{ $statusDots[$history['status']] ?? 'bg-gray-400' }}"></div>
                                    <div class="flex-1">
                                        <div class="text-sm font-medium text-gray-900">{{ $history['status_label'] ?? ucfirst($history['status']) }}</div>
                                        <div class="text-xs text-gray-500">{{ $history['changed_at'] ?? 'Fecha no disponible' }}</div>
                                    </div>
                                    @if(isset($history['reason']))
                                        <div class="text-xs text-gray-600 italic">{{ $history['reason'] }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            
            {{-- Información de la Tienda --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-3 border-b border-gray-200">
                    <h2 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="store" class="w-4 h-4 text-blue-600"></i>
                        Tienda
                    </h2>
                </div>
                <div class="p-4">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-bold text-lg">{{ substr($invoice->store->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $invoice->store->name }}</h3>
                            <p class="text-xs text-gray-500">{{ $invoice->store->email }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-1.5 text-sm">
                        @if($invoice->store->document_number)
                            <div class="flex justify-between py-1.5 border-b border-gray-100">
                                <span class="text-xs text-gray-600">{{ strtoupper($invoice->store->document_type) }}:</span>
                                <span class="text-xs text-gray-900">{{ $invoice->store->document_number }}</span>
                            </div>
                        @endif
                        @if($invoice->store->phone)
                            <div class="flex justify-between py-1.5 border-b border-gray-100">
                                <span class="text-xs text-gray-600">Teléfono:</span>
                                <span class="text-xs text-gray-900">{{ $invoice->store->phone }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <a href="{{ route('superlinkiu.stores.show', $invoice->store) }}" 
                           class="text-blue-600 hover:text-blue-800 text-xs font-medium flex items-center gap-1">
                            Ver tienda completa
                            <i data-lucide="arrow-right" class="w-3 h-3"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Información del Plan --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-3 border-b border-gray-200">
                    <h2 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="award" class="w-4 h-4 text-purple-600"></i>
                        Plan
                    </h2>
                </div>
                <div class="p-4">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                            <i data-lucide="crown" class="w-5 h-5 text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $invoice->plan->name }}</h3>
                            <p class="text-xs text-gray-500">{{ $invoice->getPeriodLabel() }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-1.5">
                        <div class="flex justify-between py-1.5 border-b border-gray-100">
                            <span class="text-xs text-gray-600">Precio base:</span>
                            <span class="text-xs text-gray-900">${{ number_format($invoice->plan->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between py-1.5">
                            <span class="text-xs text-gray-600">Duración:</span>
                            <span class="text-xs text-gray-900">{{ $invoice->plan->duration_in_days }} días</span>
                        </div>
                    </div>
                    
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <a href="{{ route('superlinkiu.plans.show', $invoice->plan) }}" 
                           class="text-blue-600 hover:text-blue-800 text-xs font-medium flex items-center gap-1">
                            Ver plan completo
                            <i data-lucide="arrow-right" class="w-3 h-3"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Acciones --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-3 border-b border-gray-200">
                    <h2 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="zap" class="w-4 h-4 text-yellow-600"></i>
                        Acciones Rápidas
                    </h2>
                </div>
                <div class="p-4 space-y-2">
                    @if(!$invoice->isPaid() && !$invoice->isCancelled())
                        <button @click="openMarkAsPaidModal()" 
                                class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors flex items-center justify-center gap-2">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                            Marcar como Pagada
                        </button>
                        
                        <button @click="openCancelModal()" 
                                class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors flex items-center justify-center gap-2">
                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                            Cancelar Factura
                        </button>
                    @endif
                    
                    @if(!$invoice->isPaid())
                        <a href="{{ route('superlinkiu.invoices.edit', $invoice) }}" 
                           class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center justify-center gap-2">
                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                            Editar Factura
                        </a>
                        
                        <button @click="$dispatch('delete-invoice', {id: {{ $invoice->id }}, number: '{{ $invoice->invoice_number }}'})"
                                class="w-full px-4 py-2 bg-white hover:bg-red-50 text-red-600 border border-red-200 hover:border-red-300 rounded-lg transition-colors flex items-center justify-center gap-2">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                            Eliminar Factura
                        </button>
                    @endif
                </div>
            </div>
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
                                        ¿Confirmar pago de la factura <span class="font-semibold text-gray-900">#{{ $invoice->invoice_number }}</span>?
                                    </p>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Fecha de Pago
                                        </label>
                                        <input type="date" 
                                               x-model="paidDate"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
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

    {{-- Modal Cancelar Factura --}}
    <div x-show="showCancelModal" 
         x-cloak
         x-on:keydown.escape.window="closeCancelModal()"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        
        <div x-show="showCancelModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="closeCancelModal()"
             class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity">
        </div>

        <div x-show="showCancelModal"
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
                                <i data-lucide="x-circle" class="h-6 w-6 text-red-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left flex-1">
                                <h3 class="text-base font-semibold leading-6 text-gray-900">
                                    Cancelar Factura
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-4">
                                        ¿Confirmar cancelación de la factura <span class="font-semibold text-gray-900">#{{ $invoice->invoice_number }}</span>?
                                    </p>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Razón de cancelación (opcional)
                                        </label>
                                        <textarea x-model="cancelReason"
                                                  rows="3"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                                  placeholder="Describe la razón..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                        <button type="button" 
                                @click="confirmCancel()"
                                :disabled="cancelLoading"
                                class="inline-flex w-full justify-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 disabled:opacity-50 sm:w-auto">
                            <span x-show="!cancelLoading">Confirmar Cancelación</span>
                            <span x-show="cancelLoading" class="flex items-center gap-2">
                                <i data-lucide="loader" class="size-4 animate-spin"></i>
                                Cancelando...
                            </span>
                        </button>
                        <button type="button" 
                                @click="closeCancelModal()"
                                :disabled="cancelLoading"
                                class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 disabled:opacity-50 sm:mt-0 sm:w-auto">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de Eliminación --}}
    <div x-data="deleteModalData()"
         x-on:delete-invoice.window="openModal($event.detail.id, $event.detail.number)"
         x-on:keydown.escape.window="closeModal()">
        <div x-show="open" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto"
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
        
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
                                    <h3 class="text-base font-semibold leading-6 text-gray-900">
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
function invoiceShow() {
    return {
        // Modal Marcar como Pagada
        showMarkAsPaidModal: false,
        markAsPaidLoading: false,
        paidDate: new Date().toISOString().split('T')[0],

        // Modal Cancelar
        showCancelModal: false,
        cancelLoading: false,
        cancelReason: '',

        openMarkAsPaidModal() {
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
        },

        async confirmMarkAsPaid() {
            this.markAsPaidLoading = true;
            
            try {
                const response = await fetch(`/superlinkiu/invoices/{{ $invoice->id }}/mark-as-paid`, {
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
        },

        openCancelModal() {
            this.cancelReason = '';
            this.showCancelModal = true;
            this.cancelLoading = false;
            
            this.$nextTick(() => {
                if (window.createIcons) window.createIcons({ icons: window.lucideIcons });
            });
        },

        closeCancelModal() {
            if (this.cancelLoading) return;
            this.showCancelModal = false;
        },

        async confirmCancel() {
            this.cancelLoading = true;
            
            try {
                const response = await fetch(`/superlinkiu/invoices/{{ $invoice->id }}/cancel`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        reason: this.cancelReason
                    })
                });

                const data = await response.json();
                
                if (!response.ok) {
                    this.cancelLoading = false;
                    this.closeCancelModal();
                    
                    if (window.toast) {
                        window.toast.error(
                            '¡Ups! algo salió mal',
                            data.message || 'Error al cancelar factura',
                            5000,
                            'bottom-center'
                        );
                    }
                    return;
                }
                
                this.cancelLoading = false;
                this.closeCancelModal();
                
                if (window.toast) {
                    window.toast.success(
                        '¡Hey! felicidades',
                        'Factura cancelada exitosamente',
                        5000,
                        'bottom-center'
                    );
                }
                
                setTimeout(() => location.reload(), 1500);
            } catch (error) {
                this.cancelLoading = false;
                this.closeCancelModal();
                
                if (window.toast) {
                    window.toast.error(
                        '¡Ups! algo salió mal',
                        error.message || 'Error al cancelar factura',
                        5000,
                        'bottom-center'
                    );
                }
            }
        }
    };
}

// Modal de eliminación
document.addEventListener('alpine:init', () => {
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
                this.closeModal();
                
                if (window.toast) {
                    window.toast.success(
                        '¡Hey! felicidades',
                        'Factura eliminada exitosamente',
                        5000,
                        'bottom-center'
                    );
                }
                
                setTimeout(() => window.location.href = '/superlinkiu/invoices', 1500);
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
