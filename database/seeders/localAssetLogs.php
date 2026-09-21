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
        $assets = asset::query()
            ->whereNotNull('user_id')->get();
        foreach ($assets as $asset) {
            asset_log::query()->firstOrCreate(
                ['asset_id' => $asset->id],
                [
                    'asset_id' => $asset->id,
                    'user_id' => $asset->user_id,
                    'Action' => 'Creation',
                    'description' => 'Asset introduced to the system for the first time from excel sheet.',
                    'new_status' => AssetStatus::Available,
                ]
            );

        }
    }
}
