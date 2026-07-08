<?php

namespace App\Livewire\V1\Hardware\Assets;

use App\Models\asset;
use App\Models\asset_attribute;
use App\Models\attributes;
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
    public $specs = [];

    public $spec_values = [];
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
            $this->assetId = $q->id;
            $this->asset_tag = $q->asset_tag;
            $this->serial_number = $q->serial_number;
            $this->branch_id = $q->branch_id;
            $this->category_id = $q->category_id;
            $this->brand_id = $q->brand_id;
            $this->type_model_id = $q->type_model_id;
            $this->purchase_date = $q->purchase_date;
            $this->warranty_expiry = $q->warranty_expiry;
            $this->getTypeModels();

            $this->spec_values = $this->asset->specs()
                ->pluck('value', 'attribute_id')
                ->toArray();
        }
        $this->categories = asset_category::all();
        $this->branches = branch::all();
        $this->brands = brand::all();
        $this->specs = attributes::query()->active();



        // dd($this->categories, $this->branches, $this->type_models);
    }

    public function getTypeModels()
    {
        $id = $this->brand_id;
        $this->type_models = type_model::query()->where('brand_id', '=', $id)->get();
        // dd($this->type_models);
    }


    // public function submit()
    // {
    //     $rules = [
    //         'asset_tag' => 'required' . ($this->isEdit ? "|unique:assets,asset_tag,$this->assetId" : ''),
    //         'serial_number' => 'required',
    //         'category_id' => 'required',
    //         'branch_id' => 'required',
    //         'brand_id' => 'required',
    //         'type_model_id' => 'required',
    //         'purchase_date' => 'required',
    //         'warranty_expiry' => 'required',
    //         'spec_values.*' => 'nullable|string|max:255',
    //     ];

    //     $this->validate($rules);

    //     $data = [
    //         'asset_tag' => $this->asset_tag,
    //         'serial_number' => $this->serial_number,
    //         'category_id' => $this->category_id,
    //         'branch_id' => $this->branch_id,
    //         'brand_id' => $this->brand_id,
    //         'type_model_id' => $this->type_model_id,
    //         'purchase_date' => $this->purchase_date,
    //         'warranty_expiry' => $this->warranty_expiry,
    //     ];

    //     if ($this->isEdit) {
    //         asset::find($this->assetId)->update($data);
    //         $this->dispatch('refreshAssetTable');
    //     } else {
    //         $data['status'] = 'available';
    //         $data['user_id'] = Auth::user()->id;
    //         $asset = asset::create($data);
    //     }

    //     foreach ($this->specs as $spec) {
    //         asset_attribute::query()->create([
    //             'asset_id' => $asset->id,
    //             'attribute_id' => $spec->id,
    //             'value' => $this->spec_values[$spec->id] ?? '',
    //         ]);
    //     }

    //     $this->reset(['asset_tag', 'serial_number', 'category_id', 'branch_id', 'brand_id', 'type_model_id', 'purchase_date', 'warranty_expiry']);
    //     // $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Asset ' . ($this->isEdit ? 'updated' : 'saved') . ' successfully.']);
    //     return redirect()->route('hardware.assets.index');
    // }

    public function submit()
    {
        $rules = [
            // تعديل بسيط: يفضل استخدام الفاصلة مع الـ unique للإصدارات الأحدث، ولكن طريقتك شغالة
            // 'asset_tag' => 'required' . ($this->isEdit ? "|unique:assets,asset_tag,$this->assetId" : "|unique:assets,asset_tag"),
            'serial_number' => 'required',
            'category_id' => 'required',
            'branch_id' => 'required',
            'brand_id' => 'required',
            'type_model_id' => 'required',
            'purchase_date' => 'required',
            'warranty_expiry' => 'required',
            'spec_values.*' => 'nullable|string|max:255',
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

        // حل المشكلة الأولى: نعرف متغير $asset في الحالتين
        if ($this->isEdit) {
            $asset = asset::find($this->assetId);
            $asset->update($data);
            $this->dispatch('refreshAssetTable');
        } else {
            $data['status'] = 'available';
            $data['user_id'] = Auth::user()->id;
            $asset = asset::create($data);
        }

        // حل المشكلة الثانية: الحفظ الذكي للمواصفات
        foreach ($this->specs as $spec) {
            // لو القيمة فاضية ممكن ما تحفظهاش عشان توفر مساحة (اختياري)
            $value = $this->spec_values[$spec->id] ?? '';

            asset_attribute::query()->updateOrCreate(
                [
                    // الشروط اللي بيبحث بيها (لو لقى السطر ده هيعدله)
                    'asset_id' => $asset->id,
                    'attribute_id' => $spec->id,
                ],
                [
                    // القيمة اللي هتتحدث أو تتكريت جديدة
                    'value' => $value,
                ]
            );
        }

        // تفريغ المدخلات
        $this->reset(['asset_tag', 'serial_number', 'category_id', 'branch_id', 'brand_id', 'type_model_id', 'purchase_date', 'warranty_expiry', 'spec_values']);

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
