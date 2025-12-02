<x-tenant-admin-layout :store="$store">
@section('title', $type === 'mesa' ? 'Consumo en Local - Mesas' : 'Servicio a Habitación')

@section('content')
<div class="space-y-4" data-store-slug="{{ $store->slug }}">
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
                            class="inline-flex items-center gap-x-2 font-medium rounded-lg focus:outline-none transition-colors disabled:opacity-50 disabled:pointer-events-none py-2 px-3 body-small bg-blue-600 text-white hover:bg-blue-700 focus:bg-blue-700 border border-transparent"
                        >
                            <i data-lucide="activity" class="w-5 h-5"></i>
                            Vista en Vivo
                        </a>
                        <button 
                            @click="showSettingsModal = true" 
                            class="inline-flex items-center gap-x-2 font-medium rounded-lg focus:outline-none transition-colors disabled:opacity-50 disabled:pointer-events-none py-2 px-3 body-small bg-gray-100 text-gray-500 hover:bg-gray-200 focus:bg-gray-200 border border-transparent flex items-center gap-2"
                        >
                            <i data-lucide="settings" class="w-5 h-5"></i>
                            Configuración
                        </button>
                        @if($canCreateNew)
                            <button 
                                @click="showCreateModal = true" 
                                class="inline-flex items-center gap-x-2 font-medium rounded-lg focus:outline-none transition-colors disabled:opacity-50 disabled:pointer-events-none py-2 px-3 body-small bg-blue-600 text-white hover:bg-blue-700 focus:bg-blue-700 border border-transparent flex items-center gap-2"
                            >
                                <i data-lucide="circle-plus" class="w-5 h-5"></i>
                                Nueva {{ ucfirst($type) }}
                            </button>
                        @elseif($type === 'habitacion' && $reservasHotelEnabled)
                            <x-alert-bordered 
                                type="warning" 
                                title="Información"
                                message="Las habitaciones se gestionan desde"
                            >
                                <a href="{{ route('tenant.admin.hotel.rooms.index', $store->slug) }}" class="underline font-medium">Reservas de Hotel</a>
                            </x-alert-bordered>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="px-6 py-4 bg-accent-50 border-b border-accent-100">
                <div class="grid grid-cols-4 gap-4">
                    <x-stat-card 
                        title="Total" 
                        :value="$stats['total']" 
                        icon="grid" 
                        color="primary"
                    />
                    <x-stat-card 
                        title="Disponibles" 
                        :value="$stats['available']" 
                        icon="check-circle" 
                        color="success"
                    />
                    <x-stat-card 
                        title="Ocupadas" 
                        :value="$stats['occupied']" 
                        icon="x-circle" 
                        color="warning"
                    />
                    <x-stat-card 
                        title="Reservadas" 
                        :value="$stats['reserved']" 
                        icon="clock" 
                        color="info"
                    />
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
                        @forelse($paginatedTables ?? $tables as $table)
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
                                        $statusBadgeTypes = [
                                            'available' => 'success',
                                            'occupied' => 'error',
                                            'reserved' => 'warning',
                                        ];
                                        $badgeType = $statusBadgeTypes[$table->status] ?? 'info';
                                        $statusLabels = [
                                            'available' => 'Disponible',
                                            'occupied' => 'Ocupada',
                                            'reserved' => 'Reservada',
                                        ];
                                        $statusLabel = $statusLabels[$table->status] ?? ucfirst($table->status);
                                    @endphp
                                    <x-badge-soft 
                                        type="{{ $badgeType }}" 
                                        text="{{ $statusLabel }}"
                                    />
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
                                        <x-button-icon-only 
                                            type="ghost" 
                                            color="secondary" 
                                            size="sm"
                                            icon="qr-code"
                                            ariaLabel="Generar QR"
                                            @click="generateQR(0, '{{ $table->table_number }}')"
                                        />
                                    @elseif($hasQR)
                                        {{-- Tiene QR: mostrar botón para ver (usar ID real si existe) --}}
                                        <x-button-icon-only 
                                            type="ghost" 
                                            color="info" 
                                            size="sm"
                                            icon="qr-code"
                                            ariaLabel="Ver QR"
                                            @click="showQRModal({{ (int)$tableId }}, {{ json_encode($table->table_number) }})"
                                        />
                                    @else
                                        {{-- Mesa normal sin QR: generar --}}
                                        <x-button-icon-only 
                                            type="ghost" 
                                            color="secondary" 
                                            size="sm"
                                            icon="qr-code"
                                            ariaLabel="Generar QR"
                                            @click="generateQR({{ $tableId }}, '{{ $table->table_number }}')"
                                        />
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        @if(isset($table->is_from_room_system) && $table->is_from_room_system)
                                            <a 
                                                href="{{ route('tenant.admin.hotel.rooms.index', $store->slug) }}"
                                                class="inline-flex items-center justify-center w-11 h-11 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors"
                                                title="Gestionar desde Reservas de Hotel"
                                            >
                                                <i data-lucide="external-link" class="w-5 h-5"></i>
                                            </a>
                                        @else
                                            @if($table->status === 'occupied')
                                                <x-button-icon-only 
                                                    type="ghost" 
                                                    color="success" 
                                                    size="sm"
                                                    icon="unlock"
                                                    ariaLabel="Liberar {{ $type }}"
                                                    @click="liberateTable({{ is_string($table->id) && str_starts_with($table->id, 'room_') ? 0 : $table->id }})"
                                                />
                                            @endif
                                            <x-button-icon-only 
                                                type="ghost" 
                                                color="info" 
                                                size="sm"
                                                icon="pencil"
                                                ariaLabel="Editar"
                                                @click="editTable({{ is_string($table->id) && str_starts_with($table->id, 'room_') ? 0 : $table->id }})"
                                            />
                                            <x-button-icon-only 
                                                type="ghost" 
                                                color="error" 
                                                size="sm"
                                                icon="trash-2"
                                                ariaLabel="Eliminar"
                                                @click="deleteTable({{ is_string($table->id) && str_starts_with($table->id, 'room_') ? 0 : $table->id }}, $event)"
                                            />
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <i data-lucide="{{ $type === 'mesa' ? 'utensils' : 'bed' }}" class="w-12 h-12 mb-3 text-gray-400"></i>
                                        <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                            No hay {{ $type === 'mesa' ? 'mesas' : 'habitaciones' }} configuradas
                                        </h3>
                                        <p class="text-sm text-gray-500 mb-6 text-center max-w-md">
                                            Comienza agregando tu primera {{ $type === 'mesa' ? 'mesa' : 'habitación' }} para gestionar pedidos
                                        </p>
                                        @if($canCreateNew)
                                            <x-button-base 
                                                type="solid" 
                                                color="info" 
                                                size="sm"
                                                htmlType="button"
                                                text="Nueva {{ ucfirst($type) }}"
                                                @click="showCreateModal = true"
                                            />
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(isset($totalPages) && $totalPages > 1)
                <div class="px-6 py-4 bg-accent-50 border-t border-accent-100">
                    <x-pagination-center 
                        :current="$currentPage" 
                        :total="$totalPages" 
                        :url="route('tenant.admin.dine-in.tables.index', ['store' => $store->slug, 'type' => $type])"
                        prevLabel="Anterior"
                        nextLabel="Siguiente"
                    />
                </div>
            @endif
        </div>

        <!-- Modal: Crear/Editar Mesa/Habitación -->
        <x-modal-generic 
            modalId="create-table-modal"
            openVariable="showCreateModal"
            maxWidth="xs"
            :closeOnBackdrop="true"
            closeHandler="resetForm()"
        >
            <x-slot:header>
                <h3 class="font-bold text-gray-800">
                    <span x-text="editingTable ? 'Editar' : 'Nueva'"></span> {{ ucfirst($type) }}
                </h3>
            </x-slot:header>
            
            <x-slot:body>
                <form @submit.prevent="saveTable" id="create-table-form">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800">
                                Número de {{ ucfirst($type) }} <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                x-model="form.table_number"
                                placeholder="Ej: 1, 2, VIP-1"
                                class="p-3 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 disabled:opacity-50 disabled:pointer-events-none"
                                required
                            >
                            <p x-show="errors.table_number" x-text="errors.table_number" class="mt-1 text-xs text-red-600"></p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800">
                                Capacidad
                            </label>
                            <input 
                                type="number" 
                                x-model="form.capacity"
                                placeholder="Número de personas"
                                min="1"
                                max="20"
                                class="p-3 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 disabled:opacity-50 disabled:pointer-events-none"
                            >
                        </div>
                    </div>
                </form>
            </x-slot:body>
            
            <x-slot:footer>
                <x-button-base 
                    type="ghost" 
                    color="secondary" 
                    size="sm"
                    htmlType="button"
                    text="Cancelar"
                    @click="showCreateModal = false; resetForm()"
                />
                <button 
                    type="submit"
                    form="create-table-form"
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                    x-bind:disabled="loading"
                    @click="$el.closest('form')?.requestSubmit()"
                >
                    <span x-show="!loading">Guardar</span>
                    <span x-show="loading" class="flex items-center gap-2">
                        <i data-lucide="loader" class="size-4 animate-spin"></i>
                        Guardando...
                    </span>
                </button>
            </x-slot:footer>
        </x-modal-generic>

        <!-- Modal: Ver QR -->
        <x-modal-generic 
            modalId="qr-modal"
            openVariable="showQRModal"
            maxWidth="xs"
            :closeOnBackdrop="true"
        >
            <x-slot:header>
                <h3 class="font-bold text-gray-800">
                    QR {{ ucfirst($type) }} #<span x-text="selectedTable?.table_number"></span>
                </h3>
            </x-slot:header>
            
            <x-slot:body>
                <div class="text-center">
                    <div class="mb-4 flex justify-center" x-html="selectedQRCode"></div>
                    <p class="text-sm text-gray-600 mb-4">Escanea para ordenar</p>
                </div>
            </x-slot:body>
            
            <x-slot:footer>
                <x-button-base 
                    type="soft" 
                    color="secondary" 
                    size="sm"
                    htmlType="button"
                    text="Descargar PNG"
                    @click="downloadQR('png')"
                />
                <x-button-base 
                    type="soft" 
                    color="secondary" 
                    size="sm"
                    htmlType="button"
                    text="Descargar SVG"
                    @click="downloadQR('svg')"
                />
                <a 
                    x-bind:href="selectedTable?.qr_url" 
                    target="_blank"
                    class="inline-flex items-center gap-x-2 font-medium rounded-lg focus:outline-none transition-colors disabled:opacity-50 disabled:pointer-events-none py-2 px-3 body-small bg-blue-600 text-white hover:bg-blue-700 focus:bg-blue-700 border border-transparent"
                >
                    Ver URL
                </a>
            </x-slot:footer>
        </x-modal-generic>

        <!-- Modal: Configuración -->
        <x-modal-generic 
            modalId="settings-modal"
            openVariable="showSettingsModal"
            maxWidth="2xl"
            :closeOnBackdrop="true"
        >
            <x-slot:header>
                <h3 class="font-bold text-gray-800">Configuración</h3>
            </x-slot:header>
            
            <x-slot:body>
                <form @submit.prevent="saveSettings" id="settings-form">
                    <div class="space-y-6">
                        <!-- Activación -->
                        <div>
                            <x-checkbox-basic 
                                label="Activar pedidos en {{ $type === 'mesa' ? 'mesa' : 'habitación' }}"
                                :checked="false"
                                x-model="settingsForm.is_enabled"
                            />
                        </div>
                        
                        <!-- Cargo de servicio -->
                        <div class="border-t border-accent-100 pt-4">
                            <h4 class="text-sm font-semibold text-black-500 mb-3">Cargo de servicio</h4>
                            
                            <x-checkbox-basic 
                                label="Cobrar automáticamente"
                                :checked="false"
                                x-model="settingsForm.charge_service_fee"
                                class="mb-3"
                            />
                            
                            <div x-show="settingsForm.charge_service_fee" class="ml-7 space-y-3">
                                <div>
                                    <x-radio-basic 
                                        radioName="service_fee_type"
                                        label="Porcentaje"
                                        :checked="false"
                                        value="percentage"
                                        x-model="settingsForm.service_fee_type"
                                        class="mb-2"
                                    />
                                    <input 
                                        type="number" 
                                        x-model="settingsForm.service_fee_percentage"
                                        min="0"
                                        max="100"
                                        class="mt-2 p-3 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 disabled:opacity-50 disabled:pointer-events-none"
                                        placeholder="10"
                                    >
                                </div>
                                
                                <div>
                                    <x-radio-basic 
                                        radioName="service_fee_type"
                                        label="Fijo"
                                        :checked="false"
                                        value="fixed"
                                        x-model="settingsForm.service_fee_type"
                                        class="mb-2"
                                    />
                                    <input 
                                        type="number" 
                                        x-model="settingsForm.service_fee_fixed"
                                        min="0"
                                        step="0.01"
                                        class="mt-2 p-3 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 disabled:opacity-50 disabled:pointer-events-none"
                                        placeholder="5000"
                                    >
                                </div>
                            </div>
                        </div>
                        
                        <!-- Propina sugerida -->
                        <div class="border-t border-accent-100 pt-4">
                            <h4 class="text-sm font-semibold text-black-500 mb-3">Propina sugerida</h4>
                            
                            <x-checkbox-basic 
                                label="Sugerir propina al cliente"
                                :checked="false"
                                x-model="settingsForm.suggest_tip"
                                class="mb-3"
                            />
                            
                            <div x-show="settingsForm.suggest_tip" class="ml-7 space-y-2">
                                <div>
                                    <label class="text-sm font-medium mb-2 block text-gray-800">Opciones (%)</label>
                                    <div class="flex items-center gap-4">
                                        <x-checkbox-basic 
                                            label="0%"
                                            :checked="false"
                                            value="0"
                                            x-model="settingsForm.tip_options"
                                        />
                                        <x-checkbox-basic 
                                            label="10%"
                                            :checked="false"
                                            value="10"
                                            x-model="settingsForm.tip_options"
                                        />
                                        <x-checkbox-basic 
                                            label="15%"
                                            :checked="false"
                                            value="15"
                                            x-model="settingsForm.tip_options"
                                        />
                                        <x-checkbox-basic 
                                            label="20%"
                                            :checked="false"
                                            value="20"
                                            x-model="settingsForm.tip_options"
                                        />
                                    </div>
                                </div>
                                
                                <x-checkbox-basic 
                                    label="Permitir propina personalizada"
                                    :checked="false"
                                    x-model="settingsForm.allow_custom_tip"
                                />
                            </div>
                        </div>
                    </div>
                    
                </form>
            </x-slot:body>
            
            <x-slot:footer>
                <x-button-base 
                    type="ghost" 
                    color="secondary" 
                    size="sm"
                    htmlType="button"
                    text="Cancelar"
                    @click="showSettingsModal = false"
                />
                <button 
                    type="submit"
                    form="settings-form"
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                    x-bind:disabled="loading"
                    @click="$el.closest('form')?.requestSubmit()"
                >
                    <span x-show="!loading">Guardar Configuración</span>
                    <span x-show="loading" class="flex items-center gap-2">
                        <i data-lucide="loader" class="size-4 animate-spin"></i>
                        Guardando...
                    </span>
                </button>
            </x-slot:footer>
        </x-modal-generic>
    
    <!-- SECTION: Delete Confirmation Modal -->
    <div 
        x-data="deleteTableModalData()"
        x-on:keydown.escape.window="closeModal()"
        @delete-table.window="openModal($event.detail.id, $event.detail.name, $event.detail.rowElement)"
    >
        {{-- Modal Overlay --}}
        <div 
            x-show="open"
            x-transition:enter="transition-opacity duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
            @click="closeModal()"
            style="display: none;"
        ></div>

        {{-- Modal Content --}}
        <div 
            x-show="open"
            x-transition:enter="transition-opacity duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
            role="dialog"
            tabindex="-1"
            aria-labelledby="delete-modal-label"
            style="display: none;"
        >
            <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                <div 
                    @click.stop
                    class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
                >
                    {{-- SECTION: Modal Header --}}
                    <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                        <h3 id="delete-modal-label" class="font-bold text-gray-800">
                            ¿Eliminar {{ $type === 'mesa' ? 'mesa' : 'habitación' }}?
                        </h3>
                        <button 
                            type="button" 
                            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none" 
                            aria-label="Cerrar"
                            @click="closeModal()"
                            x-bind:disabled="loading"
                        >
                            <span class="sr-only">Cerrar</span>
                            <i data-lucide="x" class="shrink-0 size-4"></i>
                        </button>
                    </div>
                    {{-- End SECTION: Modal Header --}}

                    {{-- SECTION: Modal Body --}}
                    <div class="p-4 overflow-y-auto">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0">
                                <div class="size-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <i data-lucide="alert-triangle" class="size-5 text-red-600"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-800">
                                    Se eliminará la {{ $type === 'mesa' ? 'mesa' : 'habitación' }} <strong>"<span x-text="tableName"></span>"</strong> de forma permanente.
                                </p>
                                <p class="text-sm text-gray-600 mt-2">
                                    Esta acción no se puede deshacer.
                                </p>
                                
                                {{-- ITEM: Error Alert --}}
                                <div x-show="error" class="mt-3" x-cloak>
                                    <div class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg p-4" role="alert">
                                        <div class="flex">
                                            <div class="shrink-0">
                                                <i data-lucide="x-circle" class="shrink-0 size-4 mt-0.5"></i>
                                            </div>
                                            <div class="ms-2">
                                                <h3 class="text-sm font-medium">
                                                    Error: <span x-text="error"></span>
                                                </h3>
                                            </div>
                                            <div class="ps-3 ms-auto">
                                                <div class="-mx-1.5 -my-1.5">
                                                    <button 
                                                        type="button" 
                                                        class="inline-flex bg-red-50 rounded-lg p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:bg-red-100" 
                                                        @click="error = null"
                                                    >
                                                        <span class="sr-only">Descartar</span>
                                                        <i data-lucide="x" class="shrink-0 size-4"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End ITEM: Error Alert --}}
                            </div>
                        </div>
                    </div>
                    {{-- End SECTION: Modal Body --}}

                    {{-- SECTION: Modal Footer --}}
                    <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200">
                        <x-button-base 
                            type="ghost" 
                            color="secondary" 
                            size="sm"
                            htmlType="button"
                            text="Cancelar"
                            @click="closeModal()"
                            x-bind:disabled="loading"
                        />
                        <button 
                            type="button" 
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none"
                            @click="confirmDelete()"
                            x-bind:disabled="loading"
                        >
                            <span x-show="!loading">Sí, eliminar</span>
                            <span x-show="loading" class="flex items-center gap-2">
                                <i data-lucide="loader" class="size-4 animate-spin"></i>
                                Eliminando...
                            </span>
                        </button>
                    </div>
                    {{-- End SECTION: Modal Footer --}}
                </div>
            </div>
        </div>
    </div>
    {{-- End SECTION: Delete Confirmation Modal --}}
    
    <!-- SECTION: Alertas Bordered (Notificaciones) -->
    <div class="fixed top-4 right-4 z-[9999] space-y-2 max-w-md w-full" 
         x-data="{ alerts: [] }"
         x-on:show-alert.window="alerts.push($event.detail); setTimeout(() => { alerts.shift(); }, 5000);">
        
        {{-- SECTION: Alerta de Configuración Guardada --}}
        <div 
            x-show="showSettingsSuccessAlert"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2"
            style="display: none;"
        >
            <x-alert-bordered 
                type="success" 
                title="Actualización exitosa" 
                message="La configuración se ha guardado correctamente."
            />
        </div>
        {{-- End SECTION: Alerta de Configuración Guardada --}}
        
        <template x-for="(alert, index) in alerts" :key="index">
            <div 
                x-show="true"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-full"
                x-transition:enter-end="opacity-100 transform translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-x-0"
                x-transition:leave-end="opacity-0 transform translate-x-full"
                class="cursor-pointer"
                @click="alerts.splice(index, 1)"
            >
                <x-alert-bordered 
                    x-bind:type="alert.type" 
                    x-bind:title="alert.title" 
                    x-bind:message="alert.message"
                />
            </div>
        </template>
    </div>
    {{-- End SECTION: Alertas Bordered --}}
