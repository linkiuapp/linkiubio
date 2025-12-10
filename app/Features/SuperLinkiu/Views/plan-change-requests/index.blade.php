@extends('shared::layouts.admin')

@section('title', 'Solicitudes de Cambio de Plan')

@section('content')
<div class="max-w-7xl mx-auto space-y-6" x-data="requestsManager()">
    
    {{-- Header --}}
    <div>
        <h1 class="text-lg font-semibold text-gray-900">Solicitudes de Cambio de Plan</h1>
        <p class="text-sm text-gray-600 mt-1">Administra las solicitudes de cambio de plan de las tiendas</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Pendientes</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                </div>
                <i data-lucide="clock" class="w-10 h-10 text-yellow-500"></i>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Aprobadas</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</p>
                </div>
                <i data-lucide="check-circle" class="w-10 h-10 text-green-500"></i>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Rechazadas</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
                </div>
                <i data-lucide="x-circle" class="w-10 h-10 text-red-500"></i>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex gap-2">
            <a href="?status=pending" 
               class="px-4 py-2 rounded-lg text-sm font-medium {{ $status === 'pending' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Pendientes
            </a>
            <a href="?status=approved" 
               class="px-4 py-2 rounded-lg text-sm font-medium {{ $status === 'approved' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Aprobadas
            </a>
            <a href="?status=rejected" 
               class="px-4 py-2 rounded-lg text-sm font-medium {{ $status === 'rejected' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Rechazadas
            </a>
            <a href="?status=all" 
               class="px-4 py-2 rounded-lg text-sm font-medium {{ $status === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Todas
            </a>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        @if($requests->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Tienda</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Cambio</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Estado</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($requests as $req)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $req->store->name }}</p>
                                <p class="text-xs text-gray-500">{{ $req->store->slug }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <p class="text-gray-600">De: <strong>{{ $req->currentPlan->name }}</strong></p>
                                <p class="text-gray-900">A: <strong class="text-blue-600">{{ $req->requestedPlan->name }}</strong></p>
                                @if($req->requested_billing_period)
                                <p class="text-xs text-gray-500 mt-1">
                                    Período: {{ ucfirst($req->requested_billing_period) }}
                                </p>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold
                                {{ $req->type === 'upgrade' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $req->type === 'upgrade' ? 'Mejora' : 'Cambio' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $req->requested_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold
                                @if($req->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($req->status === 'approved') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                @if($req->status === 'pending')
                                    <i data-lucide="clock" class="w-3 h-3"></i>
                                    Pendiente
                                @elseif($req->status === 'approved')
                                    <i data-lucide="check-circle" class="w-3 h-3"></i>
                                    Aprobada
                                @else
                                    <i data-lucide="x-circle" class="w-3 h-3"></i>
                                    Rechazada
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($req->isPending())
                            <div class="flex items-center justify-end gap-2">
                                <button @click="openApproveModal({{ $req->id }}, '{{ $req->store->name }}', '{{ $req->currentPlan->name }}', '{{ $req->requestedPlan->name }}', '{{ $req->requested_billing_period ?? 'N/A' }}')"
                                        class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                        title="Aprobar">
                                    <i data-lucide="check" class="w-4 h-4"></i>
                                </button>
                                <button @click="openRejectModal({{ $req->id }}, '{{ $req->store->name }}')"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Rechazar">
                                    <i data-lucide="x" class="w-4 h-4"></i>
                                </button>
                            </div>
                            @else
                            <span class="text-xs text-gray-500">
                                {{ $req->processed_at->format('d/m/Y') }}
                            </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if($requests->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $requests->links() }}
        </div>
        @endif
        @else
        <div class="px-6 py-12 text-center">
            <i data-lucide="inbox" class="w-12 h-12 text-gray-300 mx-auto mb-3"></i>
            <p class="text-gray-600">No hay solicitudes en este estado</p>
        </div>
        @endif
    </div>

    {{-- Modal Aprobar --}}
    <div x-show="showApproveModal"
         x-transition:enter="transition-opacity duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
         @click="showApproveModal = false"
         style="display: none;"
         x-cloak></div>

    <div x-show="showApproveModal"
         x-transition:enter="transition-opacity duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
         style="display: none;"
         x-cloak>
        <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
            <div @click.stop class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto">
                <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800">¿Aprobar cambio de plan?</h3>
                    <button @click="showApproveModal = false" class="size-8 inline-flex justify-center items-center rounded-full bg-gray-100 text-gray-800 hover:bg-gray-200">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>

                <div class="p-4 overflow-y-auto">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <div class="size-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i data-lucide="check-circle" class="size-5 text-green-600"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-800 mb-3">
                                Se aprobará el cambio de plan para <strong x-text="selectedStoreName"></strong>
                            </p>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-sm">
                                <p class="text-gray-700">
                                    De: <strong x-text="currentPlanName"></strong>
                                </p>
                                <p class="text-gray-700">
                                    A: <strong class="text-blue-600" x-text="requestedPlanName"></strong>
                                </p>
                                <p class="text-gray-600 text-xs mt-1" x-show="requestedBillingPeriod !== 'N/A'">
                                    Período: <strong x-text="requestedBillingPeriod"></strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200">
                    <button type="button"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50"
                            @click="showApproveModal = false">
                        Cancelar
                    </button>
                    <button type="button"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-green-600 text-white hover:bg-green-700"
                            @click="confirmApprove()">
                        Sí, aprobar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Rechazar --}}
    <div x-show="showRejectModal"
         x-transition:enter="transition-opacity duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
         @click="showRejectModal = false"
         style="display: none;"
         x-cloak></div>

    <div x-show="showRejectModal"
         x-transition:enter="transition-opacity duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
         style="display: none;"
         x-cloak>
        <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
            <div @click.stop class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto">
                <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800">Rechazar Solicitud</h3>
                    <button @click="showRejectModal = false" class="size-8 inline-flex justify-center items-center rounded-full bg-gray-100 text-gray-800 hover:bg-gray-200">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>

                <form @submit.prevent="submitReject" class="p-4">
                    <p class="text-sm text-gray-700 mb-4">
                        Rechazando solicitud de <strong x-text="selectedStoreName"></strong>
                    </p>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Razón del rechazo <span class="text-red-500">*</span>
                        </label>
                        <textarea x-model="rejectReason"
                                  rows="3"
                                  required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-red-500 focus:ring-2 focus:ring-red-200 focus:outline-none text-sm"
                                  placeholder="Explica por qué se rechaza..."></textarea>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button"
                                @click="showRejectModal = false"
                                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium">
                            Cancelar
                        </button>
                        <button type="submit"
                                :disabled="!rejectReason"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 disabled:bg-gray-300 text-white rounded-lg text-sm font-medium">
                            Rechazar Solicitud
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function requestsManager() {
    return {
        showApproveModal: false,
        showRejectModal: false,
        selectedRequestId: null,
        selectedStoreName: '',
        currentPlanName: '',
        requestedPlanName: '',
        requestedBillingPeriod: '',
        rejectReason: '',

        openApproveModal(requestId, storeName, currentPlan, requestedPlan, billingPeriod) {
            this.selectedRequestId = requestId;
            this.selectedStoreName = storeName;
            this.currentPlanName = currentPlan;
            this.requestedPlanName = requestedPlan;
            this.requestedBillingPeriod = billingPeriod;
            this.showApproveModal = true;
            
            this.$nextTick(() => {
                if (window.createIcons && window.lucideIcons) {
                    window.createIcons({ icons: window.lucideIcons });
                }
            });
        },

        async confirmApprove() {

            try {
                const response = await fetch(`/superlinkiu/plan-change-requests/${this.selectedRequestId}/approve`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                });

                const data = await response.json();

                if (data.success) {
                    this.showApproveModal = false;
                    if (window.toast) {
                        window.toast.success('Solicitud aprobada', data.message, 3000, 'bottom-center');
                    }
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    if (window.toast) {
                        window.toast.error('Error', data.message, 5000, 'bottom-center');
                    }
                }
            } catch (error) {
                if (window.toast) {
                    window.toast.error('Error', 'No se pudo aprobar la solicitud', 5000, 'bottom-center');
                }
            }
        },

        openRejectModal(requestId, storeName) {
            this.selectedRequestId = requestId;
            this.selectedStoreName = storeName;
            this.rejectReason = '';
            this.showRejectModal = true;
            
            this.$nextTick(() => {
                if (window.createIcons && window.lucideIcons) {
                    window.createIcons({ icons: window.lucideIcons });
                }
            });
        },

        async submitReject() {
            if (!this.rejectReason) return;

            try {
                const response = await fetch(`/superlinkiu/plan-change-requests/${this.selectedRequestId}/reject`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        reason: this.rejectReason
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.showRejectModal = false;
                    if (window.toast) {
                        window.toast.success('Solicitud rechazada', data.message, 3000, 'bottom-center');
                    }
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    if (window.toast) {
                        window.toast.error('Error', data.message, 5000, 'bottom-center');
                    }
                }
            } catch (error) {
                if (window.toast) {
                    window.toast.error('Error', 'No se pudo rechazar la solicitud', 5000, 'bottom-center');
                }
            }
        }
    }
}

// Inicializar iconos
document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>

<style>
[x-cloak] { display: none !important; }
</style>
@endsection

