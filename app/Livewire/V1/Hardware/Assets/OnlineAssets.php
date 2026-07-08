<?php

namespace App\Livewire\V1\Hardware\Assets;

use App\Models\AssetOnline;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class OnlineAssets extends Component
{

    use WithPagination;
    protected $paginateTheme = "bootstrab";

    public $search = '';

    public function showOnlineAsset($id)
    {
        dd($id);
        return redirect()->route('hardware.assets.show-online-asset', $id);
    }

    #[Computed]
    public function assets()
    {
        return AssetOnline::query()
            ->when($this->search, function ($query) {
                $query->where('computer_name', 'like', '%' . $this->search . '%')
                    ->orWhere('serial_number', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);
    }

    public function export()
    {
        return Storage::disk("public")->download("agent/collectinformation.bat");
    }


    public function render()
    {
        return view('livewire.v1.hardware.assets.online-assets');
    }
}
