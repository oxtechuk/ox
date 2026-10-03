<?php

namespace Tests\Feature;

use App\Models\DigitalProduct;
use App\Models\Order;
use App\Models\PaymentLog;
use App\Models\SiteSetting;
use App\Models\User;
use App\Services\PaySkyService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaySkySettingsAndLogsTest extends TestCase
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

    public function test_admin_can_view_paysky_settings_tab(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.settings.index', ['tab' => 'paysky']));

        $response->assertStatus(200);
        $response->assertSee('إعدادات بوابة الدفع PaySky Omni Gateway');
        $response->assertSee('paysky_mid');
        $response->assertSee('paysky_secret_key');
    }

    public function test_admin_can_update_paysky_settings(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.settings.update'), [
            'active_tab' => 'paysky',
            'paysky_enabled' => '1',
            'paysky_mode' => 'live',
            'paysky_mid' => '999888777',
            'paysky_tid' => '11223344',
            'paysky_secret_key' => 'abcdef0123456789',
            'paysky_currency' => 'EGP',
        ]);

        $response->assertRedirect(route('admin.settings.index', ['tab' => 'paysky']));

        $this->assertEquals('live', SiteSetting::get('paysky_mode'));
        $this->assertEquals('999888777', SiteSetting::get('paysky_mid'));
        $this->assertEquals('11223344', SiteSetting::get('paysky_tid'));

        // Test PaySkyService picks up the new dynamic settings
        $service = new PaySkyService;
        $this->assertEquals('999888777', $service->getMid());
        $this->assertEquals('11223344', $service->getTid());
        $this->assertEquals('live', $service->getMode());
    }

    public function test_checkout_and_callback_create_payment_logs(): void
    {
        $product = DigitalProduct::where('status', 'active')->firstOrFail();

        // 1. Checkout initiate
        $response = $this->postJson(route('checkout.initiate'), [
            'product_id' => $product->id,
            'customer_name' => 'يوسف إبراهيم',
            'customer_email' => 'youssef@example.com',
        ]);

        $response->assertStatus(200);

        // Assert payment log created
        $this->assertDatabaseHas('payment_logs', [
            'event' => 'order_created',
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('payment_logs', [
            'event' => 'lightbox_payload_prepared',
            'status' => 'info',
        ]);

        // 2. Callback
        $order = Order::where('customer_email', 'youssef@example.com')->firstOrFail();

        $this->get(route('checkout.paysky.callback', [
            'MerchantReference' => $order->merchant_reference,
            'Success' => 'true',
            'TransactionId' => 'PAYSKY-TEST-LOG-123',
        ]));

        $this->assertDatabaseHas('payment_logs', [
            'merchant_reference' => $order->merchant_reference,
            'event' => 'callback_received',
        ]);

        $this->assertDatabaseHas('payment_logs', [
            'order_id' => $order->id,
            'event' => 'order_paid_and_fulfilled',
            'status' => 'success',
        ]);
    }

    public function test_admin_can_view_payment_logs_page(): void
    {
        PaymentLog::record(
            event: 'test_event',
            status: 'success',
            message: 'تجربة تسجيل عملية دفع',
            merchantReference: 'REF-LOG-TEST'
        );

        $response = $this->actingAs($this->admin)->get(route('admin.payment-logs.index'));

        $response->assertStatus(200);
        $response->assertSee('سجل عمليات وتتبع بوابة PaySky');
        $response->assertSee('REF-LOG-TEST');
        $response->assertSee('تجربة تسجيل عملية دفع');
    }
}
