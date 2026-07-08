<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceBodyInvoice extends Model
{
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function invoice()
    {
        return $this->belongsTo(MaintenanceHeadInvoice::class, 'maintenance_head_invoice_id');
    }
}
