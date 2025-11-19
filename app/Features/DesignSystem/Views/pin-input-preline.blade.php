@extends('design-system::layout')

@section('title', 'PIN Input Preline UI')
@section('page-title', 'PIN Input Components')
@section('page-description', 'Componentes de PIN input basados exactamente en Preline UI')

@section('content')

{{-- SECTION: Basic Usage --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Basic Usage
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">A basic usage of PIN Input.</p>
    
    <x-pin-input-basic length="4" />
</div>

{{-- SECTION: Gray Input --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Gray Input
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Gray input variant.</p>
    
    <x-pin-input-gray length="4" />
</div>

{{-- SECTION: Type (Numbers Only) --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Type
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">By default, it accepts letters and numbers. To allow numbers only, use numbersOnly prop.</p>
    
    <x-pin-input-numbers-only length="4" />
</div>

{{-- SECTION: Modal Example --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Modal Example
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Basic usage in modal window.</p>
    
    <x-pin-input-modal length="4" />
</div>

@endsection















