<?php

namespace App\Features\TenantAdmin\Requests\Verticals\Restaurant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Shared\Models\Table;

class UpdateTableRequest extends FormRequest
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
        $table = $this->route('id'); // ID de la mesa/habitación
        
        // Obtener la mesa para validar
        $tableModel = Table::where('store_id', $store->id)->find($table);
        
        if (!$tableModel) {
            return []; // La validación de existencia se hace en el controller
        }
        
        return [
            'table_number' => [
                'required',
                'string',
                'max:10',
                Rule::unique('tables')->where(function ($query) use ($store, $tableModel) {
                    return $query->where('store_id', $store->id)
                                 ->where('type', $tableModel->type)
                                 ->where('id', '!=', $tableModel->id);
                })
            ],
            'capacity' => 'nullable|integer|min:1|max:20',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        $table = Table::where('store_id', view()->shared('currentStore')->id)
            ->find($this->route('id'));
        
        $typeLabel = $table && $table->type === 'habitacion' ? 'habitación' : 'mesa';
        
        return [
            'table_number.required' => 'El número de ' . $typeLabel . ' es obligatorio.',
            'table_number.string' => 'El número de ' . $typeLabel . ' debe ser texto.',
            'table_number.max' => 'El número de ' . $typeLabel . ' no puede exceder 10 caracteres.',
            'table_number.unique' => 'Ya existe una ' . $typeLabel . ' con ese número.',
            'capacity.integer' => 'La capacidad debe ser un número entero.',
            'capacity.min' => 'La capacidad mínima es 1.',
            'capacity.max' => 'La capacidad máxima es 20.',
            'is_active.boolean' => 'El estado activo debe ser verdadero o falso.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $store = view()->shared('currentStore');
            $tableId = $this->route('id');
            
            $table = Table::where('store_id', $store->id)->find($tableId);
            
            if (!$table) {
                return; // El controller manejará el 404
            }
            
            // Si es habitación y reservas_hotel está activo, verificar que NO venga del sistema
            $reservasHotelEnabled = featureEnabled($store, 'reservas_hotel');
            if ($table->type === 'habitacion' && $reservasHotelEnabled) {
                // Verificar si esta habitación corresponde a una Room del sistema de reservas
                $room = \App\Shared\Models\Room::where('store_id', $store->id)
                    ->where('room_number', $table->table_number)
                    ->first();
                
                if ($room) {
                    // Esta habitación viene del sistema de reservas, no permitir edición manual
                    $validator->errors()->add(
                        'table_number',
                        'No se puede editar una habitación que pertenece al sistema de reservas de hotel. Edítala desde Reservas de Hotel.'
                    );
                }
            }
        });
    }
}

