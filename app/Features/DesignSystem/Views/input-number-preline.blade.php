@extends('design-system::layout')

@section('title', 'Input Number Preline UI')
@section('page-title', 'Input Number Components')
@section('page-description', 'Componentes de input number basados exactamente en Preline UI')

@section('content')

{{-- SECTION: Example --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Example
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Basic example with input number.</p>
    
    <x-input-number-basic 
        name="input-number-basic"
        value="1"
    />
</div>

{{-- SECTION: Input Style --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Input Style
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Basic input style example.</p>
    
    <x-input-number-with-label 
        label="Selecciona cantidad"
        name="input-number-label"
        value="1"
    />
</div>

{{-- SECTION: Mini --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Mini
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Basic Mini example.</p>
    
    <x-input-number-mini 
        name="input-number-mini"
        value="0"
    />
</div>

{{-- SECTION: Pricing Seats Example --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Pricing Seats Example
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Basic Pricing seats example.</p>
    
    <x-input-number-pricing 
        title="Asientos adicionales"
        price="$39 mensual"
        name="input-number-pricing"
        value="0"
    />
</div>

{{-- SECTION: Validation States --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Validation States
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">It provides valuable, actionable feedback to your users with HTML5 form validation.</p>
    
    <x-input-number-validation 
        type="error"
        error-message="Fuera de límite"
        name="input-number-error"
        value="10"
    />
</div>

@endsection















