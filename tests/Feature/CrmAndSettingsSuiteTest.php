<?php

namespace Tests\Feature;

use App\Mail\ConsultationAdminNotificationMail;
use App\Mail\ConsultationConfirmationMail;
use App\Mail\InvoiceMail;
use App\Mail\QuotationMail;
use App\Models\Client;
use App\Models\Consultation;
use App\Models\Invoice;
use App\Models\Quotation;
use App\Models\SiteSetting;
use App\Models\TrackingPixel;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CrmAndSettingsSuiteTest extends TestCase
{
    use DatabaseTransactions;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::firstOrCreate(
            ['email' => 'admin_tester@ox-tech.sa'],
            [
                'name' => 'Admin Test',
                'password' => bcrypt('password'),
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );
    }

    public function test_sitemap_xml_and_robots_txt_are_accessible_and_valid(): void
    {
        $sitemapRes = $this->get('/sitemap.xml');
        $sitemapRes->assertStatus(200);
        $sitemapRes->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
        $sitemapRes->assertSee('urlset');

        $robotsRes = $this->get('/robots.txt');
        $robotsRes->assertStatus(200);
        $robotsRes->assertSee('User-agent: *');
        $robotsRes->assertSee('Sitemap:');
    }

    public function test_marketing_attribution_middleware_captures_utm_and_platform(): void
    {
        Mail::fake();

        $response = $this->withSession([])->get('/?utm_source=snapchat&utm_medium=cpc&utm_campaign=saudi_tech_2026');
        $response->assertStatus(200);
        $response->assertSessionHas('attribution.utm_source', 'snapchat');
        $response->assertSessionHas('attribution.platform_detected', 'Snapchat');

        // Submit consultation form and verify attribution saved
        $postRes = $this->post('/consultation/store', [
            'name' => 'سعد القحطاني',
            'email' => 'saad_unique_'.time().'@example.sa',
            'phone' => '+966551234567',
            'company_name' => 'شركة قمة التقنية',
            'project_type' => 'تطبيقات ومنتجات',
            'budget' => '$25,000 - $50,000',
            'message' => 'نحتاج تطبيق سحابي ولوجستي في الرياض وجدة.',
        ]);

        $postRes->assertSessionHas('success');

        $consultation = Consultation::where('phone', '+966551234567')->latest()->first();
        $this->assertNotNull($consultation);
        $this->assertEquals('snapchat', $consultation->utm_source);
        $this->assertEquals('Snapchat', $consultation->platform_detected);
        $this->assertEquals('saudi_tech_2026', $consultation->utm_campaign);

        Mail::assertQueued(ConsultationConfirmationMail::class);
        Mail::assertQueued(ConsultationAdminNotificationMail::class);
    }

    public function test_admin_can_update_settings_and_seo(): void
    {
        $this->actingAs($this->adminUser);

        $response = $this->post(route('admin.settings.update'), [
            'site_name' => 'OX Tech Enterprise Solutions',
            'site_tagline' => 'الريادة في صناعة الحلول السحابية',
            'seo_meta_title' => 'أفضل بيت برمجيات في السعودية والخليج',
            'seo_meta_description' => 'تطوير تطبيقات ومنصات ذكية في الرياض ودبي والقاهرة',
            'office_riyadh_address' => 'شارع التخصصي، الرياض، المملكة العربية السعودية',
            'contact_email_primary' => 'contact@ox-tech.sa',
            'brand_color_primary' => '#c9fa4b',
        ]);

        $response->assertRedirect();
        $this->assertEquals('OX Tech Enterprise Solutions', SiteSetting::get('site_name'));
        $this->assertEquals('contact@ox-tech.sa', SiteSetting::get('contact_email_primary'));
    }

    public function test_admin_can_update_tracking_pixels(): void
    {
        $this->actingAs($this->adminUser);

        $response = $this->post(route('admin.tracking.update'), [
            'pixels' => [
                'meta' => [
                    'pixel_id' => '998877665544332',
                    'is_active' => '1',
                ],
                'snapchat' => [
                    'pixel_id' => 'snap-pixel-123456',
                    'is_active' => '1',
                ],
                'tiktok' => [
                    'pixel_id' => 'TT-PIXEL-789',
                    'is_active' => '1',
                ],
                'google_analytics' => [
                    'pixel_id' => 'G-OXTECH2026',
                    'is_active' => '1',
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.tracking.index'));

        $meta = TrackingPixel::where('platform', 'meta')->first();
        $this->assertNotNull($meta);
        $this->assertTrue($meta->is_active);
        $this->assertEquals('998877665544332', $meta->pixel_id);
    }

    public function test_crm_client_creation_and_financial_balance(): void
    {
        $this->actingAs($this->adminUser);

        $uniqueEmail = 'faisal_'.time().'@harbi-group.sa';
        $response = $this->post(route('admin.crm.clients.store'), [
            'name' => 'فيصل الحربي',
            'email' => $uniqueEmail,
            'phone' => '+966509998888',
            'company_name' => 'مجموعة الحربي القابضة',
            'country' => 'السعودية',
            'city' => 'الرياض',
            'status' => 'active',
            'lead_source' => 'Snapchat Ads',
        ]);

        $client = Client::where('email', $uniqueEmail)->first();
        $this->assertNotNull($client);
        $response->assertRedirect(route('admin.crm.clients.show', $client));
        $this->assertEquals(0, $client->outstanding_balance);
    }

    public function test_quotation_creation_discount_and_conversion_to_invoice(): void
    {
        $this->actingAs($this->adminUser);
        Mail::fake();

        $client = Client::create([
            'name' => 'ريم الدوسري',
            'email' => 'reem_'.time().'@al-dossary.sa',
            'status' => 'active',
        ]);

        // Create Quotation with 2 items and 10% discount
        $postData = [
            'client_id' => $client->id,
            'title' => 'تطوير منصة وتطبيق ذكاء اصطناعي',
            'quotation_date' => now()->toDateString(),
            'valid_until' => now()->addDays(30)->toDateString(),
            'currency' => 'SAR',
            'discount_type' => 'percentage',
            'discount_value' => 10,
            'vat_rate' => 15,
            'status' => 'accepted',
            'items' => [
                [
                    'service_name' => 'برمجة الواجهات والتطبيق',
                    'description' => 'Flutter iOS & Android',
                    'quantity' => 1,
                    'unit_price' => 30000,
                ],
                [
                    'service_name' => 'البنية التحتية السحابية وAPI',
                    'description' => 'Laravel Cloud Backend',
                    'quantity' => 1,
                    'unit_price' => 20000,
                ],
            ],
        ];

        $response = $this->post(route('admin.crm.quotations.store'), $postData);
        $response->assertRedirect();

        $quotation = Quotation::where('client_id', $client->id)->first();
        $this->assertNotNull($quotation);
        $this->assertEquals(50000, $quotation->subtotal);
        $this->assertEquals(5000, $quotation->discount_amount); // 10% of 50000
        $this->assertEquals(6750, $quotation->vat_amount); // 15% of 45000
        $this->assertEquals(51750, $quotation->total_amount);

        // Test Quotation Email dispatch
        $emailRes = $this->post(route('admin.crm.quotations.send_email', $quotation), [
            'custom_message' => 'عزيزتنا ريم، نرفق لك العرض الفني المالي المعتمد.',
        ]);
        $emailRes->assertSessionHas('success');
        Mail::assertQueued(QuotationMail::class);

        // Convert to Invoice
        $convertRes = $this->post(route('admin.crm.quotations.convert_to_invoice', $quotation));
        $convertRes->assertRedirect();

        $invoice = Invoice::where('quotation_id', $quotation->id)->first();
        $this->assertNotNull($invoice);
        $this->assertEquals(51750, $invoice->total_amount);
        $this->assertEquals(51750, $invoice->due_amount);

        // Refresh client financials
        $client->refresh();
        $this->assertEquals(51750, $client->total_billed);
        $this->assertEquals(51750, $client->outstanding_balance);
    }

    public function test_invoice_payment_recording_updates_due_amount_and_client_debt(): void
    {
        $this->actingAs($this->adminUser);
        Mail::fake();

        $client = Client::create([
            'name' => 'طارق الزهراني',
            'email' => 'tariq_'.time().'@al-zahrani.sa',
            'status' => 'active',
        ]);

        $invoice = Invoice::create([
            'client_id' => $client->id,
            'invoice_number' => 'INV-TEST-'.time(),
            'title' => 'عقد الصيانة السنوية',
            'issue_date' => now(),
            'due_date' => now()->addDays(14),
            'currency' => 'SAR',
            'total_amount' => 23000,
            'paid_amount' => 0,
            'due_amount' => 23000,
            'status' => 'sent',
        ]);

        $client->recalculateFinancials();
        $this->assertEquals(23000, $client->outstanding_balance);

        // Record partial payment of 10,000 SAR
        $paymentRes = $this->post(route('admin.crm.invoices.payments.store', $invoice), [
            'amount' => 10000,
            'payment_date' => now()->toDateString(),
            'payment_method' => 'bank_transfer',
            'transaction_reference' => 'TR-SNB-112233',
        ]);

        $paymentRes->assertSessionHas('success');

        $invoice->refresh();
        $this->assertEquals(10000, $invoice->paid_amount);
        $this->assertEquals(13000, $invoice->due_amount);
        $this->assertEquals('partially_paid', $invoice->status);

        $client->refresh();
        $this->assertEquals(10000, $client->total_paid);
        $this->assertEquals(13000, $client->outstanding_balance);

        // Send Invoice Email
        $this->post(route('admin.crm.invoices.send_email', $invoice), [
            'custom_message' => 'إشعار استلام دفعة 10,000 ريال والمتبقي 13,000 ريال.',
        ]);
        Mail::assertQueued(InvoiceMail::class);
    }

    public function test_reports_dashboard_renders_with_attribution_and_financials(): void
    {
        $this->actingAs($this->adminUser);

        Consultation::create([
            'name' => 'عميل سناب',
            'email' => 'snapclient_'.time().'@example.com',
            'message' => 'استشارة تجارة إلكترونية',
            'platform_detected' => 'Snapchat',
            'utm_source' => 'snapchat',
        ]);

        Consultation::create([
            'name' => 'عميل تيك توك',
            'email' => 'ttclient_'.time().'@example.com',
            'message' => 'استشارة تطبيق توصيل',
            'platform_detected' => 'TikTok',
            'utm_source' => 'tiktok',
        ]);

        $response = $this->get(route('admin.reports.index'));
        $response->assertStatus(200);
        $response->assertSee('Snapchat');
        $response->assertSee('TikTok');
    }

    public function test_admin_crm_pages_load_successfully(): void
    {
        $this->actingAs($this->adminUser);

        $clientRes = $this->get(route('admin.crm.clients.index'));
        $clientRes->assertStatus(200);
        $clientRes->assertSee('نظام إدارة العملاء');

        $quotationRes = $this->get(route('admin.crm.quotations.index'));
        $quotationRes->assertStatus(200);
        $quotationRes->assertSee('عروض الأسعار');

        $invoiceRes = $this->get(route('admin.crm.invoices.index'));
        $invoiceRes->assertStatus(200);
        $invoiceRes->assertSee('إدارة الفواتير والمستحقات');

        $settingsRes = $this->get(route('admin.settings.index'));
        $settingsRes->assertStatus(200);

        $trackingRes = $this->get(route('admin.tracking.index'));
        $trackingRes->assertStatus(200);
    }
}
