{{--
Color Picker Basic - Selector de color con presets y soporte para Alpine x-model
Uso: Permite escoger un color en formato hexadecimal con ayuda visual y presets
Cuándo usar: Cuando necesites que el usuario seleccione un color para estilos o fondos
Cuándo NO usar: Cuando el color se determine automáticamente sin intervención del usuario
Ejemplo: <x-color-picker-basic label="Color" name="header_background_color" value="#FFFFFF" />
--}}

@props([
    'label' => null,
    'name' => null,
    'value' => '#FFFFFF',
    'required' => false,
    'helper' => null,
])

@php
    use Illuminate\Support\Str;

    $initial = strtoupper($value ?? '#FFFFFF');
    if (!str_starts_with($initial, '#')) {
        $initial = '#' . ltrim($initial, '#');
    }
@endphp

<div
    x-data="(() => {
        return {
            color: '{{ $initial }}',
            isOpen: false,
            error: null,
            presets: [
                '#DA27A7', '#ED2E45', '#FF6B35', '#FFAD0D', '#A855F7', '#EC4899',
                '#00C76F', '#10B981', '#14B8A6', '#06B6D4', '#0000FE', '#001B48',
                '#1C1C1E', '#4B5563', '#9CA3AF', '#D1D5DB', '#F3F4F6', '#FFFFFF',
            ],
            init() {
                this.color = this.normalize(this.color);
                this.$watch('color', (newValue) => {
                    const normalized = this.normalize(newValue || '');
                    if (!this.isValid(normalized)) {
                        this.error = 'Formato inválido (usa #RRGGBB)';
                        return;
                    }
                    this.error = null;
                    this.color = normalized;
                    window.dispatchEvent(new CustomEvent('color-changed', {
                        detail: {
                            name: '{{ $name }}',
                            value: normalized,
                        }
                    }));
                    if (Alpine.store('design')) {
                        if ('{{ $name }}' === 'header_background_color') {
                            Alpine.store('design').bgColor = normalized;
                        }
                        if ('{{ $name }}' === 'header_text_color') {
                            Alpine.store('design').textColor = normalized;
                        }
                        if ('{{ $name }}' === 'header_description_color') {
                            Alpine.store('design').descriptionColor = normalized;
                        }
                    }
                    this.$dispatch('input', normalized);
                });
                // Emitir valor inicial
                this.$nextTick(() => {
                    window.dispatchEvent(new CustomEvent('color-changed', {
                        detail: {
                            name: '{{ $name }}',
                            value: this.color,
                        }
                    }));
                    this.$dispatch('input', this.color);
                });
            },
            normalize(value) {
                if (!value) {
                    return '#FFFFFF';
                }
                let formatted = value.toString().trim().toUpperCase();
                if (!formatted.startsWith('#')) {
                    formatted = '#' + formatted.replace('#', '');
                }
                if (formatted.length === 4) {
                    const r = formatted[1];
                    const g = formatted[2];
                    const b = formatted[3];
                    formatted = `#${r}${r}${g}${g}${b}${b}`;
                }
                return formatted.slice(0, 7);
            },
            isValid(value) {
                return /^#[0-9A-F]{6}$/.test(value);
            },
            toggle() {
                this.isOpen = !this.isOpen;
            },
            close() {
                this.isOpen = false;
            },
            select(color) {
                const normalized = this.normalize(color);
                if (this.isValid(normalized)) {
                    this.color = normalized;
                    window.dispatchEvent(new CustomEvent('color-changed', {
                        detail: {
                            name: '{{ $name }}',
                            value: normalized,
                        }
                    }));
                    this.$dispatch('input', normalized);
                    this.close();
                }
            },
            onInput(event) {
                const normalized = this.normalize(event.target.value);
                if (this.isValid(normalized)) {
                    this.color = normalized;
                    window.dispatchEvent(new CustomEvent('color-changed', {
                        detail: {
                            name: '{{ $name }}',
                            value: normalized,
                        }
                    }));
                } else {
                    this.color = event.target.value;
                }
            },
        };
    })()"
    x-modelable="color"
    {{ $attributes->class('space-y-2') }}
>
    @if($label)
        <label class="flex items-center gap-1 text-sm font-semibold text-gray-800">
            {{ $label }}
            @if($required)
                <span class="text-error-500">*</span>
            @endif
        </label>
    @endif

    <div class="flex items-center gap-3">
        {{-- COMPONENT: Color swatch trigger --}}
        <button
            type="button"
            class="size-11 rounded-lg border border-gray-200 shadow-2xs transition hover:shadow-md focus:outline-none focus:ring-2 focus:ring-primary-200"
            :style="{ backgroundColor: color }"
            @click="toggle"
            :aria-label="`Seleccionar color para {{ $label ?? $name }}`"
        ></button>

        {{-- COMPONENT: Hex input --}}
        <div class="relative flex-1">
            <input
                type="text"
                name="{{ $name }}"
                :value="color"
                @input="onInput"
                class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium uppercase tracking-wide text-gray-800 focus:border-primary-300 focus:outline-none focus:ring-2 focus:ring-primary-200"
                placeholder="#FFFFFF"
                autocomplete="off"
            >
            @if($helper)
                <p class="mt-1 text-xs text-gray-500">{{ $helper }}</p>
            @endif
            <p
                x-show="error"
                x-text="error"
                class="mt-1 text-xs text-error-500"
            ></p>
        </div>
    </div>

    {{-- COMPONENT: Palette popover --}}
    <div
        x-show="isOpen"
        x-transition:enter="transition duration-150"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative"
        style="display: none;"
    >
        <div class="absolute z-20 mt-2 w-72 rounded-xl border border-gray-200 bg-white p-4 shadow-lg">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-gray-800">Colores predeterminados</span>
                <button
                    type="button"
                    class="inline-flex size-7 items-center justify-center rounded-full border border-transparent bg-gray-100 text-gray-500 hover:bg-gray-200"
                    @click="close"
                >
                    <span class="sr-only">Cerrar selector</span>
                    <i data-lucide="x" class="size-4"></i>
                </button>
            </div>
            <div class="mt-3 grid grid-cols-6 gap-2">
                <template x-for="preset in presets" :key="preset">
                    <button
                        type="button"
                        class="h-9 w-9 rounded-lg border border-white shadow-2xs transition hover:ring-2 hover:ring-primary-200 focus:outline-none"
                        :style="{ backgroundColor: preset }"
                        @click="select(preset)"
                        :aria-label="`Usar color ${preset}`"
                    ></button>
                </template>
            </div>
            <div class="mt-4">
                <label class="text-xs font-medium text-gray-500">Selecciona manualmente</label>
                <input
                    type="color"
                    :value="color"
                    @input="onInput"
                    class="mt-2 h-10 w-full cursor-pointer rounded-lg border border-gray-200"
                >
            </div>
        </div>
    </div>
</div>
