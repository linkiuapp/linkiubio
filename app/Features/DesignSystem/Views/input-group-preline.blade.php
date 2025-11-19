@extends('design-system::layout')

@section('title', 'Input Groups Preline UI')
@section('page-title', 'Input Groups Components')
@section('page-description', 'Componentes de grupos de input basados exactamente en Preline UI')

@section('content')

{{-- SECTION: Checkbox and Radios --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Checkbox and Radios
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Place any checkbox or radio option within an input group's addon instead of text.</p>
    
    <div class="max-w-sm space-y-3">
        <div>
            <x-input-group-checkbox-radio type="checkbox" input-id="checkbox-input" placeholder="Checkbox" />
        </div>
        <div>
            <x-input-group-checkbox-radio type="radio" input-id="radio-input" placeholder="Radio" />
        </div>
    </div>
</div>

{{-- SECTION: Leading Button Add-ons --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Leading Button Add-ons
    </h4>
    
    <div class="max-w-sm space-y-3">
        <div>
            <label for="leading-button-icon" class="sr-only">Label</label>
            <x-input-group-leading-button 
                button-icon="search" 
                input-id="leading-button-icon" 
            />
        </div>
        
        <div>
            <label for="leading-button-text" class="sr-only">Label</label>
            <x-input-group-leading-button 
                button-text="Buscar" 
                button-icon="search" 
                input-id="leading-button-text"
                trailing-addon="http://"
            />
        </div>
        
        <div>
            <label for="leading-button-text-only" class="sr-only">Label</label>
            <x-input-group-leading-button 
                button-text="Buscar" 
                input-id="leading-button-text-only"
                trailing-icon="search"
            />
        </div>
        
        <div>
            <label for="leading-button-simple" class="sr-only">Label</label>
            <x-input-group-leading-button 
                button-text="Botón" 
                input-id="leading-button-simple"
            />
        </div>
        
        <div>
            <label for="leading-button-multiple" class="sr-only">Label</label>
            <div class="flex rounded-lg">
                <button type="button" class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-s-md border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                    Botón
                </button>
                <button type="button" class="-me-px py-3 px-4 inline-flex justify-center items-center gap-2 border border-gray-400 font-medium bg-white text-gray-700 shadow-2xs align-middle hover:bg-gray-50 focus:z-10 focus:outline-hidden focus:ring-2 focus:ring-blue-600 transition-all text-sm">
                    Botón
                </button>
                <input type="text" id="leading-button-multiple" name="leading-button-multiple" class="py-2.5 sm:py-3 px-4 block w-full border border-gray-400 rounded-e-md sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
            </div>
        </div>
    </div>
</div>

{{-- SECTION: Inline Add-on --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Inline Add-on
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Add an inline add-on inside input.</p>
    
    <div class="max-w-sm space-y-3">
        <div>
            <x-input-group-inline-addon 
                addon-text="http://" 
                input-id="inline-addon" 
                label="Website URL"
                placeholder="www.example.com" 
            />
        </div>
    </div>
</div>

{{-- SECTION: Add-on --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Add-on
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Add an add-on in tandem with input.</p>
    
    <div class="max-w-sm space-y-3">
        <div>
            <x-input-group-basic-addon 
                addon-text="http://" 
                input-id="basic-addon" 
                label="Website URL"
                placeholder="www.example.com" 
            />
        </div>
    </div>
</div>

{{-- SECTION: Leading Icon --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Leading Icon
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Add a leading icon inside input.</p>
    
    <div class="max-w-sm space-y-3">
        <div>
            <x-input-group-leading-icon 
                icon="mail" 
                input-id="leading-icon" 
                label="Email address"
                placeholder="you@site.com" 
            />
        </div>
    </div>
</div>

{{-- SECTION: Sizes --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Sizes
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Input groups stacked from small to large.</p>
    
    <div class="max-w-sm space-y-3">
        <div>
            <x-input-group-sizes size="small" addon-text="Small" />
        </div>
        <div>
            <x-input-group-sizes size="default" addon-text="Default" />
        </div>
        <div>
            <x-input-group-sizes size="large" addon-text="Large" />
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof createIcons !== 'undefined') {
            createIcons();
        }
    });
</script>
@endpush

