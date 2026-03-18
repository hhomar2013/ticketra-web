<?php

namespace App\Livewire\V1\Hardware\Brands;

use App\Models\brand;
use App\Models\type_model;
use Livewire\Component;

class BrandsModels extends Component
{
    public $brandId;
    public $brands;
    public $models;
    public $name;
    public $modelId;
    public $IsEdit = false;
    protected $listeners = ['modelsRefresh' => 'mount' ,'delete-model' =>'deleteModel'];
    public function mount($id)
    {
        $this->brands = brand::query()->find($id);
        $this->brandId = $id;
        $this->models = type_model::query()->where('brand_id', $id)->get();
    }


    public function submitModel()
    {
        $this->validate([
            'name' => 'required'
        ]);

        $save =   type_model::updateOrCreate(['id' => $this->modelId], [
            'name' => $this->name,
            'brand_id' => $this->brandId,
        ]);
        if ($save) {
            $this->dispatch('show-toast', [
                'type' => 'success',
                'message' => 'Model saved successfully',
            ]);
            $this->mount($this->brandId);
            $this->reset(['name', 'modelId']);
        }
    }

    public function deleteModel($id)
    {
        $delete = type_model::query()->find($id);
        $delete->delete();
        $this->mount($this->brandId);
    }

    public function render()
    {
        return view('livewire.v1.hardware.brands.brands-models');
    }
}
