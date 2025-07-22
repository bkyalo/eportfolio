<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ContactSubmission;
use App\Models\FunFact;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Get all projects for the stats
        $projects = Project::latest()->get();
        
        // Get recent projects for the recent projects section
        $recentProjects = Project::latest()
            ->take(5)
            ->get();
            
        // Get recent contact form submissions and unread count
        $recentSubmissions = ContactSubmission::latest()
            ->take(5)
            ->get();
            
        $unreadCount = ContactSubmission::where('is_read', false)->count();
        
        // Get fun facts
        $funFacts = FunFact::latest()->get();
        
        return view('dashboard', [
            'projects' => $projects, // Changed from projectsCount to projects
            'recentProjects' => $recentProjects,
            'recentSubmissions' => $recentSubmissions,
            'unreadCount' => $unreadCount,
            'funFacts' => $funFacts,
        ]);
    }
}
