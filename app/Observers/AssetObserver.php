<?php
namespace App\Observers;

use App\Models\Asset;
use App\Models\asset_log;
use Illuminate\Support\Facades\Auth;

class AssetObserver
{
    public function created(Asset $asset): void
    {
        $this->logAction($asset, 'Creation', __('Asset introduced to the system for the first time.'));
    }

    public function updated(Asset $asset): void
    {
        // نحدد الحقول اللي تهمنا مراقبتها
        $monitoredFields = ['status', 'user_id', 'branch_id'];

        // إذا لم يتغير أي حقل مهم، نخرج فوراً
        if (!$asset->wasChanged($monitoredFields)) {
            return;
        }

        $this->logAction($asset, 'Update Details', $this->generateDescription($asset));
    }

    /**
     * ميثود موحدة لإنشاء اللوج لتقليل تكرار الكود
     */
    private function logAction(Asset $asset, string $action, string $description): void
    {
        asset_log::create([
            'asset_id' => $asset->id,
            'user_id' => Auth::id() ?? 1,
            'action' => $action,
            'old_status' => $asset->getOriginal('status')->value,
            'new_status' => $asset->status,
            'description' => $description,
        ]);
    }

    private function generateDescription(Asset $asset): string
    {
        $changes = [];

        if ($asset->wasChanged('status')) {
            $old = $asset->getOriginal('status')->value;
            $new = $asset->status->value;
            $changes[] = __("Status changed from :old to :new", ['old' => $old, 'new' => $new]);
        }

        if ($asset->wasChanged('user_id')) {
            $oldUser = \App\Models\User::find($asset->getOriginal('user_id'))?->name ?? __('Nobody');
            $newUser = $asset->user?->name ?? __('Nobody');
            $changes[] = __("Ownership transferred from :old to :new", ['old' => $oldUser, 'new' => $newUser]);
        }

        if ($asset->wasChanged('branch_id')) {
            $oldBranch = \App\Models\Branch::find($asset->getOriginal('branch_id'))?->name ?? __('Unknown');
            $newBranch = $asset->branch?->name ?? __('Unknown');
            $changes[] = __("Transferred from branch :old to :new", ['old' => $oldBranch, 'new' => $newBranch]);
        }

        return !empty($changes)
            ? implode(' | ', $changes)
            : __('General details updated.');
    }
}
