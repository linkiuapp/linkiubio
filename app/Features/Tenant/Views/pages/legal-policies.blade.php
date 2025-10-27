@extends('frontend.layouts.app')

@section('content')
<div class="p-4 space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex text-small font-regular text-info-300">
        <a href="{{ route('tenant.home', $store->slug) }}" class="hover:text-info-200 transition-colors">Inicio</a>
        <span class="mx-2">/</span>
        <span class="text-secondary-300 font-medium">Políticas Legales</span>
    </nav>

    <!-- Header -->
    <div class="space-y-2">
        <h1 class="text-h6 font-bold text-black-400">Políticas Legales</h1>
        <p class="text-body-small text-black-300">Conoce nuestras políticas y términos</p>
    </div>

    <!-- Contenido -->
    <div class="space-y-6">
        @php
            $sections = [
                ['title' => 'Política de Privacidad', 'key' => 'privacy_policy'],
                ['title' => 'Términos y Condiciones', 'key' => 'terms_conditions'],
                ['title' => 'Política de Envíos', 'key' => 'shipping_policy'],
                ['title' => 'Política de Devoluciones', 'key' => 'return_policy'],
            ];
        @endphp

        @foreach($sections as $section)
            <div class="bg-accent-50 rounded-xl p-6 border border-accent-200">
                <h2 class="text-body-large font-bold text-black-400 mb-4 flex items-center">
                    <x-solar-document-text-outline class="w-6 h-6 text-secondary-300 mr-2" />
                    {{ $section['title'] }}
                </h2>
                
                @if(!empty($store->{$section['key']}))
                    <div class="prose prose-sm max-w-none text-black-300">
                        {!! nl2br(e($store->{$section['key']})) !!}
                    </div>
                @else
                    <div class="bg-info-50 border border-info-200 rounded-lg p-4">
                        <p class="text-body-small text-info-300 flex items-center">
                            <x-solar-info-circle-outline class="w-5 h-5 mr-2" />
                            Esta tienda no ha configurado su {{ strtolower($section['title']) }} aún.
                        </p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Botón de regreso -->
    <div class="flex justify-center pt-6">
        <a href="{{ route('tenant.home', $store->slug) }}" 
           class="btn-secondary flex items-center gap-2 px-6 py-3 rounded-lg">
            <x-solar-arrow-left-outline class="w-5 h-5" />
            Volver al inicio
        </a>
    </div>
</div>
@endsection

