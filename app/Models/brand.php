<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class brand extends Model
{
    protected $guarded = [];

    public function typeModels()
    {
        return $this->hasMany(type_model::class, 'brand_id', 'id');
    }
}
