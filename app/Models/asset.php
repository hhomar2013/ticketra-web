<?php
namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class asset extends Model
{
    protected $guarded = [];
    // protected $casts = ['warranty_expiry' => 'date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(asset_category::class, 'category_id');
    }

    public function branch()
    {
        return $this->belongsTo(branch::class, 'branch_id');
    }

    public function brand()
    {
        return $this->belongsTo(brand::class, 'brand_id');
    }

    public function typeModel()
    {
        return $this->belongsTo(type_model::class, 'type_model_id');
    }

    public function history()
    {
        return $this->hasMany(asset_log::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function assignments()
    {
        return $this->hasMany(AssetAssignment::class)->latest();
    }

    public function isAssigned()
    {
        return $this->status === 'assigned';
    }



    public function Transfer()
    {
        return $this->hasMany(asset_transfer::class);
    }

    public function batch()
    {
        return $this->belongsTo(AssetBatch::class, 'batch_id');
    }

    // Auto-generate asset tag
    protected static function booted(): void
    {
        static::creating(function (asset $asset) {
            $asset->asset_tag = 'TAG-' . str_pad(asset::count() + 1, 5, '0', STR_PAD_LEFT);
        });
    }
    public function attributes()
    {
        return $this->belongsToMany(attributes::class, 'asset_attribute')
            ->withPivot('value');
    }

    public function specs()
    {
        return $this->hasMany(asset_attribute::class, 'asset_id');
    }

    public function warranty_expiry(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }


}
