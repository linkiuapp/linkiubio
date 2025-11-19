{{--
Datepicker With Time - Componente funcional de calendario con selector de hora integrado con Litepicker
Uso: Reservas con hora específica, citas, eventos programados
Cuándo usar: Cuando necesites seleccionar fecha y hora específica
Cuándo NO usar: Cuando solo necesites fecha o rango de fechas
Ejemplo: <x-datepicker-with-time name="fecha_hora" value="2024-12-25 14:30" />
--}}

@props([
    'name' => 'date_time',
    'nameTime' => null, // Si se proporciona, el tiempo se guarda en un campo separado
    'id' => null,
    'value' => '', // Formato: YYYY-MM-DD o YYYY-MM-DD HH:mm
    'valueTime' => '', // Formato: HH:mm (solo hora)
    'placeholder' => 'Seleccionar fecha',
    'placeholderTime' => 'Hora',
    'minDate' => null,
    'maxDate' => null,
    'disabledDates' => [],
    'width' => 'w-80',
    'required' => false,
    'disabled' => false,
    'showAmPm' => false, // Si mostrar AM/PM o usar formato 24h
])

@php
    $inputId = $id ?: 'datepicker-time-' . uniqid();
    $timeHourId = 'time-hour-' . uniqid();
    $timeMinuteId = 'time-minute-' . uniqid();
    $timeAmPmId = 'time-ampm-' . uniqid();
    $datepickerId = 'datepicker-time-container-' . uniqid();
    
    // Parsear valor de fecha y hora si viene en formato combinado
    $dateValue = $value;
    $hourValue = '12';
    $minuteValue = '00';
    $ampmValue = 'PM';
    
    if ($value && strpos($value, ' ') !== false) {
        [$dateValue, $timePart] = explode(' ', $value, 2);
        if ($timePart) {
            [$hour, $minute] = explode(':', $timePart, 2);
            $hourValue = $hour ?? '12';
            $minuteValue = $minute ?? '00';
        }
    } elseif ($valueTime) {
        [$hourValue, $minuteValue] = explode(':', $valueTime, 2);
    }
    
    // Convertir a formato 12h si showAmPm es true
    if ($showAmPm && $hourValue) {
        $hourInt = intval($hourValue);
        if ($hourInt >= 12) {
            $ampmValue = 'PM';
            if ($hourInt > 12) {
                $hourValue = str_pad($hourInt - 12, 2, '0', STR_PAD_LEFT);
            }
        } else {
            $ampmValue = 'AM';
            if ($hourInt == 0) {
                $hourValue = '12';
            }
        }
    }
@endphp

