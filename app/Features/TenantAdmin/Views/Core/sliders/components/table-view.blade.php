{{-- SECTION: Table View --}}
<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center w-12">
                                <input 
                                    type="checkbox" 
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    id="select-all-sliders"
                                >
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Slider
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Activar y Desactivar
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Programación
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Transición
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($sliders as $slider)
                            {{-- ITEM: slider#{{ $loop->index }} | id:{{ $slider->id }} | name:{{ $slider->name }} --}}
                            <tr class="hover:bg-gray-50 transition-colors" data-slider-id="{{ $slider->id }}">
                                {{-- COMPONENT: Checkbox --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input 
                                        type="checkbox" 
                                        class="slider-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" 
                                        value="{{ $slider->id }}"
                                    >
                                </td>
                                {{-- End COMPONENT: Checkbox --}}

                                {{-- SECTION: Slider Info --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($slider->image_path)
                                            <img 
                                                src="{{ Storage::disk('public')->url($slider->image_path) }}" 
                                                alt="{{ $slider->name }}"
                                                class="w-24 h-auto object-cover rounded-lg border border-gray-200"
                                            >
                                        @else
                                            <div class="w-24 h-16 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                                                <i data-lucide="image" class="w-6 h-6 text-gray-400"></i>
                                            </div>
                                        @endif
                                        
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900">{{ $slider->name }}</p>
                                            @if($slider->description)
                                                <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $slider->description }}</p>
                                            @endif
                                            @if($slider->url)
                                                <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                                    <i data-lucide="link" class="w-3 h-3"></i>
                                                    {{ $slider->url_type === 'internal' ? 'Interno' : 'Externo' }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                {{-- End SECTION: Slider Info --}}

                                {{-- SECTION: Status Badge --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($slider->is_active)
                                        {{-- COMPONENT: BadgeSoft | props:{type:success} --}}
                                        <x-badge-soft type="success" text="Activo" />
                                        {{-- End COMPONENT: BadgeSoft --}}
                                    @else
                                        {{-- COMPONENT: BadgeSoft | props:{type:error} --}}
                                        <x-badge-soft type="error" text="Inactivo" />
                                        {{-- End COMPONENT: BadgeSoft --}}
                                    @endif
                                </td>
                                {{-- End SECTION: Status Badge --}}

                                {{-- SECTION: Toggle Switch --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <label for="toggle-{{ $slider->id }}" class="relative inline-block w-11 h-6 cursor-pointer">
                                        <input 
                                            type="checkbox" 
                                            id="toggle-{{ $slider->id }}"
                                            class="peer sr-only slider-toggle"
                                            data-slider-id="{{ $slider->id }}"
                                            data-url="{{ route('tenant.admin.sliders.toggle-status', [$store->slug, $slider->id]) }}"
                                            {{ $slider->is_active ? 'checked' : '' }}
                                        >
                                        <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                                    </label>
                                </td>
                                {{-- End SECTION: Toggle Switch --}}

                                {{-- SECTION: Scheduling Badge --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($slider->is_scheduled)
                                        @if($slider->is_permanent)
                                            {{-- COMPONENT: BadgeSoft | props:{type:success} --}}
                                            <x-badge-soft type="success" text="Permanente" />
                                            {{-- End COMPONENT: BadgeSoft --}}
                                        @else
                                            {{-- COMPONENT: BadgeSoft | props:{type:warning} --}}
                                            <x-badge-soft type="warning" text="Programado" />
                                            {{-- End COMPONENT: BadgeSoft --}}
                                        @endif
                                    @else
                                        {{-- COMPONENT: BadgeSoft | props:{type:info} --}}
                                        <x-badge-soft type="info" text="Siempre" />
                                        {{-- End COMPONENT: BadgeSoft --}}
                                    @endif
                                </td>
                                {{-- End SECTION: Scheduling Badge --}}

                                {{-- SECTION: Transition Duration --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="text-sm font-medium text-gray-900">{{ $slider->transition_duration }}s</span>
                                </td>
                                {{-- End SECTION: Transition Duration --}}

                                {{-- SECTION: Actions --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center gap-2">
                                        {{-- COMPONENT: TooltipTop | props:{text:Ver detalles} --}}
                                        <x-tooltip-top text="Ver detalles">
                                            <a 
                                                href="{{ route('tenant.admin.sliders.show', [$store->slug, $slider->id]) }}"
                                                class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                aria-label="Ver detalles"
                                            >
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </a>
                                        </x-tooltip-top>
                                        {{-- End COMPONENT: TooltipTop --}}

                                        {{-- COMPONENT: TooltipTop | props:{text:Editar} --}}
                                        <x-tooltip-top text="Editar">
                                            <a 
                                                href="{{ route('tenant.admin.sliders.edit', [$store->slug, $slider->id]) }}"
                                                class="inline-flex items-center justify-center w-8 h-8 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors"
                                                aria-label="Editar"
                                            >
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </a>
                                        </x-tooltip-top>
                                        {{-- End COMPONENT: TooltipTop --}}

                                        {{-- COMPONENT: TooltipTop | props:{text:Duplicar} --}}
                                        <x-tooltip-top text="Duplicar">
                                            <button 
                                                @click="$dispatch('duplicate-slider', { id: {{ $slider->id }}, name: '{{ addslashes($slider->name) }}' })"
                                                class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:bg-gray-50 rounded-lg transition-colors {{ $currentCount >= $maxSliders ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                aria-label="Duplicar"
                                                @if($currentCount >= $maxSliders) disabled @endif
                                            >
                                                <i data-lucide="copy" class="w-4 h-4"></i>
                                            </button>
                                        </x-tooltip-top>
                                        {{-- End COMPONENT: TooltipTop --}}

                                        {{-- COMPONENT: TooltipTop | props:{text:Eliminar} --}}
                                        <x-tooltip-top text="Eliminar">
                                            <button 
                                                type="button"
                                                @click.stop="$dispatch('delete-slider', { id: {{ $slider->id }}, name: '{{ addslashes($slider->name) }}', rowElement: $el.closest('tr') })"
                                                class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                aria-label="Eliminar"
                                            >
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </x-tooltip-top>
                                        {{-- End COMPONENT: TooltipTop --}}
                                    </div>
                                </td>
                                {{-- End SECTION: Actions --}}
                            </tr>
                            {{-- End ITEM: slider#{{ $loop->index }} --}}
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    {{-- COMPONENT: EmptyState --}}
                                    <x-empty-state 
                                        :svg="$emptyStateSvg"
                                        :title="$emptyStateTitle"
                                        :message="$emptyStateMessage"
                                    >
                                        @if($currentCount < $maxSliders)
                                            <a href="{{ route('tenant.admin.sliders.create', $store->slug) }}">
                                                {{-- COMPONENT: ButtonIcon | props:{type:solid, color:info, icon:plus-circle} --}}
                                                <x-button-icon 
                                                    type="solid" 
                                                    color="info" 
                                                    icon="plus-circle"
                                                    size="md"
                                                    text="Crear primer slider"
                                                />
                                                {{-- End COMPONENT: ButtonIcon --}}
                                            </a>
                                        @endif
                                    </x-empty-state>
                                    {{-- End COMPONENT: EmptyState --}}
                                </td>
                            </tr>
                        @endforelse
                        {{-- SECTION: Dynamic Empty State (hidden initially, shown when all items are deleted) --}}
                        <tr id="dynamic-empty-state" style="display: none;">
                            <td colspan="7" class="px-6 py-12 text-center">
                                {{-- COMPONENT: EmptyState --}}
                                <x-empty-state 
                                    :svg="$emptyStateSvg"
                                    :title="$emptyStateTitle"
                                    :message="$emptyStateMessage"
                                >
                                    @if($currentCount < $maxSliders)
                                        <a href="{{ route('tenant.admin.sliders.create', $store->slug) }}">
                                            {{-- COMPONENT: ButtonIcon | props:{type:solid, color:info, icon:plus-circle} --}}
                                            <x-button-icon 
                                                type="solid" 
                                                color="info" 
                                                icon="plus-circle"
                                                size="md"
                                                text="Crear primer slider"
                                            />
                                            {{-- End COMPONENT: ButtonIcon --}}
                                        </a>
                                    @endif
                                </x-empty-state>
                                {{-- End COMPONENT: EmptyState --}}
                            </td>
                        </tr>
                        {{-- End SECTION: Dynamic Empty State --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- End SECTION: Table View --}}

