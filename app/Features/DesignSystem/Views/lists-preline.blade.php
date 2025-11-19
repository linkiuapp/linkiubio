@extends('design-system::layout')

@section('page-title', 'Lists')
@section('page-description', 'Componentes de listas basados en Preline UI')

@section('content')
{{-- SECTION: Listas Básicas --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Listas Básicas
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: list-disc --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Lista con Viñetas (disc)</h4>
            <x-list-basic 
                type="disc"
                :items="[
                    'Ahora esta es una historia sobre cómo, mi vida se volvió al revés',
                    'Y me gusta tomarme un minuto y sentarme aquí',
                    'Te contaré cómo me convertí en el príncipe de un pueblo llamado Bel-Air'
                ]"
            />
        </div>
        
        {{-- ITEM: list-decimal --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Lista Numerada (decimal)</h4>
            <x-list-basic 
                type="decimal"
                :items="[
                    'Ahora esta es una historia sobre cómo, mi vida se volvió al revés',
                    'Y me gusta tomarme un minuto y sentarme aquí',
                    'Te contaré cómo me convertí en el príncipe de un pueblo llamado Bel-Air'
                ]"
            />
        </div>
        
        {{-- ITEM: list-none --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Lista Sin Viñetas (none)</h4>
            <x-list-basic 
                type="none"
                :items="[
                    'Ahora esta es una historia sobre cómo, mi vida se volvió al revés',
                    'Y me gusta tomarme un minuto y sentarme aquí',
                    'Te contaré cómo me convertí en el príncipe de un pueblo llamado Bel-Air'
                ]"
            />
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-list-basic 
    type="disc" 
    :items="['Item 1', 'Item 2', 'Item 3']" 
/&gt;

&lt;x-list-basic 
    type="decimal" 
    :items="['Item 1', 'Item 2', 'Item 3']" 
/&gt;

&lt;x-list-basic 
    type="none" 
    :items="['Item 1', 'Item 2', 'Item 3']" 
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: List Marker --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Lista con Marcador Personalizado
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: marker-blue --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Marcador Azul</h4>
            <x-list-with-marker 
                color="blue"
                :items="['FAQ', 'License', 'Terms & Conditions']"
            />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Listas donde necesites destacar los marcadores con un color específico</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites listas simples o con iconos</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-list-with-marker 
    color="blue" 
    :items="['FAQ', 'License', 'Terms']" 
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: List Separator --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Lista con Separadores
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: separator --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Separadores Horizontales</h4>
            <x-list-separator 
                :items="['FAQ', 'License', 'Terms & Conditions']"
            />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Navegación horizontal, breadcrumbs, enlaces relacionados</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites listas verticales o con viñetas</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-list-separator 
    :items="['FAQ', 'License', 'Terms']" 
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: List Checked --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Lista con Checks
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: checked-simple --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Check Simple</h4>
            <x-list-checked 
                variant="simple"
                color="blue"
                :items="['FAQ', 'License', 'Terms & Conditions']"
            />
        </div>
        
        {{-- ITEM: checked-circle-outline --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Check con Círculo (Outline)</h4>
            <x-list-checked 
                variant="circle-outline"
                color="blue"
                :items="['FAQ', 'License', 'Terms & Conditions']"
            />
        </div>
        
        {{-- ITEM: checked-circle-filled --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Check con Círculo (Filled)</h4>
            <x-list-checked 
                variant="circle-filled"
                color="blue"
                :items="['FAQ', 'License', 'Terms & Conditions']"
            />
        </div>
        
        {{-- ITEM: checked-colors --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Variaciones de Color</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="body-small text-brandNeutral-300 mb-2">Azul</p>
                    <x-list-checked 
                        variant="simple"
                        color="blue"
                        :items="['Azul']"
                    />
                </div>
                <div>
                    <p class="body-small text-brandNeutral-300 mb-2">Rojo</p>
                    <x-list-checked 
                        variant="simple"
                        color="red"
                        :items="['Rojo']"
                    />
                </div>
                <div>
                    <p class="body-small text-brandNeutral-300 mb-2">Verde</p>
                    <x-list-checked 
                        variant="simple"
                        color="green"
                        :items="['Verde']"
                    />
                </div>
                <div>
                    <p class="body-small text-brandNeutral-300 mb-2">Amarillo</p>
                    <x-list-checked 
                        variant="simple"
                        color="yellow"
                        :items="['Amarillo']"
                    />
                </div>
            </div>
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Listas de características, beneficios, checklist</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites listas simples sin iconos</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-list-checked 
    variant="simple" 
    color="blue" 
    :items="['FAQ', 'License', 'Terms']" 
/&gt;

&lt;x-list-checked 
    variant="circle-outline" 
    color="blue" 
    :items="['FAQ', 'License', 'Terms']" 
/&gt;

&lt;x-list-checked 
    variant="circle-filled" 
    color="blue" 
    :items="['FAQ', 'License', 'Terms']" 
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
            <p><strong>ListBasic props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>type</code>: Tipo de lista ('disc', 'decimal', 'none')</li>
                <li><code>items</code>: Array de items a mostrar (required)</li>
                <li><code>spacing</code>: Espaciado entre items (default: 'space-y-2')</li>
                <li><code>textColor</code>: Color del texto (default: 'text-gray-800')</li>
                <li><code>textSize</code>: Tamaño del texto (default: 'body-small')</li>
            </ul>
        </div>
        
        <div>
            <p><strong>ListWithMarker props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>color</code>: Color del marcador ('blue', 'red', 'green', 'yellow', 'gray')</li>
                <li><code>items</code>: Array de items (required)</li>
                <li><code>spacing</code>, <code>textColor</code>, <code>textSize</code>: Igual que ListBasic</li>
            </ul>
        </div>
        
        <div>
            <p><strong>ListSeparator props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>items</code>: Array de items (required)</li>
                <li><code>textColor</code>: Color del texto (default: 'text-gray-600')</li>
                <li><code>textSize</code>: Tamaño del texto (default: 'body-small')</li>
            </ul>
        </div>
        
        <div>
            <p><strong>ListChecked props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>variant</code>: Variante ('simple', 'circle-outline', 'circle-filled')</li>
                <li><code>color</code>: Color del check ('blue', 'red', 'green', 'yellow', 'gray', 'teal')</li>
                <li><code>items</code>: Array de items (required)</li>
                <li><code>spacing</code>, <code>textColor</code>, <code>textSize</code>: Igual que ListBasic</li>
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

