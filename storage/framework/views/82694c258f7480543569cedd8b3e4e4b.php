<?php $__env->startSection('title', 'Gestión de Tiendas'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid" x-data="storeManagement">
    
    
    
    
    
    <?php echo $__env->make('superlinkiu::stores.components.delete-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    
    <?php echo $__env->make('superlinkiu::stores.components.success-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    
    <?php echo $__env->make('superlinkiu::stores.components.notifications', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    
    
    
    <?php echo $__env->make('superlinkiu::stores.components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    
    
    
    <?php echo $__env->make('superlinkiu::stores.components.filters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    
    
    
    <?php echo $__env->make('superlinkiu::stores.components.toolbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    
    
    
    <?php if($viewType === 'table'): ?>
        <?php echo $__env->make('superlinkiu::stores.components.table-view', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php else: ?>
        <?php echo $__env->make('superlinkiu::stores.components.cards-view', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    
    
    
    
    <?php echo $__env->make('superlinkiu::stores.components.pagination', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>





<?php $__env->startPush('scripts'); ?>
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
Tienda: <?php echo e(session('admin_credentials')['store_name'] ?? ''); ?>

URL: <?php echo e(session('admin_credentials')['store_slug'] ?? ''); ?>

Admin: <?php echo e(session('admin_credentials')['name'] ?? ''); ?>

Email: <?php echo e(session('admin_credentials')['email'] ?? ''); ?>

Contraseña: <?php echo e(session('admin_credentials')['password'] ?? ''); ?>

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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('shared::layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Liniu_Final\app\Features\SuperLinkiu/Views/stores/index.blade.php ENDPATH**/ ?>