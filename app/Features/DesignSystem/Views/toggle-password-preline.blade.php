@extends('design-system::layout')

@section('title', 'Toggle Password Preline UI')
@section('page-title', 'Toggle Password Components')
@section('page-description', 'Componentes de toggle password basados exactamente en Preline UI')

@section('content')

{{-- SECTION: Basic Usage --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Basic Usage
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">A basic usage of toggle password with clickable icon.</p>
    
    <x-toggle-password-basic 
        name="password"
        label="Contraseña"
        placeholder="Ingresa tu contraseña"
        value="12345qwerty"
    />
</div>

{{-- SECTION: Multi Toggle --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Multi Toggle
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">It can be used with multiple toggles.</p>
    
    <div x-data="{ 
        showPassword: false,
        init() {
            this.$nextTick(() => {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        },
        togglePassword() {
            this.showPassword = !this.showPassword;
            this.$nextTick(() => {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        }
    }" class="space-y-5">
        <div class="max-w-sm">
            <label for="toggle-password-new" class="block text-sm mb-2">Nueva contraseña</label>
            <div class="relative">
                <input 
                    id="toggle-password-new"
                    name="new_password"
                    :type="showPassword ? 'text' : 'password'"
                    placeholder="Ingresa nueva contraseña"
                    class="py-2.5 sm:py-3 ps-4 pe-10 block w-full border border-gray-400 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                >
                <button 
                    type="button" 
                    @click="togglePassword()"
                    class="absolute inset-y-0 end-0 flex items-center z-20 px-3 cursor-pointer text-gray-400 rounded-e-md focus:outline-hidden focus:text-blue-600"
                    aria-label="Mostrar/Ocultar contraseña"
                >
                    <i data-lucide="eye" x-show="!showPassword" class="shrink-0 size-3.5" x-init="$nextTick(() => { if (typeof lucide !== 'undefined') lucide.createIcons(); })"></i>
                    <i data-lucide="eye-off" x-show="showPassword" class="shrink-0 size-3.5" x-init="$nextTick(() => { if (typeof lucide !== 'undefined') lucide.createIcons(); })"></i>
                </button>
            </div>
        </div>
        
        <div class="max-w-sm mb-5">
            <label for="toggle-password-current" class="block text-sm mb-2">Contraseña actual</label>
            <div class="relative">
                <input 
                    id="toggle-password-current"
                    name="current_password"
                    :type="showPassword ? 'text' : 'password'"
                    placeholder="Ingresa contraseña actual"
                    value="12345qwerty"
                    class="py-2.5 sm:py-3 ps-4 pe-10 block w-full border border-gray-400 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                >
                <button 
                    type="button" 
                    @click="togglePassword()"
                    class="absolute inset-y-0 end-0 flex items-center z-20 px-3 cursor-pointer text-gray-400 rounded-e-md focus:outline-hidden focus:text-blue-600"
                    aria-label="Mostrar/Ocultar contraseña"
                >
                    <i data-lucide="eye" x-show="!showPassword" class="shrink-0 size-3.5" x-init="$nextTick(() => { if (typeof lucide !== 'undefined') lucide.createIcons(); })"></i>
                    <i data-lucide="eye-off" x-show="showPassword" class="shrink-0 size-3.5" x-init="$nextTick(() => { if (typeof lucide !== 'undefined') lucide.createIcons(); })"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

