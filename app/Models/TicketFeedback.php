<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketFeedback extends Model
{
    protected $guarded = [];
    protected $table   = 'ticket_feedbacks';
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
