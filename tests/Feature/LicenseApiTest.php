<?php

namespace Tests\Feature;

use App\Models\License;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LicenseApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_activation_requires_license_key_and_hardware_id(): void
    {
        $response = $this->postJson('/api/license/activate', []);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_activation_fails_for_non_existent_license(): void
    {
        $response = $this->postJson('/api/license/activate', [
            'license_key' => 'NON-EXISTENT-KEY',
            'hardware_id' => 'DEVICE_001',
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid or expired license key.',
            ]);
    }

    public function test_activation_fails_for_expired_or_revoked_license(): void
    {
        $expiredLicense = License::create([
            'license_key' => 'EXPIRED-KEY-1234',
            'max_devices' => 1,
            'status' => 'active',
            'expires_at' => now()->subDay(),
        ]);

        $revokedLicense = License::create([
            'license_key' => 'REVOKED-KEY-1234',
            'max_devices' => 1,
            'status' => 'revoked',
            'expires_at' => now()->addYear(),
        ]);

        $res1 = $this->postJson('/api/license/activate', [
            'license_key' => $expiredLicense->license_key,
            'hardware_id' => 'DEVICE_001',
        ]);
        $res1->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid or expired license key.',
            ]);

        $res2 = $this->postJson('/api/license/activate', [
            'license_key' => $revokedLicense->license_key,
            'hardware_id' => 'DEVICE_001',
        ]);
        $res2->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid or expired license key.',
            ]);
    }

    public function test_activation_succeeds_for_valid_license(): void
    {
        $license = License::create([
            'license_key' => 'OX-TECH-2026-ABCD',
            'max_devices' => 2,
            'status' => 'active',
            'expires_at' => now()->addYear(),
        ]);

        $response = $this->postJson('/api/license/activate', [
            'license_key' => 'OX-TECH-2026-ABCD',
            'hardware_id' => 'HW_DESKTOP_123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'License activated successfully.',
                'data' => [
                    'is_active' => true,
                ],
            ]);

        $this->assertDatabaseHas('license_devices', [
            'license_id' => $license->id,
            'hardware_id' => 'HW_DESKTOP_123',
        ]);
    }

    public function test_activation_succeeds_when_activating_same_device_again(): void
    {
        $license = License::create([
            'license_key' => 'OX-TECH-SINGLE-DEV',
            'max_devices' => 1,
            'status' => 'active',
            'expires_at' => now()->addYear(),
        ]);

        $license->devices()->create([
            'hardware_id' => 'HW_DESKTOP_123',
            'last_checked_at' => now()->subDays(2),
        ]);

        $response = $this->postJson('/api/license/activate', [
            'license_key' => 'OX-TECH-SINGLE-DEV',
            'hardware_id' => 'HW_DESKTOP_123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'License activated successfully.',
            ]);

        $this->assertEquals(1, $license->devices()->count());
    }

    public function test_activation_fails_when_max_devices_limit_is_exceeded(): void
    {
        $license = License::create([
            'license_key' => 'OX-TECH-MAX-1',
            'max_devices' => 1,
            'status' => 'active',
            'expires_at' => now()->addYear(),
        ]);

        $license->devices()->create([
            'hardware_id' => 'HW_DEVICE_A',
            'last_checked_at' => now(),
        ]);

        $response = $this->postJson('/api/license/activate', [
            'license_key' => 'OX-TECH-MAX-1',
            'hardware_id' => 'HW_DEVICE_B',
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Maximum device limit reached for this license key.',
            ]);

        $this->assertDatabaseMissing('license_devices', [
            'hardware_id' => 'HW_DEVICE_B',
        ]);
    }

    public function test_verification_succeeds_for_registered_device(): void
    {
        $license = License::create([
            'license_key' => 'OX-TECH-VERIFY-KEY',
            'max_devices' => 1,
            'status' => 'active',
            'expires_at' => now()->addMonth(),
        ]);

        $device = $license->devices()->create([
            'hardware_id' => 'HW_VERIFY_100',
            'last_checked_at' => now()->subDay(),
        ]);

        $response = $this->postJson('/api/license/verify', [
            'license_key' => 'OX-TECH-VERIFY-KEY',
            'hardware_id' => 'HW_VERIFY_100',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'License verified successfully.',
                'data' => [
                    'is_active' => true,
                ],
            ]);

        $this->assertTrue($device->fresh()->last_checked_at->isToday());
    }

    public function test_verification_fails_for_unregistered_device(): void
    {
        $license = License::create([
            'license_key' => 'OX-TECH-VERIFY-KEY-2',
            'max_devices' => 1,
            'status' => 'active',
            'expires_at' => now()->addMonth(),
        ]);

        $response = $this->postJson('/api/license/verify', [
            'license_key' => 'OX-TECH-VERIFY-KEY-2',
            'hardware_id' => 'UNREGISTERED_HW',
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'This device is not registered for this license key. Please activate first.',
            ]);
    }

    public function test_verification_fails_for_revoked_or_expired_license(): void
    {
        $license = License::create([
            'license_key' => 'OX-TECH-REVOKED-KEY',
            'max_devices' => 1,
            'status' => 'revoked',
            'expires_at' => now()->addMonth(),
        ]);

        $license->devices()->create([
            'hardware_id' => 'HW_DEVICE_REV',
            'last_checked_at' => now(),
        ]);

        $response = $this->postJson('/api/license/verify', [
            'license_key' => 'OX-TECH-REVOKED-KEY',
            'hardware_id' => 'HW_DEVICE_REV',
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid or expired license key.',
            ]);
    }
}
