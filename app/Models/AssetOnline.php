<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AssetOnline extends Model
{
    protected $casts = [
        'installed_apps' => 'array',
        'hardware_specs' => 'array',
        'missing_drivers' => 'array',
    ];

    protected $guarded = [];
    protected $appends = ['apps_count'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function appsCount(): Attribute
    {
        return Attribute::make(
            get: fn() => count($this->installed_apps ?? []),
        );
    }

}
