<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    protected $guarded = [];
    protected $table   = 'invoices';
    protected $casts   = ['invoice_date' => 'date', 'total_amount' => 'decimal:2'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'suppliers_id');
    }

    public function batches()
    {
        return $this->hasMany(AssetBatch::class, 'invoice_id');
    }
}
