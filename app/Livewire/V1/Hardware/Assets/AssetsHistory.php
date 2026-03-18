<?php

namespace App\Livewire\V1\Hardware\Assets;

use App\Models\asset;
use Livewire\Component;

class AssetsHistory extends Component
{
    public $assets;
    public function mount($id)
    {
        $this->assets = asset::with(['history.performer', 'Transfer', 'Transfer.fromBranch', 'Transfer.toBranch', 'history.ticket', 'branch', 'category'])->find($id);
    }
    public function backToAssets()
    {
        return redirect()->route('hardware.assets.index');
    }
    public function render()
    {
        return view('livewire.v1.hardware.assets.assets-history');
    }
}
