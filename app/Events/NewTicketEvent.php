<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast; // مهم جداً
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewTicketEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticketData;

    public function broadcastAs(): string
    {
        return 'new-ticket';
    }

    public function __construct($ticket)
    {
        // نجهز البيانات التي نريد إرسالها للمتصفح
        $this->ticketData = [
            'user'      => $ticket->user->name,
            'subject'   => $ticket->title,
            'ticket_id' => $ticket->id,
            'url'       => route('it.tickets.show', $ticket->id),
        ];
    }

    public function broadcastOn(): array
    {
        // البث سيكون على قناة عامة اسمها 'tickets'
        return [
            new Channel('tickets'),
        ];
    }
}
