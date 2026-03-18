<?php
namespace App\Livewire\V1\Invoices;

use App\Models\asset;
use App\Models\AssetBatch;
use App\Models\asset_category;
use App\Models\branch;
use App\Models\brand;
use App\Models\Invoices;
use App\Models\type_model;
use Livewire\Component;

class InvoiceBatches extends Component
{
    public Invoices $invoice;
    protected $listeners = ['removeAsset' => 'removeAsset', 'refreshInvoice' => '$refresh'];
    // ── Add Batch ──
    public bool $showBatchForm   = false;
    public string $batch_number  = '';
    public string $received_date = '';
    public string $batch_status  = 'pending';
    public string $batch_notes   = '';

    // ── Add Asset to Batch ──
    public ?int $selectedBatchId   = null;
    public bool $showAssetForm     = false;
    public string $asset_tag       = '';
    public string $serial_number   = '';
    public string $category_id     = '';
    public string $branch_id       = '';
    public string $brand_id        = '';
    public string $type_model_id   = '';
    public string $purchase_date   = '';
    public string $warranty_expiry = '';
    // public $type_models            = [];
    public function mount(int $id): void
    {
        $this->invoice       = Invoices::with(['supplier', 'batches.assets'])->findOrFail($id);
        $this->received_date = now()->format('Y-m-d');
        $this->purchase_date = now()->format('Y-m-d');
        $this->batch_number  = 'BATCH-' . now()->format('Y') . '-' . str_pad(AssetBatch::count() + 1, 3, '0', STR_PAD_LEFT);

    }

    // ── Batch Methods ──
    public function saveBatch(): void
    {
        $this->validate([
            'batch_number'  => 'required|string|unique:asset_batches,batch_number',
            'received_date' => 'required|date',
            'batch_status'  => 'required|in:pending,stocked,partial',
        ]);

        AssetBatch::create([
            'invoice_id'    => $this->invoice->id,
            'batch_number'  => $this->batch_number,
            'received_date' => $this->received_date,
            'status'        => $this->batch_status,
            'notes'         => $this->batch_notes,
        ]);

        $this->reset(['batch_number', 'batch_notes', 'showBatchForm']);
        $this->batch_number  = 'BATCH-' . now()->format('Y') . '-' . str_pad(AssetBatch::count() + 1, 3, '0', STR_PAD_LEFT);
        $this->received_date = now()->format('Y-m-d');
        $this->batch_status  = 'pending';

        $this->invoice->load('batches.assets');
        $this->dispatch('show-toast', ['message' => __('Batch added successfully'), 'type' => 'success']);
    }

    public function updateBatchStatus(int $batchId, string $status): void
    {
        AssetBatch::findOrFail($batchId)->update(['status' => $status]);
        $this->invoice->load('batches.assets');
        $this->dispatch('show-toast', ['message' => __('Batch status updated'), 'type' => 'success']);
    }

    public function deleteBatch(int $batchId): void
    {
        AssetBatch::findOrFail($batchId)->delete();
        $this->invoice->load('batches.assets');
        $this->dispatch('show-toast', ['message' => __('Batch deleted'), 'type' => 'success']);
    }

    // ── Asset Methods ──
    public function openAssetForm(int $batchId): void
    {
        $this->selectedBatchId = $batchId;
        $this->showAssetForm   = true;
        $this->reset(['asset_tag', 'serial_number', 'category_id', 'branch_id', 'brand_id', 'type_model_id', 'warranty_expiry']);
        $this->purchase_date = now()->format('Y-m-d');
    }

    public function saveAsset(): void
    {
        $this->validate([
            // 'asset_tag'     => 'required|string|unique:assets,asset_tag',
            'serial_number' => 'required|string|unique:assets,serial_number',
            'category_id'   => 'required|exists:asset_categories,id',
            'branch_id'     => 'required|exists:branches,id',
        ]);

        asset::create([
            // 'asset_tag'         => $this->asset_tag,
            'serial_number'   => $this->serial_number,
            'category_id'     => $this->category_id,
            'branch_id'       => $this->branch_id,
            'brand_id'        => $this->brand_id ?: null,
            'type_model_id'   => $this->type_model_id ?: null,
            'purchase_date'   => $this->purchase_date,
            'warranty_expiry' => $this->warranty_expiry ?: null,
            'batch_id'        => $this->selectedBatchId,
            'status'          => 'available',
        ]);

        $this->reset(['asset_tag', 'serial_number', 'category_id', 'branch_id', 'brand_id', 'type_model_id', 'warranty_expiry', 'showAssetForm', 'selectedBatchId']);
        $this->purchase_date = now()->format('Y-m-d');

        $this->invoice->load('batches.assets');
        $this->dispatch('show-toast', ['message' => __('Asset added to batch'), 'type' => 'success']);
    }

    public function removeAsset($id)
    {
        asset::find($id)->delete();
        $this->dispatch('refreshInvoice');
        // $this->invoice->load('batches.assets');
        $this->dispatch('show-toast', ['message' => __('Asset removed'), 'type' => 'success']);
    }

    public function render()
    {
        $categories = asset_category::orderBy('name')->get();
        $branches   = branch::orderBy('name')->get();
        $brands     = brand::orderBy('name')->get();
        $type_model = type_model::where('brand_id', $this->brand_id)->get();
        return view('livewire.v1.invoices.invoice-batches',
            compact('categories', 'branches', 'brands', 'type_model'));
    }
}
