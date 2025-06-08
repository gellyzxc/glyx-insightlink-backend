<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LinkRouteSetting extends Model
{
    use HasUuids;

    protected $fillable = [
        'link_setting_id',
        'route_setting_id',
        'value'
    ];

    public function linkSetting(): BelongsTo
    {
        return $this->belongsTo(LinkSetting::class);
    }

    public function routeSetting(): BelongsTo
    {
        return $this->belongsTo(RouteSetting::class);
    }

    protected $casts = [
        'value' => 'array'
    ];
}
