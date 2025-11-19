@extends('design-system::layout')

@section('title', 'Iconos')
@section('page-title', '🎭 Sistema de Iconos')
@section('page-description', 'Tamaños estandarizados y mejores prácticas para iconos (Lucide)')

@section('content')

<!-- Alerta -->
<div class="mb-8 bg-brandInfo-50 border-l-4 border-brandInfo-200 p-6 rounded-lg">
    <div class="flex items-start gap-3">
        <span class="text-2xl">ℹ️</span>
        <div>
            <h3 class="body-lg-bold text-brandInfo-400 mb-2">Solo Lucide Icons</h3>
            <p class="body-small text-brandInfo-400">
                Todos los iconos del sistema deben ser de <strong>Lucide</strong>. No usar otros sets de iconos para mantener consistencia visual.
                Docs: <a href="https://lucide.dev" target="_blank" class="underline">lucide.dev</a>
            </p>
        </div>
    </div>
</div>

<!-- Tamaños por Contexto -->
<section class="mb-12">
    <h2 class="h3 text-brandNeutral-400 mb-6">📏 Tamaños por Contexto</h2>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach($iconSizes['contexts'] as $context)
        <div class="bg-white rounded-xl p-6 shadow-sm border border-brandNeutral-50">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="body-lg-bold text-brandNeutral-400">{{ $context['label'] }} - {{ $context['px'] }}</h3>
                    <p class="caption text-brandNeutral-200 mt-1">{{ $context['uso'] }}</p>
                </div>
                <code class="caption bg-brandPrimary-50 text-brandPrimary-300 px-3 py-1 rounded">{{ $context['size'] }}</code>
            </div>

            <!-- Ejemplo Visual -->
            <div class="flex items-center gap-6 p-4 bg-brandNeutral-50 rounded-lg">
                <i data-lucide="check-circle" class="{{ $context['size'] }} text-brandSuccess-300"></i>
                <i data-lucide="alert-circle" class="{{ $context['size'] }} text-brandWarning-300"></i>
                <i data-lucide="x-circle" class="{{ $context['size'] }} text-brandError-300"></i>
                <i data-lucide="info" class="{{ $context['size'] }} text-brandInfo-300"></i>
                <i data-lucide="star" class="{{ $context['size'] }} text-brandSecondary-300"></i>
            </div>

            <!-- Código -->
            <details class="mt-4 pt-4 border-t border-brandNeutral-50">
                <summary class="caption-strong text-brandPrimary-200 cursor-pointer">Ver código →</summary>
                <pre class="mt-3 bg-brandNeutral-50 p-3 rounded caption overflow-x-auto"><code>&lt;i data-lucide="check-circle" class="{{ $context['size'] }} text-brandSuccess-300"&gt;&lt;/i&gt;</code></pre>
            </details>
        </div>
        @endforeach
    </div>
</section>

