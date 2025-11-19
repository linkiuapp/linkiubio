@extends('design-system::layout')

@section('page-title', 'Ratings')
@section('page-description', 'Componentes de calificación y valoración basados en Preline UI')

@section('content')
{{-- SECTION: Rating Basic --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Rating Basic
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: basic --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Uso Básico</h4>
            <x-rating-basic name="rating-basic-1" :value="0" />
        </div>
        
        {{-- ITEM: with-value --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Con Valor Seleccionado</h4>
            <x-rating-basic name="rating-basic-2" :value="3" />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Calificaciones de productos, reseñas, valoraciones</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites calificaciones con botones o símbolos personalizados</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-rating-basic name="rating" :value="3" /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Rating Buttons --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Rating Buttons
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: buttons-stars --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Botones con Estrellas</h4>
            <x-rating-buttons :value="4" :max="5" />
        </div>
        
        {{-- ITEM: buttons-hearts --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Botones con Corazones</h4>
            <x-rating-buttons :value="3" :max="5" icon="heart" colorActive="text-red-500" colorInactive="text-gray-300" />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Calificaciones interactivas, valoraciones con botones</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites formularios con radios o calificaciones estáticas</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-rating-buttons :value="4" :max="5" /&gt;
&lt;x-rating-buttons :value="3" :max="5" icon="heart" colorActive="text-red-500" /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Rating Static --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Rating Static
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: static --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Calificación Estática</h4>
            <x-rating-static :value="3" :max="5" />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Mostrar calificaciones existentes, valoraciones de productos</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites que el usuario pueda calificar</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-rating-static :value="4" :max="5" /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Rating Emoji --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Rating Emoji
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: emoji --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Calificación con Emojis</h4>
            <div class="text-center">
                <h3 class="body-lg text-gray-800 mb-4">
                    ¿Respondió esto tu pregunta?
                </h3>
                <x-rating-emoji :emojis="['😔', '😐️', '🤩']" />
            </div>
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Feedback rápido, satisfacción del cliente, encuestas</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites calificaciones numéricas precisas</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-rating-emoji :emojis="['😔', '😐️', '🤩']" /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Rating Thumbs --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Rating Thumbs
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: thumbs --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Calificación con Pulgares</h4>
            <x-rating-thumbs question="¿Fue útil esta página?" />
        </div>
        
        {{-- ITEM: thumbs-active --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Calificación con Pulgares - Activo</h4>
            <x-rating-thumbs question="¿Fue útil esta página?" selected="yes" />
            <x-rating-thumbs question="¿Fue útil esta página?" selected="no" />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Feedback binario, páginas de ayuda, documentación</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites calificaciones con más opciones</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-rating-thumbs question="¿Fue útil esta página?" /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Props Documentation --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Documentación de Props
    </h4>
    
    <div class="mt-4 body-small text-brandNeutral-200 space-y-4">
        <div>
            <p><strong>RatingBasic props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>name</code>: Nombre del input radio (required)</li>
                <li><code>value</code>: Valor seleccionado (0-max) - default: 0</li>
                <li><code>max</code>: Máximo de estrellas - default: 5</li>
                <li><code>disabled</code>: Si está deshabilitado - default: false</li>
                <li><code>required</code>: Si es requerido - default: false</li>
            </ul>
        </div>
        
        <div>
            <p><strong>RatingButtons props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>value</code>: Valor seleccionado (0-max) - default: 0</li>
                <li><code>max</code>: Máximo de estrellas - default: 5</li>
                <li><code>icon</code>: Icono de Lucide (star, heart, etc.) - default: 'star'</li>
                <li><code>colorActive</code>: Color cuando está activo - default: 'text-yellow-400'</li>
                <li><code>colorInactive</code>: Color cuando está inactivo - default: 'text-gray-300'</li>
                <li><code>disabled</code>: Si está deshabilitado - default: false</li>
                <li><code>onChange</code>: Callback cuando cambia el valor (opcional)</li>
            </ul>
        </div>
        
        <div>
            <p><strong>RatingStatic props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>value</code>: Valor a mostrar (0-max) - default: 0</li>
                <li><code>max</code>: Máximo de estrellas - default: 5</li>
                <li><code>icon</code>: Icono de Lucide - default: 'star'</li>
                <li><code>colorActive</code>: Color cuando está activo - default: 'text-yellow-400'</li>
                <li><code>colorInactive</code>: Color cuando está inactivo - default: 'text-gray-300'</li>
            </ul>
        </div>
        
        <div>
            <p><strong>RatingEmoji props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>emojis</code>: Array de emojis - default: ['😔', '😐️', '🤩']</li>
                <li><code>size</code>: Tamaño de los botones - default: 'size-10'</li>
                <li><code>selectedIndex</code>: Índice del emoji seleccionado (opcional)</li>
                <li><code>onSelect</code>: Callback cuando se selecciona un emoji (opcional)</li>
            </ul>
        </div>
        
        <div>
            <p><strong>RatingThumbs props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>question</code>: Pregunta a mostrar - default: '¿Fue útil esta página?'</li>
                <li><code>showQuestion</code>: Si mostrar la pregunta - default: true</li>
                <li><code>selected</code>: Valor seleccionado ('yes', 'no', null) - default: null</li>
                <li><code>onSelect</code>: Callback cuando se selecciona (opcional)</li>
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

