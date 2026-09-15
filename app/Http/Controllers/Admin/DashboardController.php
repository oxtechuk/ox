<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Testimonial;
use App\Models\Consultation;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_projects' => Project::count(),
            'featured_projects' => Project::where('is_featured', true)->count(),
            'total_testimonials' => Testimonial::count(),
            'active_testimonials' => Testimonial::where('is_active', true)->count(),
            'new_consultations' => Consultation::where('status', 'new')->count(),
            'total_consultations' => Consultation::count(),
            'total_users' => User::count(),
        ];

        $recentConsultations = Consultation::orderBy('id', 'desc')->take(6)->get();
        $recentProjects = Project::orderBy('order', 'asc')->orderBy('id', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentConsultations', 'recentProjects'));
    }
}
