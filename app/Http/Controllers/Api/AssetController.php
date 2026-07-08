<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssetOnline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssetController extends Controller
{
    public function collect(Request $request)
    {
        try {
            $data = $request->validate([
                'computer_name' => 'required|string',
                'serial_number' => 'required|string',
                'manufacturer' => 'nullable|string',
                'model' => 'nullable|string',
                'os_name' => 'nullable|string',
                'os_version' => 'nullable|string',
                'apps' => 'nullable|string',
                'specs' => 'nullable|string',
                'mac_address' => 'nullable|string',
                'windows_activation' => 'nullable|string',
                'missing_drivers' => 'nullable',
            ]);

            $appsArray = is_string($data['apps']) ? json_decode($data['apps'], true) : $data['apps'];
            $specsArray = is_string($data['specs']) ? json_decode($data['specs'], true) : $data['specs'];
            $driversArray = is_string($data['missing_drivers']) ? json_decode($data['missing_drivers'], true) : $data['missing_drivers'];
            if (empty($driversArray)) {
                $driversArray = [];
            }

            $asset = AssetOnline::updateOrCreate(
                ['serial_number' => trim($data['serial_number'])],
                [
                    'computer_name' => $data['computer_name'],
                    'manufacturer' => $data['manufacturer'],
                    'model' => $data['model'],
                    'os_name' => $data['os_name'],
                    'os_version' => $data['os_version'],
                    'installed_apps' => $appsArray,
                    'hardware_specs' => $specsArray,
                    'mac_address' => $data['mac_address'],
                    'windows_activation' => $data['windows_activation'],
                    'missing_drivers' => $driversArray,
                    'last_sync_at' => now(),
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Asset data synchronized successfully.',
                'asset_id' => $asset->id,
                'computer_name' => $asset->computer_name
            ], 200);

        } catch (\Exception $e) {
            Log::error('Asset Sync Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}