<?php

namespace App\Features\TenantAdmin\Requests\Verticals\Restaurant;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDineInSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $store = view()->shared('currentStore');
        return auth()->check() && 
               auth()->user()->role === 'store_admin' && 
               auth()->user()->store_id === $store->id;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'is_enabled' => 'nullable|boolean',
            'charge_service_fee' => 'nullable|boolean',
            'service_fee_type' => 'nullable|in:percentage,fixed',
            'service_fee_percentage' => 'nullable|integer|min:0|max:100',
            'service_fee_fixed' => 'nullable|numeric|min:0',
            'suggest_tip' => 'nullable|boolean',
            'tip_options' => 'nullable|array',
            'tip_options.*' => 'integer|min:0|max:100',
            'allow_custom_tip' => 'nullable|boolean',
            'require_table_number' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'is_enabled.boolean' => 'El estado habilitado debe ser verdadero o falso.',
            'charge_service_fee.boolean' => 'El cargo por servicio debe ser verdadero o falso.',
            'service_fee_type.in' => 'El tipo de cargo por servicio debe ser "percentage" o "fixed".',
            'service_fee_percentage.integer' => 'El porcentaje de cargo por servicio debe ser un número entero.',
            'service_fee_percentage.min' => 'El porcentaje de cargo por servicio no puede ser negativo.',
            'service_fee_percentage.max' => 'El porcentaje de cargo por servicio no puede exceder 100%.',
            'service_fee_fixed.numeric' => 'El cargo fijo por servicio debe ser un número.',
            'service_fee_fixed.min' => 'El cargo fijo por servicio no puede ser negativo.',
            'suggest_tip.boolean' => 'La sugerencia de propina debe ser verdadero o falso.',
            'tip_options.array' => 'Las opciones de propina deben ser un array.',
            'tip_options.*.integer' => 'Cada opción de propina debe ser un número entero.',
            'tip_options.*.min' => 'Las opciones de propina no pueden ser negativas.',
            'tip_options.*.max' => 'Las opciones de propina no pueden exceder 100%.',
            'allow_custom_tip.boolean' => 'El permiso de propina personalizada debe ser verdadero o falso.',
            'require_table_number.boolean' => 'El requisito de número de mesa debe ser verdadero o falso.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'is_enabled' => 'habilitación',
            'charge_service_fee' => 'cargo por servicio',
            'service_fee_type' => 'tipo de cargo',
            'service_fee_percentage' => 'porcentaje de cargo',
            'service_fee_fixed' => 'cargo fijo',
            'suggest_tip' => 'sugerencia de propina',
            'tip_options' => 'opciones de propina',
            'allow_custom_tip' => 'propina personalizada',
            'require_table_number' => 'requisito de número de mesa',
        ];
    }
}

