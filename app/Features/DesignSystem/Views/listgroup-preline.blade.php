@extends('design-system::layout')

@section('page-title', 'List Groups')
@section('page-description', 'Componentes de grupos de lista basados en Preline UI')

@section('content')
{{-- SECTION: List Group Básico --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        List Group Básico
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: basic --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Lista Simple</h4>
            <x-list-group-basic 
                :items="['Profile', 'Settings', 'Newsletter']"
            />
        </div>
        
        {{-- ITEM: with-icons --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Con Iconos</h4>
            <x-list-group-basic 
                :items="[
                    ['label' => 'Newsletter', 'icon' => 'bell'],
                    ['label' => 'Downloads', 'icon' => 'download'],
                    ['label' => 'Team Account', 'icon' => 'users']
                ]"
            />
        </div>
        
        {{-- ITEM: no-gutters --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Sin Padding (No Gutters)</h4>
            <x-list-group-basic 
                :items="['Profile', 'Settings', 'Newsletter']"
                :noGutters="true"
            />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Listas de navegación, menús laterales, opciones de configuración</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites listas interactivas con enlaces o botones</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-list-group-basic 
    :items="['Profile', 'Settings', 'Newsletter']" 
/&gt;

&lt;x-list-group-basic 
    :items="[
        ['label' => 'Newsletter', 'icon' => 'bell'],
        ['label' => 'Downloads', 'icon' => 'download']
    ]"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: List Group Links --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        List Group con Enlaces
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: links --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Enlaces con Estados</h4>
            <x-list-group-links 
                :items="[
                    ['label' => 'Active', 'url' => '#', 'icon' => 'bell', 'active' => true],
                    ['label' => 'Link', 'url' => '#', 'icon' => 'download'],
                    ['label' => 'Disabled', 'url' => '#', 'icon' => 'users', 'disabled' => true]
                ]"
            />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Navegación, menús con estados activos, enlaces deshabilitados</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites listas estáticas sin interacción</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-list-group-links 
    :items="[
        ['label' => 'Active', 'url' => '#', 'icon' => 'bell', 'active' => true],
        ['label' => 'Link', 'url' => '#', 'icon' => 'download'],
        ['label' => 'Disabled', 'url' => '#', 'disabled' => true]
    ]"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: List Group Buttons --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        List Group con Botones
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: buttons --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Botones con Estados</h4>
            <x-list-group-buttons 
                :items="[
                    ['label' => 'Active', 'icon' => 'bell', 'active' => true],
                    ['label' => 'Link', 'icon' => 'download'],
                    ['label' => 'Disabled', 'icon' => 'users', 'disabled' => true]
                ]"
            />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Formularios, acciones, opciones seleccionables</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites enlaces o listas estáticas</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-list-group-buttons 
    :items="[
        ['label' => 'Active', 'icon' => 'bell', 'active' => true],
        ['label' => 'Link', 'icon' => 'download'],
        ['label' => 'Disabled', 'icon' => 'users', 'disabled' => true]
    ]"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: List Group Horizontal --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        List Group Horizontal
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: horizontal --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Lista Horizontal (Responsive)</h4>
            <x-list-group-horizontal 
                :items="[
                    ['label' => 'Newsletter', 'icon' => 'bell'],
                    ['label' => 'Downloads', 'icon' => 'download'],
                    ['label' => 'Team Account', 'icon' => 'users']
                ]"
            />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Navegación horizontal, tabs, opciones en fila</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites listas verticales o con mucho contenido</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-list-group-horizontal 
    :items="[
        ['label' => 'Newsletter', 'icon' => 'bell'],
        ['label' => 'Downloads', 'icon' => 'download']
    ]"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: List Group con Badges --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        List Group con Badges
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: badges --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Con Badges de Notificación</h4>
            <x-list-group-with-badges 
                :items="[
                    ['label' => 'Profile', 'badge' => 'New', 'badgeColor' => 'blue'],
                    ['label' => 'Settings', 'badge' => '2', 'badgeColor' => 'blue'],
                    ['label' => 'Newsletter', 'badge' => '99+', 'badgeColor' => 'blue']
                ]"
            />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Listas con indicadores de notificaciones, contadores, estados</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites listas simples sin información adicional</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-list-group-with-badges 
    :items="[
        ['label' => 'Profile', 'badge' => 'New', 'badgeColor' => 'blue'],
        ['label' => 'Settings', 'badge' => '2', 'badgeColor' => 'blue'],
        ['label' => 'Newsletter', 'badge' => '99+', 'badgeColor' => 'blue']
    ]"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: List Group Invoice --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        List Group Invoice
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: invoice --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Estilo Factura con Total</h4>
            <x-list-group-invoice 
                :items="[
                    ['label' => 'Payment to Front', 'value' => '$264.00'],
                    ['label' => 'Tax fee', 'value' => '$52.8']
                ]"
                :total="['label' => 'Amount paid', 'value' => '$316.8']"
            />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Facturas, recibos, resúmenes de pago, listas con totales</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites listas simples sin valores o totales</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-list-group-invoice 
    :items="[
        ['label' => 'Payment to Front', 'value' => '$264.00'],
        ['label' => 'Tax fee', 'value' => '$52.8']
    ]"
    :total="['label' => 'Amount paid', 'value' => '$316.8']"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: List Group Files --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        List Group Files
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: files --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Lista de Archivos con Acciones</h4>
            <x-list-group-files 
                :items="[
                    ['name' => 'resume_web_ui_developer.csv', 'action' => 'Download', 'actionIcon' => 'download'],
                    ['name' => 'coverletter_web_ui_developer.pdf', 'action' => 'Download', 'actionIcon' => 'download']
                ]"
            />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Lista de archivos descargables, documentos, archivos adjuntos</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites listas simples sin acciones</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-list-group-files 
    :items="[
        ['name' => 'resume.pdf', 'action' => 'Download', 'actionIcon' => 'download'],
        ['name' => 'coverletter.pdf', 'action' => 'Download', 'actionIcon' => 'download']
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
            <p><strong>ListGroupBasic props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>items</code>: Array de items (string o array con 'label' y opcionalmente 'icon')</li>
                <li><code>width</code>: Ancho máximo (default: 'max-w-xs')</li>
                <li><code>textSize</code>: Tamaño de texto (default: 'body-small')</li>
                <li><code>textColor</code>: Color del texto (default: 'text-gray-800')</li>
                <li><code>noGutters</code>: Si true, sin padding lateral y usa dividers (default: false)</li>
            </ul>
        </div>
        
        <div>
            <p><strong>ListGroupLinks props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>items</code>: Array de objetos con 'label', 'url', y opcionalmente 'icon', 'active', 'disabled'</li>
                <li><code>width</code>, <code>textSize</code>: Igual que ListGroupBasic</li>
            </ul>
        </div>
        
        <div>
            <p><strong>ListGroupButtons props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>items</code>: Array de objetos con 'label', y opcionalmente 'icon', 'active', 'disabled', 'onclick'</li>
                <li><code>width</code>, <code>textSize</code>: Igual que ListGroupBasic</li>
            </ul>
        </div>
        
        <div>
            <p><strong>ListGroupHorizontal props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>items</code>: Array de items (string o array con 'label' y opcionalmente 'icon')</li>
                <li><code>textSize</code>, <code>textColor</code>: Igual que ListGroupBasic</li>
            </ul>
        </div>
        
        <div>
            <p><strong>ListGroupWithBadges props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>items</code>: Array de objetos con 'label', y opcionalmente 'badge', 'badgeColor', 'icon'</li>
                <li><code>badgeColor</code>: 'blue', 'red', 'green', 'yellow', 'gray' (default: 'blue')</li>
                <li><code>width</code>, <code>textSize</code>: Igual que ListGroupBasic</li>
            </ul>
        </div>
        
        <div>
            <p><strong>ListGroupInvoice props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>items</code>: Array de objetos con 'label' y 'value'</li>
                <li><code>total</code>: Objeto con 'label' y 'value' para el footer resaltado (opcional)</li>
                <li><code>textSize</code>, <code>textColor</code>: Igual que ListGroupBasic</li>
            </ul>
        </div>
        
        <div>
            <p><strong>ListGroupFiles props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>items</code>: Array de objetos con 'name', y opcionalmente 'action', 'actionIcon', 'actionUrl'</li>
                <li><code>textSize</code>, <code>textColor</code>: Igual que ListGroupBasic</li>
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

