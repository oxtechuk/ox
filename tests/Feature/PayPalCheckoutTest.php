<?php

namespace Tests\Feature;

use App\Models\DigitalProduct;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SiteSetting;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PayPalCheckoutTest extends TestCase
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

    public function test_can_get_paypal_config(): void
    {
        SiteSetting::set('paypal_enabled', '1', 'paypal');
        SiteSetting::set('paypal_client_id', 'TEST_CLIENT_ID_123', 'paypal');
        SiteSetting::set('paypal_currency', 'USD', 'paypal');

        $response = $this->getJson(route('checkout.paypal.config'));

        $response->assertStatus(200);
        $response->assertJson([
            'enabled' => true,
            'client_id' => 'TEST_CLIENT_ID_123',
            'currency' => 'USD',
        ]);
    }

    public function test_admin_can_update_paypal_settings(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.settings.update'), [
            'active_tab' => 'paypal',
            'paypal_enabled' => '1',
            'paypal_mode' => 'live',
            'paypal_client_id' => 'LIVE_CLIENT_ID_ABC',
            'paypal_client_secret' => 'LIVE_SECRET_XYZ',
            'paypal_currency' => 'USD',
            'paypal_egp_to_usd_rate' => '0.022',
        ]);

        $response->assertRedirect(route('admin.settings.index', ['tab' => 'paypal']));

        $this->assertEquals('LIVE_CLIENT_ID_ABC', SiteSetting::get('paypal_client_id'));
        $this->assertEquals('live', SiteSetting::get('paypal_mode'));
        $this->assertEquals('0.022', SiteSetting::get('paypal_egp_to_usd_rate'));
    }

    public function test_can_create_paypal_order(): void
    {
        SiteSetting::set('paypal_enabled', '1', 'paypal');
        SiteSetting::set('paypal_client_id', 'TEST_ID', 'paypal');
        SiteSetting::set('paypal_client_secret', 'TEST_SECRET', 'paypal');

        // Fake PayPal OAuth and Orders endpoints
        Http::fake([
            '*/v1/oauth2/token' => Http::response(['access_token' => 'mock_token', 'expires_in' => 3600]),
            '*/v2/checkout/orders' => Http::response([
                'id' => 'PAYPAL-MOCK-ORDER-123',
                'status' => 'CREATED',
                'links' => [
                    ['rel' => 'approve', 'href' => 'https://sandbox.paypal.com/checkoutnow?token=PAYPAL-MOCK-ORDER-123'],
                ],
            ], 201),
        ]);

        $product = DigitalProduct::where('status', 'active')->firstOrFail();

        $response = $this->postJson(route('checkout.paypal.create'), [
            'product_id' => $product->id,
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_phone' => '123456789',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'paypal_order_id' => 'PAYPAL-MOCK-ORDER-123',
        ]);

        $this->assertDatabaseHas('orders', [
            'customer_email' => 'john@example.com',
            'payment_gateway' => 'paypal',
            'payment_status' => 'pending',
        ]);

        $this->assertDatabaseHas('payment_logs', [
            'event' => 'paypal_order_created',
            'status' => 'info',
        ]);
    }

    public function test_can_capture_paypal_order_and_fulfill(): void
    {
        SiteSetting::set('paypal_enabled', '1', 'paypal');
        SiteSetting::set('paypal_client_id', 'TEST_ID', 'paypal');
        SiteSetting::set('paypal_client_secret', 'TEST_SECRET', 'paypal');

        Http::fake([
            '*/v1/oauth2/token' => Http::response(['access_token' => 'mock_token', 'expires_in' => 3600]),
            '*/v2/checkout/orders/*/capture' => Http::response([
                'id' => 'PAYPAL-MOCK-ORDER-123',
                'status' => 'COMPLETED',
                'purchase_units' => [
                    [
                        'payments' => [
                            'captures' => [
                                [
                                    'id' => 'CAPTURE-TRANSACTION-999',
                                    'status' => 'COMPLETED',
                                ],
                            ],
                        ],
                    ],
                ],
            ], 201),
        ]);

        $product = DigitalProduct::where('status', 'active')->firstOrFail();

        $order = Order::create([
            'order_number' => 'ORD-TEST-12345',
            'customer_name' => 'Alice Smith',
            'customer_email' => 'alice@example.com',
            'total_amount' => 500,
            'currency' => 'EGP',
            'payment_gateway' => 'paypal',
            'payment_status' => 'pending',
            'merchant_reference' => 'PP-MOCK-REF-777',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'price' => 500,
            'quantity' => 1,
            'subtotal' => 500,
        ]);

        $response = $this->postJson(route('checkout.paypal.capture'), [
            'paypal_order_id' => 'PAYPAL-MOCK-ORDER-123',
            'merchant_reference' => $order->merchant_reference,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $order->refresh();
        $this->assertEquals('paid', $order->payment_status);

        $this->assertDatabaseHas('payment_logs', [
            'merchant_reference' => $order->merchant_reference,
            'event' => 'paypal_payment_captured',
            'status' => 'success',
        ]);
    }
}
