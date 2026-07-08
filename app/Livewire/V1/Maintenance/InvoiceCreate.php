<?php

namespace App\Livewire\V1\Maintenance;

use App\Models\asset;
use App\Models\MaintenanceBodyInvoice;
use App\Models\MaintenanceHeadInvoice;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InvoiceCreate extends Component
{
    public $IsEdit = false;

    public $invoiceNumber;

    public $search = '';

    public $results = [];

    public $selectedId = null;

    public $suppliers = [];

    public $supplier_id = null;

    public $select_list = [];

    public $invoice_date = null;

    public $selected_items = [];

    public $suppliers_id = null;

    public $total_amount = 0;

    public $invoice_number = 0;

    public $status;

    public function mount()
    {
        $this->select_list = [];
        $invoice = MaintenanceHeadInvoice::latest()->first();
        $this->invoice_number = $invoice ? $invoice->invoice_number + 1 : 1;
        $this->suppliers = Supplier::all();
        $this->invoice_date = Carbon::now()->format('Y-m-d');
        $this->addItem();
    }

    public function addItem()
    {
        $this->selected_items[] = ['asset_id' => '', 'reason' => ''];
    }

    public function removeItem($index)
    {
        unset($this->selected_items[$index]);
        $this->selected_items = array_values($this->selected_items);
    }

    public function save()
    {

        $this->validate([
            'suppliers_id' => 'required',
            'selected_items.*.asset_id' => 'required',
            'selected_items.*.reason' => 'nullable|string|max:255',
        ]);
        $invoice = MaintenanceHeadInvoice::create([
            'invoice_number' => $this->invoice_number,
            'supplier_id' => $this->suppliers_id,
            'total_amount' => $this->total_amount,
            'invoice_date' => $this->invoice_date,
            'status' => $this->status,
            'user_id' => Auth::id(),
            'received_by' => Auth::id(),
        ]);
        if ($invoice) {
            foreach ($this->selected_items as $item) {
                $assetExists = asset::where('id', $item['asset_id'])->exists();

                if ($assetExists) {
                    MaintenanceBodyInvoice::create([
                        'asset_id' => $item['asset_id'],
                        'reason' => $item['reason'],
                        'maintenance_head_invoice_id' => $invoice->id,
                    ]);
                } else {
                    session()->flash('error', "Asset ID {$item['asset_id']} not found!");
                }
            }
            $this->reset(['selected_items', 'invoice_number', 'suppliers_id', 'invoice_date']);
            session()->flash('success', 'Invoice saved successfully!');
        }
    }

    public function searchInAsset()
    {

        $results = asset::query()
            ->where(function ($query) {
                $query->where('id', 'like', "%$this->search%")
                    ->orWhere('asset_tag', 'like', "%$this->search%")
                    ->orWhere('serial_number', 'like', "%$this->search%");
            })
            ->get();

        $this->results = $results;
    }

    public function render()
    {
        $assets = asset::all();

        return view('livewire.v1.maintenance.invoice-create', compact('assets'));
    }
}
