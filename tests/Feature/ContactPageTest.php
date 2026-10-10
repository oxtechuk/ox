<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        SiteSetting::create(['key' => 'site_name', 'value' => 'OX Tech']);
        SiteSetting::create(['key' => 'contact_email_primary', 'value' => 'contact@oxtech.uk']);
        SiteSetting::create(['key' => 'contact_phone_primary', 'value' => '+966500000000']);
    }

    public function test_contact_page_loads_successfully_in_arabic(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('تواصل معنا');
        $response->assertSee('تأكيد وحجز الاستشارة المجانية');
        $response->assertDontSee('id="c_budget"', false);
        $response->assertSee('fbq(\'track\', \'PageView\')', false);
    }

    public function test_contact_page_loads_with_language_switch_to_english(): void
    {
        $response = $this->withSession(['locale' => 'en'])->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('Contact Us');
        $response->assertSee('Book an Executive Tech Discovery Session');
    }

    public function test_contact_page_loads_with_language_switch_to_french(): void
    {
        $response = $this->withSession(['locale' => 'fr'])->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('Contactez-nous');
        $response->assertSee('Réservez une Session de Cadrage Technique');
    }

    public function test_submitting_contact_form_stores_lead_and_returns_success(): void
    {
        $payload = [
            'name' => 'سلطان القحطاني',
            'email' => 'sultan@company.sa',
            'phone' => '+966501234567',
            'project_type' => 'منصة وبوابة رقمية / ويب',
            'budget' => 'مرنة / سنناقشها في الجلسة',
            'contact_preference' => 'واتساب (الأسرع)',
            'message' => 'نحتاج بناء منصة تجارة رقمية متكاملة وسريعة مع ربط بوابات دفع.',
            '_form_load_time' => time() - 10,
        ];

        $response = $this->postJson(route('contact.store'), $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('consultations', [
            'name' => 'سلطان القحطاني',
            'email' => 'sultan@company.sa',
        ]);
    }
}
