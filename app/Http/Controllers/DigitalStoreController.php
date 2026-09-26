<?php

namespace App\Http\Controllers;

use App\Models\DigitalProduct;
use App\Models\ProductCategory;
use App\Models\ProductLandingPage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DigitalStoreController extends Controller
{
    /**
     * Show digital products store with category filters and search
     */
    public function index(Request $request): View
    {
        $categories = ProductCategory::where('is_active', true)
            ->withCount(['digitalProducts' => function ($query) {
                $query->where('status', 'active');
            }])
            ->orderBy('sort_order')
            ->get();

        $selectedCategorySlug = $request->query('category');
        $search = $request->query('search');
        $sort = $request->query('sort', 'latest');

        $query = DigitalProduct::query()
            ->with('category')
            ->where('status', 'active');

        if ($selectedCategorySlug) {
            $query->whereHas('category', function ($q) use ($selectedCategorySlug) {
                $q->where('slug', $selectedCategorySlug);
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('tagline', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'featured':
                $query->orderByDesc('is_featured')->latest();
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        $featuredProducts = DigitalProduct::query()
            ->with('category')
            ->where('status', 'active')
            ->where('is_featured', true)
            ->take(3)
            ->get();

        return view('store.index', compact('categories', 'products', 'featuredProducts', 'selectedCategorySlug', 'search', 'sort'));
    }

    /**
     * Show single product details page
     */
    public function show(string $slug): View
    {
        $product = DigitalProduct::with(['category', 'landingPage'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $relatedProducts = DigitalProduct::where('status', 'active')
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->take(3)
            ->get();

        return view('store.show', compact('product', 'relatedProducts'));
    }

    /**
     * Show dedicated high-conversion sales landing page for advertising
     */
    public function landing(string $slug): View
    {
        $landingPage = ProductLandingPage::with(['product.category'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->first();

        if (! $landingPage) {
            // Fallback: check if slug matches product slug
            $product = DigitalProduct::with(['landingPage', 'category'])
                ->where('slug', $slug)
                ->where('status', 'active')
                ->firstOrFail();

            $landingPage = $product->landingPage;

            if (! $landingPage || ! $landingPage->is_published) {
                return redirect()->route('store.product', $product->slug);
            }
        }

        $product = $landingPage->product;

        return view('landing.sales', compact('landingPage', 'product'));
    }
}
