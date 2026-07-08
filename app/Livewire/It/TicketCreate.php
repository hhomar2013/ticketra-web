<?php

namespace App\Livewire\It;

use App\Core\DTO\TicketDTO;
use App\Core\Enum\TicketStatus;
use App\Core\Services\TicketService;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class TicketCreate extends Component
{
    use WithFileUploads;

    // ══════════════ Properties ══════════════
    public string $title       = '';
    public string $description = '';
    public string $content     = '';
    public        $image       = null;
    public ?int   $category_id = null;
    public        $tickets     = [];
    public        $categories;

    // ══════════════ Listeners ══════════════
    protected $listeners = ['ticketCreated' => 'refreshTickets'];

    // ══════════════ Inject Service via boot() ══════════════
    protected TicketService $ticketService;

    public function boot(TicketService $ticketService): void
    {
        $this->ticketService = $ticketService;
    }

    // ══════════════ Mount ══════════════
    public function mount(): void
    {
        $this->categories  = Category::all();
        $this->category_id = Auth::user()->category_id;
        $this->refreshTickets();
    }

    // ══════════════ Refresh Tickets ══════════════
    public function refreshTickets(): void
    {
        $this->tickets = $this->ticketService->getUserTickets(Auth::id());
    }

    // ══════════════ Submit ══════════════
    public function submit(): void
    {
        $this->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|max:2048',
        ]);

        // بناء الـ DTO
        $dto = TicketDTO::fromArray([
            'title'       => $this->title,
            'description' => $this->description,
            'user_id'     => Auth::id(),
            'category_id' => $this->category_id,
        ]);

        $this->ticketService->create($dto, $this->image);

        $this->dispatch('new-ticket-detected', [
            'user'    => Auth::user()->name,
            'subject' => $this->title,
        ]);

        $this->dispatch('refresh-summernote');
        $this->dispatch('ticketCreated');
        $this->reset(['title', 'description', 'image']);
    }

    // ══════════════ Delete ══════════════
    public function deleteTicket(int $id): void
    {
        $this->ticketService->delete($id);
        session()->flash('message', 'Ticket Cancelled Successfully.');
        $this->refreshTickets();
    }

    // ══════════════ Render ══════════════
    public function render()
    {
        return view('livewire.it.ticket-create', [
            'statuses' => TicketStatus::cases(),
        ]);
    }
}
