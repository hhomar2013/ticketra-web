<?php
namespace App\Models;

use App\Core\Enum\TicketStatus;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    protected $casts = [
        'status' => TicketStatus::class,
    ];

    protected $guarded = [];

    public function image()
    {
        return $this->morphOne(images::class, 'image');
    }

    public function replies()
    {
        return $this->hasMany(TicketReply::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feedback()
    {
        return $this->hasOne(TicketFeedback::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

}
