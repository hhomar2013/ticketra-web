<?php

namespace App\Livewire\V1\Hardware\Brands;

use App\Models\brand;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class BrandsCreate extends Component
{
    use WithFileUploads;
    protected $listeners = ['brand-created' => 'mount'];
    public $IsEdit = false;
    public $name;
    public $logo, $old_logo;
    public $brandId;
    public $brand;
    public function mount($id = null)
    {
        if ($id) {
            $this->IsEdit = true;
            $this->brand = brand::find($id);
            $this->name = $this->brand->name;
            $this->old_logo = $this->brand->logo;
            $this->brandId = $id;
        }
    }

    public function submitBrand()
    {
        $this->validate([
            'name' => 'required',
            'logo' => 'required',
        ]);
        $image = $this->logo->store('brands', 'public');
        $brand =   brand::updateOrCreate(['id' => $this->brandId], [
            'name' => $this->name,
            'logo' => $image,
        ]);
        if ($brand) {
            $this->dispatch('brand-created');
            $this->reset(['name', 'logo']);
            $this->dispatch('show-toast', ['message' => 'Brand created successfully', 'type' => 'success']);
        }
    }

    public function backToBrands()
    {
        return redirect()->route('hardware.brands');
    }

    public function render()
    {
        return view('livewire.v1.hardware.brands.brands-create');
    }
}
