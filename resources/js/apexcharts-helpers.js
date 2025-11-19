// ApexCharts Helpers basados en Preline UI
// Funciones helper para construir gráficos con ApexCharts

import ApexCharts from 'apexcharts';

// Función para detectar el modo (light/dark) - simplificada para siempre usar light
function getMode() {
    return 'light';
}

// Función para construir tooltips personalizados
function buildTooltip(props, options = {}) {
    const {
        title = '',
        mode = 'light',
        valuePrefix = '',
        hasTextLabel = false,
        wrapperExtClasses = '',
        labelDivider = '',
        labelExtClasses = ''
    } = options;

    const { series, seriesIndex, dataPointIndex, w } = props;
    const value = series[seriesIndex][dataPointIndex];
    const formattedValue = valuePrefix ? `${valuePrefix}${value}` : value;

    let tooltipContent = `<div class="py-2 px-3 bg-white border border-gray-200 rounded-lg shadow-md ${wrapperExtClasses}">`;
    
    if (title) {
        tooltipContent += `<div class="text-xs font-medium text-gray-800 mb-1">${title}</div>`;
    }
    
    if (hasTextLabel) {
        const seriesName = w.globals.seriesNames[seriesIndex];
        tooltipContent += `<div class="text-xs text-gray-600">${seriesName}${labelDivider} <span class="font-semibold ${labelExtClasses}">${formattedValue}</span></div>`;
    } else {
        tooltipContent += `<div class="text-xs text-gray-600">${formattedValue}</div>`;
    }
    
    tooltipContent += `</div>`;
    
    return tooltipContent;
}

// Función principal para construir gráficos
function buildChart(selector, configFn, lightThemeOverrides = {}, darkThemeOverrides = {}) {
    const element = document.querySelector(selector);
    if (!element) {
        console.warn(`Elemento no encontrado: ${selector}`);
        return null;
    }

    const mode = getMode();
    const baseConfig = configFn(mode);
    
    // Aplicar overrides según el modo
    const themeOverrides = mode === 'dark' ? darkThemeOverrides : lightThemeOverrides;
    const config = { ...baseConfig, ...themeOverrides };

    // Asegurar que ApexCharts esté disponible
    if (typeof ApexCharts === 'undefined') {
        console.error('ApexCharts no está disponible');
        return null;
    }

    const chart = new ApexCharts(element, config);
    chart.render();

    return chart;
}

// Hacer funciones disponibles globalmente
window.ApexCharts = ApexCharts;
window.buildChart = buildChart;
window.buildTooltip = buildTooltip;

export { buildChart, buildTooltip, getMode };















