<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;

class TicketUpdatedNotification extends Notification
{
    use Queueable;

    protected $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'ticket_id' => $this->details['ticket_id'] ?? null,
            'title'     => $this->details['title'] ?? 'Ticket Updated',
            'message'   => $this->details['message'] ?? 'Ticket has been updated',
            'user_name' => $this->details['user_name'] ?? null,
            'type'      => $this->details['type'] ?? 'status',
        ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->details['ticket_id'] ?? null,
            'title'     => $this->details['title'] ?? 'Ticket Updated',
            'message'   => $this->details['message'] ?? 'Ticket has been updated',
            'user_name' => $this->details['user_name'] ?? null,
            'type'      => $this->details['type'] ?? 'status',
            'action_url' => route('it.tickets.show', $this->details['ticket_id']),
        ];
    }
}
