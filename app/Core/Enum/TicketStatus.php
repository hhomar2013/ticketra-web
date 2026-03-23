<?php

namespace App\Core\Enum;

enum TicketStatus: string
{
    case New        = 'new';
    case Open       = 'open';
    case InProgress = 'in_progress';
    case Closed     = 'closed';

    public function label(): string
    {
        return match($this) {
            TicketStatus::New        => 'New',
            TicketStatus::Open       => 'Open',
            TicketStatus::InProgress => 'In Progress',
            TicketStatus::Closed     => 'Closed',
        };
    }

    public function color(): string
    {
        return match($this) {
            TicketStatus::New        => 'secondary',
            TicketStatus::Open       => 'success',
            TicketStatus::InProgress => 'warning',
            TicketStatus::Closed     => 'danger',
        };
    }

    public function subColor(): string
    {
        return match($this) {
            TicketStatus::New        => 'bg-secondary-subtle text-secondary',
            TicketStatus::Open       => 'bg-success-subtle text-success',
            TicketStatus::InProgress => 'bg-warning-subtle text-warning',
            TicketStatus::Closed     => 'bg-danger-subtle text-danger',
        };
    }

    public function bgColor(): string
{
    return match($this) {
        TicketStatus::New        => 'bg-dark bg-opacity-25',
        TicketStatus::Open       => 'bg-success text-dark bg-opacity-25',
        TicketStatus::InProgress => 'bg-warning bg-opacity-25',
        TicketStatus::Closed     => 'bg-danger bg-opacity-25',
    };
}

public function emoji(): string
{
    return match($this) {
        TicketStatus::New        => '🕐',
        TicketStatus::Open       => '📂',
        TicketStatus::InProgress => '⚙️',
        TicketStatus::Closed     => '✅',
    };
}
}
