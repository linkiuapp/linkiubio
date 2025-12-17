@extends('frontend.layouts.app')

@section('content')
<div class="p-4 space-y-6">
    <!-- Header con breadcrumbs -->
    <div class="space-y-3">
        <!-- Breadcrumbs -->
        <nav class="flex text-caption font-medium text-info-300">
            <a href="{{ route('tenant.home', $store->slug) }}" class="hover:text-info-200 transition-colors">Inicio</a>
            <span class="mx-2">/</span>
            <span class="text-secondary-300 font-medium">Categorías</span>
        </nav>
        
        <!-- Title -->
        <div class="space-y-2">
            <h2 class="text-body-regular font-bold text-black-300">Categorías</h2>
            <p class="text-caption font-regular text-black-200">Explora nuestras categorías de productos</p>
        </div>
    </div>

    @if($categories->count() > 0)
        @php
            // Calcular el color de fondo de las categorías una sola vez
            $bgColor = $store->design && $store->design->header_background_color ? $store->design->header_background_color : '#f9fafb';
            // Convertir hex a rgba con opacidad
            if (strpos($bgColor, '#') === 0) {
                $hex = str_replace('#', '', $bgColor);
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
                $categoryBgColor = "rgba($r, $g, $b, 0.1)";
            } else {
                $categoryBgColor = $bgColor;
            }
        @endphp
        <!-- Grid de categorías -->
        <div class="grid grid-cols-4 gap-2">
            @foreach($categories as $category)
                <a href="{{ route('tenant.category', ['store' => $store->slug, 'categorySlug' => $category->slug]) }}" 
                   class="flex flex-col items-center group">
                    
                    <!-- Icono de la categoría con fondo colorido -->
                    <div class="w-72px h-72px mb-2 p-2 flex items-center justify-center rounded-2xl transition-all duration-200 hover:opacity-80" 
                         style="background-color: {{ $categoryBgColor }};">
                         @if($category->icon && $category->icon->image_url)
                             <img src="{{ $category->icon->image_url }}" 
                                  alt="{{ $category->name }}" 
                                  class="w-56px h-56px object-contain aspect-square"
                                  style="aspect-ratio: 1 / 1;">
                         @else
                             <i data-lucide="image" class="w-56px h-56px text-brandNeutral-400 group-hover:text-brandPrimary-300"></i>
                         @endif
                    </div>
                    
                    <!-- Nombre de la categoría -->
                    <span class="text-xs font-normal text-slate-900 transition-colors leading-tight text-center">
                        {{ $category->name }}
                    </span>
                </a>
            @endforeach
        </div>
    @else
        <!-- Estado vacío -->
        <div class="text-center py-12 space-y-4">
            <div class="w-16 h-16 bg-accent-100 rounded-full flex items-center justify-center mx-auto">
                <x-lucide-package class="w-8 h-8 text-black-300" />
            </div>
            <div class="space-y-2">
                <h3 class="text-h7 font-bold text-black-300">No hay categorías disponibles</h3>
                <p class="text-body-small font-regular text-black-200 max-w-sm mx-auto">
                    Por el momento no tenemos categorías configuradas. 
                    ¡Regresa pronto para ver nuestros productos!
                </p>
            </div>
            <a href="{{ route('tenant.home', $store->slug) }}" 
               class="inline-flex items-center px-4 py-2 bg-primary-300 text-accent-50 rounded-lg hover:bg-primary-200 transition-colors">
                <x-lucide-home class="w-4 h-4 mr-2" />
                Ir al inicio
            </a>
        </div>
    @endif
</div>
@endsection 