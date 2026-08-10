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
    public $selectedAsset;
    public $perPage = 10;


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



    public function viewAsset($id)
    {
        $this->selectedAsset = [];
        $this->selectedAsset = AssetAssignment::query()->where('user_id', $id)->with('asset')->get();
        $this->dispatch('show-view-modal');
    }

    public function render()
    {
        return view('livewire.v1.hardware.assets.assets-assigned');
    }
}
