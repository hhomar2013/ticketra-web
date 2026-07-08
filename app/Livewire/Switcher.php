<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Switcher extends Component
{
    public Model $model;
    public string $field;
    public bool $isPublished;
    public $dispatch = '';
    public function mount()
    {

        $this->isPublished = (bool) $this->model->getAttribute($this->field);
    }
    public function render()
    {
        return view('livewire.switcher');
    }

    public function updatedIsPublished($value)
    {
        $update = $this->model->setAttribute($this->field, $value)->save();
        if ($update) {
            $this->dispatch($this->dispatch);
        }
    }
}
