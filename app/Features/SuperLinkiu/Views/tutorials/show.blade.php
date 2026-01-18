@extends('shared::layouts.admin')

@section('title', $tutorial->title)

@section('content')
<div class="max-w-4xl mx-auto space-y-6 mt-6">
    {{-- SECTION: Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.tutorials.index') }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-800">{{ $tutorial->title }}</h1>
                <p class="text-sm text-gray-600 mt-1">{{ $tutorial->category->name }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('superlinkiu.tutorials.edit', $tutorial) }}" 
               class="px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white rounded-lg flex items-center gap-2 font-medium transition-colors">
                <i data-lucide="edit" class="w-4 h-4"></i>
                Editar
            </a>
        </div>
    </div>
    {{-- End SECTION: Header --}}

    {{-- SECTION: Tutorial Content --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="p-6 space-y-6">
            {{-- Meta Information --}}
            <div class="flex items-center gap-4 flex-wrap pb-4 border-b border-gray-200">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ $tutorial->category->name }}
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                    {{ $tutorial->difficulty_level === 'beginner' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $tutorial->difficulty_level === 'intermediate' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $tutorial->difficulty_level === 'advanced' ? 'bg-red-100 text-red-800' : '' }}">
                    {{ $tutorial->difficulty_label }}
                </span>
                @if($tutorial->is_active)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Activo
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        Inactivo
                    </span>
                @endif
                <span class="text-sm text-gray-500">
                    <i data-lucide="eye" class="w-4 h-4 inline"></i> {{ number_format($tutorial->views_count) }} vistas
                </span>
            </div>

            {{-- Featured Image --}}
            @if($tutorial->featured_image)
                <div>
                    <img src="{{ Storage::disk('public')->url($tutorial->featured_image) }}" 
                         alt="{{ $tutorial->title }}"
                         class="w-full h-auto rounded-lg border border-gray-200">
                </div>
            @endif

            {{-- Description --}}
            @if($tutorial->description)
                <div>
                    <p class="text-gray-700 leading-relaxed">{{ $tutorial->description }}</p>
                </div>
            @endif

            {{-- Video --}}
            @if($tutorial->video_url)
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Video Tutorial</h3>
                    @include('public::components.embedded-video', ['url' => $tutorial->video_url])
                </div>
            @endif

            {{-- Content --}}
            <div class="prose max-w-none">
                {!! nl2br(e($tutorial->content)) !!}
            </div>

            {{-- Tags --}}
            @if($tutorial->tags->isNotEmpty())
                <div class="pt-4 border-t border-gray-200">
                    <p class="text-sm font-medium text-gray-700 mb-2">Etiquetas:</p>
                    <div class="flex items-center gap-2 flex-wrap">
                        @foreach($tutorial->tags as $tag)
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Statistics --}}
            <div class="pt-4 border-t border-gray-200">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Creado:</p>
                        <p class="font-medium text-gray-900">{{ $tutorial->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Actualizado:</p>
                        <p class="font-medium text-gray-900">{{ $tutorial->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End SECTION: Tutorial Content --}}
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush
@endsection
