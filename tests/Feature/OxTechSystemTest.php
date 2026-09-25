<?php

namespace Tests\Feature;

use App\Models\Consultation;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OxTechSystemTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::firstOrCreate(
            ['email' => 'admin@oxtech.studio'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('admin123456'),
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );
    }

    public function test_landing_page_loads_with_dynamic_data(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('OX');
        $response->assertSee('أعمالنا');
        $response->assertSee('مِرسال');
    }

    public function test_project_details_page_loads_with_required_fields(): void
    {
        $project = Project::firstOrCreate(
            ['slug' => 'mersal-shipping-saas'],
            [
                'title' => 'مِرسال لخدمات الشحن',
                'subtitle' => 'منصة لوجستية سحابية متكاملة',
                'country_name' => 'السعودية',
                'country_code' => 'SA',
                'sector_name' => 'اللوجستيات والشحن',
                'sector_slug' => 'logistics',
                'duration' => '3 أشهر',
                'delivery_date' => 'يناير 2026',
                'summary' => 'منصة سحابية متقدمة لربط المتاجر بمزودي الشحن.',
                'is_featured' => true,
            ]
        );

        $this->assertNotNull($project);

        $response = $this->get('/projects/'.$project->slug);
        $response->assertStatus(200);
        $response->assertSee($project->title);
        $response->assertSee('3 أشهر');
        $response->assertSee('يناير 2026');
        if ($project->duration) {
            $response->assertSee($project->duration);
        }
    }

    public function test_consultation_form_submission_stores_lead(): void
    {
        $payload = [
            'name' => 'سعد المنصور',
            'email' => 'saad@testalmansour.sa',
            'phone' => '+966551234567',
            'project_type' => 'متاجر إلكترونية',
            'budget' => '$10,000 - $25,000',
            'message' => 'نود تطوير متجر إلكتروني مع نظام ولاء متقدم وربط بوابات دفع.',
        ];

        $response = $this->postJson('/consultation/store', $payload);
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('consultations', [
            'email' => 'saad@testalmansour.sa',
            'name' => 'سعد المنصور',
        ]);
    }

    public function test_consultation_honeypot_discards_bot_submission(): void
    {
        $payload = [
            'name' => 'Spam Bot',
            'email' => 'spambot@example.com',
            'message' => 'This is a spam message attempting to submit via bot script.',
            'hp_check' => 'http://spam-trap-link.ru', // bot fills the hidden trap
        ];

        $response = $this->postJson('/consultation/store', $payload);
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // Assert database does NOT contain this spam lead
        $this->assertDatabaseMissing('consultations', [
            'email' => 'spambot@example.com',
        ]);
    }

    public function test_consultation_validation_fails_on_short_message(): void
    {
        $payload = [
            'name' => 'أحمد',
            'email' => 'ahmed@test.sa',
            'message' => 'قصير', // less than 10 characters
        ];

        $response = $this->postJson('/consultation/store', $payload);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['message']);
    }

    public function test_admin_guest_redirected_from_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_login_and_access_dashboard(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@oxtech.studio',
            'password' => 'admin123456',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($this->admin);

        $dashResponse = $this->actingAs($this->admin)->get('/admin/dashboard');
        $dashResponse->assertStatus(200);
        $dashResponse->assertSee('لوحة الإحصائيات');
    }

    public function test_admin_can_create_new_project_with_details(): void
    {
        $uniqueSlug = 'test-proj-'.uniqid();
        $payload = [
            'title' => 'مشروع تجريبي جديد',
            'slug' => $uniqueSlug,
            'subtitle' => 'تطبيق سحابي متطور',
            'country_code' => 'sa',
            'country_name' => 'السعودية',
            'sector_slug' => 'commerce',
            'sector_name' => 'تجارة إلكترونية',
            'gradient_class' => 'store',
            'duration' => ' شهرين',
            'delivery_date' => 'سبتمبر 2026',
            'live_url' => 'https://testproject.oxtech.studio',
            'short_description' => 'وصف تجريبي قصير للمشروع',
            'summary' => 'ملخص كامل عن المشروع التجريبي',
            'challenge' => 'تحديات الأداء',
            'solution' => 'حلول التخزين المؤقت',
            'key_features_raw' => "خاصية 1\nخاصية 2",
            'technologies_raw' => 'Laravel, Vue, Tailwind',
            'is_featured' => 1,
            'is_big' => 0,
            'order' => 99,
        ];

        $response = $this->actingAs($this->admin)->post('/admin/projects', $payload);
        $response->assertRedirect('/admin/projects');

        $this->assertDatabaseHas('projects', [
            'slug' => $uniqueSlug,
            'title' => 'مشروع تجريبي جديد',
        ]);
    }

    public function test_admin_can_update_consultation_status_and_notes(): void
    {
        $consultation = Consultation::create([
            'name' => 'خالد الحربي',
            'email' => 'khaled@harbi.sa',
            'message' => 'استفسار عن تطوير تطبيق SaaS',
            'status' => 'new',
        ]);

        $response = $this->actingAs($this->admin)->patch('/admin/consultations/'.$consultation->id.'/status', [
            'status' => 'scheduled',
            'admin_notes' => 'تم التواصل وتحديد اجتماع يوم الأربعاء 10 صباحاً',
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('consultations', [
            'id' => $consultation->id,
            'status' => 'scheduled',
            'admin_notes' => 'تم التواصل وتحديد اجتماع يوم الأربعاء 10 صباحاً',
        ]);
    }

    public function test_admin_can_update_site_dynamic_content(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/site-content/update', [
            'hero_kicker' => 'SOFTWARE STUDIO · 2026',
            'hero_title_p1' => 'نبتكر برمجيات',
            'hero_title_highlight' => 'استثنائية.',
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('site_contents', [
            'key' => 'hero_kicker',
            'value' => 'SOFTWARE STUDIO · 2026',
        ]);
    }

    public function test_language_switch_route_and_rendering(): void
    {
        // 1. Language switcher route sets session & cookie
        $response = $this->get('/lang/en');
        $response->assertRedirect();
        $response->assertSessionHas('locale', 'en');
        $response->assertCookie('locale', 'en');

        // 2. English render has LTR and English keywords
        $enResponse = $this->withSession(['locale' => 'en'])->get('/');
        $enResponse->assertStatus(200);
        $enResponse->assertSee('dir="ltr"', false);
        $enResponse->assertSee('lang="en"', false);
        $enResponse->assertSee('Engineered to Scale');
        $enResponse->assertSee('All Sectors');

        // 3. French switch and render
        $frResponse = $this->withSession(['locale' => 'fr'])->get('/');
        $frResponse->assertStatus(200);
        $frResponse->assertSee('dir="ltr"', false);
        $frResponse->assertSee('lang="fr"', false);
        $frResponse->assertSee('Ingénierie Haute Performance');
        $frResponse->assertSee('Tous les Secteurs');

        // 4. Arabic default render has RTL
        $arResponse = $this->withSession(['locale' => 'ar'])->get('/');
        $arResponse->assertStatus(200);
        $arResponse->assertSee('dir="rtl"', false);
        $arResponse->assertSee('lang="ar"', false);
    }
}
