

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label' => null,
    'name' => null,
    'value' => '#FFFFFF',
    'required' => false,
    'helper' => null,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'label' => null,
    'name' => null,
    'value' => '#FFFFFF',
    'required' => false,
    'helper' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    use Illuminate\Support\Str;

    $initial = strtoupper($value ?? '#FFFFFF');
    if (!str_starts_with($initial, '#')) {
        $initial = '#' . ltrim($initial, '#');
    }
?>

<div
    x-data="(() => {
        return {
            color: '<?php echo e($initial); ?>',
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
                            name: '<?php echo e($name); ?>',
                            value: normalized,
                        }
                    }));
                    if (Alpine.store('design')) {
                        if ('<?php echo e($name); ?>' === 'header_background_color') {
                            Alpine.store('design').bgColor = normalized;
                        }
                        if ('<?php echo e($name); ?>' === 'header_text_color') {
                            Alpine.store('design').textColor = normalized;
                        }
                        if ('<?php echo e($name); ?>' === 'header_description_color') {
                            Alpine.store('design').descriptionColor = normalized;
                        }
                    }
                    this.$dispatch('input', normalized);
                });
                // Emitir valor inicial
                this.$nextTick(() => {
                    window.dispatchEvent(new CustomEvent('color-changed', {
                        detail: {
                            name: '<?php echo e($name); ?>',
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
                            name: '<?php echo e($name); ?>',
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
                            name: '<?php echo e($name); ?>',
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
    <?php echo e($attributes->class('space-y-2')); ?>

>
    <?php if($label): ?>
        <label class="flex items-center gap-1 text-sm font-semibold text-gray-800">
            <?php echo e($label); ?>

            <?php if($required): ?>
                <span class="text-error-500">*</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>

    <div class="flex items-center gap-3">
        
        <button
            type="button"
            class="size-11 rounded-lg border border-gray-200 shadow-2xs transition hover:shadow-md focus:outline-none focus:ring-2 focus:ring-primary-200"
            :style="{ backgroundColor: color }"
            @click="toggle"
            :aria-label="`Seleccionar color para <?php echo e($label ?? $name); ?>`"
        ></button>

        
        <div class="relative flex-1">
            <input
                type="text"
                name="<?php echo e($name); ?>"
                :value="color"
                @input="onInput"
                class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium uppercase tracking-wide text-gray-800 focus:border-primary-300 focus:outline-none focus:ring-2 focus:ring-primary-200"
                placeholder="#FFFFFF"
                autocomplete="off"
            >
            <?php if($helper): ?>
                <p class="mt-1 text-xs text-gray-500"><?php echo e($helper); ?></p>
            <?php endif; ?>
            <p
                x-show="error"
                x-text="error"
                class="mt-1 text-xs text-error-500"
            ></p>
        </div>
    </div>

    
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
<?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/ColorPickers/ColorPickerBasic.blade.php ENDPATH**/ ?>