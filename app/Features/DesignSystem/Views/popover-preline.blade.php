@extends('design-system::layout')

@section('title', 'Popover Preline UI')
@section('page-title', 'Popover Components')
@section('page-description', 'Componentes de popover basados exactamente en Preline UI')

@section('content')

{{-- SECTION: Four Directions --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Four Directions
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Four options are available: top, right, bottom, and left aligned.</p>
    
    <div class="flex items-center justify-center gap-4 flex-wrap">
        {{-- Left --}}
        <x-popover-left text="Popover izquierdo">
            <button type="button" class="flex justify-center items-center size-10 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                <i data-lucide="chevron-left" class="shrink-0 size-4" x-init="lucide.createIcons()"></i>
            </button>
        </x-popover-left>

        {{-- Top --}}
        <x-popover-top text="Popover superior">
            <button type="button" class="flex justify-center items-center size-10 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                <i data-lucide="chevron-up" class="shrink-0 size-4" x-init="lucide.createIcons()"></i>
            </button>
        </x-popover-top>

        {{-- Bottom --}}
        <x-popover-bottom text="Popover inferior">
            <button type="button" class="flex justify-center items-center size-10 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                <i data-lucide="chevron-down" class="shrink-0 size-4" x-init="lucide.createIcons()"></i>
            </button>
        </x-popover-bottom>

        {{-- Right --}}
        <x-popover-right text="Popover derecho">
            <button type="button" class="flex justify-center items-center size-10 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                <i data-lucide="chevron-right" class="shrink-0 size-4" x-init="lucide.createIcons()"></i>
            </button>
        </x-popover-right>
    </div>
</div>

@endsection















