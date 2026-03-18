<?php

namespace App\Livewire\V1\Hardware\Assets;

use App\Models\asset;
use Livewire\Component;
use App\Models\asset_category;
use App\Models\branch;
use App\Models\brand;
use App\Models\Category;
use App\Models\type_model;
use Illuminate\Support\Facades\Auth;

class AssetsCreate extends Component
{

    public $asset_tag;
    public $serial_number;
    public $branch_id;
    public $asset_category_id;
    public $categories, $category_id;
    public $branches;
    public $brands;
    public $brand_id;
    public $type_models, $type_model_id;
    public $purchase_date;
    public $warranty_expiry;
    public $asset;
    public $isEdit = false;
    public $assetId;

    public function mount($id = null)
    {
        if ($id) {
            $this->asset = asset::find($id);
            $q = $this->asset;
            $this->isEdit = true;
            $this->assetId =  $q->id;
            $this->asset_tag = $q->asset_tag;
            $this->serial_number = $q->serial_number;
            $this->branch_id = $q->branch_id;
            $this->category_id = $q->category_id;
            $this->brand_id = $q->brand_id;
            $this->type_model_id =  $q->type_model_id;
            $this->purchase_date = $q->purchase_date;
            $this->warranty_expiry = $q->warranty_expiry;
            $this->getTypeModels();
        }
        $this->categories = asset_category::all();
        $this->branches = branch::all();
        $this->brands = brand::all();


        // dd($this->categories, $this->branches, $this->type_models);
    }

    public function getTypeModels()
    {
        $id =  $this->brand_id;
        $this->type_models = type_model::query()->where('brand_id', '=', $id)->get();
        // dd($this->type_models);
    }


    public function submit()
    {
        $rules = [
            'asset_tag' => 'required' . ($this->isEdit ? "|unique:assets,asset_tag,$this->assetId" : ''),
            'serial_number' => 'required',
            'category_id' => 'required',
            'branch_id' => 'required',
            'brand_id' => 'required',
            'type_model_id' => 'required',
            'purchase_date' => 'required',
            'warranty_expiry' => 'required',
        ];

        $this->validate($rules);

        $data = [
            'asset_tag' => $this->asset_tag,
            'serial_number' => $this->serial_number,
            'category_id' => $this->category_id,
            'branch_id' => $this->branch_id,
            'brand_id' => $this->brand_id,
            'type_model_id' => $this->type_model_id,
            'purchase_date' => $this->purchase_date,
            'warranty_expiry' => $this->warranty_expiry,
        ];

        if ($this->isEdit) {
            asset::find($this->assetId)->update($data);
            $this->dispatch('refreshAssetTable');
        } else {
            $data['status'] = 'available';
            $data['user_id'] = Auth::user()->id;
            asset::create($data);
        }

        $this->reset(['asset_tag', 'serial_number', 'category_id', 'branch_id', 'brand_id', 'type_model_id', 'purchase_date', 'warranty_expiry']);
        // $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Asset ' . ($this->isEdit ? 'updated' : 'saved') . ' successfully.']);
        return redirect()->route('hardware.assets.index');
    }





    public function backToAssets()
    {
        return redirect()->route('hardware.assets.index');
    }

    public function render()
    {
        return view('livewire.v1.hardware.assets.assets-create');
    }
}
