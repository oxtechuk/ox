<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\ImageOptimizerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function __construct(
        protected ImageOptimizerService $imageOptimizer
    ) {}

    public function index(Request $request)
    {
        $query = Project::query();

        if ($request->filled('country')) {
            $query->where('country_code', $request->country);
        }

        if ($request->filled('sector')) {
            $query->where('sector_slug', $request->sector);
        }

        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === '1');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('subtitle', 'like', "%{$search}%")
                    ->orWhere('client_name', 'like', "%{$search}%");
            });
        }

        $projects = $query->orderByDesc('is_featured')->orderBy('order', 'asc')->orderBy('id', 'desc')->paginate(15);

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:projects,slug',
            'subtitle' => 'nullable|string|max:191',
            'country_code' => 'required|string|max:10',
            'country_name' => 'required|string|max:100',
            'sector_slug' => 'required|string|max:30',
            'sector_name' => 'required|string|max:100',
            'gradient_class' => 'required|string|max:50',
            'custom_gradient' => 'nullable|string|max:255',
            'is_big' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'order' => 'nullable|integer',
            'number_badge' => 'nullable|string|max:10',
            'short_description' => 'nullable|string',
            'title_en' => 'nullable|string|max:191',
            'subtitle_en' => 'nullable|string|max:191',
            'country_name_en' => 'nullable|string|max:100',
            'sector_name_en' => 'nullable|string|max:100',
            'short_description_en' => 'nullable|string',
            'client_name_en' => 'nullable|string|max:191',
            'duration_en' => 'nullable|string|max:100',
            'delivery_date_en' => 'nullable|string|max:100',
            'summary_en' => 'nullable|string',
            'challenge_en' => 'nullable|string',
            'solution_en' => 'nullable|string',
            'key_features_en_raw' => 'nullable|string',
            'impact_stat' => 'nullable|string|max:191',
            'client_name' => 'nullable|string|max:191',
            'duration' => 'nullable|string|max:100',
            'delivery_date' => 'nullable|string|max:100',
            'live_url' => 'nullable|url|max:255',
            'video_url' => 'nullable|string|max:500',
            'summary' => 'nullable|string',
            'challenge' => 'nullable|string',
            'solution' => 'nullable|string',
            'key_features_raw' => 'nullable|string',
            'technologies_raw' => 'nullable|string',
            'hero_image' => 'nullable|image|max:5120',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|image|max:5120',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']) ?: 'project-'.time();
        }

        // Handle raw features (one per line)
        if ($request->filled('key_features_raw')) {
            $validated['key_features'] = array_values(array_filter(array_map('trim', explode("\n", $request->key_features_raw))));
        }

        if ($request->filled('key_features_en_raw')) {
            $validated['key_features_en'] = array_values(array_filter(array_map('trim', explode("\n", $request->key_features_en_raw))));
        }

        // Handle raw technologies (comma separated or newline)
        if ($request->filled('technologies_raw')) {
            $techs = preg_split('/[\n,]+/', $request->technologies_raw);
            $validated['technologies'] = array_values(array_filter(array_map('trim', $techs)));
        }

        $validated['is_big'] = $request->boolean('is_big');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['order'] = $request->filled('order') ? (int) $request->input('order') : (Project::max('order') + 1);

        if ($request->hasFile('hero_image')) {
            $opt = $this->imageOptimizer->optimizeAndStore($request->file('hero_image'), 'projects', 'public', 1600, 82);
            $validated['hero_image'] = $opt['path'];
        }

        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $gFile) {
                if ($gFile && $gFile->isValid()) {
                    $opt = $this->imageOptimizer->optimizeAndStore($gFile, 'projects/gallery', 'public', 1600, 82);
                    $galleryPaths[] = $opt['path'];
                }
            }
            $validated['gallery'] = $galleryPaths;
        }

        Project::create($validated);

        return redirect()->route('admin.projects.index')->with('success', 'تم إضافة المشروع بنجاح!');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:projects,slug,'.$project->id,
            'subtitle' => 'nullable|string|max:191',
            'country_code' => 'required|string|max:10',
            'country_name' => 'required|string|max:100',
            'sector_slug' => 'required|string|max:30',
            'sector_name' => 'required|string|max:100',
            'gradient_class' => 'required|string|max:50',
            'custom_gradient' => 'nullable|string|max:255',
            'is_big' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'order' => 'nullable|integer',
            'number_badge' => 'nullable|string|max:10',
            'short_description' => 'nullable|string',
            'title_en' => 'nullable|string|max:191',
            'subtitle_en' => 'nullable|string|max:191',
            'country_name_en' => 'nullable|string|max:100',
            'sector_name_en' => 'nullable|string|max:100',
            'short_description_en' => 'nullable|string',
            'client_name_en' => 'nullable|string|max:191',
            'duration_en' => 'nullable|string|max:100',
            'delivery_date_en' => 'nullable|string|max:100',
            'summary_en' => 'nullable|string',
            'challenge_en' => 'nullable|string',
            'solution_en' => 'nullable|string',
            'key_features_en_raw' => 'nullable|string',
            'impact_stat' => 'nullable|string|max:191',
            'client_name' => 'nullable|string|max:191',
            'duration' => 'nullable|string|max:100',
            'delivery_date' => 'nullable|string|max:100',
            'live_url' => 'nullable|url|max:255',
            'video_url' => 'nullable|string|max:500',
            'summary' => 'nullable|string',
            'challenge' => 'nullable|string',
            'solution' => 'nullable|string',
            'key_features_raw' => 'nullable|string',
            'technologies_raw' => 'nullable|string',
            'hero_image' => 'nullable|image|max:5120',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|image|max:5120',
            'remove_gallery_items' => 'nullable|array',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']) ?: $project->slug;
        }

        if ($request->has('key_features_raw')) {
            $validated['key_features'] = array_values(array_filter(array_map('trim', explode("\n", $request->key_features_raw))));
        }

        if ($request->has('key_features_en_raw')) {
            $validated['key_features_en'] = array_values(array_filter(array_map('trim', explode("\n", $request->key_features_en_raw))));
        }

        if ($request->has('technologies_raw')) {
            $techs = preg_split('/[\n,]+/', $request->technologies_raw);
            $validated['technologies'] = array_values(array_filter(array_map('trim', $techs)));
        }

        $validated['is_big'] = $request->boolean('is_big');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['order'] = $request->filled('order') ? (int) $request->input('order') : ($project->order ?? 0);

        if ($request->hasFile('hero_image')) {
            if ($project->hero_image && ! str_starts_with($project->hero_image, 'assets/')) {
                Storage::disk('public')->delete($project->hero_image);
            }
            $opt = $this->imageOptimizer->optimizeAndStore($request->file('hero_image'), 'projects', 'public', 1600, 82);
            $validated['hero_image'] = $opt['path'];
        }

        // Handle gallery images: preserve existing, remove selected, and append new uploads
        $currentGallery = is_array($project->gallery) ? $project->gallery : [];

        if ($request->has('remove_gallery_items') && is_array($request->remove_gallery_items)) {
            foreach ($request->remove_gallery_items as $removePath) {
                if (! str_starts_with($removePath, 'assets/')) {
                    Storage::disk('public')->delete($removePath);
                }
                $currentGallery = array_values(array_filter($currentGallery, fn ($p) => $p !== $removePath));
            }
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $gFile) {
                if ($gFile && $gFile->isValid()) {
                    $opt = $this->imageOptimizer->optimizeAndStore($gFile, 'projects/gallery', 'public', 1600, 82);
                    $currentGallery[] = $opt['path'];
                }
            }
        }

        $validated['gallery'] = array_values($currentGallery);

        $project->update($validated);

        return redirect()->route('admin.projects.index')->with('success', 'تم تحديث بيانات المشروع بنجاح!');
    }

    public function destroy(Project $project)
    {
        if ($project->hero_image && ! str_starts_with($project->hero_image, 'assets/')) {
            Storage::disk('public')->delete($project->hero_image);
        }
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'تم حذف المشروع بنجاح.');
    }
}
