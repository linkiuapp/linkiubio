@extends('design-system::layout')

@section('title', 'File Input Preline UI')
@section('page-title', 'File Input Components')
@section('page-description', 'Componentes de file input basados exactamente en Preline UI')

@section('content')

{{-- SECTION: File Input Buttons --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        File Input Buttons
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Button style file input example.</p>
    
    <div class="max-w-sm">
        <x-file-input-button label="Choose profile photo" />
    </div>
</div>

@endsection















