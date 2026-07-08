<?php
namespace App\Livewire\V1\Hardware\AssetCategories;

use App\Models\asset_category;
use Livewire\Component;

class AssetCategoriesIndex extends Component
{
    public $categories;
    public $action = 'index';
    public $category_id;
    protected $listeners = ['refreshCategoryTable' => 'mount', 'delete-category' => 'deleteCategory'];
    public function mount()
    {
        $this->categories = asset_category::all();
    }

    public function changeAction($action)
    {
        $this->action = $action;
    }

    public function editCategory($id)
    {
        $this->changeAction('edit');
        $this->category_id = $id;
    }

    public function createCategory()
    {
        return redirect()->route('hardware.asset-categories.create');
    }

    public function deleteCategory($id)
    {
        $category = asset_category::find($id);
        $category->delete();
        $this->dispatch('refreshCategoryTable');
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => 'Category deleted successfully',
        ]);
    }

    public function render()
    {
        return view('livewire.v1.hardware.asset-categories.asset-categories-index');
    }
}
