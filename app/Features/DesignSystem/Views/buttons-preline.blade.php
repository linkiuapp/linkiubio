@extends('design-system::layout')

@section('title', 'Buttons Preline UI')
@section('page-title', 'Button Components')
@section('page-description', 'Componentes de botones basados exactamente en Preline UI')

@section('content')

{{-- SECTION: Button Types --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Tipos de Botones
    </h4>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- ITEM: button-types-examples --}}
        <div class="space-y-6">
            <h4 class="body-lg-medium text-brandNeutral-400">Estilos Disponibles</h4>
            
            <div class="space-y-4">
                <div class="space-y-2">
                    <h4 class="body-small text-brandNeutral-300">Solid</h4>
                    <x-button-base type="solid" color="info" text="Solid" />
                    <p class="text-sm text-brandNeutral-200">Para acciones principales e importantes</p>
                </div>
                
                <div class="space-y-2">
                    <h4 class="body-small text-brandNeutral-300">Outline</h4>
                    <x-button-base type="outline" color="info" text="Outline" />
                    <p class="text-sm text-brandNeutral-200">Para acciones secundarias</p>
                </div>
                
                <div class="space-y-2">
                    <h4 class="body-small text-brandNeutral-300">Ghost</h4>
                    <x-button-base type="ghost" color="info" text="Ghost" />
                    <p class="text-sm text-brandNeutral-200">Para acciones sutiles y minimalistas</p>
                </div>
                
                <div class="space-y-2">
                    <h4 class="body-small text-brandNeutral-300">Soft</h4>
                    <x-button-base type="soft" color="info" text="Soft" />
                    <p class="text-sm text-brandNeutral-200">Para acciones suaves con fondo de color</p>
                </div>
                
                <div class="space-y-2">
                    <h4 class="body-small text-brandNeutral-300">White</h4>
                    <x-button-base type="white" color="info" text="White" />
                    <p class="text-sm text-brandNeutral-200">Para fondos oscuros o coloridos</p>
                </div>
                
                <div class="space-y-2">
                    <h4 class="body-small text-brandNeutral-300">Link</h4>
                    <x-button-base type="link" color="info" text="Link" />
                    <p class="text-sm text-brandNeutral-200">Para enlaces que parecen botones</p>
                </div>
            </div>
        </div>

        {{-- ITEM: button-sizes --}}
        <div class="space-y-6">
            <h4 class="body-lg-medium text-brandNeutral-400">Tamaños Disponibles</h4>
            
            <div class="space-y-4">
                <div class="space-y-2">
                    <h4 class="body-small text-brandNeutral-300">Small</h4>
                    <x-button-base type="solid" color="info" size="sm" text="Small" />
                </div>
                
                <div class="space-y-2">
                    <h4 class="body-small text-brandNeutral-300">Default (Medium)</h4>
                    <x-button-base type="solid" color="info" size="md" text="Default" />
                </div>
                
                <div class="space-y-2">
                    <h4 class="body-small text-brandNeutral-300">Large</h4>
                    <x-button-base type="solid" color="info" size="lg" text="Large" />
                </div>
            </div>
            
            <div class="bg-brandNeutral-50 rounded-lg p-4">
                <pre class="text-sm text-brandNeutral-300"><code>&lt;x-button-base type="solid" color="info" size="sm" text="Pequeño" /&gt;
&lt;x-button-base type="solid" color="info" size="md" text="Mediano" /&gt;
&lt;x-button-base type="solid" color="info" size="lg" text="Grande" /&gt;</code></pre>
            </div>
        </div>
    </div>
</div>

