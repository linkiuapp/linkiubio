@php
    $templateField = 'template_' . $templateKey;
    $varsField = 'template_' . $templateKey . '_vars';
    $currentTemplateId = $config->$templateField ?? '';
    $currentVars = $config->$varsField ?? [];
@endphp

<div class="border border-gray-200 rounded-lg p-5 hover:shadow-lg transition-shadow">
    <!-- Header -->
    <div class="mb-4">
        <h3 class="font-semibold text-gray-900">{{ $template['name'] }}</h3>
        <p class="text-sm text-gray-500 mt-1">Categoría: {{ $category }}</p>
        <p class="text-xs text-gray-400 mt-1">{{ $template['description'] }}</p>
    </div>

    <!-- Template ID Input -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-black-300 mb-2">Template ID:</label>
        <div class="flex gap-2">
            <input type="text" 
                   id="template_{{ $templateKey }}"
                   class="flex-1 px-3 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none text-sm"
                   placeholder="d-xxxxxxxxxx"
                   value="{{ $currentTemplateId }}">
            <button id="validate_btn_{{ $templateKey }}"
                    onclick="validateTemplate('{{ $templateKey }}')" 
                    class="btn-outline-primary px-4 py-2 text-sm whitespace-nowrap">
                Validar
            </button>
        </div>
    </div>

    <!-- Test Email Section -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-black-300 mb-2">Enviar email de prueba:</label>
        <div class="flex gap-2">
            <input type="email" 
                   id="test_email_{{ $templateKey }}"
                   class="flex-1 px-3 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none text-sm"
                   placeholder="correo@ejemplo.com">
            <button id="send_btn_{{ $templateKey }}"
                    onclick="sendTestEmail('{{ $templateKey }}')" 
                    class="btn-outline-secondary px-4 py-2 text-sm whitespace-nowrap">
                Enviar prueba
            </button>
        </div>
    </div>

    <!-- Variables Section -->
    <div class="border-t pt-3">
        <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-3">
            <div class="flex items-start mb-3">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-amber-500 text-lg"></i>
                </div>
                <div class="ml-3 flex-1">
                    <h4 class="text-sm font-bold text-amber-900 mb-1">
                        Variables OBLIGATORIAS para este template
                    </h4>
                    <p class="text-xs text-amber-700">
                        Debes agregar estas variables exactamente como se muestran en tu Dynamic Template de SendGrid:
                    </p>
                </div>
            </div>
            
            <div id="vars_{{ $templateKey }}" class="bg-white rounded border border-amber-200 p-3">
                <div class="grid grid-cols-1 gap-2">
                    @php
                        $isValidated = count($currentVars) > 0;
                    @endphp
                    
                    @if(is_array($template['required_vars']) && count($template['required_vars']) > 0)
                        @foreach($template['required_vars'] as $varName => $varDescription)
                            @php
                                $hasVar = $isValidated && in_array($varName, $currentVars);
                            @endphp
                            <div class="flex items-start justify-between p-2 bg-gray-50 rounded border {{ $hasVar ? 'border-green-200 bg-green-50' : 'border-gray-200' }}">
                                <div class="flex-1">
                                    <code class="text-sm font-mono {{ $hasVar ? 'text-green-700' : 'text-gray-700' }} font-semibold">
                                        {{ $varName }}
                                    </code>
                                    <span class="text-xs text-gray-500 ml-2">({{ $varDescription }})</span>
                                </div>
                                @if($hasVar)
                                    <i class="fas fa-check-circle text-green-500 text-sm mt-1"></i>
                                @else
                                    <i class="fas fa-circle text-gray-300 text-xs mt-1"></i>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            
            <div class="mt-3 flex items-start gap-2 bg-amber-100 border border-amber-200 rounded p-2">
                <i class="fas fa-info-circle text-amber-600 text-sm mt-0.5"></i>
                <p class="text-xs text-amber-800">
                    <strong>Cómo usar:</strong> En el editor de SendGrid, arrastra elementos "Text" o "Button" y usa estas variables escribiendo exactamente 
                    <code class="bg-amber-200 px-1 rounded">@{{nombre_variable}}</code>
                </p>
            </div>
        </div>
    </div>

    <!-- Status Indicator -->
    @if($currentTemplateId)
        <div class="mt-3 pt-3 border-t">
            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                <i class="fas fa-check-circle mr-1"></i> Configurado
            </span>
        </div>
    @endif
</div>
