@extends('shared::layouts.admin')

@section('title', 'Configuración de Emails - SendGrid')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-lg font-bold text-black-400">Configuración de SendGrid</h1>
        <p class="text-sm text-gray-600">Configura las plantillas de email usando SendGrid Dynamic Templates</p>
    </div>

    <!-- API Key Configuration -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-md font-semibold mb-4">Configuración de API</h2>
        
        <div class="flex gap-4 items-end">
            <div class="flex-1">
                <label class="block text-sm font-medium text-black-300 mb-2">
                    API Key de SendGrid <span class="text-error-300">*</span>
                </label>
                <input type="password" 
                       id="api_key" 
                       class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none"
                       placeholder="SG.xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
                       value="{{ $config->sendgrid_api_key ? str_repeat('*', 20) . substr($config->sendgrid_api_key, -10) : '' }}">
            </div>
            <button onclick="validateApiKey()" class="btn-primary px-6 py-2.5 whitespace-nowrap">
                <span id="validate-api-text">Validar API</span>
                <span id="validate-api-spinner" class="hidden">
                    <i class="fas fa-spinner fa-spin"></i> Validando...
                </span>
            </button>
        </div>
        
        @if($config->api_validated_at)
        <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded">
            <p class="text-sm text-green-700">
                <i class="fas fa-check-circle"></i> API validada el {{ $config->api_validated_at->format('d/m/Y H:i') }}
            </p>
        </div>
        @endif
    </div>

    <!-- Sender Configuration -->
    @if($config->api_validated_at)
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-md font-semibold mb-4">Configuración de Remitentes</h2>
        
        <form id="sender-config-form" onsubmit="saveSenderConfig(event)">
            <!-- Dominio Verificado -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-black-300 mb-2">
                    Dominio Verificado en SendGrid <span class="text-error-300">*</span>
                </label>
                <input type="text" 
                       id="verified_domain"
                       name="verified_domain"
                       class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none"
                       placeholder="linkiu.email"
                       value="{{ $config->verified_domain ?? 'linkiu.email' }}">
                <p class="text-xs text-gray-500 mt-1">
                    <i class="fas fa-info-circle"></i> Este dominio debe estar verificado en SendGrid para poder enviar emails.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Email Gestión de Tiendas -->
                <div>
                    <label class="block text-sm font-medium text-black-300 mb-2">
                        <i class="fas fa-store text-blue-500"></i> Gestión de Tiendas
                    </label>
                    <input type="email" 
                           id="sender_store_management"
                           name="sender_store_management"
                           class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none"
                           placeholder="tiendas@linkiu.email"
                           value="{{ $config->sender_store_management ?? 'tiendas@linkiu.email' }}">
                    <p class="text-xs text-gray-500 mt-1">Para emails de creación, verificación, suspensión de tiendas</p>
                </div>

                <!-- Email Tickets -->
                <div>
                    <label class="block text-sm font-medium text-black-300 mb-2">
                        <i class="fas fa-ticket-alt text-purple-500"></i> Tickets/Soporte
                    </label>
                    <input type="email" 
                           id="sender_tickets"
                           name="sender_tickets"
                           class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none"
                           placeholder="soporte@linkiu.email"
                           value="{{ $config->sender_tickets ?? 'soporte@linkiu.email' }}">
                    <p class="text-xs text-gray-500 mt-1">Para respuestas y notificaciones de tickets</p>
                </div>

                <!-- Email Facturación -->
                <div>
                    <label class="block text-sm font-medium text-black-300 mb-2">
                        <i class="fas fa-file-invoice-dollar text-green-500"></i> Facturación
                    </label>
                    <input type="email" 
                           id="sender_billing"
                           name="sender_billing"
                           class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none"
                           placeholder="facturas@linkiu.email"
                           value="{{ $config->sender_billing ?? 'facturas@linkiu.email' }}">
                    <p class="text-xs text-gray-500 mt-1">Para facturas y pagos</p>
                </div>
            </div>

            <div class="mt-4 flex justify-end">
                <button type="submit" class="btn-primary px-6 py-2.5">
                    <i class="fas fa-save mr-2"></i> Guardar Configuración
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Tabs -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="border-b">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button onclick="showTab('todas')" 
                        class="tab-btn py-4 px-1 border-b-2 font-medium text-sm border-primary-500 text-primary-600"
                        data-tab="todas">
                    Todas
                </button>
                <button onclick="showTab('gestion')" 
                        class="tab-btn py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                        data-tab="gestion">
                    Gestión de tiendas
                </button>
                <button onclick="showTab('tickets')" 
                        class="tab-btn py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                        data-tab="tickets">
                    Tickets
                </button>
                <button onclick="showTab('facturacion')" 
                        class="tab-btn py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                        data-tab="facturacion">
                    Facturación
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            <!-- Tab: Todas -->
            <div id="tab-todas" class="tab-content">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($templateTypes as $categoryKey => $category)
                        @foreach($category['templates'] as $templateKey => $template)
                            @include('superlinkiu::email.partials.template-card', [
                                'templateKey' => $templateKey,
                                'template' => $template,
                                'category' => $category['title'],
                                'config' => $config
                            ])
                        @endforeach
                    @endforeach
                </div>
            </div>

            <!-- Tab: Gestión de tiendas -->
            <div id="tab-gestion" class="tab-content hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($templateTypes['store_management']['templates'] as $templateKey => $template)
                        @include('superlinkiu::email.partials.template-card', [
                            'templateKey' => $templateKey,
                            'template' => $template,
                            'category' => 'Gestión de tiendas',
                            'config' => $config
                        ])
                    @endforeach
                </div>
            </div>

            <!-- Tab: Tickets -->
            <div id="tab-tickets" class="tab-content hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($templateTypes['tickets']['templates'] as $templateKey => $template)
                        @include('superlinkiu::email.partials.template-card', [
                            'templateKey' => $templateKey,
                            'template' => $template,
                            'category' => 'Tickets',
                            'config' => $config
                        ])
                    @endforeach
                </div>
            </div>

            <!-- Tab: Facturación -->
            <div id="tab-facturacion" class="tab-content hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($templateTypes['billing']['templates'] as $templateKey => $template)
                        @include('superlinkiu::email.partials.template-card', [
                            'templateKey' => $templateKey,
                            'template' => $template,
                            'category' => 'Facturación',
                            'config' => $config
                        ])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Guardar configuración de remitentes
