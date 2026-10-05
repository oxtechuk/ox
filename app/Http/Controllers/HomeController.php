<?php

namespace App\Http\Controllers;

use App\Models\DigitalProduct;
use App\Models\ProductCategory;
use App\Models\Project;
use App\Models\SiteContent;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $projects = Project::where('is_featured', true)
            ->orderBy('order')
            ->orderBy('id', 'desc')
            ->get();

        if ($projects->isEmpty()) {
            $projects = Project::orderBy('order')->orderBy('id', 'desc')->get();
        }

        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('order')
            ->get();

        $siteContents = SiteContent::all()->pluck('value', 'key')->toArray();

        // Digital Products & Categories
        $digitalProducts = DigitalProduct::where('status', 'active')
            ->with('category')
            ->orderByDesc('is_featured')
            ->orderBy('id', 'asc')
            ->get();

        $productCategories = ProductCategory::where('is_active', true)
            ->withCount(['digitalProducts' => function ($q) {
                $q->where('status', 'active');
            }])
            ->orderBy('sort_order', 'asc')
            ->get();

        // Country flags mapping
        $flagEmojis = [
            'sa' => '🇸🇦',
            'ae' => '🇦🇪',
            'eg' => '🇪🇬',
            'kw' => '🇰🇼',
            'qa' => '🇶🇦',
            'om' => '🇴🇲',
            'bh' => '🇧🇭',
            'jo' => '🇯🇴',
            'de' => '🇩🇪',
            'se' => '🇸🇪',
            'gb' => '🇬🇧',
            'uk' => '🇬🇧',
            'us' => '🇺🇸',
            'ru' => '🇷🇺',
            'iq' => '🇮🇶',
            'fr' => '🇫🇷',
        ];

        // Extract unique countries with flags and sectors for filters
        $countries = Project::select('country_code', 'country_name')
            ->distinct()
            ->whereNotNull('country_code')
            ->get()
            ->map(function ($c) use ($flagEmojis) {
                $code = strtolower($c->country_code);
                $c->flag = $flagEmojis[$code] ?? '🌐';

                return $c;
            });

        $sectors = Project::select('sector_slug', 'sector_name')
            ->distinct()
            ->whereNotNull('sector_slug')
            ->get();

        $storiesJson = json_encode($testimonials->map(function ($t) {
            return [
                $t->quote,
                $t->partner_name,
                $t->partner_role.($t->partner_country ? ' · '.$t->partner_country : ''),
                $t->video_src,
                $t->video_type,
            ];
        })->toArray(), JSON_UNESCAPED_UNICODE);

        return view('landing.index', compact(
            'projects',
            'testimonials',
            'storiesJson',
            'siteContents',
            'countries',
            'sectors',
            'digitalProducts',
            'productCategories'
        ));
    }
}
