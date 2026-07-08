<?php

namespace App\Livewire\V1\Maintenance;

use App\Models\MaintenanceHeadInvoice;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceIndex extends Component
{
    use WithPagination;

    public $perPage = 10;

    protected $paginationTheme = 'bootstrap';

    public $statusFilter = '';

    public $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updateStatus(int $id, string $status): void
    {
        MaintenanceHeadInvoice::findOrFail($id)->update(['status' => $status]);
        $this->dispatch('show-toast', [
            'message' => __('Status updated successfully'),
            'type' => 'success',
        ]);
    }

    public function render()
    {
        $invoices = MaintenanceHeadInvoice::query()->with('items')
            ->when($this->search, fn ($q) => $q->where('invoice_number', 'like', '%'.$this->search.'%'))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->latest()->paginate($this->perPage);
        $stats = [
            'total' => MaintenanceHeadInvoice::count(),
            'pending' => MaintenanceHeadInvoice::where('status', 'pending')->count(),
            'paid' => MaintenanceHeadInvoice::where('status', 'paid')->count(),
            'total_amount' => MaintenanceHeadInvoice::sum('total_amount'),
        ];

        return view('livewire.v1.maintenance.invoice-index', ['invoices' => $invoices, 'stats' => $stats]);
    }
}
