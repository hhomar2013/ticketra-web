<?php
namespace App\Livewire\It;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class TicketIndex extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected string $paginationTheme = 'bootstrap';
    protected $listeners              = ['reload' => '$refresh'];
    public string $sortBy             = '';
    public int $perPage               = 10;
    public int $sortCount;
    public  $viewMode = 'card';

    public function mount()
    {
        $this->viewMode = Cache::get('tickets_view_' . Auth::id(), 'card');

    }

    public function updatedViewMode($value)
    {
        Cache::put('tickets_view_' . Auth::id(), $value, now()->addYear());
    }

    public function updatedPerPage()
    {
        $this->resetPage();
        $this->dispatch('reload');
    }

    public function updatedSortBy()
    {
        $this->dispatch('reload');
    }

    public function updatingTicketsPage()
    {
        $this->resetErrorBag();
    }
    #[Computed()]
    public function tickets()
    {
        $tickets = Ticket::with(['category', 'user']);

        if ($this->sortBy) {
            $tickets->where('status', 'like', '%' . $this->sortBy . '%');
        }

        $this->sortCount = $this->sortBy ? $tickets->count() : $tickets->get()->count();

        return $tickets->paginate($this->perPage);
    }

    public function render()
    {
        $tickets = $this->tickets();

        return view('livewire.it.ticket-index', [
            'tickets' => $tickets,
        ]);
    }
}
