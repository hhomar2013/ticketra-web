<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetAssignment extends Model
{

    protected $guarded = [];


    public function asset()
    {
        return $this->belongsTo(asset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assigner()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function branch()
    {
        return $this->belongsTo(branch::class);
    }
}
