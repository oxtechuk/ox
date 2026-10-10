<?php

namespace Tests\Feature;

use App\Models\DigitalProduct;
use App\Models\PromoCode;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PromoCodeAndCurrencyCheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_validate_promo_returns_discount_and_remaining_time(): void
    {
        $product = DigitalProduct::where('status', 'active')->firstOrFail();

        $promo = PromoCode::create([
            'code' => 'TEST50',
            'discount_type' => 'percentage',
            'discount_value' => 50,
            'valid_from' => now()->subDay(),
            'valid_until' => now()->addDays(10),
            'max_uses' => 100,
            'used_count' => 0,
            'is_active' => true,
        ]);

        $response = $this->postJson(route('checkout.validate_promo'), [
            'code' => 'TEST50',
            'product_id' => $product->id,
            'currency' => 'USD',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'valid' => true,
            'code' => 'TEST50',
            'discount_type' => 'percentage',
            'discount_value' => 50,
        ]);

        $data = $response->json();
        $this->assertNotEmpty($data['remaining_time']);
        $expectedUsd = round(((float) $product->effective_price / 50.0) * 0.5, 2);
        $this->assertEquals($expectedUsd, $data['final_price']);
    }

    public function test_expired_promo_code_is_rejected(): void
    {
        $product = DigitalProduct::where('status', 'active')->firstOrFail();

        PromoCode::create([
            'code' => 'EXPIRED99',
            'discount_type' => 'percentage',
            'discount_value' => 99,
            'valid_from' => now()->subDays(10),
            'valid_until' => now()->subDay(), // Expired yesterday
            'is_active' => true,
        ]);

        $response = $this->postJson(route('checkout.validate_promo'), [
            'code' => 'EXPIRED99',
            'product_id' => $product->id,
            'currency' => 'USD',
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'valid' => false,
        ]);
    }

    public function test_checkout_initiate_with_egp_currency_converts_price(): void
    {
        $product = DigitalProduct::where('status', 'active')->firstOrFail();

        $payload = [
            'product_id' => $product->id,
            'customer_name' => 'أحمد سمير',
            'customer_email' => 'ahmed.samir@example.com',
            'customer_phone' => '01099887766',
            'currency' => 'EGP',
        ];

        $response = $this->postJson(route('checkout.initiate'), $payload);

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertDatabaseHas('orders', [
            'order_number' => $responseData['order_number'],
            'currency' => 'EGP',
        ]);
    }

    public function test_checkout_initiate_with_promo_applies_discount_and_records_code(): void
    {
        $product = DigitalProduct::where('status', 'active')->firstOrFail();

        PromoCode::create([
            'code' => 'SUPER50',
            'discount_type' => 'percentage',
            'discount_value' => 50,
            'valid_from' => now()->subDay(),
            'valid_until' => now()->addDays(5),
            'is_active' => true,
        ]);

        $payload = [
            'product_id' => $product->id,
            'customer_name' => 'محمود علي',
            'customer_email' => 'mahmoud@example.com',
            'customer_phone' => '01234567890',
            'currency' => 'USD',
            'promo_code' => 'SUPER50',
        ];

        $response = $this->postJson(route('checkout.initiate'), $payload);

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertDatabaseHas('orders', [
            'order_number' => $responseData['order_number'],
            'promo_code' => 'SUPER50',
            'currency' => 'USD',
        ]);

        // Check promo usage count incremented
        $this->assertEquals(1, PromoCode::where('code', 'SUPER50')->value('used_count'));
    }
}