{{-- SECTION: Color Variants --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Variantes de Colores
    </h4>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- ITEM: solid-colors --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Botones Sólidos</h4>
            <div class="flex flex-wrap gap-2">
                <x-button-base type="solid" color="dark" text="Dark" />
                <x-button-base type="solid" color="secondary" text="Secondary" />
                <x-button-base type="solid" color="success" text="Success" />
                <x-button-base type="solid" color="info" text="Info" />
                <x-button-base type="solid" color="error" text="Error" />
                <x-button-base type="solid" color="warning" text="Warning" />
                <x-button-base type="solid" color="light" text="Light" />
            </div>
        </div>

        {{-- ITEM: outline-colors --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Botones Outline</h4>
            <div class="flex flex-wrap gap-2">
                <x-button-base type="outline" color="dark" text="Dark" />
                <x-button-base type="outline" color="secondary" text="Secondary" />
                <x-button-base type="outline" color="success" text="Success" />
                <x-button-base type="outline" color="info" text="Info" />
                <x-button-base type="outline" color="error" text="Error" />
                <x-button-base type="outline" color="warning" text="Warning" />
                <x-button-base type="outline" color="light" text="Light" />
            </div>
        </div>

        {{-- ITEM: ghost-colors --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Botones Ghost</h4>
            <div class="flex flex-wrap gap-2">
                <x-button-base type="ghost" color="dark" text="Dark" />
                <x-button-base type="ghost" color="secondary" text="Secondary" />
                <x-button-base type="ghost" color="success" text="Success" />
                <x-button-base type="ghost" color="info" text="Info" />
                <x-button-base type="ghost" color="error" text="Error" />
                <x-button-base type="ghost" color="warning" text="Warning" />
                <x-button-base type="ghost" color="light" text="Light" />
            </div>
        </div>

        {{-- ITEM: soft-colors --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Botones Soft</h4>
            <div class="flex flex-wrap gap-2">
                <x-button-base type="soft" color="dark" text="Dark" />
                <x-button-base type="soft" color="secondary" text="Secondary" />
                <x-button-base type="soft" color="success" text="Success" />
                <x-button-base type="soft" color="info" text="Info" />
                <x-button-base type="soft" color="error" text="Error" />
                <x-button-base type="soft" color="warning" text="Warning" />
                <x-button-base type="soft" color="light" text="Light" />
            </div>
        </div>
    </div>
</div>

{{-- SECTION: Icon Buttons --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Botones con Iconos
    </h4>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- ITEM: icon-buttons-text --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Con Texto e Icono</h4>
            <div class="space-y-3">
                <x-button-icon type="solid" color="info" icon="shopping-cart" text="Agregar al carrito" />
                <x-button-icon type="outline" color="success" icon="arrow-right" text="Registrarse gratis" iconPosition="right" />
                <x-button-icon type="ghost" color="error" icon="trash-2" text="Eliminar" />
                <x-button-icon type="soft" color="warning" icon="edit" text="Editar" />
            </div>
            <div class="text-sm text-brandNeutral-200 space-y-1">
                <p><strong>✅ Usar para:</strong> Acciones con significado visual claro</p>
                <p><strong>❌ Evitar en:</strong> Cuando el icono no aporta claridad</p>
            </div>
        </div>

        {{-- ITEM: icon-only-buttons --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Solo Iconos</h4>
            <div class="space-y-3">
                <div class="flex gap-2 items-center">
                    <x-button-icon-only type="solid" color="info" icon="plus" size="sm" ariaLabel="Agregar elemento" />
                    <x-button-icon-only type="solid" color="info" icon="plus" size="md" ariaLabel="Agregar elemento" />
                    <x-button-icon-only type="solid" color="info" icon="plus" size="lg" ariaLabel="Agregar elemento" />
                </div>
                <div class="flex gap-2 items-center">
                    <x-button-icon-only type="outline" color="error" icon="x" size="md" ariaLabel="Cerrar" />
                    <x-button-icon-only type="ghost" color="secondary" icon="edit" size="md" ariaLabel="Editar" />
                    <x-button-icon-only type="soft" color="success" icon="check" size="md" ariaLabel="Confirmar" />
                </div>
            </div>
            <div class="text-sm text-brandNeutral-200 space-y-1">
                <p><strong>✅ Usar para:</strong> Toolbars, acciones secundarias, espacios reducidos</p>
                <p><strong>❌ Evitar en:</strong> Acciones principales, significado no claro</p>
            </div>
        </div>
    </div>
</div>

{{-- SECTION: Loading Buttons --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Botones de Carga
    </h4>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- ITEM: loading-states --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Estados de Carga</h4>
            <div class="space-y-3">
                <div class="space-y-2">
                    <h4 class="body-small text-brandNeutral-300">Normal</h4>
                    <x-button-loading type="solid" color="info" text="Guardar" :loading="false" />
                </div>
                <div class="space-y-2">
                    <h4 class="body-small text-brandNeutral-300">Cargando con texto</h4>
                    <x-button-loading type="solid" color="info" text="Guardar" loadingText="Guardando..." :loading="true" />
                </div>
                <div class="space-y-2">
                    <h4 class="body-small text-brandNeutral-300">Solo spinner</h4>
                    <x-button-loading type="solid" color="info" text="Guardar" :loading="true" :loadingOnly="true" />
                </div>
            </div>
        </div>

        {{-- ITEM: loading-types --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Diferentes Tipos</h4>
            <div class="space-y-3">
                <x-button-loading type="solid" color="info" text="Solid" loadingText="Cargando..." :loading="true" />
                <x-button-loading type="outline" color="info" text="Outline" loadingText="Procesando..." :loading="true" />
                <x-button-loading type="ghost" color="info" text="Ghost" loadingText="Enviando..." :loading="true" />
                <x-button-loading type="soft" color="info" text="Soft" loadingText="Guardando..." :loading="true" />
            </div>
            <div class="text-sm text-brandNeutral-200 space-y-1">
                <p><strong>✅ Usar para:</strong> Formularios, operaciones asíncronas, procesos largos</p>
                <p><strong>❌ Evitar en:</strong> Acciones instantáneas, navegación simple</p>
            </div>
        </div>
    </div>
</div>

{{-- SECTION: Block Buttons --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Botones de Ancho Completo
    </h4>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- ITEM: block-examples --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Ejemplos</h4>
            <div class="space-y-3">
                <x-button-block type="solid" color="info" text="Crear cuenta" />
                <x-button-block type="outline" color="success" text="Iniciar sesión" />
                <x-button-block type="soft" color="warning" text="Guardar borrador" icon="save" />
                <x-button-block type="ghost" color="secondary" text="Cancelar" />
            </div>
        </div>

        {{-- ITEM: block-code --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Código de Ejemplo</h4>
            <div class="bg-brandNeutral-50 rounded-lg p-4">
                <pre class="text-sm text-brandNeutral-300"><code>&lt;x-button-block type="solid" color="info" text="Crear cuenta" /&gt;
&lt;x-button-block type="outline" text="Iniciar sesión" /&gt;
&lt;x-button-block type="soft" icon="save" text="Guardar" /&gt;</code></pre>
            </div>
            <div class="text-sm text-brandNeutral-200 space-y-1">
                <p><strong>✅ Usar para:</strong> Formularios principales, CTAs en móvil, acciones primarias</p>
                <p><strong>❌ Evitar en:</strong> Acciones secundarias, toolbars, múltiples acciones</p>
            </div>
        </div>
    </div>
</div>

{{-- SECTION: Button States --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Estados de Botones
    </h4>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- ITEM: disabled-states --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Estados Deshabilitados</h4>
            <div class="space-y-3">
                <x-button-base type="solid" color="info" text="Solid" :disabled="true" />
                <x-button-base type="outline" color="info" text="Outline" :disabled="true" />
                <x-button-base type="ghost" color="info" text="Ghost" :disabled="true" />
                <x-button-base type="soft" color="info" text="Soft" :disabled="true" />
                <x-button-base type="white" color="info" text="White" :disabled="true" />
                <x-button-base type="link" color="info" text="Link" :disabled="true" />
            </div>
        </div>

        {{-- ITEM: interactive-examples --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Ejemplos Interactivos</h4>
            <div class="space-y-3">
                <x-button-icon type="solid" color="success" icon="check-circle" text="Completar pedido" />
                <x-button-icon type="outline" color="error" icon="trash-2" text="Eliminar elemento" />
                <x-button-loading type="solid" color="warning" text="Procesar pago" loadingText="Procesando..." :loading="false" onclick="this.setAttribute('loading', 'true')" />
                <x-button-block type="solid" color="info" icon="arrow-right" text="Continuar al checkout" iconPosition="right" />
            </div>
            <div class="text-sm text-brandNeutral-200 space-y-1">
                <p><strong>Tip:</strong> Los botones disabled automáticamente incluyen `pointer-events-none` y `opacity-50`</p>
                <p><strong>Accesibilidad:</strong> Los botones solo-icono incluyen `aria-label` automático</p>
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














