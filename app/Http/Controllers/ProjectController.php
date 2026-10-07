<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\SiteContent;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
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

        $query = Project::query();

        if ($request->filled('sector')) {
            $query->where('sector_slug', $request->input('sector'));
        }

        if ($request->filled('country')) {
            $query->where('country_code', $request->input('country'));
        }

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('client_name', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%");
            });
        }

        $projects = $query->orderByDesc('is_featured')
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        $allProjectsCount = Project::count();

        $sectors = Project::select('sector_slug', 'sector_name')
            ->distinct()
            ->whereNotNull('sector_slug')
            ->get()
            ->unique('sector_slug')
            ->values();

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

        // 1. Existing countries from DB
        $dbCountries = Project::select('country_code', 'country_name', 'country_name_en')
            ->distinct()
            ->whereNotNull('country_code')
            ->get();

        // Primary strip order matching client reference image + active DB countries
        $stripOrder = ['jo', 'eg', 'sa', 'lb', 'ps', 'ae', 'sy', 'kw', 'iq', 'ma'];
        foreach ($dbCountries as $dbc) {
            $c = strtolower($dbc->country_code);
            if (! in_array($c, $stripOrder)) {
                $stripOrder[] = $c;
            }
        }

        $displayCountries = collect($stripOrder)->map(function ($code) use ($dbCountries, $countryDictionary) {
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

        // Other countries for the other countries dropdown
        $otherCountries = collect($countryDictionary)
            ->filter(fn ($info, $code) => ! in_array($code, $stripOrder))
            ->map(function ($info, $code) {
                $flagFile = "assets/flags/{$code}.webp";
                $flagUrl = file_exists(public_path($flagFile)) ? asset($flagFile) : null;

                return (object) [
                    'country_code' => $code,
                    'country_name' => $info['name'],
                    'country_name_en' => $info['name_en'],
                    'flag_url' => $flagUrl,
                ];
            })->values();

        $countries = $displayCountries;

        $siteContents = SiteContent::all()->pluck('value', 'key')->toArray();

        return view('projects.index', compact(
            'projects',
            'sectors',
            'countries',
            'displayCountries',
            'otherCountries',
            'siteContents',
            'allProjectsCount'
        ));
    }

    public function show(string $slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();

        // Get related or other projects for next/prev navigation
        $otherProjects = Project::where('id', '!=', $project->id)
            ->where('is_featured', true)
            ->inRandomOrder()
            ->take(3)
            ->get();

        $nextProject = Project::where('id', '>', $project->id)
            ->orderBy('id', 'asc')
            ->first() ?? Project::orderBy('id', 'asc')->first();

        $prevProject = Project::where('id', '<', $project->id)
            ->orderBy('id', 'desc')
            ->first() ?? Project::orderBy('id', 'desc')->first();

        $siteContents = SiteContent::all()->pluck('value', 'key')->toArray();

        return view('projects.show', compact('project', 'otherProjects', 'nextProject', 'prevProject', 'siteContents'));
    }
}
