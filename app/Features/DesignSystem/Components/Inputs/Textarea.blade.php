{{-- COMPONENT: Textarea | props: {label, placeholder, rows, disabled, help, error} --}}
@props([
    'label' => null,
    'placeholder' => '',
    'rows' => 3,
    'disabled' => false,
    'help' => null,
    'error' => null,
    'id' => null,
    'name' => null,
    'value' => null,
    'required' => false
])

@php
    $id = $id ?? 'textarea-' . uniqid();
    $baseClasses = 'py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none';
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
    
    <textarea 
        id="{{ $id }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $disabled ? 'disabled' : '' }}
        {{ $required ? 'required' : '' }}
        class="{{ $baseClasses }} {{ $errorClasses }}"
        {{ $attributes }}
    >{{ $value }}</textarea>
    
    @if($error)
        <p class="text-sm text-red-600 mt-2">{{ $error }}</p>
    @elseif($help)
        <p class="text-sm text-gray-500 mt-2">{{ $help }}</p>
    @endif
</div>






