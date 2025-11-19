@extends('design-system::layout')

@section('title', 'Searchbox Preline UI')
@section('page-title', 'Searchbox Components')
@section('page-description', 'Componentes de searchbox basados exactamente en Preline UI')

@section('content')

{{-- SECTION: Dropdown --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Dropdown
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Using JSON example in dropdown.</p>
    
    @php
        $sampleItems = [
            ['name' => 'John Doe', 'category' => 'Usuarios', 'image' => 'https://ui-avatars.com/api/?name=John+Doe&background=random'],
            ['name' => 'Jane Smith', 'category' => 'Usuarios', 'image' => 'https://ui-avatars.com/api/?name=Jane+Smith&background=random'],
            ['name' => 'Producto A', 'category' => 'Productos', 'image' => 'https://ui-avatars.com/api/?name=Producto+A&background=random'],
            ['name' => 'Producto B', 'category' => 'Productos', 'image' => 'https://ui-avatars.com/api/?name=Producto+B&background=random'],
            ['name' => 'Categoría X', 'category' => 'Categorías', 'image' => 'https://ui-avatars.com/api/?name=Categoria+X&background=random'],
            ['name' => 'Categoría Y', 'category' => 'Categorías', 'image' => 'https://ui-avatars.com/api/?name=Categoria+Y&background=random'],
        ];
    @endphp
    
    <x-searchbox-dropdown 
        name="searchbox-dropdown"
        placeholder="Escribe un nombre"
        :items="$sampleItems"
    />
</div>

@endsection















