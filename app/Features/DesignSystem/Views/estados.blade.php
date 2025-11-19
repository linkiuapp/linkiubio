@extends('design-system::layout')

@section('title', 'Sistema de Estados')
@section('page-title', '🌓 Sistema de Estados y Contrastes')
@section('page-description', 'Reglas estandarizadas para estados interactivos y contraste de colores')

@section('content')

<!-- Alerta Importante -->
<div class="mb-8 bg-brandWarning-50 border-l-4 border-brandWarning-200 p-6 rounded-lg">
    <div class="flex items-start gap-3">
        <span class="text-2xl">⚠️</span>
        <div>
            <h3 class="body-lg-bold text-brandWarning-400 mb-2">Sistema Obligatorio</h3>
            <p class="body-small text-brandWarning-400">
                Todas las vistas nuevas DEBEN seguir este sistema de estados. Consulta siempre esta guía antes de implementar componentes interactivos.
            </p>
        </div>
    </div>
</div>

<!-- Convención de Tonos -->
<section class="mb-12">
    <h2 class="h3 text-brandNeutral-400 mb-6">📊 Convención de Tonos</h2>
    
    <div class="bg-white rounded-xl p-8 shadow-sm border border-brandNeutral-50">
        <div class="grid grid-cols-5 gap-4 mb-6">
            <div class="text-center">
                <div class="bg-brandPrimary-50 h-20 rounded-lg mb-2"></div>
                <p class="caption-strong text-brandNeutral-400">50</p>
                <p class="caption text-brandNeutral-200">Fondos suaves</p>
            </div>
            <div class="text-center">
                <div class="bg-brandPrimary-100 h-20 rounded-lg mb-2"></div>
                <p class="caption-strong text-brandNeutral-400">100</p>
                <p class="caption text-brandNeutral-200">Hover suaves</p>
            </div>
            <div class="text-center">
                <div class="bg-brandPrimary-200 h-20 rounded-lg mb-2"></div>
                <p class="caption-strong text-brandPrimary-200 bg-white px-2 py-1 rounded">200 ← BASE</p>
                <p class="caption text-brandNeutral-200">Color default</p>
            </div>
            <div class="text-center">
                <div class="bg-brandPrimary-300 h-20 rounded-lg mb-2"></div>
                <p class="caption-strong text-brandNeutral-400">300</p>
                <p class="caption text-brandNeutral-200">Hover</p>
            </div>
            <div class="text-center">
                <div class="bg-brandPrimary-400 h-20 rounded-lg mb-2"></div>
                <p class="caption-strong text-brandNeutral-400">400</p>
                <p class="caption text-brandNeutral-200">Active/Texto</p>
            </div>
        </div>

        <div class="pt-6 border-t border-brandNeutral-50">
            <h4 class="body-lg-bold text-brandNeutral-400 mb-3">Regla de Oro:</h4>
            <ul class="space-y-2 body-small text-brandNeutral-300">
                <li class="flex items-start gap-2">
                    <span>✅</span>
                    <span><strong>200</strong> es siempre el color base (default)</span>
                </li>
                <li class="flex items-start gap-2">
                    <span>✅</span>
                    <span><strong>300</strong> es siempre el hover (un tono más oscuro)</span>
                </li>
                <li class="flex items-start gap-2">
                    <span>✅</span>
                    <span><strong>400</strong> es siempre el active/pressed (dos tonos más oscuro)</span>
                </li>
            </ul>
        </div>
    </div>
</section>

