@extends('design-system::layout')

@section('title', 'Inputs Preline UI')
@section('page-title', 'Input Components')
@section('page-description', 'Componentes de entrada basados exactamente en Preline UI - Código exacto sin modificaciones')

@section('content')

{{-- SECTION: Placeholder --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Placeholder
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Ejemplo básico de input con placeholder.
        </p>
        
        <div class="p-4 rounded-lg">
            <x-input-placeholder />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-input-placeholder /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Label --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Label
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Ejemplo básico de input con etiqueta.
        </p>
        
        <div class="p-4 rounded-lg">
            <x-input-label />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-input-label /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Hidden label --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Hidden label
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Elementos &lt;label&gt; ocultos usando la clase .sr-only
        </p>
        
        <div class="p-4 rounded-lg">
            <x-input-hidden-label />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-input-hidden-label /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Basic --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Basic
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Ejemplo básico de input.
        </p>
        
        <div class="p-4 rounded-lg">
            <x-input-basic />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-input-basic /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Gray input --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Gray input
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Ejemplo de una variante de estilo de input gris.
        </p>
        
        <div class="p-4 rounded-lg">
            <x-input-gray />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-input-gray /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Floating label --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Floating label
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Se requiere un placeholder en cada &lt;input&gt; ya que nuestro método usa el pseudo-elemento :placeholder-shown. También ten en cuenta que el &lt;input&gt; debe ir primero para poder utilizar un selector de hermanos (por ejemplo, ~).
        </p>
        
        <div class="p-4 rounded-lg">
            <x-input-floating-label />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-input-floating-label /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Sizes --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Sizes
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Inputs apilados de tamaño pequeño a grande.
        </p>
        
        <div class="p-4 rounded-lg">
            <x-input-sizes />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-input-sizes /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Readonly --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Readonly
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Agrega el atributo booleano readonly en un input para prevenir la modificación del valor del input.
        </p>
        
        <div class="p-4 rounded-lg">
            <x-input-readonly />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-input-readonly /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Disabled --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Disabled
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Agrega el atributo booleano disabled en un input para eliminar eventos de puntero y prevenir el enfoque.
        </p>
        
        <div class="p-4 rounded-lg">
            <x-input-disabled />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-input-disabled /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Helper text --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Helper text
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Ejemplo de un campo de input con texto de ayuda para orientación adicional.
        </p>
        
        <div class="p-4 rounded-lg">
            <x-input-with-helper />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-input-with-helper /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Corner hint --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Corner hint
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Ejemplo básico de input con una etiqueta de hint en la esquina.
        </p>
        
        <div class="p-4 rounded-lg">
            <x-input-corner-hint />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-input-corner-hint /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Validation states --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Validation states
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Proporciona retroalimentación valiosa y accionable a tus usuarios con validación de formularios HTML5.
        </p>
        
        <div class="p-4 rounded-lg">
            <x-input-validation />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-input-validation /&gt;</code></pre>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar iconos de Lucide
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    } else if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endpush