<div class="{{ $width }} relative" id="{{ $datepickerId }}" {{ $attributes }}>
    <!-- Input de fecha -->
    <input type="text" 
           id="{{ $inputId }}"
           name="{{ $name }}"
           value="{{ $dateValue }}"
           placeholder="{{ $placeholder }}"
           class="datepicker-preline-input py-2.5 sm:py-3 px-4 pe-11 block w-full border border-gray-200 rounded-lg body-small focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none mb-3"
           {{ $required ? 'required' : '' }}
           {{ $disabled ? 'disabled' : '' }}
           autocomplete="off">
    
    <!-- Icono de calendario -->
    <div class="absolute top-0 end-0 flex items-center pe-4 pointer-events-none" style="top: 0.625rem;">
        <i data-lucide="calendar" class="w-5 h-5 text-gray-400"></i>
    </div>
    
    <!-- Selectores de hora -->
    <div class="flex justify-center items-center gap-x-2">
        <!-- Selector de hora -->
        <div class="relative">
            <select id="{{ $timeHourId }}" 
                    name="{{ $nameTime ? $nameTime . '_hour' : '' }}"
                    class="py-1 px-2 pe-6 body-small border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 appearance-none cursor-pointer bg-white">
                @if($showAmPm)
                    @for($h = 1; $h <= 12; $h++)
                        <option value="{{ str_pad($h, 2, '0', STR_PAD_LEFT) }}" {{ $hourValue == str_pad($h, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                            {{ $h }}
                        </option>
                    @endfor
                @else
                    @for($h = 0; $h < 24; $h++)
                        <option value="{{ str_pad($h, 2, '0', STR_PAD_LEFT) }}" {{ $hourValue == str_pad($h, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                            {{ str_pad($h, 2, '0', STR_PAD_LEFT) }}
                        </option>
                    @endfor
                @endif
            </select>
            <div class="absolute top-1/2 end-2 -translate-y-1/2 pointer-events-none">
                <i data-lucide="chevron-down" class="w-3 h-3 text-gray-500"></i>
            </div>
        </div>
        
        <span class="body-small text-gray-800">:</span>
        
        <!-- Selector de minutos -->
        <div class="relative">
            <select id="{{ $timeMinuteId }}" 
                    name="{{ $nameTime ? $nameTime . '_minute' : '' }}"
                    class="py-1 px-2 pe-6 body-small border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 appearance-none cursor-pointer bg-white">
                @for($m = 0; $m < 60; $m++)
                    <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ $minuteValue == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                        {{ str_pad($m, 2, '0', STR_PAD_LEFT) }}
                    </option>
                @endfor
            </select>
            <div class="absolute top-1/2 end-2 -translate-y-1/2 pointer-events-none">
                <i data-lucide="chevron-down" class="w-3 h-3 text-gray-500"></i>
            </div>
        </div>
        
        @if($showAmPm)
            <!-- Selector AM/PM -->
            <div class="relative">
                <select id="{{ $timeAmPmId }}" 
                        name="{{ $nameTime ? $nameTime . '_ampm' : '' }}"
                        class="py-1 px-2 pe-6 body-small border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 appearance-none cursor-pointer bg-white">
                    <option value="AM" {{ $ampmValue == 'AM' ? 'selected' : '' }}>AM</option>
                    <option value="PM" {{ $ampmValue == 'PM' ? 'selected' : '' }}>PM</option>
                </select>
                <div class="absolute top-1/2 end-2 -translate-y-1/2 pointer-events-none">
                    <i data-lucide="chevron-down" class="w-3 h-3 text-gray-500"></i>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<style>
/* Estilos para integrar Litepicker con Preline UI - Manteniendo estilos base de litepicker-custom.css */
.litepicker.preline-style {
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    border-radius: 0.75rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    border: 1px solid #e5e7eb;
    padding: 12px;
}

.litepicker.preline-style .container__months {
    padding: 12px;
}

.litepicker.preline-style .month-item-header {
    padding: 8px 12px;
    margin-bottom: 8px;
}

.litepicker.preline-style .month-item-title {
    font-size: clamp(0.875rem, 1vw, 1rem);
    font-weight: 600;
    color: #1f2937;
}

.litepicker.preline-style .button-previous-month,
.litepicker.preline-style .button-next-month {
    width: 32px;
    height: 32px;
    border-radius: 9999px;
    transition: all 0.2s;
}

.litepicker.preline-style .button-previous-month:hover,
.litepicker.preline-style .button-next-month:hover {
    background-color: #f3f4f6;
}

.litepicker.preline-style .month-item-weekdays-row {
    padding: 4px 0;
    margin-bottom: 4px;
}

.litepicker.preline-style .month-item-weekdays-row > div {
    font-size: clamp(0.75rem, 0.8vw, 0.875rem);
    font-weight: 600;
    color: #6b7280;
    padding: 4px;
}

.litepicker.preline-style .month-item-wrapper {
    padding: 4px;
}

.litepicker.preline-style .month-item-days-row {
    margin: 2px 0;
}

.litepicker.preline-style .month-item-day-item {
    width: 40px;
    height: 40px;
    font-size: clamp(0.75rem, 0.8vw, 0.875rem);
    border-radius: 9999px;
    margin: 2px;
    transition: all 0.15s;
    border: 1.5px solid transparent;
}

.litepicker.preline-style .month-item-day-item:hover {
    border-color: #2563eb;
    color: #2563eb;
    background-color: transparent;
    transform: scale(1.05);
}

.litepicker.preline-style .month-item-day-item.is-today {
    background-color: #eff6ff;
    color: #2563eb;
    font-weight: 600;
    border-color: #2563eb;
}

.litepicker.preline-style .month-item-day-item.is-selected {
    background-color: #2563eb;
    color: #ffffff;
    font-weight: 600;
    border-color: transparent;
}

.litepicker.preline-style .month-item-day-item.is-selected:hover {
    background-color: #1d4ed8;
}

.litepicker.preline-style .month-item-day-item.is-in-range {
    background-color: #fce7f3;
    color: #da27a7;
}

.litepicker.preline-style .month-item-day-item.is-disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

.litepicker.preline-style .month-item-day-item.is-prev-month-day,
.litepicker.preline-style .month-item-day-item.is-next-month-day {
    opacity: 0.4;
}

/* Responsive */
@media (max-width: 640px) {
    .litepicker.preline-style .container__months {
        padding: 8px;
    }

    .litepicker.preline-style .month-item-day-item {
        width: 32px;
        height: 32px;
        font-size: 13px;
    }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', async function() {
    const input = document.getElementById('{{ $inputId }}');
    if (!input) return;
    
    // Inicializar iconos de Lucide
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    } else if (typeof createIcons !== 'undefined') {
        createIcons();
    }
    
    // Intentar usar la función global loadLitepicker si está disponible
    let Litepicker = null;
    
    if (typeof loadLitepicker === 'function') {
        Litepicker = await loadLitepicker();
    } else {
        try {
            if (typeof window.Litepicker !== 'undefined') {
                Litepicker = window.Litepicker;
            } else {
                console.warn('Litepicker no está disponible. Asegúrate de que datepicker.js esté cargado.');
                return;
            }
        } catch (error) {
            console.warn('Error al cargar Litepicker:', error);
            return;
        }
    }
    
    if (!Litepicker) {
        console.warn('No se pudo cargar Litepicker');
        return;
    }
    
    // Configurar opciones de Litepicker con estilo Preline UI
    const options = {
        element: input,
        format: 'YYYY-MM-DD',
        lang: 'es-ES',
        autoApply: true,
        singleMode: true,
        dropdowns: {
            minYear: new Date().getFullYear() - 5,
            maxYear: new Date().getFullYear() + 5,
            months: true,
            years: true
        },
        @if($minDate)
        minDate: new Date('{{ $minDate }}'),
        @endif
        @if($maxDate)
        maxDate: new Date('{{ $maxDate }}'),
        @endif
        @if(!empty($disabledDates))
        lockDays: [
            @foreach($disabledDates as $date)
            new Date('{{ $date }}'),
            @endforeach
        ],
        @endif
        position: 'auto',
        showTooltip: false,
        setup: (picker) => {
            picker.on('show', (ui) => {
                setTimeout(() => {
                    const container = document.querySelector('.litepicker');
                    if (container) {
                        container.classList.add('preline-style');
                    }
                }, 10);
            });
        }
    };
    
    // Inicializar Litepicker
    try {
        const picker = new Litepicker(options);
        input._litepicker = picker;
    } catch (error) {
        console.error('Error al inicializar Litepicker With Time:', error);
    }
});
</script>
@endpush

