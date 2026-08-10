<?php
namespace App\Livewire\V1\Admin;

use App\Core\Enum\AssetStatus;
use App\Core\Enum\TicketStatus;
use App\Livewire\Actions\Logout;
use App\Models\asset;
use App\Models\asset_category;
use App\Models\AssetAssignment;
use App\Models\Ticket;
use App\Models\TicketFeedback;
use App\Models\User;
use Livewire\Component;

class DashboardIndex extends Component
{
    public $page = 'assetsDashboard';

    public function changePage($page)
    {
        $this->page = $page;
    }

    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }

    public function render()
    {
        // TODO: Implement Assets Dashboard
        $assets = asset::query();

        // $assetTypeStats = asset_category::withCount('assets')->get();

        $assetStats = [
            'total' => (clone $assets)->count(),
            'available' => (clone $assets)->where('status', AssetStatus::Available)->count(),
            'maintenance' => (clone $assets)->where('status', AssetStatus::Maintenance)->count(),
            'assigned' => (clone $assets)->where('status', AssetStatus::Assigned)->count(),
            'damaged' => (clone $assets)->where('status', AssetStatus::Damaged)->count(),
        ];

        $recentAssets = asset::with('user', 'category', 'branch')
            ->latest()
            ->take(6)
            ->get();



        $weeklyAssetData = collect(range(6, 0))->map(fn($i) => [
            'day' => now()->subDays($i)->format('D'),
            'count' => (clone $assets)->whereDate('created_at', now()->subDays($i))->count(),
        ]);

        $assetAssignment = AssetAssignment::with('user', 'asset', 'branch')->where('status', AssetStatus::Assigned)->latest()->take(6)->get();

        $leavers = AssetAssignment::with('user', 'asset', 'branch')->where('status', AssetStatus::Leaver)->latest()->take(6)->get();



        // TODO: Implement Tickets Dashboard
        $tickets = Ticket::query();

        $stats = [
            'total' => (clone $tickets)->count(),
            'new' => (clone $tickets)->where('status', TicketStatus::New)->count(),
            'open' => (clone $tickets)->where('status', TicketStatus::Open)->count(),
            'in_progress' => (clone $tickets)->where('status', TicketStatus::InProgress)->count(),
            'closed' => (clone $tickets)->where('status', TicketStatus::Closed)->count(),
        ];

        $recentTickets = Ticket::with('user', 'category', 'assignedUser')
            ->latest()
            ->take(6)
            ->get();

        $avgRating = round(TicketFeedback::avg('rating') ?? 0, 1);
        $totalFeedbacks = TicketFeedback::count();

        $topAgents = User::withCount([
            'assignedTickets as closed_count' => fn($q) =>
                $q->where('status', TicketStatus::Closed)
        ])
            ->having('closed_count', '>', 0)
            ->orderByDesc('closed_count')
            ->take(3)
            ->get();

        $weeklyData = collect(range(6, 0))->map(fn($i) => [
            'day' => now()->subDays($i)->format('D'),
            'count' => Ticket::whereDate('created_at', now()->subDays($i))->count(),
        ]);

        $topAssigners = User::withCount('assignedByAssets')
            ->having('assigned_by_assets_count', '>', 0)
            ->orderByDesc('assigned_by_assets_count')
            ->take(3)
            ->get();

        return view('livewire.v1.admin.dashboard-index', compact(
            'assetStats',
            'stats',
            'recentTickets',
            'avgRating',
            'totalFeedbacks',
            'topAgents',
            'topAssigners',
            'weeklyData',
            'weeklyAssetData',
            'recentAssets',
            'assetAssignment',
            'leavers'
        ));
    }
}
