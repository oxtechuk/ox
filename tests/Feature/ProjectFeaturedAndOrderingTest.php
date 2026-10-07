<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectFeaturedAndOrderingTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);

        $this->admin = User::firstOrCreate(
            ['email' => 'admin_test@ox-tech.sa'],
            [
                'name' => 'Admin Tester',
                'password' => bcrypt('password123'),
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );
    }

    public function test_admin_can_create_featured_and_non_featured_projects(): void
    {
        // 1. Create featured project with order 2
        $response1 = $this->actingAs($this->admin)->post(route('admin.projects.store'), [
            'title' => 'مشروع مميز ثان',
            'slug' => 'project-featured-two',
            'country_code' => 'sa',
            'country_name' => 'السعودية',
            'sector_slug' => 'commerce',
            'sector_name' => 'تجارة إلكترونية',
            'gradient_class' => 'store',
            'order' => 2,
            'is_featured' => '1',
        ]);

        $response1->assertRedirect(route('admin.projects.index'));
        $this->assertDatabaseHas('projects', [
            'slug' => 'project-featured-two',
            'is_featured' => 1,
            'order' => 2,
        ]);

        // 2. Create non-featured project (is_featured = 0) with order 1
        $response2 = $this->actingAs($this->admin)->post(route('admin.projects.store'), [
            'title' => 'مشروع عادي غير مميز',
            'slug' => 'project-standard-one',
            'country_code' => 'eg',
            'country_name' => 'مصر',
            'sector_slug' => 'commerce',
            'sector_name' => 'تجارة إلكترونية',
            'gradient_class' => 'store',
            'order' => 1,
            'is_featured' => '0',
        ]);

        $response2->assertRedirect(route('admin.projects.index'));
        $this->assertDatabaseHas('projects', [
            'slug' => 'project-standard-one',
            'is_featured' => 0,
            'order' => 1,
        ]);
    }

    public function test_home_page_shows_only_featured_projects_in_order(): void
    {
        Project::query()->delete();

        $featuredFirst = Project::create([
            'title' => 'المشروع المميز الأول',
            'slug' => 'featured-first',
            'country_code' => 'sa',
            'country_name' => 'السعودية',
            'sector_slug' => 'commerce',
            'sector_name' => 'تجارة إلكترونية',
            'gradient_class' => 'store',
            'order' => 1,
            'is_featured' => true,
        ]);

        $featuredSecond = Project::create([
            'title' => 'المشروع المميز الثاني',
            'slug' => 'featured-second',
            'country_code' => 'ae',
            'country_name' => 'الإمارات',
            'sector_slug' => 'auto',
            'sector_name' => 'سيارات',
            'gradient_class' => 'auto-v',
            'order' => 2,
            'is_featured' => true,
        ]);

        $nonFeatured = Project::create([
            'title' => 'مشروع غير معروض بالرئيسية',
            'slug' => 'not-on-home',
            'country_code' => 'eg',
            'country_name' => 'مصر',
            'sector_slug' => 'health',
            'sector_name' => 'طبي',
            'gradient_class' => 'health-v',
            'order' => 0,
            'is_featured' => false,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('المشروع المميز الأول');
        $response->assertSee('المشروع المميز الثاني');
        $response->assertDontSee('مشروع غير معروض بالرئيسية');

        // Check view data order
        $viewProjects = $response->viewData('projects');
        $this->assertCount(2, $viewProjects);
        $this->assertEquals($featuredFirst->id, $viewProjects->first()->id);
        $this->assertEquals($featuredSecond->id, $viewProjects->last()->id);
    }

    public function test_projects_page_displays_featured_first_then_non_featured(): void
    {
        Project::query()->delete();

        $nonFeaturedLowOrder = Project::create([
            'title' => 'مشروع عادي بترتيب 1',
            'slug' => 'regular-order-1',
            'country_code' => 'eg',
            'country_name' => 'مصر',
            'sector_slug' => 'commerce',
            'sector_name' => 'تجارة إلكترونية',
            'gradient_class' => 'store',
            'order' => 1,
            'is_featured' => false,
        ]);

        $featuredHighOrder = Project::create([
            'title' => 'مشروع مميز بترتيب 5',
            'slug' => 'featured-order-5',
            'country_code' => 'sa',
            'country_name' => 'السعودية',
            'sector_slug' => 'commerce',
            'sector_name' => 'تجارة إلكترونية',
            'gradient_class' => 'store',
            'order' => 5,
            'is_featured' => true,
        ]);

        $response = $this->get(route('projects.index'));

        $response->assertStatus(200);
        $viewProjects = $response->viewData('projects');

        // Featured project must come first despite higher order number
        $this->assertEquals($featuredHighOrder->id, $viewProjects->first()->id);
        $this->assertEquals($nonFeaturedLowOrder->id, $viewProjects->last()->id);
    }
}
