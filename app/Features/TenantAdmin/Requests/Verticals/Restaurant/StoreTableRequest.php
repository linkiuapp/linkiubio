<?php

namespace App\Features\TenantAdmin\Requests\Verticals\Restaurant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Shared\Models\Table;

class StoreTableRequest extends FormRequest
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
        $store = view()->shared('currentStore');
        $type = $this->input('type', 'mesa');
        
        return [
            'table_number' => [
                'required',
                'string',
                'max:10',
                Rule::unique('tables')->where(function ($query) use ($store, $type) {
                    return $query->where('store_id', $store->id)
                                 ->where('type', $type);
                })
            ],
            'type' => 'required|in:mesa,habitacion',
            'capacity' => 'nullable|integer|min:1|max:20',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        $type = $this->input('type', 'mesa');
        $typeLabel = $type === 'habitacion' ? 'habitación' : 'mesa';
        
        return [
            'table_number.required' => 'El número de ' . $typeLabel . ' es obligatorio.',
            'table_number.string' => 'El número de ' . $typeLabel . ' debe ser texto.',
            'table_number.max' => 'El número de ' . $typeLabel . ' no puede exceder 10 caracteres.',
            'table_number.unique' => 'Ya existe una ' . $typeLabel . ' con ese número.',
            'type.required' => 'El tipo es obligatorio.',
            'type.in' => 'El tipo debe ser "mesa" o "habitación".',
            'capacity.integer' => 'La capacidad debe ser un número entero.',
            'capacity.min' => 'La capacidad mínima es 1.',
            'capacity.max' => 'La capacidad máxima es 20.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $store = view()->shared('currentStore');
            $type = $this->input('type', 'mesa');
            $reservasHotelEnabled = featureEnabled($store, 'reservas_hotel');
            
            // Si intentan crear una habitación y reservas_hotel está activo, no permitir
            if ($type === 'habitacion' && $reservasHotelEnabled) {
                $validator->errors()->add(
                    'type',
                    'No se pueden crear habitaciones manualmente cuando las reservas de hotel están activas. Las habitaciones se gestionan desde Reservas de Hotel.'
                );
            }
        });
    }
}

