@extends('design-system::layout')

@section('title', 'Textarea Preline UI')
@section('page-title', 'Textarea Components')
@section('page-description', 'Componentes de textarea basados exactamente en Preline UI')

@section('content')

{{-- SECTION: Placeholder --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Placeholder
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Basic input example with placeholder.</p>
    
    <div class="max-w-sm space-y-3">
        <x-textarea-placeholder placeholder="This is a textarea placeholder" rows="3" />
    </div>
</div>

{{-- SECTION: Label --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Label
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Basic input example with label.</p>
    
    <div class="max-w-sm">
        <x-textarea-with-label label="Comment" placeholder="Say hi..." rows="3" />
    </div>
</div>

{{-- SECTION: Hidden Label --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Hidden Label
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6"><label> elements hidden using the .sr-only class</p>
    
    <div class="max-w-sm">
        <x-textarea-hidden-label label="Comment" placeholder="Say hi..." rows="3" />
    </div>
</div>

{{-- SECTION: Gray Input --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Gray Input
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Gray textarea variant.</p>
    
    <div class="max-w-sm space-y-3">
        <x-textarea-gray placeholder="This is a textarea placeholder" rows="3" />
    </div>
</div>

{{-- SECTION: Default Height with Autoheight --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Default Height with Autoheight Script
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Use data-hs-default-height="*" to set the height of the textarea while maintaining the auto-height feature. Ensure to include the rows="1" attribute as well.</p>
    
    <div class="max-w-sm">
        <x-textarea-auto-height-with-button placeholder="Message..." button-text="Send" />
    </div>
</div>

{{-- SECTION: Readonly --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Readonly
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Add the readonly boolean attribute on an input to prevent modification of the input's value.</p>
    
    <div class="max-w-sm space-y-3">
        <x-textarea-readonly placeholder="Readonly" rows="3" />
    </div>
</div>

{{-- SECTION: Disabled --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Disabled
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Add the disabled boolean attribute on an input to remove pointer events, and prevent focusing.</p>
    
    <div class="max-w-sm space-y-3">
        <x-textarea-disabled placeholder="Disabled textarea" rows="3" />
        <x-textarea-disabled placeholder="Disabled readonly textarea" rows="3" :readonly="true" />
    </div>
</div>

{{-- SECTION: Helper Text --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Helper Text
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Basic input example with helper text.</p>
    
    <div class="max-w-sm">
        <x-textarea-with-helper 
            label="Leave your question" 
            placeholder="Say hi, we'll be happy to chat with you." 
            helper-text="We'll get back to you soon." 
            rows="3" 
        />
    </div>
</div>

{{-- SECTION: Corner Hint --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Corner Hint
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Basic input example with corner-hint.</p>
    
    <div class="max-w-sm">
        <x-textarea-with-corner-hint 
            label="Contact us" 
            corner-hint="100 characters" 
            placeholder="Say hi..." 
            rows="3" 
        />
    </div>
</div>

{{-- SECTION: Autoheight --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Autoheight
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Autoheight example.</p>
    
    <div class="max-w-sm">
        <x-textarea-auto-height 
            label="Contact us" 
            placeholder="Say hi..." 
        />
    </div>
</div>

@endsection















