{{--
Tab Bar Underline - Tabs con barra con subrayado
Uso: Tabs con estilo de barra con borde y subrayado
Cuándo usar: Para organizar contenido con estilo de barra destacada
Cuándo NO usar: Cuando necesites navegación entre páginas (usa Navs)
Ejemplo: <x-tab-bar-underline :tabs="[['label' => 'Tab 1', 'content' => 'Contenido 1'], ['label' => 'Tab 2', 'content' => 'Contenido 2']]" />
--}}

@props([
    'tabs' => [], // Array de tabs: [['label' => '...', 'content' => '...', 'icon' => '...', 'active' => false]]
    'tabId' => null, // ID único para el grupo de tabs (se genera automáticamente si no se proporciona)
])

@php
    $uniqueId = $tabId ?? 'tab-bar-underline-' . uniqid();
    $defaultActive = 0;
    foreach($tabs as $index => $tab) {
        if ($tab['active'] ?? false) {
            $defaultActive = $index;
            break;
        }
    }
@endphp

<div x-data="{ activeTab: {{ $defaultActive }} }" {{ $attributes }}>
    <nav class="relative z-0 flex border border-gray-200 rounded-xl overflow-hidden" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
        @foreach($tabs as $index => $tab)
            @php
                $label = $tab['label'] ?? '';
                $tabButtonId = $uniqueId . '-item-' . ($index + 1);
                $icon = $tab['icon'] ?? null;
            @endphp
            
            <button 
                type="button" 
                @click="activeTab = {{ $index }}"
                :class="activeTab === {{ $index }} ? 'border-b-blue-600 text-gray-900' : 'border-b-gray-200 text-gray-500 hover:text-gray-700'"
                class="relative min-w-0 flex-1 bg-white {{ $index === 0 ? 'first:border-s-0' : '' }} border-s border-b-2 py-4 px-4 text-sm font-medium text-center overflow-hidden hover:bg-gray-50 focus:z-10 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none transition-colors" 
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
