<?php

namespace App\Features\SuperLinkiu\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RejectStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'super_admin';
    }

    public function rules(): array
    {
        return [
            'store_id' => 'required|exists:stores,id',
            'rejection_reason' => 'required|string|in:rut_invalido,tipo_no_permitido,informacion_incompleta,duplicado,otro',
            'rejection_message' => 'nullable|string|max:500',
            'allow_reapply' => 'boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'rejection_reason.required' => 'Debes especificar un motivo de rechazo',
            'rejection_reason.in' => 'Motivo de rechazo no válido'
        ];
    }
}

