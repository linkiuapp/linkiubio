@extends('shared::layouts.admin')
@section('title', 'Crear Usuario')

@section('content')
<div class="flex-1 space-y-6">
    <!-- Header Section -->
    <div class="flex items-center gap-4">
        <a href="{{ route('superlinkiu.user-management.index') }}" 
           class="p-2 text-black-300 hover:text-black-400 hover:bg-accent-100 rounded-lg transition-colors">
            <x-solar-arrow-left-outline class="w-5 h-5" />
        </a>
        <div>
            <h1 class="text-3xl font-semibold text-black-400">Crear Nuevo Usuario</h1>
            <p class="text-black-300 mt-1">Agrega un nuevo usuario al sistema</p>
        </div>
    </div>

    <!-- Main Form -->
    <div class="max-w-3xl">
        <form action="{{ route('superlinkiu.user-management.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Main Content Card -->
            <div class="bg-accent-50 rounded-xl shadow-sm border border-accent-100 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-accent-100 bg-gradient-to-r from-accent-50 to-accent-100">
                    <h2 class="text-xl font-semibold text-black-500">Información del Usuario</h2>
                </div>

                <!-- Card Content -->
                <div class="p-6 space-y-6" x-data="{ role: '{{ old('role', 'user') }}' }">
                    <!-- Nombre y Email -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-semibold text-black-400">
                                Nombre Completo <span class="text-error-400">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name"
                                   value="{{ old('name') }}"
                                   class="w-full px-4 py-3 rounded-lg bg-accent-100 border border-accent-200 
                                          focus:ring-2 focus:ring-primary-200 focus:border-primary-200 transition-colors
                                          @error('name') border-error-200 focus:ring-error-200 @enderror"
                                   placeholder="Ej: Juan Pérez"
                                   required>
                            @error('name')
                                <p class="text-sm text-error-400 flex items-center gap-2">
                                    <x-solar-info-circle-outline class="w-4 h-4" />
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-semibold text-black-400">
                                Email <span class="text-error-400">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email"
                                   value="{{ old('email') }}"
                                   class="w-full px-4 py-3 rounded-lg bg-accent-100 border border-accent-200 
                                          focus:ring-2 focus:ring-primary-200 focus:border-primary-200 transition-colors
                                          @error('email') border-error-200 focus:ring-error-200 @enderror"
                                   placeholder="usuario@ejemplo.com"
                                   required>
                            @error('email')
                                <p class="text-sm text-error-400 flex items-center gap-2">
                                    <x-solar-info-circle-outline class="w-4 h-4" />
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Contraseña -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-black-400">
                            Contraseña <span class="text-error-400">*</span>
                        </label>
                        <input type="password" 
                               name="password" 
                               id="password"
                               class="w-full px-4 py-3 rounded-lg bg-accent-100 border border-accent-200 
                                      focus:ring-2 focus:ring-primary-200 focus:border-primary-200 transition-colors
                                      @error('password') border-error-200 focus:ring-error-200 @enderror"
                               placeholder="Mínimo 8 caracteres"
                               required>
                        @error('password')
                            <p class="text-sm text-error-400 flex items-center gap-2">
                                <x-solar-info-circle-outline class="w-4 h-4" />
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-black-300">
                            La contraseña debe tener al menos 8 caracteres
                        </p>
                    </div>

                    <!-- Rol -->
                    <div class="space-y-2">
                        <label for="role" class="block text-sm font-semibold text-black-400">
                            Rol <span class="text-error-400">*</span>
                        </label>
                        <select name="role" 
                                id="role"
                                x-model="role"
                                class="w-full px-4 py-3 rounded-lg bg-accent-100 border border-accent-200 
                                       focus:ring-2 focus:ring-primary-200 focus:border-primary-200 transition-colors
                                       @error('role') border-error-200 focus:ring-error-200 @enderror"
                                required>
                            <option value="user">Usuario</option>
                            <option value="store_admin">Store Admin</option>
                            <option value="super_admin">Super Admin</option>
                        </select>
                        @error('role')
                            <p class="text-sm text-error-400 flex items-center gap-2">
                                <x-solar-info-circle-outline class="w-4 h-4" />
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Tienda (solo si es Store Admin) -->
                    <div x-show="role === 'store_admin'" x-transition class="space-y-2">
                        <label for="store_id" class="block text-sm font-semibold text-black-400">
                            Tienda <span class="text-error-400">*</span>
                        </label>
                        <select name="store_id" 
                                id="store_id"
                                class="w-full px-4 py-3 rounded-lg bg-accent-100 border border-accent-200 
                                       focus:ring-2 focus:ring-primary-200 focus:border-primary-200 transition-colors
                                       @error('store_id') border-error-200 focus:ring-error-200 @enderror">
                            <option value="">Selecciona una tienda</option>
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>
                                    {{ $store->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('store_id')
                            <p class="text-sm text-error-400 flex items-center gap-2">
                                <x-solar-info-circle-outline class="w-4 h-4" />
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-black-300">
                            El usuario tendrá acceso completo a la administración de esta tienda
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between p-6 bg-accent-50 rounded-xl border border-accent-100">
                <a href="{{ route('superlinkiu.user-management.index') }}" 
                   class="btn-secondary flex items-center gap-2">
                    <x-solar-arrow-left-outline class="w-4 h-4" />
                    Cancelar
                </a>
                
                <button type="submit" class="btn-primary flex items-center gap-2">
                    <x-solar-user-plus-outline class="w-4 h-4" />
                    Crear Usuario
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

