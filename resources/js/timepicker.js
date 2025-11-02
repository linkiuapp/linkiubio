/**
 * Timepicker personalizado - formato 24 horas
 * Selector de hora simple y compacto sin AM/PM
 */

let timepickerInitialized = new WeakMap();

/**
 * Crear selector de tiempo personalizado
 */
function createCustomTimepicker(element) {
    // Verificar si ya está inicializado
    if (timepickerInitialized.has(element)) {
        return;
    }

    // Crear contenedor del timepicker
    const container = document.createElement('div');
    container.className = 'custom-timepicker-container';
    container.style.display = 'none';
    container.style.position = 'absolute';
    container.style.zIndex = '9999';
    container.style.backgroundColor = '#ffffff';
    container.style.border = '1px solid #e5e7eb';
    container.style.borderRadius = '8px';
    container.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
    container.style.padding = '12px';
    container.style.minWidth = '200px';

    // Crear selectores de hora y minuto
    const hourSelect = document.createElement('select');
    hourSelect.className = 'custom-timepicker-hour';
    hourSelect.style.width = '60px';
    hourSelect.style.padding = '6px 8px';
    hourSelect.style.border = '1px solid #d1d5db';
    hourSelect.style.borderRadius = '6px';
    hourSelect.style.fontSize = '14px';
    hourSelect.style.marginRight = '8px';

    const minuteSelect = document.createElement('select');
    minuteSelect.className = 'custom-timepicker-minute';
    minuteSelect.style.width = '60px';
    minuteSelect.style.padding = '6px 8px';
    minuteSelect.style.border = '1px solid #d1d5db';
    minuteSelect.style.borderRadius = '6px';
    minuteSelect.style.fontSize = '14px';

    // Llenar horas (00-23)
    for (let h = 0; h < 24; h++) {
        const option = document.createElement('option');
        option.value = String(h).padStart(2, '0');
        option.textContent = String(h).padStart(2, '0');
        hourSelect.appendChild(option);
    }

    // Llenar minutos (00, 15, 30, 45)
    [0, 15, 30, 45].forEach(m => {
        const option = document.createElement('option');
        option.value = String(m).padStart(2, '0');
        option.textContent = String(m).padStart(2, '0');
        minuteSelect.appendChild(option);
    });

    // Contenedor para los selects
    const selectsContainer = document.createElement('div');
    selectsContainer.style.display = 'flex';
    selectsContainer.style.alignItems = 'center';
    selectsContainer.style.gap = '8px';
    selectsContainer.appendChild(hourSelect);
    selectsContainer.appendChild(document.createTextNode(':'));
    selectsContainer.appendChild(minuteSelect);

    container.appendChild(selectsContainer);

    // Botón de aplicar
    const applyBtn = document.createElement('button');
    applyBtn.textContent = 'Aplicar';
    applyBtn.style.marginTop = '8px';
    applyBtn.style.width = '100%';
    applyBtn.style.padding = '6px';
    applyBtn.style.backgroundColor = '#da27a7';
    applyBtn.style.color = '#ffffff';
    applyBtn.style.border = 'none';
    applyBtn.style.borderRadius = '6px';
    applyBtn.style.cursor = 'pointer';
    applyBtn.style.fontSize = '14px';
    applyBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        const time = `${hourSelect.value}:${minuteSelect.value}`;
        // Solo asignar el valor si el usuario hizo clic en Aplicar
        element.value = time;
        element.dispatchEvent(new Event('change', { bubbles: true }));
        element.dispatchEvent(new Event('input', { bubbles: true }));
        container.style.display = 'none';
    });
    
    // Prevenir que el timepicker asigne valores automáticamente
    // Solo permitir valores cuando el usuario haga clic en "Aplicar"
    element.addEventListener('focus', () => {
        // No hacer nada automáticamente
    }, { passive: true });

    container.appendChild(applyBtn);

    // Agregar al body
    document.body.appendChild(container);

    // Parsear valor inicial del input - NO asignar valores por defecto
    const currentValue = element.value || '';
    if (currentValue.match(/^\d{1,2}:\d{2}$/)) {
        const [h, m] = currentValue.split(':');
        hourSelect.value = String(parseInt(h)).padStart(2, '0');
        minuteSelect.value = String(parseInt(m)).padStart(2, '0');
    } else {
        // NO asignar valores por defecto - dejar vacío
        hourSelect.value = '00';
        minuteSelect.value = '00';
    }

    // Mostrar/ocultar al hacer click en el input
    element.addEventListener('focus', (e) => {
        e.preventDefault();
        const rect = element.getBoundingClientRect();
        container.style.top = `${rect.bottom + window.scrollY + 4}px`;
        container.style.left = `${rect.left + window.scrollX}px`;
        container.style.display = 'block';
    });

    // Ocultar al hacer click fuera
    document.addEventListener('click', (e) => {
        if (!container.contains(e.target) && e.target !== element) {
            container.style.display = 'none';
        }
    });

    // Guardar referencia
    timepickerInitialized.set(element, container);
    element._timepickerContainer = container;
}

/**
 * Inicializar timepicker personalizado
 */
export function initCustomTimepicker(selector) {
    const element = typeof selector === 'string' ? document.querySelector(selector) : selector;
    
    if (!element) {
        return null;
    }

    // Solo aplicar a inputs de tipo text con la clase correspondiente
    if (element.tagName !== 'INPUT') {
        return null;
    }

    // Crear el timepicker personalizado
    createCustomTimepicker(element);

    return element;
}

// Hacer disponible globalmente
window.initCustomTimepicker = initCustomTimepicker;

