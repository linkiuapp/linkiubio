<x-tenant-admin-layout :store="$store">
@section('title', 'Configuración de Reservaciones')

@section('content')
<div class="container-fluid" x-data="reservationSettings">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('tenant.admin.reservations.index', $store->slug) }}" 
               class="text-black-300 hover:text-black-400">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            <h1 class="text-lg font-semibold text-black-500">Configuración de Reservaciones</h1>
        </div>
        <p class="text-sm text-black-300">Configura horarios, mesas, anticipos y notificaciones para tu sistema de reservas</p>
    </div>

    <form action="{{ route('tenant.admin.reservations.update-settings', $store->slug) }}" method="POST" @submit.prevent="saveSettings($event)" id="settings-form">
        @csrf
        @method('PUT')

        <!-- HORARIOS DISPONIBLES -->
        <div class="bg-accent-50 rounded-lg p-0 overflow-hidden mb-6">
            <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
                <h2 class="text-body-large font-bold text-black-400 mb-0">Horarios Disponibles</h2>
                <p class="text-sm text-black-300 mt-1">Define los horarios de atención por día de la semana</p>
            </div>
            
            <div class="p-6">
                @php
                    $days = [
                        'monday' => 'Lunes',
                        'tuesday' => 'Martes',
                        'wednesday' => 'Miércoles',
                        'thursday' => 'Jueves',
                        'friday' => 'Viernes',
                        'saturday' => 'Sábado',
                        'sunday' => 'Domingo'
                    ];
                @endphp
                
                @foreach($days as $dayKey => $dayName)
                <div class="mb-6 pb-6 border-b border-accent-200 last:border-b-0">
                    <div class="flex items-center justify-between mb-4">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" 
                                   x-model="form.daysEnabled['{{ $dayKey }}']"
                                   class="w-5 h-5 text-primary-300 border-accent-300 rounded focus:ring-primary-300">
                            <span class="text-body-base font-semibold text-black-400">{{ $dayName }}</span>
                        </label>
                    </div>
                    
                    <div x-show="form.daysEnabled['{{ $dayKey }}']" 
                         x-transition
                         data-day="{{ $dayKey }}"
                         x-data="{ slots: getDaySlots('{{ $dayKey }}') }"
                         class="space-y-3 mt-4">
                        <template x-for="(slot, index) in slots" :key="index">
                            <div class="flex items-center gap-3">
                                <div class="flex-1">
                                    <input type="text" 
                                           x-model="slot.start"
                                           data-slot-timepicker="start"
                                           data-day="{{ $dayKey }}"
                                           class="slot-timepicker w-full px-3 py-2 border border-accent-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-300"
                                           placeholder="12:00">
                                </div>
                                <span class="text-black-300">-</span>
                                <div class="flex-1">
                                    <input type="text" 
                                           x-model="slot.end"
                                           data-slot-timepicker="end"
                                           data-day="{{ $dayKey }}"
                                           class="slot-timepicker w-full px-3 py-2 border border-accent-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-300"
                                           placeholder="15:00">
                                </div>
                                <button type="button" 
                                        @click="removeSlot(slots, index)"
                                        class="text-error-300 hover:text-error-400">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </template>
                        <button type="button" 
                                @click="addSlot(slots)"
                                class="text-primary-300 hover:text-primary-400 text-sm font-medium">
                            <i data-lucide="plus" class="w-4 h-4 inline mr-1"></i>
                            Agregar horario
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- CONFIGURACIÓN GENERAL -->
        <div class="bg-accent-50 rounded-lg p-0 overflow-hidden mb-6">
            <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
                <h2 class="text-body-large font-bold text-black-400 mb-0">Configuración General</h2>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Duración de slots -->
                <div>
                    <label class="block text-sm font-semibold text-black-400 mb-2">
                        Duración de cada slot (minutos)
                    </label>
                    <input type="number" 
                           x-model.number="form.slot_duration"
                           min="15" 
                           max="240" 
                           step="15"
                           class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none">
                    <p class="text-sm text-black-300 mt-1">Tiempo estándar para cada reserva (ej: 60 = 1 hora)</p>
                </div>

                <!-- Anticipación mínima -->
                <div>
                    <label class="block text-sm font-semibold text-black-400 mb-2">
                        Anticipación mínima (horas)
                    </label>
                    <input type="number" 
                           x-model.number="form.min_advance_hours"
                           min="1" 
                           max="720"
                           class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none">
                    <p class="text-sm text-black-300 mt-1">Con cuántas horas de anticipación pueden reservar los clientes</p>
                </div>

                <!-- Anticipo requerido -->
                <div class="bg-accent-100 rounded-lg p-4">
                    <label class="flex items-center gap-3 cursor-pointer mb-4">
                        <input type="checkbox" 
                               x-model="form.require_deposit"
                               class="w-5 h-5 text-primary-300 border-accent-300 rounded focus:ring-primary-300">
                        <span class="text-body-base font-semibold text-black-400">Requerir anticipo</span>
                    </label>
                    
                    <div x-show="form.require_deposit" x-transition class="mt-4">
                        <label class="block text-sm font-semibold text-black-400 mb-2">
                            Monto por persona
                        </label>
                        <input type="number" 
                               x-model.number="form.deposit_per_person"
                               min="0" 
                               step="1000"
                               class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none">
                    </div>
                </div>

                <!-- Notificaciones -->
                <div class="bg-accent-100 rounded-lg p-4 space-y-4">
                    <h3 class="text-body-base font-semibold text-black-400 mb-4">Notificaciones WhatsApp</h3>
                    
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" 
                               x-model="form.send_confirmation"
                               class="w-5 h-5 text-primary-300 border-accent-300 rounded focus:ring-primary-300">
                        <span class="text-body-base text-black-400">Enviar confirmación automática</span>
                    </label>
                    
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" 
                               x-model="form.send_reminder"
                               class="w-5 h-5 text-primary-300 border-accent-300 rounded focus:ring-primary-300">
                        <span class="text-body-base text-black-400">Enviar recordatorio</span>
                    </label>
                    
                    <div x-show="form.send_reminder" x-transition>
                        <label class="block text-sm font-semibold text-black-400 mb-2 mt-4">
                            Horas antes de enviar recordatorio
                        </label>
                        <input type="number" 
                               x-model.number="form.reminder_hours"
                               min="1" 
                               max="168"
                               class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none">
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="flex items-center justify-end gap-4 mb-6">
            <a href="{{ route('tenant.admin.reservations.index', $store->slug) }}" 
               class="px-6 py-3 bg-accent-100 hover:bg-accent-200 text-black-400 rounded-lg text-sm transition-colors">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-primary-200 hover:bg-primary-300 text-accent-50 rounded-lg text-sm transition-colors">
                Guardar Configuración
            </button>
        </div>
    </form>

    <!-- Modal para Crear/Editar Mesa -->
    <div x-show="showTableModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black-500 bg-opacity-50">
        <div @click.away="showTableModal = false" class="absolute inset-0"></div>
        <div class="bg-accent-50 rounded-lg p-6 max-w-md w-full mx-4 relative z-10">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-black-500" x-text="tableModalTitle"></h3>
                <button @click="showTableModal = false" class="text-black-300 hover:text-black-400">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form @submit.prevent="saveTable()" class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-black-400 mb-2">
                        Número de Mesa
                    </label>
                    <input type="text" 
                           x-model="tableForm.table_number"
                           class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none"
                           required>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-black-400 mb-2">
                        Capacidad
                    </label>
                    <input type="number" 
                           x-model.number="tableForm.capacity"
                           min="1" 
                           max="50"
                           class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none"
                           required>
                </div>
                
                <div class="flex items-center justify-end gap-3 pt-4">
                    <button type="button" 
                            @click="showTableModal = false"
                            class="px-4 py-2 bg-accent-100 hover:bg-accent-200 text-black-400 rounded-lg text-sm">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-primary-200 hover:bg-primary-300 text-accent-50 rounded-lg text-sm">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- GESTIÓN DE MESAS -->
    <div class="bg-accent-50 rounded-lg p-0 overflow-hidden">
        <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-body-large font-bold text-black-400 mb-0">Gestión de Mesas</h2>
                    <p class="text-sm text-black-300 mt-1">Administra las mesas disponibles en tu restaurante</p>
                </div>
                <button @click="newTable()" 
                        class="px-4 py-2 bg-primary-200 hover:bg-primary-300 text-accent-50 rounded-lg text-sm flex items-center gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Nueva Mesa
                </button>
            </div>
        </div>
        
        <div class="p-6">
            @if($tables->isEmpty())
                <div class="text-center py-8">
                    <p class="text-black-300">No hay mesas registradas</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($tables as $table)
                    <div class="bg-white border border-accent-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <h3 class="text-body-base font-semibold text-black-500">Mesa {{ $table->table_number }}</h3>
                                <p class="text-sm text-black-300">Capacidad: {{ $table->capacity }} personas</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button @click="editTable({{ $table->id }}, '{{ $table->table_number }}', {{ $table->capacity }})"
                                        class="text-primary-300 hover:text-primary-400">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </button>
                                <button @click="deleteTable({{ $table->id }})"
                                        class="text-error-300 hover:text-error-400">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-black-300">Estado:</span>
                            <span class="text-sm font-medium {{ $table->is_active ? 'text-success-300' : 'text-error-300' }}">
                                {{ $table->is_active ? 'Activa' : 'Inactiva' }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('reservationSettings', () => ({
        showTableModal: false,
        tableModalTitle: 'Nueva Mesa',
        tableForm: {
            id: null,
            table_number: '',
            capacity: 4
        },
        
        init() {
            this.showTableModal = false;
            this.$nextTick(() => {
                if (window.createIcons && window.lucideIcons) {
                    window.createIcons({ icons: window.lucideIcons });
                }
                setTimeout(() => {
                    if (window.initReservationTimepicker) {
                        const timeInputs = document.querySelectorAll('.slot-timepicker');
                        timeInputs.forEach(async (input) => {
                            await window.initReservationTimepicker(input);
                        });
                    }
                }, 500);
                
                const form = this.$el?.querySelector('#settings-form') || this.$el?.querySelector('form');
                if (form) {
                    this._settingsForm = form;
                }
            });
        },
        
        form: {
            slot_duration: {{ $settings->slot_duration ?? 60 }},
            min_advance_hours: {{ $settings->min_advance_hours ?? 2 }},
            require_deposit: {{ $settings->require_deposit ? 'true' : 'false' }},
            deposit_per_person: {{ $settings->deposit_per_person ?? 0 }},
            send_confirmation: {{ $settings->send_confirmation ?? true ? 'true' : 'false' }},
            send_reminder: {{ $settings->send_reminder ?? true ? 'true' : 'false' }},
            reminder_hours: {{ $settings->reminder_hours ?? 24 }},
            daysEnabled: {
                @foreach($days as $dayKey => $dayName)
                '{{ $dayKey }}': {{ isset($timeSlots[$dayKey]) ? 'true' : 'false' }},
                @endforeach
            }
        },
        
        getDaySlots(dayKey) {
            const existingSlots = @json($timeSlots);
            return existingSlots[dayKey] || [{ start: '12:00', end: '15:00' }];
        },
        
        toggleDay(dayKey) {
            // La lógica de toggle ya está manejada por x-model
        },
        
        addSlot(slots) {
            slots.push({ start: '18:00', end: '22:00' });
        },
        
        removeSlot(slots, index) {
            if (slots.length > 1) {
                slots.splice(index, 1);
            }
        },
        
        editTable(id, tableNumber, capacity) {
            this.tableForm.id = id;
            this.tableForm.table_number = tableNumber;
            this.tableForm.capacity = capacity;
            this.tableModalTitle = 'Editar Mesa';
            this.showTableModal = true;
        },
        
        newTable() {
            this.tableForm.id = null;
            this.tableForm.table_number = '';
            this.tableForm.capacity = 4;
            this.tableModalTitle = 'Nueva Mesa';
            this.showTableModal = true;
        },
        
        async saveTable() {
            if (!this.tableForm.table_number || !this.tableForm.capacity) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor completa todos los campos'
                });
                return;
            }

            const url = this.tableForm.id 
                ? `{{ route('tenant.admin.reservations.settings', $store->slug) }}/tables/${this.tableForm.id}`
                : `{{ route('tenant.admin.reservations.settings', $store->slug) }}/tables`;
            
            const method = this.tableForm.id ? 'PUT' : 'POST';

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        table_number: this.tableForm.table_number,
                        capacity: parseInt(this.tableForm.capacity)
                    })
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message || 'Mesa guardada correctamente'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    let errorMessage = data.message || 'Error al guardar la mesa';
                    if (data.errors) {
                        const errors = Object.values(data.errors).flat();
                        errorMessage = errors.join('\n');
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error de conexión. Por favor intenta de nuevo.'
                });
            }
        },
        
        async deleteTable(tableId) {
            const confirmed = await Swal.fire({
                icon: 'warning',
                title: '¿Eliminar esta mesa?',
                text: 'Esta acción no se puede deshacer',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#ef4444'
            });
            
            if (!confirmed.isConfirmed) {
                return;
            }
            
            try {
                const response = await fetch(`{{ route('tenant.admin.reservations.settings', $store->slug) }}/tables/${tableId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message || 'Mesa eliminada correctamente'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error al eliminar la mesa'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error de conexión. Por favor intenta de nuevo.'
                });
            }
        },
        
        async saveSettings(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            let form = null;
            if (event && event.target) {
                if (event.target.tagName === 'FORM') {
                    form = event.target;
                } else {
                    form = event.target.closest('form');
                }
            }
            
            if (!form) {
                form = this._settingsForm || this.$el?.querySelector('#settings-form') || this.$el?.querySelector('form');
            }
            
            if (!form) {
                form = document.querySelector('#settings-form') || document.querySelector('form[action*="update-settings"]');
            }
            
            if (!form) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se encontró el formulario'
                });
                return;
            }
            
            const submitButton = form.querySelector('button[type="submit"]');
            if (!submitButton) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se encontró el botón de envío'
                });
                return;
            }
            
            const originalText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="animate-spin mr-2">⏳</span> Guardando...';
            
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    throw new Error('Token CSRF no encontrado');
                }
                
                const formData = new FormData();
                formData.append('_token', csrfToken.content);
                formData.append('_method', 'PUT');
                formData.append('slot_duration', this.form.slot_duration || 60);
                formData.append('min_advance_hours', this.form.min_advance_hours || 2);
                formData.append('require_deposit', this.form.require_deposit ? '1' : '0');
                formData.append('deposit_per_person', this.form.deposit_per_person || '0');
                formData.append('send_confirmation', this.form.send_confirmation ? '1' : '0');
                formData.append('send_reminder', this.form.send_reminder ? '1' : '0');
                formData.append('reminder_hours', this.form.reminder_hours || 24);
                
                @foreach($days as $dayKey => $dayName)
                {
                    const dayKey = '{{ $dayKey }}';
                    const isEnabled = this.form.daysEnabled[dayKey];
                    
                    formData.append(`daysEnabled[${dayKey}]`, isEnabled ? '1' : '0');
                    
                    if (isEnabled) {
                        const slotsContainer = document.querySelector(`[data-day="${dayKey}"]`);
                        let slots = [];
                        
                        if (slotsContainer && slotsContainer.__x && slotsContainer.__x.$data && slotsContainer.__x.$data.slots) {
                            slots = slotsContainer.__x.$data.slots || [];
                        } else {
                            const startInputs = document.querySelectorAll(`[data-slot-timepicker="start"][data-day="${dayKey}"]`);
                            const endInputs = document.querySelectorAll(`[data-slot-timepicker="end"][data-day="${dayKey}"]`);
                            
                            if (startInputs.length > 0) {
                                slots = Array.from(startInputs).map((input, index) => ({
                                    start: input.value || '',
                                    end: endInputs[index] ? endInputs[index].value : ''
                                }));
                            }
                        }
                        
                        if (slots.length > 0) {
                            formData.append(`slots_count[${dayKey}]`, slots.length.toString());
                            
                            slots.forEach((slot, index) => {
                                if (slot.start && slot.end) {
                                    formData.append(`time_slots[${dayKey}][${index}][start]`, slot.start);
                                    formData.append(`time_slots[${dayKey}][${index}][end]`, slot.end);
                                }
                            });
                        }
                    }
                }
                @endforeach
                
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken.content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData,
                    credentials: 'same-origin'
                });
                
                if (!response.ok && response.status !== 422) {
                    throw new Error(`HTTP ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message || 'Configuración guardada correctamente',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    let errorMessage = data.message || 'Error al guardar la configuración';
                    
                    if (data.errors) {
                        const errors = Object.values(data.errors).flat();
                        errorMessage = errors.join('\n');
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });
                    
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalText;
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error de conexión: ' + (error.message || 'Por favor intenta de nuevo.')
                });
                
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
            }
        }
    }));
});
</script>
@endpush
@endsection
</x-tenant-admin-layout>
