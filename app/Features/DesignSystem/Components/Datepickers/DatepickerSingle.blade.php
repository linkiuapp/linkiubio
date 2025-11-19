{{--
Datepicker Single - Componente funcional de calendario con Litepicker integrado
Uso: Selectores de fecha única, formularios que requieren una fecha específica
Cuándo usar: Reservas, fechas de entrega, fechas límite
Cuándo NO usar: Cuando necesites seleccionar rangos de fechas o hora específica
Ejemplo: <x-datepicker-single name="fecha" value="2023-07-20" />
--}}

@props([
    'name' => 'date',
    'id' => null,
    'value' => '',
    'placeholder' => 'Seleccionar fecha',
    'minDate' => null, // Fecha mínima (formato YYYY-MM-DD o Date)
    'maxDate' => null, // Fecha máxima (formato YYYY-MM-DD o Date)
    'disabledDates' => [], // Array de fechas deshabilitadas
    'width' => 'w-80', // Ancho del datepicker
    'required' => false,
    'disabled' => false,
])

@php
    $inputId = $id ?: 'datepicker-' . uniqid();
    $datepickerId = 'datepicker-container-' . uniqid();
@endphp

<div class="{{ $width }} relative" id="{{ $datepickerId }}" {{ $attributes }}>
    <!-- Input oculto para Litepicker -->
    <input type="text" 
           id="{{ $inputId }}"
           name="{{ $name }}"
           value="{{ $value }}"
           placeholder="{{ $placeholder }}"
           class="datepicker-preline-input py-2.5 sm:py-3 px-4 pe-11 block w-full border border-gray-200 rounded-lg body-small focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
           {{ $required ? 'required' : '' }}
           {{ $disabled ? 'disabled' : '' }}
           autocomplete="off">
    
    <!-- Icono de calendario -->
    <div class="absolute inset-y-0 end-0 flex items-center pe-4 pointer-events-none">
        <i data-lucide="calendar" class="w-5 h-5 text-gray-400"></i>
    </div>
</div>

@push('scripts')
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
        // Usar la función global del proyecto
        Litepicker = await loadLitepicker();
    } else {
        // Si no está disponible, intentar cargar manualmente
        try {
            // Verificar si Litepicker está disponible globalmente
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
        // Personalizar clases CSS para estilo Preline UI
        setup: (picker) => {
            picker.on('show', (ui) => {
                // Aplicar estilos Preline UI al contenedor de Litepicker
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
        
        // Guardar referencia para poder destruirlo si es necesario
        input._litepicker = picker;
    } catch (error) {
        console.error('Error al inicializar Litepicker:', error);
    }
});
</script>
@endpush

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

