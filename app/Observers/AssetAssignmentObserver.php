<?php

namespace App\Observers;

use App\Models\asset;
use App\Models\asset_transfer;
use App\Models\AssetAssignment;
use Illuminate\Support\Facades\Auth;

class AssetAssignmentObserver
{
    /**
     * Handle the AssetAssignment "created" event.
     * يتم استدعاء هذه الدالة فوراً بعد حفظ سجل التعيين
     */
    public function created(AssetAssignment $assignment): void
    {
        $asset = asset::find($assignment->asset_id);

        if ($asset) {
            // 1. نتحقق هل الفرع تغير؟ لو اه، نسجل حركة نقل (Transfer)
            if ($asset->branch_id != $assignment->branch_id) {
                asset_transfer::create([
                    'asset_id'       => $asset->id,
                    'from_branch_id' => $asset->branch_id, // الفرع القديم
                    'to_branch_id'   => $assignment->branch_id, // الفرع الجديد
                    'action_by'      => Auth::user()->id,
                    'reason'         => 'Asset assigned to :  ' . $assignment->user->name,
                ]);
            }

            // 2. تحديث بيانات الأصل (الموظف، الفرع، الحالة)
            $asset->update([
                'user_id'   => $assignment->user_id,
                'branch_id' => $assignment->branch_id,
                'status'    => 'assigned',
            ]);
        }
    }

    /**
     * Handle the AssetAssignment "updated" event.
     * لو الموظف رجع الجهاز (حدثنا تاريخ العودة)
     */
    public function updated(AssetAssignment $assignment): void
    {
        // لو تم إضافة تاريخ استرجاع (returned_at) ولم يكن موجوداً من قبل
        if ($assignment->isDirty('returned_at') && !is_null($assignment->returned_at)) {
            $asset = $assignment->asset;
            
            if ($asset) {
                $asset->update([
                    'user_id' => null,          // الجهاز ملوش موظف دلوقتي
                    'status'  => 'available',   // رجع متاح في المخزن
                ]);
            }
        }
    }
}
