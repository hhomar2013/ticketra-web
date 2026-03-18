<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class asset_log extends Model
{
    protected $guarded = [];



    public function asset()
    {
        return $this->belongsTo(asset::class);
    }

    // الشخص اللي قام بالتعديل أو الصيانة
    public function performer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // لو السجل مرتبط بتذكرة معينة
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
