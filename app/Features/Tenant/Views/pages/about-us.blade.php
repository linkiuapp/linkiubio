@extends('frontend.layouts.app')

@section('content')
<div class="p-4 space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex text-small font-regular text-info-300">
        <a href="{{ route('tenant.home', $store->slug) }}" class="hover:text-info-200 transition-colors">Inicio</a>
        <span class="mx-2">/</span>
        <span class="text-secondary-300 font-medium">Acerca de Nosotros</span>
    </nav>

    <!-- Header -->
    <div class="space-y-2">
        <h1 class="text-body-large font-bold text-black-400">Acerca de Nosotros</h1>
        <p class="text-caption text-black-300">Conoce nuestra historia</p>
    </div>

    <!-- Contenido -->
    <div class="bg-accent-50 rounded-xl p-6 border border-accent-200">
        <h2 class="text-body-large font-bold text-black-400 mb-4 flex items-center">
            <x-solar-users-group-two-rounded-outline class="w-6 h-6 text-secondary-300 mr-2" />
            Nuestra Historia
        </h2>
        
        @php
            $policies = $store->policies;
        @endphp
        
        @if(!empty($policies->about_us))
            <div class="text-black-300 break-words word-wrap" style="word-wrap: break-word; overflow-wrap: break-word; hyphens: auto;">
                {!! nl2br(e($policies->about_us)) !!}
            </div>
        @else
            <div class="bg-info-50 border border-info-200 rounded-lg p-6">
                <div class="text-center space-y-3">
                    <x-solar-book-bookmark-outline class="w-16 h-16 text-info-300 mx-auto" />
                    <p class="text-body-regular text-info-300 font-medium">
                        Esta tienda no ha compartido su historia aún
                    </p>
                    <p class="text-body-small text-black-300">
                        Vuelve pronto para conocer más sobre este negocio
                    </p>
                </div>
            </div>
        @endif
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

