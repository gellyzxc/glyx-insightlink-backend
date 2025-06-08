<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class LinkSetting extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'link_id',
        'active',
        'priority',
        'url',
        'operand',
        'classification',
    ];

    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }

    public function linkRouteSettings(): HasMany
    {
        return $this->hasMany(LinkRouteSetting::class);
    }

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'classification' => 'array',
        ];
    }
}
