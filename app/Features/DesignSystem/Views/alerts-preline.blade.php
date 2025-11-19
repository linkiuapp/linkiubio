@extends('design-system::layout')

@section('title', 'Alerts Preline UI')
@section('page-title', 'Alert Components')
@section('page-description', 'Componentes de alertas basados exactamente en Preline UI')

@section('content')

{{-- SECTION: Solid Color Alerts --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Alertas de Colores Sólidos
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Estos colores sólidos son ideales para crear una apariencia cohesiva y pulida en cualquier aplicación.
        </p>
        
        <div class="space-y-3">
            <x-alert-solid type="dark" title="Oscuro" message="¡Deberías revisar algunos de esos campos!" />
            <x-alert-solid type="secondary" title="Secundario" message="¡Deberías revisar algunos de esos campos!" />
            <x-alert-solid type="info" title="Info" message="¡Deberías revisar algunos de esos campos!" />
            <x-alert-solid type="success" title="Éxito" message="¡Deberías revisar algunos de esos campos!" />
            <x-alert-solid type="danger" title="Peligro" message="¡Deberías revisar algunos de esos campos!" />
            <x-alert-solid type="warning" title="Advertencia" message="¡Deberías revisar algunos de esos campos!" />
            <x-alert-solid type="light" title="Claro" message="¡Deberías revisar algunos de esos campos!" />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-alert-solid type="success" title="Éxito" message="¡Deberías revisar algunos de esos campos!" /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Soft Color Alerts --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Alertas de Tonos Suaves
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Estos tonos gentiles y silenciados crean una forma sutil pero efectiva de llamar la atención sin abrumar al usuario.
        </p>
        
        <div class="space-y-3">
            <x-alert-soft type="dark" title="Oscuro" message="¡Deberías revisar algunos de esos campos!" />
            <x-alert-soft type="secondary" title="Secundario" message="¡Deberías revisar algunos de esos campos!" />
            <x-alert-soft type="info" title="Info" message="¡Deberías revisar algunos de esos campos!" />
            <x-alert-soft type="success" title="Éxito" message="¡Deberías revisar algunos de esos campos!" />
            <x-alert-soft type="danger" title="Peligro" message="¡Deberías revisar algunos de esos campos!" />
            <x-alert-soft type="warning" title="Advertencia" message="¡Deberías revisar algunos de esos campos!" />
            <x-alert-soft type="light" title="Claro" message="¡Deberías revisar algunos de esos campos!" />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-alert-soft type="success" title="Éxito" message="¡Deberías revisar algunos de esos campos!" /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Bordered Alerts --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Alertas con Borde
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Usa un mensaje de descubrimiento para significar una actualización de la UI o proporcionar información sobre nuevas funciones y onboarding.
        </p>
        
        <div class="space-y-5">
            <x-alert-bordered 
                type="success" 
                title="Actualización exitosa"  
                message="Has actualizado correctamente tus preferencias de email." 
            />
            
            <x-alert-bordered 
                type="error" 
                title="Error" 
                message="Tu compra ha sido rechazada." 
            />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-alert-bordered type="success" title="Actualización exitosa" message="Has actualizado correctamente tus preferencias de email." /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Dismiss Alert --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Alerta Descartable
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Usa dismiss-alert para descartar un contenido. Requiere JS (Preline UI Remove Element plugin).
        </p>
        
        <div class="p-4 rounded-lg">
            <x-alert-dismiss 
                type="success" 
                title="Archivo subido exitosamente" 
            />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-alert-dismiss type="success" title="Archivo subido exitosamente" /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Discovery Alert --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Alerta de Descubrimiento
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Usa un mensaje de descubrimiento para notificar actualizaciones de UI o proporcionar información sobre nuevas funciones y onboarding.
        </p>
        
        <div class="p-4 rounded-lg">
            <x-alert-discovery 
                title="Nueva versión publicada" 
                message="Chris Lynch publicó una nueva versión de esta página. Actualiza para ver los cambios." 
            />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-alert-discovery title="Nueva versión publicada" message="Chris Lynch publicó una nueva versión de esta página. Actualiza para ver los cambios." /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Actions Alert --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Alerta con Acciones
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Ejemplo de alerta más interactiva con botones de acción.
        </p>
        
        <div class="p-4 rounded-lg">
            <x-alert-actions 
                title="YouTube quiere enviarte notificaciones" 
                message="Las notificaciones pueden incluir alertas, sonidos e insignias de iconos. Estos se pueden configurar en Configuración."
                :actions='[
                    ["text" => "No permitir", "action" => "alert(\"Denegado\")"],
                    ["text" => "Permitir", "action" => "alert(\"Permitido\")"]
                ]'
            />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-alert-actions title="YouTube quiere enviarte notificaciones" message="..." :actions='[["text" => "No permitir"], ["text" => "Permitir"]]' /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: With List Alert --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Alerta con Lista
    </h4>
    
    <div class="space-y-4">
        <p class="body-small text-brandNeutral-200">
            Similarmente puedes usar listas.
        </p>
        
        <div class="p-4 rounded-lg">
            <x-alert-with-list 
                title="Ha ocurrido un problema al enviar tus datos" 
                :items='[
                    "Este nombre de usuario ya está en uso",
                    "El campo de email no puede estar vacío",
                    "Por favor ingresa un número de teléfono válido"
                ]'
            />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300 overflow-x-auto"><code>&lt;x-alert-with-list title="Ha ocurrido un problema al enviar tus datos" :items='["Error 1", "Error 2"]' /&gt;</code></pre>
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
