<?php

namespace Tests\Feature;

use App\Models\License;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLicenseTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_view_licenses_index_page(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.licenses.index'));

        $response->assertStatus(200);
        $response->assertSee('إدارة وتفعيل تراخيص البرامج');
    }

    public function test_admin_can_create_a_license(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.licenses.store'), [
                'license_key' => 'OX-TEST-NEW-2026',
                'max_devices' => 2,
                'status' => 'active',
                'expires_at' => null,
            ]);

        $response->assertRedirect(route('admin.licenses.index'));
        $this->assertDatabaseHas('licenses', [
            'license_key' => 'OX-TEST-NEW-2026',
            'max_devices' => 2,
            'status' => 'active',
        ]);
    }

    public function test_admin_can_update_a_license(): void
    {
        $license = License::create([
            'license_key' => 'OX-TEST-UPDATE-KEY',
            'max_devices' => 1,
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->put(route('admin.licenses.update', $license), [
                'license_key' => 'OX-TEST-UPDATED-KEY',
                'max_devices' => 3,
                'status' => 'revoked',
            ]);

        $response->assertRedirect(route('admin.licenses.index'));
        $this->assertDatabaseHas('licenses', [
            'id' => $license->id,
            'license_key' => 'OX-TEST-UPDATED-KEY',
            'max_devices' => 3,
            'status' => 'revoked',
        ]);
    }

    public function test_admin_can_toggle_license_status(): void
    {
        $license = License::create([
            'license_key' => 'OX-TEST-TOGGLE',
            'max_devices' => 1,
            'status' => 'active',
        ]);

        $this->actingAs($this->adminUser)
            ->post(route('admin.licenses.toggle_status', $license));

        $this->assertEquals('revoked', $license->fresh()->status);

        $this->actingAs($this->adminUser)
            ->post(route('admin.licenses.toggle_status', $license));

        $this->assertEquals('active', $license->fresh()->status);
    }

    public function test_admin_can_remove_device_from_license(): void
    {
        $license = License::create([
            'license_key' => 'OX-TEST-DEVICE-REMOVE',
            'max_devices' => 1,
            'status' => 'active',
        ]);

        $device = $license->devices()->create([
            'hardware_id' => 'HW_TO_BE_REMOVED',
            'last_checked_at' => now(),
        ]);

        $this->assertEquals(1, $license->devices()->count());

        $response = $this->actingAs($this->adminUser)
            ->delete(route('admin.licenses.devices.destroy', [$license, $device]));

        $response->assertRedirect();
        $this->assertEquals(0, $license->fresh()->devices()->count());
    }
}
