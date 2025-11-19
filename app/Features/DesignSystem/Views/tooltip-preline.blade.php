@extends('design-system::layout')

@section('title', 'Tooltip Preline UI')
@section('page-title', 'Tooltip Components')
@section('page-description', 'Componentes de tooltip basados exactamente en Preline UI')

@section('content')

{{-- SECTION: Four Directions --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Four Directions
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Hover over the buttons below to see the four tooltip directions: top, right, bottom, and left.</p>
    
    <div class="grid grid-cols-3 gap-y-4 gap-x-2 max-w-60 mx-auto">
        {{-- Top --}}
        <div class="col-start-2 text-center">
            <x-tooltip-top text="Tooltip superior">
                <button type="button" class="size-10 inline-flex justify-center items-center gap-2 rounded-full bg-gray-50 border border-gray-200 text-gray-600 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 focus:outline-hidden focus:bg-blue-50 focus:border-blue-200 focus:text-blue-600">
                    <i data-lucide="chevron-up" class="shrink-0 size-4" x-init="lucide.createIcons()"></i>
                </button>
            </x-tooltip-top>
        </div>

        {{-- Left --}}
        <div class="col-start-1 text-end">
            <x-tooltip-left text="Tooltip izquierdo">
                <button type="button" class="size-10 inline-flex justify-center items-center gap-2 rounded-full bg-gray-50 border border-gray-200 text-gray-600 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 focus:outline-hidden focus:bg-blue-50 focus:border-blue-200 focus:text-blue-600">
                    <i data-lucide="chevron-left" class="shrink-0 size-4" x-init="lucide.createIcons()"></i>
                </button>
            </x-tooltip-left>
        </div>

        {{-- Right --}}
        <div class="col-start-3">
            <x-tooltip-right text="Tooltip derecho">
                <button type="button" class="size-10 inline-flex justify-center items-center gap-2 rounded-full bg-gray-50 border border-gray-200 text-gray-600 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 focus:outline-hidden focus:bg-blue-50 focus:border-blue-200 focus:text-blue-600">
                    <i data-lucide="chevron-right" class="shrink-0 size-4" x-init="lucide.createIcons()"></i>
                </button>
            </x-tooltip-right>
        </div>

        {{-- Bottom --}}
        <div class="col-start-2 text-center">
            <x-tooltip-bottom text="Tooltip inferior">
                <button type="button" class="size-10 inline-flex justify-center items-center gap-2 rounded-full bg-gray-50 border border-gray-200 text-gray-600 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 focus:outline-hidden focus:bg-blue-50 focus:border-blue-200 focus:text-blue-600">
                    <i data-lucide="chevron-down" class="shrink-0 size-4" x-init="lucide.createIcons()"></i>
                </button>
            </x-tooltip-bottom>
        </div>
    </div>
</div>

@endsection















