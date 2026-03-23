<?php

namespace App\Events;

use App\Core\Enum\TicketStatus;
use App\Models\Ticket;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Ticket       $ticket,
        public readonly TicketStatus $oldStatus,
        public readonly TicketStatus $newStatus,
    ) {}
}
