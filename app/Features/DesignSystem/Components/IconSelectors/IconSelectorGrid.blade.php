{{--
Icon Selector Grid - Selector de iconos en grid
Uso: Seleccionar un icono de una lista de iconos disponibles
Cuándo usar: Cuando necesites que el usuario seleccione un icono de una lista
Cuándo NO usar: Cuando no necesites seleccionar iconos
Ejemplo: <x-icon-selector-grid name="icon_id" :icons="$icons" :selected="old('icon_id')" />
--}}

@props([
    'name' => 'icon_id',
    'icons' => [],
    'selected' => null,
    'required' => false,
    'searchable' => true,
    'columns' => [
        'mobile' => 4,
        'tablet' => 6,
        'desktop' => 12,
    ],
])

@php
    $uniqueId = 'icon-selector-' . uniqid();
@endphp

<div 
    x-data="{ 
        searchIcon: '',
        get visibleCount() {
            return Array.from(this.$el.querySelectorAll('.icon-option'))
                .filter(el => window.getComputedStyle(el).display !== 'none').length;
        }
    }"
    class="icon-selector-container"
>
    @if($searchable)
        {{-- ITEM: Search Input --}}
        <x-input-with-icon 
            type="text"
            icon="search"
            icon-position="left"
            placeholder="Buscar icono..."
            x-model="searchIcon"
            class="mb-6"
        />
        {{-- End ITEM: Search Input --}}
    @endif

    {{-- ITEM: Icons Grid --}}
    <div class="grid grid-cols-{{ $columns['mobile'] }} sm:grid-cols-{{ $columns['tablet'] }} md:grid-cols-{{ $columns['desktop'] }} gap-3 mt-6">
        @foreach($icons as $icon)
            <label 
                class="relative cursor-pointer icon-option"
                @if($searchable)
                    x-show="searchIcon === '' || '{{ strtolower($icon->display_name ?? $icon->name ?? '') }}'.includes(searchIcon.toLowerCase())"
                @endif
            >
                <input 
                    type="radio" 
                    name="{{ $name }}" 
                    value="{{ $icon->id }}" 
                    class="sr-only peer"
                    {{ ($selected == $icon->id) ? 'checked' : '' }}
                    @if($required) required @endif
                >
                <div class="w-full aspect-square bg-gray-50 rounded-lg p-3 border border-gray-200 
                            peer-checked:border-blue-600 peer-checked:bg-blue-50 
                            hover:bg-blue-50 hover:border-blue-300
                            transition-all items-center justify-center flex">
                    @if(isset($icon->image_url))
                        <img 
                            src="{{ $icon->image_url }}" 
                            alt="{{ $icon->display_name ?? $icon->name ?? 'Icono' }}" 
                            class="w-full h-full object-contain"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                        >
                        <i data-lucide="image" class="w-full h-full text-gray-400" style="display: none;"></i>
                    @elseif(isset($icon->icon))
                        <i data-lucide="{{ $icon->icon }}" class="w-full h-full text-gray-400"></i>
                    @else
                        <i data-lucide="image" class="w-full h-full text-gray-400"></i>
                    @endif
                </div>
            </label>
        @endforeach
    </div>
    {{-- End ITEM: Icons Grid --}}

    @if($searchable)
        {{-- ITEM: Empty State --}}
        <div 
            x-show="searchIcon !== '' && visibleCount === 0" 
            class="text-center py-8"
            x-cloak
        >
            <p class="text-sm text-gray-500">No se encontraron iconos con ese nombre</p>
        </div>
        {{-- End ITEM: Empty State --}}
    @endif
</div>

