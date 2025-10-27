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
        <h1 class="text-h6 font-bold text-black-400">Acerca de Nosotros</h1>
        <p class="text-body-small text-black-300">Conoce nuestra historia</p>
    </div>

    <!-- Contenido -->
    <div class="bg-accent-50 rounded-xl p-6 border border-accent-200">
        <h2 class="text-body-large font-bold text-black-400 mb-4 flex items-center">
            <x-solar-users-group-two-rounded-outline class="w-6 h-6 text-secondary-300 mr-2" />
            Nuestra Historia
        </h2>
        
        @if(!empty($store->our_history))
            <div class="prose prose-sm max-w-none text-black-300 space-y-4">
                {!! nl2br(e($store->our_history)) !!}
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

    <!-- Info adicional -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @if($store->email)
            <div class="bg-accent-50 rounded-lg p-4 border border-accent-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-info-100 rounded-full flex items-center justify-center">
                        <x-solar-letter-outline class="w-5 h-5 text-info-300" />
                    </div>
                    <div>
                        <p class="text-caption text-black-300 font-medium">Email</p>
                        <a href="mailto:{{ $store->email }}" class="text-body-small text-info-300 hover:underline">
                            {{ $store->email }}
                        </a>
                    </div>
                </div>
            </div>
        @endif

        @if($store->phone)
            <div class="bg-accent-50 rounded-lg p-4 border border-accent-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-success-100 rounded-full flex items-center justify-center">
                        <x-solar-phone-outline class="w-5 h-5 text-success-300" />
                    </div>
                    <div>
                        <p class="text-caption text-black-300 font-medium">Teléfono</p>
                        <a href="tel:{{ $store->phone }}" class="text-body-small text-success-300 hover:underline">
                            {{ $store->phone }}
                        </a>
                    </div>
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

