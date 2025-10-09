<?php

namespace App\Features\SuperLinkiu\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'super_admin';
    }

    public function rules(): array
    {
        $categoryId = $this->route('businessCategory') ? $this->route('businessCategory')->id : null;

        return [
            'name' => 'required|string|max:100|unique:business_categories,name,' . $categoryId,
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:500',
            'requires_manual_approval' => 'required|boolean',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la categoría es obligatorio',
            'name.unique' => 'Ya existe una categoría con este nombre',
            'requires_manual_approval.required' => 'Debes especificar si requiere aprobación manual'
        ];
    }
}

