<?php

namespace App\Livewire\V1\Departments;

use App\Models\Category;
use Livewire\Component;

class DepartmentsCreate extends Component
{
    public $action = 'create';
    public $name;

    public $departmentId;


    public function render()
    {
        return view('livewire.v1.departments.departments-create');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
        ]);

        Category::updateOrInsert(['id' => $this->departmentId], [
            'name' => $this->name,
        ]);
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => __('Department created successfully')
        ]);
        $this->reset();
        $this->dispatch('refreshDepartmentTable');

    }


}
