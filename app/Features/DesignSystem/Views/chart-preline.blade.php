@extends('design-system::layout')

@section('title', 'Chart Preline UI')
@section('page-title', 'Chart Components')
@section('page-description', 'Componentes de gráficos basados en Preline UI (requieren ApexCharts)')

@section('content')

{{-- SECTION: Documentation --}}
<div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-8">
    <h4 class="h4 text-yellow-800 mb-4">⚠️ Requisitos</h4>
    <p class="body-small text-yellow-700 mb-4">
        Los componentes de gráficos requieren <strong>ApexCharts</strong> para funcionar. Para implementarlos:
    </p>
    <ol class="list-decimal list-inside space-y-2 body-small text-yellow-700">
        <li>Instalar ApexCharts: <code class="bg-yellow-100 px-2 py-1 rounded">npm i apexcharts</code></li>
        <li>Incluir CSS: <code class="bg-yellow-100 px-2 py-1 rounded">&lt;link rel="stylesheet" href="./assets/vendor/apexcharts/dist/apexcharts.css"&gt;</code></li>
        <li>Incluir JavaScript: <code class="bg-yellow-100 px-2 py-1 rounded">&lt;script src="./assets/vendor/apexcharts/dist/apexcharts.min.js"&gt;&lt;/script&gt;</code></li>
        <li>Incluir helpers de Preline: <code class="bg-yellow-100 px-2 py-1 rounded">&lt;script src="./assets/vendor/preline/dist/helper-apexcharts.js"&gt;&lt;/script&gt;</code></li>
    </ol>
    <p class="body-small text-yellow-700 mt-4">
        Ver código completo en <code class="bg-yellow-100 px-2 py-1 rounded">Componentes-3.md</code> listado 41.
    </p>
</div>

{{-- SECTION: Single Area Chart --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Single Area Chart
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Gráfico de área simple con una serie de datos.</p>
    
    <x-chart-single-area chartId="single-area-chart" />
    
    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
        <p class="body-small text-gray-600 mb-2"><strong>Configuración requerida:</strong></p>
        <p class="caption text-gray-500">Ver código JavaScript completo en Componentes-3.md línea 1151-1372</p>
    </div>
</div>

{{-- SECTION: Multiple Area Chart --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Multiple Area Chart
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Gráfico de área con múltiples series de datos.</p>
    
    <x-chart-multiple-area 
        chartId="multiple-area-chart"
        :legend="[
            ['label' => 'Ingresos', 'color' => 'blue-600'],
            ['label' => 'Gastos', 'color' => 'purple-600'],
        ]"
    />
    
    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
        <p class="body-small text-gray-600 mb-2"><strong>Configuración requerida:</strong></p>
        <p class="caption text-gray-500">Ver código JavaScript completo en Componentes-3.md línea 1397-1623</p>
    </div>
</div>

{{-- SECTION: Single Bar Chart --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Single Bar Chart
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Gráfico de barras simple con una serie de datos.</p>
    
    <x-chart-single-bar chartId="single-bar-chart" />
    
    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
        <p class="body-small text-gray-600 mb-2"><strong>Configuración requerida:</strong></p>
        <p class="caption text-gray-500">Ver código JavaScript completo en Componentes-3.md línea 1631-1830</p>
    </div>
</div>

{{-- SECTION: Pie Chart --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Pie Chart
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Gráfico de pastel para mostrar proporciones.</p>
    
    <x-chart-pie 
        chartId="pie-chart"
        :legend="[
            ['label' => 'Directo', 'color' => 'blue-600'],
            ['label' => 'Búsqueda Orgánica', 'color' => 'cyan-500'],
            ['label' => 'Referido', 'color' => 'gray-300'],
        ]"
    />
    
    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
        <p class="body-small text-gray-600 mb-2"><strong>Configuración requerida:</strong></p>
        <p class="caption text-gray-500">Ver código JavaScript completo en Componentes-3.md línea 1863-1937</p>
    </div>
</div>

@endsection















