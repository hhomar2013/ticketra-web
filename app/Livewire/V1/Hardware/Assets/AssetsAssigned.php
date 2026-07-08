<?php
namespace App\Livewire\V1\Hardware\Assets;

use App\Core\Enum\AssetReturnStatus;
use App\Models\asset;
use App\Models\AssetAssignment;
use App\Models\asset_transfer;
use App\Models\branch;
use App\Models\brand;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use App\Core\Enum\AssetStatus;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AssetsTemplateExport;

class AssetsAssigned extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $branches;
    public $branch_id;
    public $status = ['assigned'];
    public $search;
    public $sortField = 'id';
    public $sortDirection = 'asc';
    public $searchField = 'id';
    public $IsReturn = false;
    public $selectedAsset;
    public $condition_on_return = '', $notes = '', $returned_at;
    public $perPage = 10;
    protected $listeners = [
        'refreshAssetTable' => 'mount',
        'delete-asset' => 'deleteAsset',
    ];

    public $returnStatuses;

    public function mount()
    {
        // $this->branches = branch::all();
        // $this->returnStatuses = AssetReturnStatus::cases();
    }

    #[Computed]
    public function assets()
    {
        return User::query()
            ->with('assets.assignments')
            ->whereHas('assets', function ($query) {
                $query->where('status', AssetStatus::Assigned->value);
            })
            ->paginate($this->perPage);
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->mount();
    }

    public function createAsset()
    {
        return redirect()->route('hardware.assets.create');
    }

    public function editAsset($id)
    {
        return redirect()->route('hardware.assets.edit', $id);
    }

    public function sortBy($field, $value = null)
    {
        if ($field !== $this->sortField) {
            $this->sortDirection = 'asc';
        } else {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        }

        $this->sortField = $field;
        $this->searchField = $value;
        $this->mount();
    }

    public function reverseSort()
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        $this->mount();
    }

    public function deleteAsset($id)
    {
        asset::find($id)->delete();
        $this->dispatch('refreshAssetTable');
    }

    public function historyAsset($id)
    {
        return redirect()->route('hardware.assets.history', $id);
    }

    public function assignToEmployee($id)
    {
        return redirect()->route('hardware.assets.assign-to-employee', $id);
    }

    public function assetReceipt($id)
    {
        return redirect()->route('assets-reports.index', ['id' => $id]);
    }

    public function returnToBranch($id)
    {
        $this->IsReturn = true;
        $this->dispatch('return-to-branch', ['id' => $id]);
    }

    public function openReturnModal($id)
    {
        $this->selectedAsset = asset::find($id);
        $this->dispatch('show-return-modal');
    }

    public function confirmReturn()
    {
        $assignment = AssetAssignment::where('asset_id', $this->selectedAsset->id)
            ->whereNull('returned_at')
            ->first();
        $this->validate([
            'condition_on_return' => 'required',
            'returned_at' => 'required',
            'branch_id' => 'required',
        ]);

        if ($assignment) {
            $assignment->update([
                'returned_at' => now(),
                'condition_on_return' => $this->condition_on_return,
                'returned_at' => $this->returned_at,
                'notes' => $this->notes,
            ]);
            $asset = asset::find($this->selectedAsset->id);
            $asset->update([
                'status' => 'available',
                'branch_id' => $this->branch_id,
            ]);

            asset_transfer::create([
                'asset_id' => $asset->id,
                'from_branch_id' => $assignment->branch_id,
                'to_branch_id' => $this->branch_id,
                'action_by' => Auth::user()->id,
                'reason' => $this->condition_on_return,
            ]);
        }

        $this->dispatch('hide-return-modal');
        $this->dispatch('refreshAssetTable');
        $this->reset(['selectedAsset', 'condition_on_return', 'returned_at', 'notes', 'branch_id']);
    }

    public function viewAsset($id)
    {
        $this->selectedAsset = [];
        $this->selectedAsset = AssetAssignment::query()->where('user_id', $id)->with('asset')->get();
        $this->dispatch('show-view-modal');
    }

    public function downloadTemplate()
    {
        $branches = Branch::pluck('name')->toArray();
        $categories = Category::pluck('name')->toArray();

        $brandsWithModels = Brand::with('typeModels')->get()->mapWithKeys(function ($brand) {
            $models = $brand->typeModels ? $brand->typeModels->pluck('name')->toArray() : [];
            return [$brand->name => $models];
        })->toArray();

        return Excel::download(
            new AssetsTemplateExport($branches, $categories, $brandsWithModels),
            'assets_import_template.xlsx'
        );
    }

    public function render()
    {
        return view('livewire.v1.hardware.assets.assets-assigned');
    }
}
