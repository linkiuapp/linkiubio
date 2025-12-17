@extends('frontend.layouts.app')

@section('content')
<div class="px-4 py-6 space-y-6">


    <!-- Ticker de Promociones -->
    @if($tickers && $tickers->count() > 0 && $tickerConfig)
        @php
            $scrollSpeeds = [
                'slow' => 20,
                'medium' => 15,
                'fast' => 10
            ];
            $scrollDuration = $scrollSpeeds[$tickerConfig['scroll_speed']] ?? 15;
        @endphp
        <div class="ticker-wrapper" 
             style="background-color: {{ $tickerConfig['background_color'] }}; color: {{ $tickerConfig['text_color'] }};">
            <div class="ticker-container">
                <div class="flex items-center gap-2 py-3 px-4 whitespace-nowrap ticker-scroll" 
                     data-duration="{{ $scrollDuration }}">
                    @foreach($tickers as $ticker)
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="text-base font-semibold">{{ $ticker->text }}</span>
                            <span class="mx-2 text-base font-medium">•</span>
                        </div>
                    @endforeach
                    {{-- Duplicar para efecto continuo --}}
                    @foreach($tickers as $ticker)
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="text-base font-semibold">{{ $ticker->text }}</span>
                            <span class="mx-2 text-base font-medium">•</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Slider de Novedades -->
    @if($sliders->count() > 0)
        <div class="slider-container relative" 
             x-data="sliderComponent({{ $sliders->toJson() }}, {{ $sliders->first()->transition_duration ?? 5 }})"
             x-init="init()"
             @pageshow.window="init()">
            <!-- Slider principal -->
            <div class="overflow-hidden rounded-lg">
                <div class="flex gap-2 sm:gap-4" 
                     x-bind:style="transformStyle"
                     @transitionend="handleTransitionEnd()">
                    
                    <!-- Slides originales -->
                    @foreach($sliders as $index => $slider)
                        <div class="flex-shrink-0 relative flex justify-center w-full sm:w-auto">
                            @if($slider->url && $slider->url_type !== 'none')
                                @if($slider->url_type === 'external')
                                    <a href="{{ $slider->url }}" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       class="block relative group w-full">
                                @else
                                    <a href="{{ $slider->url_type === 'internal' ? url($store->slug . '/' . ltrim($slider->url, '/')) : '#' }}" 
                                       class="block relative group w-full">
                                @endif
                            @else
                                <div class="block relative group w-full">
                            @endif
                            
                            <!-- Imagen del slider - Responsive -->
                            <div class="w-full sm:w-[420px] h-[180px] sm:h-[200px] bg-accent-100 rounded-lg overflow-hidden relative">
                                @if($slider->image_url)
                                    <img src="{{ $slider->image_url }}" 
                                         alt="{{ $slider->name }}" 
                                         loading="lazy"
                                         class="w-full h-full object-cover object-center transition-transform duration-300 group-hover:scale-105"
                                         style="image-rendering: auto; -webkit-backface-visibility: hidden; backface-visibility: hidden;">
                                @endif
                                
                                <!-- Overlay suave (solo si tiene enlace) -->
                                @if($slider->url && $slider->url_type !== 'none')
                                    <div class="absolute inset-0 bg-gradient-to-t from-black-500/20 via-transparent to-transparent"></div>
                                @endif
                                
                                <!-- Indicador de enlace -->
                                @if($slider->url && $slider->url_type !== 'none')
                                    <div class="absolute top-1 right-1 bg-accent-50/20 backdrop-blur-sm rounded-full p-0.5 opacity-70 group-hover:opacity-100 transition-opacity">
                                        <i data-lucide="arrow-up-right" class="w-24px h-24px sm:w-32px sm:h-32px"></i>
                                    </div>
                                @endif
                            </div>
                            
                            @if($slider->url && $slider->url_type !== 'none')
                                </a>
                            @else
                                </div>
                            @endif
                        </div>
                    @endforeach
                    
                    @if($sliders->count() > 1)
                        <!-- Duplicar primer slide al final para efecto infinito -->
                        @php $firstSlider = $sliders->first(); @endphp
                        <div class="flex-shrink-0 relative flex justify-center w-full sm:w-auto">
                            @if($firstSlider->url && $firstSlider->url_type !== 'none')
                                @if($firstSlider->url_type === 'external')
                                    <a href="{{ $firstSlider->url }}" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       class="block relative group w-full">
                                @else
                                    <a href="{{ $firstSlider->url_type === 'internal' ? url($store->slug . '/' . ltrim($firstSlider->url, '/')) : '#' }}" 
                                       class="block relative group w-full">
                                @endif
                            @else
                                <div class="block relative group w-full">
                            @endif
                            
                            <!-- Imagen del slider - Responsive -->
                            <div class="w-full sm:w-[420px] h-[180px] sm:h-[200px] bg-accent-100 rounded-lg overflow-hidden relative">
                                @if($firstSlider->image_url)
                                    <img src="{{ $firstSlider->image_url }}" 
                                         alt="{{ $firstSlider->name }}" 
                                         loading="lazy"
                                         class="w-full h-full object-cover object-center transition-transform duration-300 group-hover:scale-105"
                                         style="image-rendering: auto; -webkit-backface-visibility: hidden; backface-visibility: hidden;">
                                @endif
                                
                                @if($firstSlider->url && $firstSlider->url_type !== 'none')
                                    <div class="absolute inset-0 bg-gradient-to-t from-black-500/20 via-transparent to-transparent"></div>
                                @endif
                                
                                @if($firstSlider->url && $firstSlider->url_type !== 'none')
                                    <div class="absolute top-1 right-1 bg-accent-50/20 backdrop-blur-sm rounded-full p-0.5 opacity-70 group-hover:opacity-100 transition-opacity">
                                        <i data-lucide="arrow-up-right" class="w-24px h-24px sm:w-32px sm:h-32px"></i>
                                    </div>
                                @endif
                            </div>
                            
                            @if($firstSlider->url && $firstSlider->url_type !== 'none')
                                </a>
                            @else
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Indicadores (dots) - Solo si hay más de 1 slide -->
            @if($sliders->count() > 1)
                <div class="flex justify-center mt-4 space-x-2">
                    @foreach($sliders as $index => $slider)
                        <button @click="goToSlide({{ $index }})"
                                class="w-2 h-2 rounded-full transition-all duration-300"
                                :class="displaySlide === {{ $index }} ? 'bg-primary-300 w-6' : 'bg-accent-300 hover:bg-accent-400'">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    <!-- Categorías -->
    <div class="space-y-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-slate-900">Categorías</h3>
            <a href="{{ route('tenant.categories', $store->slug) }}" 
               class="flex items-center gap-1 text-blue-700 hover:text-blue-800 transition-colors">
                <span class="text-base font-medium">Ver más</span>
                <i data-lucide="arrow-up-right" class="w-4 h-4 text-blue-700"></i>
            </a>
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
                        <span class="text-xs font-normal text-slate-900 transition-colors leading-tight">
                            {{ $category->name }}
                        </span>
                    </a>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-8">
                <img src="https://cdn.jsdelivr.net/gh/linkiuapp/medialink@main/Assets_Fronted/img_linkiu_v1_gallery.svg" alt="img_linkiu_v1_gallery" class="h-32 w-auto" loading="lazy">
                <p class="body-lg-bold text-center text-brandNeutral-400">No hay categorías disponibles</p>
                <a href="{{ route('tenant.categories', $store->slug) }}" 
                   class="gap-2 inline-flex mt-3 px-4 py-2 bg-brandPrimary-300 text-brandWhite-100 rounded-lg text-body-lg-medium hover:bg-brandPrimary-400 transition-colors">
                    Ver todas las categorías
                    <i data-lucide="arrow-up-right" class="w-24px h-24px sm:w-32px sm:h-32px"></i>
                </a>
            </div>
        @endif
    </div>

    <!-- Top 3 más vendidos -->
    <div class="space-y-6">
        <h3 class="text-base font-semibold text-slate-900">Top 3 más vendidos</h3>
        
        @if($topProducts->count() > 0)
            @php
                // Calcular el color de fondo de las cards una sola vez
                $bgColor = $store->design && $store->design->header_background_color ? $store->design->header_background_color : '#f9fafb';
                // Convertir hex a rgba con opacidad
                if (strpos($bgColor, '#') === 0) {
                    $hex = str_replace('#', '', $bgColor);
                    $r = hexdec(substr($hex, 0, 2));
                    $g = hexdec(substr($hex, 2, 2));
                    $b = hexdec(substr($hex, 4, 2));
                    $cardBgColor = "rgba($r, $g, $b, 0.1)";
                } else {
                    $cardBgColor = $bgColor;
                }
            @endphp
            <div class="space-y-4">
                @foreach($topProducts as $product)
                    @php
                        $estaAgotado = $product->controlaStock() && !$product->tieneStockIlimitado() && $product->estaAgotado();
                        $tieneStockBajo = $product->controlaStock() && !$product->tieneStockIlimitado() && $product->tieneStockBajo();
                        $stockDisponible = $product->stock_disponible ?? 0;
                    @endphp
                    <div class="flex gap-2 md:gap-4 rounded-xl p-4 md:p-4 transition-all duration-200 hover:shadow-sm relative cursor-pointer" 
                         style="background-color: {{ $cardBgColor }};">
                        <div class="flex items-center gap-4">
                            <!-- Imagen del producto -->
                            <div class="w-[120px] h-[120px] md:w-[126px] md:h-[126px] rounded-lg flex-shrink-0 overflow-hidden">
                                @if($product->main_image_url)
                                    <img src="{{ $product->main_image_url }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                        <i data-lucide="image" class="w-6 h-6 text-gray-400"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Información del producto -->
                            <div class="flex-1 min-w-0 flex flex-col md:gap-1 gap-0">
                                <div class="flex items-center gap-1.5 w-fit md:mb-0 mb-1">
                                    <div class="w-6 h-6 bg-slate-200 rounded-full flex items-center justify-center">
                                        <span class="text-base font-bold">
                                            🔥
                                        </span>
                                    </div>
                                    <!-- Badge de Stock bajo -->
                                    @if($tieneStockBajo && $stockDisponible > 0)
                                        <div class="flex items-center gap-1.5 w-fit md:mb-0 mb-1">
                                            <span class="bg-red-50 text-red-600 rounded-full px-2 py-1 text-xs font-semibold text-red-600">
                                                Queda {{ $stockDisponible }} unidad{{ $stockDisponible > 1 ? 'es' : '' }}
                                            </span>
                                        </div>
                                    @elseif($estaAgotado)
                                        <div class="flex items-center gap-1.5 w-fit">
                                            <span class="text-xs font-medium text-white bg-red-500 px-2 py-0.5 rounded-full">
                                                Agotado
                                            </span>
                                        </div>
                                    @endif
                                    @if($product->categories->count() > 0)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($product->categories->take(1) as $category)
                                                <span class="px-2 py-1 text-xs font-semibold text-green-900 bg-green-50 rounded-full">
                                                    {{ $category->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <!-- Título del producto -->
                                <h3 class="text-base font-bold text-slate-900 leading-tight">{{ $product->name }}</h3>
                                
                                <!-- Descripción -->
                                @if($product->description)
                                    <p class="text-xs font-normal text-slate-900 leading-tight line-clamp-1">{{ $product->description }}</p>
                                @endif

                                <!-- Precios -->
                                <div class="flex items-center gap-2">
                                    @if($product->tienePromocionActiva())
                                        <span class="text-base font-normal text-slate-900 line-through">${{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span class="text-base font-bold text-slate-900">${{ number_format($product->precio_promocional, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-base font-bold text-slate-900">${{ number_format($product->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>

                                <!-- Botones de acción -->
                                <div class="flex gap-2 items-center md:mt-0 mt-2">
                                    <x-add-to-cart-button :product="$product" :store="$store" />
                                    @if(featureEnabled($store, 'favoritos'))
                                    <button class="p-3 flex items-center justify-center transition-transform bg-red-50 hover:bg-red-100 rounded-full hover:scale-110" 
                                            data-favorite-btn
                                            data-product-id="{{ $product->id }}">
                                        <i data-lucide="heart" class="w-6 h-6 text-red-500 hover:text-red-600" style="fill: currentColor;"></i>
                                    </button>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
        <div class="flex flex-col items-center justify-center">
            <img src="https://cdn.jsdelivr.net/gh/linkiuapp/medialink@main/Assets_Fronted/img_linkiu_v1_ghost.svg" alt="img_linkiu_v1_ghost" class="h-32 w-auto" loading="lazy">
            <p class="body-lg-bold text-center text-brandNeutral-400">No hay productos disponibles</p>
        </div>
        @endif
    </div>

    <!-- Lo más nuevo -->
    <div class="space-y-6">
        <h3 class="text-base font-semibold text-slate-900">Lo más nuevo</h3>
        
        @if($newProducts->count() > 0)
            @php
                // Calcular el color de fondo de las cards una sola vez
                $bgColor = $store->design && $store->design->header_background_color ? $store->design->header_background_color : '#f9fafb';
                // Convertir hex a rgba con opacidad
                if (strpos($bgColor, '#') === 0) {
                    $hex = str_replace('#', '', $bgColor);
                    $r = hexdec(substr($hex, 0, 2));
                    $g = hexdec(substr($hex, 2, 2));
                    $b = hexdec(substr($hex, 4, 2));
                    $cardBgColor = "rgba($r, $g, $b, 0.1)";
                } else {
                    $cardBgColor = $bgColor;
                }
            @endphp
            <div class="space-y-4">
                @foreach($newProducts as $product)
                    @php
                        $estaAgotado = $product->controlaStock() && !$product->tieneStockIlimitado() && $product->estaAgotado();
                        $tieneStockBajo = $product->controlaStock() && !$product->tieneStockIlimitado() && $product->tieneStockBajo();
                        $stockDisponible = $product->stock_disponible ?? 0;
                    @endphp
                    <div class="flex gap-2 md:gap-4 rounded-xl p-4 md:p-4 transition-all duration-200 hover:shadow-sm relative" 
                         style="background-color: {{ $cardBgColor }};">
                        <div class="flex items-center gap-4">
                            <!-- Imagen del producto -->
                            <div class="w-[120px] h-[120px] md:w-[126px] md:h-[126px] rounded-lg flex-shrink-0 overflow-hidden">
                                @if($product->main_image_url)
                                    <img src="{{ $product->main_image_url }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                        <i data-lucide="image" class="w-6 h-6 text-gray-400"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Información del producto -->
                            <div class="flex-1 min-w-0 flex flex-col md:gap-1 gap-0">
                                <div class="flex items-center gap-1.5 w-fit md:mb-0 mb-1">
                                        <div class="w-6 h-6 bg-slate-200 rounded-full flex items-center justify-center">
                                            <span class="text-base font-bold">
                                                ✨
                                            </span>
                                        </div>
                                        <!-- Badge de Stock bajo -->
                                        @if($tieneStockBajo && $stockDisponible > 0)
                                            <div class="flex items-center gap-1.5 w-fit md:mb-0 mb-1">
                                                <span class="bg-red-50 text-red-600 rounded-full px-2 py-1 text-xs font-semibold text-red-600">
                                                    Queda {{ $stockDisponible }} unidad{{ $stockDisponible > 1 ? 'es' : '' }}
                                                </span>
                                            </div>
                                        @elseif($estaAgotado)
                                            <div class="flex items-center gap-1.5 w-fit">
                                                <span class="text-xs font-medium text-white bg-red-500 px-2 py-0.5 rounded-full">
                                                    Agotado
                                                </span>
                                            </div>
                                        @endif
                                        @if($product->categories->count() > 0)
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($product->categories->take(1) as $category)
                                                    <span class="px-2 py-1 text-xs font-semibold text-green-900 bg-green-50 rounded-full">
                                                        {{ $category->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Título del producto -->
                                    <h3 class="text-base font-bold text-slate-900 leading-tight">{{ $product->name }}</h3>
                                    
                                    <!-- Descripción -->
                                    @if($product->description)
                                        <p class="text-xs font-normal text-slate-900 leading-tight line-clamp-1">{{ $product->description }}</p>
                                    @endif

                                    <!-- Precios -->
                                    <div class="flex items-center gap-2">
                                        @if($product->tienePromocionActiva())
                                            <span class="text-base font-normal text-slate-900 line-through">${{ number_format($product->price, 0, ',', '.') }}</span>
                                            <span class="text-base font-bold text-slate-900">${{ number_format($product->precio_promocional, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-base font-bold text-slate-900">${{ number_format($product->price, 0, ',', '.') }}</span>
                                        @endif
                                    </div>

                                    <!-- Botones de acción -->
                                    <div class="flex gap-2 items-center md:mt-0 mt-2">
                                        <x-add-to-cart-button :product="$product" :store="$store" />
                                        @if(featureEnabled($store, 'favoritos'))
                                        <button class="p-3 flex items-center justify-center transition-transform bg-red-50 hover:bg-red-100 rounded-full hover:scale-110" 
                                                data-favorite-btn
                                                data-product-id="{{ $product->id }}">
                                            <i data-lucide="heart" class="w-6 h-6 text-red-500 hover:text-red-600" style="fill: currentColor;"></i>
                                        </button>
                                    @endif
                                    </div>
                                </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
        <div class="flex flex-col items-center justify-center">
            <img src="https://cdn.jsdelivr.net/gh/linkiuapp/medialink@main/Assets_Fronted/img_linkiu_v1_ghost.svg" alt="img_linkiu_v1_ghost" class="h-32 w-auto" loading="lazy">
            <p class="body-lg-bold text-center text-brandNeutral-400">No hay productos nuevos disponibles</p>
        </div>
        @endif
    </div>
</div>
@push('styles')
<style>
    .ticker-wrapper {
        margin-bottom: 24px;
    }
    .ticker-container {
        overflow: hidden;
        width: 100%;
    }
    /* Asegurar que los margins se apliquen correctamente */
    .ticker-container {
        margin: inherit;
    }
    .ticker-scroll {
        display: inline-flex;
        white-space: nowrap;
        will-change: transform;
        animation: ticker-move linear infinite;
        width: max-content;
        box-sizing: content-box;
    }
    .ticker-scroll[data-duration="10"] {
        animation-duration: 10s;
    }
    .ticker-scroll[data-duration="15"] {
        animation-duration: 15s;
    }
    .ticker-scroll[data-duration="20"] {
        animation-duration: 20s;
    }
    @keyframes ticker-move {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-50%);
        }
    }
</style>
@endpush

@push('scripts')
<script>
window.sliderComponent = function(sliders, duration = 5) {
    return {
        currentSlide: 0,
        sliders: sliders,
        duration: duration * 1000,
        autoPlayInterval: null,
        isPlaying: true,
        maxSlide: 0,
        isMobile: false,
        isTransitioning: false,
        displaySlide: 0,
        transformStyle: '',

        init() {
            this.stopAutoPlay();
            
            this.currentSlide = 0;
            this.displaySlide = 0;
            this.isTransitioning = false;
            this.isPlaying = true;
            this.checkViewport();
            this.updateTransform();

            this.$nextTick(() => {
                if (this.sliders.length > 1) {
                    this.startAutoPlay();
                }
            });
            
            // Escuchar cambios de tamaño de ventana
            window.addEventListener('resize', () => {
                const wasMobile = this.isMobile;
                this.checkViewport();
                
                if (wasMobile !== this.isMobile) {
                    this.currentSlide = 0;
                    this.displaySlide = 0;
                    this.updateTransform();
                }
            });
        },
        
        updateTransform() {
            this.transformStyle = this.getTransform();
        },
        
        checkViewport() {
            this.isMobile = window.innerWidth < 640;
        },
        
        getTransform() {
            if (typeof window === 'undefined') return 'transform: translateX(0px)';
            
            const isMobile = window.innerWidth < 640;
            const slideWidth = isMobile ? window.innerWidth - 32 : 420;
            const gap = isMobile ? 8 : 16;
            const totalWidth = slideWidth + gap;
            const translateX = this.currentSlide * totalWidth;
            const transition = this.isTransitioning ? 'transition: transform 0.5s ease-in-out;' : '';
            
            return `${transition} transform: translateX(-${translateX}px)`;
        },
        
        goToSlide(index) {
            this.isTransitioning = true;
            this.currentSlide = index;
            this.displaySlide = index;
            this.updateTransform();
            this.resetAutoPlay();
        },
        
        nextSlide() {
            this.isTransitioning = true;
            this.currentSlide = (this.currentSlide + 1) % this.sliders.length;
            this.displaySlide = this.currentSlide;
            this.updateTransform();
            this.resetAutoPlay();
        },
        
        handleTransitionEnd() {
            this.isTransitioning = false;
        },
        
        prevSlide() {
            if (this.sliders.length <= 1) return;
            
            this.isTransitioning = true;
            this.currentSlide = (this.currentSlide - 1 + this.sliders.length) % this.sliders.length;
            this.displaySlide = this.currentSlide;
            this.updateTransform();
            this.resetAutoPlay();
        },
        
        startAutoPlay() {
            if (this.sliders.length <= 1) return;
            
            this.autoPlayInterval = setInterval(() => {
                if (this.isPlaying) {
                    this.nextSlide();
                }
            }, this.duration);
        },
        
        stopAutoPlay() {
            if (this.autoPlayInterval) {
                clearInterval(this.autoPlayInterval);
                this.autoPlayInterval = null;
            }
        },
        
        resetAutoPlay() {
            this.stopAutoPlay();
            this.startAutoPlay();
        },
        
        pauseAutoPlay() {
            this.isPlaying = false;
        },
        
        resumeAutoPlay() {
            this.isPlaying = true;
        }
    }
}


// Pausar auto-play cuando el usuario interactúa
document.addEventListener('DOMContentLoaded', function() {
    const sliderContainer = document.querySelector('.slider-container');
    
    if (sliderContainer) {
        sliderContainer.addEventListener('mouseenter', function() {
            const component = Alpine.$data(this);
            if (component && component.pauseAutoPlay) {
                component.pauseAutoPlay();
            }
        });
        
        sliderContainer.addEventListener('mouseleave', function() {
            const component = Alpine.$data(this);
            if (component && component.resumeAutoPlay) {
                component.resumeAutoPlay();
            }
        });
    }
});
</script>
@endpush

@endsection 