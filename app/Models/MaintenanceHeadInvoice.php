<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceHeadInvoice extends Model
{
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'invoice_date' => 'datetime',
        'received_date' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(MaintenanceBodyInvoice::class, 'asset_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
