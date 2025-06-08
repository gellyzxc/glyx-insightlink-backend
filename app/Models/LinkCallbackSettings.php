<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LinkCallbackSettings extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'callback_url',
        'link_setting_id',
        'active',
    ];

    public function linkSetting(): BelongsTo
    {
        return $this->belongsTo(LinkSetting::class);
    }

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }
}
