@extends('shared::layouts.admin')

@section('title', 'Gestión de Tiendas')

@section('content')
<div class="container-fluid" x-data="storeManagement">
    {{-- ================================================================ --}}
    {{-- MODALES Y NOTIFICACIONES --}}
    {{-- ================================================================ --}}
    
    {{-- Modal de Eliminación --}}
    @include('superlinkiu::stores.components.delete-modal')
    
    {{-- Modal de Éxito (Creación) --}}
    @include('superlinkiu::stores.components.success-modal')
    
    {{-- Sistema de Notificaciones --}}
    @include('superlinkiu::stores.components.notifications')

    {{-- ================================================================ --}}
    {{-- HEADER Y ACCIONES PRINCIPALES --}}
    {{-- ================================================================ --}}
    
    @include('superlinkiu::stores.components.header')

    {{-- ================================================================ --}}
    {{-- FILTROS Y BÚSQUEDA --}}
    {{-- ================================================================ --}}
    
    @include('superlinkiu::stores.components.filters')

    {{-- ================================================================ --}}
    {{-- BARRA DE HERRAMIENTAS --}}
    {{-- ================================================================ --}}
    
    @include('superlinkiu::stores.components.toolbar')

    {{-- ================================================================ --}}
    {{-- CONTENIDO PRINCIPAL --}}
    {{-- ================================================================ --}}
    
    @if($viewType === 'table')
        @include('superlinkiu::stores.components.table-view')
    @else
        @include('superlinkiu::stores.components.cards-view')
    @endif

    {{-- ================================================================ --}}
    {{-- PAGINACIÓN --}}
    {{-- ================================================================ --}}
    
    @include('superlinkiu::stores.components.pagination')
</div>

{{-- ================================================================ --}}
{{-- SCRIPTS ESPECÍFICOS --}}
{{-- ================================================================ --}}

@push('scripts')
<script>
// Funciones helper específicas para la vista
function copyToClipboard(text) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(() => {
            try {
                if (window.Alpine && Alpine.store && Alpine.store('notifications')) {
                    Alpine.store('notifications').show('Contraseña copiada al portapapeles', 'success');
                } else {
                    alert('Contraseña copiada al portapapeles');
                }
            } catch (error) {
                alert('Contraseña copiada al portapapeles');
            }
        }).catch((error) => {
            // Fallback para navegadores que no soportan clipboard API
            fallbackCopy(text);
        });
    } else {
        fallbackCopy(text);
    }
}

function fallbackCopy(text) {
    try {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        textArea.style.top = '-999999px';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        alert('Contraseña copiada al portapapeles');
    } catch (error) {
        alert('Error al copiar. Selecciona y copia manualmente.');
    }
}

function copyCredentials() {
    const credentials = `
Tienda: {{ session('admin_credentials')['store_name'] ?? '' }}
URL: {{ session('admin_credentials')['store_slug'] ?? '' }}
Admin: {{ session('admin_credentials')['name'] ?? '' }}
Email: {{ session('admin_credentials')['email'] ?? '' }}
Contraseña: {{ session('admin_credentials')['password'] ?? '' }}
    `.trim();
    
    copyToClipboard(credentials);
}

// Toggle functionality

        document.addEventListener('change', function(e) {
    if (e.target.classList.contains('verified-toggle')) {
        const url = e.target.dataset.url;
        const originalChecked = e.target.checked;
        
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar todos los toggles de esta tienda en la página
                const storeId = e.target.dataset.storeId;
                const allToggles = document.querySelectorAll(`[data-store-id="${storeId}"].verified-toggle`);
                allToggles.forEach(toggle => {
                    toggle.checked = data.verified;
                });
                
                // Mostrar SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: data.message || 'Estado de verificación actualizado',
                    confirmButtonColor: '#00c76f',
                    confirmButtonText: 'OK',
                    timer: 2000,
                    timerProgressBar: true
                });
            } else {
                // Revertir el estado del toggle en caso de error
                e.target.checked = !originalChecked;
                
                // Mostrar error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Error al cambiar el estado',
                    confirmButtonColor: '#ed2e45',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            // Revertir el estado del toggle en caso de error de red
            e.target.checked = !originalChecked;
            
            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'No se pudo conectar con el servidor',
                confirmButtonColor: '#ed2e45',
                confirmButtonText: 'OK'
            });
        });
    }
});
</script>
@endpush
@endsection 