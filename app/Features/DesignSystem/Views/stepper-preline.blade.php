@extends('design-system::layout')

@section('page-title', 'Stepper')
@section('page-description', 'Componentes de stepper basados en Preline UI')

@section('content')
{{-- SECTION: Stepper Dynamic Linear --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Stepper Dynamic Linear
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: Dynamic Linear --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Stepper con Navegación Lineal</h4>
            @php
                $linearSteps = [
                    [
                        'label' => 'Step',
                        'content' => '<div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl"><h3 class="text-gray-500">First content</h3></div>',
                    ],
                    [
                        'label' => 'Step',
                        'content' => '<div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl"><h3 class="text-gray-500">Second content</h3></div>',
                    ],
                    [
                        'label' => 'Step',
                        'content' => '<div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl"><h3 class="text-gray-500">Third content</h3></div>',
                    ],
                    [
                        'label' => 'Final',
                        'content' => '<div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl"><h3 class="text-gray-500">Final content</h3></div>',
                        'isFinal' => true,
                    ],
                ];
            @endphp
            <x-stepper-dynamic-linear :steps="$linearSteps" :currentIndex="1" />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Formularios multi-paso, procesos de configuración, wizards</p>
            <p><strong>❌ NO usar para:</strong> Cuando no necesites navegación secuencial entre pasos</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-stepper-dynamic-linear 
    :steps="[
        ['label' => 'Paso 1', 'content' => '...'],
        ['label' => 'Paso 2', 'content' => '...'],
    ]"
    :currentIndex="1"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Stepper Non Linear --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Stepper Non Linear
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: Non Linear --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Stepper con Navegación No Lineal</h4>
            @php
                $nonLinearSteps = [
                    [
                        'label' => 'Step',
                        'content' => '<div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl"><h3 class="text-gray-500">First content</h3></div>',
                    ],
                    [
                        'label' => 'Step',
                        'content' => '<div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl"><h3 class="text-gray-500">Second content</h3></div>',
                    ],
                    [
                        'label' => 'Step',
                        'content' => '<div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl"><h3 class="text-gray-500">Third content</h3></div>',
                    ],
                    [
                        'label' => 'Final',
                        'content' => '<div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl"><h3 class="text-gray-500">Final content</h3></div>',
                        'isFinal' => true,
                    ],
                ];
            @endphp
            <x-stepper-non-linear :steps="$nonLinearSteps" />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Cuando los pasos pueden completarse independientemente</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites navegación secuencial obligatoria</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-stepper-non-linear 
    :steps="[
        ['label' => 'Paso 1', 'content' => '...'],
        ['label' => 'Paso 2', 'content' => '...'],
    ]"
    :currentIndex="1"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Stepper Skipped --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Stepper Skipped
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: Skipped --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Stepper con Pasos Opcionales</h4>
            @php
                $skippedSteps = [
                    [
                        'label' => 'Step',
                        'content' => '<div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl"><h3 class="text-gray-500">First content</h3></div>',
                        'isOptional' => true,
                    ],
                    [
                        'label' => 'Step',
                        'content' => '<div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl"><h3 class="text-gray-500">Second content</h3></div>',
                        'isOptional' => true,
                    ],
                    [
                        'label' => 'Step',
                        'content' => '<div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl"><h3 class="text-gray-500">Third content</h3></div>',
                    ],
                    [
                        'label' => 'Final',
                        'content' => '<div class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl"><h3 class="text-gray-500">Final content</h3></div>',
                        'isFinal' => true,
                    ],
                ];
            @endphp
            <x-stepper-skipped :steps="$skippedSteps" :currentIndex="1" />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Cuando algunos pasos son opcionales en el proceso</p>
            <p><strong>❌ NO usar para:</strong> Cuando todos los pasos son obligatorios</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-stepper-skipped 
    :steps="[
        ['label' => 'Paso 1', 'content' => '...', 'isOptional' => true],
        ['label' => 'Paso 2', 'content' => '...'],
    ]"
    :currentIndex="1"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Props Documentation --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Documentación de Props
    </h4>
    
    <div class="mt-4 body-small text-brandNeutral-200 space-y-4">
        <div>
            <p><strong>Props compartidos por todos los componentes Stepper:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>steps</code>: Array de pasos (requerido).</li>
                <li><code>stepperId</code>: ID único para el stepper (opcional, se genera automáticamente).</li>
                <li><code>currentIndex</code>: Índice del paso actual (default: 1).</li>
            </ul>
        </div>
        
        <div>
            <p><strong>Props en cada objeto `step` dentro del array `steps`:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>label</code>: Etiqueta del paso (requerido).</li>
                <li><code>content</code>: Contenido HTML del paso (requerido).</li>
                <li><code>isOptional</code>: Si el paso es opcional (default: false).</li>
                <li><code>isCompleted</code>: Si el paso está completado (default: false).</li>
                <li><code>isFinal</code>: Si es el paso final (default: false, el último paso es final si ninguno lo está).</li>
            </ul>
        </div>
        
        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <h4 class="body-lg-medium text-blue-900 mb-2">💡 Nota Importante</h4>
            <div class="body-small text-blue-800 space-y-2">
                <p>Los componentes Stepper requieren <strong>Preline UI JavaScript</strong> para funcionar correctamente. El JavaScript se carga automáticamente desde el layout del Design System.</p>
                <p>Los componentes usan los atributos <code>data-hs-stepper</code> y <code>data-hs-stepper-*</code> de Preline UI para la funcionalidad.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    } else if (typeof createIcons !== 'undefined') {
        createIcons();
    }
    
    // Preline UI se inicializa automáticamente desde el layout
});
</script>
@endpush

