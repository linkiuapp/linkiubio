@extends('design-system::layout')

@section('title', 'Switch/Toggle Preline UI')
@section('page-title', 'Switch/Toggle Components')
@section('page-description', 'Componentes de switch/toggle basados exactamente en Preline UI')

@section('content')

{{-- SECTION: Example --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Example
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">The default form of a toggle.</p>
    
    <div>
        <x-switch-basic />
    </div>
</div>

{{-- SECTION: With Description --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        With Description
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">The basic usage with description.</p>
    
    <div class="space-y-3">
        <x-switch-with-description label="Unchecked" />
        <x-switch-with-description label="Checked" :checked="true" />
        <x-switch-with-description label="Off" label-position="left" />
        <x-switch-with-description label="On" label-position="left" :checked="true" />
    </div>
</div>

{{-- SECTION: Disabled --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Disabled
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Disabled switch.</p>
    
    <div class="space-y-3">
        <x-switch-with-description label="Unchecked" :disabled="true" />
        <x-switch-with-description label="Checked" :checked="true" :disabled="true" />
        <x-switch-with-description label="Off" label-position="left" :disabled="true" />
        <x-switch-with-description label="On" label-position="left" :checked="true" :disabled="true" />
    </div>
</div>

{{-- SECTION: Sizes --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Sizes
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Switches stacked small to large sizes.</p>
    
    <div class="space-y-3">
        <x-switch-sizes size="xs" label="Extra small" />
        <x-switch-sizes size="sm" label="Small" />
        <x-switch-sizes size="md" label="Medium" />
        <x-switch-sizes size="lg" label="Large" />
    </div>
</div>

{{-- SECTION: Soft Color Variant --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Soft Color Variant
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Soft style switch options.</p>
    
    <div class="space-y-3">
        <x-switch-soft size="sm" />
        <x-switch-soft size="md" />
        <x-switch-soft size="lg" />
    </div>
</div>

{{-- SECTION: Validation States --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Validation States
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">It provides valuable, actionable feedback to your users with HTML5 form validation.</p>
    
    <div class="space-y-3">
        <x-switch-validation 
            type="valid" 
            label="Valid switch" 
            :checked="true"
        />
        <x-switch-validation 
            type="invalid" 
            label="Invalid switch" 
            :checked="true"
        />
    </div>
</div>

@endsection















