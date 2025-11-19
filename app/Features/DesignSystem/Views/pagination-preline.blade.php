@extends('design-system::layout')

@section('page-title', 'Pagination')
@section('page-description', 'Componentes de paginación basados en Preline UI')

@section('content')
{{-- SECTION: Pagination Bordered Group --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Pagination Bordered Group
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: Bordered Group --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Paginación con Bordes Agrupados</h4>
            <x-pagination-bordered-group 
                :current="1"
                :total="10"
                url="#"
            />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Paginación con estilo clásico y bordes visibles que se conectan</p>
            <p><strong>❌ NO usar para:</strong> Cuando prefieras un estilo sin bordes o más moderno</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-pagination-bordered-group 
    :current="1"
    :total="10"
    url="#"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Pagination Center --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Pagination Center
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: Center without border --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Paginación Centrada sin Bordes</h4>
            <x-pagination-center 
                :current="2"
                :total="10"
                url="#"
                :withBorder="false"
            />
        </div>
        
        {{-- ITEM: Center with border --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Paginación Centrada con Bordes</h4>
            <x-pagination-center 
                :current="2"
                :total="10"
                url="#"
                :withBorder="true"
            />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Paginación con estilo moderno y centrado</p>
            <p><strong>❌ NO usar para:</strong> Cuando prefieras bordes conectados o alineación diferente</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-pagination-center 
    :current="2"
    :total="10"
    url="#"
    :withBorder="false"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Pagination End --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Pagination End
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: End without border --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Paginación al Final sin Bordes</h4>
            <x-pagination-end 
                :current="2"
                :total="10"
                url="#"
                :withBorder="false"
            />
        </div>
        
        {{-- ITEM: End with border --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Paginación al Final con Bordes</h4>
            <x-pagination-end 
                :current="2"
                :total="10"
                url="#"
                :withBorder="true"
            />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Paginación alineada al final del contenedor</p>
            <p><strong>❌ NO usar para:</strong> Cuando prefieras centrado o izquierda</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-pagination-end 
    :current="2"
    :total="10"
    url="#"
    :withBorder="false"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Pagination With Of --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Pagination With Of
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: With Of Center --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Paginación con "of" Centrada</h4>
            <x-pagination-with-of 
                :current="1"
                :total="3"
                url="#"
                alignment="center"
            />
        </div>
        
        {{-- ITEM: With Of End --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Paginación con "of" al Final</h4>
            <x-pagination-with-of 
                :current="1"
                :total="3"
                url="#"
                alignment="end"
            />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Mostrar información de página actual vs total de forma compacta</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites navegación directa a páginas específicas</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-pagination-with-of 
    :current="1"
    :total="3"
    url="#"
    alignment="center"
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
            <p><strong>Props compartidos por todos los componentes de Pagination:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>current</code>: Página actual (requerido, default: 1).</li>
                <li><code>total</code>: Total de páginas (requerido, default: 1).</li>
                <li><code>url</code>: URL base para las páginas (default: '#').</li>
                <li><code>showPrevNext</code>: Mostrar botones Previous/Next (default: true).</li>
                <li><code>prevLabel</code>: Texto del botón Previous (default: 'Previous').</li>
                <li><code>nextLabel</code>: Texto del botón Next (default: 'Next').</li>
            </ul>
        </div>
        
        <div>
            <p><strong>PaginationBorderedGroup props adicionales:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>maxVisible</code>: Máximo de páginas visibles (default: 5).</li>
            </ul>
        </div>
        
        <div>
            <p><strong>PaginationCenter y PaginationEnd props adicionales:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>maxVisible</code>: Máximo de páginas visibles (default: 5).</li>
                <li><code>withBorder</code>: Si usar bordes en los botones de página (default: false).</li>
            </ul>
        </div>
        
        <div>
            <p><strong>PaginationWithOf props adicionales:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>ofText</code>: Texto entre página actual y total (default: 'of').</li>
                <li><code>alignment</code>: Alineación (center, start, end) (default: 'center').</li>
            </ul>
        </div>
        
        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <h4 class="body-lg-medium text-blue-900 mb-2">💡 Ejemplos de Uso</h4>
            <div class="body-small text-blue-800 space-y-2">
                <p><strong>1. Paginación básica con bordes:</strong></p>
                <pre class="bg-blue-100 p-2 rounded text-xs overflow-x-auto"><code>&lt;x-pagination-bordered-group 
    :current="1"
    :total="10"
    url="/productos"
/&gt;</code></pre>
                
                <p class="mt-4"><strong>2. Paginación centrada sin bordes:</strong></p>
                <pre class="bg-blue-100 p-2 rounded text-xs overflow-x-auto"><code>&lt;x-pagination-center 
    :current="2"
    :total="10"
    url="/productos"
    :withBorder="false"
/&gt;</code></pre>
                
                <p class="mt-4"><strong>3. Paginación compacta con "of":</strong></p>
                <pre class="bg-blue-100 p-2 rounded text-xs overflow-x-auto"><code>&lt;x-pagination-with-of 
    :current="1"
    :total="3"
    url="/productos"
    alignment="center"
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

