<?php

namespace App\Livewire\V1\Hardware\SpecsTypes;

use App\Models\attributes;
use App\Models\V1\Hardware\SpecsType;
use App\Models\V1\Hardware\Category;
use Livewire\Component;

class StIndex extends Component
{
    public $action = 'index';
    public $attribute_id;
    public $is_active = false;
    protected $listeners = ['cancel' => 'cancelForm', 'refreshAttributes' => 'render', 'delete-specs' => 'delete'];

    public function changeAction($action)
    {
        $this->action = $action;
    }

    public function editAttribute($id)
    {
        $this->changeAction('edit');
        $this->attribute_id = $id;

    }


    public function cancelForm()
    {
        $this->action = 'index';
        $this->category_id = null;
    }

    public function delete($id)
    {
        $attribute = attributes::find($id);
        $attribute->delete();
        $this->dispatch('refreshAttributes');
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => 'Attribute deleted successfully',
        ]);
    }



    public function render()
    {
        $attributes = attributes::get();
        return view('livewire.v1.hardware.specs-types.st-index', [
            'attributes' => $attributes,
        ]);
    }
}
