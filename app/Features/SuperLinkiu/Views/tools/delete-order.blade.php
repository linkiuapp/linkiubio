@extends('shared::layouts.admin')

@section('title', 'Eliminar Pedido')

@section('content')
<div x-data="deleteOrderTool()" class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Eliminar Pedido</h1>
            <p class="text-sm text-gray-600 mt-1">Herramienta para eliminar pedidos de prueba solicitados por tenant admin</p>
        </div>
    </div>

    {{-- Búsqueda --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <i data-lucide="search" class="w-5 h-5 text-gray-500"></i>
                Buscar Pedido
            </h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tienda</label>
                    <select x-model="storeId" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Seleccionar tienda...</option>
                        @foreach($stores as $store)
                            <option value="{{ $store->id }}">{{ $store->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"># Pedido</label>
                    <input type="text" 
                           x-model="orderNumber" 
                           @keydown.enter="searchOrder()"
                           placeholder="Número o ID del pedido"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div class="flex items-end">
                    <button @click="searchOrder()" 
                            :disabled="!storeId || !orderNumber || searching"
                            class="w-full px-4 py-2.5 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                        <i data-lucide="search" class="w-4 h-4" x-show="!searching"></i>
                        <svg x-show="searching" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="searching ? 'Buscando...' : 'Buscar'"></span>
                    </button>
                </div>
            </div>
            
            <p x-show="searchError" x-text="searchError" class="mt-3 text-sm text-red-600"></p>
        </div>
    </div>

    {{-- Resultado de búsqueda --}}
    <div x-show="order" x-cloak class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-blue-50 px-6 py-4">
            <h2 class="text-lg font-semibold text-blue-900 flex items-center gap-2">
                <i data-lucide="package" class="w-5 h-5"></i>
                Pedido Encontrado
            </h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Pedido</p>
                    <p class="text-lg font-bold text-gray-900" x-text="'#' + order?.order_number"></p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Tienda</p>
                    <p class="text-lg font-bold text-gray-900" x-text="order?.store_name"></p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Cliente</p>
                    <p class="text-lg font-bold text-gray-900" x-text="order?.customer_name || 'N/A'"></p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Total</p>
                    <p class="text-lg font-bold text-green-600" x-text="formatCurrency(order?.total)"></p>
                </div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div>
                    <p class="text-xs text-gray-500">Estado</p>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800" x-text="order?.status_label"></span>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Método de pago</p>
                    <p class="text-sm font-medium text-gray-900" x-text="order?.payment_method"></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Productos</p>
                    <p class="text-sm font-medium text-gray-900" x-text="order?.items_count + ' item(s)'"></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Fecha</p>
                    <p class="text-sm font-medium text-gray-900" x-text="order?.created_at"></p>
                </div>
            </div>
            
            {{-- Motivo de eliminación --}}
            <div class="border-t border-gray-200 pt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i data-lucide="alert-triangle" class="w-4 h-4 inline text-amber-500"></i>
                    Motivo de eliminación <span class="text-red-500">*</span>
                </label>
                <textarea x-model="reason" 
                          rows="3"
                          placeholder="Explica por qué se elimina este pedido (mínimo 10 caracteres)..."
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"></textarea>
                <p class="text-xs text-gray-500 mt-1">Este motivo quedará registrado en el log de auditoría</p>
            </div>
            
            {{-- Botones --}}
            <div class="flex justify-end gap-3 mt-6">
                <button @click="clearSearch()" 
                        class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    Cancelar
                </button>
                <button @click="confirmDelete()" 
                        :disabled="!reason || reason.length < 10 || deleting"
                        class="px-4 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                    <i data-lucide="trash-2" class="w-4 h-4" x-show="!deleting"></i>
                    <svg x-show="deleting" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="deleting ? 'Eliminando...' : 'Eliminar Pedido'"></span>
                </button>
            </div>
        </div>
    </div>

    {{-- Historial de eliminaciones --}}
    @if($deletionLogs->count() > 0)
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <i data-lucide="history" class="w-5 h-5 text-gray-500"></i>
                Últimas Eliminaciones
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pedido</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tienda</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motivo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Eliminado por</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($deletionLogs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $log->order_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $log->store_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $log->customer_name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${{ number_format($log->total, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate" title="{{ $log->reason }}">{{ Str::limit($log->reason, 40) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $log->deletedByUser?->name ?? 'Sistema' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Modal de confirmación --}}
    <div x-show="showConfirmModal" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
         @click="showConfirmModal = false">
    </div>
    
    <div x-show="showConfirmModal" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto pointer-events-none">
        <div class="flex min-h-full items-center justify-center p-4">
            <div x-show="showConfirmModal"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.stop
                 class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6 pointer-events-auto">
                
                <div class="text-center">
                    <div class="w-16 h-16 rounded-full bg-red-100 mx-auto mb-4 flex items-center justify-center">
                        <i data-lucide="alert-triangle" class="w-8 h-8 text-red-600"></i>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-2">¿Eliminar este pedido?</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Pedido <strong x-text="'#' + order?.order_number"></strong> de <strong x-text="order?.store_name"></strong>
                    </p>
                    <p class="text-xs text-red-600 mb-6">Esta acción no se puede deshacer. El pedido se eliminará permanentemente.</p>
                    
                    <div class="flex gap-3">
                        <button @click="showConfirmModal = false" 
                                class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            Cancelar
                        </button>
                        <button @click="executeDelete()" 
                                :disabled="deleting"
                                class="flex-1 px-4 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors disabled:opacity-50">
                            <span x-show="!deleting">Sí, eliminar</span>
                            <span x-show="deleting">Eliminando...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function deleteOrderTool() {
    return {
        storeId: '',
        orderNumber: '',
        order: null,
        reason: '',
        searching: false,
        deleting: false,
        searchError: '',
        showConfirmModal: false,
        
        init() {
            this.$nextTick(() => {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        },
        
        async searchOrder() {
            if (!this.storeId || !this.orderNumber) return;
            
            this.searching = true;
            this.searchError = '';
            this.order = null;
            
            try {
                const response = await fetch('{{ route("superlinkiu.tools.search-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        store_id: this.storeId,
                        order_number: this.orderNumber
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.order = data.order;
                    this.$nextTick(() => {
                        if (typeof lucide !== 'undefined') lucide.createIcons();
                    });
                } else {
                    this.searchError = data.message || 'Pedido no encontrado';
                }
            } catch (error) {
                this.searchError = 'Error de conexión';
            } finally {
                this.searching = false;
            }
        },
        
        clearSearch() {
            this.order = null;
            this.reason = '';
            this.orderNumber = '';
        },
        
        confirmDelete() {
            if (!this.reason || this.reason.length < 10) return;
            this.showConfirmModal = true;
            this.$nextTick(() => {
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });
        },
        
        async executeDelete() {
            this.deleting = true;
            
            try {
                const response = await fetch('{{ route("superlinkiu.tools.delete-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        store_id: this.storeId,
                        order_id: this.order.id,
                        reason: this.reason
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.showConfirmModal = false;
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert('Error: ' + (data.message || 'No se pudo eliminar'));
                }
            } catch (error) {
                alert('Error de conexión');
            } finally {
                this.deleting = false;
            }
        },
        
        formatCurrency(value) {
            if (!value) return '$0';
            return '$' + Number(value).toLocaleString('es-CO', { minimumFractionDigits: 0 });
        }
    }
}
</script>
@endpush
@endsection

