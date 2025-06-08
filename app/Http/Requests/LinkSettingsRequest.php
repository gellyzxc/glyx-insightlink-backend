<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinkSettingsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'link_id' => ['required', 'exists:links'],
            'route_settings_id' => ['required', 'exists:route_settings'],
            'active' => ['boolean'],
            'priority' => ['integer', 'between:1,100'],
            'settings' => ['array'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
