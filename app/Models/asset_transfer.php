<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class asset_transfer extends Model
{
    protected $guarded = [];
    public function asset()
    {
        return $this->belongsTo(asset::class);
    }
    public function user()
    {
        return $this->belongsTo(user::class, 'action_by');
    }
    public function fromBranch()
    {
        return $this->belongsTo(branch::class, 'from_branch_id');
    }
    public function toBranch()
    {
        return $this->belongsTo(branch::class, 'to_branch_id');
    }
}
