@extends('design-system::layout')

@section('title', 'Tipografías')
@section('page-title', '✍️ Sistema Tipográfico')
@section('page-description', 'Escalas tipográficas responsivas con clamp() definidas en resources/css/app.css')

@section('content')

{{-- SECTION: Indicadores de Dispositivos --}}
<div class="mb-8 bg-white rounded-xl p-6 shadow-sm border border-brandNeutral-50">
    <div class="flex gap-3 flex-wrap">
        {{-- ITEM: device-indicator | type:mobile --}}
        <span class="caption bg-brandInfo-50 text-brandInfo-300 px-3 py-1.5 rounded-lg border border-brandInfo-200">
            📱 Mobile: 320px-640px
        </span>
        {{-- ITEM: device-indicator | type:tablet --}}
        <span class="caption bg-brandInfo-50 text-brandInfo-300 px-3 py-1.5 rounded-lg border border-brandInfo-200">
            📱 Tablet: 641px-1024px
        </span>
        {{-- ITEM: device-indicator | type:laptop --}}
        <span class="caption bg-brandInfo-50 text-brandInfo-300 px-3 py-1.5 rounded-lg border border-brandInfo-200">
            💻 Laptop: 1025px-1440px
        </span>
        {{-- ITEM: device-indicator | type:desktop --}}
        <span class="caption bg-brandInfo-50 text-brandInfo-300 px-3 py-1.5 rounded-lg border border-brandInfo-200">
            🖥️ Desktop: 1441px+
        </span>
    </div>
</div>

<!-- Headings -->
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-6 mb-6">
    <h3 class="h3 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">📐 Headings</h3>
    <div class="space-y-8">
        @foreach($typography['headings'] as $typo)
        <div class="border-l-4 border-brandPrimary-200 pl-6">
            <div class="flex items-center justify-between mb-3">
                <span class="body-lg-bold text-brandNeutral-400">{{ $typo['label'] }}</span>
                <code class="caption bg-brandPrimary-50 px-3 py-1 rounded text-brandPrimary-300">.{{ $typo['class'] }}</code>
            </div>
            <p class="{{ $typo['class'] }} text-brandNeutral-400 mb-3">
                The quick brown fox jumps over the lazy dog
            </p>
            <div class="flex gap-4 text-brandNeutral-200">
                <span class="caption">📏 {{ $typo['size'] }}</span>
                <span class="caption">📊 Line-height: {{ $typo['lineHeight'] }}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Body -->
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-6 mb-6">
    <h3 class="h3 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">📝 Body Text</h3>
    <div class="space-y-8">
        @foreach($typography['body'] as $typo)
        <div class="border-l-4 border-brandSuccess-200 pl-6">
            <div class="flex items-center justify-between mb-3">
                <span class="body-lg-bold text-brandNeutral-400">{{ $typo['label'] }}</span>
                <code class="caption bg-brandSuccess-50 px-3 py-1 rounded text-brandSuccess-300">.{{ $typo['class'] }}</code>
            </div>
            <p class="{{ $typo['class'] }} text-brandNeutral-400 mb-3">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
            </p>
            <div class="flex gap-4 text-brandNeutral-200">
                <span class="caption">📏 {{ $typo['size'] }}</span>
                <span class="caption">📊 Line-height: {{ $typo['lineHeight'] }}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Caption -->
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-6">
    <h3 class="h3 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">🏷️ Captions</h3>
    <div class="space-y-8">
        @foreach($typography['caption'] as $typo)
        <div class="border-l-4 border-brandSecondary-200 pl-6">
            <div class="flex items-center justify-between mb-3">
                <span class="body-lg-bold text-brandNeutral-400">{{ $typo['label'] }}</span>
                <code class="caption bg-brandSecondary-50 px-3 py-1 rounded text-brandSecondary-300">.{{ $typo['class'] }}</code>
            </div>
            <p class="{{ $typo['class'] }} text-brandNeutral-400 mb-3">
                Small text for labels, hints, and metadata. Used for supplementary information.
            </p>
            <div class="flex gap-4 text-brandNeutral-200">
                <span class="caption">📏 {{ $typo['size'] }}</span>
                <span class="caption">📊 Line-height: {{ $typo['lineHeight'] }}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection


