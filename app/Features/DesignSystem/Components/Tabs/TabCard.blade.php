{{--
Tab Card - Tabs con estilo de tarjeta
Uso: Tabs con estilo de tarjeta con bordes redondeados
Cuándo usar: Para organizar contenido con estilo de tarjeta
Cuándo NO usar: Cuando necesites navegación entre páginas (usa Navs)
Ejemplo: <x-tab-card :tabs="[['label' => 'Tab 1', 'content' => 'Contenido 1'], ['label' => 'Tab 2', 'content' => 'Contenido 2']]" />
--}}

@props([
    'tabs' => [], // Array de tabs: [['label' => '...', 'content' => '...', 'icon' => '...', 'active' => false]]
    'tabId' => null, // ID único para el grupo de tabs (se genera automáticamente si no se proporciona)
])

@php
    $uniqueId = $tabId ?? 'tab-card-' . uniqid();
    $defaultActive = 0;
    foreach($tabs as $index => $tab) {
        if ($tab['active'] ?? false) {
            $defaultActive = $index;
            break;
        }
    }
@endphp

<div x-data="{ activeTab: {{ $defaultActive }} }" {{ $attributes }}>
    <div class="border-b border-gray-200">
        <nav class="flex gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
            @foreach($tabs as $index => $tab)
                @php
                    $label = $tab['label'] ?? '';
                    $tabButtonId = $uniqueId . '-item-' . ($index + 1);
                    $icon = $tab['icon'] ?? null;
                @endphp
                
                <button 
                    type="button" 
                    @click="activeTab = {{ $index }}"
                    :class="activeTab === {{ $index }} ? 'bg-white border-b-transparent text-blue-600' : 'bg-gray-50 text-gray-500 hover:text-gray-700'"
                    class="-mb-px py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium text-center border border-gray-200 rounded-t-lg focus:outline-hidden focus:text-gray-700 disabled:opacity-50 disabled:pointer-events-none transition-colors" 
                    id="{{ $tabButtonId }}" 
                    :aria-selected="activeTab === {{ $index }} ? 'true' : 'false'"
                    role="tab"
                >
                    @if($icon)
                        <i data-lucide="{{ $icon }}" class="shrink-0 size-4"></i>
                    @endif
                    {{ $label }}
                </button>
            @endforeach
        </nav>
    </div>

    <div class="mt-3">
        @foreach($tabs as $index => $tab)
            @php
                $tabPanelId = $uniqueId . '-' . ($index + 1);
                $tabButtonId = $uniqueId . '-item-' . ($index + 1);
                $content = $tab['content'] ?? '';
            @endphp
            
            <div 
                id="{{ $tabPanelId }}" 
                role="tabpanel" 
                aria-labelledby="{{ $tabButtonId }}"
                x-show="activeTab === {{ $index }}"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            >
                {!! $content !!}
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    } else if (typeof createIcons !== 'undefined') {
        createIcons();
    }
});
</script>
@endpush
