{{--
TimePicker Custom - Time Picker con estilo personalizado
Uso: Selector de hora con dropdown interactivo
Cuándo usar: Cuando necesites que el usuario seleccione una hora específica
Cuándo NO usar: Cuando un input type="time" simple sea suficiente
Ejemplo: <x-time-picker-custom name="time" value="14:30" />
--}}

@props([
    'name' => null,
    'timePickerId' => null,
    'value' => '',
    'placeholder' => 'hh:mm aa',
    'disabled' => false,
])

@php
    $uniqueId = $timePickerId ?? 'time-picker-' . uniqid();
    $nameAttr = $name ?? $uniqueId;
    
    // Preparar el valor inicial de forma segura
    $initialValue = $value ?: '';
    
    // Generar horas (00-23)
    $hours = [];
    for ($i = 0; $i <= 23; $i++) {
        $hours[] = str_pad($i, 2, '0', STR_PAD_LEFT);
    }
    
    // Generar minutos (00-59)
    $minutes = [];
    for ($i = 0; $i <= 59; $i++) {
        $minutes[] = str_pad($i, 2, '0', STR_PAD_LEFT);
    }
@endphp

<div class="w-full max-w-xs" 
     data-initial-value="{{ htmlspecialchars($initialValue, ENT_QUOTES, 'UTF-8') }}"
     x-data="{
    isOpen: false,
    selectedHour: '12',
    selectedMinute: '00',
    selectedPeriod: 'AM',
    displayTime: '',
    actualTime: '',
    
    init() {
        // Leer el valor inicial del atributo data-
        const initialValue = this.$el.getAttribute('data-initial-value') || '';
        this.displayTime = initialValue;
        this.actualTime = initialValue;
        
        if (!this.displayTime) {
            this.setNow();
        } else {
            this.parseTime(this.displayTime);
        }
        this.updateTime();
        
        this.$nextTick(() => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    },
    
    parseTime(timeString) {
        if (!timeString) return;
        const parts = timeString.match(/(\d{1,2}):(\d{2})\s*(AM|PM)?/i);
        if (parts) {
            let hour = parseInt(parts[1]);
            const minute = parts[2];
            const period = parts[3] ? parts[3].toUpperCase() : null;
            
            if (period) {
                if (period === 'PM' && hour !== 12) hour += 12;
                if (period === 'AM' && hour === 12) hour = 0;
                this.selectedPeriod = period;
            } else {
                if (hour >= 12) {
                    this.selectedPeriod = 'PM';
                    if (hour > 12) hour -= 12;
                } else {
                    this.selectedPeriod = 'AM';
                    if (hour === 0) hour = 12;
                }
            }
            
            this.selectedHour = String(hour).padStart(2, '0');
            this.selectedMinute = minute;
        }
    },
    
    updateTime() {
        let hour24 = parseInt(this.selectedHour);
        if (this.selectedPeriod === 'PM' && hour24 !== 12) {
            hour24 += 12;
        } else if (this.selectedPeriod === 'AM' && hour24 === 12) {
            hour24 = 0;
        }
        
        const hour24Str = String(hour24).padStart(2, '0');
        this.actualTime = `${hour24Str}:${this.selectedMinute}`;
        
        const hiddenInput = document.getElementById('{{ $uniqueId }}-hidden');
        if (hiddenInput) {
            hiddenInput.value = this.actualTime;
        }
        
        const hour12 = hour24 > 12 ? hour24 - 12 : (hour24 === 0 ? 12 : hour24);
        this.displayTime = `${String(hour12).padStart(2, '0')}:${this.selectedMinute} ${this.selectedPeriod}`;
    },
    
    setNow() {
        const now = new Date();
        let hour = now.getHours();
        const minute = String(now.getMinutes()).padStart(2, '0');
        
        if (hour >= 12) {
            this.selectedPeriod = 'PM';
            if (hour > 12) hour -= 12;
        } else {
            this.selectedPeriod = 'AM';
            if (hour === 0) hour = 12;
        }
        
        this.selectedHour = String(hour).padStart(2, '0');
        this.selectedMinute = minute;
        this.updateTime();
    },
    
    confirmTime() {
        this.isOpen = false;
    }
}">
    <div class="relative w-full">
        <input 
            type="text" 
            id="{{ $uniqueId }}"
            name="{{ $nameAttr }}"
            x-model="displayTime"
            @click.stop="isOpen = !isOpen"
            placeholder="{{ $placeholder }}"
            @if($disabled) disabled @endif
            class="py-2.5 sm:py-3 ps-4 pe-12 block w-full border border-gray-400 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none cursor-pointer {{ $attributes->get('class') }}"
            {{ $attributes->except('class') }}
            readonly
        >

        <div class="absolute inset-y-0 end-0 flex items-center pe-3 pointer-events-none">
            <button 
                type="button" 
                @click.stop="isOpen = !isOpen"
                class="size-7 shrink-0 inline-flex justify-center items-center rounded-full bg-white text-gray-500 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none pointer-events-auto"
                aria-haspopup="menu"
                :aria-expanded="isOpen"
                aria-label="Dropdown"
            >
                <span class="sr-only">Dropdown</span>
                <i data-lucide="clock" class="shrink-0 size-4"></i>
            </button>
        </div>

        <!-- Dropdown Time Picker -->
        <div 
            x-show="isOpen"
            @click.away="isOpen = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute left-0 top-full z-50 mt-2 w-[280px] bg-white border border-gray-200 shadow-xl rounded-lg"
            role="menu"
            aria-orientation="vertical"
        >
                    <div class="flex flex-row divide-x divide-gray-200 min-h-[200px]">
                        <!-- Hours -->
                        <div class="p-1 max-h-56 overflow-y-auto w-[90px] [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-white [&::-webkit-scrollbar-thumb]:bg-transparent hover:[&::-webkit-scrollbar-thumb]:bg-gray-300">
                            @foreach($hours as $hour)
                                <label 
                                    for="hour-{{ $uniqueId }}-{{ $hour }}" 
                                    class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100"
                                    :class="{ 'bg-blue-600 text-white': selectedHour === '{{ $hour }}' }"
                                >
                                    <input 
                                        type="radio" 
                                        id="hour-{{ $uniqueId }}-{{ $hour }}" 
                                        class="hidden"
                                        name="hour-{{ $uniqueId }}"
                                        value="{{ $hour }}"
                                        x-model="selectedHour"
                                        @change="updateTime()"
                                    >
                                    <span class="block">{{ $hour }}</span>
                                </label>
                            @endforeach
                        </div>
                        <!-- End Hours -->

                        <!-- Minutes -->
                        <div class="p-1 max-h-56 overflow-y-auto w-[90px] [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-white [&::-webkit-scrollbar-thumb]:bg-transparent hover:[&::-webkit-scrollbar-thumb]:bg-gray-300">
                            @foreach($minutes as $minute)
                                <label 
                                    for="minute-{{ $uniqueId }}-{{ $minute }}" 
                                    class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100"
                                    :class="{ 'bg-blue-600 text-white': selectedMinute === '{{ $minute }}' }"
                                >
                                    <input 
                                        type="radio" 
                                        id="minute-{{ $uniqueId }}-{{ $minute }}" 
                                        class="hidden"
                                        name="minute-{{ $uniqueId }}"
                                        value="{{ $minute }}"
                                        x-model="selectedMinute"
                                        @change="updateTime()"
                                    >
                                    <span class="block">{{ $minute }}</span>
                                </label>
                            @endforeach
                        </div>
                        <!-- End Minutes -->

                        <!-- 12-Hour Clock System -->
                        <div class="p-1 max-h-56 overflow-y-auto w-[100px] [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-white [&::-webkit-scrollbar-thumb]:bg-transparent hover:[&::-webkit-scrollbar-thumb]:bg-gray-300">
                            <label 
                                for="am-{{ $uniqueId }}" 
                                class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100"
                                :class="{ 'bg-blue-600 text-white': selectedPeriod === 'AM' }"
                            >
                                <input 
                                    type="radio" 
                                    id="am-{{ $uniqueId }}" 
                                    class="hidden"
                                    name="period-{{ $uniqueId }}"
                                    value="AM"
                                    x-model="selectedPeriod"
                                    @change="updateTime()"
                                >
                                <span class="block">AM</span>
                            </label>
                            <label 
                                for="pm-{{ $uniqueId }}" 
                                class="group relative flex justify-center items-center p-1.5 w-10 text-center text-sm text-gray-800 cursor-pointer rounded-md hover:bg-gray-100"
                                :class="{ 'bg-blue-600 text-white': selectedPeriod === 'PM' }"
                            >
                                <input 
                                    type="radio" 
                                    id="pm-{{ $uniqueId }}" 
                                    class="hidden"
                                    name="period-{{ $uniqueId }}"
                                    value="PM"
                                    x-model="selectedPeriod"
                                    @change="updateTime()"
                                >
                                <span class="block">PM</span>
                            </label>
                        </div>
                        <!-- End 12-Hour Clock System -->
                    </div>

                    <!-- Footer -->
                    <div class="py-2 px-3 flex flex-wrap justify-between items-center gap-2 border-t border-gray-200">
                        <button 
                            type="button" 
                            @click="setNow()"
                            class="text-[13px] font-medium rounded-md bg-white text-blue-600 hover:text-blue-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:text-blue-700"
                        >
                            Ahora
                        </button>
                        <button 
                            type="button" 
                            @click="confirmTime()"
                            class="py-1 px-2.5 text-[13px] font-medium rounded-md bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:ring-2 focus:ring-blue-500"
                        >
                            OK
                        </button>
                    </div>
                    <!-- End Footer -->
                </div>
        <!-- End Dropdown Time Picker -->
    </div>
    
    <!-- Hidden input para el valor real en formato 24 horas -->
    <input type="hidden" id="{{ $uniqueId }}-hidden" name="{{ $nameAttr }}" :value="actualTime" value="{{ $value }}">
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush

