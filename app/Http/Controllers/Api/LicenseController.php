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
        if ($authError = $this->checkApiKey($request)) {
            return $authError;
        }

        $credentials = $this->extractCredentials($request);

        // 1. Validate request payload
        $validator = Validator::make($credentials, [
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

        $licenseKey = $credentials['license_key'];
        $hardwareId = $credentials['hardware_id'];

        // 2. Locate license (case-tolerant)
        $license = License::where('license_key', $licenseKey)
            ->orWhere('license_key', strtoupper($licenseKey))
            ->first();

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
                'data' => $this->buildResponseData($license),
                'is_active' => true,
                'isActive' => true,
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
            'data' => $this->buildResponseData($license),
            'is_active' => true,
            'isActive' => true,
        ], 200);
    }

    /**
     * Periodically verify license key validity for an activated hardware device.
     */
    public function verify(Request $request): JsonResponse
    {
        if ($authError = $this->checkApiKey($request)) {
            return $authError;
        }

        $credentials = $this->extractCredentials($request);

        // 1. Validate request payload
        $validator = Validator::make($credentials, [
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

        $licenseKey = $credentials['license_key'];
        $hardwareId = $credentials['hardware_id'];

        // 2. Locate license (case-tolerant)
        $license = License::where('license_key', $licenseKey)
            ->orWhere('license_key', strtoupper($licenseKey))
            ->first();

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
            'data' => $this->buildResponseData($license),
            'is_active' => true,
            'isActive' => true,
        ], 200);
    }

    /**
     * Extract and normalize license credentials from request.
     * Supports snake_case, camelCase, and PascalCase from desktop clients.
     *
     * @return array{license_key: string, hardware_id: string}
     */
    protected function extractCredentials(Request $request): array
    {
        $licenseKey = trim((string) (
            $request->input('license_key')
            ?? $request->input('LicenseKey')
            ?? $request->input('licenseKey')
            ?? $request->input('license')
            ?? $request->input('key')
        ));

        $hardwareId = trim((string) (
            $request->input('hardware_id')
            ?? $request->input('HardwareId')
            ?? $request->input('hardwareId')
            ?? $request->input('machine_id')
            ?? $request->input('MachineId')
            ?? $request->input('hwid')
        ));

        return [
            'license_key' => $licenseKey,
            'hardware_id' => $hardwareId,
        ];
    }

    /**
     * Build standard response payload compatible with C# .NET / WPF deserializers.
     *
     * @return array<string, mixed>
     */
    protected function buildResponseData(License $license): array
    {
        $expiresAt = $license->expires_at?->toIso8601String() ?? '2099-12-31T23:59:59Z';

        return [
            'expires_at' => $expiresAt,
            'expiresAt' => $expiresAt,
            'is_active' => true,
            'isActive' => true,
            'license_key' => $license->license_key,
            'licenseKey' => $license->license_key,
            'max_devices' => $license->max_devices,
        ];
    }

    /**
     * Verify optional API key header if configured in environment (LICENSE_API_KEY).
     */
    protected function checkApiKey(Request $request): ?JsonResponse
    {
        $configuredKey = config('services.license.api_key', env('LICENSE_API_KEY'));

        if (! empty($configuredKey)) {
            $headerKey = $request->header('X-API-KEY') ?? $request->header('X-License-Key');

            if ($headerKey !== $configuredKey) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized: Invalid API Key header.',
                ], 401);
            }
        }

        return null;
    }
}
