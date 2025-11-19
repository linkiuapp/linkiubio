{{-- COMPONENT: TextInput | props: {type, label, placeholder, disabled, help, error} --}}
@props([
    'type' => 'text',
    'label' => null,
    'placeholder' => '',
    'disabled' => false,
    'help' => null,
    'error' => null,
    'id' => null,
    'name' => null,
    'value' => null,
    'required' => false
])

@php
    $id = $id ?? 'input-' . uniqid();
    $baseClasses = 'py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none';
    $errorClasses = $error ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '';
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
    
    @if($error)
        <p class="text-sm text-red-600 mt-2">{{ $error }}</p>
    @elseif($help)
        <p class="text-sm text-gray-500 mt-2">{{ $help }}</p>
    @endif
</div>






