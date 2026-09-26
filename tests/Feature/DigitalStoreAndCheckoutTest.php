<?php

namespace Tests\Feature;

use App\Mail\DigitalProductOrderCompleted;
use App\Models\DigitalProduct;
use App\Models\DownloadToken;
use App\Models\Order;
use App\Models\ProductLandingPage;
use App\Models\User;
use Database\Seeders\DigitalProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tests\TestCase;

class DigitalStoreAndCheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed basic products
        $this->seed(DigitalProductSeeder::class);
    }

    public function test_store_index_page_is_accessible(): void
    {
        $response = $this->get(route('store.index'));

        $response->assertStatus(200);
        $response->assertSee('سوق البرمجيات');
        $response->assertSee('OxPro ERP');
    }

    public function test_product_details_page_is_accessible(): void
    {
        $product = DigitalProduct::where('slug', 'oxpro-erp-system')->firstOrFail();

        $response = $this->get(route('store.product', $product->slug));

        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee('شراء وتفعيل فوري');
    }

    public function test_sales_landing_page_is_accessible(): void
    {
        $landingPage = ProductLandingPage::where('slug', 'oxpro-erp')->firstOrFail();

        $response = $this->get(route('store.landing', $landingPage->slug));

        $response->assertStatus(200);
        $response->assertSee($landingPage->headline);
        $response->assertSee('PaySky Omni Gateway');
    }

    public function test_checkout_initiate_creates_order_and_returns_paysky_payload(): void
    {
        $product = DigitalProduct::where('status', 'active')->firstOrFail();

        $payload = [
            'product_id' => $product->id,
            'customer_name' => 'محمد أحمد',
            'customer_email' => 'mohamed@example.com',
            'customer_phone' => '01012345678',
            'utm_source' => 'facebook_ads',
            'utm_campaign' => 'black_friday',
        ];

        $response = $this->postJson(route('checkout.initiate'), $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData['order_number']);
        $this->assertNotEmpty($responseData['paysky']['SecureHash']);
        $this->assertEquals($product->effective_price * 100, $responseData['paysky']['AmountTrxn']);

        $this->assertDatabaseHas('orders', [
            'order_number' => $responseData['order_number'],
            'customer_email' => 'mohamed@example.com',
            'payment_status' => 'pending',
            'utm_source' => 'facebook_ads',
        ]);
    }

    public function test_paysky_callback_fulfills_order_creates_user_and_sends_email(): void
    {
        Mail::fake();

        $product = DigitalProduct::where('status', 'active')->firstOrFail();

        // Create pending order
        $order = Order::create([
            'order_number' => 'ORD-TEST-12345',
            'customer_name' => 'سارة العتيبي',
            'customer_email' => 'sara@example.com',
            'total_amount' => $product->effective_price,
            'currency' => 'EGP',
            'payment_gateway' => 'paysky',
            'payment_status' => 'pending',
            'merchant_reference' => 'REF-TEST-998877',
        ]);

        $order->items()->create([
            'product_id' => $product->id,
            'price' => $product->effective_price,
        ]);

        // Simulate PaySky successful callback
        $response = $this->get(route('checkout.paysky.callback', [
            'MerchantReference' => $order->merchant_reference,
            'Success' => 'true',
            'TransactionId' => 'TXN-PAYSKY-888999',
        ]));

        $response->assertRedirect(route('checkout.success', $order->order_number));

        // Assert order marked paid
        $order->refresh();
        $this->assertEquals('paid', $order->payment_status);
        $this->assertNotNull($order->paid_at);

        // Assert user created
        $user = User::where('email', 'sara@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals($order->user_id, $user->id);

        // Assert license key generated
        $item = $order->items()->first();
        $this->assertNotEmpty($item->license_key);

        // Assert download token generated
        $token = DownloadToken::where('order_id', $order->id)->first();
        $this->assertNotNull($token);
        $this->assertTrue($token->isValid());

        // Assert confirmation email dispatched
        Mail::assertSent(DigitalProductOrderCompleted::class, function ($mail) {
            return $mail->hasTo('sara@example.com');
        });
    }

    public function test_secure_download_with_token_increments_count(): void
    {
        $product = DigitalProduct::where('status', 'active')->firstOrFail();

        $order = Order::create([
            'order_number' => 'ORD-DL-1122',
            'customer_name' => 'كريم محمود',
            'customer_email' => 'karim@example.com',
            'total_amount' => 500,
            'currency' => 'EGP',
            'payment_status' => 'paid',
            'merchant_reference' => 'REF-DL-1122',
        ]);

        $order->items()->create([
            'product_id' => $product->id,
            'price' => 500,
            'license_key' => 'OX-TEST-KEY-1234',
        ]);

        $token = DownloadToken::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'token' => 'secure-token-abc-xyz-123',
            'expires_at' => now()->addDays(7),
            'download_count' => 0,
            'max_downloads' => 5,
        ]);

        $response = $this->get(route('digital.download', $token->token));

        $response->assertStatus(200);
        $this->assertTrue($response->headers->contains('content-disposition', 'attachment; filename='.($product->file_name ?: Str::slug($product->name).'-v'.$product->version.'.zip')));

        $token->refresh();
        $this->assertEquals(1, $token->download_count);
    }
}
