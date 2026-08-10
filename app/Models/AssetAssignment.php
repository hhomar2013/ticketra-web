<?php

namespace App\Models;

use App\Core\Enum\AssetStatus;
use Illuminate\Database\Eloquent\Model;

class AssetAssignment extends Model
{

    protected $guarded = [];
    protected $casts = ['status' => AssetStatus::class];

    public function asset()
    {
        return $this->belongsTo(asset::class, 'asset_id');
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
