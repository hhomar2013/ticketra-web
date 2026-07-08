<?php

namespace App\Livewire\V1\Users;

use App\Core\Enum\TicketStatus;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserDashboardIndex extends Component
{
    public $listeners = ['refreshUserDashboardIndex' => '$refresh'];

    public function render()
    {
        $userId = Auth::id();

        $totalTickets  = Ticket::where('user_id', $userId)->count();

        $openTickets   = Ticket::where('user_id', $userId)
                            ->whereIn('status', [
                                TicketStatus::Open->value,
                                TicketStatus::InProgress->value,
                            ])->count();

        $closedTickets = Ticket::where('user_id', $userId)
                            ->where('status', TicketStatus::Closed)
                            ->count();

        $newTickets    = Ticket::where('user_id', $userId)
                            ->where('status', TicketStatus::New)
                            ->count();

        $recentTickets = Ticket::with('category')
                            ->where('user_id', $userId)
                            ->latest()
                            ->take(5)
                            ->get();

        return view('livewire.v1.users.user-dashboard-index', compact(
            'totalTickets',
            'openTickets',
            'closedTickets',
            'newTickets',
            'recentTickets',
        ));
    }
}
