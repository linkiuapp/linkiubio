@extends('design-system::layout')

@section('title', 'Radio Preline UI')
@section('page-title', 'Radio Components')
@section('page-description', 'Componentes de radio basados exactamente en Preline UI')

@section('content')

{{-- SECTION: Default --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Default
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">The default way to present a single option from a list.</p>
    
    <div class="space-y-3">
        <x-radio-basic name="default-radio" label="Default radio" />
        <x-radio-basic name="default-radio" label="Checked radio" :checked="true" />
    </div>
</div>

{{-- SECTION: Disabled --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Disabled
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Disabled radio.</p>
    
    <div class="space-y-3">
        <x-radio-basic name="disabled-radio" label="Disabled radio" :disabled="true" />
        <x-radio-basic name="disabled-radio" label="Disabled checked radio" :checked="true" :disabled="true" />
    </div>
</div>

{{-- SECTION: Inline Radio Group --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Inline Radio Group
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">A group of radio components.</p>
    
    <div>
        <x-radio-group 
            name="radio-group"
            :options="[
                ['id' => 'group-1', 'label' => 'Apple', 'checked' => true],
                ['id' => 'group-2', 'label' => 'Pear'],
                ['id' => 'group-3', 'label' => 'Orange']
            ]" 
        />
    </div>
</div>

{{-- SECTION: Vertical Radio Group --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Vertical Radio Group
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">A vertical group of radio components.</p>
    
    <div>
        <x-radio-group 
            name="radio-vertical-group"
            layout="vertical"
            :options="[
                ['id' => 'vertical-1', 'label' => 'Apple', 'checked' => true],
                ['id' => 'vertical-2', 'label' => 'Pear'],
                ['id' => 'vertical-3', 'label' => 'Orange']
            ]" 
        />
    </div>
</div>

{{-- SECTION: List with Description --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        List with Description
    </h4>
    
    <div class="grid space-y-3">
        <x-radio-with-description 
            name="radio-with-description"
            title="Delete" 
            description="Notify me when this action happens." 
            :checked="true"
        />
        <x-radio-with-description 
            name="radio-with-description"
            title="Archive" 
            description="Notify me when this action happens." 
        />
    </div>
</div>

{{-- SECTION: Radio within Form Input --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Radio within Form Input
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Radio components within form input stacked in a grid format.</p>
    
    <div class="grid sm:grid-cols-2 gap-2 mb-6">
        <x-radio-in-form name="radio-in-form" label="Default radio" />
        <x-radio-in-form name="radio-in-form" label="Checked radio" :checked="true" />
    </div>
    
    <p class="body-small text-brandNeutral-200 mb-6">Radio components within form input vertically grouped.</p>
    
    <div class="grid space-y-2">
        <x-radio-in-form name="radio-in-form-vertical" label="Default radio" />
        <x-radio-in-form name="radio-in-form-vertical" label="Checked radio" :checked="true" />
    </div>
</div>

{{-- SECTION: Validation States --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Validation States
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">It provides valuable, actionable feedback to your users with HTML5 form validation.</p>
    
    <div class="space-y-3">
        <x-radio-validation 
            name="radio-states"
            type="error" 
            label="This is an error radio" 
            :disabled="true"
        />
        <x-radio-validation 
            name="radio-states"
            type="success" 
            label="This is a success radio" 
            :checked="true"
        />
    </div>
</div>

@endsection

