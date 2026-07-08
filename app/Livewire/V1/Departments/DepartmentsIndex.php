<?php

namespace App\Livewire\V1\Departments;

use App\Models\Category;
use Livewire\Component;

class DepartmentsIndex extends Component
{
    public $header = 'Departments';
    public $departments = [];
    public $departmentId = null;
    public $action = 'index';
    public $is_active;
    protected $listeners = ['refreshDepartmentTable' => '$refresh', 'delete-department' => 'deleteDepartment'];

    public function mount()
    {
        $this->departments = Category::all();
    }

    public function editDepartment($id)
    {
        $this->action = 'edit';
        $this->departmentId = $id;
    }

    public function deleteDepartment($id)
    {
        $department = Category::findOrFail($id);
        $department->delete();
        $this->dispatch('show-toast', [
            'type' => 'error',
            'message' => 'Department deleted successfully'
        ]);
        $this->dispatch('refreshDepartmentTable');
    }

    public function changeAction($action)
    {
        $this->action = $action;
    }

    public function render()
    {
        return view('livewire.v1.departments.departments-index');
    }
}
