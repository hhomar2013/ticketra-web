<?php

namespace App\Observers;

use App\Models\Asset;
use App\Models\asset_log;
use Illuminate\Support\Facades\Auth;

class AssetObserver
{
    public function updated(Asset $asset)
    {
        if ($asset->isDirty('status') || $asset->isDirty('user_id') || $asset->isDirty('branch_id')) {

            asset_log::create([
                'asset_id'   => $asset->id,
                'user_id'    => Auth::id() ?? 1,
                'action'     => 'Update Details',
                'old_status' => $asset->getOriginal('status'),
                'new_status' => $asset->status,
                'description' => $this->generateDescription($asset),
            ]);
        }
    }

    private function generateDescription(Asset $asset)
    {
        $desc = __('The ' . $asset->asset_tag . ' was updated:');
        if ($asset->isDirty('status')) {
            $desc .= __('The status was changed from') . " " . $asset->getOriginal('status') . " " . __('to') . " " . $asset->status . ". ";
        }
        if ($asset->isDirty('user_id')) {
            $desc .= __('The user was changed.');
        }
        if ($asset->isDirty('branch_id')) {
            $desc .= __('The device was transferred to another branch.');
        }
        return $desc;
    }


    public function created(Asset $asset)
    {
        asset_log::create([
            'asset_id'    => $asset->id,
            'user_id'     => Auth::id() ?? 1,
            'action'      => 'Creation',
            'new_status'  => $asset->status,
            'description' => __('The original was introduced into the system for the first time.'),
        ]);
    }
}
