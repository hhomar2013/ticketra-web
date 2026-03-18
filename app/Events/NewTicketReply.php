<?php
namespace App\Events;

use App\Models\TicketReply;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewTicketReply implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public TicketReply $reply)
    {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('ticket.' . $this->reply->ticket_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id'            => $this->reply->id,
            'message'       => $this->reply->message,
            'user_id'       => $this->reply->user_id,
            'user_name'     => $this->reply->user->name,
            'created_at'    => $this->reply->created_at->format('h:i A'),
            'ticket_status' => $this->reply->ticket->status,

        ];
    }
}
