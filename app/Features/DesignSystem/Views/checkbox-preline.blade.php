@extends('design-system::layout')

@section('title', 'Checkbox Preline UI')
@section('page-title', 'Checkbox Components')
@section('page-description', 'Componentes de checkbox basados exactamente en Preline UI')

@section('content')

{{-- SECTION: Default --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Default
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">By default, a checkbox input includes a selected and unselected state.</p>
    
    <div class="space-y-3">
        <x-checkbox-basic label="Default checkbox" />
        <x-checkbox-basic label="Checked checkbox" :checked="true" />
    </div>
</div>

{{-- SECTION: Disabled --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Disabled
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Disabled checkbox.</p>
    
    <div class="space-y-3">
        <x-checkbox-basic label="Disabled checkbox" :disabled="true" />
        <x-checkbox-basic label="Disabled checked checkbox" :checked="true" :disabled="true" />
    </div>
</div>

{{-- SECTION: Checkbox Group --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Checkbox Group
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">A group of checkbox components.</p>
    
    <div class="space-y-3">
        <x-checkbox-group 
            :options="[
                ['id' => 'group-1', 'label' => 'Apple'],
                ['id' => 'group-2', 'label' => 'Pear'],
                ['id' => 'group-3', 'label' => 'Orange']
            ]" 
        />
        <x-checkbox-group 
            :options="[
                ['id' => 'group-4', 'label' => 'Apple', 'checked' => true],
                ['id' => 'group-5', 'label' => 'Pear', 'checked' => true],
                ['id' => 'group-6', 'label' => 'Orange', 'checked' => true]
            ]" 
        />
        <x-checkbox-group 
            :options="[
                ['id' => 'group-7', 'label' => 'Apple', 'disabled' => true],
                ['id' => 'group-8', 'label' => 'Pear', 'disabled' => true],
                ['id' => 'group-9', 'label' => 'Orange', 'disabled' => true]
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
        <x-checkbox-with-description 
            title="Delete" 
            description="Notify me when this action happens." 
            :checked="true"
        />
        <x-checkbox-with-description 
            title="Archive" 
            description="Notify me when this action happens." 
        />
    </div>
</div>

{{-- SECTION: Checkbox within Form Input --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Checkbox within Form Input
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Checkbox components within form input stacked in a grid format.</p>
    
    <div class="grid sm:grid-cols-2 gap-2 mb-6">
        <x-checkbox-in-form label="Default checkbox" />
        <x-checkbox-in-form label="Checked checkbox" :checked="true" />
    </div>
    
    <p class="body-small text-brandNeutral-200 mb-6">Checkbox components within form input vertically grouped.</p>
    
    <div class="grid space-y-2">
        <x-checkbox-in-form label="Default checkbox" layout="vertical" />
        <x-checkbox-in-form label="Checked checkbox" :checked="true" layout="vertical" />
    </div>
</div>

{{-- SECTION: Validation States --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Validation States
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">It provides valuable, actionable feedback to your users with HTML5 form validation.</p>
    
    <div class="space-y-3">
        <x-checkbox-validation 
            type="error" 
            label="This is an error checkbox" 
            :disabled="true"
        />
        <x-checkbox-validation 
            type="success" 
            label="This is a success checkbox" 
            :checked="true"
        />
    </div>
</div>

@endsection















