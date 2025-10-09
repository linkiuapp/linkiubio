<?php

namespace App\Features\SuperLinkiu\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApproveStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'super_admin';
    }

    public function rules(): array
    {
        return [
            'store_id' => 'required|exists:stores,id',
            'business_category_id' => 'required|exists:business_categories,id',
            'plan_id' => 'nullable|exists:plans,id',
            'admin_notes' => 'nullable|string|max:1000',
            'send_welcome_email' => 'boolean',
            'mark_as_verified' => 'boolean'
        ];
    }
}

