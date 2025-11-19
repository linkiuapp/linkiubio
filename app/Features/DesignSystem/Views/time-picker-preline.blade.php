@extends('design-system::layout')

@section('title', 'Time Picker Preline UI')
@section('page-title', 'Time Picker Components')
@section('page-description', 'Componentes de time picker basados exactamente en Preline UI')

@section('content')

{{-- SECTION: Custom Style --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Custom Style
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Basic time picker with custom style example.</p>
    
    <x-time-picker-custom 
        name="time-picker"
        value=""
    />
</div>

@endsection















