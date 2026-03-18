<?php
namespace App\Livewire\V1\Invoices;

use App\Models\Invoices;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class InvoicesIndex extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $statusFilter = '';
    public int $perPage         = 10;

    public function updatingSearch(): void
    {$this->resetPage();}
    public function updatingStatusFilter(): void
    {$this->resetPage();}

    public function updateStatus(int $id, string $status): void
    {
        Invoices::findOrFail($id)->update(['status' => $status]);
        $this->dispatch('show-toast', [
            'message' => __('Invoice status updated'),
            'type'    => 'success',
        ]);
    }

    public function deleteInvoice(int $id): void
    {
        Invoices::findOrFail($id)->delete();
        $this->dispatch('show-toast', [
            'message' => __('Invoice deleted successfully'),
            'type'    => 'success',
        ]);
    }

    #[On('refreshInvoices')]
    public function render()
    {
        $invoices = Invoices::query()
            ->with(['supplier', 'batches'])
            ->when($this->search, fn($q) =>
                $q->where('invoice_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('supplier', fn($q) =>
                        $q->where('name', 'like', '%' . $this->search . '%')
                    )
            )
            ->when($this->statusFilter, fn($q) =>
                $q->where('status', $this->statusFilter)
            )
            ->latest()
            ->paginate($this->perPage);

        $stats = [
            'total'        => Invoices::count(),
            'pending'      => Invoices::where('status', 'pending')->count(),
            'paid'         => Invoices::where('status', 'paid')->count(),
            'total_amount' => Invoices::sum('total_amount'),
        ];

        return view('livewire.v1.invoices.invoices-index', compact('invoices', 'stats'));
    }
}
