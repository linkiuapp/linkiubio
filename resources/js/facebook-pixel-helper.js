/**
 * Helper para Facebook Pixel
 * Asegura que todos los eventos tengan los parámetros correctos
 */

/**
 * Track Lead con valor por defecto
 * @param {number} value - Valor del lead (opcional, por defecto 70000)
 * @param {string} currency - Divisa (opcional, por defecto 'COP')
 */
window.trackFacebookLead = function(value = 70000, currency = 'COP') {
    if (typeof fbq !== 'undefined') {
        fbq('track', 'Lead', {
            value: value,
            currency: currency,
            predicted_ltv: value
        });
        console.log('Facebook Lead tracked:', { value, currency });
    }
};

/**
 * Track Lead con información del plan seleccionado
 * @param {string} planName - Nombre del plan
 * @param {number} planPrice - Precio del plan
 * @param {string} billingPeriod - Período de facturación
 */
window.trackFacebookLeadWithPlan = function(planName, planPrice, billingPeriod = 'monthly') {
    if (typeof fbq !== 'undefined') {
        fbq('track', 'Lead', {
            value: planPrice,
            currency: 'COP',
            content_name: planName,
            content_category: 'plan_selection',
            predicted_ltv: planPrice * 12, // Valor de vida del cliente estimado (12 meses)
            custom: {
                billing_period: billingPeriod
            }
        });
        console.log('Facebook Lead (Plan) tracked:', { planName, planPrice, billingPeriod });
    }
};

/**
 * Track CompleteRegistration cuando se complete el registro
 * @param {string} planName - Nombre del plan
 * @param {number} planPrice - Precio del plan
 */
window.trackFacebookCompleteRegistration = function(planName, planPrice) {
    if (typeof fbq !== 'undefined') {
        fbq('track', 'CompleteRegistration', {
            value: planPrice,
            currency: 'COP',
            content_name: planName,
            status: 'completed'
        });
        console.log('Facebook CompleteRegistration tracked:', { planName, planPrice });
    }
};
