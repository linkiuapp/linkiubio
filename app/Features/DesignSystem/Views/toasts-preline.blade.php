@extends('design-system::layout')

@section('page-title', 'Toasts')
@section('page-description', 'Componentes de toasts y notificaciones basados en Preline UI')

@section('content')
{{-- SECTION: Toast Basic --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Toast Basic
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: basic --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Toast Básico</h4>
            <div class="space-y-3">
                <x-toast-basic type="info" message="Este es un mensaje normal." />
                <x-toast-basic type="success" message="Este es un mensaje de éxito." />
                <x-toast-basic type="error" message="Este es un mensaje de error." />
                <x-toast-basic type="warning" message="Este es un mensaje de advertencia." />
            </div>
        </div>
        
        {{-- ITEM: with-close --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Con Botón de Cerrar</h4>
            <div class="space-y-3">
                <x-toast-basic type="info" message="Este es un mensaje con botón de cerrar." :showClose="true" />
            </div>
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Notificaciones, mensajes de estado, alertas</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites modales o alertas persistentes</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-toast-basic type="success" message="Operación exitosa" /&gt;
&lt;x-toast-basic type="error" message="Error al procesar" :showClose="true" /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Toast Condensed --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Toast Condensed
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: condensed --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Toast Compacto</h4>
            <x-toast-condensed message="Tu email ha sido enviado" actionLabel="Deshacer" />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Notificaciones con acciones rápidas, mensajes con opción de deshacer</p>
            <p><strong>❌ NO usar para:</strong> Cuando solo necesites un mensaje simple sin acciones</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-toast-condensed message="Tu email ha sido enviado" actionLabel="Deshacer" /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Toast Solid --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Toast Solid
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: solid-colors --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Variantes de Color Sólido</h4>
            <div class="space-y-3">
                <x-toast-solid color="gray-dark" message="Hello, world! Este es un mensaje toast." />
                <x-toast-solid color="gray" message="Hello, world! Este es un mensaje toast." />
                <x-toast-solid color="teal" message="Hello, world! Este es un mensaje toast." />
                <x-toast-solid color="blue" message="Hello, world! Este es un mensaje toast." />
                <x-toast-solid color="red" message="Hello, world! Este es un mensaje toast." />
                <x-toast-solid color="yellow" message="Hello, world! Este es un mensaje toast." />
                <x-toast-solid color="green" message="Hello, world! Este es un mensaje toast." />
                <x-toast-solid color="indigo" message="Hello, world! Este es un mensaje toast." />
                <x-toast-solid color="purple" message="Hello, world! Este es un mensaje toast." />
                <x-toast-solid color="pink" message="Hello, world! Este es un mensaje toast." />
            </div>
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Notificaciones destacadas, mensajes con mayor visibilidad</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites un toast con fondo blanco estándar</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-toast-solid color="blue" message="Hello, world!" /&gt;
&lt;x-toast-solid color="red" message="Error!" /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Toast Soft --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Toast Soft
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: soft-colors --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Variantes de Color Suave</h4>
            <div class="space-y-3">
                <x-toast-soft color="gray-dark" message="Hello, world! Este es un mensaje toast." />
                <x-toast-soft color="gray" message="Hello, world! Este es un mensaje toast." />
                <x-toast-soft color="teal" message="Hello, world! Este es un mensaje toast." />
                <x-toast-soft color="blue" message="Hello, world! Este es un mensaje toast." />
                <x-toast-soft color="red" message="Hello, world! Este es un mensaje toast." />
                <x-toast-soft color="yellow" message="Hello, world! Este es un mensaje toast." />
                <x-toast-soft color="green" message="Hello, world! Este es un mensaje toast." />
                <x-toast-soft color="indigo" message="Hello, world! Este es un mensaje toast." />
                <x-toast-soft color="purple" message="Hello, world! Este es un mensaje toast." />
                <x-toast-soft color="pink" message="Hello, world! Este es un mensaje toast." />
            </div>
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Notificaciones sutiles, mensajes con fondo suave</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites un toast con fondo blanco o sólido</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-toast-soft color="blue" message="Hello, world!" /&gt;
&lt;x-toast-soft color="teal" message="Éxito!" /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Toast Loading --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Toast Loading
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: loading --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Toast con Indicador de Carga</h4>
            <x-toast-loading message="Acción en progreso" />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Notificaciones de procesos en curso, acciones asíncronas</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites un toast con mensaje estático</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-toast-loading message="Acción en progreso" /&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Toast With Actions --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Toast With Actions
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: with-actions --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Toast con Acciones</h4>
            <x-toast-with-actions 
                title="Notificaciones de app"
                description="Las notificaciones pueden incluir alertas, sonidos y badges de iconos."
                icon="bell"
                :actions="[
                    ['label' => 'No permitir'],
                    ['label' => 'Permitir']
                ]"
            />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Notificaciones con múltiples opciones, confirmaciones, permisos</p>
            <p><strong>❌ NO usar para:</strong> Cuando solo necesites un mensaje simple</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-toast-with-actions 
    title="Notificaciones de app"
    description="Las notificaciones pueden incluir alertas..."
    :actions="[['label' => 'No permitir'], ['label' => 'Permitir']]"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Toast Stack --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Toast Stack
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: stack --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Múltiples Toasts Apilados</h4>
            <div class="space-y-3">
                <x-toast-with-actions 
                    title="Notificaciones de app"
                    description="Las notificaciones pueden incluir alertas, sonidos y badges de iconos."
                    icon="bell"
                    :actions="[
                        ['label' => 'No permitir'],
                        ['label' => 'Permitir']
                    ]"
                />
                <x-toast-basic type="success" message="Tus preferencias de app se han actualizado correctamente." />
            </div>
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Mostrar múltiples notificaciones apiladas verticalmente</p>
            <p><strong>❌ NO usar para:</strong> Cuando solo necesites un toast individual</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;div class="space-y-3"&gt;
    &lt;x-toast-with-actions ... /&gt;
    &lt;x-toast-basic ... /&gt;
&lt;/div&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Props Documentation --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Documentación de Props
    </h4>
    
    <div class="mt-4 body-small text-brandNeutral-200 space-y-4">
        <div>
            <p><strong>ToastBasic props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>type</code>: Tipo de toast (info, success, error, warning) - default: 'info'</li>
                <li><code>message</code>: Mensaje a mostrar (opcional, puede usar slot)</li>
                <li><code>id</code>: ID único para el toast (opcional)</li>
                <li><code>showClose</code>: Si mostrar botón de cerrar - default: false</li>
                <li><code>onClose</code>: Callback al cerrar (opcional)</li>
            </ul>
        </div>
        
        <div>
            <p><strong>ToastCondensed props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>message</code>: Mensaje a mostrar (opcional, puede usar slot)</li>
                <li><code>actionLabel</code>: Etiqueta del botón de acción - default: 'Deshacer'</li>
                <li><code>actionUrl</code>: URL para el botón de acción (opcional)</li>
                <li><code>onAction</code>: Callback para la acción (opcional)</li>
                <li><code>onClose</code>: Callback para cerrar (opcional)</li>
                <li><code>id</code>: ID único para el toast (opcional)</li>
            </ul>
        </div>
        
        <div>
            <p><strong>ToastSolid props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>color</code>: Color del fondo (gray-dark, gray, teal, blue, red, yellow, green, indigo, purple, pink) - default: 'gray'</li>
                <li><code>message</code>: Mensaje a mostrar (opcional, puede usar slot)</li>
                <li><code>id</code>: ID único para el toast (opcional)</li>
                <li><code>onClose</code>: Callback al cerrar (opcional)</li>
            </ul>
        </div>
        
        <div>
            <p><strong>ToastSoft props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>color</code>: Color del fondo (gray-dark, gray, teal, blue, red, yellow, green, indigo, purple, pink) - default: 'gray'</li>
                <li><code>message</code>: Mensaje a mostrar (opcional, puede usar slot)</li>
                <li><code>id</code>: ID único para el toast (opcional)</li>
                <li><code>onClose</code>: Callback al cerrar (opcional)</li>
            </ul>
        </div>
        
        <div>
            <p><strong>ToastLoading props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>message</code>: Mensaje a mostrar - default: 'Acción en progreso'</li>
                <li><code>spinnerColor</code>: Color del spinner (blue, gray, red, yellow, green) - default: 'blue'</li>
                <li><code>id</code>: ID único para el toast (opcional)</li>
            </ul>
        </div>
        
        <div>
            <p><strong>ToastWithActions props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>title</code>: Título del toast (opcional)</li>
                <li><code>description</code>: Descripción del toast (opcional)</li>
                <li><code>icon</code>: Nombre del icono Lucide - default: 'bell'</li>
                <li><code>iconColor</code>: Color del icono - default: 'text-gray-600'</li>
                <li><code>actions</code>: Array de acciones con 'label' y opcionalmente 'url' o 'onClick'</li>
                <li><code>id</code>: ID único para el toast (opcional)</li>
            </ul>
        </div>
    </div>
</div>

{{-- SECTION: Nota sobre Animaciones --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Nota sobre Animaciones
    </h4>
    
    <div class="body-small text-brandNeutral-200 space-y-4">
        <p>
            El componente <code>ToastCondensed</code> incluye animaciones de salida usando las clases 
            <code>hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300</code>.
        </p>
        <p>
            Estas animaciones funcionan automáticamente cuando se usa el sistema JavaScript de Preline UI 
            para remover elementos. Si necesitas usar estas animaciones sin Preline JS, puedes implementar 
            tu propia lógica JavaScript para agregar/remover las clases.
        </p>
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

