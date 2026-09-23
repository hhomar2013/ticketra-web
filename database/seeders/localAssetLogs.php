<?php

namespace Database\Seeders;

use App\Core\Enum\AssetStatus;
use App\Models\asset;
use App\Models\asset_log;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class localAssetLogs extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $assets_with_owner = asset::query()
        //     ->whereNotNull('user_id')->get();
        // foreach ($assets_with_owner as $asset) {
        //     asset_log::query()->firstOrCreate(
        //         ['asset_id' => $asset->id],
        //         [
        //             'asset_id' => $asset->id,
        //             'user_id' => 1,
        //             'Action' => 'Creation',
        //             'description' => 'Asset introduced to the system for the first time from excel sheet.',
        //             'new_status' => AssetStatus::Available,
        //         ]
        //     );

        // }


        $assets = asset::query()->where('status', AssetStatus::Assigned)->get();
        foreach ($assets as $asset1) {
            asset_log::query()->create([
                'asset_id' => $asset1->id,
                'user_id' => 1,
                'Action' => 'Assigned',
                'description' => 'Asset assigned to an employee.',
                'new_status' => AssetStatus::Assigned,
            ]);
        }

    }
}