</div>

@push('scripts')
<script>
function tablesManager(config) {
    return {
        storeSlug: config.storeSlug,
        type: config.type,
        showSettingsSuccessAlert: false,
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
                this.showAlert('error', 'Error', 'Error al guardar. Por favor intenta de nuevo.');
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
        
        deleteTable(id, event = null) {
            console.log('deleteTable called', { id, event });
            // Disparar evento para abrir modal de eliminación
            const table = this.tables.find(t => t.id == id);
            const rowElement = event?.target?.closest('tr') || null;
            
            const eventDetail = {
                id: id,
                name: table ? table.table_number : '',
                rowElement: rowElement
            };
            
            console.log('Dispatching delete-table event', eventDetail);
            
            // Disparar evento personalizado
            const deleteEvent = new CustomEvent('delete-table', {
                detail: eventDetail,
                bubbles: true,
                cancelable: true
            });
            
            window.dispatchEvent(deleteEvent);
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
                this.showAlert('error', 'Error', 'No se encontró la ' + this.type + (tableNumber ? ' número ' + tableNumber : ''));
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
                    this.showAlert('success', '¡Éxito!', 'QR generado correctamente');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    this.showAlert('error', 'Error', data.message || 'Error al generar QR');
                }
            })
            .catch(err => {
                console.error('Error:', err);
                this.showAlert('error', 'Error', 'Error al generar QR. Por favor intenta de nuevo.');
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
                this.showAlert('warning', 'No encontrado', 'No se encontró la ' + this.type + (strTableNumber ? ' número ' + strTableNumber : '') + '. La página se recargará para sincronizar los datos.');
                setTimeout(() => location.reload(), 2000);
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
                    if (confirm('Esta habitación aún no tiene QR. ¿Deseas generarlo ahora?')) {
                        this.generateQR(id, tableNumber || table.table_number);
                    }
                } else {
                    this.showAlert('warning', 'QR no encontrado', 'QR no encontrado para esta ' + this.type + '. Intenta generar el QR primero.');
                }
            }
        },
        
        downloadQR(format) {
            if (!this.selectedTable || !this.selectedTable.qr_code) {
                this.showAlert('warning', 'No hay QR', 'No hay QR para descargar');
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
                    this.showAlert('error', 'Error', 'Error al convertir QR a PNG. Intenta descargar como SVG.');
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
        
        liberateTable(id) {
            if (confirm('¿Liberar ' + this.type + '? Se marcará como disponible.')) {
                fetch(`/${this.storeSlug}/admin/dine-in/tables/${id}/liberate`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.showAlert('success', '¡Éxito!', this.type + ' liberada correctamente');
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        this.showAlert('error', 'Error', data.message || 'Error al liberar');
                    }
                })
                .catch(err => {
                    this.showAlert('error', 'Error', 'Error de conexión. Por favor intenta de nuevo.');
                });
            }
        },
        
        saveSettings() {
            const self = this;
            self.loading = true;
            
            fetch(`/${self.storeSlug}/admin/dine-in/settings`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(self.settingsForm)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    self.showSettingsSuccessAlert = true;
                    self.showSettingsModal = false;
                    setTimeout(() => {
                        self.showSettingsSuccessAlert = false;
                    }, 5000);
                } else {
                    self.showAlert('error', 'Error', 'Error al guardar configuración');
                }
            })
            .catch(err => {
                self.showAlert('error', 'Error', 'Error de conexión. Por favor intenta de nuevo.');
            })
            .finally(() => {
                self.loading = false;
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
        
        showAlert(type, title, message) {
            window.dispatchEvent(new CustomEvent('show-alert', {
                detail: {
                    type: type,
                    title: title,
                    message: message
                }
            }));
        }
    };
}

