@extends('design-system::layout')

@section('title', 'Clipboard Preline UI')
@section('page-title', 'Clipboard Components')
@section('page-description', 'Componentes para copiar texto al portapapeles basados en Preline UI')

@section('content')

{{-- SECTION: Basic Usage --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Basic Usage
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Uso básico de Clipboard con texto visible.</p>
    
    <div class="space-y-6">
        <x-clipboard-basic text="npm install preline" />
        
        <x-clipboard-basic text="git clone https://github.com/example/repo.git" />
        
        <x-clipboard-basic text="composer require package/name" successText="¡Copiado!" />
    </div>
</div>

{{-- SECTION: Tooltip Examples --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Tooltip Examples
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Ejemplo con tooltip que muestra el mensaje de éxito.</p>
    
    <div class="space-y-6">
        <x-clipboard-tooltip 
            text="npm install preline" 
            buttonText="$ npm i preline" 
        />
        
        <x-clipboard-tooltip 
            text="git clone https://github.com/example/repo.git" 
            buttonText="$ git clone https://github.com/example/repo.git" 
        />
        
        <x-clipboard-tooltip 
            text="composer require package/name" 
            buttonText="$ composer require package/name" 
            successText="¡Copiado!"
        />
    </div>
</div>

@endsection















