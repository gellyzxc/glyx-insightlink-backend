<?php

namespace App\Http\Resources;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Link */
class LinkResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'shortcut' => $this->shortcut,
            'url' => $this->url,
            'expires_at' => $this->expires_at,
            'active' => $this->active,
            'classification' => $this->classification,
            'variants' => $this->settings->map(function ($setting) {
                return [
                    'id' => $setting->id,
                    'url' => $setting->url,
                    'priority' => $setting->priority,
                    'operand' => $setting->operand,
                    'conditions' => $setting->linkRouteSettings->map(function ($condition) {
                        return [
                            'id' => $condition->id,
                            'condition' => $condition->routeSetting->name,
                            'value' => $condition->value,
                        ];
                    }),
                ];
            }),
        ];
    }}
