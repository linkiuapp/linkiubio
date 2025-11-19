{{-- COMPONENT: InputWithIcon | props: {type, label, placeholder, icon, iconPosition, disabled, error} --}}
@props([
    'type' => 'text',
    'label' => null,
    'placeholder' => '',
    'icon' => null,
    'iconPosition' => 'left',
    'disabled' => false,
    'error' => null,
    'id' => null,
    'name' => null,
    'value' => null,
    'required' => false
])

@php
    $id = $id ?? 'icon-input-' . uniqid();
    $baseClasses = 'py-3 block w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none';
    $errorClasses = $error ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '';
    $paddingClasses = $iconPosition === 'left' ? 'ps-11 pe-4' : 'ps-4 pe-11';
@endphp

<div class="space-y-2">
    @if($label)
        <label for="{{ $id }}" class="inline-block text-sm font-medium text-gray-800">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <div class="relative">
        <input 
            type="{{ $type }}"
            id="{{ $id }}"
            name="{{ $name }}"
            placeholder="{{ $placeholder }}"
            value="{{ $value }}"
            {{ $disabled ? 'disabled' : '' }}
            {{ $required ? 'required' : '' }}
            class="{{ $baseClasses }} {{ $errorClasses }} {{ $paddingClasses }} border-gray-300"
            {{ $attributes }}
        >
        
        @if($icon)
            <div class="absolute inset-y-0 {{ $iconPosition === 'left' ? 'start-0 flex items-center pointer-events-none z-20 ps-4' : 'end-0 flex items-center pointer-events-none z-20 pe-4' }}">
                <i data-lucide="{{ $icon }}" class="flex-shrink-0 size-4 text-gray-400"></i>
            </div>
        @endif
    </div>
    
    @if($error)
        <p class="text-sm text-red-600 mt-2">{{ $error }}</p>
    @endif
</div>






