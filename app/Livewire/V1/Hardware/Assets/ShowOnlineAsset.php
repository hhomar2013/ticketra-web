<?php

namespace App\Livewire\V1\Hardware\Assets;

use App\Models\AssetOnline;
use Livewire\Component;

class ShowOnlineAsset extends Component
{
    public $asset;

    public function mount($id)
    {
        $this->asset = AssetOnline::find($id);

    }

    public function render()
    {
        return view('livewire.v1.hardware.assets.show-online-asset');
    }
}
