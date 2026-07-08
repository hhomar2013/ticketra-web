<?php

namespace App\Livewire\V1\Hardware\Assets;

use App\Models\asset;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.print')]
class AssetReport extends Component
{
    public $asset;
    public function mount($id)
    {
        $this->asset = asset::with([
            'specs' => function ($query) {
                $query->orderBy('attribute_id', 'asc');
            },
            'assignments.user'
        ])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.v1.hardware.assets.asset-report');
    }
}
