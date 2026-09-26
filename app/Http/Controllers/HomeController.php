<?php

namespace App\Http\Controllers;

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

        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('order')
            ->get();

        $siteContents = SiteContent::all()->pluck('value', 'key')->toArray();

        // Extract unique countries and sectors for filters
        $countries = Project::select('country_code', 'country_name')
            ->distinct()
            ->whereNotNull('country_code')
            ->get();

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
            'sectors'
        ));
    }
}
