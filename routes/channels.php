<?php

use App\Models\Ticket;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('ticket.{ticketId}', function ($user, $ticketId) {
    $ticket = Ticket::find($ticketId);

    // ✅ بس صاحب التذكرة أو اللي عنده صلاحية يدخل الـ channel
    return $ticket && (
        $user->id === $ticket->user_id ||
        $user->can('manage tickets')
    );
});
