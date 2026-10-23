<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ConsultationContactValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_renders_successfully_with_form_and_anti_bot_elements(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('oxContactForm');
        $response->assertSee('hp_check');
        $response->assertSee('_form_load_time');
        $response->assertSee('ox-recaptcha-shield');
    }

    public function test_contact_submission_succeeds_with_valid_data(): void
    {
        Config::set('services.recaptcha.secret_key', '');

        $payload = [
            'name' => 'فهد العتيبي',
            'email' => 'fahad@alotaibi.sa',
            'phone' => '+966 55 123 4567',
            'project_type' => 'تطبيقات جوال (iOS & Android)',
            'contact_preference' => 'واتساب',
            'message' => 'نحتاج لتطوير تطبيق جوال متقدم لربط سلاسل الإمداد اللوجستية.',
        ];

        $response = $this->postJson('/contact', $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('consultations', [
            'email' => 'fahad@alotaibi.sa',
            'name' => 'فهد العتيبي',
        ]);
    }

    public function test_contact_validation_fails_when_required_fields_missing(): void
    {
        $response = $this->postJson('/contact', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'email', 'phone', 'message']);
    }

    public function test_contact_validation_fails_on_invalid_email(): void
    {
        $payload = [
            'name' => 'خالد الشمري',
            'email' => 'not-an-email',
            'phone' => '+966501112233',
            'message' => 'رسالة تجريبية بمحتوى كافٍ لأكثر من عشرة أحرف.',
        ];

        $response = $this->postJson('/contact', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_contact_validation_fails_on_short_message(): void
    {
        $payload = [
            'name' => 'سارة المطيري',
            'email' => 'sara@test.com',
            'phone' => '+966501112233',
            'message' => 'قصير',
        ];

        $response = $this->postJson('/contact', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['message']);
    }

    public function test_contact_honeypot_traps_bot_without_saving_to_database(): void
    {
        $payload = [
            'name' => 'Spam Bot Automatic',
            'email' => 'spambot@marketing-blast.ru',
            'phone' => '+1234567890',
            'message' => 'Spam advertisement links promoting spam services here.',
            'hp_check' => 'http://spam-link-trap.com',
        ];

        $response = $this->postJson('/contact', $payload);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseMissing('consultations', [
            'email' => 'spambot@marketing-blast.ru',
        ]);
    }

    public function test_contact_fails_when_recaptcha_enabled_and_token_missing(): void
    {
        Config::set('services.recaptcha.secret_key', 'test_secret_key_123');

        $payload = [
            'name' => 'عبدالله السعيد',
            'email' => 'abdullah@example.com',
            'phone' => '+966509988776',
            'message' => 'طلب استشارة لبناء منصة سحابية لتوزيع المنتجات.',
            // g-recaptcha-response omitted
        ];

        $response = $this->postJson('/contact', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['g-recaptcha-response']);
    }

    public function test_contact_fails_when_recaptcha_verification_rejected_by_google(): void
    {
        Config::set('services.recaptcha.secret_key', 'test_secret_key_123');

        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response([
                'success' => false,
                'error-codes' => ['invalid-input-response'],
            ], 200),
        ]);

        $payload = [
            'name' => 'بوت احتيالي',
            'email' => 'fraud@botnet.org',
            'phone' => '+966509988776',
            'message' => 'رسالة استشارة تجريبية تجاوزت الحد الأدنى للحروف.',
            'g-recaptcha-response' => 'fake_invalid_bot_token',
        ];

        $response = $this->postJson('/contact', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['g-recaptcha-response']);
    }

    public function test_contact_succeeds_when_recaptcha_passes_with_good_score(): void
    {
        Config::set('services.recaptcha.secret_key', 'test_secret_key_123');
        Config::set('services.recaptcha.minimum_score', 0.5);

        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response([
                'success' => true,
                'score' => 0.9,
                'action' => 'contact_page',
            ], 200),
        ]);

        $payload = [
            'name' => 'د. ياسر العبداللطيف',
            'email' => 'yasser@consulting.sa',
            'phone' => '+966501239876',
            'project_type' => 'حلول الذكاء الاصطناعي والأتمتة الذكية',
            'message' => 'نرغب في دراسة أتمتة العمليات الداخلية بالذكاء الاصطناعي.',
            'g-recaptcha-response' => 'valid_google_token_abc',
        ];

        $response = $this->postJson('/contact', $payload);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('consultations', [
            'email' => 'yasser@consulting.sa',
            'name' => 'د. ياسر العبداللطيف',
        ]);
    }
}
