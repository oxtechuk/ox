<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Services\ImageOptimizerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function __construct(
        protected ImageOptimizerService $imageOptimizer
    ) {}

    public function index()
    {
        $testimonials = Testimonial::orderBy('order', 'asc')->get();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'partner_name' => 'required|string|max:191',
            'partner_role' => 'required|string|max:191',
            'partner_country' => 'nullable|string|max:100',
            'quote' => 'required|string',
            'video_type' => 'required|in:url,file,youtube',
            'video_url' => 'nullable|string|max:255',
            'video_file' => 'nullable|mimes:mp4,mov,ogg,webm|max:51200',
            'poster_image' => 'nullable|image|max:5120',
            'number_badge' => 'nullable|string|max:10',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;
        $validated['order'] = $validated['order'] ?? (Testimonial::max('order') + 1);

        if ($request->hasFile('video_file')) {
            $path = $request->file('video_file')->store('testimonials/videos', 'public');
            $validated['video_url'] = $path;
            $validated['video_type'] = 'file';
        }

        if ($request->hasFile('poster_image')) {
            $opt = $this->imageOptimizer->optimizeAndStore($request->file('poster_image'), 'testimonials/posters', 'public', 1200, 82);
            $validated['poster_image'] = $opt['path'];
        }

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'تم إضافة فيديو الريفيو بنجاح!');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'partner_name' => 'required|string|max:191',
            'partner_role' => 'required|string|max:191',
            'partner_country' => 'nullable|string|max:100',
            'quote' => 'required|string',
            'video_type' => 'required|in:url,file,youtube',
            'video_url' => 'nullable|string|max:255',
            'video_file' => 'nullable|mimes:mp4,mov,ogg,webm|max:51200',
            'poster_image' => 'nullable|image|max:5120',
            'number_badge' => 'nullable|string|max:10',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? $testimonial->order;

        if ($request->hasFile('video_file')) {
            if ($testimonial->video_url && ! str_starts_with($testimonial->video_url, 'http')) {
                Storage::disk('public')->delete($testimonial->video_url);
            }
            $path = $request->file('video_file')->store('testimonials/videos', 'public');
            $validated['video_url'] = $path;
            $validated['video_type'] = 'file';
        }

        if ($request->hasFile('poster_image')) {
            if ($testimonial->poster_image && ! str_starts_with($testimonial->poster_image, 'assets/')) {
                Storage::disk('public')->delete($testimonial->poster_image);
            }
            $opt = $this->imageOptimizer->optimizeAndStore($request->file('poster_image'), 'testimonials/posters', 'public', 1200, 82);
            $validated['poster_image'] = $opt['path'];
        }

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'تم تحديث الريفيو بنجاح!');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->video_url && ! str_starts_with($testimonial->video_url, 'http')) {
            Storage::disk('public')->delete($testimonial->video_url);
        }
        if ($testimonial->poster_image && ! str_starts_with($testimonial->poster_image, 'assets/')) {
            Storage::disk('public')->delete($testimonial->poster_image);
        }
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'تم حذف الريفيو بنجاح.');
    }
}
