<?php
namespace App\Livewire\V1\Hardware\Brands;

use App\Models\brand;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class BrandsIndex extends Component
{
    use WithFileUploads;

    public $brands;
    public $action       = 'index';
    protected $listeners = ['brandsRefresh' => 'mount', 'delete-brand' => 'deleteBrand'];

    public function mount()
    {
        $this->brands = brand::all();
    }

    public function changeAction($action)
    {
        $this->action = $action;
    }

    public function createBrand()
    {
        $this->changeAction('create');
    }

    public function editBrand($id)
    {
        return redirect()->route('hardware.brands.edit', ['id' => $id]);
    }

    public function deleteBrand($id)
    {
        $brand = brand::find($id);
        $brand->delete();
        $this->dispatch('brandsRefresh');
        $this->dispatch('show-toast', [
            'type'    => 'success',
            'message' => 'Brand deleted successfully',
        ]);
    }

    public function render()
    {
        return view('livewire.v1.hardware.brands.brands-index');
    }
}
