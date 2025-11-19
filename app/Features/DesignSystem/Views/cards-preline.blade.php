@extends('design-system::layout')

@section('title', 'Cards Preline UI')
@section('page-title', 'Card Components')
@section('page-description', 'Componentes de cards basados exactamente en Preline UI')

@section('content')

{{-- SECTION: Basic Cards --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Cards Básicos
    </h4>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        {{-- ITEM: card-base-small --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Tamaño Small</h4>
            <x-card-base 
                size="sm" 
                title="Card pequeño" 
                content="Contenido de apoyo como introducción natural al contenido adicional."
                link="#"
                linkText="Enlace del card"
            />
        </div>

        {{-- ITEM: card-base-default --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Tamaño Default</h4>
            <x-card-base 
                size="md" 
                title="Card predeterminado" 
                content="Contenido de apoyo como introducción natural al contenido adicional."
                footer="Actualizado hace 5 minutos"
            />
        </div>

        {{-- ITEM: card-base-large --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Tamaño Large</h4>
            <x-card-base 
                size="lg" 
                title="Card grande" 
                content="Contenido de apoyo como introducción natural al contenido adicional."
                :hover="true"
                shadow="lg"
            />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="text-sm text-brandNeutral-300"><code>&lt;x-card-base size="md" title="Título" content="Contenido" /&gt;
&lt;x-card-base :hover="true" shadow="lg" title="Con hover" /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Specialized Cards --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Cards Especializados
    </h4>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- ITEM: card-scrollable --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Card Scrollable</h4>
            <x-card-scrollable 
                title="Contenido extenso" 
                height="280"
            >
                <p class="mt-2 text-gray-500">
                    Este es un card más largo con texto de apoyo que funciona como introducción natural al contenido adicional. Este contenido es un poco más largo. Este es un card más largo con texto de apoyo que funciona como introducción natural al contenido adicional.
                </p>
                <p class="mt-2 text-gray-500">
                    Este contenido es un poco más largo. Este es un card más largo con texto de apoyo que funciona como introducción natural al contenido adicional. Este contenido es un poco más largo.
                </p>
                <p class="mt-2 text-gray-500">
                    Más contenido scrolleable para demostrar la funcionalidad. Este es un card más largo con texto de apoyo que funciona como introducción natural al contenido adicional.
                </p>
            </x-card-scrollable>
            <div class="text-sm text-brandNeutral-200">
                <p><strong>✅ Usar para:</strong> Contenido extenso, listas largas</p>
            </div>
        </div>

        {{-- ITEM: card-empty-state --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Empty State</h4>
            <x-card-empty-state 
                icon="inbox"
                message="No hay datos para mostrar"
                description="Agrega algunos elementos para comenzar"
                action="#"
                actionText="Agregar elemento"
            />
            <div class="text-sm text-brandNeutral-200">
                <p><strong>✅ Usar para:</strong> Estados vacíos, sin resultados</p>
            </div>
        </div>
    </div>
</div>

{{-- SECTION: Content Layout Cards --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Cards de Layout
    </h4>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- ITEM: card-centered --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Contenido Centrado</h4>
            <x-card-centered 
                icon="star"
                title="Acción principal" 
                content="Contenido importante que debe destacar en el centro."
                link="#"
                linkText="Acción principal"
            />
            <div class="text-sm text-brandNeutral-200">
                <p><strong>✅ Usar para:</strong> CTAs importantes, contenido destacado</p>
            </div>
        </div>

        {{-- ITEM: card-with-alert --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Con Alerta</h4>
            <x-card-with-alert 
                header="Destacado"
                alertType="warning"
                alertBold="¡Atención requerida!"
                alertMessage="Esta es una alerta integrada."
                title="Card con alerta"
                content="Contenido de apoyo como introducción natural al contenido adicional."
                link="#"
                linkText="Enlace del card"
            />
            <div class="text-sm text-brandNeutral-200">
                <p><strong>✅ Usar para:</strong> Notificaciones importantes, advertencias</p>
            </div>
        </div>
    </div>
</div>

{{-- SECTION: Interactive Cards --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Cards Interactivos
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: card-panel-actions --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Panel con Acciones</h4>
            <x-card-panel-actions 
                title="Panel de control"
                :actions='[
                    ["icon" => "refresh-cw", "tooltip" => "Actualizar", "action" => "alert(\"Actualizar\")"],
                    ["icon" => "maximize", "tooltip" => "Pantalla completa", "action" => "alert(\"Pantalla completa\")"],
                    ["icon" => "x", "tooltip" => "Cerrar", "action" => "alert(\"Cerrar\")"]
                ]'
                content="Contenido con acciones rápidas disponibles en el header."
                link="#"
                linkText="Ver más detalles"
            />
            <div class="text-sm text-brandNeutral-200">
                <p><strong>✅ Usar para:</strong> Paneles de control, dashboards interactivos</p>
            </div>
        </div>

        {{-- ITEM: card-horizontal --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Layout Horizontal</h4>
            <x-card-horizontal 
                image="https://images.unsplash.com/photo-1680868543815-b8666dba60f7?ixlib=rb-4.0.3&w=320&q=80"
                imageAlt="Imagen de ejemplo"
                title="Card horizontal"
                content="Ejemplo de texto rápido para construir sobre el título del card y conformar la mayor parte del contenido del card."
                footer="Actualizado hace 5 minutos"
                link="#"
            />
            <div class="text-sm text-brandNeutral-200">
                <p><strong>✅ Usar para:</strong> Productos, artículos con imagen prominente</p>
            </div>
        </div>
    </div>
</div>

{{-- SECTION: Image Cards --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Cards con Imágenes
    </h4>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        {{-- ITEM: card-image-top --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Imagen Superior</h4>
            <x-card-image 
                image="https://images.unsplash.com/photo-1680868543815-b8666dba60f7?ixlib=rb-4.0.3&w=320&q=80"
                imageAlt="Imagen superior"
                position="top"
                title="Card con imagen"
                content="Ejemplo de texto para construir sobre el título del card."
                footer="Actualizado hace 5 minutos"
                hover="shadow"
            />
        </div>

        {{-- ITEM: card-image-bottom --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Imagen Inferior</h4>
            <x-card-image 
                image="https://images.unsplash.com/photo-1680868543815-b8666dba60f7?ixlib=rb-4.0.3&w=320&q=80"
                imageAlt="Imagen inferior"
                position="bottom"
                title="Card con imagen"
                content="Ejemplo de texto para construir sobre el título del card."
                footer="Actualizado hace 5 minutos"
            />
        </div>

        {{-- ITEM: card-image-scale --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Efecto Zoom</h4>
            <x-card-image 
                image="https://images.unsplash.com/photo-1680868543815-b8666dba60f7?ixlib=rb-4.0.3&w=560&q=80"
                imageAlt="Imagen con zoom"
                position="top"
                title="Card con zoom"
                content="Hover para ver el efecto de zoom en la imagen."
                hover="scale"
                link="#"
            />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="text-sm text-brandNeutral-300"><code>&lt;x-card-image image="/path/image.jpg" position="top" hover="scale" /&gt;
&lt;x-card-horizontal image="/path/image.jpg" title="Título" /&gt;
&lt;x-card-panel-actions title="Panel" :actions='[]' /&gt;</code></pre>
    </div>
    
    <div class="mt-4 text-sm text-brandNeutral-200 space-y-1">
        <p><strong>Tipos de hover:</strong> <code>none</code>, <code>shadow</code>, <code>scale</code></p>
        <p><strong>Posiciones de imagen:</strong> <code>top</code>, <code>bottom</code></p>
        <p><strong>Tamaños:</strong> <code>sm</code>, <code>md</code>, <code>lg</code></p>
        <p><strong>Sombras:</strong> <code>none</code>, <code>sm</code>, <code>md</code>, <code>lg</code></p>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endpush














