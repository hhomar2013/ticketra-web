<?php

namespace App\Livewire\V1\Hardware\SpecsTypes;

use App\Models\attributes;
use Livewire\Attributes\Rule;
use Livewire\Component;

class StCreate extends Component
{
    protected $listeners = ['cancel' => 'cancelForm', 'edit' => 'editForm'];


    #[Rule('required', message: 'The name field is required')]
    public $name;
    #[Rule('required', message: 'The type field is required')]
    public $type = 'text';
    public $id;
    public $attribute;
    public $is_active;
    public $action = 'create';

    public function mount($id = null)
    {
        if ($id) {
            $this->id = $id;
            $this->attribute = attributes::find($id);
            $this->name = $this->attribute->name;
            $this->type = $this->attribute->type;
            $this->action = 'edit';
        }
    }

    public function save()
    {

        $this->validate();
        attributes::query()->updateOrCreate(
            ['id' => $this->id],
            [
                'name' => $this->name,
                'type' => $this->type,
            ]
        );
        $this->reset('name');
        $this->resetValidation();
        $this->dispatch('refreshAttributes');
        $this->action == 'edit' ? $this->dispatch('cancel') : '';
    }

    public function render()
    {
        return view('livewire.v1.hardware.specs-types.st-create');
    }
}
