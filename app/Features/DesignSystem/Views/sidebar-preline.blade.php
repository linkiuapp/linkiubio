@extends('design-system::layout')

@section('page-title', 'Sidebar')
@section('page-description', 'Componentes de sidebar basados en Preline UI')

@section('content')
{{-- SECTION: Sidebar Content Push --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Sidebar Content Push
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: Content Push to Mini Sidebar --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Sidebar con Modo Mini</h4>
            <p class="body-small text-brandNeutral-200">
                En desktop, al cerrar el sidebar se convierte en modo mini, manteniendo ambos visibles para una experiencia de navegación fluida.
            </p>
            
            @php
                $sidebarItems = [
                    ['label' => 'Dashboard', 'url' => '#', 'icon' => 'home', 'active' => true],
                    ['label' => 'Calendar', 'url' => '#', 'icon' => 'calendar', 'badge' => 'Nuevo'],
                    ['label' => 'Documentation', 'url' => '#', 'icon' => 'book'],
                ];
                
                $sidebarFooter = [
                    'avatar' => 'https://images.unsplash.com/photo-1734122415415-88cb1d7d5dc0?q=80&w=320&h=320&auto=format&fit=facearea&facepad=3&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                    'name' => 'Mia Hudson',
                    'dropdown' => [
                        ['label' => 'Mi cuenta', 'url' => '#'],
                        ['label' => 'Configuración', 'url' => '#'],
                        ['label' => 'Facturación', 'url' => '#'],
                        ['label' => 'Cerrar sesión', 'url' => '#'],
                    ]
                ];
            @endphp
            
            <div class="relative border border-brandNeutral-50 rounded-lg overflow-hidden" style="min-height: 500px; position: relative;">
                <div class="lg:ms-64 transition-all duration-300 p-4">
                    <p class="body-small text-brandNeutral-200 mb-4">
                        <strong>Nota:</strong> Este componente está diseñado para usarse en una página completa. El sidebar es fijo y se posiciona sobre el contenido.
                    </p>
                    <div class="bg-gray-50 border border-dashed border-gray-200 rounded-lg p-8 text-center">
                        <p class="text-gray-500 body-small">
                            Área de contenido principal
                        </p>
                        <p class="text-gray-400 body-small mt-2">
                            En desktop, el sidebar se muestra automáticamente. Haz clic en el botón de toggle para minimizarlo.
                        </p>
                        <p class="text-gray-400 body-small mt-2">
                            En mobile, usa el botón "Abrir" arriba para mostrar el sidebar.
                        </p>
                    </div>
                </div>
                
                <x-sidebar-content-push 
                    sidebar-id="demo-sidebar"
                    :items="$sidebarItems"
                    :footer="$sidebarFooter"
                />
            </div>
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Navegación principal de aplicaciones, menús laterales colapsables</p>
            <p><strong>❌ NO usar para:</strong> Navegación simple sin necesidad de colapsar</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-sidebar-content-push 
    :items="[
        ['label' => 'Dashboard', 'url' => '#', 'icon' => 'home', 'active' => true],
        ['label' => 'Calendar', 'url' => '#', 'icon' => 'calendar', 'badge' => 'Nuevo']
    ]"
    :footer="[
        'avatar' => '...',
        'name' => 'Usuario',
        'dropdown' => [...]
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
            <p><strong>Props del componente SidebarContentPush:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>sidebarId</code>: ID único para el sidebar (se genera automáticamente si no se provee).</li>
                <li><code>items</code>: Array de items de navegación (requerido).</li>
                <li><code>footer</code>: Array con información del footer (opcional).</li>
                <li><code>showToggle</code>: Mostrar botón toggle en mobile (default: true).</li>
            </ul>
        </div>
        
        <div>
            <p><strong>Props en cada objeto `item` dentro del array `items`:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>label</code>: Texto del enlace (requerido).</li>
                <li><code>url</code>: URL del enlace (requerido).</li>
                <li><code>icon</code>: Nombre del icono Lucide (opcional).</li>
                <li><code>active</code>: Si el enlace está activo (default: false).</li>
                <li><code>badge</code>: Texto del badge (opcional).</li>
            </ul>
        </div>
        
        <div>
            <p><strong>Props en el array `footer`:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>avatar</code>: URL de la imagen del avatar (opcional).</li>
                <li><code>name</code>: Nombre del usuario (opcional).</li>
                <li><code>dropdown</code>: Array de items del dropdown (opcional).</li>
            </ul>
        </div>
        
        <div>
            <p><strong>Props en cada objeto del `dropdown`:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>label</code>: Texto del enlace (requerido).</li>
                <li><code>url</code>: URL del enlace (requerido).</li>
            </ul>
        </div>
        
        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <h4 class="body-lg-medium text-blue-900 mb-2">💡 Características</h4>
            <div class="body-small text-blue-800 space-y-2">
                <ul class="list-disc list-inside space-y-1 ml-4">
                    <li>Modo overlay en mobile (se abre sobre el contenido)</li>
                    <li>Modo mini sidebar en desktop (se colapsa a 52px de ancho)</li>
                    <li>Transiciones suaves entre estados</li>
                    <li>Dropdown en el footer con Alpine.js</li>
                    <li>Iconos Lucide automáticos</li>
                    <li>Responsive: se adapta a mobile y desktop</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
        window.createIcons({ icons: window.lucideIcons });
    } else if (typeof lucide !== 'undefined' && lucide.createIcons) {
        // Fallback si lucide está disponible globalmente
        if (typeof lucide.icons !== 'undefined') {
            lucide.createIcons({ icons: lucide.icons });
        }
    }
});
</script>
@endpush

