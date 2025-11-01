@extends('frontend.layouts.app')

@section('content')
<div class="px-4 py-6 space-y-6">
    <!-- Breadcrumbs -->
    <nav class="flex flex-wrap items-center caption text-brandInfo-300 gap-1">
        @foreach($breadcrumbs as $index => $breadcrumb)
            @php
                // Si el breadcrumb es 'Categorías', forzar la URL al catálogo general de categorías
                $isCategories = Str::lower($breadcrumb['name']) === 'categorías';
                $breadcrumbUrl = $isCategories 
                    ? route('tenant.catalog', $store->slug) 
                    : $breadcrumb['url'];
            @endphp

            @if($breadcrumbUrl)
                <a href="{{ $breadcrumbUrl }}" class="hover:text-brandInfo-400 transition-colors">
                    {{ $breadcrumb['name'] }}
                </a>
                @if($index < count($breadcrumbs) - 1)
                    <span class="mx-1">/</span>
                @endif
            @else
                <span class="text-brandNeutral-500 caption-strong">{{ $breadcrumb['name'] }}</span>
            @endif
        @endforeach
    </nav>

    <!-- Header de la categoría -->
    <div class="space-y-2">
        <div class="flex items-center space-x-3">
            <!-- Icono de la categoría -->
            @if($category->icon && $category->icon->image_url)
                <div class="w-12 h-12 bg-brandWhite-100 rounded-lg p-2 flex items-center justify-center">
                    <img src="{{ $category->icon->image_url }}" 
                         alt="{{ $category->name }}" 
                         class="w-full h-full object-contain">
                </div>
            @endif
            
            <div class="flex-1">
                <h1 class="h3 text-brandNeutral-400">{{ $category->name }}</h1>
                @if($category->description)
                    <p class="text-brandNeutral-400 mt-1 caption">{{ $category->description }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Subcategorías -->
    @if($subcategories->count() > 0)
        <div class="space-y-3">
            <h2 class="h3 text-brandNeutral-400">Subcategorías</h2>
            
            <div class="grid grid-cols-4 gap-2">
                @foreach($subcategories as $subcategory)
                    <a href="{{ route('tenant.category', [$store->slug, $subcategory->slug]) }}" 
                       class="flex flex-col items-center group">
                        
                        <!-- Icono de la subcategoría con fondo colorido -->
                        <div class="w-20 h-20 mb-2 flex items-center justify-center rounded-2xl bg-gradient-to-br from-brandWhite-100 to-brandWhite-100 hover:from-brandPrimary-100 hover:to-brandWhite-100 transition-all duration-200 shadow-sm group-hover:shadow-md">
                             @if($subcategory->icon && $subcategory->icon->image_url)
                                 <img src="{{ $subcategory->icon->image_url }}" 
                                      alt="{{ $subcategory->name }}" 
                                      class="w-14 h-14 object-contain">
                             @else
                                 <i data-lucide="image" class="w-10 h-10 text-brandNeutral-300 group-hover:text-brandPrimary-300"></i>
                             @endif
                        </div>

                        <!-- Nombre de la subcategoría -->
                        <span class="caption text-center text-brandNeutral-400 transition-colors leading-tight">
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
            <h2 class="h3 text-brandNeutral-400 mb-3">
                Productos
                <span class="caption text-brandNeutral-300">({{ $products->count() }})</span>
            </h2>
            
            <div class="space-y-3">
                @foreach($products as $product)
                    <a href="{{ route('tenant.product', [$store->slug, $product->slug]) }}" 
                       class="bg-brandWhite-100 rounded-lg p-4 hover:bg-brandPrimary-50 hover:shadow-sm transition-all duration-200 block">
                        <div class="flex items-center gap-3">
                            <!-- Imagen del producto -->
                            <div class="w-20 h-20 bg-brandWhite-100 rounded-lg flex-shrink-0 overflow-hidden">
                                @if($product->main_image_url)
                                    <img src="{{ $product->main_image_url }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-brandNeutral-200">
                                        <i data-lucide="image" class="w-6 h-6 text-brandNeutral-200"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Información del producto -->
                            <div class="flex-1 min-w-0">
                                <h3 class="body-lg-bold text-brandNeutral-400 line-clamp-1">{{ $product->name }}</h3>
                                
                                @if($product->description)
                                    <p class="caption text-brandNeutral-400 line-clamp-1">{{ $product->description }}</p>
                                @endif

                                <!-- Precio prominente -->
                                <div class="body-lg-bold text-brandNeutral-400">
                                    ${{ number_format($product->price, 0, ',', '.') }}
                                </div>

                                <!-- Categorías pequeñas (mostrar otras categorías si tiene) -->
                                @if($product->categories->count() > 1)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($product->categories->where('id', '!=', $category->id)->take(1) as $cat)
                                            <span class="px-2 py-0.5 bg-brandSuccess-50 text-brandSuccess-400 rounded-full caption">
                                                {{ $cat->name }}
                                            </span>
                                        @endforeach
                                        @if($product->categories->where('id', '!=', $category->id)->count() > 1)
                                            <span class="bg-brandSuccess-50 px-2 py-0.5 caption items-center text-brandSuccess-400 rounded-full">+{{ $product->categories->where('id', '!=', $category->id)->count() - 1 }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Botón agregar al carrito -->
                            <div class="flex flex-col gap-2">
                                <x-add-to-cart-button :product="$product" :store="$store" />
                                <div class="bg-brandError-50 p-2 rounded-lg">
                                    <i data-lucide="heart-plus" class="w-16px h-16px text-brandError-400"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @else
        <!-- Estado: Sin productos -->
        @if($subcategories->count() == 0)
            <div class="text-center py-12 space-y-4 max-w-sm mx-auto">
                <div class="space-y-2 text-center flex flex-col items-center mx-auto">
                    <img src="https://cdn.jsdelivr.net/gh/linkiuapp/medialink@main/Assets_Fronted/img_linkiu_v1_ghost.svg" alt="img_linkiu_v1_ghost" class="h-32 w-auto" loading="lazy">
                    <h3 class="h3 text-brandNeutral-400">No hay productos en esta categoría</h3>
                    <p class="caption text-brandNeutral-300 max-w-sm mx-auto">
                        Aún no tenemos productos disponibles en esta categoría. 
                        Explora otras categorías o regresa pronto.
                    </p>
                </div>
                <div class="flex w-full flex-col-2 gap-3 items-center">
                    <a href="{{ route('tenant.catalog', $store->slug) }}" 
                       class="flex-1 flex justify-center items-center px-4 py-2 bg-brandPrimary-300 text-brandWhite-50 rounded-lg hover:bg-brandPrimary-400 transition-colors">
                        <i data-lucide="shopping-basket" class="w-6 h-6 mr-2"></i>
                        Ver catálogo
                    </a>
                    <a href="{{ route('tenant.home', $store->slug) }}" 
                       class="flex-1 flex justify-center items-center px-4 py-2 bg-brandSecondary-300 text-brandWhite-50 rounded-lg hover:bg-brandSecondary-400 transition-colors">
                        <i data-lucide="home" class="w-6 h-6 mr-2"></i>
                        Ir al inicio
                    </a>
                </div>
            @endif
        @endif
    </div>
@endsection