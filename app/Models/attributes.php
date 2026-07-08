<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class attributes extends Model
{
    protected $guarded = [];

    public function assets(): BelongsToMany
    {
        return $this->belongsToMany(Asset::class, 'asset_attribute')
            ->withPivot('value')
            ->withTimestamps();
    }

    public function scopeActive()
    {
        return self::query()->where('is_active', 1)->get();
    }

    public function scopeNotActive()
    {
        return self::query()->where('is_active', 0)->get();
    }
}
