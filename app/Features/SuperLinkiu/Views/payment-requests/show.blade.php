@extends('shared::layouts.admin')

@section('title', 'Solicitud de Pago - Factura #' . $invoice->invoice_number)

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6" x-data="paymentRequestShow()">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.payment-requests.index') }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-lg font-semibold text-gray-800">Solicitud de Pago</h1>
                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                        Pendiente de Verificación
                    </span>
                </div>
                <p class="text-sm text-gray-600 mt-1">Factura #{{ $invoice->invoice_number }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Columna Principal --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Información de la Factura --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                        Información de la Factura
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Comprobante de Pago --}}
            @php
                $metadata = $invoice->metadata ?? [];
                $paymentProof = $metadata['payment_proof'] ?? null;
                $uploadedAt = isset($metadata['uploaded_at']) ? \Carbon\Carbon::parse($metadata['uploaded_at']) : null;
            @endphp
            @if($paymentProof)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                            <i data-lucide="image" class="w-5 h-5 text-green-600"></i>
                            Comprobante de Pago
                        </h2>
                    </div>
                    <div class="p-6">
                        @if($uploadedAt)
                            <div class="mb-4">
                                <label class="block text-xs font-medium text-gray-600 mb-1">Subido el</label>
                                <p class="text-sm text-gray-900">{{ $uploadedAt->format('d/m/Y H:i:s') }}</p>
                                <p class="text-xs text-gray-500 mt-1">Hace {{ $uploadedAt->diffForHumans() }}</p>
                            </div>
                        @endif

                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            @php
                                $fileUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($paymentProof);
                                $fileExtension = strtolower(pathinfo($paymentProof, PATHINFO_EXTENSION));
                                $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            @endphp
                            
                            @if($isImage)
                                <div class="flex flex-col items-center gap-4">
                                    <img src="{{ $fileUrl }}" 
                                         alt="Comprobante de pago" 
                                         class="max-w-full h-auto rounded-lg shadow-md max-h-96 object-contain">
                                </div>
                            @else
                                <div class="flex flex-col items-center gap-4 p-8">
                                    <i data-lucide="file" class="w-16 h-16 text-gray-400"></i>
                                    <div class="text-center">
                                        <p class="text-sm font-medium text-gray-900">Archivo PDF</p>
                                        <p class="text-xs text-gray-500 mt-1">Haz clic en descargar para ver el comprobante</p>
                                    </div>
                                </div>
                            @endif

                            <div class="mt-4 flex justify-center">
                                <a href="{{ route('superlinkiu.payment-requests.download-proof', $invoice) }}" 
                                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                                    <i data-lucide="download" class="w-4 h-4"></i>
                                    Descargar Comprobante
                                </a>
                            </div>
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
                    
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <a href="{{ route('superlinkiu.stores.show', $invoice->store) }}" 
                           class="text-blue-600 hover:text-blue-800 text-xs font-medium flex items-center gap-1">
                            Ver tienda completa
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
                        Acciones
                    </h2>
                </div>
                <div class="p-4 space-y-3">
                    <button @click="openApproveModal()" 
                            class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors flex items-center justify-center gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        Aprobar Pago
                    </button>
                    
                    <button @click="openRejectModal()" 
                            class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors flex items-center justify-center gap-2">
                        <i data-lucide="x-circle" class="w-4 h-4"></i>
                        Rechazar Solicitud
                    </button>

                    <a href="{{ route('superlinkiu.invoices.show', $invoice) }}" 
                       class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center justify-center gap-2">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                        Ver Factura Completa
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Aprobar Pago --}}
    <div x-show="showApproveModal" 
         x-cloak
         x-on:keydown.escape.window="closeApproveModal()"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        
        <div x-show="showApproveModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="closeApproveModal()"
             class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity">
        </div>

        <div x-show="showApproveModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="fixed inset-0 z-10 overflow-x-hidden overflow-y-auto pointer-events-none">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg pointer-events-auto">
                    <form method="POST" action="{{ route('superlinkiu.payment-requests.approve', $invoice) }}" @submit.prevent="confirmApprove()">
                        @csrf
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <i data-lucide="check-circle" class="h-6 w-6 text-green-600"></i>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left flex-1">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900">
                                        Aprobar Pago
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500 mb-4">
                                            ¿Confirmar aprobación del pago de la factura <span class="font-semibold text-gray-900">#{{ $invoice->invoice_number }}</span>?
                                        </p>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Fecha de Pago
                                                </label>
                                                <input type="date" 
                                                       name="paid_date"
                                                       x-model="paidDate"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Notas (opcional)
                                                </label>
                                                <textarea name="payment_notes"
                                                          x-model="paymentNotes"
                                                          rows="3"
                                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                                          placeholder="Notas adicionales sobre el pago..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                            <button type="submit" 
                                    :disabled="approveLoading"
                                    class="inline-flex w-full justify-center rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700 disabled:opacity-50 sm:w-auto">
                                <span x-show="!approveLoading">Confirmar Aprobación</span>
                                <span x-show="approveLoading" class="flex items-center gap-2">
                                    <i data-lucide="loader" class="size-4 animate-spin"></i>
                                    Procesando...
                                </span>
                            </button>
                            <button type="button" 
                                    @click="closeApproveModal()"
                                    :disabled="approveLoading"
                                    class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 disabled:opacity-50 sm:mt-0 sm:w-auto">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Rechazar Solicitud --}}
    <div x-show="showRejectModal" 
         x-cloak
         x-on:keydown.escape.window="closeRejectModal()"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        
        <div x-show="showRejectModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="closeRejectModal()"
             class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity">
        </div>

        <div x-show="showRejectModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="fixed inset-0 z-10 overflow-x-hidden overflow-y-auto pointer-events-none">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg pointer-events-auto">
                    <form method="POST" action="{{ route('superlinkiu.payment-requests.reject', $invoice) }}" @submit.prevent="confirmReject()">
                        @csrf
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <i data-lucide="x-circle" class="h-6 w-6 text-red-600"></i>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left flex-1">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900">
                                        Rechazar Solicitud
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500 mb-4">
                                            ¿Confirmar rechazo de la solicitud de pago de la factura <span class="font-semibold text-gray-900">#{{ $invoice->invoice_number }}</span>?
                                        </p>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Razón del rechazo <span class="text-red-600">*</span>
                                            </label>
                                            <textarea name="rejection_reason"
                                                      x-model="rejectionReason"
                                                      rows="4"
                                                      required
                                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                                      placeholder="Describe la razón del rechazo..."></textarea>
                                            <p class="text-xs text-gray-500 mt-1">La tienda recibirá esta razón como explicación del rechazo.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                            <button type="submit" 
                                    :disabled="rejectLoading || !rejectionReason.trim()"
                                    class="inline-flex w-full justify-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 disabled:opacity-50 sm:w-auto">
                                <span x-show="!rejectLoading">Confirmar Rechazo</span>
                                <span x-show="rejectLoading" class="flex items-center gap-2">
                                    <i data-lucide="loader" class="size-4 animate-spin"></i>
                                    Procesando...
                                </span>
                            </button>
                            <button type="button" 
                                    @click="closeRejectModal()"
                                    :disabled="rejectLoading"
                                    class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 disabled:opacity-50 sm:mt-0 sm:w-auto">
                                Cancelar
                            </button>
                        </div>
                    </form>
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
function paymentRequestShow() {
    return {
        // Modal Aprobar
        showApproveModal: false,
        approveLoading: false,
        paidDate: new Date().toISOString().split('T')[0],
        paymentNotes: '',

        // Modal Rechazar
        showRejectModal: false,
        rejectLoading: false,
        rejectionReason: '',

        openApproveModal() {
            this.paidDate = new Date().toISOString().split('T')[0];
            this.paymentNotes = '';
            this.showApproveModal = true;
            this.approveLoading = false;
            
            this.$nextTick(() => {
                if (window.createIcons) window.createIcons({ icons: window.lucideIcons });
            });
        },

        closeApproveModal() {
            if (this.approveLoading) return;
            this.showApproveModal = false;
        },

        async confirmApprove() {
            this.approveLoading = true;
            
            try {
                const form = this.$el.closest('form');
                const formData = new FormData(form);
                
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                if (response.redirected) {
                    window.location.href = response.url;
                    return;
                }

                const data = await response.json();
                
                if (!response.ok) {
                    this.approveLoading = false;
                    this.closeApproveModal();
                    
                    if (window.toast) {
                        window.toast.error(
                            '¡Ups! algo salió mal',
                            data.message || 'Error al aprobar el pago',
                            5000,
                            'bottom-center'
                        );
                    }
                    return;
                }
                
                // Redireccionar
                window.location.href = '{{ route('superlinkiu.payment-requests.index') }}';
            } catch (error) {
                this.approveLoading = false;
                this.closeApproveModal();
                
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

        openRejectModal() {
            this.rejectionReason = '';
            this.showRejectModal = true;
            this.rejectLoading = false;
            
            this.$nextTick(() => {
                if (window.createIcons) window.createIcons({ icons: window.lucideIcons });
            });
        },

        closeRejectModal() {
            if (this.rejectLoading) return;
            this.showRejectModal = false;
        },

        async confirmReject() {
            if (!this.rejectionReason.trim()) return;
            
            this.rejectLoading = true;
            
            try {
                const form = this.$el.closest('form');
                const formData = new FormData(form);
                
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                if (response.redirected) {
                    window.location.href = response.url;
                    return;
                }

                const data = await response.json();
                
                if (!response.ok) {
                    this.rejectLoading = false;
                    this.closeRejectModal();
                    
                    if (window.toast) {
                        window.toast.error(
                            '¡Ups! algo salió mal',
                            data.message || 'Error al rechazar la solicitud',
                            5000,
                            'bottom-center'
                        );
                    }
                    return;
                }
                
                // Redireccionar
                window.location.href = '{{ route('superlinkiu.payment-requests.index') }}';
            } catch (error) {
                this.rejectLoading = false;
                this.closeRejectModal();
                
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

<style>
[x-cloak] { display: none !important; }
</style>
@endsection
