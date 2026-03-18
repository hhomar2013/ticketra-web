<?php
namespace App\Livewire\V1\Reports\Feedback;

use App\Models\TicketFeedback;
use Livewire\Component;
use Livewire\WithPagination;

class FeedbackIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';
    public string $sortBy = '';
    public int $perPage   = 10;

    public function updatingSearch(): void
    {$this->resetPage();}
    public function updatingSortBy(): void
    {$this->resetPage();}

    public function render()
    {
        $feedbacks = TicketFeedback::query()
            ->with([
                'user',                // صاحب التذكرة (اللي عمل الفيدباك)
                'ticket.user',         // نفس الشخص
                'ticket.assignedUser', // الموظف اللي اشتغل عليها
                'ticket.category',
            ])
            ->when($this->search, fn($q) =>
                $q->whereHas('ticket', fn($q) =>
                    $q->where('title', 'like', '%' . $this->search . '%')
                )
                    ->orWhereHas('user', fn($q) =>
                        $q->where('name', 'like', '%' . $this->search . '%')
                    )
            )
            ->when($this->sortBy, fn($q) =>
                $q->where('rating', $this->sortBy)
            )
            ->latest()
            ->paginate($this->perPage);

        $avgRating = TicketFeedback::avg('rating');

        return view('livewire.v1.reports.feedback.feedback-index', [
            'feedbacks'  => $feedbacks,
            'avgRating'  => round($avgRating, 1),
            'totalCount' => TicketFeedback::count(),
        ]);
    }
}
