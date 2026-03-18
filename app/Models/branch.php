<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class branch extends Model
{
    protected $guarded = [];

    public function assets()
    {
        return $this->hasMany(asset::class);
    }
}
