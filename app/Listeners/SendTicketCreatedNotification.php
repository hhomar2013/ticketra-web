<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Models\User;
use App\Notifications\TicketUpdatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendTicketCreatedNotification implements ShouldQueue
{
    public function handle(TicketCreated $event): void
    {
        $ticket = $event->ticket;

        $admins = User::where('role', 'admin')->get();

        Notification::send($admins, new TicketUpdatedNotification([
            'user'      => $ticket->user->name,
            'subject'   => $ticket->title,
            'ticket_id' => $ticket->id,
            'url'       => route('it.tickets.show', $ticket->id),
        ]));

        // بث للـ Reverb
        broadcast(new \App\Events\NewTicketEvent($ticket));
    }
}
