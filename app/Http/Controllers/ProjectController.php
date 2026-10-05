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

        $projects = $query->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        $allProjectsCount = Project::count();

        $sectors = Project::select('sector_slug', 'sector_name')
            ->distinct()
            ->whereNotNull('sector_slug')
            ->get()
            ->unique('sector_slug')
            ->values();

        $countries = Project::select('country_code', 'country_name')
            ->distinct()
            ->whereNotNull('country_code')
            ->get()
            ->map(function ($c) use ($flagEmojis) {
                $code = strtolower($c->country_code);
                if ($code === 'uk') {
                    $code = 'gb';
                }
                $c->flag = $flagEmojis[$code] ?? '🌐';
                $flagFile = "assets/flags/{$code}.webp";
                $c->flag_url = file_exists(public_path($flagFile)) ? asset($flagFile) : null;

                return $c;
            });

        $siteContents = SiteContent::all()->pluck('value', 'key')->toArray();

        return view('projects.index', compact(
            'projects',
            'sectors',
            'countries',
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
