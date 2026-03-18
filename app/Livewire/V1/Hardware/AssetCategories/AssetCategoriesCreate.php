<?php
namespace App\Livewire\V1\Hardware\AssetCategories;

use App\Models\asset_category;
use Livewire\Component;

class AssetCategoriesCreate extends Component
{
    public $category = null;
    public $IsEdit   = false;
    public $name;
    public $slug;
    public $description;
    public $category_id;
    protected $listeners = ['refreshCategoryTable' => 'mount'];
    public function mount($id = null)
    {
        if ($id) {
            $this->category    = asset_category::find($id);
            $this->IsEdit      = true;
            $this->name        = $this->category->name;
            $this->slug        = $this->category->slug;
            $this->description = $this->category->description;
            $this->category_id = $id;
        }
    }
    public function updatedName($value): void
    {
        if (! $this->IsEdit) {
            $this->slug = \Illuminate\Support\Str::slug($value);
        }
    }

    public function submitCategory()
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);

        asset_category::query()->updateOrCreate([
            'id' => $this->category_id,
        ], [
            'name'        => $this->name,
            'slug'        => $this->slug,
            'description' => $this->description,
        ]);

        $this->name        = '';
        $this->slug        = '';
        $this->description = '';

        $this->dispatch('refreshCategoryTable');
        $this->dispatch('show-toast', [
            'type'    => 'success',
            'message' => 'Category saved successfully',
        ]);
    }

    public function backToCategory()
    {
        return redirect()->route('hardware.asset-categories');
    }

    public function render()
    {
        return view('livewire.v1.hardware.asset-categories.asset-categories-create');
    }
}
