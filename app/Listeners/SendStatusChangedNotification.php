<?php

namespace App\Listeners;

use App\Events\TicketStatusChanged;
use App\Notifications\TicketUpdatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendStatusChangedNotification implements ShouldQueue
{
    public function handle(TicketStatusChanged $event): void
    {
        $ticket = $event->ticket;

        // إبلاغ صاحب التيكيت بتغيير الحالة
        $ticket->user->notify(new TicketUpdatedNotification([
            'user'      => $ticket->user->name,
            'subject'   => "Ticket #{$ticket->id} status changed",
            'old_status'=> $event->oldStatus->label(),
            'new_status'=> $event->newStatus->label(),
            'ticket_id' => $ticket->id,
            'url'       => route('user.tickets.show', $ticket->id),
        ]));
    }
}