function saveSenderConfig(event) {
    event.preventDefault();
    
    const formData = {
        verified_domain: document.getElementById('verified_domain').value,
        sender_store_management: document.getElementById('sender_store_management').value,
        sender_tickets: document.getElementById('sender_tickets').value,
        sender_billing: document.getElementById('sender_billing').value
    };
    
    fetch('{{ route("superlinkiu.email.save-sender-config") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('¡Éxito!', 'Configuración de remitentes guardada correctamente', 'success');
        } else {
            Swal.fire('Error', data.message || 'Error al guardar la configuración', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Error al guardar la configuración', 'error');
    });
}

// Función para cambiar tabs
function showTab(tab) {
    // Ocultar todos los contenidos
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Desactivar todos los botones
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('border-primary-500', 'text-primary-600');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Mostrar el contenido seleccionado
    document.getElementById('tab-' + tab).classList.remove('hidden');
    
    // Activar el botón seleccionado
    document.querySelector(`[data-tab="${tab}"]`).classList.remove('border-transparent', 'text-gray-500');
    document.querySelector(`[data-tab="${tab}"]`).classList.add('border-primary-500', 'text-primary-600');
}

// Validar API Key
function validateApiKey() {
    const apiKey = document.getElementById('api_key').value;
    
    if (!apiKey || apiKey.includes('*')) {
        Swal.fire('Error', 'Por favor ingresa una API Key válida', 'error');
        return;
    }
    
    // Mostrar spinner
    document.getElementById('validate-api-text').classList.add('hidden');
    document.getElementById('validate-api-spinner').classList.remove('hidden');
    
    fetch('{{ route("superlinkiu.email.validate-api") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ api_key: apiKey })
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            Swal.fire('¡Éxito!', data.message, 'success').then(() => {
                location.reload();
            });
        } else {
            Swal.fire('Error', data.message || 'Error desconocido', 'error');
        }
    })
    .catch(error => {
        console.error('Error completo:', error);
        Swal.fire('Error', 'Error al validar la API Key: ' + error.message, 'error');
    })
    .finally(() => {
        document.getElementById('validate-api-text').classList.remove('hidden');
        document.getElementById('validate-api-spinner').classList.add('hidden');
    });
}

// Validar template
function validateTemplate(templateKey) {
    const templateId = document.getElementById('template_' + templateKey).value;
    
    if (!templateId) {
        Swal.fire('Error', 'Por favor ingresa un Template ID', 'error');
        return;
    }
    
    // Mostrar loading en el botón
    const btn = document.getElementById('validate_btn_' + templateKey);
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Validando...';
    btn.disabled = true;
    
    fetch('{{ route("superlinkiu.email.validate-template") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ 
            template_id: templateId,
            template_type: templateKey 
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Actualizar variables en la UI
            const varsContainer = document.getElementById('vars_' + templateKey);
            if (data.variables && data.variables.length > 0) {
                varsContainer.innerHTML = data.variables.map(v => 
                    '<span class="text-primary-600 font-mono">@{{' + v + '}}</span>'
                ).join(', ');
            }
            
            // Mostrar check verde
            btn.innerHTML = '<i class="fas fa-check text-green-500"></i> Validado';
            btn.classList.remove('btn-outline-primary');
            btn.classList.add('btn-outline-success');
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }, 3000);
            
            Swal.fire('¡Éxito!', `Template "${data.template_name}" validado`, 'success');
        } else {
            Swal.fire('Error', data.message, 'error');
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    })
    .catch(error => {
        Swal.fire('Error', 'Error al validar el template', 'error');
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}

// Enviar email de prueba
function sendTestEmail(templateKey) {
    const templateId = document.getElementById('template_' + templateKey).value;
    const testEmail = document.getElementById('test_email_' + templateKey).value;
    
    if (!templateId) {
        Swal.fire('Error', 'Primero debes configurar y validar el Template ID', 'error');
        return;
    }
    
    if (!testEmail) {
        Swal.fire('Error', 'Por favor ingresa un email de prueba', 'error');
        return;
    }
    
    // Validar formato de email
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(testEmail)) {
        Swal.fire('Error', 'Por favor ingresa un email válido', 'error');
        return;
    }
    
    // Mostrar loading
    const btn = document.getElementById('send_btn_' + templateKey);
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
    btn.disabled = true;
    
    fetch('{{ route("superlinkiu.email.send-test") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ 
            template_id: templateId,
            template_type: templateKey,
            test_email: testEmail 
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('¡Enviado!', data.message, 'success');
            // Limpiar campo de email
            document.getElementById('test_email_' + templateKey).value = '';
        } else {
            Swal.fire('Error', data.message, 'error');
        }
    })
    .catch(error => {
        Swal.fire('Error', 'Error al enviar el email de prueba', 'error');
    })
    .finally(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}
</script>
@endpush
@endsection
