<x-tenant-admin-layout :store="$store">
    @section('title', 'Mi Perfil')
    @section('subtitle', 'Gestiona tu información y seguridad')

    @section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        
        <!-- Información del Usuario -->
        <div class="bg-accent-50 rounded-lg p-6 border border-accent-200">
            <h2 class="text-lg font-semibold text-black-500 mb-4">Información Personal</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-black-300 mb-1">Nombre</label>
                    <p class="text-black-500 font-medium">{{ $user->name }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-black-300 mb-1">Email</label>
                    <p class="text-black-500 font-medium">{{ $user->email }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-black-300 mb-1">Tienda</label>
                    <p class="text-black-500 font-medium">{{ $store->name }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-black-300 mb-1">Último acceso</label>
                    <p class="text-black-300">
                        {{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Nunca' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Cambiar Contraseña -->
        <div class="bg-accent-50 rounded-lg p-6 border border-accent-200">
            <h2 class="text-lg font-semibold text-black-500 mb-4">🔐 Cambiar Contraseña</h2>
            
            <form method="POST" action="{{ route('tenant.admin.profile.change-password', ['store' => $store->slug]) }}">
                @csrf
                
                <div class="space-y-4">
                    <!-- Contraseña Actual -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-black-300 mb-2">
                            Contraseña Actual <span class="text-error-300">*</span>
                        </label>
                        <input type="password" 
                               id="current_password" 
                               name="current_password" 
                               class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none @error('current_password') border-error-200 @enderror"
                               required>
                        @error('current_password')
                            <p class="text-xs text-error-300 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nueva Contraseña -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-black-300 mb-2">
                            Nueva Contraseña <span class="text-error-300">*</span>
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none @error('password') border-error-200 @enderror"
                               required>
                        <p class="text-xs text-black-300 mt-1">Mínimo 8 caracteres, debe incluir letras y números</p>
                        @error('password')
                            <p class="text-xs text-error-300 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirmar Nueva Contraseña -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-black-300 mb-2">
                            Confirmar Nueva Contraseña <span class="text-error-300">*</span>
                        </label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none"
                               required>
                    </div>

                    <!-- Botón -->
                    <div class="pt-2">
                        <button type="submit" 
                                class="bg-primary-300 hover:bg-primary-200 text-accent-50 px-6 py-2 rounded-lg font-medium transition-colors">
                            <i class="fas fa-key mr-2"></i> Cambiar Contraseña
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
    @endsection
</x-tenant-admin-layout>



