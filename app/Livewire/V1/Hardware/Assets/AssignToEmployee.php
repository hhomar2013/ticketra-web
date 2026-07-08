<?php
namespace App\Livewire\V1\Hardware\Assets;

use App\Models\asset;
use App\Models\AssetAssignment;
use App\Models\branch;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Core\Enum\AssetStatus as AssetStatusEnum;
class AssignToEmployee extends Component
{

    public $asset;
    public $employees;
    public $employee_id;
    public $search;
    public $branch, $branch_id;
    public $notes;
    public function mount($id = null)
    {
        $this->branch = branch::all();
        $this->asset = asset::find($id);
        // ✅ جيب الـ IDs اللي عندهم assets مرتبطة بيهم
        $assignedUserIds = asset::whereNotNull('user_id')
            ->where('status', AssetStatusEnum::Assigned->value)
            ->pluck('user_id');

        // ✅ استثنيهم
        $this->employees = User::query()
            // ->role('user')
            // ->whereNotIn('id', $assignedUserIds)
            ->latest()
            ->get();
    }

    public function updatedEmployeeId()
    {
        // $this->asset->employee_id = $this->employee_id;
        // dd($this->asset->employee_id);
    }
    public function assignToEmployee()
    {
        $this->validate([
            'employee_id' => 'required',
            'branch_id' => 'required',
        ]);

        $q = AssetAssignment::query()->create([
            'asset_id' => $this->asset->id,
            'user_id' => $this->employee_id,
            'branch_id' => $this->branch_id,
            'assigned_by' => Auth::user()->id,
            'assigned_at' => now(),
            'condition_on_assign' => __('Asset Assigned to Employee'),
            'notes' => $this->notes ?? '',
            'status' => AssetStatusEnum::Assigned->value

        ]);
        if ($q) {
            $this->dispatch('alert', type: 'success', message: __('Asset Assigned to Employee Successfully'));
            return redirect()->route('hardware.assets.index');
        } else {
            $this->dispatch('alert', type: 'error', message: __('Asset Assigned to Employee Failed'));
        }
    }

    public function render()
    {
        return view('livewire.v1.hardware.assets.assign-to-employee');
    }
}
