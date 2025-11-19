<x-tenant-admin-layout :store="$store">
@section('title', 'Pedido #' . $order->order_number)

@section('content')
<div class="max-w-6xl mx-auto print-container" x-data="orderDetail" x-init="init()">
    <!-- Componente de recibo POS (oculto, solo para generar PDF) -->
    <div id="order-receipt-pos" style="display: none; position: absolute; left: -9999px;">
        <x-order-receipt-pos :order="$order" :store="$store" />
    </div>
    
    <!-- Header normal (oculto al imprimir) -->
    <div class="mb-6 print-header no-print">
        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('tenant.admin.orders.index', $store->slug) }}" 
               class="text-gray-600 hover:text-gray-700">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            <h1 class="text-lg font-semibold text-gray-900">Pedido #{{ $order->order_number }}</h1>
            @php
                $statusBadgeType = match($order->status) {
                    'pending' => 'warning',
                    'confirmed' => 'info',
                    'preparing' => 'info',
                    'shipped' => 'info',
                    'delivered' => 'success',
                    'cancelled' => 'error',
                    default => 'secondary'
                };
            @endphp
            <x-badge-soft :type="$statusBadgeType" :text="$order->status_label" />
        </div>
        <p class="text-sm text-gray-600">
            Creado el {{ $order->created_at->format('d/m/Y \a \l\a\s H:i') }} 
            ({{ $order->created_at->diffForHumans() }})
        </p>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 no-print">
        
        <!-- Columna Principal -->
        <div class="xl:col-span-2 space-y-6 print-section">
            
            <!-- Información del Cliente -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Información del Cliente</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Nombre</label>
                        <div class="text-sm text-gray-900">{{ $order->customer_name }}</div>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Teléfono</label>
                        <div class="text-sm text-gray-900">
                            <a href="https://wa.me/57{{ preg_replace('/\D/', '', $order->customer_phone) }}" 
                               target="_blank" class="text-green-600 hover:text-green-700 flex items-center gap-1">
                                {{ $order->customer_phone }}
                                <i data-lucide="message-circle" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                    @if($order->customer_address)
                    <div class="lg:col-span-2">
                        <label class="block text-xs text-gray-600 mb-1">Dirección</label>
                        <div class="text-sm text-gray-900">{{ $order->customer_address }}</div>
                    </div>
                    @endif
                    @if($order->department)
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Departamento</label>
                        <div class="text-sm text-gray-900">{{ $order->department }}</div>
                    </div>
                    @endif
                    @if($order->city)
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Ciudad</label>
                        <div class="text-sm text-gray-900">{{ $order->city }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Productos del Pedido -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Productos ({{ $order->items->count() }})</h3>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center p-4 bg-white rounded-lg border border-gray-200">
                            <div class="w-12 h-12 rounded-lg flex-shrink-0 border border-gray-200 overflow-hidden bg-gray-100 relative mr-4">
                                @if($item->product && $item->product->main_image_url)
                                    <img src="{{ $item->product->main_image_url }}" 
                                         alt="{{ $item->product_name }}" 
                                         class="w-full h-full object-cover"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                @endif
                                <div class="w-full h-full {{ $item->product && $item->product->main_image_url ? 'hidden' : 'flex' }} items-center justify-center absolute inset-0">
                                    <i data-lucide="package" class="w-6 h-6 text-gray-500"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-semibold text-gray-900">{{ $item->product_name }}</div>
                                @if($item->variant_details)
                                    <div class="text-xs text-gray-600">{{ $item->formatted_variants }}</div>
                                @endif
                                @if($item->product)
                                    <a href="{{ route('tenant.admin.products.show', [$store->slug, $item->product->id]) }}" 
                                       class="text-xs text-blue-600 hover:text-blue-700">
                                        Ver producto
                                    </a>
                                @endif
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-900">Cant: {{ $item->quantity }}</div>
                                <div class="text-sm text-gray-600">${{ number_format($item->unit_price, 0, ',', '.') }} c/u</div>
                                <div class="text-sm font-semibold text-gray-900">${{ number_format($item->item_total, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Resumen del Pedido -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Resumen</h3>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="text-gray-900">${{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @if($order->shipping_cost > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Envío:</span>
                            <span class="text-gray-900">${{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    @if($order->coupon_discount > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Descuento:</span>
                            <span class="text-green-600">-${{ number_format($order->coupon_discount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="border-t border-gray-200 pt-3">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-gray-900">Total:</span>
                            <span class="text-lg font-semibold text-blue-600">${{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historial de Estados -->
            @if($order->statusHistory && $order->statusHistory->count() > 0)
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Historial de Estados</h3>
                <div class="space-y-4">
                    @foreach($order->statusHistory as $history)
                        <div class="flex">
                            <div class="flex-shrink-0 w-8 h-8 {{ $history->status_color }} rounded-full flex items-center justify-center mr-3">
                                <i data-lucide="check-circle" class="w-4 h-4 text-white"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm text-gray-900">{{ $history->status_change }}</div>
                                @if($history->notes)
                                    <div class="text-xs text-gray-600 mt-1">{{ $history->notes }}</div>
                                @endif
                                <div class="text-xs text-gray-500">
                                    Por: {{ $history->changed_by }} • {{ $history->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6 print-hide">
            
            <!-- Información de Entrega -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Entrega</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Tipo</label>
                        <div class="flex items-center text-sm">
                            @if(in_array($order->delivery_type, ['domicilio', 'local', 'national']))
                                <i data-lucide="truck" class="w-4 h-4 text-blue-600 mr-2"></i>
                                <span class="text-gray-900">
                                    @if($order->delivery_type === 'national')
                                        Envío Nacional
                                    @else
                                        Domicilio
                                    @endif
                                </span>
                            @else
                                <i data-lucide="store" class="w-4 h-4 text-gray-600 mr-2"></i>
                                <span class="text-gray-900">Pickup en Tienda</span>
                            @endif
                        </div>
                    </div>
                    
                    @if(in_array($order->delivery_type, ['domicilio', 'local', 'national']))
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Costo de Envío</label>
                            <div class="text-sm text-gray-900">
                                @if($order->shipping_cost > 0)
                                    ${{ number_format($order->shipping_cost, 0, ',', '.') }}
                                @else
                                    <span class="text-green-600">Gratis</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Información de Pago -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Pago</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Método</label>
                        <div class="flex items-center text-sm">
                            @if($order->payment_method === 'transferencia' || $order->payment_method === 'bank_transfer')
                                <i data-lucide="credit-card" class="w-4 h-4 text-blue-600 mr-2"></i>
                                <span class="text-gray-900">Transferencia Bancaria</span>
                            @elseif($order->payment_method === 'contra_entrega')
                                <i data-lucide="wallet" class="w-4 h-4 text-yellow-600 mr-2"></i>
                                <span class="text-gray-900">Pago Contra Entrega</span>
                            @elseif($order->payment_method === 'efectivo' || $order->payment_method === 'cash')
                                <i data-lucide="dollar-sign" class="w-4 h-4 text-green-600 mr-2"></i>
                                <span class="text-gray-900">Efectivo</span>
                            @else
                                <i data-lucide="credit-card" class="w-4 h-4 text-blue-600 mr-2"></i>
                                <span class="text-gray-900">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                            @endif
                        </div>
                    </div>

                    @if($order->payment_proof_path)
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Comprobante</label>
                            <div class="flex items-center gap-3">
                                <div class="flex items-center">
                                    <i data-lucide="file-text" class="w-4 h-4 text-green-600 mr-2"></i>
                                    <a href="{{ route('tenant.admin.orders.download-payment-proof', [$store->slug, $order->id]) }}" 
                                       class="text-sm text-blue-600 hover:text-blue-700"
                                       target="_blank">
                                        Descargar comprobante
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Cambiar Estado -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Cambiar Estado</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs text-gray-700 mb-2">Nuevo Estado</label>
                        <select x-model="newStatus" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900">
                            <option value="">Seleccionar estado</option>
                            @foreach(['pending' => 'Pendiente', 'confirmed' => 'Confirmado', 'preparing' => 'Preparando', 'shipped' => 'Enviado', 'delivered' => 'Entregado', 'cancelled' => 'Cancelado'] as $status => $label)
                                @if($status !== $order->status)
                                    <option value="{{ $status }}">{{ $label }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-700 mb-2">Notas (Opcional)</label>
                        <textarea x-model="statusNotes" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 placeholder-gray-400"
                                  placeholder="Observaciones sobre el cambio de estado..."></textarea>
                    </div>
                    <button type="button" @click="showStatusModal = true" :disabled="!newStatus" 
                            class="w-full px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors flex items-center justify-center gap-2 text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                        Actualizar Estado
                    </button>
                </div>
            </div>

            <!-- Notas del Pedido -->
            @if($order->notes)
                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                    <h3 class="text-sm font-medium text-gray-700 mb-4">Notas</h3>
                    <div class="text-sm text-gray-900">{{ $order->notes }}</div>
                </div>
            @endif

            <!-- Acciones Rápidas -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Acciones</h3>
                <div class="space-y-3">
                    @if($order->canBeEdited())
                        <a href="{{ route('tenant.admin.orders.edit', [$store->slug, $order->id]) }}" 
                           class="w-full flex items-center justify-center px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors text-sm"
                           title="Editar pedido">
                            <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                            Editar Pedido
                        </a>
                    @endif
                    
                    <button onclick="printOrder()" 
                            class="w-full flex items-center justify-center px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors text-sm"
                            title="Descargar PDF del pedido">
                        <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                        Descargar PDF
                    </button>
                    
                    <a href="https://wa.me/57{{ preg_replace('/\D/', '', $order->customer_phone) }}?text=Hola {{ $order->customer_name }}, te contactamos sobre tu pedido #{{ $order->order_number }}" 
                       target="_blank" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm"
                       title="Contactar por WhatsApp">
                        <i data-lucide="message-circle" class="w-4 h-4 mr-2"></i>
                        Contactar por WhatsApp
                    </a>
                    
                    @if(!in_array($order->status, ['delivered', 'cancelled']))
                        <button @click="showCancelModal = true" 
                                class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm"
                                title="Cancelar pedido">
                            <i data-lucide="x-circle" class="w-4 h-4 mr-2"></i>
                            Cancelar Pedido
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de confirmación de cambio de estado --}}
    <div x-show="showStatusModal" 
         x-cloak
         style="display: none;"
         x-transition:enter="transition-opacity duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.away="showStatusModal = false"
         @keydown.escape.window="showStatusModal = false"
         class="fixed inset-0 z-[9999] overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showStatusModal = false"></div>
            <div class="relative bg-white rounded-lg max-w-md w-full p-6 border border-gray-200 shadow-xl" 
                 @click.stop
                 x-transition:enter="transition-all ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition-all ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">
                <!-- Botón X para cerrar -->
                <button @click="showStatusModal = false" 
                        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="refresh-cw" class="w-6 h-6 text-blue-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Confirmar cambio de estado</h3>
                    <p class="text-gray-600 mb-2">
                        ¿Cambiar el estado del pedido <strong>#{{ $order->order_number }}</strong> a:
                    </p>
                    <p class="text-sm text-blue-600 font-medium mb-6" x-text="getStatusLabel(newStatus)"></p>
                    <div class="flex gap-3 justify-center">
                        <button @click="showStatusModal = false" 
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button @click="confirmStatusUpdate()" 
                                class="px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-colors">
                            Confirmar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de confirmación de cancelación --}}
    <div x-show="showCancelModal" 
         x-cloak
         style="display: none;"
         x-transition:enter="transition-opacity duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.away="showCancelModal = false"
         @keydown.escape.window="showCancelModal = false"
         class="fixed inset-0 z-[9999] overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showCancelModal = false"></div>
            <div class="relative bg-white rounded-lg max-w-md w-full p-6 border border-gray-200 shadow-xl" 
                 @click.stop
                 x-transition:enter="transition-all ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition-all ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">
                <!-- Botón X para cerrar -->
                <button @click="showCancelModal = false" 
                        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Confirmar cancelación</h3>
                    <p class="text-gray-600 mb-6">
                        ¿Estás seguro de que deseas cancelar el pedido <strong>#{{ $order->order_number }}</strong>?
                        Esta acción no se puede deshacer.
                    </p>
                    <div class="flex gap-3 justify-center">
                        <button @click="showCancelModal = false" 
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            No, Volver
                        </button>
                        <button @click="confirmCancel()" 
                                class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                            Sí, Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerta de error -->
    <div x-show="showErrorAlert" 
         x-cloak
         class="fixed bottom-4 right-4 z-50 max-w-md"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2">
        <div x-show="errorMessage">
            <x-alert-bordered 
                type="error" 
                title="Error">
                <span x-text="errorMessage"></span>
            </x-alert-bordered>
        </div>
    </div>
</div>

@push('styles')
<style>
@media print {
    /* Ocultar elementos del layout principal */
    body > main,
    body > aside,
    body > header,
    body > nav,
    body > footer {
        display: none !important;
    }
    
    /* Mostrar el contenedor principal */
    .print-container {
        display: block !important;
        visibility: visible !important;
        position: relative !important;
    }
    
    /* Ocultar elementos del layout */
    aside,
    .sidebar,
    nav,
    header,
    footer,
    .navbar,
    .tenant-navbar,
    .admin-navbar,
    .admin-footer,
    
    /* Ocultar elementos de la vista - pero NO print-only */
    .no-print:not(.print-only),
    button,
    a[href]:not(.print-link),
    .print-hide,
    .xl\\:col-span-2,
    [x-data]:not(.print-only),
    [x-show]:not(.print-only),
    [x-cloak]:not(.print-only),
    .fixed,
    .absolute,
    .print-section,
    .print-header {
        display: none !important;
        visibility: hidden !important;
    }
    
    /* Ocultar todos los hijos directos del contenedor excepto print-only */
    .print-container > .print-header,
    .print-container > .grid {
        display: none !important;
        visibility: hidden !important;
    }
    
    /* Asegurar que no-print no oculte print-only */
    .print-container > .no-print:not(.print-only) {
        display: none !important;
        visibility: hidden !important;
    }
    
    /* Mostrar solo la vista POS durante la impresión */
    /* El estilo inline display:none se mantiene, pero @media print lo sobrescribe */
    .print-only {
        display: block !important;
        visibility: visible !important;
        position: relative !important;
        width: 100% !important;
        max-width: 70mm !important;
        margin: 0 auto !important;
        opacity: 1 !important;
    }
    
    /* Sobrescribir cualquier estilo inline durante impresión */
    .print-only[style*="display: none"],
    .print-only[style*="display:none"] {
        display: block !important;
    }
    
    /* Asegurar que todos los hijos de print-only sean visibles */
    .print-only * {
        visibility: visible !important;
    }
    
    /* Asegurar que no-print no afecte a print-only durante impresión */
    .print-only.no-print {
        display: block !important;
    }
    
    /* Asegurar que el contenedor muestre print-only */
    .print-container .print-only {
        display: block !important;
        visibility: visible !important;
    }
    
    /* Ajustar display de elementos dentro de print-only */
    .print-only table {
        display: table !important;
        width: 100% !important;
    }
    
    .print-only tr {
        display: table-row !important;
    }
    
    .print-only td,
    .print-only th {
        display: table-cell !important;
    }
    
    .print-only .flex {
        display: flex !important;
    }
    
    .print-only div,
    .print-only p,
    .print-only span,
    .print-only h1,
    .print-only h2,
    .print-only h3 {
        display: block !important;
    }
    
    /* Resetear layout para impresión */
    * {
        box-shadow: none !important;
        text-shadow: none !important;
    }
    
    /* Estilos para impresión tipo POS */
    @page {
        size: 80mm auto; /* Tamaño estándar de recibo térmico */
        margin: 5mm;
    }
    
    html, body {
        background: white !important;
        font-family: 'Courier New', monospace !important;
        font-size: 10pt;
        line-height: 1.3;
        color: #000 !important;
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        height: auto !important;
    }
    
    body {
        padding: 10mm !important;
        display: flex !important;
        justify-content: center !important;
        align-items: flex-start !important;
    }
    
    /* Contenedor principal - ocultar todo excepto print-only */
    .print-container {
        display: block !important;
        width: 70mm !important;
        max-width: 70mm !important;
        margin: 0 auto !important;
        padding: 0 !important;
    }
    
    /* Ocultar todos los hijos directos del contenedor excepto print-only */
    .print-container > .no-print,
    .print-container > .print-header,
    .print-container > .grid {
        display: none !important;
    }
    
    /* Mostrar solo print-only */
    .print-only {
        display: block !important;
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .print-only h1 {
        font-size: 14pt;
        font-weight: bold;
        margin: 0 0 4px 0;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .print-only p {
        margin: 2px 0;
        font-size: 9pt;
    }
    
    .print-only .text-xs {
        font-size: 9pt !important;
    }
    
    .print-only .text-sm {
        font-size: 10pt !important;
    }
    
    /* Separadores */
    .print-only .border-t {
        border-top: 1px solid #000 !important;
    }
    
    .print-only .border-dashed {
        border-style: dashed !important;
    }
    
    /* Tabla de productos */
    .print-only table {
        width: 100%;
        border-collapse: collapse;
        margin: 4px 0;
        font-size: 9pt;
    }
    
    .print-only table th {
        border-bottom: 1px solid #000;
        padding: 3px 0;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 8pt;
    }
    
    .print-only table td {
        padding: 2px 0;
        border-bottom: 1px dashed #666;
    }
    
    .print-only table tr:last-child td {
        border-bottom: none;
    }
    
    /* Totales */
    .print-only .font-bold {
        font-weight: bold;
    }
    
    .print-only .font-semibold {
        font-weight: 600;
    }
    
    /* Ocultar iconos y elementos decorativos */
    [data-lucide],
    i[data-lucide],
    .lucide,
    img {
        display: none !important;
    }
    
    /* Links */
    a {
        color: #000 !important;
        text-decoration: none !important;
    }
    
    /* Evitar saltos de página */
    .print-only {
        page-break-inside: avoid;
    }
    
    /* Ajustes de espaciado */
    .print-only .mb-1 {
        margin-bottom: 3px !important;
    }
    
    .print-only .mb-2 {
        margin-bottom: 6px !important;
    }
    
    .print-only .mb-3 {
        margin-bottom: 9px !important;
    }
    
    .print-only .mb-4 {
        margin-bottom: 12px !important;
    }
    
    .print-only .my-2 {
        margin-top: 6px !important;
        margin-bottom: 6px !important;
    }
    
    .print-only .mt-4 {
        margin-top: 12px !important;
    }
    
    /* Centrado de texto */
    .print-only .text-center {
        text-align: center !important;
    }
    
    /* Alineación */
    .print-only .text-left {
        text-align: left !important;
    }
    
    .print-only .text-right {
        text-align: right !important;
    }
    
    /* Flexbox para alineación */
    .print-only .flex {
        display: flex !important;
    }
    
    .print-only .justify-between {
        justify-content: space-between !important;
    }
    
    /* Bordes */
    .print-only .border-t-2 {
        border-top: 2px solid #000 !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('orderDetail', () => ({
        newStatus: '',
        statusNotes: '',
        showStatusModal: false,
        showCancelModal: false,
        showErrorAlert: false,
        errorMessage: '',

        init() {
            // Forzar cierre de modales al inicio - asegurar que estén cerrados
            this.showCancelModal = false;
            this.showStatusModal = false;
            this.showErrorAlert = false;
            this.newStatus = '';
            this.statusNotes = '';
            this.errorMessage = '';
            
            // Asegurar que los modales estén cerrados en el DOM
            Alpine.nextTick(() => {
                // Cerrar cualquier modal que pueda estar abierto
                if (this.showStatusModal) this.showStatusModal = false;
                if (this.showCancelModal) this.showCancelModal = false;
                
                // Inicializar iconos Lucide
                if (typeof lucide !== 'undefined' && lucide.createIcons) {
                    lucide.createIcons();
                }
            });
        },

        getStatusLabel(status) {
            const labels = {
                'pending': 'Pendiente',
                'confirmed': 'Confirmado', 
                'preparing': 'Preparando',
                'shipped': 'Enviado',
                'delivered': 'Entregado',
                'cancelled': 'Cancelado'
            };
            return labels[status] || status;
        },

        confirmStatusUpdate() {
            if (!this.newStatus) return;

            // Cerrar modal inmediatamente antes de hacer la petición
            this.showStatusModal = false;
            
            // Deshabilitar botones mientras procesa
            const confirmBtn = event?.target || document.querySelector('[x-on\\:click*="confirmStatusUpdate"]');
            if (confirmBtn) {
                confirmBtn.disabled = true;
            }

            fetch(`{{ route('tenant.admin.orders.update-status', [$store->slug, $order->id]) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    status: this.newStatus,
                    notes: this.statusNotes
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cerrar modal inmediatamente
                    this.showStatusModal = false;
                    this.newStatus = '';
                    this.statusNotes = '';
                    
                    // Recargar después de un breve delay para permitir animación de cierre
                    setTimeout(() => {
                        window.location.reload();
                    }, 200);
                } else {
                    this.errorMessage = data.message || 'Error al cambiar estado';
                    this.showErrorAlert = true;
                    setTimeout(() => { this.showErrorAlert = false; }, 5000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.errorMessage = 'Error de conexión. Por favor, intenta nuevamente.';
                this.showErrorAlert = true;
                setTimeout(() => { this.showErrorAlert = false; }, 5000);
            });
        },

        confirmCancel() {
            // Cerrar modal inmediatamente
            this.showCancelModal = false;
            
            // Deshabilitar botones mientras procesa
            const confirmBtn = event?.target || document.querySelector('[x-on\\:click*="confirmCancel"]');
            if (confirmBtn) {
                confirmBtn.disabled = true;
            }

            // Cambiar estado a cancelled en lugar de eliminar
            fetch(`{{ route('tenant.admin.orders.update-status', [$store->slug, $order->id]) }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    status: 'cancelled'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Asegurar que el modal esté cerrado
                    this.showCancelModal = false;
                    
                    // Recargar después de un breve delay para permitir animación de cierre
                    setTimeout(() => {
                        window.location.reload();
                    }, 200);
                } else {
                    this.errorMessage = data.message || 'Error al cancelar pedido';
                    this.showErrorAlert = true;
                    setTimeout(() => { this.showErrorAlert = false; }, 5000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.errorMessage = 'Error de conexión. Por favor, intenta nuevamente.';
                this.showErrorAlert = true;
                setTimeout(() => { this.showErrorAlert = false; }, 5000);
            });
        }
    }));
});

function printOrder() {
    // Cargar html2pdf.js dinámicamente si no está cargado
    if (typeof html2pdf === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js';
        script.onload = function() {
            generatePDF();
        };
        document.head.appendChild(script);
    } else {
        generatePDF();
    }
    
    function generatePDF() {
        const receiptElement = document.getElementById('order-receipt-pos');
        if (!receiptElement) {
            alert('Error: No se encontró el contenedor del recibo');
            return;
        }
        
        // Obtener el contenido del componente
        const receiptContent = receiptElement.querySelector('.order-receipt-pos');
        if (!receiptContent) {
            alert('Error: No se encontró el contenido del recibo. Verifica la consola para más detalles.');
            console.error('Elemento order-receipt-pos no encontrado en:', receiptElement);
            return;
        }
        
        // Crear un contenedor temporal completamente visible en la pantalla
        const tempContainer = document.createElement('div');
        tempContainer.id = 'temp-pdf-container';
        tempContainer.style.position = 'fixed';
        tempContainer.style.left = '0';
        tempContainer.style.top = '0';
        tempContainer.style.width = '120mm';
        tempContainer.style.zIndex = '99999';
        tempContainer.style.backgroundColor = 'white';
        tempContainer.style.visibility = 'visible';
        tempContainer.style.display = 'block';
        tempContainer.style.opacity = '1';
        tempContainer.style.overflow = 'visible';
        
        // Clonar el contenido completo con todos sus estilos
        const clonedContent = receiptContent.cloneNode(true);
        
        // Asegurar que el contenido clonado tenga todos los estilos necesarios
        clonedContent.style.display = 'block';
        clonedContent.style.visibility = 'visible';
        clonedContent.style.opacity = '1';
        clonedContent.style.width = '120mm';
        clonedContent.style.backgroundColor = 'white';
        clonedContent.style.position = 'relative';
        clonedContent.style.left = '0';
        clonedContent.style.top = '0';
        
        // Asegurar que todos los elementos hijos sean visibles
        const allChildren = clonedContent.querySelectorAll('*');
        allChildren.forEach(child => {
            child.style.visibility = 'visible';
            if (child.style.display === 'none') {
                child.style.display = '';
            }
            if (child.style.opacity === '0' || child.style.opacity === '') {
                child.style.opacity = '1';
            }
        });
        
        tempContainer.appendChild(clonedContent);
        document.body.appendChild(tempContainer);
        
        // Esperar a que el contenido se renderice completamente
        setTimeout(() => {
            // Verificar que el contenido tenga texto
            const textContent = clonedContent.textContent || clonedContent.innerText;
            if (!textContent || textContent.trim().length === 0) {
                alert('Error: El contenido del recibo está vacío');
                document.body.removeChild(tempContainer);
                return;
            }
            
            console.log('Generando PDF con contenido de', textContent.length, 'caracteres');
            console.log('Dimensiones del contenido:', clonedContent.scrollWidth, 'x', clonedContent.scrollHeight);
            
            // Opciones para el PDF
            const opt = {
                margin: [0, 0, 0, 0],
                filename: 'pedido-{{ $order->order_number }}.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { 
                    scale: 2,
                    useCORS: true,
                    letterRendering: true,
                    logging: true,
                    allowTaint: false,
                    backgroundColor: '#ffffff',
                    width: clonedContent.scrollWidth || 264,
                    height: clonedContent.scrollHeight || 1000,
                    x: 0,
                    y: 0
                },
                jsPDF: { 
                    unit: 'mm', 
                    format: [120, 500],
                    orientation: 'portrait'
                },
                pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
            };
            
            // Generar y descargar el PDF desde el contenedor temporal
            html2pdf().set(opt).from(tempContainer).save().then(() => {
                console.log('PDF generado exitosamente');
                // Limpiar el contenedor temporal
                if (tempContainer.parentNode) {
                    document.body.removeChild(tempContainer);
                }
            }).catch((error) => {
                console.error('Error al generar PDF:', error);
                alert('Error al generar el PDF: ' + error.message);
                // Limpiar el contenedor temporal incluso si hay error
                if (tempContainer.parentNode) {
                    document.body.removeChild(tempContainer);
                }
            });
        }, 500);
    }
}
</script>
@endpush
@endsection
</x-tenant-admin-layout>