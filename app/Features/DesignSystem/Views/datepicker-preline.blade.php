@extends('design-system::layout')

@section('title', 'Datepicker Preline UI')
@section('page-title', 'Datepicker Components')
@section('page-description', 'Componentes de datepicker basados exactamente en Preline UI')

@section('content')

{{-- SECTION: Single Datepicker --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Datepicker Funcional con Litepicker
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: datepicker-basic --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Datepicker Básico</h4>
            <x-datepicker-single 
                name="fecha_basica"
                placeholder="Selecciona una fecha"
            />
            <div class="body-small text-brandNeutral-200">
                <p><strong>✅ Usar para:</strong> Reservas, fechas de entrega, fechas límite</p>
                <p><strong>❌ NO usar para:</strong> Rangos de fechas, selección de hora</p>
            </div>
        </div>

        {{-- ITEM: datepicker-with-value --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Con Valor Predefinido</h4>
            <x-datepicker-single 
                name="fecha_con_valor"
                value="2024-12-25"
                placeholder="Selecciona una fecha"
            />
        </div>

        {{-- ITEM: datepicker-with-min-date --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Con Fecha Mínima (Desde Hoy)</h4>
            <x-datepicker-single 
                name="fecha_minima"
                :minDate="now()->format('Y-m-d')"
                placeholder="Solo fechas futuras"
            />
        </div>

        {{-- ITEM: datepicker-with-disabled-dates --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Con Fechas Deshabilitadas</h4>
            <x-datepicker-single 
                name="fecha_con_deshabilitadas"
                :disabledDates="[
                    now()->addDays(1)->format('Y-m-d'),
                    now()->addDays(2)->format('Y-m-d'),
                    now()->addDays(3)->format('Y-m-d'),
                ]"
                placeholder="Algunas fechas no disponibles"
            />
        </div>
    </div>
    
    {{-- SECTION: Datepicker Range --}}
    <div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
        <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
            Datepicker de Rango
        </h4>
        
        <div class="space-y-8">
            {{-- ITEM: datepicker-range-basic --}}
            <div class="space-y-4">
                <h4 class="body-lg-medium text-brandNeutral-400">Rango de Fechas Básico</h4>
                <x-datepicker-range 
                    nameStart="fecha_inicio"
                    nameEnd="fecha_fin"
                    placeholder="Seleccionar rango"
                />
                <div class="body-small text-brandNeutral-200">
                    <p><strong>✅ Usar para:</strong> Reservas de hotel, reportes por período, filtros de fecha</p>
                    <p><strong>❌ NO usar para:</strong> Cuando solo necesites una fecha única</p>
                </div>
            </div>
        </div>
        
        <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
            <pre class="body-small text-brandNeutral-300"><code>&lt;x-datepicker-range 
    nameStart="fecha_inicio" 
    nameEnd="fecha_fin" 
    placeholder="Seleccionar rango" 
/&gt;</code></pre>
        </div>
    </div>
    
    {{-- SECTION: Datepicker With Time --}}
    <div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
        <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
            Datepicker con Hora
        </h4>
        
        <div class="space-y-8">
            {{-- ITEM: datepicker-time-24h --}}
            <div class="space-y-4">
                <h4 class="body-lg-medium text-brandNeutral-400">Formato 24 Horas</h4>
                <x-datepicker-with-time 
                    name="fecha_hora_24"
                    placeholder="Seleccionar fecha y hora"
                />
            </div>
            
            {{-- ITEM: datepicker-time-ampm --}}
            <div class="space-y-4">
                <h4 class="body-lg-medium text-brandNeutral-400">Formato 12 Horas (AM/PM)</h4>
                <x-datepicker-with-time 
                    name="fecha_hora_12"
                    :showAmPm="true"
                    placeholder="Seleccionar fecha y hora"
                />
            </div>
            
            <div class="body-small text-brandNeutral-200">
                <p><strong>✅ Usar para:</strong> Reservas con hora específica, citas, eventos programados</p>
                <p><strong>❌ NO usar para:</strong> Cuando solo necesites fecha o rango de fechas</p>
            </div>
        </div>
        
        <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
            <pre class="body-small text-brandNeutral-300"><code>&lt;x-datepicker-with-time 
    name="fecha_hora" 
    placeholder="Seleccionar fecha y hora" 
/&gt;

&lt;x-datepicker-with-time 
    name="fecha_hora" 
    :showAmPm="true"
    placeholder="Seleccionar fecha y hora" 
/&gt;</code></pre>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-datepicker-single 
    name="fecha" 
    placeholder="Selecciona una fecha" 
/&gt;

&lt;x-datepicker-single 
    name="fecha" 
    value="2024-12-25" 
    :minDate="now()->format('Y-m-d')"
    :disabledDates="['2024-12-24', '2024-12-26']"
/&gt;</code></pre>
    </div>
    
    <div class="mt-4 body-small text-brandNeutral-200 space-y-1">
        <p><strong>Props disponibles para DatepickerSingle:</strong></p>
        <ul class="list-disc list-inside space-y-1 ml-4">
            <li><code>name</code>: Nombre del input (required para formularios)</li>
            <li><code>id</code>: ID del input (opcional, se genera automáticamente)</li>
            <li><code>value</code>: Valor inicial (formato YYYY-MM-DD)</li>
            <li><code>placeholder</code>: Texto placeholder del input</li>
            <li><code>minDate</code>: Fecha mínima seleccionable (formato YYYY-MM-DD)</li>
            <li><code>maxDate</code>: Fecha máxima seleccionable (formato YYYY-MM-DD)</li>
            <li><code>disabledDates</code>: Array de fechas deshabilitadas (formato YYYY-MM-DD)</li>
            <li><code>width</code>: Ancho del datepicker (default: 'w-80')</li>
            <li><code>required</code>: Si el campo es requerido</li>
            <li><code>disabled</code>: Si el campo está deshabilitado</li>
        </ul>
        
        <p class="mt-4"><strong>Props disponibles para DatepickerRange:</strong></p>
        <ul class="list-disc list-inside space-y-1 ml-4">
            <li><code>nameStart</code>: Nombre del input de fecha inicial</li>
            <li><code>nameEnd</code>: Nombre del input de fecha final</li>
            <li><code>idStart</code>: ID del input inicial (opcional)</li>
            <li><code>idEnd</code>: ID del input final (opcional)</li>
            <li><code>valueStart</code>: Valor inicial de fecha inicio (formato YYYY-MM-DD)</li>
            <li><code>valueEnd</code>: Valor inicial de fecha fin (formato YYYY-MM-DD)</li>
            <li><code>placeholder</code>: Texto placeholder de ambos inputs</li>
            <li><code>minDate</code>, <code>maxDate</code>, <code>disabledDates</code>: Igual que DatepickerSingle</li>
        </ul>
        
        <p class="mt-4"><strong>Props disponibles para DatepickerWithTime:</strong></p>
        <ul class="list-disc list-inside space-y-1 ml-4">
            <li><code>name</code>: Nombre del input de fecha</li>
            <li><code>nameTime</code>: Nombre base para campos de hora (opcional, crea campos separados)</li>
            <li><code>value</code>: Valor inicial (formato YYYY-MM-DD o YYYY-MM-DD HH:mm)</li>
            <li><code>valueTime</code>: Valor inicial de hora (formato HH:mm)</li>
            <li><code>showAmPm</code>: Si mostrar formato 12h con AM/PM (default: false, usa 24h)</li>
            <li><code>placeholder</code>: Texto placeholder del input de fecha</li>
            <li><code>placeholderTime</code>: Texto placeholder de hora</li>
            <li><code>minDate</code>, <code>maxDate</code>, <code>disabledDates</code>: Igual que DatepickerSingle</li>
        </ul>
    </div>
</div>

{{-- SECTION: Información Técnica --}}
<div class="bg-brandInfo-50 border border-brandInfo-200 rounded-xl p-6 mb-8">
    <div class="flex items-start gap-3">
        <i data-lucide="info" class="w-5 h-5 text-brandInfo-300 flex-shrink-0 mt-0.5"></i>
        <div>
            <h4 class="body-lg-medium text-brandInfo-400 mb-2">Integración con Litepicker</h4>
            <p class="body-small text-brandInfo-300 mb-3">
                Este componente está <strong>completamente funcional</strong> y utiliza <strong>Litepicker</strong> 
                (ya implementado en el proyecto) para la funcionalidad de calendario. El estilo visual está inspirado 
                en Preline UI y se integra perfectamente con el Design System.
            </p>
            <ul class="body-small text-brandInfo-300 space-y-1 list-disc list-inside ml-4">
                <li>✅ Carga dinámica de Litepicker (lazy loading)</li>
                <li>✅ Estilo visual de Preline UI</li>
                <li>✅ Soporte para fechas mínimas/máximas</li>
                <li>✅ Fechas deshabilitadas personalizadas</li>
                <li>✅ Integración con formularios Laravel</li>
                <li>✅ Iconos Lucide</li>
                <li>✅ Escalas tipográficas personalizadas</li>
            </ul>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined' && lucide.createIcons) {
            lucide.createIcons();
        } else if (typeof createIcons !== 'undefined') {
            createIcons();
        }
        
        // Esperar a que datepicker.js esté disponible (se carga desde app.js o Vite)
        // Si no está disponible, intentar cargar las funciones después de un breve delay
        function waitForDatepicker() {
            if (typeof loadLitepicker === 'function' || typeof initReservationDatepicker === 'function') {
                return true;
            }
            return false;
        }
        
        // Intentar hasta 10 veces (2 segundos) esperando a que datepicker.js esté disponible
        let attempts = 0;
        const maxAttempts = 10;
        const checkInterval = setInterval(() => {
            attempts++;
            if (waitForDatepicker() || attempts >= maxAttempts) {
                clearInterval(checkInterval);
                if (attempts >= maxAttempts) {
                    console.warn('⚠️ datepicker.js no está disponible. Los datepickers pueden no funcionar correctamente.');
                }
            }
        }, 200);
    });
</script>
@endpush

