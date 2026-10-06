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

        // Verify Streamlined Sidebar Navigation Items
        $response->assertSee('الرئيسية والمبيعات');
        $response->assertSee('لوحة التحكم');
        $response->assertSee('مبيعات وتراخيص المتجر');
        $response->assertSee('البرامج والمنتجات');
        $response->assertSee('طلبات الاستشارة');
        $response->assertSee('سجل العملاء');
        $response->assertSee('الفواتير والمستحقات');
        $response->assertSee('مركز النظام والمحتوى');

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

    public function test_admin_can_access_unified_hub_page(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.hub'));

        $response->assertStatus(200);

        // Verify Hub Page Modules & Categories
        $response->assertSee('مركز إدارة النظام والأدوات');
        $response->assertSee('المحتوى ومعرض الأعمال');
        $response->assertSee('العمليات والمالية');
        $response->assertSee('النظام والتهيئة والأمان');

        // Verify Consolidated Cards
        $response->assertSee('المشاريع ومعرض الأعمال');
        $response->assertSee('فيديوهات وقصص الشركاء');
        $response->assertSee('نصوص وعناصر الموقع');
        $response->assertSee('عروض الأسعار (Quotations)');
        $response->assertSee('سجل بوابات الدفع');
        $response->assertSee('تقارير الأداء ومصادر الزيارات');
        $response->assertSee('إعدادات الموقع وبوابات الدفع');
        $response->assertSee('بكسلات التتبع');
        $response->assertSee('فريق الإدارة والمستخدمين');
    }
}
