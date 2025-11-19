@extends('design-system::layout')

@section('title', 'Modal Preline UI')
@section('page-title', 'Modal Components')
@section('page-description', 'Componentes de modal basados exactamente en Preline UI con overlay desenfocado')

@section('content')

{{-- SECTION: Example (Basic) --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Example
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">The default form of a modal dialog.</p>
    
    <x-modal-basic modalId="basic-modal" title="Título del Modal" content="Este es un contenido más amplio con texto de apoyo como introducción natural a contenido adicional.">
        <button 
            type="button" 
            class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
        >
            Abrir modal
        </button>
    </x-modal-basic>
</div>

{{-- SECTION: Scale Animation --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Scale Animation
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Experience the classic modal dialog with an engaging scale animation effect.</p>
    
    <x-modal-scale modalId="scale-modal" title="Título del Modal" content="Este es un contenido más amplio con texto de apoyo como introducción natural a contenido adicional.">
        <button 
            type="button" 
            class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
        >
            Abrir modal
        </button>
    </x-modal-scale>
</div>

{{-- SECTION: Slide Down Animation --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Slide Down Animation
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">The default form of a modal dialog with slide down animation.</p>
    
    <x-modal-slide-down modalId="slide-modal" title="Título del Modal" content="Este es un contenido más amplio con texto de apoyo como introducción natural a contenido adicional.">
        <button 
            type="button" 
            class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
        >
            Abrir modal
        </button>
    </x-modal-slide-down>
</div>

{{-- SECTION: Static Backdrop --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Static Backdrop
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">When backdrop is set to static, the modal will not close when clicking outside it. Click the button below to try it.</p>
    
    <x-modal-static-backdrop modalId="static-modal" title="Título del Modal" content="Este es un contenido más amplio con texto de apoyo como introducción natural a contenido adicional.">
        <button 
            type="button" 
            class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
        >
            Abrir modal
        </button>
    </x-modal-static-backdrop>
</div>

@endsection