<!-- Estados de Botones -->
<section class="mb-12">
    <h2 class="h3 text-brandNeutral-400 mb-6">🔘 Estados de Botones</h2>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Primary Button States -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-brandNeutral-50">
            <h3 class="body-lg-bold text-brandNeutral-400 mb-4">Primary Button</h3>
            
            <div class="space-y-4">
                <!-- Default -->
                <div>
                    <p class="caption text-brandNeutral-300 mb-2">Default (200)</p>
                    <button class="py-3 px-5 rounded-full bg-brandPrimary-200 text-brandWhite-50 body-small">
                        Default State
                    </button>
                    <code class="block mt-2 caption bg-brandNeutral-50 p-2 rounded">bg-brandPrimary-200 text-brandWhite-50</code>
                </div>

                <!-- Hover -->
                <div>
                    <p class="caption text-brandNeutral-300 mb-2">Hover (300)</p>
                    <button class="py-3 px-5 rounded-full bg-brandPrimary-300 text-brandWhite-50 body-small">
                        Hover State
                    </button>
                    <code class="block mt-2 caption bg-brandNeutral-50 p-2 rounded">hover:bg-brandPrimary-300</code>
                </div>

                <!-- Active -->
                <div>
                    <p class="caption text-brandNeutral-300 mb-2">Active/Pressed (400)</p>
                    <button class="py-3 px-5 rounded-full bg-brandPrimary-400 text-brandWhite-50 body-small">
                        Active State
                    </button>
                    <code class="block mt-2 caption bg-brandNeutral-50 p-2 rounded">active:bg-brandPrimary-400</code>
                </div>

                <!-- Disabled -->
                <div>
                    <p class="caption text-brandNeutral-300 mb-2">Disabled (200 + opacity-50)</p>
                    <button disabled class="py-3 px-5 rounded-full bg-brandPrimary-200 text-brandWhite-50 body-small opacity-50 cursor-not-allowed">
                        Disabled State
                    </button>
                    <code class="block mt-2 caption bg-brandNeutral-50 p-2 rounded">opacity-50 cursor-not-allowed</code>
                </div>
            </div>

            <!-- Código Completo -->
            <details class="mt-6 pt-6 border-t border-brandNeutral-50">
                <summary class="caption-strong text-brandPrimary-200 cursor-pointer">Ver código completo →</summary>
                <pre class="mt-3 bg-brandNeutral-50 p-4 rounded caption overflow-x-auto"><code>&lt;button class="py-3 px-5 rounded-full 
        bg-brandPrimary-200 
        hover:bg-brandPrimary-300 
        active:bg-brandPrimary-400 
        text-brandWhite-50
        body-small
        disabled:opacity-50 
        disabled:cursor-not-allowed"&gt;
    Button
