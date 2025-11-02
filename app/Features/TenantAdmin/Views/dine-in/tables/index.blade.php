<x-tenant-admin-layout :store="$store">
@section('title', $type === 'mesa' ? 'Consumo en Local - Mesas' : 'Servicio a Habitación')

@section('content')
<div class="space-y-4">
    <div x-data="tablesManager({{ json_encode([
        'storeSlug' => $store->slug,
        'type' => $type,
        'dineInSettings' => $dineInSettings,
        'tables' => $tables->map(function($table) {
            // Obtener room_id: puede venir de is_from_room_system (virtual) o de room_id directo (Table real)
            $roomId = null;
            if (isset($table->room_id)) {
                $roomId = $table->room_id;
            } elseif (isset($table->is_from_room_system) && $table->is_from_room_system && isset($table->room_id)) {
                $roomId = $table->room_id;
            }
            
            // Determinar ID: si es Table real (no virtual), usar su ID; si es virtual, usar 0
            $tableId = 0;
            if (isset($table->id)) {
                // Si no es virtual (tiene ID real y no es string "room_"), usar el ID
                if (!is_string($table->id) || !str_starts_with($table->id, 'room_')) {
                    $tableId = (int) $table->id;
                }
            }
            
            // Asegurar que qr_code y qr_url estén disponibles (pueden ser null si es virtual)
            $qrCode = null;
            $qrUrl = null;
            
            // Si es un objeto Table (real), obtener los valores directamente
            if (is_object($table) && method_exists($table, 'getAttribute')) {
                $qrCode = $table->qr_code ?? null;
                $qrUrl = $table->qr_url ?? null;
            } elseif (isset($table->qr_code)) {
                $qrCode = $table->qr_code;
            }
            if (isset($table->qr_url)) {
                $qrUrl = $table->qr_url;
            }
            
            return [
                'id' => $tableId,
                'table_number' => $table->table_number ?? null,
                'qr_code' => $qrCode,
                'qr_url' => $qrUrl,
                'room_id' => $roomId,
            ];
        })
    ]) }})">
        <!-- Header -->
        <div class="bg-accent-50 rounded-lg p-0 overflow-hidden">
            <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-black-500 mb-2">
                            {{ $type === 'mesa' ? 'Consumo en Local - Mesas' : 'Servicio a Habitación - Habitaciones' }}
                        </h2>
                        <p class="text-sm text-black-300">
                            Gestiona las {{ $type === 'mesa' ? 'mesas' : 'habitaciones' }} para pedidos en {{ $type === 'mesa' ? 'local' : 'habitación' }}
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a 
                            href="{{ route('tenant.admin.dine-in.dashboard', ['store' => $store->slug, 'type' => $type]) }}" 
                            class="px-4 py-2 bg-primary-200 hover:bg-primary-300 text-white rounded-lg text-sm transition-colors flex items-center gap-2"
                        >
                            <i data-lucide="activity" class="w-5 h-5"></i>
                            Vista en Vivo
                        </a>
                        <button 
                            @click="showSettingsModal = true" 
                            class="px-4 py-2 bg-accent-100 hover:bg-accent-200 text-black-400 rounded-lg text-sm transition-colors flex items-center gap-2"
                        >
                            <i data-lucide="settings" class="w-5 h-5"></i>
                            Configuración
                        </button>
                        @if($canCreateNew)
                            <button 
                                @click="showCreateModal = true" 
                                class="btn-primary flex items-center gap-2"
                            >
                                <i data-lucide="circle-plus" class="w-5 h-5"></i>
                                Nueva {{ ucfirst($type) }}
                            </button>
                        @elseif($type === 'habitacion' && $reservasHotelEnabled)
                            <div class="px-4 py-2 bg-info-50 text-info-400 rounded-lg text-sm flex items-center gap-2">
                                <i data-lucide="info" class="w-5 h-5"></i>
                                <span>Las habitaciones se gestionan desde <a href="{{ route('tenant.admin.hotel.rooms.index', $store->slug) }}" class="underline font-medium">Reservas de Hotel</a></span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="px-6 py-4 bg-accent-50 border-b border-accent-100">
                <div class="grid grid-cols-4 gap-4">
                    <div class="bg-white rounded-lg p-3 border border-accent-200">
                        <p class="text-xs text-black-300 mb-1">Total</p>
                        <p class="text-2xl font-semibold text-black-500">{{ $stats['total'] }}</p>
                    </div>
                    <div class="bg-success-50 rounded-lg p-3 border border-success-200">
                        <p class="text-xs text-black-300 mb-1">Disponibles</p>
                        <p class="text-2xl font-semibold text-success-400">{{ $stats['available'] }}</p>
                    </div>
                    <div class="bg-error-50 rounded-lg p-3 border border-error-200">
                        <p class="text-xs text-black-300 mb-1">Ocupadas</p>
                        <p class="text-2xl font-semibold text-error-400">{{ $stats['occupied'] }}</p>
                    </div>
                    <div class="bg-warning-50 rounded-lg p-3 border border-warning-200">
                        <p class="text-xs text-black-300 mb-1">Reservadas</p>
                        <p class="text-2xl font-semibold text-warning-400">{{ $stats['reserved'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Lista de Mesas/Habitaciones -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-accent-100">
                        <tr class="text-left text-xs font-medium text-black-400 uppercase tracking-wider">
                            <th class="px-6 py-3">Número</th>
                            <th class="px-6 py-3">Capacidad</th>
                            <th class="px-6 py-3">Estado</th>
                            <th class="px-6 py-3">Pedido Activo</th>
                            <th class="px-6 py-3">QR</th>
                            <th class="px-6 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-accent-50 divide-y divide-accent-100">
                        @forelse($tables as $table)
                            <tr class="text-black-400 hover:bg-accent-100">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 flex items-center justify-center bg-primary-50 rounded-lg">
                                            <i data-lucide="{{ $type === 'mesa' ? 'utensils' : 'bed' }}" class="w-5 h-5 text-primary-200"></i>
                                        </div>
                                        <div>
                                            <span class="font-semibold text-black-500">{{ $table->table_number }}</span>
                                            @if(isset($table->is_from_room_system) && $table->is_from_room_system && isset($table->room_type_name))
                                                <p class="text-xs text-black-300">{{ $table->room_type_name }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="text-black-500">{{ $table->capacity ?? 'N/A' }} personas</span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'available' => ['bg' => 'bg-success-50', 'text' => 'text-success-400', 'border' => 'border-success-200'],
                                            'occupied' => ['bg' => 'bg-error-50', 'text' => 'text-error-400', 'border' => 'border-error-200'],
                                            'reserved' => ['bg' => 'bg-warning-50', 'text' => 'text-warning-400', 'border' => 'border-warning-200'],
                                        ];
                                        $statusColor = $statusColors[$table->status] ?? $statusColors['available'];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColor['bg'] }} {{ $statusColor['text'] }} {{ $statusColor['border'] }} border">
                                        {{ ucfirst($table->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($table->currentOrder)
                                        <a href="{{ route('tenant.admin.orders.show', [$store->slug, $table->currentOrder->id]) }}" 
                                           class="text-primary-200 hover:text-primary-100">
                                            {{ $table->currentOrder->order_number }}
                                        </a>
                                        <p class="text-black-300 text-xs">${{ number_format($table->currentOrder->total, 0, ',', '.') }}</p>
                                    @else
                                        <span class="text-black-300">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        // Determinar el ID correcto: si existe Table real, usar su ID; si es virtual, usar 0
                                        $tableId = 0; // Default para habitaciones virtuales
                                        if (isset($table->id)) {
                                            // Si tiene ID y no es un string "room_", usar el ID real
                                            if (!is_string($table->id) || !str_starts_with($table->id, 'room_')) {
                                                $tableId = $table->id;
                                            }
                                        }
                                        
                                        $isFromRoom = is_object($table) && isset($table->is_from_room_system) && $table->is_from_room_system;
                                        $hasQR = isset($table->qr_code) && !empty($table->qr_code);
                                    @endphp
                                    
                                    @if($isFromRoom && !$hasQR)
                                        {{-- Habitación virtual sin QR: mostrar botón para generar --}}
                                        <button 
                                            @click="generateQR(0, '{{ $table->table_number }}')"
                                            class="text-black-300 hover:text-primary-200"
                                            title="Generar QR"
                                        >
                                            <i data-lucide="qr-code" class="w-5 h-5"></i>
                                        </button>
                                    @elseif($hasQR)
                                        {{-- Tiene QR: mostrar botón para ver (usar ID real si existe) --}}
                                        <button 
                                            @click="showQRModal({{ (int)$tableId }}, {{ json_encode($table->table_number) }})"
                                            class="text-primary-200 hover:text-primary-100"
                                            title="Ver QR"
                                        >
                                            <i data-lucide="qr-code" class="w-5 h-5"></i>
                                        </button>
                                    @else
                                        {{-- Mesa normal sin QR: generar --}}
                                        <button 
                                            @click="generateQR({{ $tableId }}, '{{ $table->table_number }}')"
                                            class="text-black-300 hover:text-primary-200"
                                            title="Generar QR"
                                        >
                                            <i data-lucide="qr-code" class="w-5 h-5"></i>
                                        </button>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        @if(isset($table->is_from_room_system) && $table->is_from_room_system)
                                            <a 
                                                href="{{ route('tenant.admin.hotel.rooms.index', $store->slug) }}"
                                                class="p-2 text-primary-200 hover:bg-primary-50 rounded-lg transition-colors"
                                                title="Gestionar desde Reservas de Hotel"
                                            >
                                                <i data-lucide="external-link" class="w-5 h-5"></i>
                                            </a>
                                        @else
                                            @if($table->status === 'occupied')
                                                <button 
                                                    @click="liberateTable({{ is_string($table->id) && str_starts_with($table->id, 'room_') ? 0 : $table->id }})"
                                                    class="p-2 text-success-400 hover:bg-success-50 rounded-lg transition-colors"
                                                    title="Liberar {{ $type }}"
                                                >
                                                    <i data-lucide="unlock" class="w-5 h-5"></i>
                                                </button>
                                            @endif
                                            <button 
                                                @click="editTable({{ is_string($table->id) && str_starts_with($table->id, 'room_') ? 0 : $table->id }})"
                                                class="p-2 text-primary-200 hover:bg-primary-50 rounded-lg transition-colors"
                                                title="Editar"
                                            >
                                                <i data-lucide="pencil" class="w-5 h-5"></i>
                                            </button>
                                            <button 
                                                @click="deleteTable({{ is_string($table->id) && str_starts_with($table->id, 'room_') ? 0 : $table->id }})"
                                                class="p-2 text-error-400 hover:bg-error-50 rounded-lg transition-colors"
                                                title="Eliminar"
                                            >
                                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-black-300">
                                    <i data-lucide="{{ $type === 'mesa' ? 'utensils' : 'bed' }}" class="w-12 h-12 mx-auto mb-3 text-black-200"></i>
                                    <p>No hay {{ $type === 'mesa' ? 'mesas' : 'habitaciones' }} configuradas</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal: Crear/Editar Mesa/Habitación -->
        <div x-show="showCreateModal" 
             x-cloak
             x-transition
             class="fixed inset-0 bg-black-500 bg-opacity-50 flex items-center justify-center z-50"
             @keydown.escape.window="showCreateModal = false; resetForm()"
             style="display: none;"
             x-bind:style="showCreateModal ? 'display: flex;' : 'display: none;'">
            <div class="bg-white rounded-lg p-6 w-full max-w-md" @click.stop>
                <button 
                    @click="showCreateModal = false; resetForm()"
                    class="absolute top-4 right-4 text-black-300 hover:text-black-500 transition-colors"
                >
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
                <h3 class="text-lg font-semibold text-black-500 mb-4">
                    <span x-text="editingTable ? 'Editar' : 'Nueva'"></span> {{ ucfirst($type) }}
                </h3>
                
                <form @submit.prevent="saveTable">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm text-black-400 mb-2">Número de {{ ucfirst($type) }} *</label>
                            <input 
                                type="text" 
                                x-model="form.table_number"
                                class="w-full px-3 py-2 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200"
                                required
                            >
                            <p x-show="errors.table_number" x-text="errors.table_number" class="mt-1 text-xs text-error-400"></p>
                        </div>
                        
                        <div>
                            <label class="block text-sm text-black-400 mb-2">Capacidad</label>
                            <input 
                                type="number" 
                                x-model="form.capacity"
                                min="1"
                                max="20"
                                class="w-full px-3 py-2 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200"
                            >
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end gap-3 mt-6">
                        <button 
                            type="button"
                            @click="showCreateModal = false; resetForm()"
                            class="px-4 py-2 text-black-400 hover:text-black-500 transition-colors"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="submit"
                            class="btn-primary"
                            :disabled="loading"
                        >
                            <span x-show="!loading">Guardar</span>
                            <span x-show="loading">Guardando...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal: Ver QR -->
        <div x-show="showQRModal" 
             x-cloak
             x-transition
             class="fixed inset-0 bg-black-500 bg-opacity-50 flex items-center justify-center z-50"
             @keydown.escape.window="showQRModal = false"
             style="display: none;"
             x-bind:style="showQRModal ? 'display: flex;' : 'display: none;'">
            <div class="bg-white rounded-lg p-6 w-full max-w-md text-center relative" @click.stop>
                <button 
                    @click="showQRModal = false"
                    class="absolute top-4 right-4 text-black-300 hover:text-black-500 transition-colors"
                >
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
                <h3 class="text-lg font-semibold text-black-500 mb-4">
                    QR {{ ucfirst($type) }} #<span x-text="selectedTable?.table_number"></span>
                </h3>
                
                <div class="mb-4" x-html="selectedQRCode"></div>
                
                <p class="text-sm text-black-300 mb-4">Escanea para ordenar</p>
                
                <div class="flex items-center justify-center gap-3">
                    <button 
                        @click="downloadQR('png')"
                        class="px-4 py-2 bg-accent-100 hover:bg-accent-200 text-black-400 rounded-lg text-sm transition-colors"
                    >
                        Descargar PNG
                    </button>
                    <button 
                        @click="downloadQR('svg')"
                        class="px-4 py-2 bg-accent-100 hover:bg-accent-200 text-black-400 rounded-lg text-sm transition-colors"
                    >
                        Descargar SVG
                    </button>
                    <a 
                        :href="selectedTable?.qr_url" 
                        target="_blank"
                        class="px-4 py-2 bg-primary-200 hover:bg-primary-300 text-white rounded-lg text-sm transition-colors"
                    >
                        Ver URL
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal: Configuración -->
        <div x-show="showSettingsModal" 
             x-cloak
             x-transition
             class="fixed inset-0 bg-black-500 bg-opacity-50 flex items-center justify-center z-50 overflow-y-auto"
             @keydown.escape.window="showSettingsModal = false"
             style="display: none;"
             x-bind:style="showSettingsModal ? 'display: flex;' : 'display: none;'">
            <div class="bg-white rounded-lg p-6 w-full max-w-2xl my-8 relative" @click.stop>
                <button 
                    @click="showSettingsModal = false"
                    class="absolute top-4 right-4 text-black-300 hover:text-black-500 transition-colors z-10"
                >
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
                <h3 class="text-lg font-semibold text-black-500 mb-4">Configuración</h3>
                
                <form @submit.prevent="saveSettings">
                    <div class="space-y-6">
                        <!-- Activación -->
                        <div>
                            <label class="flex items-center gap-3">
                                <input 
                                    type="checkbox" 
                                    x-model="settingsForm.is_enabled"
                                    class="w-4 h-4 text-primary-200 rounded focus:ring-primary-200"
                                >
                                <span class="text-sm text-black-400">Activar pedidos en {{ $type === 'mesa' ? 'mesa' : 'habitación' }}</span>
                            </label>
                        </div>
                        
                        <!-- Cargo de servicio -->
                        <div class="border-t border-accent-100 pt-4">
                            <h4 class="text-sm font-semibold text-black-500 mb-3">Cargo de servicio</h4>
                            
                            <label class="flex items-center gap-3 mb-3">
                                <input 
                                    type="checkbox" 
                                    x-model="settingsForm.charge_service_fee"
                                    class="w-4 h-4 text-primary-200 rounded focus:ring-primary-200"
                                >
                                <span class="text-sm text-black-400">Cobrar automáticamente</span>
                            </label>
                            
                            <div x-show="settingsForm.charge_service_fee" class="ml-7 space-y-3">
                                <div>
                                    <label class="flex items-center gap-3 mb-2">
                                        <input 
                                            type="radio" 
                                            x-model="settingsForm.service_fee_type"
                                            value="percentage"
                                            class="w-4 h-4 text-primary-200"
                                        >
                                        <span class="text-sm text-black-400">Porcentaje</span>
                                    </label>
                                    <input 
                                        type="number" 
                                        x-model="settingsForm.service_fee_percentage"
                                        min="0"
                                        max="100"
                                        class="w-full px-3 py-2 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200"
                                        placeholder="10"
                                    >
                                </div>
                                
                                <div>
                                    <label class="flex items-center gap-3 mb-2">
                                        <input 
                                            type="radio" 
                                            x-model="settingsForm.service_fee_type"
                                            value="fixed"
                                            class="w-4 h-4 text-primary-200"
                                        >
                                        <span class="text-sm text-black-400">Fijo</span>
                                    </label>
                                    <input 
                                        type="number" 
                                        x-model="settingsForm.service_fee_fixed"
                                        min="0"
                                        step="0.01"
                                        class="w-full px-3 py-2 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200"
                                        placeholder="5000"
                                    >
                                </div>
                            </div>
                        </div>
                        
                        <!-- Propina sugerida -->
                        <div class="border-t border-accent-100 pt-4">
                            <h4 class="text-sm font-semibold text-black-500 mb-3">Propina sugerida</h4>
                            
                            <label class="flex items-center gap-3 mb-3">
                                <input 
                                    type="checkbox" 
                                    x-model="settingsForm.suggest_tip"
                                    class="w-4 h-4 text-primary-200 rounded focus:ring-primary-200"
                                >
                                <span class="text-sm text-black-400">Sugerir propina al cliente</span>
                            </label>
                            
                            <div x-show="settingsForm.suggest_tip" class="ml-7 space-y-2">
                                <div>
                                    <label class="text-sm text-black-400 mb-2 block">Opciones (%)</label>
                                    <div class="flex items-center gap-4">
                                        <label class="flex items-center gap-2">
                                            <input 
                                                type="checkbox" 
                                                x-model="settingsForm.tip_options"
                                                value="0"
                                                class="w-4 h-4 text-primary-200 rounded"
                                            >
                                            <span class="text-sm text-black-400">0%</span>
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input 
                                                type="checkbox" 
                                                x-model="settingsForm.tip_options"
                                                value="10"
                                                class="w-4 h-4 text-primary-200 rounded"
                                            >
                                            <span class="text-sm text-black-400">10%</span>
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input 
                                                type="checkbox" 
                                                x-model="settingsForm.tip_options"
                                                value="15"
                                                class="w-4 h-4 text-primary-200 rounded"
                                            >
                                            <span class="text-sm text-black-400">15%</span>
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input 
                                                type="checkbox" 
                                                x-model="settingsForm.tip_options"
                                                value="20"
                                                class="w-4 h-4 text-primary-200 rounded"
                                            >
                                            <span class="text-sm text-black-400">20%</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <label class="flex items-center gap-3">
                                    <input 
                                        type="checkbox" 
                                        x-model="settingsForm.allow_custom_tip"
                                        class="w-4 h-4 text-primary-200 rounded focus:ring-primary-200"
                                    >
                                    <span class="text-sm text-black-400">Permitir propina personalizada</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end gap-3 mt-6 border-t border-accent-100 pt-4">
                        <button 
                            type="button"
                            @click="showSettingsModal = false"
                            class="px-4 py-2 text-black-400 hover:text-black-500 transition-colors"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="submit"
                            class="btn-primary"
                            :disabled="loading"
                        >
                            <span x-show="!loading">Guardar Configuración</span>
                            <span x-show="loading">Guardando...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function tablesManager(config) {
    return {
        storeSlug: config.storeSlug,
        type: config.type,
        showCreateModal: false,
        showQRModal: false,
        showSettingsModal: false,
        editingTable: null,
        selectedTable: null,
        selectedQRCode: '',
        tables: config.tables || [],
        loading: false,
        errors: {},
        form: {
            table_number: '',
            capacity: 4,
            type: config.type
        },
        settingsForm: {
            is_enabled: config.dineInSettings.is_enabled ?? false,
            charge_service_fee: config.dineInSettings.charge_service_fee ?? false,
            service_fee_type: config.dineInSettings.service_fee_type ?? 'percentage',
            service_fee_percentage: config.dineInSettings.service_fee_percentage ?? 10,
            service_fee_fixed: config.dineInSettings.service_fee_fixed ?? 0,
            suggest_tip: config.dineInSettings.suggest_tip ?? true,
            tip_options: config.dineInSettings.tip_options ?? [0, 10, 15, 20],
            allow_custom_tip: config.dineInSettings.allow_custom_tip ?? true,
            require_table_number: config.dineInSettings.require_table_number ?? true,
        },
        
        saveTable() {
            this.loading = true;
            this.errors = {};
            
            const url = this.editingTable 
                ? `/admin/dine-in/tables/${this.editingTable}`
                : `/admin/dine-in/tables`;
            const method = this.editingTable ? 'PUT' : 'POST';
            
            fetch(url.replace('admin', this.storeSlug + '/admin'), {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(this.form)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    this.errors = data.errors || {};
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al guardar. Por favor intenta de nuevo.',
                    confirmButtonColor: '#ed2e45'
                });
            })
            .finally(() => {
                this.loading = false;
            });
        },
        
        editTable(id) {
            // TODO: Cargar datos de la mesa
            this.editingTable = id;
            this.showCreateModal = true;
        },
        
        async deleteTable(id) {
            const result = await Swal.fire({
                title: '¿Eliminar ' + this.type + '?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ed2e45',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: '✓ Sí, eliminar',
                cancelButtonText: 'Cancelar'
            });
            
            if (!result.isConfirmed) return;
            
            fetch(`/${this.storeSlug}/admin/dine-in/tables/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: this.type + ' eliminada correctamente',
                        confirmButtonColor: '#00c76f',
                        timer: 2000
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error al eliminar',
                        confirmButtonColor: '#ed2e45'
                    });
                }
            })
            .catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error de conexión. Por favor intenta de nuevo.',
                    confirmButtonColor: '#ed2e45'
                });
            });
        },
        
        generateQR(id, tableNumber = null) {
            // Buscar la mesa/habitación en el array
            // Si hay tableNumber, usar ese para identificar específicamente (importante para habitaciones virtuales con id=0)
            let table = null;
            
            if (tableNumber) {
                // Buscar por tableNumber primero (más preciso)
                table = this.tables.find(t => t.table_number == tableNumber);
            }
            
            // Si no se encontró por tableNumber, buscar por ID
            if (!table) {
                if (id == 0) {
                    // Para id=0, buscar cualquier entrada con id=0 o null
                    table = this.tables.find(t => t.id === 0 || t.id === null);
                } else {
                    table = this.tables.find(t => t.id == id);
                }
            }
            
            if (!table) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se encontró la ' + this.type + (tableNumber ? ' número ' + tableNumber : ''),
                    confirmButtonColor: '#ed2e45'
                });
                return;
            }
            
            // Construir la URL con los parámetros necesarios
            // Usar el ID real si existe, o 0 si es virtual
            const tableId = table.id || id || 0;
            let url = `/${this.storeSlug}/admin/dine-in/tables/${tableId}/generate-qr?type=${this.type}&table_number=${encodeURIComponent(table.table_number)}`;
            
            // Si es una habitación virtual (id == 0) y tiene room_id, agregarlo
            if (tableId == 0 && this.type === 'habitacion' && table.room_id) {
                url += `&room_id=${table.room_id}`;
            }
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Si se creó una nueva tabla, actualizar el array ANTES de recargar
                    if (data.table_id) {
                        // Buscar la tabla por table_number (más confiable que por id)
                        const tableToFind = tableNumber || table?.table_number;
                        const tableIndex = this.tables.findIndex(t => {
                            if (tableToFind) {
                                return t.table_number == tableToFind;
                            }
                            return t.id == id || t.id === 0 || t.id === null;
                        });
                        
                        if (tableIndex !== -1) {
                            // Actualizar la entrada existente con todos los datos
                            this.tables[tableIndex].id = data.table_id;
                            this.tables[tableIndex].qr_code = data.qr_code;
                            this.tables[tableIndex].qr_url = data.qr_url;
                            // Asegurar que table_number esté presente
                            if (table && table.table_number) {
                                this.tables[tableIndex].table_number = table.table_number;
                            }
                        } else if (tableToFind) {
                            // Si no se encontró pero tenemos table_number, agregar nueva entrada
                            this.tables.push({
                                id: data.table_id,
                                table_number: tableToFind,
                                qr_code: data.qr_code,
                                qr_url: data.qr_url,
                                room_id: table?.room_id || null
                            });
                        }
                    }
                    // Recargar para asegurar sincronización completa con el backend
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'QR generado correctamente',
                        confirmButtonColor: '#00c76f',
                        timer: 2000
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error al generar QR',
                        confirmButtonColor: '#ed2e45'
                    });
                }
            })
            .catch(err => {
                console.error('Error:', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al generar QR. Por favor intenta de nuevo.',
                    confirmButtonColor: '#ed2e45'
                });
            });
        },
        
        showQRModal(id, tableNumber = null) {
            // Normalizar parámetros
            const numId = id !== null && id !== undefined && !isNaN(Number(id)) ? Number(id) : null;
            const strTableNumber = tableNumber !== null && tableNumber !== undefined && tableNumber !== '' ? String(tableNumber) : null;
            
            // Si no hay parámetros válidos, salir silenciosamente (puede ser llamado sin parámetros)
            if (!numId && !strTableNumber) {
                return;
            }
            
            // Buscar la mesa/habitación en el array
            let table = null;
            
            // PRIORIDAD 1: Buscar por tableNumber (más confiable, especialmente después de generar QR)
            if (strTableNumber && strTableNumber !== 'null') {
                table = this.tables.find(t => {
                    const tNum = String(t.table_number || '');
                    return tNum === strTableNumber;
                });
            }
            
            // PRIORIDAD 2: Si no se encontró por tableNumber, buscar por ID
            if (!table && numId !== null) {
                if (numId === 0) {
                    // Para id=0, buscar cualquier entrada con id=0, null, o undefined
                    // PERO solo si también coincide el tableNumber (si está disponible)
                    table = this.tables.find(t => {
                        const idMatch = t.id == 0 || t.id === null || t.id === undefined;
                        if (strTableNumber && strTableNumber !== 'null') {
                            return idMatch && String(t.table_number || '') === strTableNumber;
                        }
                        return idMatch;
                    });
                } else {
                    // Para ID diferente de 0, buscar coincidencia exacta
                    table = this.tables.find(t => {
                        return Number(t.id) === numId;
                    });
                }
            }
            
            // Si aún no se encontró, intentar una búsqueda más flexible
            if (!table && strTableNumber && strTableNumber !== 'null') {
                // Último intento: búsqueda flexible por tableNumber
                table = this.tables.find(t => {
                    return String(t.table_number || '') == strTableNumber ||
                           String(t.table_number || '') === String(strTableNumber);
                });
            }
            
            if (!table) {
                console.error('Table not found:', { 
                    id: numId, 
                    tableNumber: strTableNumber,
                    tablesInArray: this.tables.map(t => ({ 
                        id: t.id, 
                        table_number: t.table_number,
                        has_qr: !!t.qr_code
                    }))
                });
                Swal.fire({
                    icon: 'warning',
                    title: 'No encontrado',
                    text: 'No se encontró la ' + this.type + (strTableNumber ? ' número ' + strTableNumber : '') + '. La página se recargará para sincronizar los datos.',
                    confirmButtonColor: '#00c76f',
                    timer: 2000
                }).then(() => {
                    location.reload();
                });
                return;
            }
            
            if (table.qr_code) {
                this.selectedTable = table;
                // El QR está guardado como SVG en la base de datos, inyectarlo directamente
                this.selectedQRCode = table.qr_code;
                this.showQRModal = true;
            } else {
                // Si no tiene QR pero es virtual, sugerir generarlo
                if (this.type === 'habitacion' && id == 0) {
                    Swal.fire({
                        title: '¿Generar QR?',
                        text: 'Esta habitación aún no tiene QR. ¿Deseas generarlo ahora?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#da27a7',
                        cancelButtonColor: '#9ca3af',
                        confirmButtonText: '✓ Sí, generar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.generateQR(id, tableNumber || table.table_number);
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'QR no encontrado',
                        text: 'QR no encontrado para esta ' + this.type + '. Intenta generar el QR primero.',
                        confirmButtonColor: '#da27a7'
                    });
                }
            }
        },
        
        downloadQR(format) {
            if (!this.selectedTable || !this.selectedTable.qr_code) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No hay QR',
                    text: 'No hay QR para descargar',
                    confirmButtonColor: '#da27a7'
                });
                return;
            }
            
            if (format === 'png') {
                // Para PNG, convertir SVG a imagen usando canvas
                const svgData = this.selectedTable.qr_code;
                const img = new Image();
                const svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
                const url = URL.createObjectURL(svgBlob);
                
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    canvas.width = img.width || 300;
                    canvas.height = img.height || 300;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);
                    
                    canvas.toBlob((blob) => {
                        const link = document.createElement('a');
                        link.href = URL.createObjectURL(blob);
                        link.download = `${this.type}-${this.selectedTable.table_number}.png`;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        URL.revokeObjectURL(url);
                    }, 'image/png');
                };
                
                img.onerror = () => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al convertir QR a PNG. Intenta descargar como SVG.',
                        confirmButtonColor: '#ed2e45'
                    });
                    URL.revokeObjectURL(url);
                };
                
                img.src = url;
            } else {
                // Descargar como SVG directamente
                const svgBlob = new Blob([this.selectedTable.qr_code], { type: 'image/svg+xml;charset=utf-8' });
                const url = URL.createObjectURL(svgBlob);
                const link = document.createElement('a');
                link.href = url;
                link.download = `${this.type}-${this.selectedTable.table_number}.svg`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                URL.revokeObjectURL(url);
            }
        },
        
        async liberateTable(id) {
            const result = await Swal.fire({
                title: '¿Liberar ' + this.type + '?',
                text: 'Se marcará esta ' + this.type + ' como disponible',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#00c76f',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: '✓ Sí, liberar',
                cancelButtonText: 'Cancelar'
            });
            
            if (!result.isConfirmed) return;
            
            fetch(`/${this.storeSlug}/admin/dine-in/tables/${id}/liberate`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: this.type + ' liberada correctamente',
                        confirmButtonColor: '#00c76f',
                        timer: 2000
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error al liberar',
                        confirmButtonColor: '#ed2e45'
                    });
                }
            })
            .catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error de conexión. Por favor intenta de nuevo.',
                    confirmButtonColor: '#ed2e45'
                });
            });
        },
        
        saveSettings() {
            this.loading = true;
            
            fetch(`/${this.storeSlug}/admin/dine-in/settings`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(this.settingsForm)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Configuración guardada correctamente',
                        confirmButtonColor: '#00c76f',
                        timer: 2000
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al guardar configuración',
                        confirmButtonColor: '#ed2e45'
                    });
                }
            })
            .catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error de conexión. Por favor intenta de nuevo.',
                    confirmButtonColor: '#ed2e45'
                });
            })
            .finally(() => {
                this.loading = false;
            });
        },
        
        resetForm() {
            this.form = {
                table_number: '',
                capacity: 4,
                type: this.type
            };
            this.editingTable = null;
            this.errors = {};
        },
        
        downloadQR(format) {
            // Esta función ya está implementada arriba, pero por si acaso
            if (!this.selectedTable || !this.selectedTable.qr_code) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No hay QR',
                    text: 'No hay QR para descargar',
                    confirmButtonColor: '#da27a7'
                });
                return;
            }
        }
    };
}
</script>
@endpush
@endsection
</x-tenant-admin-layout>

