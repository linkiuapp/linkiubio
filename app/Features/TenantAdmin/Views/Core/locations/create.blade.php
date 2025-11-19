<x-tenant-admin-layout :store="$store">

@section('title', 'Crear Nueva Sede')

@section('content')
<div
    class="space-y-6"
    x-data="locationForm"
>
    {{-- COMPONENT: Notifications --}}
    @include('tenant-admin::core.locations.components.notifications')

    @if(session('error'))
        <x-alert-bordered
            type="error"
            title="No se pudo crear la sede"
            class="w-full"
        >
            <p class="text-sm text-gray-700">{{ session('error') }}</p>
        </x-alert-bordered>
    @endif

    @if($errors->any())
        <x-alert-bordered
            type="error"
            title="Revisa la información ingresada"
            class="w-full"
        >
            <ul class="space-y-1 text-sm text-gray-700 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert-bordered>
    @endif

    {{-- SECTION: Header --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-900">Crear nueva sede</h1>
            <p class="text-sm text-gray-600">Completa la información para agregar una nueva sede a tu tienda.</p>
        </div>
        <a href="{{ route('tenant.admin.locations.index', ['store' => $store->slug]) }}">
            <x-button-icon
                type="outline"
                color="secondary"
                icon="arrow-left"
                text="Volver"
            />
        </a>
    </div>

    <form
        action="{{ route('tenant.admin.locations.store', ['store' => $store->slug]) }}"
        method="POST"
        class="space-y-6"
    >
        @csrf

        {{-- CARD: Información de la sede --}}
        <x-card-base title="Información de la sede" shadow="sm">
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div class="md:col-span-1">
                    <x-input-with-label
                        label="Nombre de la sede *"
                        name="name"
                        placeholder="Ej. Sede Centro"
                        :value="old('name')"
                        :required="true"
                        container-class="w-full"
                    />
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-1">
                    <x-input-with-label
                        label="Encargado/Responsable"
                        name="manager_name"
                        placeholder="Nombre de la persona encargada"
                        :value="old('manager_name')"
                        container-class="w-full"
                    />
                    @error('manager_name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <x-textarea-with-label
                        label="Descripción"
                        textarea-name="description"
                        rows="3"
                        placeholder="Breve descripción de la sede..."
                        container-class="w-full"
                    >{{ old('description') }}</x-textarea-with-label>
                    @error('description')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-1 space-y-2">
                    <label class="block text-sm font-medium text-gray-800">Sede principal</label>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_main" value="0">
                        <x-switch-basic
                            switch-name="is_main"
                            :checked="old('is_main', false)"
                            value="1"
                        />
                        <span class="text-sm text-gray-600">Establecer como sede principal</span>
                    </div>
                    <p class="text-xs text-gray-500">Solo puede haber una sede principal por tienda.</p>
                </div>

                <div class="md:col-span-1 space-y-2">
                    <label class="block text-sm font-medium text-gray-800">Estado</label>
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        <x-switch-basic
                            switch-name="is_active"
                            :checked="old('is_active', true)"
                            value="1"
                        />
                        <span class="text-sm text-gray-600">Sede activa</span>
                    </div>
                    <p class="text-xs text-gray-500">Las sedes inactivas no se mostrarán en el frontend.</p>
                </div>
            </div>
        </x-card-base>

        {{-- CARD: Contacto y ubicación --}}
        <x-card-base title="Contacto y ubicación" shadow="sm">
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div class="md:col-span-1">
                    <x-input-with-label
                        label="Teléfono *"
                        name="phone"
                        placeholder="+57 1 234 5678"
                        :value="old('phone')"
                        :required="true"
                        container-class="w-full"
                    />
                    @error('phone')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-1">
                    <x-input-with-label
                        label="WhatsApp"
                        name="whatsapp"
                        placeholder="+57 300 123 4567"
                        :value="old('whatsapp')"
                        container-class="w-full"
                    />
                    @error('whatsapp')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-1">
                    <x-input-with-label
                        label="Departamento *"
                        name="department"
                        placeholder="Cundinamarca"
                        :value="old('department')"
                        :required="true"
                        container-class="w-full"
                    />
                    @error('department')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-1">
                    <x-input-with-label
                        label="Ciudad *"
                        name="city"
                        placeholder="Bogotá"
                        :value="old('city')"
                        :required="true"
                        container-class="w-full"
                    />
                    @error('city')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <x-input-with-label
                        label="Dirección *"
                        name="address"
                        placeholder="Calle 123 #45-67, Centro"
                        :value="old('address')"
                        :required="true"
                        container-class="w-full"
                    />
                    @error('address')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <x-textarea-with-label
                        label="Mensaje de WhatsApp"
                        textarea-name="whatsapp_message"
                        rows="2"
                        placeholder="Hola, me interesa conocer más sobre sus productos en [Nombre Sede]"
                        container-class="w-full"
                    >{{ old('whatsapp_message') }}</x-textarea-with-label>
                    <p class="text-xs text-gray-500 mt-1">Este mensaje se usará cuando los clientes hagan clic en el botón de WhatsApp.</p>
                    @error('whatsapp_message')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </x-card-base>

        {{-- CARD: Horarios de atención --}}
        <x-card-base title="Horarios de atención" shadow="sm">
            <div class="space-y-6">
                <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                    <label class="block text-sm font-semibold text-gray-800 mb-2">⚡ Aplicar preset rápido</label>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <select
                            x-model="selectedPreset"
                            class="flex-1 px-3 py-2 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-200 text-sm"
                        >
                            <option value="">-- Selecciona un preset --</option>
                            <option value="weekdays-9-6">Lunes a Viernes 9am-6pm</option>
                            <option value="weekdays-sat-10-8">Lunes a Sábado 10am-8pm</option>
                            <option value="everyday-8-10">Todos los días 8am-10pm</option>
                            <option value="24-7">24 horas / 7 días</option>
                            <option value="nightclub">Nocturno (6pm-2am)</option>
                        </select>
                        <x-button-base
                            type="solid"
                            color="info"
                            text="Aplicar preset"
                            html-type="button"
                            @click="applyPreset()"
                            x-bind:disabled="!selectedPreset"
                        />
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Los presets llenan automáticamente los horarios. Puedes ajustarlos después.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Día</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Cerrado</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Horario principal</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Horario adicional</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @php
                                $days = [
                                    0 => 'Domingo',
                                    1 => 'Lunes',
                                    2 => 'Martes',
                                    3 => 'Miércoles',
                                    4 => 'Jueves',
                                    5 => 'Viernes',
                                    6 => 'Sábado',
                                ];

                                $defaultSchedules = [
                                    0 => ['is_closed' => false, 'open_1' => '09:00', 'close_1' => '18:00'],
                                    1 => ['is_closed' => false, 'open_1' => '09:00', 'close_1' => '18:00'],
                                    2 => ['is_closed' => false, 'open_1' => '09:00', 'close_1' => '18:00'],
                                    3 => ['is_closed' => false, 'open_1' => '09:00', 'close_1' => '18:00'],
                                    4 => ['is_closed' => false, 'open_1' => '09:00', 'close_1' => '18:00'],
                                    5 => ['is_closed' => false, 'open_1' => '09:00', 'close_1' => '18:00'],
                                    6 => ['is_closed' => false, 'open_1' => '09:00', 'close_1' => '13:00'],
                                ];
                            @endphp

                            @foreach($days as $dayNum => $dayName)
                                <tr>
                                    <td class="px-4 py-3">
                                        <span class="font-semibold text-gray-900">{{ $dayName }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <label class="flex items-center gap-2 text-sm text-gray-600">
                                            <input
                                                type="checkbox"
                                                name="day_{{ $dayNum }}_closed"
                                                id="day_{{ $dayNum }}_closed"
                                                class="schedule-closed-checkbox h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                                data-day="{{ $dayNum }}"
                                                {{ old("day_{$dayNum}_closed", $defaultSchedules[$dayNum]['is_closed'] ?? false) ? 'checked' : '' }}
                                            >
                                            Cerrado
                                        </label>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2"
                                             :class="{ 'opacity-50': document.getElementById('day_{{ $dayNum }}_closed')?.checked }">
                                            <input
                                                type="time"
                                                name="day_{{ $dayNum }}_open_1"
                                                class="time-input rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-200"
                                                value="{{ old("day_{$dayNum}_open_1", $defaultSchedules[$dayNum]['open_1'] ?? '') }}"
                                                data-day="{{ $dayNum }}"
                                            >
                                            <span class="text-gray-500">a</span>
                                            <input
                                                type="time"
                                                name="day_{{ $dayNum }}_close_1"
                                                class="time-input rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-200"
                                                value="{{ old("day_{$dayNum}_close_1", $defaultSchedules[$dayNum]['close_1'] ?? '') }}"
                                                data-day="{{ $dayNum }}"
                                            >
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2"
                                             :class="{ 'opacity-50': document.getElementById('day_{{ $dayNum }}_closed')?.checked }">
                                            <input
                                                type="time"
                                                name="day_{{ $dayNum }}_open_2"
                                                class="time-input rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-200"
                                                value="{{ old("day_{$dayNum}_open_2", $defaultSchedules[$dayNum]['open_2'] ?? '') }}"
                                                data-day="{{ $dayNum }}"
                                            >
                                            <span class="text-gray-500">a</span>
                                            <input
                                                type="time"
                                                name="day_{{ $dayNum }}_close_2"
                                                class="time-input rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-200"
                                                value="{{ old("day_{$dayNum}_close_2", $defaultSchedules[$dayNum]['close_2'] ?? '') }}"
                                                data-day="{{ $dayNum }}"
                                            >
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500">Opcional (ej. horario de tarde)</p>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <x-button-icon
                                            type="soft"
                                            color="secondary"
                                            size="sm"
                                            icon="copy"
                                            text="Copiar"
                                            html-type="button"
                                            @click="openCopyModal({{ $dayNum }})"
                                        />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Modal: Copiar horario --}}
                <div
                    x-show="showCopyModal"
                    x-cloak
                    class="fixed inset-0 z-50 flex items-center justify-center px-4"
                    style="display: none;"
                >
                    <div class="absolute inset-0 bg-gray-900/50" @click="showCopyModal = false"></div>
                    <div class="relative w-full max-w-md rounded-xl border border-gray-200 bg-white p-6 shadow-lg">
                        <h4 class="text-base font-semibold text-gray-900 mb-4">
                            Copiar horario de <span x-text="getDayName(copyFromDay)"></span>
                        </h4>
                        <p class="text-sm text-gray-600 mb-4">Selecciona los días a los que deseas copiar este horario:</p>
                        <div class="space-y-2 mb-6">
                            <template x-for="day in [0,1,2,3,4,5,6]" :key="day">
                                <label
                                    x-show="day !== copyFromDay"
                                    class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer"
                                >
                                    <input
                                        type="checkbox"
                                        :value="day"
                                        x-model="copyToDays"
                                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    >
                                    <span x-text="getDayName(day)"></span>
                                </label>
                            </template>
                        </div>
                        <div class="flex gap-3">
                            <x-button-base
                                type="outline"
                                color="secondary"
                                text="Cancelar"
                                html-type="button"
                                class="flex-1"
                                @click="showCopyModal = false"
                            />
                            <x-button-base
                                type="solid"
                                color="info"
                                text="Copiar horario"
                                html-type="button"
                                class="flex-1"
                                @click="copySchedule()"
                                x-bind:disabled="copyToDays.length === 0"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </x-card-base>

        {{-- CARD: Redes sociales --}}
        <x-card-base title="Redes sociales" shadow="sm">
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                @foreach($platforms as $platform => $label)
                    <div>
                        <x-input-with-label
                            label="{{ $label }}"
                            name="social_{{ $platform }}"
                            placeholder="https://{{ $platform }}.com/mi-sede"
                            value="{{ old('social_' . $platform) }}"
                            container-class="w-full"
                            type="url"
                        />
                        @error("social_{$platform}")
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>
        </x-card-base>

        {{-- ACTIONS --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('tenant.admin.locations.index', ['store' => $store->slug]) }}">
                <x-button-base
                    type="outline"
                    color="error"
                    text="Cancelar"
                />
            </a>
            <x-button-icon
                type="solid"
                color="dark"
                icon="save"
                text="Guardar sede"
                html-type="submit"
            />
        </div>
    </form>

</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('locationForm', () => ({
        showNotification: false,
        notificationMessage: '',
        notificationType: 'success',
        selectedPreset: '',
        showCopyModal: false,
        copyFromDay: null,
        copyToDays: [],
        
        init() {
            // Initialize form behavior
            this.initScheduleCheckboxes();
        },
        
        initScheduleCheckboxes() {
            const self = this;
            document.querySelectorAll('.schedule-closed-checkbox').forEach(checkbox => {
                // Remove old event listeners if any
                const oldListener = checkbox._changeListener;
                if (oldListener) {
                    checkbox.removeEventListener('change', oldListener);
                }
                
                // Create a new event listener
                const newListener = function() {
                    const day = this.dataset.day;
                    const open1 = document.querySelector(`[name="day_${day}_open_1"]`);
                    const close1 = document.querySelector(`[name="day_${day}_close_1"]`);
                    const open2 = document.querySelector(`[name="day_${day}_open_2"]`);
                    const close2 = document.querySelector(`[name="day_${day}_close_2"]`);
                    
                    if (this.checked) {
                        // Día cerrado: deshabilitar campos
                        open1.disabled = true;
                        close1.disabled = true;
                        open2.disabled = true;
                        close2.disabled = true;
                    } else {
                        // Día abierto: habilitar campos
                        open1.disabled = false;
                        close1.disabled = false;
                        open2.disabled = false;
                        close2.disabled = false;
                        
                        // Autocompletar horario principal si está vacío O si tiene valores inválidos
                        if (!open1.value || open1.value === '' || open1.value === '00:00') {
                            open1.value = '09:00';
                        }
                        if (!close1.value || close1.value === '' || close1.value === '00:00') {
                            close1.value = '18:00';
                        }
                        
                        // Validar que la hora de apertura sea menor que la de cierre
                        if (open1.value >= close1.value) {
                            open1.value = '09:00';
                            close1.value = '18:00';
                        }
                    }
                };
                
                // Store the listener reference for future cleanup
                checkbox._changeListener = newListener;
                
                // Add the event listener
                checkbox.addEventListener('change', newListener);
                
                // Set initial state
                newListener.call(checkbox);
            });
        },
        
        getDayName(dayNum) {
            const days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
            return days[dayNum] || '';
        },
        
        showNotificationMessage(message, type = 'success') {
            this.notificationMessage = message;
            this.notificationType = type;
            this.showNotification = true;
            
            setTimeout(() => {
                this.showNotification = false;
            }, 5000);
        },
        
        applyPreset() {
            if (!this.selectedPreset) return;
            
            const presets = {
                'weekdays-9-6': {
                    0: { closed: true },
                    1: { open1: '09:00', close1: '18:00' },
                    2: { open1: '09:00', close1: '18:00' },
                    3: { open1: '09:00', close1: '18:00' },
                    4: { open1: '09:00', close1: '18:00' },
                    5: { open1: '09:00', close1: '18:00' },
                    6: { closed: true }
                },
                'weekdays-sat-10-8': {
                    0: { closed: true },
                    1: { open1: '10:00', close1: '20:00' },
                    2: { open1: '10:00', close1: '20:00' },
                    3: { open1: '10:00', close1: '20:00' },
                    4: { open1: '10:00', close1: '20:00' },
                    5: { open1: '10:00', close1: '20:00' },
                    6: { open1: '10:00', close1: '20:00' }
                },
                'everyday-8-10': {
                    0: { open1: '08:00', close1: '22:00' },
                    1: { open1: '08:00', close1: '22:00' },
                    2: { open1: '08:00', close1: '22:00' },
                    3: { open1: '08:00', close1: '22:00' },
                    4: { open1: '08:00', close1: '22:00' },
                    5: { open1: '08:00', close1: '22:00' },
                    6: { open1: '08:00', close1: '22:00' }
                },
                '24-7': {
                    0: { open1: '00:00', close1: '23:59' },
                    1: { open1: '00:00', close1: '23:59' },
                    2: { open1: '00:00', close1: '23:59' },
                    3: { open1: '00:00', close1: '23:59' },
                    4: { open1: '00:00', close1: '23:59' },
                    5: { open1: '00:00', close1: '23:59' },
                    6: { open1: '00:00', close1: '23:59' }
                },
                'nightclub': {
                    0: { closed: true },
                    1: { closed: true },
                    2: { closed: true },
                    3: { closed: true },
                    4: { open1: '18:00', close1: '02:00' },
                    5: { open1: '18:00', close1: '02:00' },
                    6: { open1: '18:00', close1: '02:00' }
                }
            };
            
            const preset = presets[this.selectedPreset];
            if (!preset) return;
            
            for (let day in preset) {
                const config = preset[day];
                const checkbox = document.querySelector(`[name="day_${day}_closed"]`);
                const open1 = document.querySelector(`[name="day_${day}_open_1"]`);
                const close1 = document.querySelector(`[name="day_${day}_close_1"]`);
                const open2 = document.querySelector(`[name="day_${day}_open_2"]`);
                const close2 = document.querySelector(`[name="day_${day}_close_2"]`);
                
                if (config.closed) {
                    checkbox.checked = true;
                } else {
                    checkbox.checked = false;
                    open1.value = config.open1;
                    close1.value = config.close1;
                    open2.value = config.open2 || '';
                    close2.value = config.close2 || '';
                }
                
                // Trigger change event
                checkbox.dispatchEvent(new Event('change'));
            }
            
            this.showNotificationMessage('Los horarios se configuraron automáticamente.', 'success');
        },
        
        openCopyModal(dayNum) {
            this.copyFromDay = dayNum;
            this.copyToDays = [];
            this.showCopyModal = true;
        },
        
        copySchedule() {
            if (this.copyToDays.length === 0) return;
            
            const fromDay = this.copyFromDay;
            const fromCheckbox = document.querySelector(`[name="day_${fromDay}_closed"]`);
            const fromOpen1 = document.querySelector(`[name="day_${fromDay}_open_1"]`);
            const fromClose1 = document.querySelector(`[name="day_${fromDay}_close_1"]`);
            const fromOpen2 = document.querySelector(`[name="day_${fromDay}_open_2"]`);
            const fromClose2 = document.querySelector(`[name="day_${fromDay}_close_2"]`);
            
            this.copyToDays.forEach(toDay => {
                const toCheckbox = document.querySelector(`[name="day_${toDay}_closed"]`);
                const toOpen1 = document.querySelector(`[name="day_${toDay}_open_1"]`);
                const toClose1 = document.querySelector(`[name="day_${toDay}_close_1"]`);
                const toOpen2 = document.querySelector(`[name="day_${toDay}_open_2"]`);
                const toClose2 = document.querySelector(`[name="day_${toDay}_close_2"]`);
                
                toCheckbox.checked = fromCheckbox.checked;
                toOpen1.value = fromOpen1.value;
                toClose1.value = fromClose1.value;
                toOpen2.value = fromOpen2.value;
                toClose2.value = fromClose2.value;
                
                // Trigger change event
                toCheckbox.dispatchEvent(new Event('change'));
            });
            
            this.showCopyModal = false;
            
            this.showNotificationMessage(`Se copió el horario a ${this.copyToDays.length} día(s).`, 'success');
        }
    }));
});
</script>
@endpush
@endsection
</x-tenant-admin-layout>
