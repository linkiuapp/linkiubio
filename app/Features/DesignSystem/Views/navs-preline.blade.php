@extends('design-system::layout')

@section('page-title', 'Navs')
@section('page-description', 'Componentes de navegación basados en Preline UI - Código exacto sin modificaciones')

@section('content')

{{-- SECTION: Example - Nav Basic --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Example - Nav Básico
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            El componente nav base está construido con flexbox y proporciona una base sólida para construir todo tipo de componentes de navegación.
        </p>
        
        <div class="p-4 rounded-lg">
            <x-nav-basic />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-nav-basic /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Segment --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Segment
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Otro tipo de Tabs con segmento.
        </p>
        
        <div class="p-4 rounded-lg">
            <x-nav-segment />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-nav-segment /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: With badges --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        With badges
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Ejemplo simple con badges.
        </p>
        
        <div class="p-4 rounded-lg">
            <x-nav-with-badges />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-nav-with-badges /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: With icons --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        With icons
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Tabs contenidos con iconos.
        </p>
        
        <div class="p-4 rounded-lg">
            <x-nav-with-icons />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-nav-with-icons /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Tabs with underline --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Tabs with underline
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Una forma básica de tabs con subrayado.
        </p>
        
        <div class="p-4 rounded-lg">
            <x-nav-with-underline />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-nav-with-underline /&gt;</code></pre>
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
