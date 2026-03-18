<?php
namespace App\Livewire\V1\Admin;


use App\Livewire\Actions\Logout;
use App\Models\Ticket;
use App\Models\TicketFeedback;
use App\Models\User;
use Livewire\Component;

class DashboardIndex extends Component
{


    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }




    public function render()
    {
        $tickets = Ticket::query();

        $stats = [
            'total'       => (clone $tickets)->count(),
            'new'         => (clone $tickets)->where('status', 'new')->count(),
            'open'        => (clone $tickets)->where('status', 'open')->count(),
            'in_progress' => (clone $tickets)->where('status', 'in_progress')->count(),
            'closed'      => (clone $tickets)->where('status', 'closed')->count(),
        ];

        $recentTickets = Ticket::with('user', 'category', 'assignedUser')
            ->latest()
            ->take(6)
            ->get();

        $avgRating    = round(TicketFeedback::avg('rating') ?? 0, 1);
        $totalFeedbacks = TicketFeedback::count();

        // أحسن 3 موظفين بأكتر تذاكر مغلقة
        $topAgents = User::withCount(['assignedTickets as closed_count' => fn($q) =>
                $q->where('status', 'closed')
            ])
            ->having('closed_count', '>', 0)
            ->orderByDesc('closed_count')
            ->take(3)
            ->get();

        // آخر 7 أيام - تذاكر جديدة يومياً
        $weeklyData = collect(range(6, 0))->map(fn($i) => [
            'day'   => now()->subDays($i)->format('D'),
            'count' => Ticket::whereDate('created_at', now()->subDays($i))->count(),
        ]);

        return view('livewire.v1.admin.dashboard-index'
        , compact(
            'stats', 'recentTickets', 'avgRating', 'totalFeedbacks', 'topAgents', 'weeklyData'
        ));
    }
}


