<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Link extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'shortcut',
        'url',
        'user_id',
        'expires_at',
        'active',
        'name',
        'classification',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function settings(): HasMany
    {
        return $this->hasMany(LinkSetting::class);
    }

    protected function casts(): array
    {
        return [
            'expires_at' => 'timestamp',
            'classification' => 'array',
        ];
    }
}
