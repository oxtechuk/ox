<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalProduct;
use App\Models\ProductCategory;
use App\Models\ProductLandingPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DigitalProductController extends Controller
{
    /**
     * Display a listing of digital products.
     */
    public function index(Request $request): View
    {
        $query = DigitalProduct::with(['category', 'landingPage'])->withCount('orderItems');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('tagline', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = ProductCategory::where('is_active', true)->get();

        return view('admin.digital-products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        $categories = ProductCategory::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.digital-products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:digital_products,slug',
            'tagline' => 'nullable|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'currency' => 'required|string|max:3',
            'version' => 'required|string|max:20',
            'features' => 'nullable|string', // newline separated
            'system_requirements' => 'nullable|string', // newline separated
            'software_file' => 'nullable|file|max:102400', // up to 100MB
            'has_license_key' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:active,draft,archived',
            'create_landing_page' => 'nullable|boolean',
            'landing_headline' => 'nullable|string|max:255',
            'landing_subheadline' => 'nullable|string',
        ]);

        $slug = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        if (DigitalProduct::where('slug', $slug)->exists()) {
            $slug .= '-'.time();
        }

        // Parse features & requirements from multiline textarea
        $features = ! empty($validated['features'])
            ? array_values(array_filter(array_map('trim', explode("\n", $validated['features']))))
            : [];

        $systemRequirements = ! empty($validated['system_requirements'])
            ? array_values(array_filter(array_map('trim', explode("\n", $validated['system_requirements']))))
            : [];

        $filePath = null;
        $fileName = null;
        $fileSize = null;

        if ($request->hasFile('software_file')) {
            $uploaded = $request->file('software_file');
            $fileName = $uploaded->getClientOriginalName();
            $fileSize = round($uploaded->getSize() / 1024 / 1024, 2).' MB';
            $filePath = $uploaded->storeAs('digital_products', $slug.'_'.time().'.'.$uploaded->getClientOriginalExtension(), 'local');
        }

        $product = DigitalProduct::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $slug,
            'tagline' => $validated['tagline'] ?? null,
            'description' => $validated['description'],
            'features' => $features,
            'system_requirements' => $systemRequirements,
            'price' => $validated['price'],
            'sale_price' => $validated['sale_price'] ?? null,
            'currency' => $validated['currency'],
            'version' => $validated['version'],
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_size' => $fileSize,
            'has_license_key' => $request->boolean('has_license_key', true),
            'is_featured' => $request->boolean('is_featured', false),
            'status' => $validated['status'],
        ]);

        // Automatically create high-converting landing page if checked
        if ($request->boolean('create_landing_page', true)) {
            ProductLandingPage::create([
                'product_id' => $product->id,
                'slug' => $slug,
                'headline' => $validated['landing_headline'] ?: $product->name,
                'subheadline' => $validated['landing_subheadline'] ?: $product->tagline,
                'hero_badge' => '🔥 عرض خاص لفترة محدودة: تفعيل فوري مع ترخيص رسمي',
                'timer_ends_at' => now()->addDays(2),
                'key_benefits' => [
                    ['title' => 'توفير الوقت والجهد', 'desc' => 'نظام آلي بالكامل يقلل الأخطاء ويسرع إنجاز مهامك.'],
                    ['title' => 'ترخيص دائم بدون قيود', 'desc' => 'تفعيل مدى الحياة بدون أي اشتراكات دورية إجبارية.'],
                    ['title' => 'أمان وتشفير كامل', 'desc' => 'حماية بياناتك وحساباتك بأعلى معايير التشفير.'],
                    ['title' => 'دعم فني وتحديثات مستمرة', 'desc' => 'فريق متخصص لمساعدتك في التثبيت وحل أي استفسار.'],
                ],
                'social_proof_stats' => [
                    ['label' => 'مستخدم نشط', 'value' => '+1,200'],
                    ['label' => 'نسبة رضا العملاء', 'value' => '99%'],
                    ['label' => 'استقرار وأداء', 'value' => '100%'],
                    ['label' => 'دعم فني', 'value' => '24/7'],
                ],
                'faq_items' => [
                    ['question' => 'كيف أستلم البرنامج ومفتاح الترخيص؟', 'answer' => 'فور إتمام الدفع ستنتقل لصفحة التحميل المباشر وسيصلك إيميل فوري يحتوي على مفتاح الترخيص وبياناتك.'],
                    ['question' => 'هل توجد مصاريف تجديد؟', 'answer' => 'لا، هذا العرض يمنحك ترخيصاً دائماً بدون أي اشتراك شهري.'],
                ],
                'guarantee_text' => 'نضمن لك استرجاع المبلغ بالكامل خلال 14 يوماً في حال عدم ملاءمة البرنامج لعملك.',
                'cta_text' => 'اشترِ الآن واحصل على التفعيل الفوري',
                'is_published' => true,
            ]);
        }

        return redirect()->route('admin.digital-products.index')->with('success', 'تم إضافة المنتج الرقمي وتجهيز صفحة الهبوط بنجاح.');
    }

    /**
     * Show the form for editing the product.
     */
    public function edit(DigitalProduct $digitalProduct): View
    {
        $digitalProduct->load(['category', 'landingPage']);
        $categories = ProductCategory::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.digital-products.edit', compact('digitalProduct', 'categories'));
    }

    /**
     * Update the product in storage.
     */
    public function update(Request $request, DigitalProduct $digitalProduct): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:191',
            'slug' => 'required|string|max:191|unique:digital_products,slug,'.$digitalProduct->id,
            'tagline' => 'nullable|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'currency' => 'required|string|max:3',
            'version' => 'required|string|max:20',
            'features' => 'nullable|string',
            'system_requirements' => 'nullable|string',
            'software_file' => 'nullable|file|max:102400',
            'has_license_key' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:active,draft,archived',
        ]);

        $features = ! empty($validated['features'])
            ? array_values(array_filter(array_map('trim', explode("\n", $validated['features']))))
            : $digitalProduct->features;

        $systemRequirements = ! empty($validated['system_requirements'])
            ? array_values(array_filter(array_map('trim', explode("\n", $validated['system_requirements']))))
            : $digitalProduct->system_requirements;

        $updateData = [
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['slug']),
            'tagline' => $validated['tagline'] ?? null,
            'description' => $validated['description'],
            'features' => $features,
            'system_requirements' => $systemRequirements,
            'price' => $validated['price'],
            'sale_price' => $validated['sale_price'] ?? null,
            'currency' => $validated['currency'],
            'version' => $validated['version'],
            'has_license_key' => $request->boolean('has_license_key', true),
            'is_featured' => $request->boolean('is_featured', false),
            'status' => $validated['status'],
        ];

        if ($request->hasFile('software_file')) {
            $uploaded = $request->file('software_file');
            $fileName = $uploaded->getClientOriginalName();
            $fileSize = round($uploaded->getSize() / 1024 / 1024, 2).' MB';
            $filePath = $uploaded->storeAs('digital_products', $digitalProduct->slug.'_'.time().'.'.$uploaded->getClientOriginalExtension(), 'local');

            $updateData['file_path'] = $filePath;
            $updateData['file_name'] = $fileName;
            $updateData['file_size'] = $fileSize;
        }

        $digitalProduct->update($updateData);

        return redirect()->route('admin.digital-products.index')->with('success', 'تم تحديث بيانات البرنامج بنجاح.');
    }

    /**
     * Remove the product from storage.
     */
    public function destroy(DigitalProduct $digitalProduct): RedirectResponse
    {
        if ($digitalProduct->file_path && Storage::disk('local')->exists($digitalProduct->file_path)) {
            Storage::disk('local')->delete($digitalProduct->file_path);
        }

        $digitalProduct->delete();

        return redirect()->route('admin.digital-products.index')->with('success', 'تم حذف المنتج الرقمي بنجاح.');
    }
}
