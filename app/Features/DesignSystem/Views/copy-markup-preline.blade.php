@extends('design-system::layout')

@section('title', 'Copy Markup Preline UI')
@section('page-title', 'Copy Markup Components')
@section('page-description', 'Componentes de copy markup basados exactamente en Preline UI')

@section('content')

{{-- SECTION: Basic Usage --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Basic Usage
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">A basic usage of copy markup with a base input.</p>
    
    <x-copy-markup-basic 
        input-id="content-copy"
        wrapper-id="wrapper-copy"
        limit="3"
        button-text="Agregar Nombre"
        placeholder="Ingresa nombre"
    />
</div>

{{-- SECTION: Predefined Markup --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Predefined Markup
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">A predefined markup that hidden by default, and only copies after "add" button was clicked.</p>
    
    <x-copy-markup-predefined 
        template-id="predefined-template"
        wrapper-id="predefined-wrapper"
        limit="3"
        button-text="Agregar Nombre"
    >
        <input 
            type="text" 
            class="py-2.5 sm:py-3 px-4 block w-full border border-gray-400 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" 
            placeholder="Ingresa nombre"
        >
    </x-copy-markup-predefined>
</div>

@endsection