<!-- Tamaños Recomendados por Dispositivo -->
<section class="mb-12">
    <h2 class="h3 text-brandNeutral-400 mb-6">📱 Tamaños por Dispositivo</h2>
    
    <!-- Mobile -->
    <div class="mb-8 bg-white rounded-xl p-6 shadow-sm border border-brandNeutral-50">
        <div class="flex items-center gap-3 mb-6">
            <span class="text-2xl">📱</span>
            <div>
                <h3 class="body-lg-bold text-brandNeutral-400">{{ $iconSizes['devices']['mobile']['name'] }}</h3>
                <p class="caption text-brandNeutral-200">Priorizar touch targets grandes y legibilidad</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Tamaño Mínimo Touch -->
            <div class="p-4 bg-brandInfo-50 border border-brandInfo-200 rounded-lg">
                <p class="caption-strong text-brandInfo-400 mb-3">Touch Target Mínimo</p>
                <div class="flex items-center justify-center p-6 bg-white rounded-lg">
                    <div class="{{ $iconSizes['devices']['mobile']['minTouch'] }} flex items-center justify-center bg-brandPrimary-200 rounded-lg">
                        <i data-lucide="home" class="w-5 h-5 text-brandWhite-50"></i>
                    </div>
                </div>
                <code class="caption block text-center mt-3">{{ $iconSizes['devices']['mobile']['minTouch'] }}</code>
                <p class="caption text-brandInfo-300 text-center mt-2">44px × 44px mínimo (Apple HIG)</p>
            </div>

            <!-- Recomendados -->
            <div class="p-4 bg-brandSuccess-50 border border-brandSuccess-200 rounded-lg">
                <p class="caption-strong text-brandSuccess-400 mb-3">✅ Recomendados</p>
                <div class="flex flex-col gap-4">
                    @foreach($iconSizes['devices']['mobile']['recommended'] as $size)
                    <div class="flex items-center gap-3 bg-white p-3 rounded">
                        <i data-lucide="check" class="{{ $size }} text-brandSuccess-300"></i>
                        <code class="caption">{{ $size }}</code>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Evitar -->
            @if(count($iconSizes['devices']['mobile']['avoid']) > 0)
            <div class="p-4 bg-brandError-50 border border-brandError-200 rounded-lg">
                <p class="caption-strong text-brandError-400 mb-3">❌ Evitar</p>
                <div class="flex flex-col gap-4">
                    @foreach($iconSizes['devices']['mobile']['avoid'] as $size)
                    <div class="flex items-center gap-3 bg-white p-3 rounded">
                        <i data-lucide="x" class="{{ $size }} text-brandError-300"></i>
                        <code class="caption">{{ $size }}</code>
                        <p class="caption text-brandError-300">Muy pequeño</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Tablet -->
    <div class="mb-8 bg-white rounded-xl p-6 shadow-sm border border-brandNeutral-50">
        <div class="flex items-center gap-3 mb-6">
            <span class="text-2xl">📱</span>
            <div>
                <h3 class="body-lg-bold text-brandNeutral-400">{{ $iconSizes['devices']['tablet']['name'] }}</h3>
                <p class="caption text-brandNeutral-200">Balance entre mobile y desktop</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Touch Target -->
            <div class="p-4 bg-brandInfo-50 border border-brandInfo-200 rounded-lg">
                <p class="caption-strong text-brandInfo-400 mb-3">Touch Target Mínimo</p>
                <div class="flex items-center justify-center p-6 bg-white rounded-lg">
                    <div class="{{ $iconSizes['devices']['tablet']['minTouch'] }} flex items-center justify-center bg-brandPrimary-200 rounded-lg">
                        <i data-lucide="home" class="w-5 h-5 text-brandWhite-50"></i>
                    </div>
                </div>
                <code class="caption block text-center mt-3">{{ $iconSizes['devices']['tablet']['minTouch'] }}</code>
            </div>

            <!-- Recomendados -->
            <div class="p-4 bg-brandSuccess-50 border border-brandSuccess-200 rounded-lg">
                <p class="caption-strong text-brandSuccess-400 mb-3">✅ Recomendados</p>
                <div class="flex flex-col gap-4">
                    @foreach($iconSizes['devices']['tablet']['recommended'] as $size)
                    <div class="flex items-center gap-3 bg-white p-3 rounded">
                        <i data-lucide="check" class="{{ $size }} text-brandSuccess-300"></i>
                        <code class="caption">{{ $size }}</code>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-brandNeutral-50">
        <div class="flex items-center gap-3 mb-6">
            <span class="text-2xl">🖥️</span>
            <div>
                <h3 class="body-lg-bold text-brandNeutral-400">{{ $iconSizes['devices']['desktop']['name'] }}</h3>
                <p class="caption text-brandNeutral-200">Más flexibilidad, pero mantener legibilidad</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Click Target -->
            <div class="p-4 bg-brandInfo-50 border border-brandInfo-200 rounded-lg">
                <p class="caption-strong text-brandInfo-400 mb-3">Click Target Mínimo</p>
                <div class="flex items-center justify-center p-6 bg-white rounded-lg">
                    <div class="{{ $iconSizes['devices']['desktop']['minTouch'] }} flex items-center justify-center bg-brandPrimary-200 rounded-lg">
                        <i data-lucide="home" class="w-4 h-4 text-brandWhite-50"></i>
                    </div>
                </div>
                <code class="caption block text-center mt-3">{{ $iconSizes['devices']['desktop']['minTouch'] }}</code>
            </div>

            <!-- Recomendados -->
            <div class="p-4 bg-brandSuccess-50 border border-brandSuccess-200 rounded-lg">
                <p class="caption-strong text-brandSuccess-400 mb-3">✅ Recomendados</p>
                <div class="flex flex-col gap-4">
                    @foreach($iconSizes['devices']['desktop']['recommended'] as $size)
                    <div class="flex items-center gap-3 bg-white p-3 rounded">
                        <i data-lucide="check" class="{{ $size }} text-brandSuccess-300"></i>
                        <code class="caption">{{ $size }}</code>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Ejemplos en Contexto -->
