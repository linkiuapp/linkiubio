@extends('design-system::layout')

@section('title', 'Badges Preline UI')
@section('page-title', 'Badge Components')
@section('page-description', 'Componentes de badges/labels/chips basados exactamente en Preline UI')

@section('content')

{{-- SECTION: Solid Color Badges --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Badges de Colores Sólidos
    </h4>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- ITEM: badge-solid-examples --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Ejemplos Básicos</h4>
            <div class="flex flex-wrap gap-2">
                <x-badge-solid type="dark" text="Dark" />
                <x-badge-solid type="secondary" text="Secondary" />
                <x-badge-solid type="info" text="Info" />
                <x-badge-solid type="success" text="Success" />
                <x-badge-solid type="error" text="Error" />
                <x-badge-solid type="warning" text="Warning" />
                <x-badge-solid type="light" text="Light" />
            </div>
            <div class="text-sm text-brandNeutral-200 space-y-1">
                <p><strong>✅ Usar para:</strong> Estados importantes, categorías principales, información crítica</p>
                <p><strong>❌ Evitar en:</strong> Elementos decorativos, información secundaria</p>
            </div>
        </div>

        {{-- ITEM: badge-solid-code --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Código de Ejemplo</h4>
            <div class="bg-brandNeutral-50 rounded-lg p-4">
                <pre class="text-sm text-brandNeutral-300"><code>&lt;x-badge-solid type="success" text="Activo" /&gt;
&lt;x-badge-solid type="error" text="Error" /&gt;
&lt;x-badge-solid type="warning" text="Pendiente" /&gt;</code></pre>
            </div>
        </div>
    </div>
</div>

{{-- SECTION: Soft Color Badges --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Badges de Tonos Suaves
    </h4>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- ITEM: badge-soft-examples --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Ejemplos Básicos</h4>
            <div class="flex flex-wrap gap-2">
                <x-badge-soft type="dark" text="Dark" />
                <x-badge-soft type="secondary" text="Secondary" />
                <x-badge-soft type="info" text="Info" />
                <x-badge-soft type="success" text="Success" />
                <x-badge-soft type="error" text="Error" />
                <x-badge-soft type="warning" text="Warning" />
                <x-badge-soft type="light" text="Light" />
            </div>
            <div class="text-sm text-brandNeutral-200 space-y-1">
                <p><strong>✅ Usar para:</strong> Información secundaria, etiquetas decorativas, clasificaciones no críticas</p>
                <p><strong>❌ Evitar en:</strong> Alertas importantes, estados críticos</p>
            </div>
        </div>

        {{-- ITEM: badge-soft-code --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Código de Ejemplo</h4>
            <div class="bg-brandNeutral-50 rounded-lg p-4">
                <pre class="text-sm text-brandNeutral-300"><code>&lt;x-badge-soft type="success" text="Completado" /&gt;
&lt;x-badge-soft type="info" text="Información" /&gt;
&lt;x-badge-soft type="warning" text="Advertencia" /&gt;</code></pre>
            </div>
        </div>
    </div>
</div>

{{-- SECTION: Special Badge Types --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Badges Especiales
    </h4>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- ITEM: badge-max-width --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Con Ancho Máximo</h4>
            <div class="space-y-2">
                <x-badge-max-width type="info" text="Este contenido es un poco más largo y se trunca" maxWidth="40" />
            </div>
            <div class="text-sm text-brandNeutral-200">
                <p><strong>Uso:</strong> Para textos largos que necesitan límite de ancho</p>
            </div>
        </div>

        {{-- ITEM: badge-indicator --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Con Indicador</h4>
            <div class="flex flex-wrap gap-2">
                <x-badge-indicator type="success" text="Conectado" />
                <x-badge-indicator type="error" text="Desconectado" />
                <x-badge-indicator type="warning" text="Pendiente" />
            </div>
            <div class="text-sm text-brandNeutral-200">
                <p><strong>Uso:</strong> Estados de conexión, actividad en tiempo real</p>
            </div>
        </div>
    </div>
</div>

{{-- SECTION: Badge with Icons --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Badges con Iconos
    </h4>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- ITEM: badge-icon-examples --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Con Texto e Icono</h4>
            <div class="flex flex-wrap gap-2">
                <x-badge-icon type="success" icon="check-circle" text="Conectado" />
                <x-badge-icon type="error" icon="alert-triangle" text="Atención" />
                <x-badge-icon type="info" icon="loader" text="Cargando" />
                <x-badge-icon type="secondary" icon="power" text="Deshabilitado" />
            </div>
        </div>

        {{-- ITEM: badge-icon-only --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Solo Iconos</h4>
            <div class="flex flex-wrap gap-2">
                <x-badge-icon type="success" icon="trending-up" :iconOnly="true" />
                <x-badge-icon type="error" icon="trending-down" :iconOnly="true" />
                <x-badge-icon type="secondary" icon="trending-up" :iconOnly="true" />
            </div>
            <div class="text-sm text-brandNeutral-200">
                <p><strong>Uso:</strong> Estados con significado visual claro, métricas</p>
            </div>
        </div>
    </div>
</div>

{{-- SECTION: Interactive Badges --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Badges Interactivos
    </h4>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- ITEM: badge-removable --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Removibles</h4>
            <div class="flex flex-wrap gap-2">
                <x-badge-removable type="info" text="Filtro aplicado" />
                <x-badge-removable type="success" text="Tag seleccionado" />
                <x-badge-removable type="warning" text="Categoría" />
            </div>
            <div class="text-sm text-brandNeutral-200">
                <p><strong>Uso:</strong> Filtros aplicados, tags seleccionados, elementos temporales</p>
            </div>
        </div>

        {{-- ITEM: badge-avatar --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Con Avatar</h4>
            <div class="flex flex-wrap gap-2">
                <x-badge-avatar name="Christina" avatar="https://images.unsplash.com/photo-1531927557220-a9e23c1e4794?ixlib=rb-4.0.3&w=32&h=32&fit=crop&crop=face" />
                <x-badge-avatar name="Mark" avatar="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&w=32&h=32&fit=crop&crop=face" :removable="true" />
                <x-badge-avatar name="Usuario Sin Avatar" />
            </div>
            <div class="text-sm text-brandNeutral-200">
                <p><strong>Uso:</strong> Equipos de trabajo, asignaciones, participantes</p>
            </div>
        </div>
    </div>
</div>

{{-- SECTION: Badge Buttons --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Badges en Botones
    </h4>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- ITEM: badge-buttons --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Contadores</h4>
            <div class="flex flex-wrap gap-4">
                <x-badge-button text="Notificaciones" count="5" icon="bell" />
                <x-badge-button text="Mensajes" count="12" icon="message-circle" color="blue" />
                <x-badge-button text="Carritos" count="3" icon="shopping-cart" color="green" />
            </div>
        </div>

        {{-- ITEM: badge-buttons-styles --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Diferentes Estilos</h4>
            <div class="flex flex-wrap gap-4">
                <x-badge-button text="Default" count="8" buttonStyle="default" />
                <x-badge-button text="Outline" count="15" buttonStyle="outline" />
                <x-badge-button text="Ghost" count="2" buttonStyle="ghost" />
            </div>
            <div class="text-sm text-brandNeutral-200">
                <p><strong>Uso:</strong> Botones con contadores, notificaciones pendientes</p>
            </div>
        </div>
    </div>
</div>

{{-- SECTION: Positioned Badges --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Badges Posicionados
    </h4>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- ITEM: positioned-examples --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">En Botones</h4>
            <div class="flex gap-4">
                <button type="button" class="relative inline-flex justify-center items-center w-11 h-11 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    <x-badge-positioned count="99+" type="notification" />
                </button>
                
                <button type="button" class="relative inline-flex justify-center items-center w-11 h-11 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    <x-badge-positioned type="profile" color="green" />
                </button>
            </div>
        </div>

        {{-- ITEM: positioned-animated --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Con Animación</h4>
            <div class="flex gap-4">
                <button type="button" class="relative inline-flex justify-center items-center w-11 h-11 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50">
                    <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                    <x-badge-positioned :animated="true" />
                </button>
                
                <button type="button" class="relative py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50">
                    Notificación
                    <x-badge-positioned count="9+" :animated="true" />
                </button>
            </div>
            <div class="text-sm text-brandNeutral-200">
                <p><strong>Uso:</strong> Notificaciones urgentes, actividad en tiempo real</p>
            </div>
        </div>
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














