<?php

namespace App\Livewire;

use App\Models\Ticket;
use App\Models\User;
use Laravel\Pail\ValueObjects\Origin\Console;
use Livewire\Component;

class Dashboard extends Component
{
    public $total_users;
    public $total_tickets;

    public $latest_ticket_id;

    public function mount()
    {
        $this->latest_ticket_id = Ticket::max('id');
        $this->total_users = User::count();
        $this->total_tickets = Ticket::get();
    }

    public function checkTickets()
    {
        $current_latest = Ticket::max('id');
        $new_ticket = false;
        if ($current_latest > $this->latest_ticket_id) {
            $this->latest_ticket_id = $current_latest;

            $this->total_tickets = Ticket::get();
            $this->total_users = User::count();
            $new_ticket = Ticket::find($this->latest_ticket_id);
            $this->dispatch('new-ticket-detected', [
                'ticket_id' => $new_ticket->id,
                'user' => $new_ticket->user->name,
                'subject' => $new_ticket->title,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
