@extends('design-system::layout')

@section('page-title', 'Tabs')
@section('page-description', 'Componentes de tabs basados en Preline UI')

@section('content')
{{-- SECTION: Tab Pills --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Tab Pills (Brand Color)
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: pills --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Tabs con Estilo Pills</h4>
            @php
                $tabsPills = [
                    ['label' => 'Tab 1', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">primer</em> contenido del tab.</p>'],
                    ['label' => 'Tab 2', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">segundo</em> contenido del tab.</p>'],
                    ['label' => 'Tab 3', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">tercer</em> contenido del tab.</p>']
                ];
            @endphp
            <x-tab-pills :tabs="$tabsPills" />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Organizar contenido en secciones con estilo moderno</p>
            <p><strong>❌ NO usar para:</strong> Navegación entre páginas (usa Navs)</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-tab-pills 
    :tabs="[
        ['label' => 'Tab 1', 'content' => 'Contenido 1'],
        ['label' => 'Tab 2', 'content' => 'Contenido 2']
    ]"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Tab Pills Gray --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Tab Pills Gray
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: pills-gray --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Tabs con Estilo Pills Gris</h4>
            @php
                $tabsPillsGray = [
                    ['label' => 'Tab 1', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">primer</em> contenido del tab.</p>'],
                    ['label' => 'Tab 2', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">segundo</em> contenido del tab.</p>'],
                    ['label' => 'Tab 3', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">tercer</em> contenido del tab.</p>']
                ];
            @endphp
            <x-tab-pills-gray :tabs="$tabsPillsGray" />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Organizar contenido con estilo más sutil</p>
            <p><strong>❌ NO usar para:</strong> Navegación entre páginas (usa Navs)</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-tab-pills-gray 
    :tabs="[
        ['label' => 'Tab 1', 'content' => 'Contenido 1'],
        ['label' => 'Tab 2', 'content' => 'Contenido 2']
    ]"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Tab With Underline --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Tab With Underline
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: underline --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Tabs con Subrayado</h4>
            @php
                $tabsUnderline = [
                    ['label' => 'Tab 1', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">primer</em> contenido del tab.</p>'],
                    ['label' => 'Tab 2', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">segundo</em> contenido del tab.</p>'],
                    ['label' => 'Tab 3', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">tercer</em> contenido del tab.</p>']
                ];
            @endphp
            <x-tab-with-underline :tabs="$tabsUnderline" />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Organizar contenido con estilo clásico</p>
            <p><strong>❌ NO usar para:</strong> Navegación entre páginas (usa Navs)</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-tab-with-underline 
    :tabs="[
        ['label' => 'Tab 1', 'content' => 'Contenido 1'],
        ['label' => 'Tab 2', 'content' => 'Contenido 2']
    ]"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Tab Segment --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Tab Segment
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: segment --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Tabs con Estilo Segmentado</h4>
            @php
                $tabsSegment = [
                    ['label' => 'Tab 1', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">primer</em> contenido del tab.</p>'],
                    ['label' => 'Tab 2', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">segundo</em> contenido del tab.</p>'],
                    ['label' => 'Tab 3', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">tercer</em> contenido del tab.</p>']
                ];
            @endphp
            <x-tab-segment :tabs="$tabsSegment" />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Organizar contenido con estilo más destacado</p>
            <p><strong>❌ NO usar para:</strong> Navegación entre páginas (usa Navs)</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-tab-segment 
    :tabs="[
        ['label' => 'Tab 1', 'content' => 'Contenido 1'],
        ['label' => 'Tab 2', 'content' => 'Contenido 2']
    ]"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Tab Card --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Tab Card
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: card --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Tabs con Estilo de Tarjeta</h4>
            @php
                $tabsCard = [
                    ['label' => 'Tab 1', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">primer</em> contenido del tab.</p>'],
                    ['label' => 'Tab 2', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">segundo</em> contenido del tab.</p>'],
                    ['label' => 'Tab 3', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">tercer</em> contenido del tab.</p>']
                ];
            @endphp
            <x-tab-card :tabs="$tabsCard" />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Organizar contenido con estilo de tarjeta</p>
            <p><strong>❌ NO usar para:</strong> Navegación entre páginas (usa Navs)</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-tab-card 
    :tabs="[
        ['label' => 'Tab 1', 'content' => 'Contenido 1'],
        ['label' => 'Tab 2', 'content' => 'Contenido 2']
    ]"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Tab With Badges --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Tab With Badges
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: with-badges --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Tabs con Badges</h4>
            @php
                $tabsBadges = [
                    ['label' => 'Tab 1', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">primer</em> contenido del tab.</p>', 'badge' => '99+'],
                    ['label' => 'Tab 2', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">segundo</em> contenido del tab.</p>', 'badge' => '99+'],
                    ['label' => 'Tab 3', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">tercer</em> contenido del tab.</p>']
                ];
            @endphp
            <x-tab-with-badges :tabs="$tabsBadges" />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Mostrar indicadores visuales de cantidad o notificaciones</p>
            <p><strong>❌ NO usar para:</strong> Cuando no necesites badges o contadores</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-tab-with-badges 
    :tabs="[
        ['label' => 'Tab 1', 'content' => 'Contenido 1', 'badge' => '5'],
        ['label' => 'Tab 2', 'content' => 'Contenido 2', 'badge' => '12']
    ]"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Tab With Icons --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Tab With Icons
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: with-icons --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Tabs con Iconos</h4>
            @php
                $tabsIcons = [
                    ['label' => 'Tab 1', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">primer</em> contenido del tab.</p>', 'icon' => 'home'],
                    ['label' => 'Tab 2', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">segundo</em> contenido del tab.</p>', 'icon' => 'user-circle'],
                    ['label' => 'Tab 3', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">tercer</em> contenido del tab.</p>', 'icon' => 'settings']
                ];
            @endphp
            <x-tab-with-icons :tabs="$tabsIcons" />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Mejorar la UX visual con iconos descriptivos</p>
            <p><strong>❌ NO usar para:</strong> Cuando los tabs sean autoexplicativos sin necesidad de iconos</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-tab-with-icons 
    :tabs="[
        ['label' => 'Tab 1', 'content' => 'Contenido 1', 'icon' => 'home'],
        ['label' => 'Tab 2', 'content' => 'Contenido 2', 'icon' => 'user']
    ]"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Tab Bar Underline --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Tab Bar Underline
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: bar-underline --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Tabs con Barra con Subrayado</h4>
            @php
                $tabsBarUnderline = [
                    ['label' => 'Tab 1', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">primer</em> contenido del tab.</p>'],
                    ['label' => 'Tab 2', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">segundo</em> contenido del tab.</p>'],
                    ['label' => 'Tab 3', 'content' => '<p class="text-gray-500">Este es el <em class="font-semibold text-gray-800">tercer</em> contenido del tab.</p>']
                ];
            @endphp
            <x-tab-bar-underline :tabs="$tabsBarUnderline" />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Organizar contenido con estilo de barra destacada</p>
            <p><strong>❌ NO usar para:</strong> Navegación entre páginas (usa Navs)</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-tab-bar-underline 
    :tabs="[
        ['label' => 'Tab 1', 'content' => 'Contenido 1'],
        ['label' => 'Tab 2', 'content' => 'Contenido 2']
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
            <p><strong>Todos los componentes Tab comparten estos props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>tabs</code>: Array de tabs (requerido)</li>
                <li><code>tabId</code>: ID único para el grupo de tabs (opcional, se genera automáticamente)</li>
            </ul>
        </div>
        
        <div>
            <p><strong>Props en tabs (array de tabs):</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>label</code>: Texto del tab (requerido)</li>
                <li><code>content</code>: Contenido HTML del panel del tab (opcional, puede usar slot)</li>
                <li><code>icon</code>: Nombre del icono Lucide (opcional)</li>
                <li><code>badge</code>: Texto del badge (solo para TabWithBadges) (opcional)</li>
                <li><code>active</code>: Si el tab está activo por defecto - default: false (el primer tab es activo por defecto)</li>
            </ul>
        </div>
        
        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <h4 class="body-lg-medium text-blue-900 mb-2">💡 Nota Importante</h4>
            <div class="body-small text-blue-800 space-y-2">
                <p>Los componentes Tabs requieren <strong>Preline UI JavaScript</strong> para funcionar correctamente. El JavaScript se inicializa automáticamente en cada componente.</p>
                <p>Los tabs usan <code>data-hs-tab</code> y clases <code>hs-tab-active:</code> para el estilo y funcionalidad.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function() {
    function initIcons() {
        if (typeof lucide !== 'undefined' && lucide.createIcons) {
            lucide.createIcons();
        } else if (typeof createIcons !== 'undefined') {
            createIcons();
        }
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initIcons);
    } else {
        initIcons();
    }
    
    // Preline UI se inicializa automáticamente con autoInit en el layout
})();
</script>
@endpush

