<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProductionSecurityAuditTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;

    protected User $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::firstOrCreate(
            ['email' => 'sec_admin@oxtech.studio'],
            [
                'name' => 'Sec Admin',
                'password' => 'admin123456',
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );

        $this->customer = User::firstOrCreate(
            ['email' => 'customer_test@oxtech.studio'],
            [
                'name' => 'Customer User',
                'password' => 'customer123456',
                'role' => 'customer',
                'is_active' => true,
            ]
        );
    }

    public function test_customer_cannot_access_protected_admin_panel(): void
    {
        // Authenticated as regular customer (non-admin)
        $response = $this->actingAs($this->customer)->get('/admin/dashboard');

        // Must return 403 Forbidden
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    public function test_sitemap_xml_returns_valid_xml_with_multilingual_entries(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=utf-8');
        $response->assertSee('<?xml', false);
        $response->assertSee('urlset', false);
        $response->assertSee('xhtml:link', false);
    }

    public function test_robots_txt_returns_disallows_and_sitemap(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/plain; charset=utf-8');
        $response->assertSee('Disallow: /admin/');
        $response->assertSee('GPTBot');
        $response->assertSee('PerplexityBot');
        $response->assertSee('ClaudeBot');
        $response->assertSee('Sitemap:');
    }

    public function test_llms_txt_endpoints_are_available_for_ai_engines(): void
    {
        $response = $this->get('/llms.txt');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/markdown; charset=utf-8');
        $response->assertSee('oxtech.uk');
        $response->assertSee('https://github.com/oxtechuk');

        $fullResponse = $this->get('/llms-full.txt');
        $fullResponse->assertStatus(200);
        $fullResponse->assertHeader('Content-Type', 'text/markdown; charset=utf-8');
        $fullResponse->assertSee('Complete AI Knowledge Base');
    }

    public function test_schema_org_contains_social_media_profiles_and_map(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('instagram.com/oxtech.uk', false);
        $response->assertSee('github.com/oxtechuk', false);
        $response->assertSee('share.google/82M8ufbu784MYpH3y', false);
    }

    public function test_non_existent_page_returns_404_error_page(): void
    {
        $response = $this->get('/non-existent-page-url-'.time());

        $response->assertStatus(404);
        $response->assertSee('404');
    }

    public function test_security_headers_are_present_on_web_responses(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    public function test_consultation_store_validates_and_stores_lead(): void
    {
        $response = $this->post('/consultation/store', [
            'name' => 'فهد التميمي',
            'email' => 'fahad@example.com',
            'phone' => '+966501234567',
            'company_name' => 'شركة التميمي القابضة',
            'message' => 'نود تطوير منصة تجارة إلكترونية سحابية متكاملة لربط الفروع.',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('consultations', [
            'email' => 'fahad@example.com',
        ]);
    }

    public function test_storage_fallback_route_serves_uploaded_files(): void
    {
        $testPath = storage_path('app/public/test-asset.txt');
        if (! file_exists(dirname($testPath))) {
            mkdir(dirname($testPath), 0755, true);
        }
        file_put_contents($testPath, 'OX_STORAGE_TEST_CONTENT');

        try {
            $response = $this->get('/storage/test-asset.txt');
            $response->assertStatus(200);
            $this->assertFileExists($response->getFile()->getPathname());

            $notFound = $this->get('/storage/does-not-exist-'.time().'.png');
            $notFound->assertStatus(404);
        } finally {
            if (file_exists($testPath)) {
                unlink($testPath);
            }
        }
    }
}
