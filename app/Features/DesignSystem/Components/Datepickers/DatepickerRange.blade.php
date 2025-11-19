{{--
Datepicker Range - Componente funcional de calendario para seleccionar rango de fechas con Litepicker integrado
Uso: Selección de rangos de fechas, períodos de tiempo, reservas de varias noches
Cuándo usar: Reservas de hotel, reportes por período, filtros de fecha
Cuándo NO usar: Cuando solo necesites una fecha única
Ejemplo: <x-datepicker-range nameStart="fecha_inicio" nameEnd="fecha_fin" />
--}}

@props([
    'nameStart' => 'date_start',
    'nameEnd' => 'date_end',
    'idStart' => null,
    'idEnd' => null,
    'valueStart' => '',
    'valueEnd' => '',
    'placeholder' => 'Seleccionar rango de fechas',
    'minDate' => null,
    'maxDate' => null,
    'disabledDates' => [],
    'width' => 'w-80',
    'required' => false,
    'disabled' => false,
])

@php
    $inputStartId = $idStart ?: 'datepicker-range-start-' . uniqid();
    $inputEndId = $idEnd ?: 'datepicker-range-end-' . uniqid();
    $datepickerId = 'datepicker-range-container-' . uniqid();
@endphp

<div class="{{ $width }} relative" id="{{ $datepickerId }}" {{ $attributes }}>
    <!-- Input Start -->
    <input type="text" 
           id="{{ $inputStartId }}"
           name="{{ $nameStart }}"
           value="{{ $valueStart }}"
           placeholder="{{ $placeholder }}"
           class="datepicker-preline-input py-2.5 sm:py-3 px-4 pe-11 block w-full border border-gray-200 rounded-lg body-small focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none mb-2"
           {{ $required ? 'required' : '' }}
           {{ $disabled ? 'disabled' : '' }}
           autocomplete="off">
    
    <!-- Icono de calendario Start -->
    <div class="absolute top-0 end-0 flex items-center pe-4 pointer-events-none" style="top: 0.625rem;">
        <i data-lucide="calendar" class="w-5 h-5 text-gray-400"></i>
    </div>
    
    <!-- Input End -->
    <input type="text" 
           id="{{ $inputEndId }}"
           name="{{ $nameEnd }}"
           value="{{ $valueEnd }}"
           placeholder="{{ $placeholder }}"
           class="datepicker-preline-input py-2.5 sm:py-3 px-4 pe-11 block w-full border border-gray-200 rounded-lg body-small focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
           {{ $required ? 'required' : '' }}
           {{ $disabled ? 'disabled' : '' }}
           autocomplete="off">
    
    <!-- Icono de calendario End -->
    <div class="absolute bottom-0 end-0 flex items-center pe-4 pointer-events-none" style="bottom: 0.625rem;">
        <i data-lucide="calendar" class="w-5 h-5 text-gray-400"></i>
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
    const inputStart = document.getElementById('{{ $inputStartId }}');
    const inputEnd = document.getElementById('{{ $inputEndId }}');
    
    if (!inputStart || !inputEnd) return;
    
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
    
    // Configurar opciones de Litepicker para rango
    const options = {
        element: inputStart,
        elementEnd: inputEnd,
        format: 'YYYY-MM-DD',
        lang: 'es-ES',
        autoApply: false, // Para rangos, mostrar botones Apply/Cancel
        singleMode: false, // Modo rango
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
        
        // Guardar referencia
        inputStart._litepicker = picker;
        inputEnd._litepicker = picker;
    } catch (error) {
        console.error('Error al inicializar Litepicker Range:', error);
    }
});
</script>
@endpush

