<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class asset extends Model
{
    protected $guarded = [];
    protected $casts   = ['warranty_expiry' => 'date', 'purchase_price' => 'decimal:2'];

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
}
