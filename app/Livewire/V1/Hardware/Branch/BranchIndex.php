<?php
namespace App\Livewire\V1\Hardware\Branch;

use App\Models\branch;
use Livewire\Component;

class BranchIndex extends Component
{
    public $header       = 'Branches';
    public $branches     = [];
    public $branchId     = null;
    public $action       = 'index';
    protected $listeners = ['refreshBranchTable' => '$refresh', 'delete-branch' => 'deleteBranch'];

    public function mount()
    {
        $this->branches = branch::all();
    }

    public function editBranch($id)
    {
        $this->action   = 'edit';
        $this->branchId = $id;
    }

    public function deleteBranch($id)
    {
        $branch = branch::findOrFail($id);
        $branch->delete();
        $this->dispatch('show-toast', [
            'type'    => 'error',
            'message' => 'Branch deleted successfully',
        ]);
        $this->dispatch('refreshBranchTable');
    }

    public function changeAction($action)
    {
        $this->action = $action;
    }

    public function render()
    {
        return view('livewire.v1.hardware.branch.branch-index');
    }
}
