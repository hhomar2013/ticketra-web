<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetBatch extends Model
{
    protected $fillable = ['invoice_id', 'batch_number', 'received_date', 'status', 'notes'];
    protected $casts    = ['received_date' => 'date'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function assets()
    {
        return $this->hasMany(asset::class, 'batch_id');
    }

    // Auto-generate batch number
    protected static function booted(): void
    {
        static::creating(function (AssetBatch $batch) {
            $batch->batch_number = 'BATCH-' . date('Y') . '-' . str_pad(
                AssetBatch::whereYear('created_at', date('Y'))->count() + 1,
                4, '0', STR_PAD_LEFT
            );
        });
    }
}
