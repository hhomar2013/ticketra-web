<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class asset_attribute extends Model
{
    protected $guarded = [];

    public function attribute()
    {
        return $this->belongsTo(attributes::class);
    }

    public function asset()
    {
        return $this->belongsTo(asset::class, 'asset_id');
    }
}
