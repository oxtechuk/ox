<?php

namespace App\Http\Controllers;

use App\Models\DigitalProduct;
use App\Models\ProductCategory;
use App\Models\Project;
use App\Models\SiteContent;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $projects = Cache::remember('home_projects', 3600, function () {
            $featured = Project::where('is_featured', true)
                ->orderBy('order', 'asc')
                ->orderBy('id', 'desc')
                ->get();

            if ($featured->isEmpty()) {
                return Project::orderBy('order', 'asc')->orderBy('id', 'desc')->get();
            }

            return $featured;
        });

        $testimonials = Cache::remember('home_testimonials', 3600, function () {
            try {
                Testimonial::where('partner_name', 'like', '%موسي%')
                    ->orWhere('partner_name', 'like', '%هامش%')
                    ->where('order', '!=', 1)
                    ->update(['order' => 1, 'number_badge' => '01']);
            } catch (\Throwable $e) {
                // fail-safe if DB connection isn't available
            }

            $items = Testimonial::where('is_active', true)
                ->orderByRaw("CASE WHEN partner_name LIKE '%موسي%' OR partner_name LIKE '%هامش%' THEN 0 ELSE 1 END")
                ->orderBy('order', 'asc')
                ->get()
                ->values();

            $items->each(function ($t, $index) {
                $t->number_badge = sprintf('%02d', $index + 1);
            });

            return $items;
        });

        $siteContents = SiteContent::cachedDict();
        $siteSettings = SiteSetting::cachedDict();

        // Digital Products & Categories cached
        $digitalProducts = Cache::remember('home_digital_products', 3600, function () {
            return DigitalProduct::where('status', 'active')
                ->with('category')
                ->orderByDesc('is_featured')
                ->orderBy('id', 'asc')
                ->get();
        });

        $productCategories = Cache::remember('home_product_categories', 3600, function () {
            return ProductCategory::where('is_active', true)
                ->withCount(['digitalProducts' => function ($q) {
                    $q->where('status', 'active');
                }])
                ->orderBy('sort_order', 'asc')
                ->get();
        });

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

        // Standard Arabic / English name dictionary for popular countries
        $countryDictionary = [
            'jo' => ['name' => 'الأردن', 'name_en' => 'Jordan'],
            'eg' => ['name' => 'مصر', 'name_en' => 'Egypt'],
            'sa' => ['name' => 'السعودية', 'name_en' => 'Saudi Arabia'],
            'ae' => ['name' => 'الإمارات', 'name_en' => 'UAE'],
            'kw' => ['name' => 'الكويت', 'name_en' => 'Kuwait'],
            'iq' => ['name' => 'العراق', 'name_en' => 'Iraq'],
            'ma' => ['name' => 'المغرب', 'name_en' => 'Morocco'],
            'ps' => ['name' => 'فلسطين', 'name_en' => 'Palestine'],
            'lb' => ['name' => 'لبنان', 'name_en' => 'Lebanon'],
            'sy' => ['name' => 'سوريا', 'name_en' => 'Syria'],
            'qa' => ['name' => 'قطر', 'name_en' => 'Qatar'],
            'bh' => ['name' => 'البحرين', 'name_en' => 'Bahrain'],
            'om' => ['name' => 'عمان', 'name_en' => 'Oman'],
            'dz' => ['name' => 'الجزائر', 'name_en' => 'Algeria'],
            'tn' => ['name' => 'تونس', 'name_en' => 'Tunisia'],
            'ly' => ['name' => 'ليبيا', 'name_en' => 'Libya'],
            'sd' => ['name' => 'السودان', 'name_en' => 'Sudan'],
            'ye' => ['name' => 'اليمن', 'name_en' => 'Yemen'],
            'de' => ['name' => 'ألمانيا', 'name_en' => 'Germany'],
            'se' => ['name' => 'السويد', 'name_en' => 'Sweden'],
            'gb' => ['name' => 'بريطانيا', 'name_en' => 'United Kingdom'],
            'us' => ['name' => 'أمريكا', 'name_en' => 'United States'],
        ];

        $countriesData = Cache::remember('home_countries_data', 3600, function () use ($countryDictionary) {
            $dbCountries = Project::select('country_code', 'country_name', 'country_name_en')
                ->distinct()
                ->whereNotNull('country_code')
                ->get();

            $stripOrder = ['jo', 'eg', 'sa', 'lb', 'ps', 'ae', 'sy', 'kw', 'iq', 'ma'];

            $display = collect($stripOrder)->map(function ($code) use ($dbCountries, $countryDictionary) {
                $dbItem = $dbCountries->first(fn ($d) => strtolower($d->country_code) === $code);
                $dictItem = $countryDictionary[$code] ?? null;
                $name = $dbItem?->country_name ?? $dictItem['name'] ?? strtoupper($code);
                $nameEn = $dbItem?->country_name_en ?? $dictItem['name_en'] ?? strtoupper($code);
                $flagFile = "assets/flags/{$code}.webp";
                $flagUrl = file_exists(public_path($flagFile)) ? asset($flagFile) : null;

                return (object) [
                    'country_code' => $code,
                    'country_name' => $name,
                    'country_name_en' => $nameEn,
                    'flag_url' => $flagUrl,
                ];
            });

            $otherCodes = collect(array_keys($countryDictionary))
                ->merge($dbCountries->pluck('country_code')->map(fn ($c) => strtolower($c)))
                ->unique()
                ->filter(fn ($code) => ! in_array($code, $stripOrder))
                ->values();

            $other = $otherCodes->map(function ($code) use ($dbCountries, $countryDictionary) {
                $dbItem = $dbCountries->first(fn ($d) => strtolower($d->country_code) === $code);
                $dictItem = $countryDictionary[$code] ?? null;
                $name = $dbItem?->country_name ?? $dictItem['name'] ?? strtoupper($code);
                $nameEn = $dbItem?->country_name_en ?? $dictItem['name_en'] ?? strtoupper($code);
                $flagFile = "assets/flags/{$code}.webp";
                $flagUrl = file_exists(public_path($flagFile)) ? asset($flagFile) : null;

                return (object) [
                    'country_code' => $code,
                    'country_name' => $name,
                    'country_name_en' => $nameEn,
                    'flag_url' => $flagUrl,
                ];
            });

            return [
                'display' => $display,
                'other' => $other,
            ];
        });

        $displayCountries = $countriesData['display'];
        $otherCountries = $countriesData['other'];
        $countries = $displayCountries;

        $sectors = Cache::remember('home_sectors', 3600, function () use ($projects) {
            $featuredSectorSlugs = $projects->pluck('sector_slug')->unique()->filter()->values();

            return ($featuredSectorSlugs->isNotEmpty()
                ? Project::whereIn('sector_slug', $featuredSectorSlugs)
                : Project::query())
                ->select('sector_slug', 'sector_name')
                ->distinct()
                ->whereNotNull('sector_slug')
                ->get()
                ->unique('sector_slug')
                ->values();
        });

        $storiesJson = Cache::remember('home_stories_json', 3600, function () use ($testimonials) {
            return json_encode($testimonials->map(function ($t) {
                return [
                    $t->quote,
                    $t->partner_name,
                    $t->partner_role.($t->partner_country ? ' · '.$t->partner_country : ''),
                    $t->video_src,
                    $t->video_type,
                ];
            })->toArray(), JSON_UNESCAPED_UNICODE);
        });

        return view('landing.index', compact(
            'projects',
            'testimonials',
            'storiesJson',
            'siteContents',
            'siteSettings',
            'countries',
            'displayCountries',
            'otherCountries',
            'sectors',
            'digitalProducts',
            'productCategories'
        ));
    }
}
