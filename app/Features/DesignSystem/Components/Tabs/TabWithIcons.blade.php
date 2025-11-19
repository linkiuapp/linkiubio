{{--
Tab With Icons - Tabs con iconos
Uso: Tabs con iconos en cada botón
Cuándo usar: Para mejorar la UX visual con iconos descriptivos
Cuándo NO usar: Cuando los tabs sean autoexplicativos sin necesidad de iconos
Ejemplo: <x-tab-with-icons :tabs="[['label' => 'Tab 1', 'content' => 'Contenido 1', 'icon' => 'home'], ['label' => 'Tab 2', 'content' => 'Contenido 2', 'icon' => 'user']]" />
--}}

@props([
    'tabs' => [], // Array de tabs: [['label' => '...', 'content' => '...', 'icon' => '...', 'active' => false]]
    'tabId' => null, // ID único para el grupo de tabs (se genera automáticamente si no se proporciona)
])

@php
    $uniqueId = $tabId ?? 'tab-icons-' . uniqid();
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
                    :class="activeTab === {{ $index }} ? 'font-semibold border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-blue-600'"
                    class="py-4 px-1 inline-flex items-center gap-x-2 border-b-2 text-sm whitespace-nowrap focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none transition-colors" 
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
