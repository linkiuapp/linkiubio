@extends('design-system::layout')

@section('title', 'Select Preline UI')
@section('page-title', 'Select Components')
@section('page-description', 'Componentes de select basados exactamente en Preline UI')

@section('content')

{{-- SECTION: Example --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Example
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Custom styles are limited to the &lt;select&gt;'s initial appearance and cannot modify the &lt;option&gt;s due to browser limitations.</p>
    
    <x-select-basic 
        name="select-basic"
        :options="[
            '1' => 'Opción 1',
            '2' => 'Opción 2',
            '3' => 'Opción 3'
        ]"
        placeholder="Abre este menú de selección"
    />
</div>

{{-- SECTION: Gray Input --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Gray Input
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Gray select variant.</p>
    
    <x-select-gray 
        name="select-gray"
        :options="[
            '1' => 'Opción 1',
            '2' => 'Opción 2',
            '3' => 'Opción 3'
        ]"
        placeholder="Abre este menú de selección"
    />
</div>

{{-- SECTION: Sizes --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Sizes
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Selects stacked small to large sizes.</p>
    
    <div class="space-y-3">
        <x-select-sizes 
            size="sm"
            name="select-sm"
            :options="[
                '1' => 'Opción 1',
                '2' => 'Opción 2',
                '3' => 'Opción 3'
            ]"
            placeholder="Abre este menú de selección"
        />
        <x-select-sizes 
            size="md"
            name="select-md"
            :options="[
                '1' => 'Opción 1',
                '2' => 'Opción 2',
                '3' => 'Opción 3'
            ]"
            placeholder="Abre este menú de selección"
        />
        <x-select-sizes 
            size="lg"
            name="select-lg"
            :options="[
                '1' => 'Opción 1',
                '2' => 'Opción 2',
                '3' => 'Opción 3'
            ]"
            placeholder="Abre este menú de selección"
        />
    </div>
</div>

{{-- SECTION: Disabled --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Disabled
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Disabled input.</p>
    
    <div class="space-y-3">
        <x-select-basic 
            name="select-disabled"
            :options="[
                '1' => 'Opción 1',
                '2' => 'Opción 2',
                '3' => 'Opción 3'
            ]"
            placeholder="Abre este menú de selección"
            :disabled="true"
        />
        <x-select-gray 
            name="select-disabled-gray"
            :options="[
                '1' => 'Opción 1',
                '2' => 'Opción 2',
                '3' => 'Opción 3'
            ]"
            placeholder="Abre este menú de selección"
            :disabled="true"
        />
    </div>
</div>

{{-- SECTION: Label --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Label
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Basic input example with label.</p>
    
    <x-select-with-label 
        label="Etiqueta"
        name="select-label"
        :options="[
            '1' => 'Opción 1',
            '2' => 'Opción 2',
            '3' => 'Opción 3'
        ]"
        placeholder="Abre este menú de selección"
    />
</div>

{{-- SECTION: Validation States --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Validation States
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">It provides valuable, actionable feedback to your users with HTML5 form validation.</p>
    
    <div class="space-y-6">
        <x-select-validation 
            type="error"
            label="Etiqueta"
            name="select-error"
            error-message="Por favor selecciona un estado válido."
            :options="[
                '1' => 'Opción 1',
                '2' => 'Opción 2',
                '3' => 'Opción 3'
            ]"
            placeholder="Abre este menú de selección"
            selected=""
        />
        <x-select-validation 
            type="success"
            label="Etiqueta"
            name="select-success"
            success-message="¡Se ve bien!"
            :options="[
                '1' => 'Opción 1',
                '2' => 'Opción 2',
                '3' => 'Opción 3'
            ]"
            placeholder="Abre este menú de selección"
            selected="1"
        />
    </div>
</div>

@endsection















