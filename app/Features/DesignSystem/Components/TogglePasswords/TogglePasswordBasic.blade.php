{{--
Toggle Password Basic - Input de contraseña con toggle para mostrar/ocultar
Uso: Input de contraseña con botón para mostrar/ocultar la contraseña
Cuándo usar: Cuando necesites que el usuario pueda ver su contraseña mientras la escribe
Cuándo NO usar: Cuando la seguridad requiera que la contraseña siempre esté oculta
Ejemplo: <x-toggle-password-basic name="password" label="Contraseña" placeholder="Ingresa tu contraseña" />
--}}

@props([
    'name' => null,
    'inputId' => null,
    'label' => '',
    'placeholder' => '',
    'value' => '',
    'disabled' => false,
    'maxWidth' => 'max-w-sm',
])

@php
    $uniqueId = $inputId ?? 'toggle-password-' . uniqid();
    $nameAttr = $name ?? $uniqueId;
@endphp

<div class="{{ $maxWidth }}" x-data="{ 
    showPassword: false,
    init() {
        this.$nextTick(() => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    },
    togglePassword() {
        this.showPassword = !this.showPassword;
        this.$nextTick(() => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    }
}">
    @if($label)
        <label for="{{ $uniqueId }}" class="block text-sm mb-2">{{ $label }}</label>
    @endif
    <div class="relative">
        <input 
            id="{{ $uniqueId }}"
            name="{{ $nameAttr }}"
            :type="showPassword ? 'text' : 'password'"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($value) value="{{ $value }}" @endif
            @if($disabled) disabled @endif
            class="py-2.5 sm:py-3 ps-4 pe-10 block w-full border border-gray-400 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
            {{ $attributes }}
        >
        <button 
            type="button" 
            @click="togglePassword()"
            class="absolute inset-y-0 end-0 flex items-center z-20 px-3 cursor-pointer text-gray-400 rounded-e-md focus:outline-hidden focus:text-blue-600"
            aria-label="Mostrar/Ocultar contraseña"
        >
            <i data-lucide="eye" x-show="!showPassword" class="shrink-0 size-3.5" x-init="$nextTick(() => { if (typeof lucide !== 'undefined') lucide.createIcons(); })"></i>
            <i data-lucide="eye-off" x-show="showPassword" class="shrink-0 size-3.5" x-init="$nextTick(() => { if (typeof lucide !== 'undefined') lucide.createIcons(); })"></i>
        </button>
    </div>
</div>

