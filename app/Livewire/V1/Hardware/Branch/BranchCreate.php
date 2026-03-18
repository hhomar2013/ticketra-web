<?php
namespace App\Livewire\V1\Hardware\Branch;

use App\Models\branch;
use Livewire\Component;

class BranchCreate extends Component
{

    public $name;
    public $address;
    public $phone;
    public $email;
    public $description;
    public $location;
    public $IsEdit   = false;
    public $branch   = null;
    public $branchId = null;
    public function mount($id = null)
    {
        if ($id) {
            $this->IsEdit      = true;
            $this->branch      = branch::query()->findOrFail($id);
            $this->name        = $this->branch->name;
            $this->phone       = $this->branch->phone;
            $this->email       = $this->branch->email;
            $this->description = $this->branch->description;
            $this->location    = $this->branch->location;
            $this->branchId    = $id;
        }
    }

    public function backToBranches()
    {

        return redirect()->route('settings.config', ['page' => 'branches']);
    }

    public function createBranch()
    {
        $this->validate([
            'name'  => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        $create = branch::query()->updateOrCreate([
            'id' => $this->branchId,
        ], [
            'name'        => $this->name,
            'phone'       => $this->phone,
            'email'       => $this->email,
            'description' => $this->description ?? '',
            'location'    => $this->location ?? '',
        ]);

        if ($create) {
            $this->name        = '';
            $this->phone       = '';
            $this->email       = '';
            $this->description = '';
            $this->location    = '';

            $this->dispatch('refreshBranchTable');
            // $this->dispatch('show-toast', [
            //     'type'    => 'success',
            //     'message' => 'Branch saved successfully',
            // ]);
            $this->redirect('/settings/config?page=branches', navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.v1.hardware.branch.branch-create');
    }
}
