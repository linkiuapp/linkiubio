@extends('design-system::layout')

@section('title', 'Colores')
@section('page-title', '🎨 Sistema de Colores')
@section('page-description', 'Paleta de colores del brand definida en tailwind.config.js')

@section('content')

{{-- SECTION: Paleta de Colores Brand --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    {{-- LIST: colorPalette | count:{{ $colorPalette->count ?? count($colorPalette) }} --}}
    @forelse($colorPalette as $colorKey => $colorData)
        {{-- ITEM: color-group | id:{{ $colorKey }} | title:{{ $colorData['name'] }} --}}
        <div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-6">
            <h3 class="h4 text-brandNeutral-400 mb-4">{{ $colorData['name'] }}</h3>
            
            {{-- region: Color Shades --}}
            <div class="space-y-3">
                @forelse($colorData['shades'] as $shade => $hex)
                    {{-- ITEM: shade | id:{{ $colorKey }}-{{ $shade }} | hex:{{ $hex }} --}}
                    <div class="flex items-center gap-4">
                        {{-- Color preview --}}
                        <div class="w-16 h-16 rounded-lg shadow-md border border-brandNeutral-50 flex-shrink-0" 
                             style="background-color: {{ $hex }}">
                        </div>
                        
                        {{-- Color information --}}
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <span class="body-lg-medium text-brandNeutral-400">
                                    {{ $shade }}
                                </span>
                                <code class="caption bg-brandNeutral-50 px-2 py-1 rounded text-brandNeutral-300">
                                    {{ $colorKey }}-{{ $shade }}
                                </code>
                            </div>
                            <span class="body-small text-brandNeutral-200">
                                {{ $hex }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="body-small text-brandNeutral-200">No hay tonos definidos</p>
                @endforelse
            </div>
            {{-- endregion --}}
        </div>
    @empty
        <div class="col-span-2 text-center p-8">
            <p class="body-lg text-brandNeutral-200">No hay colores definidos</p>
        </div>
    @endforelse
</div>

@endsection


