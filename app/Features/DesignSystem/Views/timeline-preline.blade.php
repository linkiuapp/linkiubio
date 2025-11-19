@extends('design-system::layout')

@section('page-title', 'Timeline')
@section('page-description', 'Componentes de timeline basados en Preline UI')

@section('content')
{{-- SECTION: Timeline With Time --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Timeline With Time
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: with-time --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Timeline con Hora</h4>
            <div>
                <x-timeline-item 
                    time="12:05PM"
                    title="Created \"Preline in React\" task"
                    titleIcon="file-text"
                    description="Find more detailed insctructions here."
                    :user="['name' => 'James Collins', 'avatar' => 'https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=3&w=320&h=320&q=80']"
                />
                <x-timeline-item 
                    time="12:05PM"
                    title="Release v5.2.0 quick bug fix 🐞"
                    :user="['name' => 'Alex Gregarov', 'initials' => 'A']"
                />
                <x-timeline-item 
                    time="12:05PM"
                    title="Marked \"Install Charts\" completed"
                    description="Finally! You can check it out here."
                    :user="['name' => 'James Collins', 'avatar' => 'https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=3&w=320&h=320&q=80']"
                />
                <x-timeline-item 
                    time="12:05PM"
                    title="Take a break ⛳️"
                    description="Just chill for now... 😉"
                    :isLast="true"
                />
            </div>
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Mostrar eventos en orden cronológico, historial de actividades</p>
            <p><strong>❌ NO usar para:</strong> Contenido no relacionado con el tiempo o eventos</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-timeline-item 
    time="12:05PM"
    title="Evento"
    description="Descripción"
    :user="['name' => 'Usuario', 'avatar' => '...']"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Timeline Collapsable --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Timeline Collapsable
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: collapsable --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Timeline con Sección Colapsable</h4>
            <div>
                <x-timeline-heading>1 Ago, 2023</x-timeline-heading>
                <x-timeline-item 
                    title="Created \"Preline in React\" task"
                    titleIcon="file-text"
                    description="Find more detailed insctructions here."
                    :user="['name' => 'James Collins', 'avatar' => 'https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=3&w=320&h=320&q=80']"
                />
                <x-timeline-item 
                    title="Release v5.2.0 quick bug fix 🐞"
                    :user="['name' => 'Alex Gregarov', 'initials' => 'A']"
                />
                <x-timeline-item 
                    title="Marked \"Install Charts\" completed"
                    description="Finally! You can check it out here."
                    :user="['name' => 'James Collins', 'avatar' => 'https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=3&w=320&h=320&q=80']"
                />
                <x-timeline-heading>31 Jul, 2023</x-timeline-heading>
                <x-timeline-item 
                    title="Take a break ⛳️"
                    description="Just chill for now... 😉"
                    :isLast="false"
                />
                <x-timeline-collapsable 
                    collapseId="timeline-old"
                    heading="30 Jul, 2023"
                    showLabel="Mostrar más antiguo"
                    hideLabel="Ocultar"
                    :items="[
                        [
                            'title' => 'Final touch ups',
                            'description' => 'Double check everything and make sure we\'re ready to go.'
                        ]
                    ]"
                />
            </div>
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Ocultar eventos antiguos, mostrar solo eventos recientes</p>
            <p><strong>❌ NO usar para:</strong> Cuando todos los eventos deben estar siempre visibles</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-timeline-collapsable 
    collapseId="timeline-old"
    heading="30 Jul, 2023"
    :items="[...]"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Timeline Icons and Avatars --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Timeline Icons and Avatars
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: icons-avatars --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Timeline con Iconos y Avatares</h4>
            <div>
                <x-timeline-heading>1 Ago, 2023</x-timeline-heading>
                <x-timeline-item 
                    title="Created \"Preline in React\" task"
                    titleIcon="file-text"
                    description="Find more detailed insctructions here."
                    dotIcon="avatar"
                    dotAvatar="https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=3&w=320&h=320&q=80"
                    :user="['name' => 'James Collins', 'avatar' => 'https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=3&w=320&h=320&q=80']"
                />
                <x-timeline-item 
                    title="Release v5.2.0 quick bug fix 🐞"
                    dotIcon="initials"
                    dotInitials="A"
                    :user="['name' => 'Alex Gregarov', 'initials' => 'A']"
                />
                <x-timeline-item 
                    title="Marked \"Install Charts\" completed"
                    description="Finally! You can check it out here."
                    dotIcon="avatar"
                    dotAvatar="https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=3&w=320&h=320&q=80"
                    :user="['name' => 'James Collins', 'avatar' => 'https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=3&w=320&h=320&q=80']"
                />
                <x-timeline-heading>31 Jul, 2023</x-timeline-heading>
                <x-timeline-item 
                    title="Take a break ⛳️"
                    description="Just chill for now... 😉"
                    dotIcon="icon"
                    dotIconName="activity"
                    :isLast="true"
                />
            </div>
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Timeline con iconos personalizados, avatares en los puntos</p>
            <p><strong>❌ NO usar para:</strong> Cuando solo necesites puntos simples</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-timeline-item 
    title="Evento"
    dotIcon="avatar"
    dotAvatar="..."
/&gt;
&lt;x-timeline-item 
    title="Evento"
    dotIcon="initials"
    dotInitials="A"
/&gt;
&lt;x-timeline-item 
    title="Evento"
    dotIcon="icon"
    dotIconName="activity"
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
            <p><strong>TimelineItem props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>time</code>: Hora a mostrar en el lado izquierdo (opcional)</li>
                <li><code>title</code>: Título del evento</li>
                <li><code>titleIcon</code>: Icono de Lucide para el título (opcional)</li>
                <li><code>description</code>: Descripción del evento (opcional)</li>
                <li><code>user</code>: Array con 'name' y opcionalmente 'avatar' o 'initials'</li>
                <li><code>dotIcon</code>: Tipo de icono del punto ('dot', 'avatar', 'icon', 'initials')</li>
                <li><code>dotAvatar</code>: URL del avatar para el punto</li>
                <li><code>dotInitials</code>: Iniciales para el punto (ej: 'A')</li>
                <li><code>dotIconName</code>: Nombre del icono Lucide para el punto</li>
                <li><code>isLast</code>: Si es el último elemento (oculta la línea) - default: false</li>
            </ul>
        </div>
        
        <div>
            <p><strong>TimelineHeading props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>text</code>: Texto del encabezado (opcional, puede usar slot)</li>
            </ul>
        </div>
        
        <div>
            <p><strong>TimelineCollapsable props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>collapseId</code>: ID único para el collapse (opcional, se genera automáticamente)</li>
                <li><code>items</code>: Array de items del timeline con las mismas props que TimelineItem</li>
                <li><code>heading</code>: Encabezado para la sección colapsable (opcional)</li>
                <li><code>showLabel</code>: Texto del botón para mostrar - default: 'Mostrar más antiguo'</li>
                <li><code>hideLabel</code>: Texto del botón para ocultar - default: 'Ocultar'</li>
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

