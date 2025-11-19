@extends('design-system::layout')

@section('title', 'Dropdown Preline UI')
@section('page-title', 'Dropdown Components')
@section('page-description', 'Componentes de dropdown basados exactamente en Preline UI')

@section('content')

{{-- SECTION: Default --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Default
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">The default dropdown menu appearance.</p>
    
    <x-dropdown-default 
        :items="[
            ['label' => 'Newsletter', 'url' => '#'],
            ['label' => 'Purchases', 'url' => '#'],
            ['label' => 'Downloads', 'url' => '#'],
            ['label' => 'Team Account', 'url' => '#'],
        ]"
        triggerText="Acciones"
    />
</div>

{{-- SECTION: Icons --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Icons
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">The default dropdown menu with icons.</p>
    
    <x-dropdown-with-icons 
        :items="[
            ['label' => 'Newsletter', 'url' => '#', 'icon' => 'bell'],
            ['label' => 'Purchases', 'url' => '#', 'icon' => 'shopping-cart'],
            ['label' => 'Downloads', 'url' => '#', 'icon' => 'download'],
            ['label' => 'Team Account', 'url' => '#', 'icon' => 'users'],
        ]"
        triggerText="Acciones"
    />
</div>

{{-- SECTION: Title --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Title
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">The default dropdown menu with title.</p>
    
    <x-dropdown-with-title 
        :sections="[
            [
                'title' => 'Configuración',
                'items' => [
                    ['label' => 'Newsletter', 'url' => '#', 'icon' => 'bell'],
                    ['label' => 'Purchases', 'url' => '#', 'icon' => 'shopping-cart'],
                    ['label' => 'Downloads', 'url' => '#', 'icon' => 'download'],
                    ['label' => 'Team Account', 'url' => '#', 'icon' => 'users'],
                ]
            ],
            [
                'title' => 'Contactos',
                'items' => [
                    ['label' => 'Soporte de Contacto', 'url' => '#', 'icon' => 'message-circle'],
                ]
            ]
        ]"
        triggerText="Acciones"
    />
</div>

{{-- SECTION: With Header --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        With Header
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">The default dropdown menu with header.</p>
    
    <x-dropdown-with-header 
        :items="[
            ['label' => 'Newsletter', 'url' => '#', 'icon' => 'bell'],
            ['label' => 'Purchases', 'url' => '#', 'icon' => 'shopping-cart'],
            ['label' => 'Downloads', 'url' => '#', 'icon' => 'download'],
            ['label' => 'Team Account', 'url' => '#', 'icon' => 'users'],
        ]"
        headerTitle="Sesión iniciada como"
        headerSubtitle="james@site.com"
        triggerText="Acciones"
    />
</div>

{{-- SECTION: Custom Icon Trigger --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Custom Icon Trigger
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">The default dropdown menu with custom icon-trigger.</p>
    
    <x-dropdown-custom-icon-trigger 
        :items="[
            ['label' => 'Newsletter', 'url' => '#'],
            ['label' => 'Purchases', 'url' => '#'],
            ['label' => 'Downloads', 'url' => '#'],
            ['label' => 'Team Account', 'url' => '#'],
        ]"
        icon="more-vertical"
    />
</div>

@endsection















