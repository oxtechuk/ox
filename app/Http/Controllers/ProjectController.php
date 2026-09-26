<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\SiteContent;

class ProjectController extends Controller
{
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