<section class="mb-12">
    <h2 class="h3 text-brandNeutral-400 mb-6">🎯 Ejemplos en Contexto</h2>
    
    <div class="space-y-6">
        <!-- Botones -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-brandNeutral-50">
            <h3 class="body-lg-bold text-brandNeutral-400 mb-4">En Botones</h3>
            <div class="flex flex-wrap gap-4">
                <button class="flex items-center gap-2 py-2 px-4 rounded-full bg-brandPrimary-200 hover:bg-brandPrimary-300 text-brandWhite-50 caption transition-all duration-200 shadow-sm hover:shadow-md">
                    <i data-lucide="plus" class="w-3 h-3"></i>
                    Small Button
                </button>
                <button class="flex items-center gap-2 py-3 px-5 rounded-full bg-brandPrimary-200 hover:bg-brandPrimary-300 text-brandWhite-50 body-small transition-all duration-200 shadow-sm hover:shadow-md">
                    <i data-lucide="check" class="w-5 h-5"></i>
                    Medium Button
                </button>
                <button class="flex items-center gap-2 py-4 px-6 rounded-full bg-brandPrimary-200 hover:bg-brandPrimary-300 text-brandWhite-50 body-lg-medium transition-all duration-200 shadow-sm hover:shadow-md">
                    <i data-lucide="save" class="w-6 h-6"></i>
                    Large Button
                </button>
            </div>
            <code class="caption block mt-4 bg-brandNeutral-50 p-3 rounded">SM: w-3 h-3 | MD: w-5 h-5 | LG: w-6 h-6</code>
        </div>

        <!-- Inputs -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-brandNeutral-50">
            <h3 class="body-lg-bold text-brandNeutral-400 mb-4">En Inputs</h3>
            <div class="space-y-4">
                <div class="relative">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2">
                        <i data-lucide="search" class="w-5 h-5 text-brandNeutral-300"></i>
                    </div>
                    <input type="text" placeholder="Buscar..." class="w-full pl-10 pr-4 py-3 border border-brandNeutral-200 rounded-lg body-small focus:border-brandPrimary-200 focus:ring-2 focus:ring-brandPrimary-200">
                </div>
            </div>
            <code class="caption block mt-4 bg-brandNeutral-50 p-3 rounded">Inputs: w-5 h-5 (20px)</code>
        </div>

        <!-- Navegación -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-brandNeutral-50">
            <h3 class="body-lg-bold text-brandNeutral-400 mb-4">En Navegación</h3>
            <nav class="flex gap-2">
                <a href="#" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-brandPrimary-50 text-brandPrimary-400 body-small">
                    <i data-lucide="home" class="w-5 h-5"></i>
                    Inicio
                </a>
                <a href="#" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-brandNeutral-50 text-brandNeutral-300 body-small">
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                    Pedidos
                </a>
                <a href="#" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-brandNeutral-50 text-brandNeutral-300 body-small">
                    <i data-lucide="settings" class="w-5 h-5"></i>
                    Configuración
                </a>
            </nav>
            <code class="caption block mt-4 bg-brandNeutral-50 p-3 rounded">Navegación: w-5 h-5 (20px)</code>
        </div>

        <!-- Badges -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-brandNeutral-50">
            <h3 class="body-lg-bold text-brandNeutral-400 mb-4">En Badges y Tags</h3>
            <div class="flex flex-wrap gap-3">
                <span class="inline-flex items-center gap-1.5 bg-brandSuccess-50 text-brandSuccess-400 border border-brandSuccess-200 px-3 py-1 rounded-full caption">
                    <i data-lucide="check" class="w-3 h-3"></i>
                    Activo
                </span>
                <span class="inline-flex items-center gap-1.5 bg-brandWarning-50 text-brandWarning-400 border border-brandWarning-200 px-3 py-1 rounded-full caption">
                    <i data-lucide="clock" class="w-3 h-3"></i>
                    Pendiente
                </span>
                <span class="inline-flex items-center gap-1.5 bg-brandError-50 text-brandError-400 border border-brandError-200 px-3 py-1 rounded-full caption">
                    <i data-lucide="x" class="w-3 h-3"></i>
                    Inactivo
                </span>
            </div>
            <code class="caption block mt-4 bg-brandNeutral-50 p-3 rounded">Badges: w-3 h-3 (12px)</code>
        </div>
    </div>
