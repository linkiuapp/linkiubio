{{--
Toggle Password Multi - Múltiples inputs de contraseña con toggle compartido
Uso: Múltiples inputs de contraseña que comparten el mismo toggle para mostrar/ocultar
Cuándo usar: Cuando tengas múltiples campos de contraseña (ej: contraseña actual y nueva) y quieras que compartan el toggle
Cuándo NO usar: Cuando cada campo necesite su propio toggle independiente
Ejemplo: 
<x-toggle-password-multi>
    <x-slot:inputs>
        <x-toggle-password-input name="current_password" label="Contraseña actual" />
        <x-toggle-password-input name="new_password" label="Nueva contraseña" />
    </x-slot:inputs>
</x-toggle-password-multi>
--}}

@props([
    'maxWidth' => 'max-w-sm',
])

<div class="space-y-5" x-data="{ showPassword: false }">
    {{ $inputs ?? $slot }}
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        
        // Re-inicializar iconos cuando cambie el estado
        document.addEventListener('alpine:updated', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    });
</script>
@endpush















