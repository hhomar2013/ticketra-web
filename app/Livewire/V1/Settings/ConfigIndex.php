<?php
namespace App\Livewire\V1\Settings;

use Livewire\Attributes\Url;
use Livewire\Component;

class ConfigIndex extends Component
{
    #[Url()]
    public $page = 'general';

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function render()
    {
        return view('livewire.v1.settings.config-index');
    }
}
