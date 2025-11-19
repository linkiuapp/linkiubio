@extends('design-system::layout')

@section('page-title', 'Spinners (Loaders)')
@section('page-description', 'Componentes de spinners y loaders basados en Preline UI')

@section('content')
{{-- SECTION: Spinner Basic --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Spinner Basic
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: basic --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Spinner Básico</h4>
            <x-spinner-basic />
        </div>
        
        {{-- ITEM: color-variants --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Variantes de Color</h4>
            <div class="flex flex-wrap items-center gap-6">
                <div class="flex flex-col items-center gap-2">
                    <x-spinner-basic color="gray" />
                    <span class="caption text-gray-500">Gray</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <x-spinner-basic color="gray-light" />
                    <span class="caption text-gray-500">Gray Light</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <x-spinner-basic color="red" />
                    <span class="caption text-gray-500">Red</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <x-spinner-basic color="yellow" />
                    <span class="caption text-gray-500">Yellow</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <x-spinner-basic color="green" />
                    <span class="caption text-gray-500">Green</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <x-spinner-basic color="blue" />
                    <span class="caption text-gray-500">Blue</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <x-spinner-basic color="indigo" />
                    <span class="caption text-gray-500">Indigo</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <x-spinner-basic color="purple" />
                    <span class="caption text-gray-500">Purple</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <x-spinner-basic color="pink" />
                    <span class="caption text-gray-500">Pink</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <x-spinner-basic color="orange" />
                    <span class="caption text-gray-500">Orange</span>
                </div>
            </div>
        </div>
        
        {{-- ITEM: sizes --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Tamaños</h4>
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex flex-col items-center gap-2">
                    <x-spinner-basic color="blue" size="sm" />
                    <span class="caption text-gray-500">Small</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <x-spinner-basic color="blue" size="md" />
                    <span class="caption text-gray-500">Medium</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <x-spinner-basic color="blue" size="lg" />
                    <span class="caption text-gray-500">Large</span>
                </div>
            </div>
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Indicadores de carga, estados de loading, procesamiento</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites mensajes de error o estados completos</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-spinner-basic /&gt;
&lt;x-spinner-basic color="blue" size="md" /&gt;
&lt;x-spinner-basic color="red" size="sm" /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Spinner Card --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Spinner Card
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: card --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Spinner dentro de Card</h4>
            <x-spinner-card />
        </div>
        
        {{-- ITEM: card-different-sizes --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Diferentes Tamaños</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <x-spinner-card color="blue" size="sm" />
                <x-spinner-card color="blue" size="md" />
                <x-spinner-card color="blue" size="lg" />
            </div>
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Loading states en cards, contenedores con contenido en carga</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites un spinner inline o sin contenedor</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-spinner-card /&gt;
&lt;x-spinner-card color="blue" size="md" /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Spinner Overlay --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Spinner Overlay
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: overlay --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Spinner con Overlay</h4>
            <x-spinner-overlay color="blue" size="md">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="shrink-0">
                            <i data-lucide="alert-triangle" class="shrink-0 size-4 text-blue-600 mt-0.5"></i>
                        </div>
                        <div class="ms-3">
                            <h3 class="body-small text-blue-800 font-medium">
                                Atención requerida
                            </h3>
                            <div class="body-small text-blue-700 mt-2">
                                <span class="font-semibold">¡Atención!</span> Debes revisar algunos de los campos a continuación.
                            </div>
                        </div>
                    </div>
                </div>
            </x-spinner-overlay>
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Loading states sobre contenido existente, formularios en proceso</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites un spinner standalone o dentro de una card</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-spinner-overlay color="blue" size="md"&gt;
    &lt;!-- Contenido aquí --&gt;
&lt;/x-spinner-overlay&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Props Documentation --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Documentación de Props
    </h4>
    
    <div class="mt-4 body-small text-brandNeutral-200 space-y-4">
        <div>
            <p><strong>SpinnerBasic props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>color</code>: Color del spinner (blue, gray, red, yellow, green, indigo, purple, pink, orange) - default: 'blue'</li>
                <li><code>size</code>: Tamaño (sm, md, lg) - default: 'md'</li>
                <li><code>label</code>: Texto para screen readers - default: 'Loading...'</li>
            </ul>
        </div>
        
        <div>
            <p><strong>SpinnerCard props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>color</code>: Color del spinner - default: 'blue'</li>
                <li><code>size</code>: Tamaño (sm, md, lg) - default: 'md'</li>
                <li><code>minHeight</code>: Altura mínima de la card - default: 'min-h-60'</li>
                <li><code>label</code>: Texto para screen readers - default: 'Loading...'</li>
            </ul>
        </div>
        
        <div>
            <p><strong>SpinnerOverlay props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>color</code>: Color del spinner - default: 'blue'</li>
                <li><code>size</code>: Tamaño (sm, md, lg) - default: 'md'</li>
                <li><code>overlayOpacity</code>: Opacidad del overlay - default: 'bg-white/50'</li>
                <li><code>label</code>: Texto para screen readers - default: 'Loading...'</li>
                <li><code>slot</code>: Contenido sobre el cual se muestra el spinner (required)</li>
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