</section>

<!-- Reglas de Uso -->
<section class="mb-12">
    <h2 class="h3 text-brandNeutral-400 mb-6">📖 Reglas de Uso</h2>
    
    <div class="bg-white rounded-xl p-6 shadow-sm border border-brandNeutral-50">
        <div class="space-y-4">
            <div class="flex items-start gap-3">
                <span class="text-xl flex-shrink-0">✅</span>
                <div>
                    <p class="body-lg-medium text-brandNeutral-400">Mantener proporción del contenedor</p>
                    <p class="body-small text-brandNeutral-200">El icono debe alinearse verticalmente con el texto adyacente</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="text-xl flex-shrink-0">✅</span>
                <div>
                    <p class="body-lg-medium text-brandNeutral-400">Usar w-5 h-5 como default</p>
                    <p class="body-small text-brandNeutral-200">20px es el tamaño estándar para la mayoría de contextos</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="text-xl flex-shrink-0">✅</span>
                <div>
                    <p class="body-lg-medium text-brandNeutral-400">Mantener consistencia en secciones</p>
                    <p class="body-small text-brandNeutral-200">Todos los iconos de una misma sección deben tener el mismo tamaño</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="text-xl flex-shrink-0">✅</span>
                <div>
                    <p class="body-lg-medium text-brandNeutral-400">Touch targets mínimos en mobile</p>
                    <p class="body-small text-brandNeutral-200">Botones con iconos deben ser mínimo w-10 h-10 (40px) en mobile</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="text-xl flex-shrink-0">❌</span>
                <div>
                    <p class="body-lg-medium text-brandNeutral-400">No usar iconos muy pequeños en mobile</p>
                    <p class="body-small text-brandNeutral-200">w-3 h-3 es difícil de ver y tocar en dispositivos táctiles</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <span class="text-xl flex-shrink-0">❌</span>
                <div>
                    <p class="body-lg-medium text-brandNeutral-400">No mezclar tamaños sin razón</p>
                    <p class="body-small text-brandNeutral-200">Cada cambio de tamaño debe tener un propósito claro</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cheat Sheet -->
<section class="mb-12">
    <h2 class="h3 text-brandNeutral-400 mb-6">⚡ Cheat Sheet</h2>
    
    <div class="bg-brandNeutral-400 text-white rounded-xl p-8 shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div>
                <h3 class="body-lg-bold mb-3">🔘 En Botones</h3>
                <div class="space-y-1 caption font-mono">
                    <p>Small: w-4 h-4</p>
                    <p>Medium: w-5 h-5 ← DEFAULT</p>
                    <p>Large: w-6 h-6</p>
                </div>
            </div>
            <div>
                <h3 class="body-lg-bold mb-3">📝 En Inputs</h3>
                <div class="space-y-1 caption font-mono">
                    <p>Default: w-5 h-5</p>
                    <p>Color: text-brandNeutral-300</p>
                </div>
            </div>
            <div>
                <h3 class="body-lg-bold mb-3">🏷️ En Badges</h3>
                <div class="space-y-1 caption font-mono">
                    <p>Default: w-3 h-3</p>
                    <p>Large: w-4 h-4</p>
                </div>
            </div>
            <div>
                <h3 class="body-lg-bold mb-3">🧭 En Navegación</h3>
                <div class="space-y-1 caption font-mono">
                    <p>Default: w-5 h-5</p>
                    <p>Sidebar: w-5 h-5</p>
                </div>
            </div>
            <div>
                <h3 class="body-lg-bold mb-3">📱 Mobile</h3>
                <div class="space-y-1 caption font-mono">
                    <p>Min Touch: w-10 h-10</p>
                    <p>Recommended: w-5 h-5, w-6 h-6</p>
                </div>
            </div>
            <div>
                <h3 class="body-lg-bold mb-3">🖥️ Desktop</h3>
                <div class="space-y-1 caption font-mono">
                    <p>Min Click: w-6 h-6</p>
                    <p>Recommended: w-4 h-4, w-5 h-5</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

