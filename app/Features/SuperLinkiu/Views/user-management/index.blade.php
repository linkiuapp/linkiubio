@extends('shared::layouts.admin')
@section('title', 'Gestión de Usuarios')

@section('content')
<div class="flex-1 space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-black-400">Gestión de Usuarios</h1>
            <p class="text-black-300 mt-1">Administra los usuarios del sistema y sus roles</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.user-management.create') }}" class="btn-primary">
                <x-solar-add-circle-outline class="w-4 h-4 mr-2" />
                Nuevo Usuario
            </a>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Usuarios -->
        <div class="bg-accent-50 rounded-xl p-6 shadow-sm border border-accent-100">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-black-300 mb-1">Total de Usuarios</p>
                    <p class="text-2xl font-bold text-black-500">{{ $totalUsers }}</p>
                </div>
                <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                    <x-solar-users-group-rounded-outline class="w-6 h-6 text-primary-300" />
                </div>
            </div>
        </div>

        <!-- Super Admins -->
        <div class="bg-accent-50 rounded-xl p-6 shadow-sm border border-accent-100">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-black-300 mb-1">Super Admins</p>
                    <p class="text-2xl font-bold text-error-300">{{ $superAdmins }}</p>
                </div>
                <div class="w-12 h-12 bg-error-100 rounded-lg flex items-center justify-center">
                    <x-solar-shield-user-outline class="w-6 h-6 text-error-300" />
                </div>
            </div>
        </div>

        <!-- Store Admins -->
        <div class="bg-accent-50 rounded-xl p-6 shadow-sm border border-accent-100">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-black-300 mb-1">Store Admins</p>
                    <p class="text-2xl font-bold text-success-400">{{ $storeAdmins }}</p>
                </div>
                <div class="w-12 h-12 bg-success-100 rounded-lg flex items-center justify-center">
                    <x-solar-user-check-outline class="w-6 h-6 text-success-400" />
                </div>
            </div>
        </div>

        <!-- Usuarios Regulares -->
        <div class="bg-accent-50 rounded-xl p-6 shadow-sm border border-accent-100">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-black-300 mb-1">Usuarios</p>
                    <p class="text-2xl font-bold text-info-300">{{ $regularUsers }}</p>
                </div>
                <div class="w-12 h-12 bg-info-100 rounded-lg flex items-center justify-center">
                    <x-solar-user-outline class="w-6 h-6 text-info-300" />
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-accent-50 rounded-xl shadow-sm border border-accent-100 overflow-hidden">
        <!-- Filtros y búsqueda -->
        <div class="px-6 py-4 border-b border-accent-100 bg-accent-50">
            <form method="GET" class="flex gap-4">
                <!-- Búsqueda -->
                <div class="flex-1 relative">
                    <input type="text" 
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Buscar por nombre o email..."
                           class="w-full px-4 py-2.5 pl-10 rounded-lg border-2 border-accent-200 focus:border-primary-200 focus:ring-2 focus:ring-primary-100 transition-colors">
                    <x-solar-magnifer-outline class="w-5 h-5 absolute left-3 top-3 text-black-300" />
                </div>

                <!-- Filtro por rol -->
                <select name="role" 
                        class="px-4 py-2.5 rounded-lg border-2 border-accent-200 focus:border-primary-200 focus:ring-2 focus:ring-primary-100">
                    <option value="">Todos los roles</option>
                    <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="store_admin" {{ request('role') === 'store_admin' ? 'selected' : '' }}>Store Admin</option>
                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Usuario</option>
                </select>

                <button type="submit" class="btn-primary whitespace-nowrap">
                    Filtrar
                </button>

                @if(request()->hasAny(['search', 'role']))
                    <a href="{{ route('superlinkiu.user-management.index') }}" class="btn-outline-secondary whitespace-nowrap">
                        Limpiar
                    </a>
                @endif
            </form>
        </div>

        <!-- Tabla de usuarios -->
        @if($users->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-accent-100 border-b border-accent-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-black-400 uppercase tracking-wider">Usuario</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-black-400 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-black-400 uppercase tracking-wider">Rol</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-black-400 uppercase tracking-wider">Tienda</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-black-400 uppercase tracking-wider">Último acceso</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-black-400 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-accent-50 divide-y divide-accent-200">
                        @foreach($users as $user)
                            <tr class="hover:bg-accent-100 transition-colors">
                                <!-- Usuario -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img src="{{ $user->avatar_url }}" 
                                             alt="{{ $user->name }}" 
                                             class="w-10 h-10 rounded-full mr-3">
                                        <div>
                                            <div class="text-sm font-semibold text-black-400">{{ $user->name }}</div>
                                            <div class="text-xs text-black-300">ID: {{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Email -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-black-400">{{ $user->email }}</div>
                                </td>

                                <!-- Rol -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->role === 'super_admin')
                                        <span class="px-3 py-1 text-xs font-semibold bg-error-100 text-error-400 rounded-full flex items-center gap-1 w-fit">
                                            <x-solar-shield-user-outline class="w-3 h-3" />
                                            Super Admin
                                        </span>
                                    @elseif($user->role === 'store_admin')
                                        <span class="px-3 py-1 text-xs font-semibold bg-success-100 text-success-400 rounded-full flex items-center gap-1 w-fit">
                                            <x-solar-user-check-outline class="w-3 h-3" />
                                            Store Admin
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold bg-info-100 text-info-400 rounded-full flex items-center gap-1 w-fit">
                                            <x-solar-user-outline class="w-3 h-3" />
                                            Usuario
                                        </span>
                                    @endif
                                </td>

                                <!-- Tienda -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->store)
                                        <a href="{{ route('superlinkiu.stores.show', $user->store->id) }}" 
                                           class="text-sm text-primary-300 hover:text-primary-400 font-medium">
                                            {{ $user->store->name }}
                                        </a>
                                    @else
                                        <span class="text-sm text-black-300">-</span>
                                    @endif
                                </td>

                                <!-- Último acceso -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-black-300">
                                        {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Nunca' }}
                                    </div>
                                </td>

                                <!-- Acciones -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('superlinkiu.user-management.edit', $user->id) }}" 
                                           class="text-primary-300 hover:text-primary-400 p-2 hover:bg-primary-50 rounded-lg transition-colors"
                                           title="Editar">
                                            <x-solar-pen-2-outline class="w-4 h-4" />
                                        </a>

                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('superlinkiu.user-management.destroy', $user->id) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-error-300 hover:text-error-400 p-2 hover:bg-error-50 rounded-lg transition-colors"
                                                        title="Eliminar">
                                                    <x-solar-trash-bin-trash-outline class="w-4 h-4" />
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-accent-100 bg-accent-100">
                    {{ $users->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="p-12 text-center">
                <div class="w-20 h-20 bg-black-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <x-solar-users-group-rounded-outline class="w-10 h-10 text-black-300" />
                </div>
                <h3 class="text-lg font-semibold text-black-400 mb-2">No se encontraron usuarios</h3>
                <p class="text-black-300 mb-6">
                    @if(request()->hasAny(['search', 'role']))
                        Intenta con otros filtros de búsqueda
                    @else
                        Comienza creando el primer usuario del sistema
                    @endif
                </p>
                @if(!request()->hasAny(['search', 'role']))
                    <a href="{{ route('superlinkiu.user-management.create') }}" class="btn-primary">
                        <x-solar-add-circle-outline class="w-4 h-4 mr-2" />
                        Crear Primer Usuario
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection

