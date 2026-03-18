<?php
namespace App\Livewire\V1\Users;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserDashboardIndex extends Component
{

    public $listeners = ['refreshUserDashboardIndex' => '$refresh'];

    public function render()
    {
        $totalTickets  = Ticket::where('user_id', Auth::id())->count();
        $openTickets   = Ticket::where('user_id', Auth::id())->whereIn('status', ['open', 'in_progress'])->count();
        $closedTickets = Ticket::where('user_id', Auth::id())->where('status', 'closed')->count();
        $newTickets    = Ticket::where('user_id', Auth::id())->where('status', 'new')->count();
        $recentTickets = Ticket::with('category')->where('user_id', Auth::id())->latest()->take(5)->get();
        return view('livewire.v1.users.user-dashboard-index', compact('totalTickets', 'openTickets', 'closedTickets', 'newTickets', 'recentTickets'));
    }
}
