<?php

namespace Database\Seeders;

use App\Models\License;
use Illuminate\Database\Seeder;

class LicenseSeeder extends Seeder
{
    /**
     * Run the database seeds for testing the desktop licensing system.
     */
    public function run(): void
    {
        // 1. Active Lifetime License (Multi-device: 2)
        License::updateOrCreate(
            ['license_key' => 'OX-LIFETIME-DEMO-2026'],
            [
                'max_devices' => 2,
                'status' => 'active',
                'expires_at' => null,
            ]
        );

        // 2. Active 1-Year License (Single-device: 1)
        License::updateOrCreate(
            ['license_key' => 'OX-ANNUAL-KEY-2027'],
            [
                'max_devices' => 1,
                'status' => 'active',
                'expires_at' => now()->addYear(),
            ]
        );

        // 3. Expired License (For testing expiration rejection)
        License::updateOrCreate(
            ['license_key' => 'OX-EXPIRED-TEST-9999'],
            [
                'max_devices' => 1,
                'status' => 'expired',
                'expires_at' => now()->subMonth(),
            ]
        );

        // 4. Revoked License (For testing blocked keys)
        License::updateOrCreate(
            ['license_key' => 'OX-REVOKED-TEST-0000'],
            [
                'max_devices' => 1,
                'status' => 'revoked',
                'expires_at' => now()->addMonths(6),
            ]
        );
    }
}