// Inicializar iconos Lucide cuando se carga el DOM
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});

// Reinicializar iconos cuando Alpine actualiza el DOM
document.addEventListener('alpine:init', () => {
    Alpine.effect(() => {
        if (typeof lucide !== 'undefined' && lucide.createIcons) {
            setTimeout(() => {
                lucide.createIcons();
            }, 100);
        }
    });
    
    // Modal de eliminación
    function deleteTableModalData() {
        return {
            open: false,
            tableId: null,
            tableName: '',
            tableRow: null,
            loading: false,
            error: null,
            
            openModal(id, name, rowElement) {
                console.log('openModal called', { id, name, rowElement });
                this.tableId = id;
                this.tableName = name;
                this.tableRow = rowElement;
                this.error = null;
                this.open = true;
            },
            
            closeModal() {
                if (!this.loading) {
                    this.open = false;
                    this.tableId = null;
                    this.tableName = '';
                    this.tableRow = null;
                    this.error = null;
                }
            },
            
            async confirmDelete() {
                if (!this.tableId) return;
                
                this.loading = true;
                this.error = null;
                
                const storeSlug = document.querySelector('[data-store-slug]')?.getAttribute('data-store-slug');
                if (!storeSlug) {
                    this.error = 'Error: No se pudo obtener el slug de la tienda';
                    this.loading = false;
                    return;
                }
                
                try {
                    const response = await fetch(`/${storeSlug}/admin/dine-in/tables/${this.tableId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    });
                    
                    let data;
                    try {
                        data = await response.json();
                    } catch (e) {
                        this.error = 'Error al procesar la respuesta del servidor';
                        this.loading = false;
                        return;
                    }
                    
                    // Verificar si hay error (status no ok o success false)
                    if (!response.ok) {
                        // Si es un error 422 u otro, mostrar el mensaje del servidor
                        let errorMessage = data.message || data.error || 'Error al eliminar la mesa';
                        // Si el mensaje es un array, convertir a string
                        if (Array.isArray(errorMessage)) {
                            errorMessage = errorMessage.join(', ');
                        }
                        this.error = errorMessage;
                        this.loading = false;
                        return;
                    }
                    
                    if (!data.success) {
                        let errorMessage = data.message || data.error || 'Error al eliminar la mesa';
                        // Si el mensaje es un array, convertir a string
                        if (Array.isArray(errorMessage)) {
                            errorMessage = errorMessage.join(', ');
                        }
                        this.error = errorMessage;
                        this.loading = false;
                        return;
                    }
                    
                    window.dispatchEvent(new CustomEvent('show-alert', {
                        detail: {
                            type: 'success',
                            title: '¡Éxito!',
                            message: data.message || 'Mesa eliminada correctamente'
                        }
                    }));
                    this.closeModal();
                    setTimeout(() => location.reload(), 1500);
                } catch (err) {
                    console.error('Error:', err);
                    this.error = 'Error de conexión. Por favor intenta de nuevo.';
                    this.loading = false;
                }
            }
        };
    }
});
</script>
@endpush
@endsection
</x-tenant-admin-layout>

