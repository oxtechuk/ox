<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\License;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LicenseController extends Controller
{
    /**
     * Activate a license key on a specific hardware device.
     */
    public function activate(Request $request): JsonResponse
    {
        // 1. Validate request payload
        $validator = Validator::make($request->all(), [
            'license_key' => ['required', 'string', 'max:191'],
            'hardware_id' => ['required', 'string', 'max:191'],
        ], [
            'license_key.required' => 'The license_key field is required.',
            'hardware_id.required' => 'The hardware_id field is required.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $licenseKey = trim((string) $request->input('license_key'));
        $hardwareId = trim((string) $request->input('hardware_id'));

        // 2. Locate license
        $license = License::where('license_key', $licenseKey)->first();

        if (! $license) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired license key.',
            ], 400);
        }

        // 3. Check status & expiration
        if ($license->status !== 'active' || $license->isExpired()) {
            if ($license->status === 'active' && $license->isExpired()) {
                $license->update(['status' => 'expired']);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired license key.',
            ], 400);
        }

        // 4. Check if device is already registered for this license
        $existingDevice = $license->devices()->where('hardware_id', $hardwareId)->first();

        if ($existingDevice) {
            $existingDevice->update([
                'last_checked_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'License activated successfully.',
                'data' => [
                    'expires_at' => $license->expires_at?->toIso8601String(),
                    'is_active' => true,
                ],
            ], 200);
        }

        // 5. Check device limit
        $currentDeviceCount = $license->devices()->count();
        if ($currentDeviceCount >= $license->max_devices) {
            return response()->json([
                'success' => false,
                'message' => 'Maximum device limit reached for this license key.',
            ], 400);
        }

        // 6. Register new device
        $license->devices()->create([
            'hardware_id' => $hardwareId,
            'last_checked_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'License activated successfully.',
            'data' => [
                'expires_at' => $license->expires_at?->toIso8601String(),
                'is_active' => true,
            ],
        ], 200);
    }

    /**
     * Periodically verify license key validity for an activated hardware device.
     */
    public function verify(Request $request): JsonResponse
    {
        // 1. Validate request payload
        $validator = Validator::make($request->all(), [
            'license_key' => ['required', 'string', 'max:191'],
            'hardware_id' => ['required', 'string', 'max:191'],
        ], [
            'license_key.required' => 'The license_key field is required.',
            'hardware_id.required' => 'The hardware_id field is required.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $licenseKey = trim((string) $request->input('license_key'));
        $hardwareId = trim((string) $request->input('hardware_id'));

        // 2. Locate license
        $license = License::where('license_key', $licenseKey)->first();

        if (! $license) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired license key.',
            ], 400);
        }

        // 3. Verify status and expiration
        if ($license->status !== 'active' || $license->isExpired()) {
            if ($license->status === 'active' && $license->isExpired()) {
                $license->update(['status' => 'expired']);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired license key.',
            ], 400);
        }

        // 4. Verify that this hardware_id is already registered
        $device = $license->devices()->where('hardware_id', $hardwareId)->first();

        if (! $device) {
            return response()->json([
                'success' => false,
                'message' => 'This device is not registered for this license key. Please activate first.',
            ], 400);
        }

        // 5. Update last checked timestamp
        $device->update([
            'last_checked_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'License verified successfully.',
            'data' => [
                'expires_at' => $license->expires_at?->toIso8601String(),
                'is_active' => true,
            ],
        ], 200);
    }
}
