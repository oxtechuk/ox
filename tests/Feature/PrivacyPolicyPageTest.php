<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PrivacyPolicyPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_privacy_policy_page_loads_successfully_in_arabic(): void
    {
        $response = $this->get('/privacy-policy');

        $response->assertOk();
        $response->assertViewIs('legal.privacy');
        $response->assertSee('سياسة الخصوصية وحماية البيانات');
        $response->assertSee('برامج سطح المكتب');
        $response->assertSee('إضافات واكستنشن المتصفح');
        $response->assertSee('Local-First');
        $response->assertSee('privacy@oxtech.uk');
    }

    public function test_privacy_alias_route_works(): void
    {
        $response = $this->get('/privacy');

        $response->assertOk();
        $response->assertViewIs('legal.privacy');
    }

    public function test_privacy_policy_page_loads_in_english(): void
    {
        $response = $this->get('/privacy-policy?lang=en');

        $response->assertOk();
        $response->assertSee('Privacy & Data Protection Policy');
        $response->assertSee('Desktop Applications & Software Privacy');
        $response->assertSee('Browser Extensions & Plugins Privacy Policy');
        $response->assertSee('Chrome Web Store');
    }

    public function test_privacy_policy_page_loads_in_french(): void
    {
        $response = $this->get('/privacy-policy?lang=fr');

        $response->assertOk();
        $response->assertSee('Politique de Confidentialité et Protection des Données');
        $response->assertSee('Logiciels Bureau');
        $response->assertSee('Extensions Navigateur');
    }

    public function test_privacy_policy_is_present_in_dynamic_sitemap(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertSee(route('privacy.policy'));
    }
}
