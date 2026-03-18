<?php

namespace App\Livewire\V1\Maintenance;

use App\Models\asset;
use App\Models\MaintenanceHeadInvoice;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use function Symfony\Component\Clock\now;

class InvoiceCreate extends Component
{
    public $invoiceNumber;
    public $search = '';
    public $results = [];
    public $selectedId = null;
    public $suppliers = [];
    public $supplier_id = null;
    public $select_list = [];
    public $invoice_date = null;

    public function mount()
    {
        $this->select_list = [];
        $invoice = MaintenanceHeadInvoice::latest()->first();
        $this->invoiceNumber = $invoice ? $invoice->invoice_number + 1 : 1;
        $this->suppliers = Supplier::all();
        $this->invoice_date = Carbon::now()->format('Y-m-d');
    }


    public function save()
    {
        // 1. إنشاء الفاتورة الرأسية
        $invoice = MaintenanceHeadInvoice::create([
            'invoice_number' => $this->invoiceNumber,
            'supplier_id'    => $this->supplier_id,
            'invoice_date'   => $this->invoice_date,
            'user_id'        => Auth::id(),
            'received_by'    => Auth::id(),
        ]);

        foreach ($this->select_list as $item) {
            $assetExists = \App\Models\Asset::where('id', $item['id'])->exists();

            if ($assetExists) {
                $invoice->items()->create([
                    'asset_id' => $item['id'],
                ]);
            } else {
                session()->flash('error', "Asset ID {$item['id']} not found!");
            }
        }

        $this->reset(['select_list', 'search']);
        session()->flash('success', 'Invoice saved successfully!');
    }


    public function deleteItem($id)
    {
        $this->select_list = array_filter($this->select_list, function ($item) use ($id) {
            return $item['id'] !== $id;
        });
        $this->select_list = array_values($this->select_list);
    }

    public function clearList()
    {
        $this->select_list = [];
    }

    public function select($asset)
    {
        if (is_numeric($asset)) {
            return;
        }

        $assetArray = is_object($asset) ? $asset->toArray() : $asset;

        $id = $assetArray['id'];
        $exists = false;
        foreach ($this->select_list as $key => $item) {
            if ($item['id'] === $id) {
                unset($this->select_list[$key]);
                $exists = true;
                break;
            }
        }

        if (!$exists) {
            $this->select_list[] = $assetArray;
        }

        $this->select_list = array_values($this->select_list);
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
        return view('livewire.v1.maintenance.invoice-create');
    }
}
