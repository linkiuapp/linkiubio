@extends('design-system::layout')

@section('page-title', 'Progress')
@section('page-description', 'Componentes de barras de progreso basados en Preline UI')

@section('content')
{{-- SECTION: Progress Básico --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Progress Básico
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: basic --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Barra de Progreso Simple</h4>
            <x-progress-basic :value="25" />
        </div>
        
        {{-- ITEM: heights --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Diferentes Alturas</h4>
            <div class="space-y-2">
                <x-progress-basic :value="25" height="h-1.5" />
                <x-progress-basic :value="50" height="h-4" />
            </div>
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Indicadores de progreso, cargas, procesos</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites barras complejas con múltiples segmentos</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-progress-basic :value="25" /&gt;
&lt;x-progress-basic :value="50" height="h-4" /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Progress con Label --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Progress con Label
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: with-label --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Con Porcentaje al Final</h4>
            <div class="space-y-5">
                <x-progress-with-label :value="25" />
                <x-progress-with-label :value="50" />
                <x-progress-with-label :value="75" />
                <x-progress-with-label :value="100" />
            </div>
        </div>
        
        {{-- ITEM: with-icon --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Con Iconos</h4>
            <div class="space-y-5">
                <x-progress-with-label :value="80" color="red" :showIcon="true" iconType="error" />
                <x-progress-with-label :value="100" color="green" :showIcon="true" iconType="check" />
            </div>
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Progreso con porcentaje visible, indicadores con texto</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites barras simples sin texto</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-progress-with-label :value="25" /&gt;
&lt;x-progress-with-label :value="100" color="green" :showIcon="true" iconType="check" /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Progress con Título --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Progress con Título
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: with-title --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Con Título y Porcentaje</h4>
            <div class="space-y-5">
                <x-progress-with-title title="Progress title" :value="25" />
                <x-progress-with-title title="Progress title" :value="50" />
                <x-progress-with-title title="Progress title" :value="75" />
                <x-progress-with-title title="Progress title" :value="100" />
            </div>
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Progreso con descripción, tareas con título</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites barras simples sin título</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-progress-with-title 
    title="Progress title" 
    :value="25" 
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Progress Multiple --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Progress Multiple
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: multiple --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Barras con Múltiples Segmentos</h4>
            <x-progress-multiple 
                :segments="[
                    ['value' => 25, 'color' => 'blue'],
                    ['value' => 15, 'color' => 'blue-dark'],
                    ['value' => 30, 'color' => 'gray'],
                    ['value' => 5, 'color' => 'orange']
                ]"
            />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Progreso con diferentes categorías, estadísticas segmentadas</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites una sola barra de progreso</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-progress-multiple 
    :segments="[
        ['value' => 25, 'color' => 'blue'],
        ['value' => 15, 'color' => 'blue-dark'],
        ['value' => 30, 'color' => 'gray']
    ]"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Progress Vertical --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Progress Vertical
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: vertical --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Barras Verticales</h4>
            <div class="flex gap-x-8">
                <x-progress-vertical :value="25" />
                <x-progress-vertical :value="50" />
                <x-progress-vertical :value="75" />
                <x-progress-vertical :value="90" />
                <x-progress-vertical :value="17" />
            </div>
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Progreso vertical, indicadores de altura, gráficos verticales</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites barras horizontales estándar</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-progress-vertical :value="25" height="h-32" /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Variaciones de Color --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Variaciones de Color
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: colors --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Colores Predefinidos</h4>
            <div class="space-y-5">
                <x-progress-basic :value="50" color="dark" />
                <x-progress-basic :value="50" color="gray" />
                <x-progress-basic :value="50" color="green" />
                <x-progress-basic :value="50" color="red" />
                <x-progress-basic :value="50" color="yellow" />
                <x-progress-basic :value="50" color="blue" />
            </div>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-progress-basic :value="50" color="blue" /&gt;
&lt;x-progress-basic :value="50" color="red" /&gt;
&lt;x-progress-basic :value="50" color="green" /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Props Documentation --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Documentación de Props
    </h4>
    
    <div class="mt-4 body-small text-brandNeutral-200 space-y-4">
        <div>
            <p><strong>ProgressBasic props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>value</code>: Valor del progreso (0-100) - required</li>
                <li><code>color</code>: Color de la barra ('blue', 'gray', 'dark', 'green', 'red', 'yellow', 'white') - default: 'blue'</li>
                <li><code>height</code>: Altura ('h-1.5', 'h-2', 'h-4') - default: 'h-1.5'</li>
            </ul>
        </div>
        
        <div>
            <p><strong>ProgressWithLabel props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>value</code>, <code>color</code>, <code>height</code>: Igual que ProgressBasic</li>
                <li><code>showIcon</code>: Si mostrar icono en lugar de porcentaje (default: false)</li>
                <li><code>iconType</code>: Tipo de icono ('check' o 'error') - default: 'check'</li>
            </ul>
        </div>
        
        <div>
            <p><strong>ProgressWithTitle props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>title</code>: Título del progreso (required)</li>
                <li><code>value</code>, <code>color</code>, <code>height</code>: Igual que ProgressBasic</li>
            </ul>
        </div>
        
        <div>
            <p><strong>ProgressMultiple props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>segments</code>: Array de objetos con 'value' y 'color' (required)</li>
                <li><code>height</code>: Altura (default: 'h-1.5')</li>
            </ul>
        </div>
        
        <div>
            <p><strong>ProgressVertical props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>value</code>, <code>color</code>: Igual que ProgressBasic</li>
                <li><code>height</code>: Altura del contenedor (default: 'h-32')</li>
                <li><code>width</code>: Ancho de la barra (default: 'w-2')</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar iconos de Lucide
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    } else if (typeof createIcons !== 'undefined') {
        createIcons();
    }
});
</script>
@endpush















