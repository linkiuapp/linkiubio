@extends('frontend.layouts.app')

@section('content')
<div class="px-4 py-6 space-y-6">
    <!-- Breadcrumbs -->
    <nav class="flex flex-wrap items-center text-sm text-black-300 gap-1">
        @foreach($breadcrumbs as $index => $breadcrumb)
            @if($breadcrumb['url'])
                <a href="{{ $breadcrumb['url'] }}" class="hover:text-primary-300 transition-colors">
                    {{ $breadcrumb['name'] }}
                </a>
                @if($index < count($breadcrumbs) - 1)
                    <span class="mx-1">/</span>
                @endif
            @else
                <span class="text-black-400 font-medium">{{ $breadcrumb['name'] }}</span>
            @endif
        @endforeach
    </nav>

    <!-- Header de la categoría -->
    <div class="space-y-2">
        <div class="flex items-center space-x-3">
            <!-- Icono de la categoría -->
            @if($category->icon && $category->icon->image_url)
                <div class="w-12 h-12 bg-accent-100 rounded-lg p-2 flex items-center justify-center">
                    <img src="{{ $category->icon->image_url }}" 
                         alt="{{ $category->name }}" 
                         class="w-full h-full object-contain">
                </div>
            @endif
            
            <div class="flex-1">
                <h1 class="text-base font-bold text-black-400">{{ $category->name }}</h1>
                @if($category->description)
                    <p class="text-black-300 mt-1 text-small font-regular">{{ $category->description }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Subcategorías -->
    @if($subcategories->count() > 0)
        <div class="space-y-3">
            <h2 class="text-base font-semibold text-black-400">Subcategorías</h2>
            
            <div class="grid grid-cols-4 gap-3">
                @foreach($subcategories as $subcategory)
                    <a href="{{ route('tenant.category', [$store->slug, $subcategory->slug]) }}" 
                       class="flex flex-col items-center group">
                        
                        <!-- Icono de la subcategoría con fondo colorido -->
                        <div class="w-20 h-20 mb-2 flex items-center justify-center rounded-2xl bg-gradient-to-br from-accent-50 to-accent-100 hover:from-primary-50 hover:to-accent-50 transition-all duration-200 shadow-sm group-hover:shadow-md">
                             @if($subcategory->icon && $subcategory->icon->image_url)
                                 <img src="{{ $subcategory->icon->image_url }}" 
                                      alt="{{ $subcategory->name }}" 
                                      class="w-14 h-14 object-contain">
                             @else
                                 <x-solar-gallery-outline class="w-10 h-10 text-black-300 group-hover:text-primary-300" />
                             @endif
                        </div>

                        <!-- Nombre de la subcategoría -->
                        <span class="text-caption font-regular text-center text-black-500 transition-colors leading-tight">
                            {{ $subcategory->name }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Productos -->
    @if($products->count() > 0)
        <div>
            <h2 class="text-base font-semibold text-black-400 mb-3">
                Productos
                <span class="text-small font-regular text-black-300">({{ $products->count() }})</span>
            </h2>
            
            <div class="space-y-3">
                @foreach($products as $product)
                    <a href="{{ route('tenant.product', [$store->slug, $product->slug]) }}" 
                       class="bg-white rounded-lg p-3 border border-accent-200 hover:border-primary-200 hover:shadow-sm transition-all duration-200 block">
                        <div class="flex items-center gap-3">
                            <!-- Imagen del producto -->
                            <div class="w-20 h-20 bg-accent-100 rounded-lg flex-shrink-0 overflow-hidden">
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
                                <h3 class="text-caption font-bold text-black-500 mb-1 line-clamp-1">{{ $product->name }}</h3>
                                
                                @if($product->description)
                                    <p class="text-small font-regular text-black-300 mb-2 line-clamp-1">{{ $product->description }}</p>
                                @endif

                                <!-- Precio prominente -->
                                <div class="text-body-regular font-bold text-primary-300 mb-1">
                                    ${{ number_format($product->price, 0, ',', '.') }}
                                </div>

                                <!-- Categorías pequeñas (mostrar otras categorías si tiene) -->
                                @if($product->categories->count() > 1)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($product->categories->where('id', '!=', $category->id)->take(2) as $cat)
                                            <span class="px-2 py-0.5 bg-accent-300 text-black-500 rounded text-small">
                                                {{ $cat->name }}
                                            </span>
                                        @endforeach
                                        @if($product->categories->where('id', '!=', $category->id)->count() > 2)
                                            <span class="text-small font-regular text-black-200">+{{ $product->categories->where('id', '!=', $category->id)->count() - 2 }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Botón agregar al carrito -->
                            <x-add-to-cart-button :product="$product" :store="$store" />
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @else
        <!-- Estado: Sin productos -->
        @if($subcategories->count() == 0)
            <div class="text-center py-12 space-y-4">
                <div class="w-16 h-16 bg-accent-100 rounded-full flex items-center justify-center mx-auto">
                    <x-solar-box-outline class="w-8 h-8 text-black-200" />
                </div>
                <div class="space-y-2">
                    <h3 class="text-base font-semibold text-black-400">No hay productos en esta categoría</h3>
                    <p class="text-black-300 max-w-sm mx-auto text-small font-regular">
                        Aún no tenemos productos disponibles en esta categoría. 
                        Explora otras categorías o regresa pronto.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('tenant.categories', $store->slug) }}" 
                       class="inline-flex items-center px-4 py-2 bg-primary-300 text-accent-50 rounded-lg hover:bg-primary-200 transition-colors text-sm">
                        <x-solar-gallery-outline class="w-4 h-4 mr-2" />
                        Ver categorías
                    </a>
                    <a href="{{ route('tenant.home', $store->slug) }}" 
                       class="inline-flex items-center px-4 py-2 bg-accent-200 text-black-400 rounded-lg hover:bg-accent-300 transition-colors text-sm">
                        <x-solar-home-2-outline class="w-4 h-4 mr-2" />
                        Ir al inicio
                    </a>
                </div>
            </div>
        @endif
    @endif
</div>
@endsection 