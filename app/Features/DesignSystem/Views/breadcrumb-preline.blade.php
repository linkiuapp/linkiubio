@extends('design-system::layout')

@section('page-title', 'Breadcrumb')
@section('page-description', 'Componentes de breadcrumb basados en Preline UI')

@section('content')
{{-- SECTION: Breadcrumb Chevrons --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Breadcrumb Chevrons
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: Chevrons --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Breadcrumbs con Chevrons</h4>
            @php
                $breadcrumbItems = [
                    ['label' => 'Home', 'url' => '#'],
                    ['label' => 'App Center', 'url' => '#'],
                    ['label' => 'Application', 'active' => true],
                ];
            @endphp
            <x-breadcrumb-chevrons :items="$breadcrumbItems" />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Navegación jerárquica con separadores de flechas</p>
            <p><strong>❌ NO usar para:</strong> Cuando prefieras otro estilo de separador</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-breadcrumb-chevrons 
    :items="[
        ['label' => 'Home', 'url' => '#'],
        ['label' => 'App Center', 'url' => '#'],
        ['label' => 'Application', 'active' => true]
    ]"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Breadcrumb Slashes --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Breadcrumb Slashes
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: Slashes --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Breadcrumbs con Barras Diagonales</h4>
            @php
                $breadcrumbItemsSlashes = [
                    ['label' => 'Home', 'url' => '#'],
                    ['label' => 'App Center', 'url' => '#'],
                    ['label' => 'Application', 'active' => true],
                ];
            @endphp
            <x-breadcrumb-slashes :items="$breadcrumbItemsSlashes" />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Navegación jerárquica con separadores de barras diagonales</p>
            <p><strong>❌ NO usar para:</strong> Cuando prefieras chevrons o iconos</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-breadcrumb-slashes 
    :items="[
        ['label' => 'Home', 'url' => '#'],
        ['label' => 'App Center', 'url' => '#'],
        ['label' => 'Application', 'active' => true]
    ]"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Breadcrumb With Icons --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Breadcrumb With Icons
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: With Icons --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Breadcrumbs con Iconos</h4>
            @php
                $breadcrumbItemsIcons = [
                    ['label' => 'Home', 'url' => '#', 'icon' => 'home'],
                    ['label' => 'App Center', 'url' => '#', 'icon' => 'folder'],
                    ['label' => 'Application', 'active' => true, 'icon' => 'file'],
                ];
            @endphp
            <x-breadcrumb-with-icons :items="$breadcrumbItemsIcons" />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Mejorar la UX visual con iconos descriptivos</p>
            <p><strong>❌ NO usar para:</strong> Cuando los breadcrumbs sean autoexplicativos sin necesidad de iconos</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-breadcrumb-with-icons 
    :items="[
        ['label' => 'Home', 'url' => '#', 'icon' => 'home'],
        ['label' => 'App Center', 'url' => '#', 'icon' => 'folder'],
        ['label' => 'Application', 'active' => true, 'icon' => 'file']
    ]"
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
            <p><strong>Todos los componentes Breadcrumb comparten estos props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>items</code>: Array de objetos, cada uno representando un item del breadcrumb (requerido).</li>
            </ul>
        </div>
        
        <div>
            <p><strong>Props en cada objeto `item` dentro del array `items`:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>label</code>: Texto del item (requerido).</li>
                <li><code>url</code>: URL del enlace (requerido para items no activos).</li>
                <li><code>active</code>: Booleano para indicar si el item está activo (default: `false`, el último item es activo si ninguno lo está).</li>
                <li><code>icon</code>: Nombre del icono Lucide (opcional, solo para <code>BreadcrumbWithIcons</code>).</li>
            </ul>
        </div>
        
        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <h4 class="body-lg-medium text-blue-900 mb-2">💡 Ejemplos de Uso</h4>
            <div class="body-small text-blue-800 space-y-2">
                <p><strong>1. Breadcrumb básico con chevrons:</strong></p>
                <pre class="bg-blue-100 p-2 rounded text-xs overflow-x-auto"><code>&lt;x-breadcrumb-chevrons 
    :items="[
        ['label' => 'Inicio', 'url' => '/'],
        ['label' => 'Productos', 'url' => '/productos'],
        ['label' => 'Detalle', 'active' => true]
    ]"
/&gt;</code></pre>
                
                <p class="mt-4"><strong>2. Breadcrumb con iconos:</strong></p>
                <pre class="bg-blue-100 p-2 rounded text-xs overflow-x-auto"><code>&lt;x-breadcrumb-with-icons 
    :items="[
        ['label' => 'Inicio', 'url' => '/', 'icon' => 'home'],
        ['label' => 'Productos', 'url' => '/productos', 'icon' => 'package'],
        ['label' => 'Detalle', 'active' => true, 'icon' => 'file']
    ]"
/&gt;</code></pre>
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
});
</script>
@endpush















