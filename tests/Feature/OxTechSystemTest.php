<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Testimonial;
use App\Models\Consultation;
use App\Models\SiteContent;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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

        $response = $this->get('/projects/' . $project->slug);
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
        $uniqueSlug = 'test-proj-' . uniqid();
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

        $response = $this->actingAs($this->admin)->patch('/admin/consultations/' . $consultation->id . '/status', [
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
}
