@extends('frontend.layouts.app')

@section('content')
<div class="px-4 py-6 space-y-6">
    <!-- Slider de Novedades -->
    @if($sliders->count() > 0)
        <div class="slider-container relative" x-data="sliderComponent({{ $sliders->toJson() }}, {{ $sliders->first()->transition_duration ?? 5 }})">
            <!-- Slider principal -->
            <div class="overflow-hidden rounded-lg">
                <div class="flex gap-2 sm:gap-3 transition-transform duration-500 ease-in-out" 
                     :style="getTransform()">
                    
                    @foreach($sliders as $index => $slider)
                        <div class="w-1/2 sm:w-1/3 flex-shrink-0 relative flex justify-center px-1">
                            @if($slider->url && $slider->url_type !== 'none')
                                @if($slider->url_type === 'external')
                                    <a href="{{ $slider->url }}" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       class="block relative group">
                                @else
                                    <a href="{{ $slider->url_type === 'internal' ? url($store->slug . '/' . ltrim($slider->url, '/')) : '#' }}" 
                                       class="block relative group">
                                @endif
                            @else
                                <div class="block relative group">
                            @endif
                            
                            <!-- Imagen del slider -->
                            <div class="w-full aspect-[17/10] max-w-full bg-accent-100 rounded-lg overflow-hidden relative">
                                @if($slider->image_url)
                                    <img src="{{ $slider->image_url }}" 
                                         alt="{{ $slider->name }}" 
                                         class="w-full h-full object-cover object-center transition-transform duration-300 group-hover:scale-105">
                                @endif
                                
                                <!-- Overlay suave (solo si tiene enlace) -->
                                @if($slider->url && $slider->url_type !== 'none')
                                    <div class="absolute inset-0 bg-gradient-to-t from-black-500/20 via-transparent to-transparent"></div>
                                @endif
                                
                                <!-- Indicador de enlace -->
                                @if($slider->url && $slider->url_type !== 'none')
                                    <div class="absolute top-1 right-1 bg-accent-50/20 backdrop-blur-sm rounded-full p-0.5 opacity-70 group-hover:opacity-100 transition-opacity">
                                        <x-solar-arrow-right-outline class="w-2 h-2 text-accent-50" />
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
                    
                    <!-- Duplicar slides para efecto infinito - duplicar según viewport -->
                    @if($sliders->count() > 1)
                        {{-- Duplicar 2 para móvil, 3 para desktop (tomamos 3 para cubrir ambos casos) --}}
                        @foreach($sliders->take(3) as $index => $slider)
                            <div class="w-1/2 sm:w-1/3 flex-shrink-0 relative flex justify-center px-1">
                                @if($slider->url && $slider->url_type !== 'none')
                                    @if($slider->url_type === 'external')
                                        <a href="{{ $slider->url }}" 
                                           target="_blank" 
                                           rel="noopener noreferrer"
                                           class="block relative group">
                                    @else
                                        <a href="{{ $slider->url_type === 'internal' ? url($store->slug . '/' . ltrim($slider->url, '/')) : '#' }}" 
                                           class="block relative group">
                                    @endif
                                @else
                                    <div class="block relative group">
                                @endif
                                
                                <!-- Imagen del slider -->
                                <div class="w-full aspect-[17/10] max-w-full bg-accent-100 rounded-lg overflow-hidden relative">
                                    @if($slider->image_url)
                                        <img src="{{ $slider->image_url }}" 
                                             alt="{{ $slider->name }}" 
                                             class="w-full h-full object-cover object-center transition-transform duration-300 group-hover:scale-105">
                                    @endif
                                    
                                    <!-- Overlay suave (solo si tiene enlace) -->
                                    @if($slider->url && $slider->url_type !== 'none')
                                        <div class="absolute inset-0 bg-gradient-to-t from-black-500/20 via-transparent to-transparent"></div>
                                    @endif
                                    
                                    <!-- Indicador de enlace -->
                                    @if($slider->url && $slider->url_type !== 'none')
                                        <div class="absolute top-1 right-1 bg-accent-50/20 backdrop-blur-sm rounded-full p-0.5 opacity-70 group-hover:opacity-100 transition-opacity">
                                            <x-solar-arrow-right-outline class="w-2 h-2 text-accent-50" />
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
                    @endif
                </div>
            </div>
            
            <!-- Indicadores (dots) - Solo si hay más de 1 slide -->
            @if($sliders->count() > 1)
                <div class="flex justify-center mt-4 space-x-2">
                    @foreach($sliders as $index => $slider)
                        <button @click="goToSlide({{ $index }})"
                                class="w-2 h-2 rounded-full transition-all duration-300"
                                :class="currentSlide === {{ $index }} ? 'bg-primary-300 w-6' : 'bg-accent-300 hover:bg-accent-400'">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    <!-- Categorías -->
    <div>
        <h2 class="text-lg font-bold text-black-400 mb-4">Categorías</h2>
        
        @if($categories->count() > 0)
            <div class="grid grid-cols-4 gap-3">
                @foreach($categories as $category)
                    <a href="{{ route('tenant.category', ['store' => $store->slug, 'categorySlug' => $category->slug]) }}" 
                       class="flex flex-col items-center group">
                        
                        <!-- Icono de la categoría con fondo colorido -->
                        <div class="w-16 h-16 mb-2 flex items-center justify-center rounded-2xl bg-gradient-to-br from-accent-100 to-accent-200 group-hover:from-primary-50 group-hover:to-primary-100 transition-all duration-200 shadow-sm group-hover:shadow-md">
                             @if($category->icon && $category->icon->image_url)
                                 <img src="{{ $category->icon->image_url }}" 
                                      alt="{{ $category->name }}" 
                                      class="w-10 h-10 object-contain">
                             @else
                                 <x-solar-gallery-outline class="w-8 h-8 text-black-300 group-hover:text-primary-300" />
                             @endif
                        </div>
                        
                        <!-- Nombre de la categoría -->
                        <span class="text-xs text-center text-black-400 font-medium group-hover:text-primary-300 transition-colors leading-tight">
                            {{ $category->name }}
                        </span>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-black-300">
                <x-solar-gallery-outline class="w-12 h-12 mx-auto mb-3 text-black-200" />
                <p class="text-sm">No hay categorías disponibles</p>
                <a href="{{ route('tenant.categories', $store->slug) }}" 
                   class="inline-flex items-center mt-3 px-4 py-2 bg-primary-300 text-accent-50 rounded-lg text-sm hover:bg-primary-200 transition-colors">
                    <x-solar-gallery-outline class="w-4 h-4 mr-2" />
                    Explorar
                </a>
            </div>
        @endif
    </div>

    <!-- Top 3 más vendidos -->
    <div>
        <h2 class="text-lg font-bold text-black-400 mb-4">Top 3 más vendidos</h2>
        
        @if($topProducts->count() > 0)
            <div class="space-y-3">
                @foreach($topProducts as $product)
                    <a href="{{ route('tenant.product', [$store->slug, $product->slug]) }}" 
                       class="bg-white rounded-lg p-3 border border-accent-200 hover:border-primary-200 hover:shadow-sm transition-all duration-200 block relative">
                        <!-- Badge MÁS VENDIDO -->
                        <div class="absolute -top-2 -left-2 bg-error-300 text-accent-50 text-xs px-2 py-1 rounded-full font-bold z-10 shadow-sm">
                            🔥 MÁS VENDIDO
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <!-- Imagen del producto -->
                            <div class="w-16 h-16 bg-accent-100 rounded-lg flex-shrink-0 overflow-hidden">
                                @if($product->main_image_url)
                                    <img src="{{ $product->main_image_url }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-black-200">
                                        <x-solar-gallery-outline class="w-6 h-6" />
                                    </div>
                                @endif
                            </div>

                            <!-- Información del producto -->
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-black-400 text-sm mb-1 line-clamp-1">{{ $product->name }}</h3>
                                
                                @if($product->description)
                                    <p class="text-xs text-black-300 mb-2 line-clamp-1">{{ $product->description }}</p>
                                @endif

                                <!-- Precio prominente -->
                                <div class="text-base font-bold text-primary-300 mb-1">
                                    ${{ number_format($product->price, 0, ',', '.') }}
                                </div>

                                <!-- Categorías pequeñas -->
                                @if($product->categories->count() > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($product->categories->take(2) as $category)
                                            <span class="px-2 py-0.5 bg-primary-50 text-primary-300 rounded text-xs">
                                                {{ $category->name }}
                                            </span>
                                        @endforeach
                                        @if($product->categories->count() > 2)
                                            <span class="text-xs text-black-200">+{{ $product->categories->count() - 2 }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Botón agregar al carrito -->
                            <div class="flex-shrink-0">
                                <button class="add-to-cart-btn bg-secondary-300 hover:bg-secondary-200 text-white w-11 h-11 rounded-lg flex items-center justify-center transition-colors" 
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->name }}"
                                        data-product-price="{{ $product->price }}"
                                        data-product-image="{{ $product->main_image_url }}"
                                        onclick="event.preventDefault(); event.stopPropagation();">
                                    <x-solar-cart-plus-outline class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-black-300">
                <x-solar-box-outline class="w-12 h-12 mx-auto mb-3 text-black-200" />
                <p class="text-sm">No hay productos disponibles</p>
            </div>
        @endif
    </div>

    <!-- Lo más nuevo -->
    <div>
        <h2 class="text-lg font-bold text-black-400 mb-4">Lo más nuevo</h2>
        
        @if($newProducts->count() > 0)
            <div class="space-y-3">
                @foreach($newProducts as $product)
                    <a href="{{ route('tenant.product', [$store->slug, $product->slug]) }}" 
                       class="bg-white rounded-lg p-3 border border-accent-200 hover:border-primary-200 hover:shadow-sm transition-all duration-200 block relative">
                        <!-- Badge NUEVO -->
                        <div class="absolute -top-2 -left-2 bg-success-300 text-accent-50 text-xs px-2 py-1 rounded-full font-bold z-10 shadow-sm">
                            ✨ NUEVO
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <!-- Imagen del producto -->
                            <div class="w-16 h-16 bg-accent-100 rounded-lg flex-shrink-0 overflow-hidden">
                                @if($product->main_image_url)
                                    <img src="{{ $product->main_image_url }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-black-200">
                                        <x-solar-gallery-outline class="w-6 h-6" />
                                    </div>
                                @endif
                            </div>

                            <!-- Información del producto -->
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-black-400 text-sm mb-1 line-clamp-1">{{ $product->name }}</h3>
                                
                                @if($product->description)
                                    <p class="text-xs text-black-300 mb-2 line-clamp-1">{{ $product->description }}</p>
                                @endif

                                <!-- Precio prominente -->
                                <div class="text-base font-bold text-primary-300 mb-1">
                                    ${{ number_format($product->price, 0, ',', '.') }}
                                </div>

                                <!-- Categorías pequeñas -->
                                @if($product->categories->count() > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($product->categories->take(2) as $category)
                                            <span class="px-2 py-0.5 bg-primary-50 text-primary-300 rounded text-xs">
                                                {{ $category->name }}
                                            </span>
                                        @endforeach
                                        @if($product->categories->count() > 2)
                                            <span class="text-xs text-black-200">+{{ $product->categories->count() - 2 }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Botón agregar al carrito -->
                            <div class="flex-shrink-0">
                                <button class="add-to-cart-btn bg-secondary-300 hover:bg-secondary-200 text-white w-11 h-11 rounded-lg flex items-center justify-center transition-colors" 
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->name }}"
                                        data-product-price="{{ $product->price }}"
                                        data-product-image="{{ $product->main_image_url }}"
                                        onclick="event.preventDefault(); event.stopPropagation();">
                                    <x-solar-cart-plus-outline class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-black-300">
                <x-solar-box-outline class="w-12 h-12 mx-auto mb-3 text-black-200" />
                <p class="text-sm">No hay productos nuevos disponibles</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function sliderComponent(sliders, duration = 5) {
    return {
        currentSlide: 0,
        sliders: sliders,
        duration: duration * 1000, // Convertir a milisegundos
        autoPlayInterval: null,
        isPlaying: true,
        maxSlide: 0,
        isMobile: false,
        
        init() {
            this.checkViewport();
            
            if (this.sliders.length > 1) {
                this.startAutoPlay();
            }
            
            // Escuchar cambios de tamaño de ventana
            window.addEventListener('resize', () => {
                const wasMobile = this.isMobile;
                this.checkViewport();
                
                // Si cambió de móvil a desktop o viceversa, resetear a slide 0
                if (wasMobile !== this.isMobile) {
                    this.currentSlide = 0;
                }
            });
        },
        
        checkViewport() {
            this.isMobile = window.innerWidth < 640; // sm breakpoint de Tailwind
        },
        
        getTransform() {
            if (this.isMobile) {
                // Móvil: desplazar 50% + gap (2 slides visibles)
                return `transform: translateX(calc(-${this.currentSlide * 50}% - ${this.currentSlide * 8}px))`;
            } else {
                // Desktop: desplazar 33.333% + gap (3 slides visibles)
                return `transform: translateX(calc(-${this.currentSlide * 33.333}% - ${this.currentSlide * 12}px))`;
            }
        },
        
        goToSlide(index) {
            this.currentSlide = index;
            this.resetAutoPlay();
        },
        
        nextSlide() {
            this.currentSlide = this.currentSlide + 1;
            
            // Efecto infinito: si llegó al final, resetear sin transición
            if (this.currentSlide >= this.sliders.length) {
                setTimeout(() => {
                    const sliderElement = document.querySelector('.slider-container .flex');
                    if (sliderElement) {
                        sliderElement.style.transition = 'none';
                        this.currentSlide = 0;
                        
                        // Restaurar transición después de un frame
                        setTimeout(() => {
                            sliderElement.style.transition = 'transform 500ms ease-in-out';
                        }, 50);
                    }
                }, 500);
            }
            
            this.resetAutoPlay();
        },
        
        prevSlide() {
            if (this.currentSlide <= 0) {
                // Ir al final si está en el inicio
                this.currentSlide = this.maxSlide;
            } else {
                this.currentSlide = this.currentSlide - 1;
            }
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