&lt;/button&gt;</code></pre>
            </details>
        </div>

        <!-- Success Button States -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-brandNeutral-50">
            <h3 class="body-lg-bold text-brandNeutral-400 mb-4">Success Button</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="caption text-brandNeutral-300 mb-2">Default (200)</p>
                    <button class="py-3 px-5 rounded-full bg-brandSuccess-200 text-brandWhite-50 body-small">
                        Guardar Cambios
                    </button>
                </div>
                <div>
                    <p class="caption text-brandNeutral-300 mb-2">Hover (300)</p>
                    <button class="py-3 px-5 rounded-full bg-brandSuccess-300 text-brandWhite-50 body-small">
                        Guardar Cambios
                    </button>
                </div>
                <div>
                    <p class="caption text-brandNeutral-300 mb-2">Active (400)</p>
                    <button class="py-3 px-5 rounded-full bg-brandSuccess-400 text-brandWhite-50 body-small">
                        Guardar Cambios
                    </button>
                </div>
                <div>
                    <p class="caption text-brandNeutral-300 mb-2">Disabled</p>
                    <button disabled class="py-3 px-5 rounded-full bg-brandSuccess-200 text-brandWhite-50 body-small opacity-50 cursor-not-allowed">
                        Guardar Cambios
                    </button>
                </div>
            </div>
        </div>

        <!-- Error Button States -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-brandNeutral-50">
            <h3 class="body-lg-bold text-brandNeutral-400 mb-4">Error Button (Destructivo)</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="caption text-brandNeutral-300 mb-2">Default (200)</p>
                    <button class="py-3 px-5 rounded-full bg-brandError-200 text-brandWhite-50 body-small">
                        Eliminar
                    </button>
                </div>
                <div>
                    <p class="caption text-brandNeutral-300 mb-2">Hover (300)</p>
                    <button class="py-3 px-5 rounded-full bg-brandError-300 text-brandWhite-50 body-small">
                        Eliminar
                    </button>
                </div>
                <div>
                    <p class="caption text-brandNeutral-300 mb-2">Active (400)</p>
                    <button class="py-3 px-5 rounded-full bg-brandError-400 text-brandWhite-50 body-small">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>

        <!-- Warning Button States -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-brandNeutral-50">
            <h3 class="body-lg-bold text-brandNeutral-400 mb-4">Warning Button</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="caption text-brandNeutral-300 mb-2">Default (200)</p>
                    <button class="py-3 px-5 rounded-full bg-brandWarning-200 text-brandWhite-50 body-small">
                        Advertencia
                    </button>
                </div>
                <div>
                    <p class="caption text-brandNeutral-300 mb-2">Hover (300)</p>
                    <button class="py-3 px-5 rounded-full bg-brandWarning-300 text-brandWhite-50 body-small">
                        Advertencia
                    </button>
                </div>
                <div>
                    <p class="caption text-brandNeutral-300 mb-2">Active (400)</p>
                    <button class="py-3 px-5 rounded-full bg-brandWarning-400 text-brandWhite-50 body-small">
                        Advertencia
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Fondos Claros y Cards -->
<section class="mb-12">
    <h2 class="h3 text-brandNeutral-400 mb-6">📄 Fondos Claros (Cards, Badges, Alerts)</h2>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach([
            ['color' => 'Info', 'emoji' => 'ℹ️'],
            ['color' => 'Success', 'emoji' => '✅'],
            ['color' => 'Warning', 'emoji' => '⚠️'],
            ['color' => 'Error', 'emoji' => '❌']
        ] as $variant)
        <div class="bg-white rounded-xl p-6 shadow-sm border border-brandNeutral-50">
            <h3 class="body-lg-bold text-brandNeutral-400 mb-4">{{ $variant['emoji'] }} {{ $variant['color'] }}</h3>
            
            <div class="space-y-4">
                <!-- Fondo 50 con texto 400 -->
                <div class="bg-brand{{ $variant['color'] }}-50 border border-brand{{ $variant['color'] }}-200 p-4 rounded-lg">
                    <p class="body-small text-brand{{ $variant['color'] }}-400">
                        <strong>Fondo 50 + Texto 400:</strong> Este es el uso correcto para fondos suaves con buen contraste.
                    </p>
                    <code class="caption block mt-2">bg-brand{{ $variant['color'] }}-50 text-brand{{ $variant['color'] }}-400</code>
                </div>

                <!-- Hover: Fondo 100 -->
                <div class="bg-brand{{ $variant['color'] }}-100 border border-brand{{ $variant['color'] }}-200 p-4 rounded-lg">
                    <p class="body-small text-brand{{ $variant['color'] }}-400">
                        <strong>Hover (Fondo 100):</strong> Un tono más oscuro para interacciones.
                    </p>
                    <code class="caption block mt-2">hover:bg-brand{{ $variant['color'] }}-100</code>
                </div>

                <!-- Selected: Fondo 200 con texto brandWhite-50 -->
                <div class="bg-brand{{ $variant['color'] }}-200 border border-brand{{ $variant['color'] }}-200 p-4 rounded-lg">
                    <p class="body-small text-brandWhite-50">
                        <strong>Selected/Active (Fondo 200):</strong> Color base con texto brandWhite-50.
                    </p>
                    <code class="caption block mt-2 bg-white/20 rounded px-2 py-1">bg-brand{{ $variant['color'] }}-200 text-brandWhite-50</code>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- Contraste de Texto -->
