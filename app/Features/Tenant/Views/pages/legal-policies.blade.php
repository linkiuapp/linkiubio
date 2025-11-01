@extends('frontend.layouts.app')

@section('content')
<div class="p-4 space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex caption text-brandPrimary-300">
        <a href="{{ route('tenant.home', $store->slug) }}" class="hover:text-brandPrimary-400 transition-colors">Inicio</a>
        <span class="mx-2">/</span>
        <span class="caption text-brandNeutral-400">Políticas Legales</span>
    </nav>

    <!-- Header -->
    <div class="space-y-2">
        <h1 class="h3 text-brandNeutral-400">Políticas Legales</h1>
        <p class="caption text-brandNeutral-300">Conoce nuestras políticas y términos</p>
    </div>

    <!-- Contenido -->
    <div class="space-y-6">
        @php
            // Obtener políticas desde la relación policies
            $policies = $store->policies;
            
            $sections = [
                ['title' => 'Política de Privacidad', 'key' => 'privacy_policy'],
                ['title' => 'Términos y Condiciones', 'key' => 'terms_conditions'],
                ['title' => 'Política de Envíos', 'key' => 'shipping_policy'],
                ['title' => 'Política de Devoluciones', 'key' => 'return_policy'],
            ];
        @endphp

        @foreach($sections as $section)
            <div class="bg-brandPrimary-50 rounded-xl p-6 border border-brandPrimary-300">
                <h2 class="body-lg-bold text-brandNeutral-400 mb-4 flex items-center">
                    <i data-lucide="file-text" class="w-6 h-6 text-brandPrimary-300 mr-2"></i>
                    {{ $section['title'] }}
                </h2>
                
                @if(!empty($policies->{$section['key']}))
                    <div class="text-brandNeutral-300 break-words word-wrap" style="word-wrap: break-word; overflow-wrap: break-word; hyphens: auto;">
                        {!! nl2br(e($policies->{$section['key']})) !!}
                    </div>
                @else
                    <div class="bg-brandInfo-50 border border-brandInfo-300 rounded-lg p-4">
                        <p class="caption text-brandInfo-300 flex items-center">
                            <i data-lucide="info" class="w-5 h-5 mr-2 text-brandInfo-300"></i>
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
           class="bg-brandSecondary-300 hover:bg-brandSecondary-400 text-brandWhite-50 px-6 py-3 rounded-lg body-lg-bold transition-colors flex items-center justify-center gap-2">
            <i data-lucide="arrow-left" class="w-5 h-5 text-brandWhite-50"></i>
            Volver al inicio
        </a>
    </div>
</div>
@endsection

