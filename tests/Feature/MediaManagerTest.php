<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaManagerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);

        $this->admin = User::firstOrCreate(
            ['email' => 'admin@ox-tech.sa'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
    }

    public function test_guest_cannot_access_media_library(): void
    {
        $response = $this->get(route('admin.media.index'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_media_library_page(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.media.index'));

        $response->assertStatus(200);
        $response->assertSee('مكتبة الوسائط وضغط الصور');
        $response->assertSee('إجمالي ملفات الصور');
        $response->assertSee('WebP');
    }

    public function test_admin_can_upload_and_optimize_image_to_webp(): void
    {
        Storage::fake('public');

        // Create a 100x100 fake png image
        $file = UploadedFile::fake()->image('banner_hero.png', 800, 600);

        $response = $this->actingAs($this->admin)->post(route('admin.media.store'), [
            'files' => [$file],
        ]);

        $response->assertRedirect(route('admin.media.index'));
        $response->assertSessionHas('success');

        // Verify stored files in media directory
        $storedFiles = Storage::disk('public')->allFiles('media');
        $this->assertNotEmpty($storedFiles);

        // Check that at least one stored file is a webp
        $webpFiles = array_filter($storedFiles, fn ($f) => str_ends_with($f, '.webp'));
        $this->assertNotEmpty($webpFiles);
    }

    public function test_media_destroy_blocks_path_traversal(): void
    {
        $response = $this->actingAs($this->admin)->delete(route('admin.media.destroy'), [
            'path' => '../../../../windows/system32/cmd.exe',
        ]);

        $response->assertSessionHas('error');

        $responseTraversal = $this->actingAs($this->admin)->delete(route('admin.media.destroy'), [
            'path' => 'assets/style.css',
        ]);

        $responseTraversal->assertSessionHas('error');
    }

    public function test_admin_can_delete_uploaded_media_file(): void
    {
        Storage::fake('public');

        // Place a test file in storage
        Storage::disk('public')->put('media/sample_test.webp', 'fake_webp_binary_content');
        $this->assertTrue(Storage::disk('public')->exists('media/sample_test.webp'));

        $response = $this->actingAs($this->admin)->delete(route('admin.media.destroy'), [
            'path' => 'media/sample_test.webp',
        ]);

        $response->assertRedirect(route('admin.media.index'));
        $response->assertSessionHas('success');

        $this->assertFalse(Storage::disk('public')->exists('media/sample_test.webp'));
    }

    public function test_admin_can_trigger_batch_optimization(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.media.batch-optimize'));

        $response->assertRedirect(route('admin.media.index'));
        $response->assertSessionHas('success');
    }
}