<section class="mb-12">
    <h2 class="h3 text-brandNeutral-400 mb-6">📝 Reglas de Contraste de Texto</h2>
    
    <div class="bg-white rounded-xl p-8 shadow-sm border border-brandNeutral-50">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Texto brandWhite-50 -->
            <div>
                <h3 class="body-lg-bold text-brandNeutral-400 mb-4">✅ Siempre usar text-brandWhite-50 sobre:</h3>
                <div class="space-y-3">
                    <div class="bg-brandPrimary-200 p-4 rounded-full">
                        <p class="text-brandWhite-50 body-small">Tonos 200 (color base)</p>
                    </div>
                    <div class="bg-brandPrimary-300 p-4 rounded-full">
                        <p class="text-brandWhite-50 body-small">Tonos 300 (hover)</p>
                    </div>
                    <div class="bg-brandPrimary-400 p-4 rounded-full">
                        <p class="text-brandWhite-50 body-small">Tonos 400 (active)</p>
                    </div>
                </div>
            </div>

            <!-- Texto Oscuro -->
            <div>
                <h3 class="body-lg-bold text-brandNeutral-400 mb-4">✅ Siempre usar texto oscuro (400) sobre:</h3>
                <div class="space-y-3">
                    <div class="bg-brandPrimary-50 border border-brandPrimary-200 p-4 rounded-lg">
                        <p class="text-brandPrimary-400 body-small">Tonos 50 (fondos suaves)</p>
                    </div>
                    <div class="bg-brandPrimary-100 border border-brandPrimary-200 p-4 rounded-lg">
                        <p class="text-brandPrimary-400 body-small">Tonos 100 (hover suaves)</p>
                    </div>
                    <div class="bg-white border border-brandNeutral-200 p-4 rounded-lg">
                        <p class="text-brandNeutral-400 body-small">Fondos blancos</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ejemplos Incorrectos -->
        <div class="mt-8 pt-8 border-t border-brandNeutral-50">
            <h3 class="body-lg-bold text-brandError-400 mb-4">❌ Ejemplos INCORRECTOS (No usar)</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-brandPrimary-50 p-4 rounded-lg border-2 border-brandError-200">
                    <p class="text-brandPrimary-200 body-small">❌ Texto 200 sobre fondo 50 (bajo contraste)</p>
                </div>
                <div class="bg-white p-4 rounded-lg border-2 border-brandError-200">
                    <p class="text-brandNeutral-100 body-small">❌ Texto 100 sobre blanco (muy claro)</p>
                </div>
                <div class="bg-brandPrimary-300 p-4 rounded-lg border-2 border-brandError-200">
                    <p class="text-brandPrimary-400 body-small">❌ Texto oscuro sobre fondo oscuro</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cheat Sheet -->
<section class="mb-12">
    <h2 class="h3 text-brandNeutral-400 mb-6">⚡ Cheat Sheet de Referencia Rápida</h2>
    
    <div class="bg-brandNeutral-400 text-white rounded-xl p-8 shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Botones -->
            <div>
                <h3 class="body-lg-bold mb-3">🔘 Botones</h3>
                <div class="space-y-1 caption font-mono">
                    <p>Size: py-3 px-5</p>
                    <p>Border: rounded-full</p>
                    <p>BG: bg-{color}-200</p>
                    <p>Hover: hover:bg-{color}-300</p>
                    <p>Active: active:bg-{color}-400</p>
                    <p>Text: text-brandWhite-50</p>
                    <p>Disabled: opacity-50</p>
                </div>
            </div>

            <!-- Cards -->
            <div>
                <h3 class="body-lg-bold mb-3">📄 Cards/Fondos</h3>
                <div class="space-y-1 caption font-mono">
                    <p>BG: bg-{color}-50</p>
                    <p>Hover: hover:bg-{color}-100</p>
                    <p>Border: border-{color}-200</p>
                    <p>Text: text-{color}-400</p>
                </div>
            </div>

            <!-- Badges -->
            <div>
                <h3 class="body-lg-bold mb-3">🏷️ Badges</h3>
                <div class="space-y-1 caption font-mono">
                    <p>BG: bg-{color}-50</p>
                    <p>Border: border-{color}-200</p>
                    <p>Text: text-{color}-400</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

