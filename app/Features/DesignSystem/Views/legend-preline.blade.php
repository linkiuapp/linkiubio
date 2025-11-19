@extends('design-system::layout')

@section('page-title', 'Legend Indicator')
@section('page-description', 'Componentes de indicadores de leyenda basados en Preline UI')

@section('content')
{{-- SECTION: Legend Indicator Básico --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Legend Indicator Básico
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: basic --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Indicador Básico</h4>
            <x-legend-indicator text="Legend indicator" color="gray" />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Leyendas de gráficos, indicadores de estado, categorías visuales</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites indicadores más complejos o interactivos</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-legend-indicator 
    text="Legend indicator" 
    color="gray" 
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Variaciones de Color --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Variaciones de Color
    </h4>
    
    <div class="space-y-6">
        {{-- ITEM: colors --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Colores Predefinidos</h4>
            <div class="flex flex-wrap gap-6">
                <x-legend-indicator text="Dark" color="dark" />
                <x-legend-indicator text="Gray" color="gray" />
                <x-legend-indicator text="Red" color="red" />
                <x-legend-indicator text="Yellow" color="yellow" />
                <x-legend-indicator text="Green" color="green" />
                <x-legend-indicator text="Blue" color="blue" />
                <x-legend-indicator text="Indigo" color="indigo" />
                <x-legend-indicator text="Purple" color="purple" />
                <x-legend-indicator text="Pink" color="pink" />
                <x-legend-indicator text="Light" color="light" />
            </div>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-legend-indicator text="Dark" color="dark" /&gt;
&lt;x-legend-indicator text="Gray" color="gray" /&gt;
&lt;x-legend-indicator text="Red" color="red" /&gt;
&lt;x-legend-indicator text="Yellow" color="yellow" /&gt;
&lt;x-legend-indicator text="Green" color="green" /&gt;
&lt;x-legend-indicator text="Blue" color="blue" /&gt;
&lt;x-legend-indicator text="Indigo" color="indigo" /&gt;
&lt;x-legend-indicator text="Purple" color="purple" /&gt;
&lt;x-legend-indicator text="Pink" color="pink" /&gt;
&lt;x-legend-indicator text="Light" color="light" /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Props Documentation --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Documentación de Props
    </h4>
    
    <div class="mt-4 body-small text-brandNeutral-200 space-y-4">
        <div>
            <p><strong>LegendIndicator props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>color</code>: Color del punto ('gray', 'dark', 'red', 'yellow', 'green', 'blue', 'indigo', 'purple', 'pink', 'light') - default: 'gray'</li>
                <li><code>text</code>: Texto del indicador (required)</li>
                <li><code>textSize</code>: Tamaño del texto (default: 'body-small')</li>
                <li><code>textColor</code>: Color del texto (default: 'text-gray-600')</li>
                <li><code>size</code>: Tamaño del punto ('size-2', 'size-3', 'size-4') - default: 'size-2'</li>
            </ul>
        </div>
    </div>
</div>
@endsection















