<?php

namespace App\Livewire\V1\Invoices;

use App\Models\AssetBatch;
use App\Models\Invoices;
use App\Models\Supplier;
use Livewire\Component;

class InvoiceCreate extends Component
{
    public ?int $invoiceId = null;

    public bool $IsEdit = false;

    // ── Invoice Fields ──
    public string $invoice_number = '';

    public string $invoice_date = '';

    public string $suppliers_id = '';

    public string $total_amount = '';

    public string $status = 'pending';

    public string $notes = '';

    // ── Batch Fields ──
    public string $batch_number = '';

    public string $received_date = '';

    public string $batch_status = 'pending';

    public string $batch_notes = '';

    public bool $addBatch = true;

    public function mount(?int $id = null): void
    {
        $this->invoice_date = now()->format('Y-m-d');
        $this->received_date = now()->format('Y-m-d');
        $this->batch_number = 'BATCH-' . now()->format('Y') . '-' . str_pad(AssetBatch::count() + 1, 3, '0', STR_PAD_LEFT);

        if ($id) {
            $invoice = Invoices::with('batches')->findOrFail($id);
            $this->invoiceId = $id;
            $this->IsEdit = true;
            $this->invoice_number = $invoice->invoice_number;
            $this->invoice_date = $invoice->invoice_date;
            $this->suppliers_id = $invoice->suppliers_id;
            $this->total_amount = $invoice->total_amount;
            $this->status = $invoice->status;
            $this->notes = $invoice->notes ?? '';
            $this->addBatch = false;
        }
    }

    public function save()
    {
        $this->validate([
            'invoice_number' => 'required|string|unique:invoices,invoice_number' . ($this->invoiceId ? ',' . $this->invoiceId : ''),
            'invoice_date' => 'required|date',
            'suppliers_id' => 'required|exists:suppliers,id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,paid',
        ]);

        if ($this->addBatch && !$this->IsEdit) {
            $this->validate([
                'batch_number' => 'required|string|unique:asset_batches,batch_number',
                'received_date' => 'required|date',
                'batch_status' => 'required|in:pending,stocked,partial',
            ]);
        }

        if ($this->IsEdit) {
            $invoice = Invoices::findOrFail($this->invoiceId);
            $invoice->update([
                'invoice_number' => $this->invoice_number,
                'invoice_date' => $this->invoice_date,
                'suppliers_id' => $this->suppliers_id,
                'total_amount' => $this->total_amount,
                'status' => $this->status,
                'notes' => $this->notes,
            ]);
        } else {
            $invoice = Invoices::create([
                'invoice_number' => $this->invoice_number,
                'invoice_date' => $this->invoice_date,
                'suppliers_id' => $this->suppliers_id,
                'total_amount' => $this->total_amount,
                'status' => $this->status,
                'notes' => $this->notes,
            ]);

            if ($this->addBatch) {
                AssetBatch::create([
                    'invoice_id' => $invoice->id,
                    'batch_number' => $this->batch_number,
                    'received_date' => $this->received_date,
                    'status' => $this->batch_status,
                    'notes' => $this->batch_notes,
                ]);
            }
        }

        $this->dispatch('show-toast', [
            'message' => $this->IsEdit ? __('Invoice updated successfully') : __('Invoice created successfully'),
            'type' => 'success',
        ]);

        return redirect()->route('invoices.index');
    }

    public function render()
    {
        $suppliers = Supplier::orderBy('name')->get();

        return view('livewire.v1.invoices.invoice-create', compact('suppliers'));
    }
}
