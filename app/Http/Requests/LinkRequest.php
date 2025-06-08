<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinkRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'shortcut' => ['required'],
            'url' => ['required'],
            'expires_at' => ['nullable', 'date'],
            'variants' => ['nullable', 'array'],
            'variants.*.url' => ['required', 'url'],
            'variants.*.priority' => ['required', 'integer', 'min:0', 'max:100'],
            'variants.*.conditions' => ['required', 'array'],
            'variants.*.operand' => ['required', 'in:AND,OR'],
            'variants.*.conditions.*.condition' => ['required', 'string', 'exists:route_settings,name'],
            'variants.*.conditions.*.value' => ['required', 'array'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
