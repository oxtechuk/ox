<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardRedesignTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);

        $this->admin = User::firstOrCreate(
            ['email' => 'admin@ox-tech.sa'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
    }

    public function test_admin_can_access_redesigned_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);

        // Verify the 4 Smart Navigation Groups
        $response->assertSee('نظرة عامة والمالية');
        $response->assertSee('المتجر والمنتجات الرقمية');
        $response->assertSee('العملاء والتسويق');
        $response->assertSee('المحتوى والنظام');

        // Verify Financial Hub Elements & Metrics
        $response->assertSee('Available balance');
        $response->assertSee('USD');
        $response->assertSee('الدخل الشهري (Income)');
        $response->assertSee('الطلبات والتراخيص (Orders)');

        // Verify Marketplace Hero Box & Curve Chart
        $response->assertSee('OX Tech MarketPlace');
        $response->assertSee('monthlyIncomeChart');
        $response->assertSee('حالة بوابات الدفع والتحصيل');
        $response->assertSee('PaySky');
        $response->assertSee('PayPal');

        // Verify Topbar SaaS Features
        $response->assertSee('إضافة سريعة');
        $response->assertSee('مرحباً!');
    }
}
