{{-- COMPONENT: FloatingLabelInput | props: {type, label, placeholder, disabled, error} --}}
@props([
    'type' => 'text',
    'label' => 'Label',
    'placeholder' => ' ',
    'disabled' => false,
    'error' => null,
    'id' => null,
    'name' => null,
    'value' => null,
    'required' => false
])

@php
    $id = $id ?? 'floating-input-' . uniqid();
    $baseClasses = 'peer py-4 px-4 block w-full bg-gray-100 border-transparent rounded-lg text-sm placeholder:text-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none';
    $errorClasses = $error ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '';
    $labelClasses = 'absolute top-0 start-0 p-4 h-full text-sm truncate pointer-events-none transition ease-in-out duration-100 border border-transparent peer-disabled:opacity-50 peer-disabled:pointer-events-none peer-focus:text-xs peer-focus:-translate-y-1.5 peer-focus:text-gray-500 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:-translate-y-1.5 peer-[:not(:placeholder-shown)]:text-gray-500';
@endphp

<div class="relative">
    <input 
        type="{{ $type }}"
        id="{{ $id }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        value="{{ $value }}"
        {{ $disabled ? 'disabled' : '' }}
        {{ $required ? 'required' : '' }}
        class="{{ $baseClasses }} {{ $errorClasses }}"
        {{ $attributes }}
    >
    
    <label for="{{ $id }}" class="{{ $labelClasses }}">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    
    @if($error)
        <p class="text-sm text-red-600 mt-2">{{ $error }}</p>
    @endif
</div>






